<?php

$host = '127.0.0.1';
$port=9000;
$timeout=10;

$sk1 = fsockopen( $host,$port,$errnum,$errstr,$timeout );

if (!is_resource($sk1))
{
    exit("connection fail: ".$errnum." ".$errstr) ;
}
else
{
    // Hello
    fputs($sk1, "hello") ;
    $dati="" ;
    while (!feof($sk1))
    {
        $dati.= fgets ($sk1, 1024);
    }
    echo($dati) ;
}
fclose($sk1) ;

?>