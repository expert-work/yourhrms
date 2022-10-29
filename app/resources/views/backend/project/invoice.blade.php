<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <meta http-equiv="Content-Type" content="text/html;" />
    <meta charset="UTF-8">
    <link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">
    <style media="all">
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
    <div>

        <div style="background: #eceff4;padding: 1rem;">
            <table>
                <tr>
                    <td>
                        @if (env('FILESYSTEM_DRIVER') == 'server')
                            <img src="{{ Storage::disk('s3')->url(config('settings.app')['company_logo_frontend']) }}"
                                class="hourworx-logo-img" alt="{{ config('app.name') }}" height="30"
                                style="display:inline-block;">
                        @elseif(env('FILESYSTEM_DRIVER') == 'local')
                            <img src="{{ Storage::url(config('settings.app')['company_logo_frontend']) }}"
                                class="hourworx-logo-img" alt="{{ config('app.name') }}" height="30"
                                style="display:inline-block;">
                        @else
                            <img src="{{ Storage::url(config('settings.app')['company_logo_frontend']) }}"
                                class="hourworx-logo-img" alt="{{ config('app.name') }}" height="30"
                                style="display:inline-block;">
                        @endif
                    </td>
                    <td style="font-size: 1.5rem;" class="text-right strong">{{ _trans('INVOICE') }} </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style="font-size: 1rem;" class="strong">{{ config('settings.app.company_name') }}</td>
                    <td class="text-right">#{{ @$data['project']->invoice }}</td>
                </tr>
            </table>

        </div>

        <div style="padding: 1rem;padding-bottom: 0">
            <table>
                <tr>
                    <td class="strong small gry-color">{{ _trans('project.To') }}:</td>
                </tr>
                <tr>
                    <td class="strong">{{ $data['project']->client->name }}</td>
                </tr>
                <tr>
                    <td class="gry-color small">{{ $data['project']->client->address }},
                        {{ @$data['project']->client->city }}, {{ @$data['project']->client->country }}</td>
                </tr>
                <tr>
                    <td class="gry-color small">{{ _trans('Email') }}: {{ $data['project']->client->email }}</td>
                </tr>
                <tr>
                    <td class="gry-color small">{{ _trans('Phone') }}: {{ $data['project']->client->phone }}</td>
                </tr>
            </table>
        </div>

        <div style="padding: 1rem;">
            <table class="padding text-left small border-bottom">
                <thead>
                    <tr class="gry-color" style="background: #eceff4;">
                        <th width="35%">{{ _trans('common.ID') }}</th>
                        <th width="50%" class="text-left">{{ _trans('account.Payment Method') }}</th>
                        <th width="15%" class="text-right">{{ _trans('common.Total') }}</th>
                    </tr>
                </thead>
                <tbody class="strong">
                    @if (@$data['project']->payments)
                        @foreach ($data['project']->payments as $key => $payment)
                            <tr>
                                <td width="20%">{{ $key + 1 }}</td>
                                <td width="50%">{{ $payment->payment_method->name }}</td>
                                <td width="30%" class="text-right">
                                    {{ currency_format(number_format(@$payment->amount, 2)) }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div style="padding:0 1.5rem;">
            <table style="width: 40%;margin-left:auto;" class="text-right sm-padding small strong">
                <tbody>
                    <tr>
                        <th class="gry-color text-left">{{ _trans('common.Total') }}</th>
                        <td class="currency">
                            {{ currency_format(number_format(@$data['project']->amount, 2)) }}
                        </td>
                    </tr>
                    <tr>
                        <th class="gry-color text-left">{{ _trans('common.Total Paid') }}</th>
                        <td class="currency">
                            {{ currency_format(number_format(@$data['project']->paid, 2)) }}
                        </td>
                    </tr>
                    <tr>
                        <th class="text-left strong">{{ _trans('common.Total Due') }}</th>
                        <td class="currency">
                            {{ currency_format(number_format($data['project']->due, 2)) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>
