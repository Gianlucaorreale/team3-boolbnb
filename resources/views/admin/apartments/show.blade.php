@extends('layouts.app')
@section('content')
    <div class="container bg-light">
      <div class="row">

        {{-- apartment --}}
        <div class="col-12 apartment border rounded shadow bg-white p-4 mb-2">
          <div class="row">
    
            <div class="col-12">
              <h1>{{$apartment->descriptive_title}}</h1>
            </div>
    
            <div class="col-12">
              <address><strong>{{$apartment->address}}</strong></address>
            </div>

            <div class="col-12">
              <p><strong>{{$apartment->square_meters}} mq</strong></p>
            </div>
    
            <div class="col-6">
              <img class="w-100 h-100 rounded shadow" src="{{asset('storage/'.$apartment->image)}}" alt="Card image cap">
            </div>
    
            <div class="col-6 d-flex flex-column justify-content-between">
              <h4>Servizi:</h4>
              <ul class="list-unstyled p-0">
                @forelse ($apartment->services as $service)
                    <li>
                      <i class="{{$service->icon}} mr-2"></i>
                      {{$service->label}}
                    </li>
                @empty
                    
                <span>Nessun servizio</span>
                @endforelse
              </ul>

              <div class="mb-3">
                <h4 class="d-inline mr-2">Visibile:</h4>
                <span> @if($apartment->visibility) Si @else No @endif </span>           
              </div>

              <div>
                <h4 class="d-inline mr-2">Sponsor:</h4>
                <span></span>           
              </div>

              {{-- buttons --}}
              <div class="d-flex justify-content-end mt-3">
                
                {{-- edit --}}
                <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn-secondary p-2 rounded mr-2">Modifica</i></a>
                
                {{-- delete --}}
                <form class="delete-form" action="{{route('admin.apartments.destroy', $apartment->id)}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-secondary delete p-2 w-100 border-0 rounded" data-toggle="modal" data-target="#exampleModal">
                    Elimina
                  </button>
                  @include('includes.admin.apartments.modal')
                </form>
                
                {{-- turn back --}}
                <a class="btn-secondary p-2 rounded ml-2" href="{{route('admin.apartments.index')}}">Torna indietro</a>
              </div>
            </div>

          </div>
        </div>

        {{-- messages --}}
        <div class="col-12 messages p-4 border rounded shadow bg-white mb-2">
          <h1>Messaggi</h1>
        </div>

        {{-- views --}}
        <div class="col-12 views p-4 border rounded shadow bg-white mb-2">
          <h1>Visualizzazioni</h1>
        </div>

      </div>
    </div>
@endsection