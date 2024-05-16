
<!DOCTYPE html>
<html>
<head>
    <title>Quotation and Order Contract</title>
</head>
<body>
        @foreach($itemList as $value)
            <table style="width: 200px;">
                <tr style="width: 100%">
                    <td colspan="4" style=" padding: 8px; text-align: center; font-weight: bold;">{{ $value['name'] }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;width: 50%">{{ $value['item_size'] }}</td>
                    <td style=" text-align: right;width: 50%">{{ number_format($value['retail_price'], 2) }}</td>
                </tr>
                <tr>
                <td colspan="2" style=" padding: 8px; text-align: center;">
                    {!! DNS1D::getBarcodeHTML($value['barcode']['barcode'], "EAN13") !!}
                </td>
                </tr>
                <tr>
                    <td colspan="2" style=" text-align: center;">{{ $value['barcode']['barcode'] }}</td>
                </tr>
            </table>
        @endforeach

</body>

</html>