
<!DOCTYPE html>
<html>
<head>
    <title>Quotation and Order Contract</title>
</head>
<body>


<table style="width: 100%; border-collapse: collapse;">
    @foreach($itemList as $index => $value)
        @if($index % 3 == 0)
            <tr style="page-break-inside: avoid;">
                @endif
                <td style="width: 33.33%; padding: 10px; vertical-align: top;">
                    <table style="width: 200px; border-collapse: collapse; page-break-inside: avoid;max-width: 200px">
                        <tr>
                            <td colspan="2" style="padding: 8px; text-align: center; font-weight: bold;">{{ $value['name'] }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 50%;">{{ $value['item_size'] }}</td>
                            <td style="text-align: right; width: 50%;">{{ number_format($value['retail_price'], 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 8px; text-align: center;">
                                {!! DNS1D::getBarcodeHTML($value['barcode']['barcode'], 'EAN13') !!}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">{{ $value['barcode']['barcode'] }}</td>
                        </tr>
                    </table>
                </td>
                @if(($index + 1) % 3 == 0)
            </tr>
            @endif
            @endforeach
            @if(count($itemList) % 3 != 0)
                </tr>
        @endif
</table>




{{--<div style="display: flex; flex-wrap: wrap;">--}}
{{--        @foreach($itemList as $value)--}}
{{--            <table style="width: 200px; float: left">--}}
{{--                <tr style="width: 100%">--}}
{{--                    <td colspan="4" style=" padding: 8px; text-align: center; font-weight: bold;">{{ $value['name'] }}</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td style="text-align: left;width: 50%">{{ $value['item_size'] }}</td>--}}
{{--                    <td style=" text-align: right;width: 50%">{{ number_format($value['retail_price'], 2) }}</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                <td colspan="2" style=" padding: 8px; text-align: center;">--}}
{{--                    {!! DNS1D::getBarcodeHTML($value['barcode']['barcode'], "EAN13") !!}--}}
{{--                </td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td colspan="2" style=" text-align: center;">{{ $value['barcode']['barcode'] }}</td>--}}
{{--                </tr>--}}
{{--            </table>--}}
{{--        @endforeach--}}
{{--</div>--}}
</body>

</html>
