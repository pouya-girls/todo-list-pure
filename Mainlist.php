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
        .done1 {
            background-color: #e6e64a;
        }
        .done2 {
            background-color: #e64839;
        }
        .done3 {
            background-color: #aa93e6;
        }
        .done4 {
            background-color: #5de640;
        }
        .done5 {
            background-color: #36e6bb;
        }
    </style>
</head>
<body>

<h2>My todo list</h2>
<ul> <!-- unordered list -->
    <?php
        $query = "select * from todos";
        if(isset($_GET['filter'])) {
            if ($_GET['filter'] == 'todo') {
                $query .= " where is_done = 0"; // where clause
            } elseif ($_GET['filter'] == 'done') {
                $query .= " where is_done = 1";
            }
        }
        $result = $connection->query($query);

        if($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if($row['is_done']) {
                    echo "<li class='done" . rand(1, 5) . "'>"; // halari ke done shode
                } else {
                    echo "<li>"; // halate aadi
                }
                echo $row['name'];
                if (!$row['is_done']) {
                    echo "<a href=\"Mainlist.php?done="
                        . $row['id']
                        . "\">Done</a>";
                }
                echo "</li>";
            }
        }
    ?>
</ul>
<div>
    [<a href="Mainlist.php?filter=all">All</a>] <br/>
    [<a href="Mainlist.php?filter=todo">Todo</a>] <br/>
    [<a href="Mainlist.php?filter=done">Done</a>] <br/>
</div>
<form method="post">
    <input name="todo" placeholder="New item">
    <button>Add</button>
</form>
</body>
</html>