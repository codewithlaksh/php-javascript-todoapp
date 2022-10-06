<?php
// This file contains the server side scripting for the app

require_once 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST["type"];
    
    $serverMsg = array();
    
    if ($type == "addtodo") {
        $title = $_POST["title"];
        $description = $_POST["description"];
        if (empty(trim($title)) || empty(trim($description))) {
            array_push($serverMsg, array(
                "status" => "error",
                "message" => "Title or description cannot be blank!"
            ));
            echo json_encode($serverMsg);
        }else{
            $sql = "INSERT INTO `todos` (`title`, `description`) VALUES ('$title', '$description')";
            $result = mysqli_query($conn, $sql);
    
            if ($result) {
                array_push($serverMsg, array(
                    "status" => "success",
                    "message" => "Your todo has been added successfully!"
                ));
            }
        
            echo json_encode($serverMsg);
        }
    }
    elseif ($type == "updatetodo") {
        $sno = $_POST["snoEdit"];
        $title = $_POST["titleEdit"];
        $description = $_POST["descriptionEdit"];

        if (empty(trim($title)) || empty(trim($description))) {
            array_push($serverMsg, array(
                "status" => "error",
                "message" => "Title or description cannot be blank!"
            ));
            echo json_encode($serverMsg);
        }else{
            $sql = "UPDATE `todos` SET `title`='$title', `description`='$description' WHERE `todos`.`sno`=$sno";
            $result = mysqli_query($conn, $sql);
    
            if ($result) {
                array_push($serverMsg, array(
                    "status" => "success",
                    "message" => "Your todo has been updated successfully!"
                ));
            }
        
            echo json_encode($serverMsg);
        }
    }
    elseif ($type == "deletetodo") {
        $sno = $_POST["snoDelete"];

        $sql = "DELETE FROM `todos` WHERE `todos`.`sno`=$sno";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            array_push($serverMsg, array(
                "status" => "success",
                "message" => "Your todo has been deleted successfully!"
            ));
        }
    
        echo json_encode($serverMsg);
    }
}

?>