<?php
require_once('config.php');
include("config.php");
$id = 3351;

for($i=0;$i >= 1000; $i++){
    mysqli_query($conn, "UPDATE dados SET id='".$id."' WHERE data='19/11/2021 12:00:00'");
    $id++;
}
?>
