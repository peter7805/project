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
  <style>
    body {
      height: 100%;
    }
    .login_box {
      width: 40%;
      margin: 0px auto;
    }
  </style>

  <title>signup</title>
</head>

<body>
  <div class="login_box mt-3 p-5">
    <h2 class="text-center">註冊網路銀行</h2>
    <form>
      <div class="form-group">
        <label for="name">名稱：</label>
        <input type="text" maxlength="10" class="form-control" id="name" placeholder="請輸入您的名稱">
      </div>
      <div class="form-group">
        <label for="account">身分證字號：</label>
        <input type="text" maxlength="10" class="form-control" id="account" placeholder="請輸入您的身分證字號">
      </div>
      <div class="form-group">
        <label for="userId">使用者代碼：</label>
        <input type="text" maxlength="20" class="form-control" id="userId" placeholder="請輸入6~20位英文數字">
      </div>
      <div class="form-group">
        <label for="password">Password：</label>
        <input type="password" maxlength="20" class="form-control" id="password" placeholder="請輸入6~20位英文數字">
      </div>
      <div class="form-group">
        <label for="repassword">二次確認Password：</label>
        <input type="password" maxlength="20" class="form-control" id="repassword" placeholder="請再次輸入密碼">
      </div>
      <div class="text-center">
        <button type="button" class="btn btn-primary btn-lg m-3" id="btnok" style="width: 35%;">註冊</button>
        <button type="button" class="btn btn-secondary btn-lg m-3" id="btncancel" style="width: 35%;">取消</button>
      </div>
    </form>
    <div id="error_info" class="text-center" style="color:red;">
    </div>
  </div>
</body>
<script>
  $(document).ready(function() {
    $("#btnok").click(function() {
      var checkAccount = /^[A-Z]{1}[0-9]{9}$/;
      var checkPwd = /^[a-zA-Z0-9]{6,20}$/;
      var name = $("#name").val();
      var account = $("#account").val();
      var userId = $("#userId").val();
      var pwd = $("#password").val();
      var repwd = $("#repassword").val();
      if (
        name != "" &&
        userId != "" &&
        checkAccount.test(account) &&
        checkPwd.test(userId) &&
        checkPwd.test(pwd) &&
        pwd == repwd
      ) {
        $.ajax({
          type: "POST",
          url: "/bank/signup",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            name: name,
            account: account,
            userId: userId,
            password: pwd,
          },
          async: false,
          success: function(msg) {
            if(msg == 1){
              alert('註冊成功，請登入');
              window.location.href = "/bank";
            }else{
              alert(msg);            
            }
          },
          error: function(res) {
            var text = Object.values(res.responseJSON.errors);
            $("#error_info").empty();
            for(i=0;i<text.length;i++){
              $("#error_info").append(
                '<p>'+text[i]+'</p>'
              );
            }
          }
        });
      } else {
        if(name == ""){
          alert('姓名不得為空');
        }else if (!checkAccount.test(account)) {
          alert('身分證字號輸入格式錯誤');
          $("#password").val("");
          $("#repassword").val("");
        }else if (!checkPwd.test(userId)) {
          alert('使用者代碼輸入格式錯誤');
          $("#password").val("");
          $("#repassword").val("");
        } else if (!checkPwd.test(pwd)) {
          alert('password輸入格式錯誤');
          $("#password").val("");
          $("#repassword").val("");
        }else if (password != pwd) {
          alert('密碼不一致');
          $("#repassword").val("");
        }
      }
    });
    $("#btncancel").click(function() {
      window.location.href = "/bank";
    });
  });
</script>

</html>