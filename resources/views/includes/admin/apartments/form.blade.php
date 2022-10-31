@if($errors->any())
<div class="alert alert-danger" role="alert">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
  </ul>
</div>
@endif
@if($apartment->exists)
  <form action="{{route('admin.apartments.update', $apartment)}}" method="POST" enctype="multipart/form-data">
  @method('PUT')
@else
  <form action="{{route('admin.apartments.store')}}" method="POST" enctype="multipart/form-data">
@endif
    @csrf
    {{-- descriptive_title --}}
    <div class="form-group">
      <label for="descriptive_title">Titolo Descrittivo:<span class="text-danger"> *</span></label>
      <textarea class="form-control" id="descriptive_title" name="descriptive_title" rows="4" minlength="4" maxlength="255" required>
        {{old('descriptive_title', $apartment->descriptive_title)}}
      </textarea>
    </div>
    <div class="row">
      {{-- num_rooms --}}
      <div class="col">
        <div class="form-group">
          <label for="num_rooms">Numero Stanze:<span class="text-danger"> *</span></label>
          <input type="number" class="form-control" value="{{old('num_rooms', $apartment->num_rooms)}}" name="num_rooms" id="num_rooms" min="1" max="255" required value="1">
        </div>
      </div>
      {{-- num_bathroom --}}
      <div class="col">
        <div class="form-group">
          <label for="num_bathroom">Numero Bagni:<span class="text-danger"> *</span></label>
          <input type="number" class="form-control" value="{{old('num_bathroom', $apartment->num_bathroom)}}" name="num_bathroom" id="num_bathroom" min="1" max="255" required value="1">
        </div>
      </div>
      {{-- num_bed --}}
      <div class="col">
        <div class="form-group">
          <label for="num_bed">Numero Letti:<span class="text-danger"> *</span></label>
          <input type="number" class="form-control" value="{{old('num_bed', $apartment->num_bed)}}" name="num_bed" id="num_bed" min="1" max="255" required value="1">
        </div>
      </div>
      {{-- square_meters --}}
      <div class="col">
        <div class="form-group">
          <label for="square_meters">Metri Quadri:<span class="text-danger"> *</span></label>
          <input type="number" class="form-control" value="{{old('square_meters', $apartment->square_meters)}}" name="square_meters" id="square_meters" min="5" required value="1">
        </div>
      </div>
    </div>
    {{-- address --}}
    <div class="form-group">
      <label for="address">Indirizzo:<span class="text-danger"> *</span></label>
      <div id="address-tomtom">   
      </div>
      <input id="lat" type="text" class="form-control" name="latitude" id="lat" value="{{old('latitude', $apartment->latitude)}}" hidden>
      <input id="lon" type="text" class="form-control" name="longitude" id="lon" value="{{old('longitude', $apartment->longitude)}}" hidden>
    </div>
    {{-- services --}}
    <label for="services">Servizi:</label>
    <div class="form-group" id="services">
      <div class="form-check">
        <div class="row row-cols-3 row-cols-md-6">
          @foreach ($services as $service)
          <div class="col">
            <input class="form-check-input" 
                @if (in_array($service->id, old('services_array', $services_ids))) checked @endif 
                type="checkbox" id="{{$service->label}}" 
                name="services_array[]" value="{{$service->id}}">
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
      <div class="row">
        <div class="col-8">
          <label for="image">Carica un'immagine:<span class="text-danger"> *</span></label>
          <input type="file" class="form-control" name="image" id="image-field" placeholder="https://example.com/" size="30" @if(!$apartment->image) required @endif>
        </div>
        <div class="col-4">
          <img id="preview" class="img-fluid" src="{{$apartment->image ? asset('storage/'.$apartment->image) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png?20200912122019'}}" alt="apartment-image-preview">
        </div>
      </div>
    </div>
    <div>
    </div>
    {{-- visibility --}}
    <div class="form-group">
      <div class="form-check">
        <input @if((old('visibility', $apartment->visibility))) checked @endif 
        class="form-check-input" type="checkbox" id="visibility" name="visibility" value="1">
        <label class="form-check-label" for="visibility">
          Visibile
        </label>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Salva</button>
    <a class="btn btn-secondary" href="{{route('admin.apartments.index')}}">Torna indietro</a>
    <script>
      var options = {
          searchOptions: {
              key: 'k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA',
              language: 'it-IT',
              limit: 10,
          },
          autocompleteOptions: {
              key: 'k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA',
              language: 'it-IT',
          }
      };
      const latInput = document.getElementById('lat');
      const lonInput = document.getElementById('lon');
      const addressContainer = document.getElementById('address-tomtom')
      var ttSearchBox = new tt.plugins.SearchBox(tt.services, options);
      var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
      addressContainer.append(searchBoxHTML);
      const tomtomInput = document.getElementsByClassName("tt-search-box-input")[0];

      let date = {}
      ttSearchBox.on('tomtom.searchbox.resultsfound', function(data) {
        date = (data);
        let position = date.data.results.fuzzySearch.results[0].position;
        let lon = position.lng;
        let lat = position.lat;
        latInput.value = lat;
        lonInput.value = lon;
      });
      tomtomInput.setAttribute("name","address");
      tomtomInput.setAttribute("type","search");
      tomtomInput.value = '<?php echo $apartment->address ?>';
  </script>
  </form>