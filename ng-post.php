<?php

// header('Access-Control-Allow-Origin: http://192.168.1.167:4200/');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');  
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');


$postdata = file_get_contents("php://input");

// $request = json_encode($postdata);

$request = json_decode($postdata);


$data = [];

foreach ($request as $k => $v)
{
  $temp = "$k => $v";
  $data[''.$k] = $v;
}




require('connect-db.php');  

  
global $mainpage;
global $db;

//   // if ($_SERVER['REQUEST_METHOD'] == 'POST')
//   // {



    $pwd = htmlspecialchars($data['pass']);
    $user = $data['user'];
    $bp = $data['bp'];
    $name = $data['first'] . " " . $data['last'];


    $query = "SELECT * FROM creds";
      
      $statement = $db->prepare($query);
      $statement->execute();

      $results = $statement->fetchAll();

      $statement->closeCursor();

      $foo = False;
      
      foreach($results as $result) 
      {
        if ($result['user'] == $user)
        {
          $foo = True;
          echo json_encode("Invalid User, try another");
        }
      }
          
    if (!$foo)
    {
      $query = "INSERT INTO creds(name, user, pwd, bp, shares) VALUES (:name, :username, :pass, :buyingpower, :shares)";
      
      $statement = $db->prepare($query);


      $statement->bindValue(':name', $name);
      $statement->bindValue(':username', $user);
      $statement->bindValue(':pass', $pwd);
      $statement->bindValue(':buyingpower', $bp);
      $statement->bindValue(':shares', "");
      
      $statement->execute();

      $statement->closeCursor();

      session_start();
      $_SESSION['username'] = $user;
      $_SESSION['name'] = $name;
      $_SESSION['bp'] = $bp;

      echo json_encode($data);
    }

?>

