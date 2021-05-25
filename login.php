<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">   
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>Example: PHP form handling</title>
 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/styles.css">

   
</head>
<body>
  
  <div>  
   
  <!-- what are form inputs -->
  <!-- who will handle the form submission -->
  <!-- how are the request sent -->
     
    <?php include('header.html') ?> 

      <!--Home Screen-->

    <div class = "jumbotron">
      <form action = "<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="form-group">
          <label for="exampleFormControlInput1">Enter Credentials</label>
          <!-- <div class="row"> -->
            <div class="row">
              <input name = "user" type="text" class="form-control" placeholder="Username" value = "<?php if(isset($_COOKIE['user'])) echo $_COOKIE['user']; ?>" required>
            </div>
            <br>

            <div class="row">
              <input name = "pwd" type="password" class="form-control" placeholder="Password" value = "<?php if (isset($_COOKIE['pwd'])) echo $_COOKIE['pwd']; ?>" required>
            </div>
          <!-- </div> -->

          
        </div>

      

        <input type="submit" name="login" value="login" class="button button1" />
      
      </form>
    </div>
 
  </div>

</body>
</html>


<?php
require('connect-db.php');

if (isset($_COOKIE['user']) and isset($_COOKIE['pwd']))
{
    session_start();
    $_SESSION['username'] = $_COOKIE['user'];
    $_SESSION['name'] = $_COOKIE['name'];
    $_SESSION['bp'] = $_COOKIE['bp'];
    header("Location: " . "portfolio.php");
}
?>

<?php 

$mainpage = "portfolio.php";   


if (isset($_POST['login']))
{ 
   try 
   {  
      switch ($_POST['login']) 
      {
         case 'login': authenticate();  break;
      }
   }
   catch (Exception $e)       // handle any type of exception
   {
      $error_message = $e->getMessage();
      echo "<p>Error message: $error_message </p>";
   }   
}
?>

<?php
function authenticate()
{

   global $mainpage;
   // Assume there exists a hashed password for a user (username='demo', password='nan') 
   // in a database or file and we've retrieved and assigned it to a $hash variable 
   // $hash = '$2y$10$BybeAVqd1A6/fl5yl/pTzuloZXYzSnc0S1hz6HYm/JzrKFP7Y6hCu';     // hash for 'nan'

   // hash for 'demo'


  if ($_SERVER['REQUEST_METHOD'] == 'POST')
   {
      global $db;



      if (isset($_POST['pwd']) and isset($_POST['user']))
      {

        $pwd = htmlspecialchars($_POST['pwd']);  
      
        $user = $_POST['user'];
    
        $query = "SELECT * FROM creds";
        
        $statement = $db->prepare($query);
        $statement->execute();

        $results = $statement->fetchAll();

        $statement->closeCursor();

        $foo = True;
        
        foreach($results as $result) 
        {
          if ($result['user'] == $user & $result['pwd'] == $pwd)
          {
            session_start();


            $_SESSION['username'] = $result['user'];
            $_SESSION['pwd'] = $result['pwd'];
            $_SESSION['name'] = $result['name'];
            $_SESSION['bp'] = $result['bp'];

            setcookie('user', $user, time()+3600);
            setcookie('pwd', ($result['pwd']), time()+3600);

            header("Location: " . "portfolio.php");
            $foo = False;
          }
        }
        if ($foo)
        {
          echo("Credentials are not Correct");
        }
      }
    }
    
}
?>

<?php include('footer.html') ?>

  
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

<script src="js/signup.js"></script>
</body>
</html>