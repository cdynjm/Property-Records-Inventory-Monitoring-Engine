<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRIME ({{ $title ?? 'ICS Form' }})</title>

    <link rel="icon" href="{{ asset('/img/PRIME.png') }}" sizes="any">

    <style>
        .page-form {
            max-width: 100%;
            min-width: 800px;
            overflow-x: auto;
        }

        .header {
            text-align: center;
        }

        .header p {
            margin: 5px;
        }

        .office {
            text-align: center
        }

        .office h4 {
            margin: 10px
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr th {
            border: 1px solid black;
        }

        table tr td {
            border: 1px solid black;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            @page {
                size: portrait;
                margin: 50px 30px 30px;
            }
        }
    </style>
</head>

<body>

    <div class="no-print" style="margin-bottom: 20px; display: flex; gap: 10px;">
        <button onclick="history.back()"
            style="background-color: #f1f1f1; border: 1px solid #ccc; padding: 8px 16px; border-radius: 5px; cursor: pointer; font-size: 12px;">
            Back
        </button>

        <button onclick="window.print()"
            style="background-color: #54aa7a; color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; font-size: 12px;">
            Print Form
        </button>
    </div>

    <div class="page-form">
        <div class="header">
            <p>Republic of the Philippines</p>
            <p>PROVINCE OF SOUTHERN LEYTE</p>
            <p>Maasin City</p>
        </div>

        <div class="office">
            <h4>OFFICE OF THE PROVINCIAL GENERAL SERVICES</h4>
        </div>

        <div class="table">
            <table>
                <tr>
                    <th colspan="10">
                        <h4 style="margin: 0;">INVENTORY CUSTODIAN SLIP</h4>
                    </th>
                </tr>
                <tr>
                    <td colspan="10" style="text-align: right;">
                        <span style="margin-right: 100px;">ICS No.: {{ $ics->icsNumber }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">QTY.</td>
                    <td style="text-align: center">UNIT</td>
                    <td style="text-align: center" width="30%">DESCRIPTION</td>

                    <td style="text-align: center; padding:0;">
                        <div style="border-bottom:1px solid black; padding:2px 0;">Office</div>
                        <div style="padding:2px 0;">Code</div>
                    </td>

                    <td style="text-align: center; padding:0;">
                        <div style="border-bottom:1px solid black; padding:2px 0;">Inv. Item</div>
                        <div style="padding:2px 0;">No.</div>
                    </td>

                    <td style="text-align: center; padding:0;">
                        <div style="border-bottom:1px solid black; padding:2px 0;">Date</div>
                        <div style="padding:2px 0;">Acquired</div>
                    </td>

                    <td style="text-align: center; padding:0;">
                        <div style="border-bottom:1px solid black; padding:2px 0; font-size: 13px">Est. Useful</div>
                        <div style="padding:2px 0; font-size: 13px;">Life</div>
                    </td>

                    <td style="text-align: center;">Unit Cost</td>
                </tr>

                @php
                    $totalRows = 15;
                    $filledRows = $ics->information->count();
                @endphp

                @foreach ($ics->information as $icsInfo)
                    <tr>
                        <td style="text-align: center;">{{ $icsInfo->quantity }}</td>
                        <td style="text-align: center;">{{ $icsInfo->unit }}</td>
                        <td style="text-align: left;">{!! nl2br(e($icsInfo->description)) !!}</td>
                        <td style="text-align: center;">{{ $icsInfo->officeCode }}</td>
                        <td style="text-align: center;">{{ $icsInfo->invItemNumber }}</td>
                        <td style="text-align: center;">{{ date('n/j/Y', strtotime($icsInfo->dateAcquired)) }}</td>
                        <td style="text-align: center;">{{ $icsInfo->estUsefulLife }}</td>
                        <td style="text-align: center;">{{ number_format($icsInfo->unitCost, 2) }}</td>
                    </tr>
                @endforeach

                @for ($i = $filledRows; $i < $totalRows; $i++)
                    <tr>
                        <td style="text-align: center;">&nbsp;</td>
                        <td style="text-align: center;">&nbsp;</td>
                        <td style="text-align: left;">&nbsp;</td>
                        <td style="text-align: center;">&nbsp;</td>
                        <td style="text-align: center;">&nbsp;</td>
                        <td style="text-align: center;">&nbsp;</td>
                        <td style="text-align: center;">&nbsp;</td>
                        <td style="text-align: center;">&nbsp;</td>
                    </tr>
                @endfor
                <tr>
                    <td colspan="3">
                        <div style="font-style: italic">Received by:</div>
                        <div style="text-align: center; margin-top: 20px;">

                            <h4
                                style="margin: 0; {{ $ics->receivedBy != null ? 'color: black;' : 'color: transparent;' }}">
                                {{ $ics->receivedBy != null ? $ics->receivedBy : 'PERSON' }}</h4>
                            <div
                                style="flex: 1; border-bottom: 1px solid rgb(46, 46, 46); text-align: center; max-width: 70%; margin: 5px auto;">
                            </div>
                            <div style="font-style: italic; margin-bottom: 10px;">(Signature Over Printed Name)</div>

                            <h5
                                style="margin: 0; {{ $ics->receivedByPosition != null ? 'color: black;' : 'color: transparent;' }}">
                                {{ $ics->receivedByPosition != null ? $ics->receivedByPosition : 'POSITION' }}</h5>
                            <div
                                style="flex: 1; border-bottom: 1px solid rgb(46, 46, 46); text-align: center; max-width: 70%; margin: 5px auto;">
                            </div>
                            <div style="font-style: italic; margin-bottom: 10px;">Position/Office</div>

                            <h5
                                style="margin: 0; {{ $ics->dateReceivedBy != null ? 'color: black;' : 'color: transparent;' }}">
                                {{ $ics->dateReceivedBy != null ? date('n/j/Y', strtotime($ics->dateReceivedBy)) : 'DATE' }}
                            </h5>
                            <div
                                style="flex: 1; border-bottom: 1px solid rgb(46, 46, 46); text-align: center; max-width: 70%; margin: 5px auto;">
                            </div>
                            <div style="font-style: italic; margin-bottom: 20px;">Date</div>
                        </div>

                    </td>
                    <td colspan="5">
                        <div style="font-style: italic">Received from:</div>
                        <div style="text-align: center; margin-top: 20px;">

                            <h4 style="margin: 0;">{{ $ics->receivedFrom->name }}</h4>
                            <div
                                style="flex: 1; border-bottom: 1px solid rgb(46, 46, 46); text-align: center; max-width: 70%; margin: 5px auto;">
                            </div>
                            <div style="font-style: italic; margin-bottom: 10px;">
                                (Signature Over Printed Name)</div>

                            <h5 style="margin: 0;">{{ $ics->receivedFromPosition }}</h5>
                            <div
                                style="flex: 1; border-bottom: 1px solid rgb(46, 46, 46); text-align: center; max-width: 70%; margin: 5px auto;">
                            </div>
                            <div style="font-style: italic; margin-bottom: 10px;">
                                Position/Office</div>

                            <h5 style="margin: 0;">{{ date('n/j/Y', strtotime($ics->dateReceivedFrom)) }}</h5>
                            <div
                                style="flex: 1; border-bottom: 1px solid rgb(46, 46, 46); text-align: center; max-width: 70%; margin: 5px auto;">
                            </div>
                            <div style="font-style: italic; margin-bottom: 20px;">Date</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
