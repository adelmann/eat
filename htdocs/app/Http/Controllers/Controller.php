<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function isActive($user)
    {
        if ($user->active == '0') {
            Auth::logout();
            header("Refresh:0");
        }
    }

    /**
     * @param $minutes
     * @return string
     */
    public static function getMinutesToTime($minutes, $asHTML = true) {
        if ($minutes < 0) return 'false';
        if ($minutes == 0) return "0m";

        $hours      = floor((($minutes % (60 * 60 * 24)) % (60 * 60)) / 60 );
        $minutes    = floor((($minutes % (60 * 60 * 24)) % (60 * 60)) % 60 );


        $out = "";
        if ($asHTML == true) {
            if ($hours > 0) $out .= "<span class='hour'>" . $hours . "</span>h ";
            if ($minutes > 0) $out .= "<span class='minutes'>" . $minutes . "</span>m ";
        } else {
            if ($hours > 0) $out .= "" . $hours . "h ";
            if ($minutes > 0) $out .= $minutes . "m ";
        }

        return $out;
    }

    /**
     * @param $minutes
     * @return string
     */
    public static function getTranslatedTime($minutes) {
        $hours    = floor($minutes / 60);
        $minutes  = $minutes - ($hours * 60);
        return sprintf("%02d", $hours).':'.sprintf("%02d", $minutes);
    }
}
