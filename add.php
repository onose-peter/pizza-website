<?php
    include('config/db_connect.php');


        $title = $email = $ingredients ='';


        $errors = array('email'=> '', 'title'=>'', 'ingredients'=>"");


    if(isset($_POST["submit"])){
        // echo htmlspecialchars($_POST['email']);
        // echo htmlspecialchars($_POST['title']);
        // echo htmlspecialchars($_POST['ingredients']);

        //check email
        if (empty($_POST['email'])){
            $errors['email'] = 'Input your email <br/>';
        } else {
           $email = $_POST['email'];
           if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
               $errors['email']= 'email must be a vaild email address';
           }
        }

        //check pizza title
        if (empty($_POST['title'])){
            $errors['title']= 'Input your Pizza Title <br/>';
        } else {
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
                $errors['title']= 'Title must be letters and spaces only';
            }
        }

        //check for ingridents
        if (empty($_POST['ingredients'])){
            $errors['ingredients']= 'Input your ingredients seprated with a comma ';
        } else {
            $ingredients = $_POST['ingredients'];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
                $errors['ingredients']='ingredients must be a comma seprated list';
            }
        }
        if(array_filter($errors)){
           // echo 'errors in the form';
        } else{
            //mysqli_real_escape_string works like the htmlspecialchars, it escapes any kind of malicious chars its protects us from people writing harmful code to our database. its just basically to protect data going into the database
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

            //next, create the sql string that is going to save the data in the db
            $sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title', '$email', '$ingredients')";

            //save to db and check if it works

            if(mysqli_query($conn, $sql)){
                //success
                header("location: ninja.php"); //redirecting to the homepage
            } else{
                //error
                echo 'query error: ' . mysqli_error($conn);
            }

        }
       
    }  //end of post check
    

?>

<!DOCTYPE html>
<html lang="en">

 <?php include("templates/header.php")?> 

    <section class="container grey-text">
    <h4 class="center">Add a Pizza</h4>
       <form class="white" action="" method = "POST">
            <label> Your Email:</label>
                <input type="text" name="email" value=" <?php echo htmlspecialchars($email)?>">
                    <div class="red-text">
                       <?php echo $errors['email']; ?>
                   </div>

            <label> Pizza Title:</label>
                <input type="text" name="title"  value=" <?php echo htmlspecialchars($title)?>">
                    <div class="red-text">
                        <?php echo $errors['title']; ?>
                    </div>

            <label> ingredients (comma seperated):</label>
                <input type="text" name="ingredients"  value=" <?php echo htmlspecialchars($ingredients)?>">
                    <div class="red-text">
                       <?php echo $errors['ingredients']; ?>
                    </div>

            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
       </form>
    </section>


 <?php include("templates/footer.php")?> 

    

</html>