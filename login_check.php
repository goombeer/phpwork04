<?php
//コンソールツールにエラーを表示させるため
ini_set('display_errors',1);

//セッションを持たせて、ログイン機能を強化
session_start();
$_SESSION["username"] = $_POST["username"];
$_SESSION["email"] = $_POST["email"];
$_SESSION["pass"] = $_POST["pass"];

//データベース関連
$db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
$db['dbname'] = ltrim($db['path'], '/');
$dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";


try {
  $db = new PDO($dsn, $db['user'], $db['pass']);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  error_log($e);
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//ユーザーのメールアドレスを取り出して、会員登録しているか確認
$stmt = $db->prepare("SELECT * FROM user_database WHERE username=:username AND email=:email AND root=0");
$stmt -> bindValue(':username',$_SESSION["username"]);
$stmt -> bindValue(':email',$_SESSION["email"]);
$status = $stmt->execute();

if ($status == false) {
  queryError($stmt);
}

$result = $stmt->fetch();
if (password_verify($_SESSION["pass"],$result["pass"])) {
  $_SESSION["chk_ssid"]  = $_SESSION["ssid"];
  $_SESSION["name"]      = $result['username'];
  echo "ログインに成功しました";
} else {
  echo "ログインに失敗しました";
}
// $result = array_values($result);
// error_log(print_r($result,true));
// $judge = in_array($_SESSION["email"],$result);
// error_log($judge);


 ?>
