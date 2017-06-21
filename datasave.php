<?php
  ini_set('display_errors',1);//コンソールツールにエラーを表示させるため
  require __DIR__ . '/vendor/autoload.php';

  $db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
  $db['dbname'] = ltrim($db['path'], '/');
  $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
  $username = $_POST["username"];
  $email = $_POST["email"];
  $pass = $_POST["pass"];
  $pass = password_hash($pass,PASSWORD_DEFAULT);

  try {
    $db = new PDO($dsn, $db['user'], $db['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    error_log($e);
    exit('データベースに接続できませんでした。'.$e->getMessage());
    echo "もう一度入力してください";
  }

  //ユーザーのメールアドレスを取り出して、会員登録しているか確認
  $stmt = $db->prepare("SELECT email FROM user_database");
  $status = $stmt->execute();
  $result = $stmt->fetchall(PDO::FETCH_COLUMN);
  $result = array_values($result);
  $judge_email = in_array($email,$result);

  //ユーザー名を取り出して、重複がないか確認
  $stmt = $db->prepare("SELECT username FROM user_database");
  $status = $stmt->execute();
  $result = $stmt->fetchall(PDO::FETCH_COLUMN);
  $result = array_values($result);
  $judge_user = in_array($username ,$result);

  if ($judge_email == 1) {
    //emailの重複あり
    echo "すでにこのメールアドレスは登録されています";
  } elseif ($judge_user == 1) {
    //ユーザー名の重複あり
    echo "すでにこのユーザー名は登録されています";
  } else{
    //新規ユーザーに対して
    $stmt = $db->prepare('INSERT INTO user_database(id,username,email,pass,root)VALUES(NULL, :username, :email,:pass,:root)');
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
    $stmt->bindValue(':root', 0, PDO::PARAM_INT);
    $status = $stmt->execute();
    echo "登録が完了しました";
  }











 ?>
