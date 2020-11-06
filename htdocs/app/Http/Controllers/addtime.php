<?php

namespace App\Http\Controllers;

use App\bookedTimes;
use App\timeCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class addtime extends Controller
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
        $Categories             = timeCategories::all();
        $CategoriesDescription  = timeCategories::all();

        return view('addtime', [
            'categories'    => $Categories,
            'state'         => '',
            'Categories'            => $CategoriesDescription
        ]);
    }

    public function addnew(Request $request)
    {
        Controller::isActive(Auth::user());
        $Categories     = timeCategories::all();

        $category       = $request->get('category');
        $title          = $request->get('title');
        $usedTime       = $request->get('usedTime');
        $usedDate       = $request->get('usedDate');
        $description    = $request->get('description');

        if ($category != '' && $usedTime != '') {
            $bookTime               = new bookedTimes();
            $bookTime->title        = $title;
            $bookTime->catid        = $category;
            $bookTime->description  = $description;

            $workinTime             = explode(':',$usedTime);
            $hours2Minutes          = $workinTime[0] * 60;
            $usedTimeInMinutes      = $hours2Minutes+$workinTime[1];

            $bookTime->usedtime     = $usedTimeInMinutes;

            if ($usedDate != '') {
                $bookTime->date     = $usedDate;
            } else {
                $actDateTime 	    = date('Y-m-d H:i:s');
                $bookTime->date     = $actDateTime;
            }
            $bookTime->userid       = Auth::user()->id;
            $bookTime->save();

            return view('addtime', [
                'state'         => 'safed'
            ]);
        } else {
            Log::debug('Error saving addTime with datas:'.$request);
            return view('addtime', [
                'state'         => 'unsafed'
            ]);
        }
    }

    public function updateEntry(Request $request) {
        Controller::isActive(Auth::user());
        $Categories     = timeCategories::all();

        $entryId        = $request->get('entryId');
        $category       = $request->get('category');
        $title          = $request->get('title');
        $usedTime       = $request->get('usedTime');
        $usedDate       = $request->get('usedDate');
        $description    = $request->get('description');

        if ($category != '' && $usedTime != '') {
            $bookTime = bookedTimes::query()->where([
                ['userid',Auth::user()->id],
                ['id', $entryId]
            ])->first();

            if ($bookTime->userid == Auth::user()->id) {
                $bookTime->title        = $title;
                $bookTime->catid        = $category;
                $bookTime->description  = $description;

                $workinTime             = explode(':',$usedTime);
                $hours2Minutes          = $workinTime[0] * 60;
                $usedTimeInMinutes      = $hours2Minutes+$workinTime[1];

                $bookTime->usedtime     = $usedTimeInMinutes;
                if ($usedDate != '') {
                    $bookTime->date     = $usedDate;
                } else {
                    $actDateTime 	    = date('Y-m-d H:i:s');
                    $bookTime->date     = $actDateTime;
                }
                $bookTime->save();
                return redirect('owntimes');
            } else {
                Log::debug('Its not possible to edit other booking (User:'.Auth::user()->id.'):'.$request);
                return view('addtime', [
                    'state'         => 'unsafed'
                ]);
            }

        } else {
            Log::debug('Error saving addTime with datas:'.$request);
            return view('addtime', [
                'state'         => 'unsafed'
            ]);
        }
    }
}
