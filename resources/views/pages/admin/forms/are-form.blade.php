<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRIME ({{ $title ?? 'ARE Form' }})</title>

    <link rel="icon" href="{{ asset('/img/PRIME.png') }}" sizes="any">

    <style>
        .page-form {
            max-width: 100%;
            min-width: 800px;
            overflow-x: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
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
            <h3 style="margin-bottom: 0">ACKNOWLEDGEMENT RECEIPT FOR EQUIPMENT</h3>
            <p>Provincial Government of Southern Leyte</p>
            <i style="font-size: 12px;">LGU</i>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; width: 100%;">
            <span>Office/Department: {{ $are->areOffice }}</span>
            <span>A.R.E. CONTROL NO.: {{ $are->areControlNumber }}</span>
        </div>

        <div class="table">
            <table>
                <tr>
                    <td style="text-align: center">Qty.</td>
                    <td style="text-align: center">Unit</td>
                    <td style="text-align: center; width:30%; letter-spacing: 3px;">Description</td>

                    <td style="text-align: center; padding:0;">
                        <div style="padding:5px 0;">Property</div>
                        <div style="padding:5px 0;">No.</div>
                    </td>

                    <td style="text-align: center; padding:0;">
                        <div style="padding:5px 0;">Unit</div>
                        <div style="padding:5px 0;">Cost</div>
                    </td>

                    <td style="text-align: center; padding:0;">
                        <div style="padding:5px 0;">Total</div>
                        <div style="padding:5px 0;">Value</div>
                    </td>

                    <td style="text-align: center; padding:0;">
                        <div style="padding:5px 0;">Date</div>
                        <div style="padding:5px 0;">Acquired</div>
                    </td>
                </tr>

                @php
                    $totalRows = 15;
                    $filledRows = $are->information->count();
                @endphp

                @foreach ($are->information as $areInfo)
                    <tr>
                        <td style="text-align: center;">{{ $areInfo->quantity }}</td>
                        <td style="text-align: center;">{{ $areInfo->unit }}</td>
                        <td style="text-align: left;">{!! nl2br(e($areInfo->description)) !!}</td>
                        <td style="text-align: center;">
                            {{ $areInfo->propertyYear }}-{{ $areInfo->propertyCode }}-{{ $areInfo->propertySubCode }}-{{ $areInfo->propertyCount }}-{{ $areInfo->propertyOffice }}
                        </td>
                        <td style="text-align: center;">{{ number_format($areInfo->unitCost, 2) }}</td>
                        <td style="text-align: center;">{{ number_format($areInfo->totalValue, 2) }}</td>
                        <td style="text-align: center;">{{ date('n/j/Y', strtotime($areInfo->dateAcquired)) }}</td>
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
                    </tr>
                @endfor
                <tr>
                    <td colspan="3">
                        <div style="font-style: italic">Received from:</div>
                        <div style="text-align: center; margin-top: 20px;">

                            <h4 style="margin: 0;">{{ $are->receivedFrom->name }}</h4>
                            <div
                                style="flex: 1; border-bottom: 1px solid rgb(46, 46, 46); text-align: center; max-width: 70%; margin: 5px auto;">
                            </div>
                            <div style="font-style: italic; margin-bottom: 10px;">
                                Name</div>
                            <h5 style="margin: 0;">{{ $are->receivedFromPosition }}</h5>
                            <div
                                style="flex: 1; border-bottom: 1px solid rgb(46, 46, 46); text-align: center; max-width: 70%; margin: 5px auto;">
                            </div>
                            <div style="font-style: italic; margin-bottom: 10px;">
                                Position</div>
                            <h5 style="margin: 0;">{{ date('n/j/Y', strtotime($are->dateReceivedFrom)) }}</h5>
                            <div
                                style="flex: 1; border-bottom: 1px solid rgb(46, 46, 46); text-align: center; max-width: 70%; margin: 5px auto;">
                            </div>
                            <div style="font-style: italic; margin-bottom: 20px;">Date</div>
                        </div>
                    </td>

                    <td colspan="5">
                        <div style="font-style: italic">Received by:</div>
                        <div style="text-align: center; margin-top: 20px;">
                            <h4
                                style="margin: 0; {{ $are->receivedBy != null ? 'color: black;' : 'color: transparent;' }}">
                                {{ $are->receivedBy != null ? $are->receivedBy : 'PERSON' }}</h4>
                            <div
                                style="flex: 1; border-bottom: 1px solid rgb(46, 46, 46); text-align: center; max-width: 70%; margin: 5px auto;">
                            </div>
                            <div style="font-style: italic; margin-bottom: 10px;">Name</div>
                            <h5
                                style="margin: 0; {{ $are->receivedByPosition != null ? 'color: black;' : 'color: transparent;' }}">
                                {{ $are->receivedByPosition != null ? $are->receivedByPosition : 'POSITION' }}</h5>
                            <div
                                style="flex: 1; border-bottom: 1px solid rgb(46, 46, 46); text-align: center; max-width: 70%; margin: 5px auto;">
                            </div>
                            <div style="font-style: italic; margin-bottom: 10px;">Position</div>
                            <h5
                                style="margin: 0; {{ $are->dateReceivedBy != null ? 'color: black;' : 'color: transparent;' }}">
                                {{ $are->dateReceivedBy != null ? date('n/j/Y', strtotime($are->dateReceivedBy)) : 'DATE' }}
                            </h5>
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
