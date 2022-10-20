<div class="container">
  <form action="{{route('admin.apartments.store')}}" method="POST">
    @csrf
    {{-- descriptive_title --}}
    <div class="form-group">
      <label for="descriptive_title">Titolo Descrittivo:</label>
      <textarea type="text" class="form-control" value="{{old('descriptive_title', $apartment->descriptive_title)}}" id="descriptive_title" name="descriptive_title" rows="4" maxlength="255" required>
      </textarea>
    </div>
    <div class="row">
      {{-- num_rooms --}}
      <div class="col">
        <div class="form-group">
          <label for="num_rooms">Numero Stanze:</label>
          <input type="number" class="form-control" name="num_rooms" id="num_rooms" min="0" max="255" required value="1">
        </div>
      </div>
      {{-- num_bathroom --}}
      <div class="col">
        <div class="form-group">
          <label for="num_bathroom">Numero Bagni:</label>
          <input type="number" class="form-control" name="num_bathroom" id="num_bathroom" min="0" max="255" required value="1">
        </div>
      </div>
      {{-- num_bed --}}
      <div class="col">
        <div class="form-group">
          <label for="num_bed">Numero Letti:</label>
          <input type="number" class="form-control" name="num_bed" id="num_bed" min="0" max="255" required value="1">
        </div>
      </div>
      {{-- square_meters --}}
      <div class="col">
        <div class="form-group">
          <label for="square_meters">Metri Quadri:</label>
          <input type="number" class="form-control" name="square_meters" id="square_meters" min="0" required value="1">
        </div>
      </div>
    </div>
    {{-- address --}}
    <div class="form-group">
      <label for="address">Address</label>
      <input type="text" class="form-control" id="address" name="address" placeholder="Via, Città, Regione, Stato">
    </div>
    {{-- services --}}
    <div class="form-group">
      <div class="form-check">
        <div class="row row-cols-3 row-cols-md-6">
          @foreach ($services as $service)
          <div class="col">
            <input class="form-check-input" type="checkbox" id="{{$service->label}}" name="{{$service->label}}" value="{{$service->id}}">
            <label class="form-check-label" for="{{$service->label}}">
              {{$service->label}}
            </label>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    {{-- image --}}
    <div class="form-group">
      <label for="image">Enter an https:// URL:</label>
      <input type="url" class="form-control" name="image" id="image" placeholder="https://example.com/" size="30" required>
    </div>
    {{-- visibility --}}
    <div class="form-group">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="visibility" name="visibility" value="1">
        <label class="form-check-label" for="visibility">
          Visibile
        </label>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Aggiungi Appartamento</button>
  </form>
</div>