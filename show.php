<?php
session_start();
if(
!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()
){
echo "LOGIN ERROR";
header("Location: index.php");
}

 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>管理画面</title>
     <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
     <link rel="stylesheet" href="/css/show.css">
     <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
   </head>
   <body>
     <table id="table">

     </table>
     <button type="button" name="button" id="show">一覧表示</button>
     <script>
      $('#show').click(function(){
        $.ajax('database.php',
        {
          type: 'GET',
          dataType: 'json'
        })
        .done(function (data) {
          console.log("成功");
          console.log(data);
        })
        .fail(function (data) {
          console.log("失敗");
          console.log(data);
        });




      })
     </script>
   </body>
 </html>
