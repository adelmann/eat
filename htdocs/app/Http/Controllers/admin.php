<?php

namespace App\Http\Controllers;

use App\bookedTimes;
use App\timeCategories;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class admin extends Controller
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
        return view('users', [
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminuser() {
        Controller::isActive(Auth::user());
        $Users = User::orderBy('name','asc')->paginate(25);

        return view('adminUsers', compact('Users'));
    }

    /**
     * @param $userid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function admintoggleActive($userid)
    {
        Controller::isActive(Auth::user());
        if (Auth::user()->admin == 1) {
            $choosenUser = User::query()->where('id', $userid)->first();
            $choosenUser->active = ($choosenUser->active == 1) ? 0 : 1;
            $choosenUser->save();
            return redirect('adminuser');
        } else {
            return redirect('home');
        }
    }

    /**
     * @param $userid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function admintoggleAdmin($userid)
    {
        Controller::isActive(Auth::user());
        if (Auth::user()->admin == 1) {
            $choosenUser = User::query()->where('id', $userid)->first();
            $choosenUser->admin = ($choosenUser->admin == 1) ? 0 : 1;
            $choosenUser->save();
            return redirect('adminuser');
        } else {
            return redirect('home');
        }
    }

    /**
     * @param $userid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function adminDeleteUser($userid)
    {
        Controller::isActive(Auth::user());
        if (Auth::user()->admin == 1) {
            $bookedTimes = bookedTimes::query()->where('userid',$userid)->get();
            foreach ($bookedTimes as $booking) {
                $booking->delete();
            }
            $choosenUser = User::query()->where('id', $userid)->first();
            $choosenUser->delete();
            return redirect('adminuser');
        } else {
            return redirect('home');
        }

    }
}
