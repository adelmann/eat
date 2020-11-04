@extends('layouts.app',
    [
            'position' => 'export'
    ]
)

@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 pt-3">
        <h2>Daten Exportieren</h2>
        <hr>
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <b>Zeitraum:</b>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('exportRange') }}">
                            @csrf
                            <div>
                                Von:
                            <input type="date" class="form-control" name="startDate"><br>
                                Bis:
                            <input type="date" class="form-control" name="endDate">
                            </div><br>
                            <button type="submit" class="btn btn-sm btn-block btn-primary" name="exportRange">Zeiten Download</button>
                            <button type="submit" class="btn btn-sm btn-block btn-primary" name="exportRangeParents">Elternzeiten Download</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <b>Kindergartenjahr:</b>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-primary btn-sm btn-block" href="{{ route('exportKindergardenYear') }}">Zeiten Download</a>
                        <a class="btn btn-primary btn-sm btn-block" href="{{ route('exportKindergardenYearParents') }}">Elternzeiten Download</a>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <b>Monat:</b>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-primary btn-sm btn-block" href="{{ route('exportKindergardenMonth') }}">Zeiten Download</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
