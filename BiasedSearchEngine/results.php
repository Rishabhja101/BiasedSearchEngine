<?php
    $con = mysqli_connect("localhost", "root", "") or die(mysqli_error());
    mysqli_select_db($con, "biasedSearchEngine") or die(mysqli_error());

  
?>