@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row p-5">
      @forelse ($apartments as $apartment)
      <div class="col">
        <div class="card" style="width: 18rem;">
          <img class="card-img-top" src="{{$apartment->image}}" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">{{$apartment->descriptive_title}}</h5>
            <p class="card-text">{{$apartment->address}}</p>
            @forelse ($apartment->services as $service)
                <span>{{$service->label}} , </span>
            @empty
                
            <span>Nessun servizio</span>
            @endforelse
          </div>
        </div>
      </div>
      @empty
      <h1 class="display-1">Nessun Appartamento in tuo possesso</h1>
      @endforelse
    </div>
  </div>
@endsection