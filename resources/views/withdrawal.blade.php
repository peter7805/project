<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <style>
    .login_box {
      width: 40%;
      margin: 0px auto;
    }
  </style>
  <title>Bank</title>
</head>

<body>

    <div class="container">
      <div class="text-center">
        <h2 class="m-4">歡迎光臨網路銀行</h2>
      </div>
    </div>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      @if (Session::get('id'))
        <div class="align-left">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="/bank/homepage">搜尋紀錄 <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/bank/deposit">存款 <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="/bank/withdrawal">提款 <span class="sr-only">(current)</span></a>
            </li>
          </ul>
        </div>  
        <div class="align-right">
          <ul class="nav navbar-nav navbar-right">
            <li class="active">
              <a href="/bank">Sign out</a>
            </li>
          </ul>
        </div>          
      @else
        <div class="align-left">
          <ul class="navbar-nav"></ul>
        </div> 
        <div class="align-right">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="/bank">Sign in</a></li>
            <li class="ml-3"><a href="/bank/signup">Sign up</a></li>
          </ul>
        </div>          
      @endif
    </div>
  </nav>
  <div class="container">
    <h5 class="m-3">帳戶資訊--@if(Session::get('id'))<span>姓名：{{$name}}  ｜</span><span>餘額：{{$balance}}</span>@endif</h5>
    <div class="login_box p-5">
      <h4 class="text-center mb-3" style="color: red">提款</h4>
      <form>
        <div class="form-group">
          <label for="w_amount">目前餘額：</label>
          <input type="number" maxlength="10" class="form-control" id="w_amount" value="{{$balance}}" disabled>
        </div>
        <div class="form-group">
          <label for="w_money">提款金額：</label>
          <input type="number" maxlength="10" class="form-control" id="w_money" placeholder="請輸入金額">
        </div>
        <div class="form-group">
          <label for="w_remark">備註：</label>
          <input type="text" maxlength="6" class="form-control" id="w_remark" placeholder="請輸入備註">
        </div>
        <div class="text-center">
          <button type="button" class="btn btn-primary btn-lg m-3" id="withdraok" style="width: 35%;">送出</button>
        </div>
      </form>
    </div>
  </div>
</body>
<script>
  $(document).ready(function() {
    //提款
    $("#withdraok").click(function() {
      var w_amount = $("#w_amount").val();
      var w_money = $("#w_money").val();
      var w_remark = $("#w_remark").val();
      if (w_money != "" && w_money <= w_amount && w_money != 0) {
        $.ajax({
          type: "POST",
          url: "/bank/withdrawal",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            user_id: {{$id}},
            amount: w_amount,
            money: w_money,
            remark: w_remark,
          },
          async: false,
          success: function(msg) {
            if(msg == 1){
              alert('提款成功');
              location.reload();
            }else{
              alert(msg);            
            }
          },
          error: function(msg) {
            alert("提款失敗");
          }
        });
      } else {
        if(w_money == ""){
          alert('輸入金額不得為空');
        }else if(w_money == 0){
          alert('提款金額不得為0');
        }else if(w_money > w_amount){
          alert('提款金額不得大於帳戶餘額');
        }
      }
    });
  });
</script>

</html>