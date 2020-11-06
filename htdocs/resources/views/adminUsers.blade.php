@extends('layouts.app',
    [
            'position' => 'adminuser'
    ]
)

@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 pt-3">
        <h2>Benutzer:</h2>
        <hr>
        <div class="row">
            <div class="col-12">

            </div>
        </div>
        <table class="table table-striped table-grey table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Freigeschaltet</th>
                <th scope="col">Admin</th>
                <th scope="col">Löschen?</th>
            </tr>
            </thead>
            <tbody>

                @foreach($Users as $indexKey=>$User)
                    <tr>
                        <td>{{$User->name}}</td>
                        <td>
                            <a href="{{ route('admintoggleActive', ['userid' => $User->id]) }}" class="btn btn-small btn-sm  @if ($User->active == '1') btn-primary @else btn-danger @endif">
                                @if ($User->active == '1') Aktiv @else Inaktiv @endif
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admintoggleAdmin', ['userid' => $User->id]) }}" class="btn btn-small btn-sm  @if ($User->admin == 'active') btn-primary @else btn-danger @endif">
                                @if ($User->admin == '1') Admin @else User @endif
                            </a>
                        </td>
                        <td>
                            @if ($User->id != 1)
                            <a href="{{ route('adminDeleteUser', ['userid' => $User->id]) }}" class="btn btn-small btn-sm btn-danger">
                                x
                            </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
@endsection
