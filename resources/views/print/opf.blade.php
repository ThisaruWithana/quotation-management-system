<!DOCTYPE html>
<html>
<head>
    <title>Quotation and Order Contract</title>
    <style>
      #height-container { position: absolute; left: 0px; right: 0px; top: 0px; width: 100%;}
    </style>
</head>

<body>
    <div id="height-container">
        <table>
            <tbody>
            <tr>
                <td>
                    <table style="margin:0;width:100%;max-width:1024px;font-family:Segoe UI; border-collapse: collapse;border-spacing: 0;background: #ffffff">
                        <tbody>
                        <!--Header-->

                        <tr>
                            <td style="width:100%; font-size:11px; padding:5px 20px 0px;text-align: center;color: #572682;font-weight: bold;font-style:italic">
                                <table style="width:100%;margin: auto;padding: 0px;border-radius: 6px;border-collapse: collapse;">
                                    <tbody>

                                    <td style="text-align: left;font-size: 10px;color:#393939;padding:5px 8px;width: 100%;vertical-align: top;border-bottom: 1px solid #000000 ">
                                        <table style="float: right">
                                            <tbody style="font-size: 11px">
                                            <tr>
                                                <td><p style="margin-top: -15px">Generated On {{ date('d/m/Y', strtotime($opf->created_at)) }} Page 1 of 1</p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:100%; padding:0px 20px 0px;text-align: center;">
                                <table style="width:100%;margin: auto;padding: 0px;border-radius: 6px;border-collapse: collapse;">
                                    <tbody>
                                    <tr style="text-align: center;font-size: 20px;color:#393939;padding:5px 8px;width: 100%;vertical-align: top;border-bottom: 1px solid #000000 ;background: #ddd">
                                        <td colspan="1" style="border-left: 1px solid #000000;border-right: 1px solid #000000">
                                            ORDER PROCESSING FORM REPORT
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:100%; font-size:11px; padding:0px 20px 0px;text-align: center;color: #572682;font-weight: bold;font-style:italic">
                                <table style="width:100%;margin: auto;padding: 0px;border-radius: 6px;border-collapse: collapse;border-left: 1px solid #000;border-right:1px solid #000;background: #f3f3f3">
                                    <tbody>
                                    <tr>
                                        <td style="text-align: right;font-size: 10px;color:#393939;padding:5px 8px;width: 33.3%; ">
                                            <table>
                                                <tbody style="font-size: 13px">
                                                <tr>
                                                    <td>
                                                        <p style="margin: 0px"><strong style="width: 120px;display: inline-block">OPF Code :</strong>
                                                        6193-2-240328</p>
                                                        <p style="margin: 0px"><strong style="width: 120px;display: inline-block">OPF Date  :</strong>
                                                            {{ date('d-m-Y', strtotime($opf->created_at)) }}</p>
                                                        <p style="margin: 0px"><strong style="width: 120px;display: inline-block">Client :</strong>
                                                            {{ $opf['quotation']['customer']['name'] }}</p>
                                                        <p style="margin: 0px"><strong style="width: 120px;display: inline-block">Quot. Date :</strong>
                                                        {{ date('d-m-Y', strtotime($opf->quotation->created_at)) }}</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>


                                        <td style="text-align: left;font-size: 10px;color:#393939;padding:5px 8px;width: 33.3%;vertical-align: top; ">
                                            <table style="float: left">
                                                <tbody style="font-size: 13px">
                                                <tr>
                                                    <td><p style="margin: 0px"><strong style="width: 120px;display: inline-block">Created By  :</strong> {{ $opf['created_user']['name'] }}</p>
                                                        <p style="margin: 0px"><strong style="width: 120px;display: inline-block">Symbol Group :</strong> {{ $opf->symbol_group }}</p>
                                                        <p style="margin: 0px"><strong style="width: 120px;display: inline-block">Installation Date :</strong> @if($opf->installation_date != '') {{ date('d-m-Y', strtotime($opf->installation_date)) }} @endif</p>
                                                        <p style="margin: 0px"><strong style="width: 120px;display: inline-block">OPF Price :</strong> £{{ number_format($price_after_discount, 2) }}</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:100%;  padding:0px 20px 0px;text-align: center;color: #572682;font-weight: bold;font-style:italic">
                                <table style="width:100%;margin: auto;padding: 0px;border-radius: 6px;border-collapse: collapse;border-left: 1px solid #000;border-right:1px solid #000;background: #f3f3f3">
                                    <tbody>
                                    <tr>
                                        <td style="text-align: right;color:#393939;padding:0px 8px;width: 100%; border-bottom: 1px solid #000;">
                                            <table>
                                                <tbody style="font-size: 13px">
                                                <tr>
                                                    <td>
                                                        <p style="margin: 0px"><strong style="width: 120px;">Maintenace
                                                            From Quote:</strong>
                                                            {{ strip_tags(html_entity_decode($opf->quotation->description)) }}</p>

                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>

                                    </tr>

                                    </tbody>
                                </table>
                            </td>
                        </tr>


                        <tr>
                            <td style="padding: 0px 15px 10px;">
                                <table style="width:100%; padding:0px 0px 30px 0px;background: #ffffff;border-radius: 30px;">
                                    <tbody>

                                    <tr>
                                        <td>
                                            <table style="width: 100%">
                                                <tbody>
                                                <tr>
                                                    <td style="width:100%; font-size:11px; padding:0px 0px 15px;text-align: center;color: #572682;font-weight: bold;font-style:italic">
                                                        <table style="width:100%;margin: auto;padding: 0px;border-radius: 6px;border-collapse: collapse;">
                                                            <tbody>
                                                            <tr>
                                                                <td style="text-align: left;font-size: 10px;color:#030303;padding:0px 0px 5px;width:100%;vertical-align: center; ">
                                                                    <table style="width: 100%;border-collapse: collapse;">
                                                                        <thead style="font-size: 9px;text-align: center;vertical-align: center;">
                                                                        <tr>
                                                                            <th style="border: 1px solid #000;background: #ddd;">
                                                                                Supplier
                                                                            </th>
                                                                            <th style="border: 1px solid #000;background: #ddd;">
                                                                                BarCode
                                                                            </th>
                                                                            <th style="border: 1px solid #000;background: #ddd;">
                                                                                Item Description
                                                                            </th>
                                                                            <th style="border: 1px solid #000;background: #ddd;">
                                                                                Qty
                                                                            </th>
                                                                            <th style="border: 1px solid #000;background: #ddd;">
                                                                                Individual
                                                                                Item Cost
                                                                            </th>
                                                                            <th style="border: 1px solid #000;background: #ddd;">
                                                                                Item
                                                                                Cost
                                                                            </th>
                                                                            <th style="border: 1px solid #000;background: #ddd;">
                                                                                Stock
                                                                            </th>
                                                                            <th style="border: 1px solid #000;background: #ddd;">
                                                                                Order
                                                                                Qty
                                                                            </th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody style="font-size: 9px;text-align: center;">

                                                                        <?php
                                                                            $total_qty = 0;
                                                                            $total_stock = 0;
                                                                            $total_order_qty = 0;
                                                                            $total_cost = 0;
                                                                        ?>
                                                                        @foreach($itemList as $value)
                                                                            <tr>
                                                                                <td style="padding: 10px;border-right: 1px solid #000000;border-left:1px solid #000000 ;border-bottom: 1px solid #000000">
                                                                                    {{ $value['supplier'] }}
                                                                                </td>
                                                                                <td style="padding: 10px;text-align: left;border-right: 1px solid #000000;border-bottom: 1px solid #000000">
                                                                                    {{ $value['barcode'] }}
                                                                                </td>
                                                                                <td style="text-align: right;padding: 4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000">
                                                                                    {{ $value['name'] }}
                                                                                </td>
                                                                                <td style="text-align: right;padding: 4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000">
                                                                                    {{ $value['qty'] }}
                                                                                </td>
                                                                                <td style="text-align: right;padding: 4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000">
                                                                                    {{ number_format($value['item_cost'], 2) }}
                                                                                </td>
                                                                                <td style="text-align: right;padding: 4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000">
                                                                                    {{ number_format($value['total_cost'], 2) }}
                                                                                </td>
                                                                                <td style="text-align: right;padding: 4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000">
                                                                                    {{ $value['in_stock'] }}
                                                                                </td>
                                                                                <td style="text-align: right;padding: 4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000">
                                                                                    {{ $value['order_qty'] }}
                                                                                </td>
                                                                            </tr>

                                                                            <?php 
                                                                                $total_qty = $total_qty + $value['qty'];
                                                                                $total_stock = $total_stock + $value['in_stock'];
                                                                                $total_order_qty = $total_order_qty + $value['order_qty'];
                                                                                $total_cost = $total_cost + $value['total_cost'];
                                                                            ?>
                                                                        @endforeach

                                                                        </tbody>

                                                                        <tfoot style="font-size: 12px;text-align: center;color: #000000">

                                                                        <tr>
                                                                            <td colspan="7"
                                                                                style="text-align: right; padding: 5px 10px; border: 1px solid black;background: #f3f3f3;font-weight: bold">
                                                                                Qty
                                                                            </td>
                                                                            <td style="padding: 5px 10px; border: 1px solid black;text-align: right;background: #f3f3f3;">
                                                                                {{ $total_qty }}
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="7"
                                                                                style="text-align: right; padding: 5px 10px; border: 1px solid black;background: #f3f3f3;font-weight: bold">
                                                                                Stock
                                                                            </td>
                                                                            <td style="padding: 5px 10px; border: 1px solid black;text-align: right;background: #f3f3f3;">
                                                                                {{ $total_stock }}
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="7"
                                                                                style="text-align: right; padding: 5px 10px; border: 1px solid black;background: #f3f3f3;font-weight: bold">
                                                                                Order Qty
                                                                            </td>
                                                                            <td style="padding: 5px 10px; border: 1px solid black;text-align: right;background: #f3f3f3;">
                                                                                {{ $total_order_qty }}
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="7"
                                                                                style="text-align: right; padding:5px 10px; border: 1px solid black;background: #f3f3f3;font-weight: bold">
                                                                                Item Cost
                                                                            </td>
                                                                            <td style="padding:5px 10px; border: 1px solid black;text-align: right;background: #f3f3f3;">
                                                                                £{{ number_format($total_cost, 2) }}
                                                                            </td>
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                            <td colspan="7"
                                                                                style="text-align: right; padding:5px 10px; border: 1px solid black;background: #f3f3f3;font-weight: bold">
                                                                                Total
                                                                            </td>
                                                                            <td style="padding:5px 10px; border: 1px solid black;text-align: right;background: #f3f3f3;">
                                                                                £{{ number_format($total_cost, 2) }}
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="7"
                                                                                style="text-align: right; padding: 5px 10px; border: 1px solid black;background: #f3f3f3;font-weight: bold">
                                                                                Gross Profit
                                                                            </td>
                                                                            <td style="padding: 5px 10px; border: 1px solid black;text-align: right;background: #f3f3f3;">
                                                                                £{{ number_format($price_after_discount - $total_cost, 2) }}
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="7"
                                                                                style="text-align: right; padding: 5px 10px; border: 1px solid black;background: #f3f3f3;font-weight: bold">
                                                                                Margin %
                                                                            </td>
                                                                            <td style="padding:5px 10px; border: 1px solid black;text-align: right;background: #f3f3f3;">
                                                                                {{ number_format($opf->margin, 2) }}
                                                                            </td>
                                                                        </tr>


                                                                        </tfoot>


                                                                    </table>
                                                                </td>
                                                            </tr>

                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>


                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
            </tbody>
        </table>
    </div>

</body>

</html>