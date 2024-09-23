<center>
    <table style="width: 100%;background: #F7F5FB;margin: 0 auto;">
        <tbody>
        <tr>
            <td align="center">
                <center>
                    <table style="margin:0 auto;width:100%;max-width:550px;font-family:sans-serif; border-collapse: collapse;border-spacing: 0;">
                        <tbody style="border-bottom: 5px solid #007bff;">
                        <!--Header-->
                        <tr>
                            <td style="padding: 0;">
                                <table style="background:#ededed;width:100%;padding:10px 0px;border-spacing:0;">
                                    <tbody style="border-collapse: collapse;border-spacing: 0;">
                                    <tr>
                                        <td style="width:auto; text-align: center;padding:20px 0px 15px;">
                                            <!-- <img src="{{ URL::to('/') }}/images/logo/logo.jpeg"
                                                 style="width: 70px"> -->
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <table style="width:100%; padding:30px 30px;background: #ffffff">
                                    <tbody>
                                    <tr>
                                        <td style="width:100%;font-weight:500; padding:5px 0px 20px;text-align: center;color:#007bff;font-size:20px;margin: 0px">
                                            Verification Code
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="width:100%; font-size:13px; padding:5px 0px 15px;text-align: left;color: #707070;font-weight: 600;font-style:normal">
                                            Dear <span>{{ $data['name'] }}</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="line-height: 18px; width:100%;font-weight:inherit; font-size:12px;color: #707070; padding:5px 0px 5px;text-align: left;line-height: 18px;">
                                            Please Use <b>{{ $data['otp'] }}</b> for the current login session, this
                                            code will be valid until the user has logged out from the application.
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="line-height:20px;width:100%;font-weight:inherit; font-size:13px;color: #707070; padding:15px 0px 15px;text-align: left;">
                                            Sincerely, <br>
                                            <b>MSP Systems.</b>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <table style="width:100%;padding:0px 10px 10px;font-size: 12px;background:#EDEDED;">
                                    <tbody>
                                    <tr>
                                        <td style="width:100%;font-weight:inherit; font-size:10px;color: #707070; padding:20px 0px 15px;text-align: center;">
                                         
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </center>
            </td>
        </tr>
        </tbody>

    </table>
</center>