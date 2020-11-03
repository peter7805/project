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
            <li class="nav-item active">
              <a class="nav-link" href="/bank/homepage">搜尋紀錄 <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/bank/deposit">存款 <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/bank/withdrawal">提款 <span class="sr-only">(current)</span></a>
            </li>
          </ul>
        </div>  
        <div class="align-right">
          <ul class="nav navbar-nav navbar-right">
            <li class="active">
              <a href="/bank/logout">Sign out</a>
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

    <div>
      <table class="table">
        <thead class="thead-light">
          <tr>
            <th scope="col" style="width:5%;"></th>
            <th scope="col" style="width:25%;">編號</th>
            <th scope="col" style="width:10%;">類型</th>
            <th scope="col" style="width:10%;">金額</th>
            <th scope="col" style="width:10%;">餘額</th>
            <th scope="col" style="width:15%;">備註</th>
            <th scope="col" style="width:25%;">時間</th>
          </tr>
        </thead>
        <tbody id="info">
        </tbody>
      </table>
    </div>
    <div class="login_box p-5">
      <h4 class="text-center mb-3" >交易紀錄查詢</h4>
      <form>
        <div class="form-group">
          <label for="startTime">開始日期：</label>
          <input type="date" maxlength="10" class="form-control" id="startTime">
        </div>
        <div class="form-group">
          <label for="endTime">結束日期：</label>
          <input type="date" maxlength="10" class="form-control" id="endTime">
        </div>
        <div class="text-center">
          <button type="button" class="btn btn-primary btn-lg m-3" id="searchok" style="width: 35%;">送出</button>
        </div>
      </form>
    </div>
  </div>
</body>
<script>
  $(document).ready(function() {
    $("#searchok").click(function() {
      var start_time = $("#startTime").val();
      var end_time = $("#endTime").val();
      var satrt_t = (Date.parse(start_time));
      var end_t = (Date.parse(end_time)).valueOf();
      if (start_time != "" && end_time != "" && end_t >= satrt_t) {
        $.ajax({
          type: "POST",
          url: "/bank/show",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            user_id: {{$id}},
            start_time: start_time,
            end_time: end_time,
          },
          async: false,
          success: function(res) {
            for (i = 0; i < res.length; i++) {
              if(res[i].type == 0){
                res[i].type = '存款';
              }else{
                res[i].type = '提款';
              }
              if(res[i].remark == null){
                res[i].remark = '';
              }
              $("#info").append(
                `<tr><th scope = "row" style="width:5%;">${res[i].id}</th><td style="width:25%;">${res[i].number}</td><td style="width:10%;">${res[i].type}</td><td style="width:10%;">${res[i].money}</td><td style="width:10%;">${res[i].balance}</td><td style="width:15%;">${res[i].remark}</td><td style="width:25%;">${res[i].create_time}</td></tr>`
              );
            }
          },
          error: function(msg) {
            alert("查詢失敗");
          }
        });
      } else {
        if(start_time == ""){
          alert('開始日期不得為空');
        }else if(end_time == ""){
          alert('結束日期不得為空');
        }else if(end_t < satrt_t){
          alert('日期輸入有誤');
        }
      }
    });
  });
</script>

</html>