<html>
<head>

</head>
<body>
<div style="display: flex;">
    <h3>ငွေအ၀င်အထွက်စာရင်း</h3>
</div>
<table  bgcolor="#cccccc"  bordercolor="#000000">
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
           <td>{{$transaction->category->name}}</td>
            <td>
                @if($transaction->type==1)
                    <span>၀င်ငွေ</span>
                @else
                    <span>ထွက်ငွေ</span>
                @endif
            </td>
            <td>{{$transaction->amount}}</td>
            <td>{{$transaction->created_at}}</td>
        </tr>
    @endforeach

    </tbody>
</table>

</body>
</html>
