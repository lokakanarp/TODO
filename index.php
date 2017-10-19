<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TO-DO</title>
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
    <form method="POST">
    <div class="box2 col-lg-12">
          <h5>Ange dina kunduppgifter:</h5>
               <p>Title<br>
                   <input type="text" name="title">
               </p>
                <p>Created by<br>
                   <input type="text" name="createdBy">
               </p>
            <input class="button" type="submit" value="Skicka" />
          </div> 
    </form>
    <?php 
    require 'database.php'; 
    
    $statement = $pdo->prepare(
        "INSERT INTO todo_list (title, createdBy)
        VALUES (:title, :createdBy)"
    );
    
    $statement->execute(array(
    ":title" => $_POST["title"],
    ":createdBy" => $_POST["createdBy"]
    ));
    
    $statement = $pdo->prepare("SELECT * FROM todo_list");
    
    $statement->execute();
    $todo_list = $statement->fetchAll(PDO::FETCH_ASSOC);
    print_r($todo_list);
    
   
    
    print_r($_POST);
    ?>
    
    <footer></footer>
</body>
</html>