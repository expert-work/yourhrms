<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('settings.app')['company_name'] }} | {{ 'Invoice' }}</title>
    <meta http-equiv="Content-Type" content="text/html;"/>
    <meta charset="UTF-8">
    <style media="all">
        * {
            margin: 0;
            padding: 0;
            line-height: 1.3;
            font-family: "Times New Roman", Times, serif;
            color: #333542;
        }

        body {
            font-size: 0.688rem;
        }

        .gry-color *,
        .gry-color {
            color: #878f9c;
        }

        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table td {
            font-family: 'SolaimanLipi', sans-serif !important;
        }

        table.padding th {
            padding: .25rem .7rem;
        }

        table.padding td {
            padding: .25rem .7rem;
        }

        table.sm-padding td {
            padding: .1rem .7rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 1px solid #eceff4;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<div style="background: #eceff4;padding: 1.5rem;">
    <div style="width: 85%;margin: auto;">
        <table>
            <tr>
                <td>
                    @if(env('FILESYSTEM_DRIVER') == 'server')
                        <img
                            src="{{ Storage::disk('s3')->url(config('settings.app')['company_logo']) }}"
                            height="30"
                            style="display:inline-block;">
                    @elseif(env('FILESYSTEM_DRIVER') == 'local')
                        <img src="{{ asset(Storage::url(config('settings.app')['company_logo'])) }}"
                             height="30"
                             style="display:inline-block;">
                    @else
                        <img src="{{ asset(Storage::url(config('settings.app')['company_logo'])) }}" height="30"
                             style="display:inline-block;">
                    @endif
                </td>
                <td style="font-size: 1.5rem;" class="text-right strong">{{  "INVOICE" }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td class=" small">{{  'Email' }}: support@adgari.com</td>
            </tr>
            <tr>
                <td class=" small">{{  'Phone' }}: 09638303030</td>
                <td class="text-right small"><span class=" small">{{  'Date' }}:</span> <span
                        class=" strong"> {{ $payment->created_at }} </span></td>

            </tr>
        </table>
    </div>
</div>

<div style="width:80%;margin: auto;">
    <table style="margin-top:25px; margin-bottom:25px;">

        <tr>
            <td class="strong"><b>{{ 'Name' }} : </b> {{ @$payment->user->name }}</td>
            <td class="text-right strong"><b>{{ 'Payment Method' }} :</b>
                Bank Payment
            </td>
        </tr>
        <tr>
            <td></td>
            <td class="text-right strong"><b>{{ 'Payment Status' }} :</b>
                @php
                    /*$due=0;
                    $paidAmount=0;
                    $totalAmount=0;
                    $due = $payment->amount - $payment->paid_amount;
                    if ($due == 0){
                        echo 'Paid';
                    }elseif($due < 0){
                        echo 'Advance Paid';
                    }else{
                        echo 'paid';
                    }*/
                @endphp
                {{ $payment->status->name }}
            </td>
        </tr>
    </table>
    <div>
        <table class="padding text-left small border-bottom table-bordered">
            <thead>
            <tr class="" style="background: #eceff4;">
                <th width="35%" class="text-left">{{ 'Month' }}</th>
                <th width="15%" class="text-right">{{ 'Total' }}</th>
            </tr>
            </thead>
            <tbody class="strong">
            <tr>
                <td> {{  date("F", strtotime($payment->payment_date)) }} </td>
                <td class="text-right"> {{ $payment->amount }} Tk</td>
            </tr>
            </tbody>
        </table>

        <div style="width: 98%" class="row">
            <div class="col-xl-5 col-md-6 ">
                <table class="table table-responsive table-bordered">
                    <tbody>
                    <tr>
                        <th>{{ 'Subtotal' }}</th>
                        <td class="text-right">
                            <span class="fw-600">{{ $payment->paid_amount }} TK</span>
                        </td>
                    </tr>

                    <tr>
                        <th>{{ 'Due' }}</th>
                        <td class="text-right">
                            <span class="font-italic"> {{ $payment->due_amount }} TK</span>
                        </td>
                    </tr>

                    <th>{{ 'Total Paid Amount' }}</th>
                    <td class="text-right">
                        <span class="font-italic">{{ $payment->paid_amount }} TK</span>
                    </td>
                    </tbody>
                </table>

            </div>
            <div class="col-md-12">
                <br>
                <br>
                <br>
                <p><b>In Words</b> : <i> {{ numberTowords($payment->paid_amount) }} TAKA</i></p>
            </div>
        </div>
    </div>

</div>
</body>
</html>
