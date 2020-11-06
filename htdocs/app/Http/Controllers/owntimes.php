<?php

namespace App\Http\Controllers;

use App\bookedTimes;
use App\timeCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class owntimes extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Controller::isActive(Auth::user());
        $BookedTimes    = bookedTimes::query()
            ->join('time_categories','time_categories.id','=','booked_times.catid')
            ->select('booked_times.*', 'time_categories.name as catname')
            ->where('userid',Auth::user()->id)
            ->get();

        $actDateTime 	    = date('Y-m-d H:i:s');
        $OneYearPast        = date('Y-01-01');
        $firstDayOfActMonth = date('Y-m-01', strtotime($actDateTime));

        if (date('m') >= 8 ) {
            $KindergardenStart  = date('Y-08-01');
            $KindergardenEnd    = date('Y-07-31',strtotime('+1 year'));
        } else {
            $KindergardenStart  = date('Y-08-01',strtotime('-1 year'));
            $KindergardenEnd    = date('Y-07-31');
        }

        $OneYearCompleteTimes   = bookedTimes::query()
            ->where([
                ['userid',Auth::user()->id],
                ['date','<=', $actDateTime],
                ['date', '>=', $OneYearPast]
            ])
            ->sum('usedtime');

        $ActMonthCompleteTimes   = bookedTimes::query()
            ->where([
                ['userid',Auth::user()->id],
                ['date','<=', $actDateTime],
                ['date', '>=', $firstDayOfActMonth]
            ])
            ->sum('usedtime');

        $ActKindergardenYear    = bookedTimes::query()
            ->where([
                ['userid',Auth::user()->id],
                ['date','<=', $KindergardenEnd],
                ['date', '>=', $KindergardenStart]
            ])
            ->sum('usedtime');

        return view('owntimes', [
            'ownBookedTimes'         => $BookedTimes,
            'ownTimes4Year'          => $OneYearCompleteTimes,
            'ownActMonth'            => $ActMonthCompleteTimes,
            'ownKindergardenYear'    => $ActKindergardenYear
        ]);
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id) {
        Controller::isActive(Auth::user());
        $Entry2Delete = bookedTimes::query()->where([
            ['userid',Auth::user()->id],
            ['id', $id]
        ])->first();
        if ($Entry2Delete != null) {
            Log::debug('Delete:'.$Entry2Delete);
            $Entry2Delete->delete();
        }
        return redirect('owntimes');
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function edit($id) {
        Controller::isActive(Auth::user());
        $Categories             = timeCategories::all();
        $CategoriesDescription  = timeCategories::all();

        $Entry2Edit = bookedTimes::query()->where([
            ['userid',Auth::user()->id],
            ['id', $id]
        ])->first();

        return view('addtime', [
            'categories'    => $Categories,
            'state'         => 'edit',
            'Categories'    => $CategoriesDescription,
            'EditEntry'     => $Entry2Edit
        ]);
    }
}
