
<meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<x-admin>
    @section('title')  Barcode @endsection
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Barcode</h3>
            <div class="card-tools">
                <a href="{{ route('admin.vat.create') }}" class="btn btn-sm btn-primary">Add</a>
            </div>
        </div>
        <div class="card-body">
        <div class="container mt-3">
        <div class="row">
          <div class="col-12 text-success"><h2>Laravel Barcode Generator Application</h2></div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 mb-3">
                <div class="mb-3">{!! DNS1D::getBarcodeHTML('800897860356465', 'PHARMA') !!}</div>
                <div class="mb-3">{!! DNS1D::getBarcodeHTML('9988776655', 'CODABAR') !!}</div>
                <div class="mb-3">{!! DNS1D::getBarcodeHTML('1234567890', 'UPCA') !!}</div>
                <div class="mb-3">{!! DNS1D::getBarcodeHTML('9988776655', 'CODABAR') !!}</div>
            </div>
        </div>
    </div>

    <h1>UK Postcodes</h1>

<p id="text">Enter a property name or number and postcode.<p>

<input id="number" type="text" value="name/number" onfocus="if(this.value == 'name/number') { this.value = ''; }" />
  
<input id="postcode" type="text" value="postcode" onfocus="if(this.value == 'postcode') { this.value = ''; }" />

<button id="submit">Submit</button>



    </div>
    @section('js')

<script>
	$('#submit').click(function(){  
  
  //Get Postcode
  var number = $('#number').val();
  var postcode = $('#postcode').val().toUpperCase();;
  
  //Get latitude & longitude
  $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + postcode + '&sensor=false&key=AIzaSyB1uKiubSQGwEtp3sFl4n1n-uKR2jEBDRM',  
            function(data) {
                console.log(data);
              var lat = data.results[0].geometry.location.lat;
              var lng = data.results[0].geometry.location.lng;
              
  //Get address    
  $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&sensor=false&key=AIzaSyB1uKiubSQGwEtp3sFl4n1n-uKR2jEBDRM',  
            function(data) {              
              var address = data.results[0].address_components;              
              var street = address[1].long_name;
              var town = address[2].long_name;
              var county = address[3].long_name;                        
  
  //Insert
  $('#text').text(number + ', ' + street + ', ' + town + ', ' + county + ', ' + postcode);
     
    });
  });
});
</script>
    @endsection
</x-admin>

