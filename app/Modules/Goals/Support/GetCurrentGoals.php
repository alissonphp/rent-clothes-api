<?php

namespace App\Modules\Goals\Support;

use App\Modules\Cashier\Models\SellerCommission;
use App\Modules\Goals\Models\Goals;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class GetCurrentGoals
 * @package App\Modules\Goals\Support
 */
class GetCurrentGoals
{

    /**
     * @var \Illuminate\Database\Eloquent\Model|null|static
     */
    public $goal;
    /**
     * @var Carbon
     */
    public $start;
    /**
     * @var Carbon
     */
    public $end;

    /**
     * GetCurrentGoals constructor.
     */
    public function __construct()
    {
        try {

            $this->start = new Carbon('first day of this month');
            $this->end = new Carbon('last day of this month');

            $year = date('Y');
            $month = date('m');
            $this->goal = Goals::where('year',$year)
                ->where('month',$month)
                ->first();
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * @return mixed
     */
    public function getGoalSeller()
    {
        return $this->goal->goal_seller;
    }

    /**
     * @param $seller
     * @return mixed
     */
    public function getGoalSellerNow($seller)
    {
        return DB::table('seller_commissions')
            ->join('cashier','seller_commissions.cashiers_id','=','cashier.id')
            ->where('seller_commissions.users_id', $seller)
            ->whereBetween('seller_commissions.created_at',[$this->start, $this->end])
            ->select((DB::raw('sum(cashier.total) as totalSellers')))
            ->get();
    }

    /**
     * @return mixed
     */
    public function getGoalStore()
    {
        return $this->goal->goal_store;
    }

    /**
     * @return mixed
     */
    public function getGoalStoreNow()
    {
        return DB::table('cashier')
            ->whereBetween('created_at',[$this->start, $this->end])
            ->select((DB::raw('sum(total) as totalStore')))
            ->get();
    }


    /**
     * @param $seller
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSellerCurrentCommissions($seller)
    {
        return SellerCommission::where('users_id', $seller)
            ->whereBetween('created_at',[$this->start, $this->end])
            ->with(['cashier' => function ($query) {
                $query->with('order');
            }])
            ->orderBy('created_at')
            ->get();
    }

    /**
     * @param $value
     * @return float|int
     */
    public function calcSellerCommission($value)
    {
        $comm = $value * ($this->goal->commission_seller/100);
        return $comm;
    }

}