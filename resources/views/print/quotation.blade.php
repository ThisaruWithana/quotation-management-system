<!DOCTYPE html>
<html>
<head>
    <title>Quotation and Order Contract</title>
</head>
<body>
    <table style="">
        <tbody>
        <tr>
            <td>
                <table style=" margin:0 auto;width:100%;max-width:1024px;font-family:Segoe UI; border-collapse: collapse;border-spacing: 0;background: #ffffff">
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
                                            <td><p style="margin-top: -15px">Generated On {{ $date }}  Page 1 of 1</p>
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
                        <td style="width:100%; font-size:11px; padding:0px 20px 0px;text-align: center;color: #572682;font-weight: bold;font-style:italic">
                            <table style="width:100%;margin: auto;padding: 0px;border-radius: 6px;border-collapse: collapse;border-left: 1px solid #000;border-right:1px solid #000">
                                <tbody>
                                <tr>
                                    <td style="text-align: right;font-size: 10px;color:#393939;padding:5px 5px;width: 33.3%;">
                                        <table>
                                            <tbody style="font-size: 11px">
                                            <tr>
                                                <td><p style="margin: 0px"><strong>TO</strong></p>
                                                    <p style="margin: 0px">
                                                        {{ $quotation['customer']['name'] }}<br>
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

                                    <td style="text-align: left;font-size: 10px;color:#393939;padding:5px 8px;width: 33.3%;vertical-align: top; ">
                                        <table style="float: right">
                                            <tbody style="font-size: 11px">
                                            <tr>
                                                <td><img style="width: 100%;" src="{{ URL::to('/') }}/images/logo/logo.jpeg"></td>
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
                        <td style="width:100%; font-size:11px; padding:0px 20px 0px;text-align: center;color: #572682;font-weight: bold;font-style:italic">
                            <table style="width:100%;margin: auto;padding: 0px;border-radius: 6px;border-collapse: collapse;border-left: 1px solid #000;border-right:1px solid #000">
                                <tbody>
                                <tr>
                                    <td style="text-align: right;font-size: 10px;color:#393939;padding:5px 8px;width: 33.3%; ">
                                        <table>
                                            <tbody style="font-size: 11px">
                                            <tr>
                                                <td><p style="margin: 0px"><strong>Quotation Reference :</strong>
                                                    {{ $ref }}</p>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </td>

                                    <td style="text-align: left;font-size: 10px;color:#393939;padding:5px 8px;width: 33.3%;vertical-align: top; ">
                                        <table style="float: right">
                                            <tbody style="font-size: 11px">
                                            <tr>
                                                <td><p style="margin: 0px"><strong>Date :</strong> {{ date('d/m/Y', strtotime($quotation->created_at)) }}</p>
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
                            <table style="width:100%; padding:0px 0px 0px 0px;background: #ffffff;border-radius: 30px;">
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
                                                                        <th style="border: 1px solid #000;background: #ddd; width:100px;">
                                                                            Code
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
                                                                                    {{ $value['id'] }}
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
                                                                        <td style="height: 22px; text-align: right;padding: 0px 5px;border: 1px solid #000;background: #ddd;"
                                                                            colspan="4">
                                                                            SOFTWARE & HARDWARE MAINTENANCE £60.00 + VAT
                                                                            ,PER TILL, PER MONTH,WILL APPLY. .( PAID
                                                                            ANNUALLY IN ADVANCE ) TRANSACTION ONLY (FREE) ON
                                                                            MEDIA SCREEN.
                                                                        </td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td style="height: 70px; text-align: right;padding: 0px 5px;border: 1px solid #000;padding: 10px;"
                                                                            colspan="4">
                                                                        </td>
                                                                    </tr>


                                                                    </tbody>

                                                                    <tfoot style="font-size: 9px;text-align: center;color: #000000">

                                                                    <tr>
                                                                        <td colspan="3"
                                                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                                                            Total Amount Inc. VAT
                                                                        </td>
                                                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                                                            {{ number_format($quotation['price'], 2) }}
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
                                                                            VAT   {{ number_format($quotation['vat_rate'], 2) }}%
                                                                        </td>
                                                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                                                            {{ number_format($quotation['vat_amt'], 2) }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3"
                                                                            style="text-align: right; padding: 10px; border: 1px solid black;background: #ffff80;">
                                                                            Total Amount Inc. VAT
                                                                        </td>
                                                                        <td style="padding: 10px; border: 1px solid black;text-align: right;background: #ffff80;">
                                                                            {{ number_format($quotation['final_price'], 2) }}
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
                                                                            {{ number_format($quotation['final_price'], 2) }}
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

                                            <tr>
                                                <td style="font-size: 12px">
                                                    I hereby order the above software/hardware and services for installation
                                                    at the above store and accept the payment
                                                    terms. I also accept that the items ordered are none refundable, full or
                                                    in part as they are specifically ordered for
                                                    this install.
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding: 0px 20px;">
                                                    <table style="width:100%; padding:0px 0px;background: #ffffff;border-radius: 30px;">
                                                        <tbody>

                                                        <tr>
                                                            <td style="width:100%; font-size:11px; padding:30px 20px 30px;text-align: center;color: #000000;font-weight: bold;font-style:italic">
                                                                <table style="width:100%;margin: auto;padding: 0px;border-radius: 6px;border-collapse: collapse;">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="text-align: center;font-size: 12px;color:#393939;padding:5px 8px;width: 50%;vertical-align: top; ">
                                                                            <table style="width: 100%">
                                                                                <tbody style="font-size: 13px;text-align: right">
                                                                                <tr>
                                                                                    <td style="padding: 10px;"> <strong>Client Name:</strong>
                                                                                        ____________________________________________________
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding: 10px;"> <strong>Signature :</strong>
                                                                                        ____________________________________________________
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>

                                                                            <table style="width: 100%;margin-top: 50px">
                                                                                <tbody style="font-size: 13px;">

                                                                                <tr>
                                                                                    <td style="padding: 10px;"> <strong>FOR MSP SYSTEMS LTD</strong>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding: 10px;text-align: right"> <strong>Name:</strong>
                                                                                        ____________________________________________________
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding: 10px;text-align: right"> <strong>Signature :</strong>
                                                                                        ____________________________________________________
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>


                                                                        <td style="text-align: center;font-size: 12px;color:#393939;padding:5px 8px 5px 50px;width: 50%;vertical-align: top; padding-left: 50px">

                                                                            <table style="width: 100%;">
                                                                                <tbody style="font-size: 13px;">
                                                                                <tr>
                                                                                    <td style="padding: 10px;"> <strong>MSP SYSTEMS LTD
                                                                                    <br>4 MAYPOLE YARD</br>WEST STREET (BETWEEN 14-16)</br>DUNSTABLE

                                                                                    </strong>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding: 10px;font-weight: bold">
                                                                                        <p style="margin-bottom: 0px">Tel:020 89533962</p>
                                                                                        <p style="margin-bottom: 0px;margin-top: 0px">Fax:020 89533962</p>
                                                                                        <p style="margin-bottom: 0px;margin-top: 0px">Email:</p>
                                                                                    </td>
                                                                                </tr>

                                                                                <td style="padding: 10px;font-weight: bold">
                                                                                    <p style="margin-bottom: 0px">Bank :HSBC.Edgware</p>
                                                                                    <p style="margin-bottom: 0px;">Account :81500449</p>
                                                                                    <p style="margin-bottom: 0px;margin-top: 0px">Sort Code:40-20-16</p>
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
                                                            <td style="width:100%;font-weight:600; padding:0px 0px 0px;text-align: left;color:#000000;font-size:12px;font-weight: bold;">
                                                                Ownership or Title to the product shall not pass on to the buyer until the company has received payment in full. Payment to be made to MSP Systems Ltd. Quotation valid for 28 days
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
</body>

</html>