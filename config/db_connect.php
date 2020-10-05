<?php 

//connect to database
$conn = mysqli_connect('localhost', 'peter', 'test1234', 'ninja_pizza');// it takes in 4 parameters: localhost, username, password, db-name

//next is to check if the connection is succcessful

if(!$conn){
    echo 'Connection error: ' . mysqli_connect_error();
}

?>