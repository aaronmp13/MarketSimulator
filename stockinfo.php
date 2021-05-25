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
session_start();
include('header.html');
require('connect-db.php');  
?>

<?php

// overview
$API_KEY = "2T11QGW4OZZG5891";
$FUNC = "OVERVIEW";
$SYMB = $_POST['stock'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,("https://www.alphavantage.co/query?function=" . $FUNC . "&symbol=" . $SYMB . "&apikey=" . $API_KEY));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);
$result = json_decode($server_output);


$_SESSION['s_ticker'] = $result->{'Symbol'};
$_SESSION['s_name'] = $result->{'Name'};


$_SESSION['hi_52'] = $result->{'52WeekHigh'};
$_SESSION['low_52'] = $result->{'52WeekLow'};
$_SESSION['desc'] = $result->{'Description'};



$FUNC = "TIME_SERIES_DAILY";
$SYMB = $_POST['stock'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,("https://www.alphavantage.co/query?function=" . $FUNC . "&symbol=" . $SYMB . "&apikey=" . $API_KEY));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);
$result = json_decode($server_output);

$dataForAllDays = $result->{'Time Series (Daily)'};

$date = date_create(date('Y-m-d'));


while (!isset($dataForAllDays->{date_format($date,"Y-m-d")}))
{
	date_sub($date,date_interval_create_from_date_string("1 day"));
}

$dataForSingleDate = $dataForAllDays->{date_format($date,"Y-m-d")};

$open = $dataForSingleDate->{'1. open'};
$high = $dataForSingleDate->{'2. high'};
$low = $dataForSingleDate->{'3. low'};
$close = $dataForSingleDate->{'4. close'};
$vol = $dataForSingleDate->{'5. volume'};


?>

<div class="jumbotron">

<h1> <?php echo $_SESSION['s_name'];?> </h1></br>

<h3> <?php echo date_format($date,"Y-m-d"); ?> Share Price</h3>
<h3>  <?php echo $close; ?> </h3>
  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="get">
    <input type="submit" name="add" value="Add" class="button button1"/>
  </form>

</div>


<h4> Low: <?php echo $_SESSION['hi_52']; ?></h4>
<h4> High: <?php echo $_SESSION['hi_52']; ?></h4>
<h4> 52-Week High: <?php echo $_SESSION['hi_52']; ?> </h4>
<h4> 52-Week Low: <?php echo $_SESSION['low_52']; ?> </h4>
<p> <?php echo $_SESSION['desc']; ?> </p>




<?php

if (isset($_GET['submit']))
{ 
   try 
   {  
      switch ($_GET['submit']) 
      {
        case 'add': add_share();
        break;
      }
   }
   catch (Exception $e)       // handle any type of exception
   {
      $error_message = $e->getMessage();
      echo "<p>Error message: Improper Validation </p>";
   }   
}


function add_share()
{
  // header("Location: " . "portfolio.php");

  // global $mainpage;
  // global $db;


  // $query = "UPDATE `creds` SET `shares`=:symb WHERE `user`=:username";
  // $statement = $db->prepare($query);

  // $statement->bindValue(':symb', $SYMB);
  // $statement->bindValue(':username', $_SESSION['username']);

  // $statement->execute();
  // $statement->closeCursor();

  // header("Location: " . "portfolio.php");
  
}

?>


<?php
include('footer.html');
?>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</body>
</html>