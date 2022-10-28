@extends('layouts.app')

@section('content')
<div class="container text-center">
  <a href="{{route('admin.apartments.create')}}" class="btn btn-primary mb-3">Inserisci appartamento</a>
  <div class="row">

    @forelse ($apartments as $apartment)
    <div class="col-12">
      <div class="row border bg-light my-2 p-2">

        {{-- title --}}
        <div class="col-12 text-left mb-2">
          <h2>{{$apartment->descriptive_title}}</h2>
        </div>

        {{-- image --}}
        <div class="col-5 d-flex justify-content-center alig-items-center">
          <img class="img-fluid rounded shadow-sm" src="{{asset('storage/'.$apartment->image)}}" alt="Card image cap">
        </div>

        {{-- description --}}
        
        <div class="col-6 text-left">
            {{-- address --}}
            <div class="address">
              <label for=""><strong>Indirizzo</strong></label>
              <address>{{$apartment->address}}</address>
            </div>
            {{-- square meters --}}
            <div class="square-meters">
              <label for=""><strong>Metri quadri</strong></label>
              <p>{{$apartment->square_meters}}</p>
            </div>
            {{-- services --}}
            <div class="services">
              <label for=""><strong>Servizi</strong></label>
              <div class="d-flex flex-wrap mb-2"> 
                  @forelse ($apartment->services as $service)
                  <span class="mr-2">{{$service->label}}</span> 
                  @empty
                  <li>Nessun servizio</li>
                  @endforelse
              </div>  
            </div>  
              {{-- visible --}}
            <div class="visible">
              <label for=""><strong>Visibile</strong></label>
              <p> {{$apartment->visible == false ? 'Si' : 'No'}} </p>           
            </div>
        </div>

        {{-- buttons --}}
        <div class="col-1 d-flex flex-column align-items-center">
            {{-- show --}}
            <a href="{{route('admin.apartments.show', $apartment)}}" class="btn btn-success w-100 mb-2 py-2 px-2" style="font-size: 0.7rem">Vedi</a>
            {{-- edit --}}
            <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-warning w-100 mb-2 py-2 px-2" style="font-size: 0.7rem">Modifica</a>
            {{-- delete --}}
            <form class="delete-form" action="{{route('admin.apartments.destroy', $apartment->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger delete w-100 mb-2 py-2 px-2" style="font-size: 0.7rem" data-toggle="modal" data-target="#exampleModal">
                Elimina
                </button>
                @include('includes.admin.apartments.modal')
            </form>
            {{-- messages --}}
            {{-- <a href="{{route('admin.apartments.messages.index', $apartment)}}" class="btn btn-primary w-50 mb-2">Messaggi</a> --}}
        </div>
        
      </div>
    </div>

    @empty
    <h1 class="display-1">Nessun Appartamento in tuo possesso</h1>
    @endforelse

  </div>
</div>

@endsection