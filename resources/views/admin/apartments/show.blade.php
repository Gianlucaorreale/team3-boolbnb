@extends('layouts.app')
@section('content')
    <div class="container">
      <div class="card" style="width: 35rem;">
        <img class="card-img-top" src="{{$apartment->image}}" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title">{{$apartment->descriptive_title}}</h5>
          <p class="card-text">{{$apartment->address}}</p>
          @forelse ($apartment->services as $service)
              <span>{{$service->label}} , </span>
          @empty
              
          <span>Nessun servizio</span>
          @endforelse
          <a class="btn btn-primary" href="{{route('admin.apartments.index')}}">Torna indietro</a>
        </div>
      </div>
    </div>
@endsection