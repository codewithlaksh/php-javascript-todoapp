<?php

if (isset($_GET["gettodos"]) && $_GET["gettodos"] == true) {
    require_once 'config.php';
    $sql = "SELECT * FROM `todos`";
    $result = mysqli_query($conn, $sql);
    $todosArr = array();

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($todosArr, array(
            "sno" => $row["sno"],
            "title" => $row["title"],
            "description" => $row["description"],
            "updated" => $row["updated"],
            "created" => $row["created"],
        ));
    };
    echo json_encode($todosArr);
}


?>