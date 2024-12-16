<?php

namespace App\Http\Controllers;

use App\Exports\SaleExport;
use App\Mail\SelledInvoice;
use App\Models\Customer;
use App\Models\Location;
use App\Models\LocationType;
use App\Models\PackageDetail;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SelledItems;
use App\Models\SelledPackageItem;
use App\Models\SelledPackageTalent;
use App\Models\SelledTalent;
use App\Models\Talent;
use App\Models\User;
use App\Models\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Konekt\PdfInvoice\InvoicePrinter;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->getCreatedBy();
        $tempInvoice = Sale::pluck('invoice_id')->max();
        $tempInvoice = Auth::user()->sellInvoiceNumberFormat($tempInvoice + 1);

        if ($request->location_id){
            $accessSale = $this->reserveLocation($request);
            $location = Location::where('id', $request->location_id)->first();
 
            if($accessSale['status'] == 'success'){
                return view('sales.index', compact('location','tempInvoice'));
            } else {
                return redirect('/')->with('error', $accessSale['message']);
            }
        }
        if (Auth::user()->can('Manage Sales')) {        
            return view('sales.index', compact('tempInvoice'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create(Request $request)
    {
        $sess = session()->get('sales');

        if (Auth::user()->can('Manage Sales') && isset($sess) && !empty($sess) && count($sess) > 0) {
            $user = Auth::user();

            $settings = Utility::settings();

            $customer = Customer::where('name', '=', $request->vc_name)->where('created_by', $user->getCreatedBy())->first();

            $details = [
                'invoice_id' => $user->sellInvoiceNumberFormat($this->invoiceSellNumber()),
                'customer' => $customer != null ? $customer->toArray() : [],
                'user' => $user != null ? $user->toArray() : [],
                'date' => date('Y-m-d'),
                'pay' => 'show',
            ];

            if (!empty($details['customer'])) {
                $details['customer']['state'] = $details['customer']['state'] != '' ? ", " . $details['customer']['state'] : '';

                $customerdetails = '<h2 class="h6 font-weight-normal"><b>' . ucfirst($details['customer']['name']) . '</b>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['phone_number'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['address'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['city'] . $details['customer']['state'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['country'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['zipcode'] . '</p></h2>';
            } else {
                $customerdetails = '<h2 class="h6"><b>' . __('Walk-in Customer') . '</b><h2>';
            }

            $settings['company_telephone'] = $settings['company_telephone'] != '' ? ", " . $settings['company_telephone'] : '';
            $settings['company_state']     = $settings['company_state'] != '' ? ", " . $settings['company_state'] : '';

            $userdetails = '<h2 class="h6"><b>' . ucfirst($details['user']['name']) . ' </b> <h2  class="h6 font-weight-normal">' . '<p class="m-0 h6 font-weight-normal">' . $settings['company_name'] . $settings['company_telephone'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $settings['company_address'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $settings['company_city'] . $settings['company_state'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $settings['company_country'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $settings['company_zipcode'] . '</p></h2>';

            $details['customer']['details'] = $customerdetails;

            $details['user']['details'] = $userdetails;

            $mainsubtotal = 0;
            $sales        = [];

            foreach ($sess as $key => $value) {
                $subtotal = $value['price'] * $value['quantity'];
                $tax      = ($subtotal * $value['tax']) / 100;

                $sales['data'][$key]['name']       = $value['name'];
                $sales['data'][$key]['quantity']   = $value['quantity'];
                $sales['data'][$key]['price']      = Auth::user()->priceFormat($value['price']);
                $sales['data'][$key]['tax']        = $value['tax'] . '%';
                $sales['data'][$key]['tax_amount'] = Auth::user()->priceFormat($tax);
                $sales['data'][$key]['subtotal']   = Auth::user()->priceFormat($value['subtotal']);
                $mainsubtotal                      += $value['subtotal'];
            }
            $sales['total'] = Auth::user()->priceFormat($mainsubtotal);


            return view('sales.show', compact('sales', 'details'));
        } else {
            return response()->json(
                [
                    'error' => __('Add some products to cart!'),
                ],
                '404'
            );
        }
    }

    public function store(Request $request)
    {
        // return $request;
        if (Auth::user()->can('Manage Sales')) {
            $user_id = Auth::user()->getCreatedBy();
        
            DB::beginTransaction();
                $location = Location::where('id', $request->location_id)->first();
                
                //TODO ADD LOCATION STATUS CHECKING

                $location->status = 'booked';
                $location->save();
                
                $sale = new Sale();
        
                $sale->location_id = $request->location_id;
                $sale->check_in = Carbon::now();
                $sale->invoice_id = $this->invoiceSellNumber();
                $sale->total = 0;
                $sale->tax = 0;
                $sale->save();
        
                if ($request->sale_type == 'paket') {
                    $package = Product::with('unit')->where('id', $request->package_id)->first();
        
                    $selledItem = new SelledItems();
                    $selledItem->sell_id = $sale->id;
                    $selledItem->product_id = $request->package_id;
                    $selledItem->price = $package->sale_price;
                    $selledItem->quantity = 1;
                    $selledItem->purchase_price = $package->purchase_price;
                    $selledItem->unit = $package->unit->name;
                    $selledItem->save();
        
                    $packageDetail = PackageDetail::where('product_id', $request->package_id)->first();
                    // return $packageDetail;
                    foreach ($packageDetail->fixed_products as $fixedProduct) {
                        $product = Product::with('unit')->where('id', $fixedProduct->productId)->first();
                        
                        //STOCK CHECKING HERE
                        if($product->is_stock == 1){
                            if (!$product->hasSufficientStock($fixedProduct->quantity)) {
                                return response()->json([
                                    'status' => 400,
                                    'message' => __('Insufficient stock for product: ') . $product->name,
                                ]);
                            }
                        }
                       
                        $selledPackageItem = new SelledPackageItem();
                        $selledPackageItem->selled_item_id = $selledItem->id;
                        $selledPackageItem->product_id = $fixedProduct->productId;
                        $selledPackageItem->price = $product->sale_price;
                        $selledPackageItem->purchase_price = $product->purchase_price;
                        $selledPackageItem->quantity = $fixedProduct->quantity;
                        $selledPackageItem->unit = $product->unit->name;
                        $selledPackageItem->save();
                    }
        
                    foreach ($request->optional_products as $optionalProduct) {
                        foreach ($optionalProduct['selected'] as $selectedProduct) {
                            $product = Product::with('unit')->where('id', $selectedProduct['product_id'])->first();
                            
                            //ADD STOCK CHECKING HERE
                            if($product->is_stock == 1){
                                if (!$product->hasSufficientStock($selectedProduct['qty'])) {
                                    return response()->json([
                                        'status' => 400,
                                        'message' => __('Insufficient stock for product: ') . $product->name,
                                    ]);
                                }
                            }

                            $selledPackageItem = new SelledPackageItem();
                            $selledPackageItem->selled_item_id = $selledItem->id;
                            $selledPackageItem->product_id = $selectedProduct['product_id'];
                            $selledPackageItem->price = $product->sale_price;
                            $selledPackageItem->purchase_price = $product->purchase_price;
                            $selledPackageItem->quantity = $selectedProduct['qty'];
                            $selledPackageItem->unit = $product->unit->name;
        
                            $selledPackageItem->save();
                        }
                    }
        
                    foreach ($request->optional_talents as $optionalTalent) {
                        $talent = Talent::with('talentGradeDetail')->where('id', $optionalTalent)->first();
                        
                        //TODO ADD TALENT STATUS CHECKING

                        $talent->status = 'booked';
                        $talent->save();
                        
                        $selledPackageTalent = new SelledPackageTalent();
                        $selledPackageTalent->selled_item_id = $selledItem->id;
                        $selledPackageTalent->talent_id = $talent->id;
                        $selledPackageTalent->hour = $packageDetail->duration;
                        $selledPackageTalent->talent_price = $talent->talentGradeDetail->talent_price;
                        $selledPackageTalent->agency_price = $talent->talentGradeDetail->agency_price;
                        $selledPackageTalent->office_price = $talent->talentGradeDetail->office_price;
                        $selledPackageTalent->save();
                        
                    }
                    $sale->type = 'paket';
                    $sale->total = $selledItem->price;
                    $sale->tax = $sale->total * 0.11;
                    $sale->save();

                } else {
                    if($request->selled_talents){
                        foreach ($request->selled_talents as $selledTalent) {
                            $talent = Talent::with('talentGradeDetail')->where('id', $selledTalent['talentId'])->first();
                            
                            //TODO ADD TALENT STATUS CHECKING
    
                            $talent->status = 'booked';
                            $talent->save();
                            
                            $bookedTalent = new SelledTalent();
                            $bookedTalent->sell_id = $sale->id;
                            $bookedTalent->talent_id = $talent->id;
                            $bookedTalent->hour = $selledTalent['quantity'];
                            $bookedTalent->talent_price = $talent->talentGradeDetail->talent_price;
                            $bookedTalent->agency_price = $talent->talentGradeDetail->agency_price;
                            $bookedTalent->office_price = $talent->talentGradeDetail->office_price;
                            $bookedTalent->save();
                            
                            $sale->total += ($bookedTalent->talent_price +  $bookedTalent->agency_price + $bookedTalent->office_price) * $bookedTalent->hour;
                        }
                    }

                    if($request->selled_items){
                        foreach ($request->selled_items as $selledItem) {
                            $product = Product::with('unit')->where('id', $selledItem['productId'])->first();
                            //ADD STOCK CHECKING HERE
                            if($product->is_stock == 1){
                                if (!$product->hasSufficientStock($selledItem['quantity'])) {
                                    return response()->json([
                                        'status' => 400,
                                        'message' => __('Insufficient stock for product: ') . $product->name,
                                    ]);
                                }
                            }
                            $bookedItem = new SelledItems();
                            $bookedItem->sell_id = $sale->id;
                            $bookedItem->product_id =  $selledItem['productId'];
                            $bookedItem->price = $product->sale_price;
                            $bookedItem->purchase_price = $product->purchase_price;
                            $bookedItem->quantity = $selledItem['quantity'];
                            $bookedItem->unit = $product->unit->name;
                            $bookedItem->save();
    
                            $sale->total += $bookedItem->price *  $bookedItem->quantity;
    
                        }
                    }

                    $sale->type = 'regular';
                    $sale->tax = $sale->total * 0.11;
                    $sale->save();
                }
            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => __('Reservation saved successfully!'),
            ]);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    function invoiceSellNumber()
    {
        if (Auth::user()->can('Manage Purchases')) {
            $latest = Sale::latest()->first();

            return $latest ? $latest->invoice_id + 1 : 1;
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Sale $sale)
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit(Sale $sale)
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function update(Request $request, Sale $sale)
    {
        try {
            // Start the transaction
            DB::beginTransaction();
        
            $sale->total = 0;
        
            // Delete existing records
            SelledTalent::where('sell_id', $sale->id)->delete();
        
            $prevPackageTalent = SelledItems::where('sell_id', $sale->id)->where('unit', 'PAKET')->pluck('id')->first();
            SelledItems::where('sell_id', $sale->id)->delete();
            
            // Re-add talents
            if ($request->selled_talents) {
                foreach ($request->selled_talents as $selledTalent) {
                    $talent = Talent::with('talentGradeDetail')->where('id', $selledTalent['id'])->firstOrFail();
        
                    // TODO: Add talent status checking
                    $talent->status = 'booked';
                    $talent->save();
        
                    $bookedTalent = new SelledTalent();
                    $bookedTalent->sell_id = $sale->id;
                    $bookedTalent->talent_id = $talent->id;
                    $bookedTalent->hour = $selledTalent['qty'];
                    $bookedTalent->talent_price = $talent->talentGradeDetail->talent_price;
                    $bookedTalent->agency_price = $talent->talentGradeDetail->agency_price;
                    $bookedTalent->office_price = $talent->talentGradeDetail->office_price;
                    $bookedTalent->save();
        
                    $sale->total += ($bookedTalent->talent_price + $bookedTalent->agency_price + $bookedTalent->office_price) * $bookedTalent->hour;
                }
            }
        
            // Re-add items
            if ($request->selled_items) {
                foreach ($request->selled_items as $selledItem) {
                    $product = Product::with('unit')->where('id', $selledItem['id'])->firstOrFail();
        
                    // TODO: Add stock checking here
                    if ($product->is_stock == 1) {
                        if (!$product->hasSufficientStock($selledItem['qty'])) {
                            return response()->json([
                                'status' => 400,
                                'message' => __('Insufficient stock for product: ') . $product->name,
                            ]);
                        }
                    }
                    
                    $bookedItem = new SelledItems();
                    $bookedItem->sell_id = $sale->id;
                    $bookedItem->product_id = $selledItem['id'];
                    $bookedItem->price = $product->sale_price;
                    $bookedItem->purchase_price = $product->purchase_price;
                    $bookedItem->quantity = $selledItem['qty'];
                    $bookedItem->unit = $product->unit->name;
                    $bookedItem->save();
        
                    $sale->total += $bookedItem->price * $bookedItem->quantity;
        
                    if ($product->unit->name == 'PAKET') {
                        // Get the corresponding SelledPackageTalents for the previous package
                        $selledPackageTalents = SelledPackageTalent::where('selled_item_id', $prevPackageTalent)->get();
                        if ($selledPackageTalents->isNotEmpty()) {
                            foreach ($selledPackageTalents as $selledTalent) {
                                // Update the selled_item_id for the package talents with the new selled_item_id
                                $selledTalent->selled_item_id = $bookedItem->id; // Fix the extra $ sign here
                                $selledTalent->save();
                            }
                        }
                    }
                }
            }
        
            $sale->tax = $sale->total * 0.11;
        
            // Save updated sale
            $sale->save();
        
            // Commit the transaction
            DB::commit();
        
            return response()->json([
                'status' => 200,
                'message' => 'Sale updated successfully.',
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
        
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update sale. Error: ' . $e->getMessage(),
            ], 500);
        }
        
    }

    public function destroy(Sale $sale)
    {
        if (Auth::user()->can('Manage Sales') && isset($sale)) {
            SelledItems::where('sell_id', $sale->id)->delete();
            $sale->delete();
        }

        return redirect()->route('reports.sales')->with('success', __('Sales Order deleted successfully.'));
    }

    public function salesItems(Request $request)
    {
        $sale_id = $request->id;
        if (Auth::user()->can('Manage Sales') && $request->ajax() && isset($sale_id) && !empty($sale_id)) {
            $items = SelledItems::select('selled_items.*', 'products.name as productname', 'products.quantity as maxquantity')->join('products', 'products.id', '=', 'selled_items.product_id')->where('products.created_by', '=', Auth::user()->getCreatedBy())->where('selled_items.sell_id', '=', $sale_id)->get();

            foreach ($items as $key => $item) {
                $subtotal = $item->price * $item->quantity;
                $tax      = ($subtotal * $item->tax) / 100;

                $items[$key]['subtotal'] = $subtotal + $tax;
            }

            return json_encode($items);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function selledInvoice($sell_id)
    {
        $sell_id = Crypt::decrypt($sell_id);

        $sell = Sale::find($sell_id);

        if (!empty($sell)) {
            $user     = User::select('*')->where('id', $sell->created_by)->first();
            $settings = Utility::settings($user->id);

            $invoice_id    = $user->sellInvoiceNumberFormat($sell->invoice_id);
            $invoice_color = $user->sellInvoiceColor();

            $settings['company_telephone'] = $settings['company_telephone'] != '' ? ", " . $settings['company_telephone'] : '';
            $settings['company_state']     = $settings['company_state'] != '' ? ", " . $settings['company_state'] : '';

            $userdetails = [
                ucfirst($user->name),
                $settings['company_name'] . $settings['company_telephone'],
                $settings['company_address'],
                $settings['company_city'] . $settings['company_state'],
                $settings['company_country'],
                $settings['company_zipcode'],
            ];

            $customer = $sell->customer;

            if ($customer != null) {
                $customer->state = $customer->state != '' ? ", " . $customer->state : '';

                $customerdetails = [
                    ucfirst($customer->name),
                    $customer->phone_number,
                    $customer->address,
                    $customer->city . $customer->state,
                    $customer->country,
                    $customer->zipcode,
                ];
            } else {
                $customerdetails = [
                    __('Walk-in Customer'),
                    '',
                    '',
                    '',
                    '',
                    '',
                ];
            }

            $items = SelledItems::select('selled_items.*', 'products.name as productname')->join('products', 'products.id', '=', 'selled_items.product_id')->where('products.created_by', '=', $user->getCreatedBy())->where('selled_items.sell_id', '=', $sell->id)->get();

            $invoice = new InvoicePrinter("A4", $user->currencySymbol(), $user->lang);

            $invoice->setLogo(asset(Storage::url('logo/logo-invoice.png')));
            $invoice->setColor($invoice_color);
            $invoice->setType($invoice_id);
            $invoice->setDate($user->dateFormat($sell->created_at));
            $invoice->setTime($user->timeFormat($sell->created_at));

            $invoice->setFrom($userdetails);

            $invoice->setTo($customerdetails);

            $total = 0;

            foreach ($items as $key => $item) {
                $subtotal = $item->price * $item->quantity;
                $tax      = ($subtotal * $item->tax) / 100;

                $total += $st = $subtotal + $tax;
                $invoice->addItem($item->productname, "", $item->quantity, $item->price, $item->tax, $tax, $st);
            }

            $invoice->addTotal("Total", $total, true);

            if ($sell->status == 1) {
                $invoice->addBadge(__('Partially Paid'));
            } else if ($sell->status == 2) {
                $invoice->addBadge(__('Paid'));
            } else {
                $invoice->addBadge(__('Unpaid'));
            }

            $invoice->addTitle("Important Notice");

            $invoice->addParagraph("No item will be replaced or refunded if you don't have the invoice with you.");

            $invoice->setFooternote(URL::to('/'));

            $name = 'sellpdf/sell_' . md5(time()) . '.pdf';

            $invoice->render('I', $name);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function printSaleInvoice($id)
    {
        $sale_id = Crypt::decrypt($id);
        $sale    = Sale::findOrFail($sale_id);

        if ($sale) {
            $user = User::select('*')->where('id', $sale->created_by)->first();

            $selleditems = SelledItems::select('selled_items.*', 'products.name as productname')->join('products', 'products.id', '=', 'selled_items.product_id')->where('products.created_by', '=', $user->getCreatedBy())->where('selled_items.sell_id', '=', $sale->id)->get();

            $total = 0;

            foreach ($selleditems as $key => $item) {
                $subtotal = $item->price * $item->quantity;
                $tax      = ($subtotal * $item->tax) / 100;

                $total += $st = $subtotal + $tax;

                $item->name       = $item->productname;
                $item->quantity   = $item->quantity;
                $item->price      = $user->priceFormat($item->price);
                $item->tax        = $item->tax . '%';
                $item->tax_amount = $user->priceFormat($tax);
                $item->subtotal   = $user->priceFormat($st);
                $items[]          = $item;
            }

            $sale->items    = $items;
            $sale->subtotal = $user->priceFormat($total);

            $settings                      = Utility::settings($user->id);
            $settings['company_telephone'] = $settings['company_telephone'] != '' ? ", " . $settings['company_telephone'] : '';
            $settings['company_state']     = $settings['company_state'] != '' ? ", " . $settings['company_state'] : '';

            $userdetails = [
                ucfirst($user->name),
                $settings['company_name'] . $settings['company_telephone'],
                $settings['company_address'],
                $settings['company_city'] . $settings['company_state'],
                $settings['company_country'],
                $settings['company_zipcode'],
            ];

            $customer = $sale->customer;

            if ($customer != null) {
                $customer->state = $customer->state != '' ? ", " . $customer->state : '';

                $customerdetails = [
                    ucfirst($customer->name),
                    $customer->phone_number,
                    $customer->address,
                    $customer->city . $customer->state,
                    $customer->country,
                    $customer->zipcode,
                ];
            } else {
                $customerdetails = [
                    __('Walk-in Vendor'),
                    '',
                    '',
                    '',
                    '',
                    '',
                ];
            }
            $color = '#' . $settings['sale_invoice_color'];

            //Set your logo
            // $logo         = asset(\Storage::url('/'));
            // $company_logo = Utility::getValByName('company_logo_dark');
            $logo=\App\Models\Utility::get_file('/');
            $company_logo = Utility::get_company_logo();
            $img          = asset($logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));

            $font_color = Utility::getFontColor($color);

            return view('sales.templates.' . $settings['sale_invoice_template'], compact('sale', 'color', 'font_color', 'settings', 'user', 'userdetails', 'customerdetails', 'img'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function previewSelledInvoice($template, $color)
    {
        $settings = Utility::settings();

        $sale = new Sale();
        $user = Auth::user();

        $customerdetails = [
            ucfirst('Client'),
        ];

        $items = [];
        for ($i = 1; $i <= 3; $i++) {
            $item             = new \stdClass();
            $item->name       = 'Item ' . $i;
            $item->quantity   = 2;
            $item->price      = 'Rp.100.00';
            $item->tax        = '0%';
            $item->tax_amount = 'Rp.0.0';
            $item->subtotal   = 'Rp.200.00';
            $items[]          = $item;
        }

        $sale->invoice_id = 1;
        $sale->items      = $items;
        $sale->subtotal   = 'Rp.600.00';
        $sale->created_at = date('Y-m-d H:i:s');

        $preview    = 1;
        $color      = '#' . $color;
        $font_color = Utility::getFontColor($color);

        //Set your logo
        // $logo         = asset(\Storage::url('/'));
        // $company_logo = Utility::getValByName('company_logo_dark');
        $logo=\App\Models\Utility::get_file('/');
        $company_logo = Utility::get_company_logo();
        $img          = asset($logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));

        return view('sales.templates.' . $template, compact('sale', 'preview', 'color', 'font_color', 'settings', 'user', 'customerdetails', 'img'));
    }
    public function export()
    {
        $name = 'Sale_' . date('Y-m-d i:h:s');
        $data = Excel::download(new SaleExport(), $name . '.xlsx'); ob_end_clean();

        return $data;
    }

    public function getLocation()
    {
        $locations = LocationType::with('location')->where('created_by', Auth::user()->getCreatedBy())->get();

        return view('sales.get-location', compact('locations'));
    }

    public function getLocationSale($location_id)
    {
        $sale = Sale::with([
            'selledItem.product', 
            'selledItem.selledPackageItem.product',
            'selledTalent.talent',
            'selledItem.selledPackageTalent.talent',
            // 'location',

        ]) // Eager load both relationships
        ->where('location_id', $location_id)
        // ->where('check_out', null)
        ->orderBy('created_at', 'desc')
        ->latest()
        ->first();

        $sale->invoice_id = Auth::user()->sellInvoiceNumberFormat($sale->invoice_id);

        return $sale;
    }

    public function inProcess(Request $request)
    {
        $location = Location::where('id', $request->location_id)->where('created_by', Auth::user()->getCreatedBy())->first();

        $location->state = "processing";
        $location->processing_by = Auth::user()->name;
        $location->last_process_call = Carbon::now();
        $location->save();

        return response()->json(['message' => 'Call is logged.']);
    }

    public function reserveLocation(Request $request)
    {
        $location = Location::find($request->location_id);
    
        if (!$location) {
            return [
                'status' => 'error',
                'message' => __('Location not found.')
            ];
        }
    
        if (
            $location->last_process_call &&
            now()->diffInSeconds($location->last_process_call) < 15 &&
            $location->processing_by != Auth::user()->name
        ) {
            return [
                'status' => 'error',
                'message' => __('Location is still being processed by :user.', ['user' => $location->processing_by])
            ];
        }
    
        // Logic to reserve location (optional: update DB fields like `processing_by` here)
        $location->update([
            'last_process_call' => now(),
            'processing_by' => Auth::user()->name,
        ]);
    
        return [
            'status' => 'success',
            'message' => __('Location reserved successfully.'),
            'location' => $location->code
        ];
    }

    public function checkOut(Request $request)
    {
         // Find the location by its code
        $location = Location::where('code', $request->location)->first();

        if (!$location) {
            return response()->json(['status' => 400, 'message' => 'Location not found.']);
        }

        // Find the sale for the location where check_out is null (i.e., not yet checked out)
        $sale = Sale::where('location_id', $location->id)->whereNull('check_out')->first();

        if (!$sale) {
            return response()->json(['status' => 400, 'message' => 'No ongoing sale found for this location.']);
        }

        // Check if the total payment (total + tax) matches the paid amount
        if (($sale->total + $sale->tax) == $sale->paid) {
            // Mark the sale as checked out
            $sale->check_out = Carbon::now();
            // $sale->save();

            $selledTalents = SelledTalent::where('sell_id', $sale->id)->get();

            if ($selledTalents->isNotEmpty()) {
                foreach ($selledTalents as $selledTalent) {
                    $talent = Talent::where('id', $selledTalent->talent_id)->first();
                    if ($talent) {  // Check if talent exists
                        $talent->status = 'available';
                        $talent->save();
                    }
                }
            }

            if ($sale->type == 'paket') {
                $packageId = SelledItems::where('sell_id', $sale->id)->where('unit', 'PAKET')->pluck('id')->first();
                // return $packageId;
                if ($packageId) {  // Check if package ID exists
                    $selledPackageTalents = SelledPackageTalent::where('selled_item_id', $packageId)->get();

                    if ($selledPackageTalents->isNotEmpty()) {
                        foreach ($selledPackageTalents as $selledTalent) {
                            $talent = Talent::where('id', $selledTalent->talent_id)->first();
                            if ($talent) {  // Check if talent exists
                                $talent->status = 'available';
                                $talent->save();
                            }
                        }
                    }
                }
            }

            return response()->json(['status' => 200, 'message' => "Penjualan di Lokasi $sale->location_code check-out successfully."]);
        } else {
            // Payment is incomplete, return a response indicating that
            return response()->json(['status' => 400, 'message' => 'Payment not completed. Please complete the payment first.']);
        }
        

    }
    
}
