<?php
    $con = mysqli_connect("localhost", "root", "") or die(mysqli_error($con));
    mysqli_select_db($con, "biasedSearchEngine") or die(mysqli_error($con));

    $clean = mysqli_real_escape_string($con, $_GET['search']);
    $hello = mysqli_query($con, "SELECT * FROM items WHERE title = '$clean'") or die(mysqli_error($con));
    if(mysqli_num_rows($hello) >= 1){
        while($i = mysqli_fetch_array($hello)){
            echo '<a href="'.$i['url'].'">'.$i['title'].'</a><p>'. $i['url']. '<p>'. $i['description'].'<p><a>-------------------------------------------------------------------------------------</a><p>';
        }
    }
    else {
        echo "No results found, sorry :(";
    }
?>