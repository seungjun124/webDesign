<?php
$r = isset($_GET['request']) ? $_GET['request'] : "";
$method = $_SERVER['REQUEST_METHOD'];
//GET, POST, PUT, DELETE...
$uri = explode("/", $r);//문자열을 배열로
$api = isset($uri[0]) ? $uri[0] : "";
$id = isset($uri[1]) ? $uri[1] : 0;
$db = new PDO("mysql:host=localhost; dbname=web; charset=utf8;", "root", "");
if( $api == "todo" ) {
	if( $method == "GET" ) {
		$todo = array();
		$sql = "SELECT * FROM todo ORDER BY id DESC";
		if( $rs = $db->query($sql) ) {
			$todo = $rs->fetchAll(PDO::FETCH_ASSOC);
		}
		echo json_encode($todo, JSON_UNESCAPED_UNICODE);
	} else if( $method == "POST" ) {
		$res = array("success"=>false);
		$todo = isset($_POST['todo']) ? $_POST['todo'] : "";
		if( $todo ) {
			$sql = "INSERT INTO todo(todo, complete) VALUES(:todo, 0)";
			if( $rs = $db->prepare($sql) ) {
				$rs->bindParam(":todo", $todo);
				if( $rs->execute() ) {
					if( $rs->rowCount() ) $res['success'] = true;
				}
			}
		}
		echo json_encode($res);
	} else if( $method == "DELETE" ) {
		$res = array("success"=>false);
		if( $id ) {
			$sql = "DELETE FROM todo WHERE id=:id";
			if( $rs = $db->prepare($sql) ) {
				$rs->bindParam(":id", $id);
				if( $rs->execute() ) {
					if( $rs->rowCount() ) $res['success'] = true;
				}
			}
		}
		echo json_encode($res);
	}
} else if( $api == "check" ) {
	if( $method == "POST" ) {
		$res = array("success"=>false);
		if( $id ) {
			$sql1 = "SELECT * FROM todo WHERE id=:id";
			if( $rs1 = $db->prepare($sql1) ) {
				$rs1->bindParam(":id", $id);
				if( $rs1->execute() ) {
					$data = $rs1->fetch();
					if( isset($data['id']) ) {
						if( $data['complete'] == 1 ) $c = 0;
						else $c = 1;
						$sql2 = "UPDATE todo SET complete=:c WHERE id=:id";
						if( $rs2 = $db->prepare($sql2) ) {
							$rs2->bindParam(":c", $c);
							$rs2->bindParam(":id", $id);
							if( $rs2->execute() ) {
								if( $rs2->rowCount() ) $res['success'] = true;
							}
						}
					}
				}
			}
		}
		echo json_encode($res);
	}
}