@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create New Reservation</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div></div>
                    <form method="POST" action="{{ route('customer.reservations.store') }}">
                      @csrf
                      <div class="row">
                        <div class="col-md-6">
                          <label for="start_stop_id">Departure</label>
                          <select class="form-control" name="departure_stop_id" id="departure-id">
                            <option value="" disabled selected>Select departure city</option>
                            @foreach ($cities as $id => $city)
                              <option value="{{ $id }}">{{ $city }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label for="start_stop_id">Arrival</label>
                          <select class="form-control" name="arrival_stop_id" id="arrival-id">
                            <option value="" disabled selected>Select arrival city</option>
                            @foreach ($cities as $id => $city)
                              <option value="{{ $id }}">{{ $city }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="row" style="margin-top: 10px">
                        <div class="col-md-6">
                          <button class="btn btn-lg btn-success" type="submit">Create</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
