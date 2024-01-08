<html>
<head>

</head>
<body>
<div style="display: grid">
    <h3>
        Transactions List
    </h3>

</div>

<table style="width: 100%"  bgcolor="#cccccc"  bordercolor="#000000">
    <thead>
    <tr>
        <th  bgcolor="#dddddd">အမည်</th>
        <th  bgcolor="#dddddd">အမျိုးအစား</th>
        <th  bgcolor="#dddddd">ပမာဏ</th>
        <th bgcolor="#dddddd">နေ့ရက်</th>
    </tr>
    </thead>
    <tbody>

    @foreach($transactions as $transaction)
        <tr>
           <td style="text-align: center">{{$transaction->category->name}}</td>
            <td style="text-align: center">
                @if($transaction->type==1)
                    <span style="color: green">၀င်ငွေ</span>
                @else
                    <span style="color: red">ထွက်ငွေ</span>
                @endif
            </td>
            <td style="text-align: center">{{$transaction->amount}}</td>
            <td style="text-align: center">{{$transaction->created_at}}</td>
        </tr>
    @endforeach

    </tbody>
</table>

</body>
</html>
