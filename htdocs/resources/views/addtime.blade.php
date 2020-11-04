@extends('layouts.app',
    [
            'position' => 'addtime'
    ]
)

@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 pt-3">
    @if ($state === '')
        <h2>Neue Zeiten eintragen</h2>
        <hr>
        @include('addFormula')

    @elseif($state == 'unsafed')
        <h2 class="text-danger"> Es gab einen Fehler. Die Zeit wurde nicht gespeichert!</h2>
        <hr>
        <div class="row">
            <div class="col-12">
                Leider gab es ein Problem beim speichern der getätigten Zeit. Dieses Problem wurde in einem Logfile gespeichert. Bitte kontaktiere Andi - <a href="mailto:info@adelmann-solutions.com">E-Mail schreiben</a>
            </div>
        </div>
    @elseif($state == 'safed')
        <h2 class="text-success">Zeit erfolgreich gespeichert</h2>
        <hr>
        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-lg" href="{{ route('addtime') }}">Weitere Zeiten eintragen</a>
                <a class="btn btn-secondary btn-lg" href="{{ route('owntimes') }}">Zu den eigenen Zeiten</a>
            </div>
        </div>
    @elseif($state == 'edit')
            <h2>Zeit bearbeiten</h2>
            <hr>
            @include('addFormula', array('EditEntry' => $EditEntry))
    @endif
    </main>
@endsection
