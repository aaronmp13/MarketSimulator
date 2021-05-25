<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">   
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>Sign Up</title>
 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

  <link rel="stylesheet" href="styles/styles.css">
  
</head>

<body>
  
<?php 


require('connect-db.php');  

if (isset($_POST['submit']))
{ 
   try 
   {  
      switch ($_POST['submit']) 
      {
        case 'insert': createUser();
        break;
      }
   }
   catch (Exception $e)       // handle any type of exception
   {
      $error_message = $e->getMessage();
      echo "<p>Error message: Improper Validation </p>";
   }   
}


function createUser()
{
  
  global $mainpage;
  global $db;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {



    $pwd = htmlspecialchars($_POST['pwd']);  
    $user = $_POST['user'];
    $bp = $_POST['bp'];
    $name = $_POST['first'] . " " . $_POST['last'];


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
          echo("
            <small class='text-danger'>
              Username " . $user . " is already taken, please try another.
            </small>");
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
      $_SESSION['username'] = $_POST['user'];
      $_SESSION['name'] = $_POST['first'] . " " . $_POST['last'];
      $_SESSION['bp'] = $_POST['bp'];

      header("Location: ". $mainpage);
    }
  }
}

$mainpage = "portfolio.php";   
createUser();

include('header.html'); 

include ('signup.html');

include('footer.html'); 

?> 
  
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/signup.js"></script>
</body>
</html>