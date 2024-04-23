<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    
        <div class="barcode">
            <p class="name">{{$item}}</p>
            {!! DNS1D::getBarcodeHTML($barcode, "EAN13") !!}
            <p class="pid">{{$barcode}}</p>
        </div>
</body>
</html>
