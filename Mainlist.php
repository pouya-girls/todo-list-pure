<?php
$connection = new mysqli(
        '127.0.0.1',
        'root',
        '',
        'todo_list'
);

if(isset($_POST['todo'])) {
    $todo = $_POST['todo'];

    $connection->query("insert into todos (name) values ('"
        . $todo
        . "')");
}

if(isset($_GET['done'])) {
    $id = $_GET['done'];

    $connection->query("update todos set is_done = 1 where id=" . $id);
}
?>
<html>
<head>
    <title>My todo list</title>
    <style>
        .done {
            background-color: #e6e64a;
        }
    </style>
</head>
<body>

<h2>My todo list</h2>
<ul> <!-- unordered list -->
    <?php
        $result = $connection->query("select * from todos");

        if($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if($row['is_done'] == 1) {
                    echo "<li class='done'>"; // halari ke done shode
                } else {
                    echo "<li>"; // halate aadi
                }
                echo $row['name'];
                echo "<a href=\"Mainlist.php?done="
                    . $row['id']
                    . "\">Done</a>";
                echo "</li>";
            }
        }
    ?>
</ul>

<form method="post">
    <input name="todo" placeholder="New item">
    <button>Add</button>
</form>
</body>
</html>