<?php
    //adding the database connection
    include('config/db_connect.php');

    //to detect if the post request was made in the delete button below
    if(isset($_POST['delete'])){

        $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

        //making a sql to make a query
        $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";

        //make this query and check if its succesfully done
        if(mysqli_query($conn, $sql)) {
            //success
            header('location: ninja.php');
        } {
            //error
            echo 'query error: ' . mysqli_error($conn); 
        }

    }

    //check yo see if we have the GET data inside the url
    if(isset($_GET['id'])){
        //to escape any kind of characters that a user wants to input by himself to get a result from the url just to protect the db
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        //making a sql to use to make a query
        $sql = "select * FROM pizzas WHERE id = $id";

        //get the query result
        $result = mysqli_query($conn, $sql);

        //fetch the result in array format for just one row
        $pizza = mysqli_fetch_assoc($result);

        //its always safe to free the results and close the connection
        mysqli_free_result($result);
        mysqli_close($conn);

        // print_r($pizza);
    }

?>

<!DOCTYPE html>
<html lang="en">

<?php include("templates/header.php")?> 

<div class="container center grey-text">

    <?php if($pizza): ?>
        
        <h4><?php echo htmlspecialchars($pizza['title']); ?></h4>
        <p>Created by: <?php echo htmlspecialchars($pizza['email']); ?></p>
        <p><?php echo date($pizza['created_at']); ?></p>
        <h5>Ingredients:</h5>
        <p><?php echo htmlspecialchars($pizza['ingredients']) ?></p>

        <!-- delete form -->
        <form action ="details.php" method ="POST">
            <input type="hidden" name = "id_to_delete" value ="<?php  echo $pizza['id']?>"> 
            <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
        </form>



    <?php else: ?>
    
    <h5>No such pizza exists!</h5>

    <?php endif; ?>
</div>

<?php include("templates/footer.php")?> 
 
</html>