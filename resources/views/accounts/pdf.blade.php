<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>
</head>
<body>
<div>
    <table align="center" class="table table-striped">
        <caption>
            <a href="http:\\www.dreamsoftbd.com">
                <img src="{{asset('image/dream.png')}}" alt="Receipt" style="height: 25%;width: 25%">
            </a>
        </caption>
        <thead>
        <tr>
            <th>Date</th>
            <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <td>{{$account->created_at}}</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Name</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{$account->name}}</td>
        </tr>
        <tr>
            <td>Description</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{$account->description}}</td>
        </tr>
        <tr>
            <td>Amount</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{$account->amount}}</td>
        </tr>
        <tr>
            <td>Pay</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{$account->pay}}</td>
        </tr>
        <tr>
            <td>Due</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{$account->due}}</td>
        </tr>

        </tbody>
    </table>
    <caption align="center">
        <a href="http:\\www.dreamsoftbd.com">
            Copyright @ dreamsoft(bd)
        </a>
    </caption>
</div>
</body>
</html>