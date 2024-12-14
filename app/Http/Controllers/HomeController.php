<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchSalesTarget;
use App\Models\Calendar;
use App\Models\CashRegister;
use App\Models\Customer;
use App\Models\LandingPageSection;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Location;
use App\Models\LocationType;
use App\Models\Sale;
use App\Models\Todo;
use App\Models\User;
use App\Models\Utility;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    function index()
    {
        if (\Auth::check()) {
            $authuser = Auth::user();

            $user_id = $authuser->getCreatedBy();

            $low_stock = (int)Utility::settings()['low_product_stock_threshold'];

            $branches = Branch::select('id')->where('created_by', '=', $user_id)->count();

            $cashregisters = CashRegister::select('cash_registers.id')
                ->leftjoin('branches', 'branches.id', '=', 'cash_registers.branch_id')
                ->where('branches.created_by', '=', $user_id)
                ->count();


            //   Dashboard calendar 
            $events    = Calendar::where('created_by', '=', \Auth::user()->getCreatedBy())->get();
            $now = date('m');
            $current_month_event = Calendar::select('id', 'start', 'end', 'title', 'created_at', 'className')->whereRaw('MONTH(start)=' . $now)->get();

            $arrEvents = [];
            foreach ($events as $event) {

                $arr['id']    = $event['id'];
                $arr['title'] = $event['title'];
                $arr['start'] = $event['start'];
                $arr['end']   = $event['end'];
                $arr['className'] = $event['className'];
                $arr['url']             = route('calendars.show', $event['id']);

                $arrEvents[] = $arr;
            }
            $arrEvents =  json_encode($arrEvents);
            //   Dashboard calendar 

            $notifications = Notification::getAllNotifications();

            $customers = Customer::select('id')->where('created_by', '=', $user_id)->count();

            $vendors = Vendor::select('id')->where('created_by', '=', $user_id)->count();

            $productObj = Product::getallproducts();

            $productscount = $productObj->count();

            $monthlySelledAmount = Sale::totalSelledAmount(true);
            $dailySelledAmount = Sale::totalSelledAmount(false, true);

            $monthlyPurchasedAmount = Purchase::totalPurchasedAmount(true);
            $dailyPurchasedAmount = Purchase::totalPurchasedAmount(false, true);

            $purchasesArray = Purchase::getPurchaseReportChart();

            $salesArray = Sale::getSalesReportChart();

            $todos = Todo::where('created_by', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();

            $saletarget = BranchSalesTarget::getBranchTargets(true);

            $locations = Location::with('latestSale')->where('created_by', '=', Auth::user()->getCreatedBy())->orderBy('id', 'ASC')->get();
            $locationTypes = LocationType::where('created_by', '=', Auth::user()->getCreatedBy())->orderBy('id', 'ASC')->pluck('name', 'name');
            $locationTypes->prepend(__('All Location'), '');

            $homes = [
                'branches',
                'cashregisters',
                'productscount',
                'notifications',
                'customers',
                'vendors',
                'monthlySelledAmount',
                'dailySelledAmount',
                'monthlyPurchasedAmount',
                'dailyPurchasedAmount',
                'purchasesArray',
                'salesArray',
                'todos',
                'saletarget',
                'locations',
                'locationTypes'
            ];

            $getOrderChart     = $this->getOrderChart(['duration' => 'week']);
            $ownersCount       = User::totalOwners();
            $paidOwnersCount   = User::countPaidOwners();
            $ordersCount       = Order::totalOrders();
            $ordersPrice       = Order::totalOrdersPrice();
            $plansCount        = Plan::totalPlan();
            $mostPurchasedPlan = Plan::most_purchased_plan();

            $sa = [
                'getOrderChart',
                'ownersCount',
                'ordersCount',
                'ordersPrice',
                'plansCount',
                'paidOwnersCount',
                'mostPurchasedPlan',
            ];

            if (Auth::user()->isSuperAdmin()) {
                return view('sa-dashboard', compact($sa));
            }

            return view('dashboard', compact($homes, 'arrEvents'));
        } else {
            if (!file_exists(storage_path() . "/installed")) {
                header('location:install');
                die;
            } else {
                if (env('DISPLAY_LANDING') == 'on') {
                    $plans = Plan::get();
                    $get_section = LandingPageSection::orderBy('section_order', 'ASC')->get();
                    return view('layouts.landing', compact('plans', 'get_section'));
                } else {
                    return redirect('login');
                }
            }
        }
    }

    public function getOrderChart(array $arrParam)
    {
        $arrDuration = [];
        if ($arrParam['duration']) {
            if ($arrParam['duration'] == 'week') {
                $previous_week = strtotime("-2 week +1 day");

                for ($i = 0; $i < 14; $i++) {
                    $arrDuration[date('Y-m-d', $previous_week)] = date('d-M', $previous_week);

                    $previous_week = strtotime(date('Y-m-d', $previous_week) . " +1 day");
                }
            }
        }
        $arrTask = [];
        foreach ($arrDuration as $date => $label) {
            $data               = Order::select(DB::raw('count(*) as total'))->whereDate('created_at', '=', $date)->first();
            $arrTask['label'][] = $label;
            $arrTask['data'][]  = $data->total;
        }

        return $arrTask;
    }

    public function changeMode()
    {
        $usr = Auth::user();
        $usr->mode  = $usr->mode == 'light' ? 'dark' : 'light';
        $usr->save();

        return redirect()->back();
    }

    public function getStockNotification($stock_type)
    {
        $productObj = Product::getallproducts();

        $productscount = $productObj->count();

        if ($stock_type == 'min') {
            
            $lowstockproducts = [];
    
            if ($productscount > 0) {
    
                foreach ($productObj->get() as $key => $product) {
    
                    $productquantity = $product->getTotalProductQuantity();
    
                    if ($productquantity <= $product->min_stock && $product->is_stock == 1) {
                        $lowstockproducts[] = [
                            'name' => $product->name,
                            'quantity' => $productquantity
                        ];
                    }
                }
            }

            $html = view('components.low-stock-notification', compact('lowstockproducts'))->render();

            return response()->json(['html' => $html]);

        } else if ($stock_type == 'max') {
            $highstockproducts = [];
    
            if ($productscount > 0) {
    
                foreach ($productObj->get() as $key => $product) {
    
                    $productquantity = $product->getTotalProductQuantity();
    
                    if ($productquantity >= $product->max_stock && $product->is_stock == 1) {
                        $highstockproducts[] = [
                            'name' => $product->name,
                            'quantity' => $productquantity
                        ];
                    }
                }
            }

            $html = view('components.high-stock-notification', compact('highstockproducts'))->render();

            return response()->json(['html' => $html]);
        }
       
    }
}
