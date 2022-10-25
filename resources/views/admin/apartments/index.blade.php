@extends('layouts.app')

@section('content')
<div class="container text-center">
  <a href="{{route('admin.apartments.create')}}" class="btn btn-primary">Crea</a>
  <div class="row p-0">

    @forelse ($apartments as $apartment)
    <div class="col-12">
      <div class="row bg-secondary my-2 rounded">

        <div class="col-4 pl-0">
          <div class="card">
        <img class="card-img-top img-fluid rounded" src="{{asset('storage/'.$apartment->image)}}" alt="Card image cap">
      </div>
    </div>
    <div class="col-8">
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
                <form class="delete-form" action="{{route('admin.apartments.destroy', $apartment->id)}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger delete" data-toggle="modal" data-target="#exampleModal">
                    Delete
                  </button>
                  @include('includes.admin.apartments.modal')
                </form>
              </div>
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