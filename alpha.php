<?php

$API_KEY = "2T11QGW4OZZG5891";
$FUNC = "TIME_SERIES_DAILY";
$SYMB = $_GET['stock'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,("https://www.alphavantage.co/query?function=" . $FUNC . "&symbol=" . $SYMB . "&apikey=" . $API_KEY));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);
$result = json_decode($server_output);

$dataForAllDays = $result->{'Time Series (Daily)'};

$date = date("Y-m-d");

$dataForSingleDate = $dataForAllDays->{"2021-04-27"};
echo "Open: " . $dataForSingleDate->{'1. open'} . '<br/>';
echo $dataForSingleDate->{'2. high'} . '<br/>';
echo $dataForSingleDate->{'3. low'} . '<br/>';
echo $dataForSingleDate->{'4. close'} . '<br/>';
echo $dataForSingleDate->{'5. volume'} . '<br/>';


?>