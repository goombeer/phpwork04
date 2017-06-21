<?php
session_start();
$_SESSION["ssid"] = session_id();
error_log($_SESSION["ssid"]);
 ?>


 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>登録画面</title>
     <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
     <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
     <link rel="stylesheet" href="css/style.css">
     <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
   </head>
   <body>
   <div class="main">
           <div id="rogin_area">
             <h2 class="login_title">ログイン</h2>
             <div class="user_wrap">
               <input type="text" name="" value="" placeholder="ユーザー名を入力してください" id="login_user"><br>
             </div>
             <div class="mail_wrap">
               <input type="text" name="" value="" placeholder="メールアドレスを入力してください" id="login_mail"><br>
             </div>
             <div class="pass_wrap">
               <input type="password" name="" value="" placeholder="パスワードを入力してください" id="login_pass"><br>
             </div>
             <div class="button_wrap">
               <button type="button" name="button" id="login">ログイン</button>
             </div>
            </div>

          <div id="regist">
             <h2 class="new_title">新規アカウント作成</h2>
             <form class="" action="index.html" method="post">
               <div class="regist_user_wrap">
                 <input type="text" name="user" value="" placeholder="ユーザー名を入力してください" id="regist_user"><br>
               </div>
               <div class="regist_mail_wrap">
                 <input type="text" name="email" value="" placeholder="メールアドレスを入力してください" id="regist_mail"><br>
               </div>
               <div class="regist_pass_wrap">
                 <input type="password" name="pass" value="" placeholder="パスワードを入力してください" id="pass"><br>
               </div>
               <div class="regist_pass_wrap">
                 <input type="password" name="repass" value="" placeholder="パスワードを再入力してください" id="repass"><br>
               </div>
             </form>
             <div class="account_wrap">
               <button type="button" name="button" id="account_create">アカウント作成</button>
             </div>
          </div>
  </div>

  <div class="messaage_area">
    <p id=message></p>
  </div>

   <script>
   //ユーザー登録周り
    $('#account_create').click(function(){
      $("#message").text("");
      let username = $('#regist_user').val();
      let email = $('#regist_mail').val();
      let pass = $('#pass').val();
      let repass = $('#repass').val();
      if (pass == repass ) {
          $.ajax('datasave.php',
          {
            type: 'post',
            data: {
                  username: username,
                  email:email,
                  pass:pass,
                  },
            dataType: 'text'
          })
          .done(function (text) {
            console.log("成功");
            $('#message').text(text);
            $('#regist_user').val("");
            $('#regist_mail').val("");
            $('#pass').val("");
            $('#repass').val("");
          })
          .fail(function (text) {
            console.log("失敗");
            $('#message').text(text);
            $('#regist_user').val("");
            $('#regist_mail').val("");
            $('#pass').val("");
            $('#repass').val("");
          });
      } else {
        $("#message").text("パスワードが一致していません");
        $('#pass').css("background","red");
        $('#repass').css("background","red");
      }
    });

    //ログイン周り
    $('#login').click(function(){
      $("#message").text("");
      let username = $('#login_user').val();
      let email = $('#login_mail').val();
      let pass = $('#login_pass').val();
      if (username == "" || email == "" || pass == "") {
        $('#message').append('必要項目を入力してください');
        exit;
      }
      $.ajax('login_check.php',
      {
        type: 'post',
        data: {
              username: username,
              email:email,
              pass:pass,
              },
        dataType: 'text'
      })
      .done(function (text) {
        console.log(text);
        $('#message').text(text);
        $('#login_user').val("");
        $('#login_mail').val("");
        $('#login_pass').val("");
        window.location.href = 'show.php';
      })
      .fail(function (text) {
        console.log(response);
        $('#message').text(text);
        $('#login_user').val("");
        $('#login_mail').val("");
        $('#login_pass').val("");
      })
    });
   </script>
   </body>
 </html>
