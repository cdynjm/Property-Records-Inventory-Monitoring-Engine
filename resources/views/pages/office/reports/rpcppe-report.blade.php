<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRIME ({{ $title ?? 'RPCPPE' }})</title>

    <link rel="icon" href="{{ asset('/img/prime.png') }}" sizes="any">

    <style>
        .page-form {
            max-width: 100%;
            min-width: 800px;
            overflow-x: auto;
        }

        .header {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead tr th {
            border: 1px solid black;
        }

        table tr td {
            border: 1px solid black;
            padding: 5px;
            font-size: 12px;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            @page {
                size: legal landscape;
                margin: 25px;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="margin-bottom: 20px; display: flex; gap: 10px;">
        <button onclick="window.print()"
            style="background-color: #54aa7a; color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; font-size: 12px;">
            Print Report
        </button>
    </div>

    <div class="page-form">
        <div class="header">
            <h5 style="margin-bottom: 10px;">REPORT ON THE PHYSICAL COUNT OF PROPERTY, PLANT AND EQUIPMENT</h5>
        </div>

        <div style="text-align: center; font-size: 12px; margin-bottom: 10px;">
            As of {{ strtoupper(date('F Y')) }}
        </div>

        <div style="text-align: center; font-size: 12px; margin-bottom: 10px;">
            Year {{ session('rpcppe-year') != '' ? session('rpcppe-year') : date('Y')  }}
            {{ session('accounts-code-description') != '' ? '| ' . session('accounts-code-description') : '' }}
            {{ session('office-name') != '' ? '| ' . session('office-name') : '' }}
        </div>

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <td style="text-align: center">ARTICLE <br> NO.</td>
                        <td style="text-align: center">ITEM DESCRIPTION</td>
                        <td style="text-align: center">NEW PROPERTY NUMBER</td>
                        <td style="text-align: center">UNIT <br> MEASURE</td>
                        <td style="text-align: center">UNIT VALUE</td>
                        <td style="text-align: center">ACCOUNTABLE OFFICER</td>
                        <td style="text-align: center">DATE ACQUIRED</td>
                        <td style="text-align: center">REMARKS</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($are as $index => $ar)
                        @foreach ($ar->information as $infoIndex => $areInfo)
                            <tr>
                                @if ($infoIndex === 0)
                                    <td style="text-align: center">{{ $index + 1 }}</td>
                                @endif

                                <td
                                    style="max-width: 500px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $areInfo->description }}
                                </td>

                                <td style="text-align: center; white-space: nowrap">{{ $areInfo->propertyNumber }}</td>
                                <td style="text-align: center">{{ $areInfo->unit }}</td>
                                <td style="text-align: center">{{ number_format($areInfo->unitCost, 2) }}</td>

                                @if ($infoIndex === 0)
                                    <td style="text-align: center">
                                        {{ $ar->receivedBy }}
                                    </td>
                                @endif

                                <td style="text-align: center">
                                    {{ date('m/d/Y', strtotime($areInfo->dateAcquired)) }}
                                </td>

                                @if ($infoIndex === 0)
                                    <td style="text-align: center">
                                        {{ $ar->remarks }}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 1rem;">
                                <p>No data found</p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
