<?php

if (isset($_GET["todo_sno"]) && $_GET["todo_sno"] == true) {
    require_once 'config.php';
    $sno = $_GET["todo_sno"];
    $sql = "SELECT * FROM `todos` WHERE `sno`=$sno";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 0){
        echo "No such todo exists!";
    }else{
        $todoArr = array();
        $row = mysqli_fetch_assoc($result);
        array_push($todoArr, array(
            "sno" => $row["sno"],
            "title" => $row["title"],
            "description" => $row["description"]
        ));
        echo json_encode($todoArr);
    }
}


?>