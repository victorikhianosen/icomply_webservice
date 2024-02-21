<!DOCTYPE html>
<html>

<head>
    <style>
        .card-dark {
            background-color: #333;
            color: #fff;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="">
        <div class="">
            <div class="row card-body px-3">
                <div class="col">
                    <div class="mb-2">
                        <img src="http://139.59.186.114/icomply_webservice/public/allfiles/Fkpkq5xyDmglUjE8WcLQlxVVGgp1fD7gXBGZSLkj.png"
                            alt="" class="img-fluid img-responsive" width="170">
                    </div>
                    <div class="mt-5"><b>Alert Id</b>: {{ucwords($report['exceptionName'])}} </div>
                    <p class="mt-4"><b>Narration</b> : {{ucwords($report['Narration'])}}</p>
                    <table class="table table-striped table-hover table-responsive table-bordered mt-1">
                        <thead>
                            <tr>
                                @foreach ($report['validResults'][0][0] as $key => $value)
                                @php
                                $columnNames = [
                                'old_name' => 'new name',
                                'amount_lcy'=>'amount',
                                'account_officer'=>'account officer id',
                                'trans_reference'=>'transaction reference',
                                'curr_no'=>'currency number',
                                'contract_bal_id'=>'contract balance id',
                                'prodccy'=>'currency code',
                                'account_title_1'=>'account title',
                                'charge_ccy'=>'charge currency',
                                'interest_ccy'=>'interest currency',
                                'alt_account_type'=>'account type',
                                'dept_code'=>'department code',
                                ''=>'',
                                ''=>'',
                                ''=>'',
                                ''=>'',
                                ''=>'',
                                ''=>'',
                                ''=>'',

                                // Add more column mappings here
                                ];
                                $newColumnName = $columnNames[$key] ?? $key;
                                @endphp
                                <th scope="col" class="text-danger">{{ ucwords($newColumnName) }}</th>
                                {{-- <th scope="col" class="text-danger">{{ ucwords($key)}}</th> --}}
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($report['validResults'][0] as $row)
                            <tr>
                                @foreach ($row as $key => $value)
                                @php
                                if (in_array($key, ['amount_lcy', 'amt_lcy',]) && is_numeric($value)) {
                                $formattedValue = number_format((float) $value, 2);
                                }
                    
                                elseif (in_array($key, ['opening_date', 'date_last_updated']) && preg_match('/^\d{8}$/', $value)) {
                                $date = DateTime::createFromFormat('Ymd', $value);
                                if ($date) { // Ensure $date creation was successful
                                $formattedValue = $date->format('d-M-Y');
                                }
                                }
                                elseif (in_array($key, ['date_time', ]) && is_numeric($value)) {
                                $formattedValue = date('d-M-Y H:i:s', $value);
                                }
                                elseif (in_array($key, ['time_last_sign_on']) && is_numeric($value)) {
                                $formattedValue = date('H:i:s', strtotime($value));
                                }
                                elseif (in_array($key, ['start_time','end_time']) && is_numeric($value)) {
                                $hours = floor($value / 100);
                                $minutes = $value % 100;
                                $formattedValue = sprintf('%d:%02d', $hours, $minutes);
                                } else {
                                $formattedValue = $value;
                                }
                                @endphp
                                <td>{{ $formattedValue }}</td>
                                {{-- <td>{{ $value }}</td> --}}
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>