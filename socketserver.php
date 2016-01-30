#!/usr/bin/php -q
<?php
/**
 * to run call from command line this not a web broweser application
 * c:\> php /Users/Grzegorz/Sites/xampp/htdocs/php-socket/socket.php
 *
 */

// Set time limit to indefinite execution
set_time_limit (0);

// Set the ip and port we will listen on
$address = '127.0.0.1';
$port = 9000;


// Create a TCP Stream socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
echo 'socket resource:'.$socket;

// Bind the socket to an address/port
socket_bind($socket, $address, $port) or die('Could not bind to address');

// Start listening for connections
socket_listen($socket);

// Accept incoming requests and handle them as child processes
$client = socket_accept($socket);
//$who = socket_getpeername($sock);

$socketname = socket_getsockname($socket, $address, $port);
echo ' socket name: '.$socketname;

/*
socket_recvfrom($socket, $buf, 12, 0, $from, $port);
echo "Received $buf from remote address $from and remote port $port" . PHP_EOL;
*/

if(socket_getpeername($client, $remoteAddress, $remotePort))
{
    echo ' RemoteAddress: '.$remoteAddress;
    echo ' RemotePort: '.$remotePort;
}

// Read the input from the client &#8211; 1024 bytes
$clientInput = socket_read($client, 1024);
echo 'Data: '. $clientInput;

// Strip all white spaces from input
//$output = ereg_replace("[ \t\n\r]","",$clientInput).chr(0);

$fileString = file_get_contents('/Users/Grzegorz/Sites/xampp/htdocs/php-socket/data_233520.txt');

socket_write($client, $fileString);

$i=10;
while ($i)
{
	$clientInput = $clientInput.' from Greg Server '. $i;
	// Display output back to client
	socket_write($client, $clientInput);
	echo ' Message nr '.$i.'sent to client';
	sleep(1);
	$i--;
}

// Close the client (child) socket
socket_close($client);

// Close the master sockets
socket_close($socket);

?>

