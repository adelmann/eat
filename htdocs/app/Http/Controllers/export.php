<?php

namespace App\Http\Controllers;

use App\bookedTimes;
use App\User;
use Illuminate\Http\Request;

class export extends Controller
{
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
        return view('export');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportKindergardenYearParents() {
        $users                  = User::all();
        $actDateTime 	        = date('Y-m-d H:i:s');
        if (date('m') >= 8 ) {
            $KindergardenStart  = date('Y-08-01');
            $KindergardenEnd    = date('Y-07-31',strtotime('+1 year'));
        } else {
            $KindergardenStart  = date('Y-08-01',strtotime('-1 year'));
            $KindergardenEnd    = date('Y-07-31');
        }

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=kindergardenYearParentsTime.csv", // <- name of file
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $columns = array('Elternteil','Zeiten');

        $callback = function() use($users, $KindergardenEnd, $KindergardenStart,$columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns,';');

            foreach ($users as $user) {
                $ActKindergardenYearPerParent    = bookedTimes::query()
                    ->where([
                        ['date','<=', $KindergardenEnd],
                        ['date', '>=', $KindergardenStart],
                        ['userid', $user->id]
                    ])
                    ->sum('usedtime');

                $file = fopen('php://output', 'w');
                //fputcsv($file, $columns,';');
                $row['Elternteil']  = $user->name;
                $row['Zeiten']      = \App\Http\Controllers\Controller::getMinutesToTime($ActKindergardenYearPerParent,false);
                fputcsv($file, array($row['Elternteil'], $row['Zeiten']),';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function kindergardenYear() {
        $actDateTime 	    = date('Y-m-d H:i:s');
        if (date('m') >= 8 ) {
            $KindergardenStart  = date('Y-08-01');
            $KindergardenEnd    = date('Y-07-31',strtotime('+1 year'));
        } else {
            $KindergardenStart  = date('Y-08-01',strtotime('-1 year'));
            $KindergardenEnd    = date('Y-07-31');
        }

        $ActKindergardenYear    = bookedTimes::query()
            ->join('time_categories','time_categories.id','=','booked_times.catid')
            ->join('users','users.id','=','booked_times.userid')
            ->select('booked_times.*', 'time_categories.name as catname','users.name')
            ->where([
                ['date','<=', $KindergardenEnd],
                ['date', '>=', $KindergardenStart]
            ])
            ->orderBy('date','asc')
            ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=kindergardenYear.csv", // <- name of file
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];
        $columns = array('Kategorie', 'Titel', 'Zeit', 'Beschreibung', 'Datum', 'Elternteil');

        $callback = function() use($ActKindergardenYear, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns,';');

            foreach ($ActKindergardenYear as $task) {
                $row['Kategorie']    = $task->catname;
                $row['Titel']        = $task->title;
                $row['Zeit']         = \App\Http\Controllers\Controller::getMinutesToTime($task->usedtime, false);
                $row['Beschreibung'] = $task->description;
                $row['Datum']        = date('d-m-yy', strtotime($task->date));
                $row['Elternteil']   = $task->name;

                fputcsv($file, array($row['Kategorie'], $row['Titel'], $row['Zeit'], $row['Beschreibung'], $row['Datum'], $row['Elternteil']),';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportKindergardenMonth() {
        $actDateTime 	    = date('Y-m-d H:i:s');
        $firstDayOfActMonth = date('Y-m-01', strtotime($actDateTime));

        $ActKindergardenMonth    = bookedTimes::query()
            ->join('time_categories','time_categories.id','=','booked_times.catid')
            ->join('users','users.id','=','booked_times.userid')
            ->select('booked_times.*', 'time_categories.name as catname','users.name')
            ->where([
                ['date','<=', $actDateTime],
                ['date', '>=', $firstDayOfActMonth]
            ])
            ->orderBy('date','asc')
            ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=kindergardenActMonth.csv", // <- name of file
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];
        $columns = array('Kategorie', 'Titel', 'Zeit', 'Beschreibung', 'Datum', 'Elternteil');

        $callback = function() use($ActKindergardenMonth, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns,';');

            foreach ($ActKindergardenMonth as $task) {
                $row['Kategorie']    = $task->catname;
                $row['Titel']        = $task->title;
                $row['Zeit']         = \App\Http\Controllers\Controller::getMinutesToTime($task->usedtime, false);
                $row['Beschreibung'] = $task->description;
                $row['Datum']        = date('d-m-yy', strtotime($task->date));
                $row['Elternteil']   = $task->name;

                fputcsv($file, array($row['Kategorie'], $row['Titel'], $row['Zeit'], $row['Beschreibung'], $row['Datum'], $row['Elternteil']),';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportRange(Request $request) {
        $startDate          = $request->get('startDate');
        $endDate            = $request->get('endDate');
        $exportRange        = false;
        $exportRangeParents = false;

        if ($request->has('exportRange') == true) {
            $exportRange        = true;
        }
        if ($request->has('exportRangeParents') == true) {
            $exportRangeParents = true;
        }


        if ($startDate != '' && $endDate != '' && $exportRangeParents == true) {
            $users                  = User::all();
            $actDateTime 	        = date('Y-m-d H:i:s');

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=kindergardenRangeParentsTime.csv", // <- name of file
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0",
            ];

            $columns = array('Elternteil','Zeiten');

            $callback = function() use($users, $startDate, $endDate,$columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns,';');

                foreach ($users as $user) {
                    $ActKindergardenYearPerParent    = bookedTimes::query()
                        ->where([
                            ['date','<=', $endDate],
                            ['date', '>=', $startDate],
                            ['userid', $user->id]
                        ])
                        ->sum('usedtime');

                    $file = fopen('php://output', 'w');
                    //fputcsv($file, $columns,';');
                    $row['Elternteil']  = $user->name;
                    $row['Zeiten']      = \App\Http\Controllers\Controller::getMinutesToTime($ActKindergardenYearPerParent,false);
                    fputcsv($file, array($row['Elternteil'], $row['Zeiten']),';');
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } elseif ($startDate != '' && $endDate != '' && $exportRange == true) {
            $actDateTime 	    = date('Y-m-d H:i:s');

            $ActKindergardenRange    = bookedTimes::query()
                ->join('time_categories','time_categories.id','=','booked_times.catid')
                ->join('users','users.id','=','booked_times.userid')
                ->select('booked_times.*', 'time_categories.name as catname','users.name')
                ->where([
                    ['date','<=', $endDate],
                    ['date', '>=', $startDate]
                ])
                ->orderBy('date','asc')
                ->get();

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=kindergardenRange.csv", // <- name of file
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0",
            ];
            $columns = array('Kategorie', 'Titel', 'Zeit', 'Beschreibung', 'Datum', 'Elternteil');

            $callback = function() use($ActKindergardenRange, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns,';');

                foreach ($ActKindergardenRange as $task) {
                    $row['Kategorie']    = $task->catname;
                    $row['Titel']        = $task->title;
                    $row['Zeit']         = \App\Http\Controllers\Controller::getMinutesToTime($task->usedtime, false);
                    $row['Beschreibung'] = $task->description;
                    $row['Datum']        = date('d-m-yy', strtotime($task->date));
                    $row['Elternteil']   = $task->name;

                    fputcsv($file, array($row['Kategorie'], $row['Titel'], $row['Zeit'], $row['Beschreibung'], $row['Datum'], $row['Elternteil']),';');
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } else {
            die('uiii2');
            return redirect('export');
        }
        return redirect('export');
    }
}
