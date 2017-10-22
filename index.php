<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TO-DO</title>
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
    <form method="POST">
        
        <h1>TODO-listan:</h1>
        <p>Title<br>
        <input type="text" name="title">
        </p>
        <p>Created by<br>
        <input type="text" name="createdBy">
        </p>
        <input class="button" type="submit" value="Skicka" />
        
    </form>
    <?php 
    require 'database.php'; 
    
    $statement = $pdo->prepare(
        "INSERT INTO todo_list (title, createdBy)
        VALUES (:title, :createdBy)");
    
    $statement->execute(array(
    ":title" => $_POST["title"],
    ":createdBy" => $_POST["createdBy"]));
    
    $statement = $pdo->prepare("SELECT * FROM todo_list");
    
    $statement->execute();
    $todo_list = $statement->fetchAll(PDO::FETCH_ASSOC);
    $reverse = array_reverse($todo_list);
    
    ?>
    
         <h2>Att göra:</h2>
    <table>
        <thread>
            <tr>
                
                 <th>Id</th>
                <th>Title</th>
                <th>Created by</th>
                <th>Completed</th>
            </tr>
        </thread>
        <form method="POST">
        <tbody>
        <?php
        foreach($reverse as $i){ ?>
        <tr>
            <td><?php echo $i['id']; ?></td>    
            <td><?php echo $i['title']; ?></td>
            <td><?php echo $i['createdBy']; ?></td>
             <td>
                <input type="checkbox" name="completed" value="<?= $i['id']; ?> ">    
            </td>
           
        </tr><?php
             }  ?>
             
        </tbody>
        <input class="button" type="submit" value="Skicka" />
     </form>
    
    </table>
     <?php 
     print_r($_POST);
    foreach($_POST as $key=>$value){
        if(isset($_POST["completed"])){
            $statement = $pdo->prepare(
                "UPDATE todo_list SET completed = 1 WHERE id = " . $value
            );
            $statement->execute();
        }
    }
    
    
    
    
    ?>
      
       
        

    
 
    
    <footer></footer>
</body>
</html>