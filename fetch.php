<?php
//echo "Debugging message: Reached this point"; // Make sure to end this statement with a semicolon

// Database connection
$host = "";
$user = "";
$password = "";
$database = "";
$connection = mysqli_connect($host, $user, $password, $database);

// Check database connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    //echo '<script>console.log("connection established");</script>'; // Add semicolon at the end
}

// Check if form is submitted
if (isset($_POST['submit']) && (!empty($_POST['formula']) || !empty($_POST['name']) || !empty($_POST['pId']))) {
    // Handle form submission and SQL injection vulnerability
    $sql = "SELECT * from hplc";
		$searchParam ="";
		$searchCol = "";
		$col="";
		if(!empty(@$_POST['formula'])){
			$searchCol = "formula";
			$searchParam = "Where formula=('".$_POST['formula']."') ";
		} elseif(!empty(@$_POST['name'])){
			$searchCol = "name";
			$searchParam = "Where formulaName=('".$_POST['name']."') ";
		} elseif(!empty(@$_POST['pId'])){
			$searchCol = "pId";
			$col =$_POST['pId'];
			$modifiedString = preg_replace('/[\s-]+/', '_', $col);
			//echo '<script>console.log("'.$modifiedString.' + modifiedString modifiedString modifiedString cxase"); </script>';
			$sql = "SELECT formula,formulaName,molecularWeight,rtMin,areaMax,".$modifiedString." from hplc";
		}
		$sql = "$sql $searchParam";
		// where Formula=('$searchParam') or name=('$searchrr')";
		//echo '<script>console.log("'.$sql.' + searching for this query in the database"); </script>';
		$result = mysqli_query($connection, $sql);
		//console.log("testeddd",$result)
		// $data1 =[];
		// while ($rows = $res->fetch_assoc()) {
		// 	$data1[] = $rows;
		// }
		// $response1 = json_encode($data1);
			//echo "<script> createLayout(".$response1.",'".$searchCol."','".$modifiedString."'); </script>";
} else {
    // Fetch records from the database
    $sql = "SELECT * FROM hplc LIMIT 5";
    $result = mysqli_query($connection, $sql);
}    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Send records as JSON response
    header('Content-Type: application/json');
    echo json_encode($data);

?>
