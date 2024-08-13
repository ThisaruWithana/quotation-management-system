<!DOCTYPE html>
<html>
<head>
    <title>Quotation and Order Contract</title>
</head>
<body>

    <div style="margin:5px;">
        <div class="head">
            <table style="width:100%;margin: auto;padding: 0px;border-radius: 6px;border-collapse: collapse;">
                <tbody>
                    <tr>
                        <td style="text-align: left;font-size: 10px;color:#393939;padding:5px 8px;width: 100%;vertical-align: top;">
                            <table style="float: right">
                                <tbody style="font-size: 11px">
                                    <tr>
                                        <td><p style="margin-top: -15px">Generated On {{ $date }}  Page 1 of 1</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="width:100%; font-size:11px; padding:0px 20px 0px;text-align: center;color: #572682;font-weight: bold;font-style:italic">
            <table style="width:100%;margin: auto;padding: 0px;border-radius: 6px;border-collapse: collapse;border-left: 1px solid #000;border-right:1px solid #000; border-top: 1px solid #000000">
                <tbody>
                    <tr>
                        <td style="text-align: right;font-size: 10px;color:#393939;padding:5px 5px;width: 33.3%;">
                            <table>
                                <tbody style="font-size: 11px">
                                    <tr>
                                        <td>
                                            <p style="margin: 0px"><strong>TO</strong></p>
                                            <p style="margin: 0px">{{ $quotation['customer']['name'] }}<br>
                                            {{ $quotation['customer']['contact_person'] }}<br>
                                            {{ $quotation['customer']['address'] }}<br>
                                            {{ $quotation['customer']['postal_code'] }}<br>
                                            Tel: {{ $quotation['customer']['tel'] }}<br>
                                            Email: {{ $quotation['customer']['email'] }}
                                            </p>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </td>

                        <td style="text-align: right;font-size: 10px;color:#393939;width: 33.3%;padding:5px 5px;">
                            <table style="width: 100%;">
                                <tbody style="font-size: 11px">
                                    <tr>
                                        <td style="font-size: 22px;color: #000000;font-weight:600;text-align: center;">
                                            QUOTATION <br>AND <br>ORDER CONTRACT
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>

                        <td style="text-align: left;font-size: 10px;color:#393939;padding:0px 8px;width: 33.3%;vertical-align: top; ">
                            <table style="float: right">
                                <tbody style="font-size: 11px">
                                    <tr>
                                        <td><img style="width: 100%;" src="{{ URL::to('/') }}/images/logo/logo.jpeg"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>

                    </tr>
  
                    <tr>
                        <td style="text-align: right;font-size: 10px;color:#393939;padding:5px 5px;width: 33.3%;" colspan="2">
                            <table>
                                <tbody style="font-size: 11px;font-weight: bold">
                                    <tr>
                                        <td>
                                            <p style="margin-top: 30px"><strong>Quotation Reference :</strong>{{ $ref }}</p>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </td>
                        
                        <td style="text-align: right;font-size: 10px;color:#393939;padding:5px 5px;width: 33.3%;">
                            <table style="float: right">
                                <tbody style="font-size: 11px">
                                    <tr>
                                        <td><p style="margin-top: 30px; margin-left: -100px;"><strong>Date :</strong> {{ date('d/m/Y', strtotime($quotation->created_at)) }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div style="padding: 0px 20px 10px;">

        @if($quotation['retail_print_option'] == 1)
            <table style="width:100%;margin: auto;padding: 0px;border-radius: 6px;border-collapse: collapse;">
                <tbody>
                    <tr>
                        <td style="text-align: left;font-size: 10px;color:#030303;padding:0px 0px 5px;width:100%;vertical-align: center; ">
                            <table style="width: 106%;border-collapse: collapse;">
                                <thead style="font-size: 9px;text-align: center;vertical-align: center;">
                                    <tr>
                                        <th style="border: 1px solid #000;background: #ddd; width:100px;">
                                            Product Code
                                        </th>
                                        <th style="border: 1px solid #000;background: #ddd;">
                                            Description
                                        </th>
                                        <th style="border: 1px solid #000;background: #ddd;">
                                            QTY
                                        </th>
                                        <th style="border: 1px solid #000;background: #ddd;">
                                            RETAIL PRICE
                                        </th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 9px;text-align: center;">
                                                                        
                                    @foreach($quotationItems as $value)

                                        @if($value['display_report'] === 1)
                                            <tr>
                                                <td style="padding: 10px;border-right: 1px solid #000000;border-left:1px solid #000000 ;border-bottom: 1px solid #000000;text-align: left;">
                                                    {{ $value['product_code'] }}
                                                </td>
                                                <td style="padding: 10px;text-align: left;border-right: 1px solid #000000;border-bottom: 1px solid #000000">
                                                    {{ $value['name'] }}
                                                </td>
                                                <td style="text-align: center;padding: 4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000">
                                                    {{ $value['qty'] }}
                                                </td>
                                                <td style="text-align: center;padding: 4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000">
                                                    {{ number_format($value['retail'], 2) }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                        <tr>
                                            <td style="height: 22px; text-align: center;padding: 5px 5px;border: 1px solid #000;background: #ddd;"
                                                colspan="4">
                                                <strong>
                                                    {{ strip_tags(html_entity_decode($quotation['description'])) }}
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height: 70px; text-align: right;padding: 0px 5px;border: 1px solid #000;padding: 10px;"
                                                colspan="4">
                                            </td>
                                        </tr>


                                </tbody>

                                <tfoot style="font-size: 9px;text-align: center;color: #000000; font-weight: bold">

                                    <tr>
                                        <td colspan="3"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            Total Amount
                                        </td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                            £{{ number_format($quotation['price'], 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            DISCOUNT   
                                        </td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                            {{ number_format($quotation['discount'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            Total Amount (After Discount)
                                        </td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                            £{{ number_format(($quotation['price'] - (($quotation['price'] * $quotation['discount']) / 100)), 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            VAT   {{ number_format($quotation['vat_rate'], 2) }}%
                                        </td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                            £{{ number_format($quotation['vat_amt'], 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            Total Amount Inc. VAT
                                        </td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                            £{{ number_format($quotation['final_price'], 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            <strong>Payment terms: Deposit of 60% and
                                                balance by Direct Debit within 7 days of
                                                install.</strong></td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            Balance Due
                                        </td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                            £{{ number_format($quotation['final_price'], 2) }}
                                        </td>
                                    </tr>

                                </tfoot>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size: 12px;">
                            I hereby order the above software/hardware and services for installation
                            at the above store and accept the payment
                            terms. I also accept that the items ordered are none refundable, full or
                            in part as they are specifically ordered for
                            this install.
                        </td>
                    </tr>

                </tbody>
            </table>
        @else
            <table style="width:100%;margin: auto;padding: 0px;border-radius: 6px;border-collapse: collapse;">
                <tbody>
                    <tr>
                        <td style="text-align: left;font-size: 10px;color:#030303;padding:0px 0px 5px;width:100%;vertical-align: center; ">
                            <table style="width: 106%;border-collapse: collapse;">
                                <thead style="font-size: 9px;text-align: center;vertical-align: center;">
                                    <tr>
                                        <th style="border: 1px solid #000;background: #ddd; width:100px;">
                                            Code
                                        </th>
                                        <th style="border: 1px solid #000;background: #ddd;">
                                            Description
                                        </th>
                                        <th style="border: 1px solid #000;background: #ddd;">
                                            QTY
                                        </th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 9px;text-align: center;">
                                                                        
                                    @foreach($quotationItems as $value)

                                        @if($value['display_report'] === 1)
                                            <tr>
                                                <td style="padding: 10px;border-right: 1px solid #000000;border-left:1px solid #000000 ;border-bottom: 1px solid #000000;text-align: left;">
                                                    {{ $value['product_code'] }}
                                                </td>
                                                <td style="padding: 10px;text-align: left;border-right: 1px solid #000000;border-bottom: 1px solid #000000">
                                                    {{ $value['name'] }}
                                                </td>
                                                <td style="text-align: center;padding: 4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000">
                                                    {{ $value['qty'] }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                        <tr>
                                            <td style="height: 22px; text-align: center;padding: 5px 5px;border: 1px solid #000;background: #ddd;"
                                                colspan="3">
                                                <strong>
                                                    {!! strip_tags(html_entity_decode($quotation['description'])) !!}
                                                </strong>
                                               
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height: 70px; text-align: right;padding: 0px 5px;border: 1px solid #000;padding: 10px;"
                                                colspan="3">
                                            </td>
                                        </tr>


                                </tbody>

                                <tfoot style="font-size: 9px;text-align: center;color: #000000; font-weight: bold">

                                    <tr>
                                        <td colspan="2"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            Total Amount
                                        </td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                            £{{ number_format($quotation['price'], 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            DISCOUNT   
                                        </td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                            {{ number_format($quotation['discount'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            Total Amount (After Discount)
                                        </td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                            £{{ number_format(($quotation['price'] - (($quotation['price'] * $quotation['discount']) / 100)), 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            VAT   {{ number_format($quotation['vat_rate'], 2) }}%
                                        </td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                            £{{ number_format($quotation['vat_amt'], 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            Total Amount Inc. VAT
                                        </td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                            £{{ number_format($quotation['final_price'], 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            <strong>Payment terms: Deposit of 60% and
                                                balance by Direct Debit within 7 days of
                                                install.</strong></td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"
                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                            Balance Due
                                        </td>
                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                            £{{ number_format($quotation['final_price'], 2) }}
                                        </td>
                                    </tr>

                                </tfoot>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size: 12px;">
                            I hereby order the above software/hardware and services for installation
                            at the above store and accept the payment
                            terms. I also accept that the items ordered are none refundable, full or
                            in part as they are specifically ordered for
                            this install.
                        </td>
                    </tr>

                </tbody>
            </table>
        @endif
        </div>

        <div style="padding: 0px 10px;">

            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td>
                            <table style="width: 100%">
                                <tbody style="font-size: 13px;text-align: left">
                                    <tr>
                                        <td style="padding: 5px;"> <strong>Client Name:</strong>
                                        </td>
                                        <td style="padding: 5px;">
                                            ________________________________
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;"> <strong>Signature :</strong>
                                        </td>
                                        <td style="padding: 5px;">
                                            ________________________________
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="font-size: 12px;text-align: left;padding: 10px;">
                            <strong>
                                <p style="margin-bottom: 2px">MSP SYSTEMS LTD</p>
                                <p style="margin-bottom: 0px;margin-top: 2px">4 MAYPOLE YARD</p>
                                <p style="margin-bottom: 0px;margin-top: 2px">WEST STREET (BETWEEN 14-16)</p>
                                <p style="margin-bottom: 0px;margin-top: 2px">DUNSTABLE</p>
                                <p style="margin-bottom: 0px;margin-top: 2px">LU6 1XF</p>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-size: 12px;text-align: left;">
                            <strong>
                                <p style="margin-bottom: 2px; margin: left 10px;">Tel:020 89533962</p>
                                <p style="margin-bottom: 0px;margin-top: 2px; margin: left 10px;">Fax:020 89533962</p>
                                <p style="margin-bottom: 0px;margin-top: 2px; margin: left 10px;">Email: admin@msp-group.co.uk</p>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table style="width: 100%">
                                <tbody style="font-size: 13px;text-align: left;">
                                    <tr>
                                        <td style="padding: 5px;" colspan="2"> <strong>FOR MSP SYSTEMS LTD</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px;"> <strong>Name :</strong>
                                        </td>
                                        <td style="padding: 5px;margin-left: -100px;">
                                            {{ $quotation['created_user']['name'] }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="font-size: 12px;text-align: left;padding: 10px;">
                            <strong>
                                <p style="margin-bottom: 0px">Bank :HSBC.Edgware</p>
                                <p style="margin-bottom: 0px;">Account :81500449</p>
                                <p style="margin-bottom: 0px;margin-top: 0px">Sort Code:40-20-16</p>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width:100%;font-weight:600; padding:10px;text-align: left;color:#000000;font-size:12px;font-weight: bold;">
                            Ownership or Title to the product shall not pass on to the buyer until the company has received payment in full. Payment to be made to MSP Systems Ltd. Quotation valid for 28 days
                        </td>
                    </tr>
                    
                   
                </tbody>
            </table>
                
    
        </div>
    
    </div>


</body>

</html>