@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">All Trips</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table">
                      <thead>
                        <th>#</th>
                        <th>Bus</th>
                        <th>Stops</th>
                      </thead>
                      <tbody>
                        @foreach ($trips as $key => $trip)
                          <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $trip->bus->plate_number }}</td>
                            <td>{{ $trip->stops_list }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
