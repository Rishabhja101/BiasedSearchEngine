<html>
	<head>
		<title>The Search Engine</title>
	</head>
	<body>
        <h1 style="text-align:center">
			BSSEARCHER
		</h1>
		<form method="get" action="results.php">
			<label>What would you like to search for?</label>
			<input type="text" name="search">
			<button type="submit">Search</button>
		</form>
        <br>
        <br>
	</body>
</html>

<?php
    $con = mysqli_connect("localhost", "root", "") or die(mysqli_error($con));
    mysqli_select_db($con, "biasedSearchEngine") or die(mysqli_error($con));

    $clean = mysqli_real_escape_string($con, $_GET['search']);
    $hello = mysqli_query($con, "SELECT * FROM items WHERE title LIKE '%$clean%'") or die(mysqli_error($con));
    if(mysqli_num_rows($hello) >= 1){
        $results = array();
        $occurrences = array();
        while($i = mysqli_fetch_array($hello)){
            array_push($results, '<a href="<?php redirect('.$i['url'].') ?>">'.$i['title'].'</a><p>'. $i['url']. '<p>'. $i['description'].'<p>');
            array_push($occurrences, $i['activity']);
        }
        $got = quickSort($occurrences, 0, sizeof($results) - 1, $results);
        $occurrences = $got[0];
        $results = $got[1];
        $occurrences = reverse($occurrences);
        $results = reverse($results);
        for ($n = 0; $n < sizeof($results); $n++){
            echo $results[$n];
//            echo $occurrences[$n];
            echo "<p><a>-------------------------------------------------------------------------------------</a><p>";
        }
    }
    else {
        echo "No results found, sorry :(";
    }

    function redirect($url, $permanent = false)
    {
        window.open('http://destination.com');
        //header($url, true, $permanent ? 301 : 302);
        exit();
    }

    function reverse($array){
        $final = array();
        for ($n = 0; $n < sizeof($array); $n++){
            array_push($final, $array[sizeof($array) - $n - 1]);
        }        
        return $final;
    }

    function quickSort($array, $start, $end, $array0){
        if ($start < $end){
            $got = partition($array, $start, $end, $array0);
            $array = $got[0];
            $array0 = $got[1];
            $piv_pos = $got[2];
            $got = quickSort($array, $start, $piv_pos - 1, $array0);
            $array = $got[0];
            $array0 = $got[1];
            $got = quickSort($array, $piv_pos + 1, $end, $array0);
            $array = $got[0];
            $array0 = $got[1];
        }
        $final = array();
        array_push($final, $array);
        array_push($final, $array0);
        return $final;
    }

    function partition($array, $start, $end, $array0){
        $i = $start + 1;
        $piv = $array[$start];
        for ($j = $start + 1; $j <= $end; $j++){
            if ($array[$j] < $piv){
                $temp = $array[$i];
                $array[$i] = $array[$j];
                $array[$j] = $temp;

                $temp = $array0[$i];
                $array0[$i] = $array0[$j];
                $array0[$j] = $temp;

                $i++;
            }
        }
        $temp = $array[$start];
        $array[$start] = $array[$i - 1];
        $array[$i - 1] = $temp;

        $temp = $array0[$start];
        $array0[$start] = $array0[$i - 1];
        $array0[$i - 1] = $temp;

        $final = array();
        array_push($final, $array);
        array_push($final, $array0);
        array_push($final, $i - 1);
        return $final;
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
                else if ($n == sizeof($sortedArray) - 1){
                    array_splice($sortedArray, $n, 0, $array1[$i]);
                    array_splice($sortedArrayActivity, $n, 0, $array2[$i]);
                }
            }    
        }
        return $sortedArray;
    }

    function sorter2($array1, $array2) {
        $sortedArray = array($array1[0]);
        $sortedArrayActivity = array($array2[0]);
        for ($i = 1; $i < sizeof($array1); $i++){
            for ($n = 0; $n < sizeof($sortedArray); $n++){
                if ($sortedArrayActivity[$n] < $array2[$i]){
                    array_splice($sortedArray, $n, 0, $array1[$i]);
                    array_splice($sortedArrayActivity, $n, 0, $array2[$i]);
                    $n = sizeof($sortedArray);
                }
                else if ($n == sizeof($sortedArray) - 1){
                    array_splice($sortedArray, $n, 0, $array1[$i]);
                    array_splice($sortedArrayActivity, $n, 0, $array2[$i]);
                }
            }    
        }
        return $sortedArrayActivity;
    }
?>