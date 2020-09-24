@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create New Trip</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div></div>
                    <form method="POST" action="{{ route('dashboard.trips.store') }}">
                      @csrf
                      <div class="row">
                        <div class="col-md-6">
                          <label for="bus_id">Bus</label>
                          <select class="form-control" name="bus_id" id="bus-id">
                            <option value="" disabled selected>Select a bus</option>
                            @foreach ($buses as $id => $plate_number)
                              <option value="{{ $id }}">{{ $plate_number }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <stops-input
                        :cities="{{ json_encode($cities) }}"
                      ></stops-input>
                      <div class="row">
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
