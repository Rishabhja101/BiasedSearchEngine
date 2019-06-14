<html>
	<head>
		<title>BSSEARCHER</title>

        <!-- Bootstrap CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body class="container" style="padding-top:50px;">
        <h1 class="text-center display-4">
			<a style="font-size:55px; color:blue;">B</a><a style="font-size:53px; color:red;">S</a><strong style="font-size:51px; color:grey; font-weight: 800;">S</strong><strong style="font-size:49px; color:blue; font-weight: 800;">E</strong><strong style="font-size:47px; color:green; font-weight: 800;">A</strong><strong style="font-size:47px; color:red; font-weight: 800;">R</strong><strong style="font-size:49px; color:purple; font-weight: 800;">C</strong><strong style="font-size:51px; color:brown; font-weight: 800;">H</strong><a style="font-size:53px; color:orange">E</a><a style="font-size:55px; color:green">R</a>
		</h1>
		<form class="form-group" method="get" action="results.php">
            <div class="form-group col-12" style="text-align:center">
            <div style="padding-left:20%; padding-right:20%;">
				<input class="form-control mb-4" type="text" name="search">
			</div>
                <button class="btn btn-lg btn-primary" style="width: 20%;" type="submit">Search</button>
            </div>
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
            array_push($results, '<a href="'.$i['url'].'" style="font-size:20px;">'.$i['title'].'</a><p style="font-size: 12px; color:#008001">'. $i['url']. '<p>'. $i['description'].'<p>');
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
            echo "<hr>";
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

<html>
    <footer style="padding-top:50px;">
	    <h3>
			Background information about BSSEARCHER:
		</h3>
		<p style="text-align:justify">
			Currently, there are no industry standards for how corporations regulate the development and training of their AI algorithms to limit bias. This leaves the public in danger of being abused by these corporations since they will unknowingly be using these bias algorithms which they blindly trust to provide them with unbiased information. Ideally, the govenment should set industry standards for processes of developing and training AI algorithms to limit inherent bias. To demonstrate this problem with, I have developed simple search engine ("BSSEARCHER") which I have trained to be biased and right-winged in politics to demonstrate how corporations that are unregulated may be able to allow bias into thier services which manipulates their consumers. Here is a link to a more in-depth explanation of the problem along with the proposed solution in an essay about why we need <a href="https://docs.google.com/document/d/1z1vpHm3PhNq2tdGRLLQwA5cFtVScbh51Xtbyk2gVIQs/edit?usp=sharing">Government Regulation on AI</a>.
		</p>
	</footer>
</html>