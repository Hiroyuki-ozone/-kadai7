<?php
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ

if(
  !isset($_POST["book_name"]) || $_POST["book_name"]=="" ||
  !isset($_POST["book_url"]) || $_POST["book_url"]=="" ||
  !isset($_POST["comment"]) || $_POST["comment"]==""
){
  exit('ParamError');
}


$book_name = $_POST["book_name"];
$book_url = $_POST["book_url"];
$comment = $_POST["comment"];

//2. DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成
$sql="INSERT INTO gs_bm_table(id, book_name, book_url, comment, submit_datetimes)values(NULL, :a1, :a2, :a3, sysdate())";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':a1', $book_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $book_url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("sqlError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");

}
?>


