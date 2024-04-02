<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    

    @for ($i = 1; $i <= 12; $i++)
        <div class="row">
            <div class="col-md-6">
                    <div class="mb-3">{!! DNS1D::getBarcodeHTML($barcode, "C128C") !!}</div>
            </div>
            <br>
            <div class="col-md-6">
                    <div class="mb-3">{!! DNS1D::getBarcodeHTML($barcode, "C128C") !!}</div>
            </div>
            <br>
        </div>
    @endfor
    <!-- <div class="row">
            <div class="col-12 col-sm-6 col-md-4 mb-3">
                <div class="mb-3">{!! DNS1D::getBarcodeHTML($barcode, "C128") !!}</div>
            </div><br>
            <div class="col-12 col-sm-6 col-md-4 mb-3">
                <div class="mb-3">{!! DNS1D::getBarcodeHTML($barcode, "C128A") !!}</div>
            </div><br>
            <div class="col-12 col-sm-6 col-md-4 mb-3">
                <div class="mb-3">{!! DNS1D::getBarcodeHTML($barcode, "C128B") !!}</div>
            </div><br>
            <div class="col-12 col-sm-6 col-md-4 mb-3">
                <div class="mb-3">{!! DNS1D::getBarcodeHTML($barcode, "C128C") !!}</div>
            </div><br>
            <div class="col-12 col-sm-6 col-md-4 mb-3">
                <div class="mb-3">{!! DNS1D::getBarcodeHTML($barcode, "CODE11") !!}</div>
            </div><br>
        </div> -->
</body>
</html>
