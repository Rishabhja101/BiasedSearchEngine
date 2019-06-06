<?php
    $con = mysqli_connect("localhost", "root", "") or die(mysqli_error($con));
    mysqli_select_db($con, "biasedSearchEngine") or die(mysqli_error($con));

    $clean = mysqli_real_escape_string($con, $_GET['search']);
    $hello = mysqli_query($con, "SELECT * FROM items WHERE title = '$clean'") or die(mysqli_error($con));
    if(mysqli_num_rows($hello) >= 1){
        $results = array();
        $occurrences = array();
        while($i = mysqli_fetch_array($hello)){
            array_push($results, '<a href="'.$i['url'].'">'.$i['title'].'</a><p>'. $i['url']. '<p>'. $i['description'].'<p><a>-------------------------------------------------------------------------------------</a><p>');
            array_push($occurrences, $i['activity']);
        }
        $results = sorter($results, $occurrences);
        for ($n = 0; $n < sizeof($results); $n++){
            echo $results[$n];
            echo $occurrences[$n];
        }
    }
    else {
        echo "No results found, sorry :(";
    }

    function sorter($array1, $array2) {
        $sortedArray = array($array1[0]);
        $sortedArrayActivity = array($array2[0]);
        for ($i = 1; $i < sizeof($array1); $i++){
            for ($n = 0; $n < sizeof($sortedArray); $n++){
                if ($sortedArrayActivity[$n] < $array2[$i]){
                    array_splice($sortedArray, $n, 0, $array1[$i]);
                    array_splice($sortedArrayActivity, $n, 0, $array2[$i]);
                    $n = sizeof($sortedArray);
                }
            }    
        }
        return $sortedArray;
    }
?>