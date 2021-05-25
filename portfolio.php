<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->        
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="styles/styles.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    
    <script src="js/signup.js"></script>

  </head>

<body>



<?php
include('header.html');

session_start(); 

if (!isset($_SESSION['username']))
{
  header("Location: " . "home.html");
}


require 'connect-db.php';
?>

  <form action="portfolio.php" method="get">
    <input type="submit" name="logout" value="logout" class="button" />
  </form>

  <form action="stockinfo.php" method = "post">
    <div class="input-group">
      <input type="search" name = "stock" class="form-control rounded" placeholder="Search Portfolio" aria-label="Search"
    aria-describedby="search-addon" />
    </div>
  </form>


    <div class = "jumbotron jumbotron-fluid">
      <h1> <?php echo $_SESSION['name'] . "'s Portfolio"; ?> </h1>

      <div class = "row">
          <h2> <?php echo "Buying Power: $" . $_SESSION['bp'];?></h2>
      </div>

<?php


$query = "SELECT * FROM creds";
      
      $statement = $db->prepare($query);
      $statement->execute();

      $results = $statement->fetchAll();

      $statement->closeCursor();
      
      foreach($results as $result) 
      {
        if ($result['user'] == $_SESSION['username'])
        {
          $stocks = explode("-", $result['shares']);
          foreach ($stocks as $stock)
          {
            echo "<h4>" . $stock . "</h4> <br>";
          }
        }
      }

?>
    </div>

<?php
function logout()
{
  session_destroy();
  // setcookie('user', time() - 3600);
  // setcookie('pwd', time() - 3600);
  header("Location: " . "home.html");
}


if (isset($_GET['logout']))
{
  try
  {
    switch ($_GET['logout']) 
    {
      case 'logout': logout(); break;
    }

  }
  catch (Exception $e) 
   {
      $error_message = $e->getMessage();
      echo "<p>Error message: Improper Validation </p>";
   }   
}

?>


<?php
include('footer.html');
?>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</body>
</html>