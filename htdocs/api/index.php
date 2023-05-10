<?php
$db = new PDO("mysql:host=localhost; dbname=web; charset=utf8;", "root", "");
$sql = "SELECT * FROM quotes ORDER BY rand() LIMIT 1";
$rs = $db -> query($sql);   
$data = $rs -> fetch(PDO::FETCH_ASSOC);
$quote = array("id" => $data["id"], "content" => $data["quote"]);
echo json_encode($quote);
