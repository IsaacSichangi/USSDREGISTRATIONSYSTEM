<?php

$servername = 'localhost';

$username = '';

$password = '';
//$password = '';
$database = '';



// Create connection

$conn = mysqli_connect($servername, $username, $password, $database);


//function to print content

function ussd_proceed($ussd_text){

	header('Content-type: text/plain');

echo "CON ".$ussd_text;

exit(0);

}

//function to END a session

function ussd_stop($ussd_text){
	header('Content-type: text/plain');

echo "END ".$ussd_text;

exit(0);

}

function error_reportingsss(){
global $conn;

error_log(mysqli_error($conn),1, "support@zorowtech.com");


}






?>