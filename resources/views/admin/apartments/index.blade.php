@extends('layouts.app')

@section('content')
  <div class="container text-center">
    <a href="{{route('admin.apartments.create')}}" class="btn btn-primary">Crea</a>
    <div class="row p-5">
      @forelse ($apartments as $apartment)
      <div class="col">
        <div class="card" style="width: 18rem;">
          <img class="card-img-top" src="{{asset('storage/'.$apartment->image)}}" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">{{$apartment->descriptive_title}}</h5>
            <p class="card-text">{{$apartment->address}}</p>
            @forelse ($apartment->services as $service)
                <span>{{$service->label}} , </span>
            @empty
                
            <span>Nessun servizio</span>
            @endforelse
            <br>
            <div class="row my-3">
              <div class="col">
                <a href="{{route('admin.apartments.show', $apartment)}}" class="btn btn-primary">Show</a>
              </div>
              <div class="col">
                <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-warning">Edit</a>
              </div>
              <div class="col">
                <form action="{{route('admin.apartments.destroy', $apartment->id)}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      @empty
      <h1 class="display-1">Nessun Appartamento in tuo possesso</h1>
      @endforelse
    </div>
  </div>
@endsection