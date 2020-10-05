<?php
//to connect to the database, u can use two methods
//1-MYSQLi (i stands for improved)
//2-PDO (PHP data object)

//connect to database
//$conn = mysqli_connect('localhost', 'peter', 'test1234', 'ninja_pizza');// it takes in 4 parameters: localhost, username, password, db-name

//next is to check if the connection is succcessful

// if(!$conn){
//     echo 'Connection error: ' . mysqli_connect_error();
// }

include('config/db_connect.php');


//write query for all pizzas
//$sql = 'SELECT * FROM pizzas' //selecting all the columns in the table. but we dont want all.we want some part of the table
$sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';//ORDER BY orders the column in a particular way.

//next, we make query and getting the result
$result = mysqli_query($conn, $sql);

//next, fetch the resulting roles as an array i.e changing it to an array format to be able to use the data
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);


//free result from memory
mysqli_free_result($result);

//close connection
mysqli_close($conn);





?>

<!DOCTYPE html>
<html lang="en">

 <?php include("templates/header.php")?> 

 <h4 class="center grey-text"> Pizzas!</h4>

 <div class="container">
    <div class="row">

        <?php foreach($pizzas as $pizza){  ?>

            <div class="col s6 md3">
                <div class="card z-depth-0">

                    <img src="img/pizza.png" class="pizza" alt="">

                    <div class="card-content center">
                        <h6><?php  echo htmlspecialchars($pizza['title']); ?></h6>

                        <ul>
                            <?php foreach(explode(',', $pizza['ingredients']) as $ing){ ?>

                                <li><?php echo htmlspecialchars($ing); ?></li>

                            <?php } ?>
                        </ul>
                    </div>

                    <div class="card-action right-align">
                        <a href="details.php?id=<?php echo $pizza['id'] ?>" class="brand-text">more info</a>
                    </div>

                </div>
            </div>

        <?php  }  ?>

        

    </div>
 </div>

 <?php include("templates/footer.php")?> 

    

</html>