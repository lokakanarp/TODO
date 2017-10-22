<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TO-DO</title>

    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
</head>

<body>
    <main>
        <form method="POST">
            <h1>Lokas att göra-lista</h1>
            <p>Lägg till uppgift:<br>
                <input type="text" name="title">
            </p>
            <p>Skapad av:<br>
                <input type="text" name="createdBy">
            </p>
            <input class="button" type="submit" value="Skicka" />

        </form>
        <?php
        require 'database.php'; 
        if(isset($_POST["title"])) {
            $statement = $pdo->prepare(
                "INSERT INTO todo_list (title, createdBy)
                VALUES (:title, :createdBy)");
            $statement->execute(array(
                ":title" => $_POST["title"],
                ":createdBy" => $_POST["createdBy"]));
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
        $statement = $pdo->prepare("SELECT * FROM todo_list");
        $statement->execute();
        $fetched = $statement->fetchAll(PDO::FETCH_ASSOC);
        $todo_list = array_reverse($fetched);
        ?>

        <h2>Att göra:</h2>
        <table>
            <thread>
                <tr>
                    <th>Nr</th>
                    <th>Uppgift</th>
                    <th>Skapad av</th>
                    <th>Klar</th>
                    <th>Radera</th>
                </tr>
            </thread>
            <form method="POST">
                <tbody>
                    <?php
            foreach($todo_list as $i){ ?>
                        <tr>
                            <td>
                                <?php echo $i['id']; ?>
                            </td>
                            <td>
                                <?php echo $i['title']; ?>
                            </td>
                            <td>
                                <?php echo $i['createdBy']; ?>
                            </td>
                            <td>
                                <input type="checkbox" name="completed" value="<?= $i['id']; ?> ">
                                <input type="checkbox" name="delete" value="<?= $i['id']; ?> "></td>
                        </tr>
                        <?php
                 }  ?>
                            <input class="button" type="submit" value="Skicka" />
                </tbody>

            </form>
        </table>
    </main>
    <footer></footer>
</body>

</html>
