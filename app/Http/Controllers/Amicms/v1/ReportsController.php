<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Models\Business;
use App\Models\BusinessFactories;
use App\Models\Machine;
use App\Models\Order;
use App\Models\Report;
use App\Models\Subscription;
use App\Models\SubscriptionHistory;
use App\Models\Technic;
use Illuminate\Http\Request;

class ReportsController extends AmicmsController
{
    private $layout = [];

    private $startDate = '';
    private $endDate = '';

    public function __construct()
    {
        $this->is_profile_auth();
        $this->layout['title'] = 'Статистика';


    }

    public function orders(Request $request)
    {
        $machines = Machine::with(['reportOrdersByNew'])->orderBy('title_uk', 'asc')->get();

        $orders_array = Order::with('machine')
            ->select("*")
            ->selectRaw("count(case when status = 'new' then 1 end) as total_new")
            ->selectRaw("count(case when status = 'accepted' or status = 'executed' then 1 end) as total_accepted")
            ->selectRaw("count(case when status = 'done' then 1 end) as total_done");

        $machinesImp = [];
        if (!empty($request->get('machines')) && $request->has('machines')) {
            $machinesImp = implode(',', $request->get('machines'));
            $orders_array->whereIn('machine_id', explode(',', $machinesImp));

        }

        if (!empty($request->get('period')) && $request->has('period')) {
            $periodExp = explode(' - ', $request->get('period'));
            $this->startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));


            $this->endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));
            $orders_array->whereBetween('created_at', [$this->startDate, $this->endDate]);

        }

        $orders = $orders_array->groupBy('machine_id')->orderBy('created_at')->get();
        return view('amicms.reports.orders', ['layout' => $this->layout, 'machines' => $machines, 'machinesImp' => $machinesImp, 'orders' => $orders, 'startDate' => $this->startDate, 'endDate' => $this->endDate]);

    }

    public function subscription(Request $request)
    {
        $histories_array = Subscription::whereHas('business')
            ->select("*")
//            ->selectRaw("count(case when type = 'package' then 1 end) as total_package")
//            ->selectRaw("count(case when type = 'slot' then 1 end) as total_slot")
        ;

        $histories_array->where('added_manually', 0);

        if (!empty($request->get('period')) && $request->has('period')) {
            $periodExp = explode(' - ', $request->get('period'));
            $this->startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));
            $this->endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));
            $histories_array->whereBetween('created_at', [$this->startDate, $this->endDate]);

        }

        $histories = $histories_array->orderBy('added_manually', 'desc')->orderBy('created_at', 'desc')->get();


        $historyPackage = Subscription::selectRaw("sum(price) as paid_package")
            ->selectRaw("count(case when type = 'package' then 1 end) as total_package")
            ->selectRaw("count(case when type = 'package' and status='Approved' and date_format(active_to, '%Y-%m-%d') >= " . date('Y-m-d') . " then 1 end) as total_active_package")
            ->selectRaw("count(case when type = 'package' and status<>'Approved' or date_format(active_to, '%Y-%m-%d') <= " . date('Y-m-d') . " then 1 end) as total_deactive_package")
            ->where('type', 'package');

        $historyPackage->where('added_manually', 0)->orderBy('added_manually', 'desc');

        if (!empty($request->get('period')) && $request->has('period')) {
            $periodExp = explode(' - ', $request->get('period'));
            $this->startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));
            $this->endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));
            $historyPackage->whereBetween('created_at', [$this->startDate, $this->endDate]);

        }

        $historyPackage = $historyPackage->orderBy('created_at', 'desc')->first();

        $historySlot = Subscription::selectRaw("sum(price) as paid_slot")
            ->selectRaw("sum(count) as total_slot")
            ->selectRaw("sum(case when type = 'slot' and status = 'Approved' and date_format(active_to, '%Y-%m-%d') >= " . date('Y-m-d') . " then count else 0 end) as total_active_slot")
            ->selectRaw("sum(case when type = 'slot' and status <> 'Approved' or date_format(active_to, '%Y-%m-%d') <= " . date('Y-m-d') . " then count else 0 end) as total_deactive_slot")
            ->where('type', 'slot');

        $historySlot->where('added_manually', 0)->orderBy('added_manually', 'desc');

        if (!empty($request->get('period')) && $request->has('period')) {
            $periodExp = explode(' - ', $request->get('period'));
            $this->startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));
            $this->endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));
            $historySlot->whereBetween('created_at', [$this->startDate, $this->endDate]);

        }

        $historySlot = $historySlot->orderBy('created_at', 'desc')->first();

        return view('amicms.reports.subscription', ['layout' => $this->layout, 'histories' => $histories, 'startDate' => $this->startDate, 'endDate' => $this->endDate, 'historyPackage' => $historyPackage, 'historySlot' => $historySlot]);

    }

}
