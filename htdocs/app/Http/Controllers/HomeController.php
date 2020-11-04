<?php

namespace App\Http\Controllers;

use App\bookedTimes;
use App\timeCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
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

        $CategoriesDescription  = timeCategories::all();

        $Last30Entries          = bookedTimes::query()
            ->join('time_categories','time_categories.id','=','booked_times.catid')
            ->join('users','users.id','=','booked_times.userid')
            ->select('booked_times.*', 'time_categories.name as catname','users.name')
            ->orderBy('date','desc')->take(30)->get();

        $OneYearCompleteTimes   = bookedTimes::query()
            ->where([
                ['date','<=', $actDateTime],
                ['date', '>=', $OneYearPast]
            ])
            ->sum('usedtime');

        $ActMonthCompleteTimes   = bookedTimes::query()
            ->where([
                ['date','<=', $actDateTime],
                ['date', '>=', $firstDayOfActMonth]
            ])
            ->sum('usedtime');

        $ActKindergardenYear    = bookedTimes::query()
            ->where([
                ['date','<=', $KindergardenEnd],
                ['date', '>=', $KindergardenStart]
            ])
            ->sum('usedtime');

        return view('home',
        [
            'allTime1Year'          => $OneYearCompleteTimes,
            'actMonthTime'          => $ActMonthCompleteTimes,
            'actKindergardenYear'   => $ActKindergardenYear,
            'last30Entries'         => $Last30Entries,
            'Categories'            => $CategoriesDescription
        ]);
    }
}
