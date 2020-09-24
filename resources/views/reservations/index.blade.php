@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">All Reservations</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table">
                      <thead>
                        <th>#</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                      </thead>
                      <tbody>
                        @foreach ($reservations as $key => $reservation)
                          <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $reservation->departureStop->city->name }}</td>
                            <td>{{ $reservation->arrivalStop->city->name }}</td>
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
