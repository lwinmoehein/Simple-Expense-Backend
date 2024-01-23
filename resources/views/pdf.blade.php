<html>
<head>

</head>
<body>
<div style="color: orangered">
    <h2 style="text-decoration: underline">
        {{$start}} - {{$end}}
    </h2>
</div>

<table style="width: 100%"  bgcolor="#cccccc"  bordercolor="#000000">
    <thead>
    <tr>
        <th  bgcolor="#dddddd">Name</th>
        <th  bgcolor="#dddddd">Category</th>
        <th  bgcolor="#dddddd">Amount</th>
        <th  bgcolor="#dddddd">Note</th>
        <th bgcolor="#dddddd">Date</th>
    </tr>
    </thead>
    <tbody>

    @foreach($transactions as $transaction)
        <tr>
           <td style="text-align: center">{{$transaction->category}}</td>
            <td style="text-align: center">
                @if($transaction->type==="Income")
                    <span style="color: green">Income</span>
                @else
                    <span style="color: red">Expense</span>
                @endif
            </td>
            <td style="text-align: center">{{$transaction->note}}</td>
            <td style="text-align: center">{{$transaction->amount}}</td>
            <td style="text-align: center">{{$transaction->created_at}}</td>
        </tr>
    @endforeach

    </tbody>
</table>

</body>
</html>
