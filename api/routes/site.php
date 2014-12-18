<?php
ini_set('display_errors','on');

$app->get('/hello/:name', function ($name) {
  echo "Hello, $name";
});

$app->get('/fetch/userdata',function() use($app) {
  $req = $app->request();
  $requiredfields = array(
    'id'
  );
  
  // validate required fields
  if(!RequiredFields($req->get(), $requiredfields)){
    return false;
  }
	$id = $req->get("id");
	global $conn;
	$sql='SELECT * from users where id='.$id;
	$rs=$conn->query($sql);
	$arr = $rs->fetch_all(MYSQLI_ASSOC);
  
  echo json_encode(array(
    "error" => 0,
    "message" => "User data fetch successfully",
		"users" => $arr
  ));
});

$app->get('/login',function() use($app) {
  $req = $app->request();
  $requiredfields = array(
    'email',
		'password'
  );
  
  // validate required fields
  if(!RequiredFields($req->get(), $requiredfields)){
    return false;
  }
	$email = $req->get("email");
	$password = $req->get("password");
	global $conn;
	$sql='SELECT * from users where EmailAddress="'.$email.'" and Password="'.$password.'"';
	$rs=$conn->query($sql);
	$arr = $rs->fetch_array(MYSQLI_ASSOC);
  if($arr == null){
		echo json_encode(array(
			"error" => 1,
			"message" => "Email-id or Password doesn't exist",
		));
		return;
	}
	
  echo json_encode(array(
    "error" => 0,
    "message" => "User logged in successfully",
		"users" => $arr
  ));
});
?>
