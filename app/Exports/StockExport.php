<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\PurchasedItems;
use App\Models\SelledItems;
use App\Models\SelledPackageItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class StockExport implements FromCollection, WithHeadings, WithTitle, WithCustomStartCell, WithEvents
{

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function headings(): array
    {
        $formattedStartDate = Carbon::parse($this->startDate)->translatedFormat('d F Y');
        $formattedEndDate = Carbon::parse($this->endDate)->translatedFormat('d F Y');

        return [
            ['STOCK BARANG NEW BALI HEPPI'], // Title row
            ['Tanggal', '', $formattedStartDate, '-', $formattedEndDate],
            [],                             // Empty row for spacing
            ['No', 'Nama Barang', 'Masuk', 'Keluar', 'Sisa'], // Table headers
        ];
    }

    /**
     * Define where the data starts in the sheet.
     */
    public function startCell(): string
    {
        return 'A1';
    }

    /**
     * Listen for the AfterSheet event to apply styling.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Style Title Row (A1)
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'italic' => true,
                        'size' => 16,
                        'color' => ['rgb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Merge title row
                $sheet->mergeCells('A1:E1'); 

                // Date Row
                $sheet->mergeCells('A2:B2');
                // Style Table Header Row (A4:E4)
                $sheet->getStyle('A4:E4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'color' => ['rgb' => '00000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Auto-size columns
                foreach (range('B', 'E') as $col) {
                    $sheet->getColumnDimension($col)->setWidth(20);                
                }

                $sheet->getColumnDimension('A')->setWidth(5); 

                $sheet->getDefaultRowDimension()->setRowHeight(20); // Default height = 20

                $sheet->getStyle($sheet->calculateWorksheetDimension())
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A1:' . 'A' . $sheet->getHighestRow() ) // Adjusts for all rows in column A
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                

                // Dynamic starting cell of the table (adjust if needed)
                $startRow = 4; // Assuming the table starts at row 4
                $startColumn = 'A';

                // Get dynamic row count based on collection
                $dataCount = $this->collection()->count(); // Rows of data
                $headerRowCount = 1;                      // Number of header rows
                $totalRows = $startRow + $headerRowCount + $dataCount - 1;

                // Determine the last column dynamically
                $endColumn = 'E'; // Fixed, if headers are from A to E (adjust dynamically if needed)

                // Dynamically build the range
                $tableRange = "{$startColumn}{$startRow}:{$endColumn}{$totalRows}";

                // Apply border styling dynamically
                $sheet->getStyle($tableRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN, // Thin border
                            'color' => ['rgb' => '000000'],      // Black border
                        ],
                    ],
                ]);      

                // Merge category cells dynamically
                $currentRow = 5; // Start after the table header
                $categories = Category::with('product')->get();

                foreach ($categories as $category) {
                    $startRow = $currentRow;
                    $productCount = $category->product->count();

                    // Skip merging if no products exist
                    if ($productCount > 0) {
                        $currentRow += $productCount;
                    }

                    // Merge the cells for the category row
                    $sheet->mergeCells("B{$startRow}:E{$startRow}");
                    $sheet->getStyle("B{$startRow}")->applyFromArray([
                        'font' => ['bold' => true],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ]);

                    $currentRow++; // Move to the next category start
                }
            },
        ];
    }


    public function title(): string
    {
        return 'Stock Report';
    }

    /**
     * Generate the data for export
     */
    public function collection()
    {
        $data = [];
        $counter = 1;

        // Retrieve categories with related products
        $categories = Category::with('product')->get();

        foreach ($categories as $category) {
            // Add category header
            $data[] = [$counter++, strtoupper($category->name), '', '', ''];

            foreach ($category->product as $product) {
                // Calculate incoming (MASUK) stock
                $masuk = PurchasedItems::whereHas('purchase', function ($query) {
                    $query->whereBetween('purchase_date', [$this->startDate, $this->endDate]);
                })->where('product_id', $product->id)->sum('quantity');
            
                // Calculate outgoing (KELUAR) stock
                $keluar = SelledItems::whereHas('sale', function ($query) {
                    $query->whereRaw('DATE(check_in) BETWEEN ? AND ?', [
                        $this->startDate,
                        $this->endDate
                    ]);
                })->where('product_id', $product->id)->sum('quantity');
            
                // Calculate outgoing (KELUAR) stock from packages
                
                $paketKeluar = SelledPackageItem::whereHas('selledItem.sale', function ($query) {
                    $query->whereRaw('DATE(check_in) BETWEEN ? AND ?', [
                        $this->startDate,
                        $this->endDate
                    ]);
                })->where('product_id', $product->id)->sum('quantity');

                // Calculate remaining stock (SISA)
                $totalKeluar = $keluar + $paketKeluar;
                $sisa = $masuk - $totalKeluar;
            
                // Append product data
                $data[] = ['', $product->name, $masuk, $totalKeluar, $sisa];
            }
        }

        return collect($data);
    }
}
