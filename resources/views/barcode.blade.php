<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Generate Barcode in Laravel 10</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
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
</body>
</html>