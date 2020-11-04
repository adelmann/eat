@extends('layouts.app',
    [
            'position' => 'home'
    ]
)

@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 pt-3">
        <h2>Übersicht</h2>
        <hr>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <b>Aktuell aufgewendete Zeit:</b>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">Gesammt (Aktuelles Jahr):</div>
                            <div class="col-8"><b>{!! \App\Http\Controllers\Controller::getMinutesToTime($allTime1Year) !!}</b></div>
                        </div>

                        <div class="row">
                            <div class="col-4">Kindergartenjahr:</div>
                            <div class="col-8"><b>{!! \App\Http\Controllers\Controller::getMinutesToTime($actKindergardenYear) !!}</b></div>
                        </div>

                        <div class="row">
                            <div class="col-4">Aktueller Monat</div>
                            <div class="col-8"><b>{!! \App\Http\Controllers\Controller::getMinutesToTime($actMonthTime) !!}</b></div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <b>Letzte Zeitaufwendungen:</b>
                    </div>
                    <div class="card-body">
                        <table class="table" id="bookingOverview">
                            <thead>
                            <th scope="col">Kategorie</th>
                            <th scope="col">Datum</th>
                            <th scope="col">Zeit</th>
                            <th scope="col"></th>
                            </thead>
                            <tbody id="bookingTimes">
                            @foreach($last30Entries as $singleEntry)
                                <tr>
                                    <td>{{$singleEntry->catname}} @if ($singleEntry->title != '') - {{$singleEntry->title}} @endif</td>
                                    <td>{{ date('d-m-yy', strtotime($singleEntry->date)) }}</td>
                                    <td>
                                        {!! \App\Http\Controllers\Controller::getMinutesToTime($singleEntry->usedtime) !!}
                                    </td>
                                    <td><button class="btn btn-sm" type="button" data-toggle="collapse" data-target="#bookedTimes-{{ $loop->index }}" aria-expanded="true" aria-controls="bookedTimes-{{ $loop->index }}">Details</button></td>
                                </tr>
                                <tr id="bookedTimes-{{ $loop->index }}" class="table-active collapse" aria-labelledby="bookingTimes" data-parent="#bookingOverview">
                                    <td colspan="4">
                                        @if ($singleEntry->description != '')
                                            Beschreibung:<br>
                                            {{$singleEntry->description}}<br>
                                            <hr>
                                        @endif
                                        Eingetragen von: {{$singleEntry->name}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
