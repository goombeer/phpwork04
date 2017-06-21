<?php
ini_set('display_errors',1);//コンソールツールにエラーを表示させるため

$db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
$db['dbname'] = ltrim($db['path'], '/');
$dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
$username = $_POST["username"];

try {
  $db = new PDO($dsn, $db['user'], $db['pass']);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  error_log($e);
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

$stmt = $db->prepare("SELECT name,age,question1,question2,question3 FROM line_user_info");
$status = $stmt->execute();
$result = $stmt->fetchall(PDO::FETCH_ASSOC);
$json = json_encode($result);
error_log(print_r($json,true));
echo $json;


 ?>
