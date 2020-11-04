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
                <th scope="col">Aktion Toggle</th>
            </tr>
            </thead>
            <tbody>

                @foreach($Users as $indexKey=>$User)
                    <tr>
                        <td>{{$User->name}}</td>
                        <td>@if ($User->active == 'active') Aktiv @else Inaktiv @endif</td>
                        <td>@if ($User->admin == '1') Admin @else Benutzer @endif</td>
                        <td>
                            <a href="" class="btn btn-small btn-sm btn-danger">Admin</a>
                            <a href="" class="btn btn-small btn-sm btn-danger">Admin</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
@endsection
