<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  	<title>Search Results</title>
	<link rel="stylesheet" type="text/css" href="styling.css"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="functions.js"></script>
</head>
<body class="App" >
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
 	<div class="information">
		<div class="bg">
			<div class="bg2" style="margin-bottom:10px;">
				<img class ="SorbMutDB_logo" alt="SorbMutDB_logo" src="https://www.depts.ttu.edu/igcast/Genome_test/SorbMutDB_logo.png"/>
				<p class="_h1" style="padding:10px;">SorbMutDB <br/>(Sorghum bicolor Mutation Database)</p>
			</div>
        </div>
		
        <form method="post" class = "bg">
			<p class="intro"><b>SorbMutDB</b> provides information on the sequence indexed EMS-induced mutations of 1,000 Sorghum mutant lines in the genetic background of the reference genome line Btx623. To provide a solid platform, SorbMutDB maintains a sizable collection of mutation-related data and its impact at the amino acid level in an adaptive framework. Information provided includes the details about the mutant plant line with its ID information, chromosome, location, the function of the gene in Arabidopsis thaliana and Rice (Oryza sativa), the number of mutants affected and a number of alleles, and a detailed summary of mutation type with the SIFT (Sorting Intolerant from Tolerant) score.</p>
			<div class="toast-message">
				<h4 style="font-size:150%; text-align:center; word-wrap: break-word; width: 80%;">To request seeds of the mutants, please email: <a class="mailId" onclick="copy('Zhanguo.Xin@ttu.edu')">Dr. Zhanguo Xin</a> or <a class="mailId" onclick="copy('yijiao@ttu.edu')">Dr. Yinping Jiao</a>.</h4>
				<div id="toast" style="display: none"></div>
			</div>
			<div class="row">
				<div class="col">
				<input type="text" name="search" id= "inp2" pattern = "^(Sobic\.[A-Z0-9]{10})(?:,?(Sobic\.[A-Z0-9]{10}))*$|^(Sb[a-z0-9]{9})(,(Sb[a-z0-9]{9}))*$" required="true"
				placeholder="e.g. Sobic.001G006700" style="margin-top: 15px"/>
				</div>
				<div class="infoIcon col">
					<div  data-bs-toggle="tooltip" data-bs-placement="top" title="To search multiple genes, please separate the gene IDs by a comma. For example 'Sobic.001G006700,Sobic.001G006900'.">
						<svg xmlns="http://www.w3.org/2000/svg" width="36" height="30" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
							<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
						</svg>
					</div>
				</div>
  			</div>
			<label style="text-align:justify;">Users start by browsing a list of genes or using a specific gene identifier to search the database <br/>(e.g., <em>"Sobic.001G006700"</em> or <em>"Sb01g004380"</em> with sorghum BTx623 reference genome v3.1.1 and V1.4 gene_id).</label>
			<button class="mutationBtn" type="submit" name="submit" value="Search"> Mutation Summary</button>
        </form>
    </div>
	
	<hr width="100%" height="10px" color="red" />

	<?php
	// Credentials to connect to Database
	$host = "localhost";
	$user = "natsu";
	$password = "12#\$qwER";
	$database = "igcast_main";

    //echo $password;
	// Connecting to the database
	$connection = mysqli_connect($host, $user, $password, $database);

	// checking connection
	if (!$connection) {
		die("Connection failed: " . mysqli_connect_error());
	}
    else
    {
        echo '<script>console.log("connection establiashed"); </script>';
    }

    
	// check if the search button is clicked
	if (isset($_POST['submit'])) {

		$searchrr = $_POST['search'];
		$pattern = "/^(Sobic\.[A-Z0-9]{10})(?:,?(Sobic\.[A-Z0-9]{10}))*$/";
		$search = mysqli_real_escape_string($connection, $searchrr);
		if(preg_match($pattern,$searchrr))
		{
			//echo '<script>console.log("'.$search.' + ifcase"); </script>';
			$searchArr = explode(',',$search);
			$searchStr = implode("','", $searchArr);
			// search query for V3 gene ID
			$sql = "SELECT * FROM igcast_db_main WHERE V3_1_1_gene_id IN ('$searchStr')";
		}
		else
		{
			//echo '<script>console.log("'.$searchrr.' + elsecase"); </script>';
			$searchArr = explode(',',$search);
			$searchStr = implode("','", $searchArr);
			// search query for V1 gene ID
			$sql = "SELECT * FROM igcast_db_main WHERE V1_4_gene_id IN ('$searchStr')";
		}

		// fetching the Data from he SQL Table
		$result = mysqli_query($connection, $sql);

		// display search results
		if (mysqli_num_rows($result) > 0) {
			echo '<script>console.log("Data Fetched");</script>';
			$count = 0;
			$accordionId ="";
			while ($row = mysqli_fetch_assoc($result)) {
				$tableid = $row['V3_1_1_gene_id'];
				$headerId = 'header'.$count;
				$collapseId = 'collapse'.$count;
				$targetCollapse = '#'.$collapseId;
				$accordionId ="accordion".$count;
				$parentId = "#".$accordionId;
				echo "<div class='accordion' id='$accordionId'>";
				echo "<div class='accordion-item'>
    			 			<h2 class='accordion-header' id='{$headerId}'>
      			 			<button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='$targetCollapse' aria-expanded='true' aria-controls='$collapseId'>". $tableid . "</button>
    				 		</h2>
    				 	<div id='$collapseId' class='accordion-collapse collapse show' aria-labelledby='$headerId' data-bs-parent='$parentId'>
      						<div class='accordion-body'>";
							  echo "<table class='tableMain' id = '{$tableid}'>";
							  echo "<tr>
									  <th>#V1.4 Gene.Id:</th>
									  <th>#V3.1.1 Gene Id:</th>
									  <th>Function in Arabidopsis (i)</th>
									  <th>Function in Arabidopsis (ii)</th>
									  <th>Function in Araidopsis (iii)</th>
									  <th>Function in Rice (i)</th>
									  <th>Function in Rice (ii)</th>
									  <th>No. of Mutants</th>
									  <th>No. of Alleles</th>
								  </tr>";					  
							  echo "<tr>
									  <td class=check>" . $row['V1_4_gene_id'] ."</td>
									  <td class=check>" . $row['V3_1_1_gene_id']. "</td>
									  <td class=check>" . $row['Function_in_Arabidopsis_i']. "</td>
									  <td class=check>" . $row['Function_in_Arabidopsis_ii']. "</td>
									  <td class=check>" . $row['Function_in_Arabidopsis_iii']. "</td>
									  <td class=check>" . $row['Function_in_Rice_i']. "</td>
									  <td class=check>" . $row['Function_in_Rice_ii']. "</td>
									  <td class=check>" . $row['No_of_Mutants']. "</td>
									  <td class=check>" . $row['No_of_Alleles']. "</td>
								  </tr>";
							  // Closing the table
						  echo "</table>";						  
						 
							  // Encoding the Data as a JSON String
							  $mutData = json_encode($row['Mutation_Detail']);
			  
							  // Pass the PHP variable holding the JSON String to a JavaScript variable
							  if (isset($mutData))
								  echo "<script>
								  displayFunc('".$row['V3_1_1_gene_id']."',".$mutData.");
								  </script>";
						echo'</div>
  					 		</div>
					 		</div>
							</div>';						
				$count++;
			}
			echo "<script>newDiv('$accordionId','$count');</script>";
			echo "<script>showDownload();</script>";
		} 
		else 
		{
			// If no result is found
			echo "<center><font size=+2><b>No results found. </b></font><center>";
		}	
	}

	

	// Closing the connection
	mysqli_close($connection);
	?>
	<script>
// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
</body>
<script src="functions.js"></script>
</html>
