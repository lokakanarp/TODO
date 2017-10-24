<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TO-DO</title>

    <link rel="stylesheet" href="style2.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <main>
            <div class="top_wrap_1">
                <form method="POST">
                    <h1>Lokas att göra-lista</h1>
                    <p>Lägg till uppgift:
                        <p>
                            <p><input type="text" name="title"></p>
                            <p>Skapad av:</p>
                            <p><input type="text" name="createdBy"></p>
                            <input class="button" type="submit" value="Skicka" />

                </form>
            </div>
            <div class="top_wrap_2">
                <img src="cat.jpg">
            </div>
            <div class="clear"></div>

            <?php
            require 'database.php'; 
            if(isset($_POST["title"])) {
                $statement = $pdo->prepare(
                    "INSERT INTO todo_list (title, createdBy)
                    VALUES (:title, :createdBy)");
                $statement->execute(array(
                    ":title" => $_POST["title"],
                    ":createdBy" => $_POST["createdBy"]));
                echo "<p>Din uppgift har framgångsrikt lagts till i listan!</p>";
            }
            if(isset($_POST["completed"])){
                $statement = $pdo->prepare(
                    "UPDATE todo_list SET completed = 1 WHERE id = " . $_POST["completed"]
                );
                $statement->execute();

            }
            if(isset($_POST["delete"])){
                $statement = $pdo->prepare(
                    "DELETE FROM todo_list WHERE id = " . $_POST["delete"]
                );
                $statement->execute();
            }
            $todo_list = array();
            $statement = $pdo->prepare("SELECT * FROM todo_list ORDER by id DESC");
            $statement->execute();
            $todo_list = $statement->fetchAll(PDO::FETCH_ASSOC);
            ?>

                <form method="POST">
                    <h2>Att göra:</h2>
                    <table>
                        <tr>
                            <th>Nr</th>
                            <th>Uppgift</th>
                            <th>Skapad av</th>
                            <th>Klar</th>
                            <th>Radera</th>
                        </tr>
                        <?php
                foreach($todo_list as $i){ ?>
                            <tr>
                                <td>
                                    <?php echo $i['id']; ?>
                                </td>
                                <td>
                                    <?php if($i['completed'] == 0){ 
                                    echo $i['title']; 
                                    } elseif ($i['completed'] == 1) {echo "<s>" . $i['title'] . "</s>" ; }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $i['createdBy']; ?>
                                </td>
                                <td>
                                    <input type="checkbox" name="completed" value="<?= $i['id']; ?> ">
                                </td>
                                <td>
                                    <input type="checkbox" name="delete" value="<?= $i['id']; ?> "></td>
                            </tr>
                            <?php } ?>
                    </table>

                    <input class="button" type="submit" value="Skicka">
                </form>
                <h2>Utförda uppgifter:</h2>
                <table>
                    <tr>
                        <th>Nr</th>
                        <th>Uppgift</th>
                        <th>Skapad av</th>
                    </tr>
                    <?php
                foreach($todo_list as $i){ ?>
                        <tr>
                            <td>
                                <?php if($i['completed'] == 1){
                                        echo $i['id']; }?>
                            </td>
                            <td>
                                <?php if($i['completed'] == 1){ 
                                    echo $i['title']; 
                                    } ?>
                            </td>
                            <td>
                                <?php if($i['completed'] == 1){
                                          echo $i['createdBy']; }?>
                            </td>
                        </tr>
                        <?php } ?>
                </table>
        </main>
    </div>
    <div class="footer">
        <footer>
            <p class="footer_text">hejhej</p>
        </footer>
    </div>


</body>

</html>
