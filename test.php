<!DOCTYPE html>
<html lang="en">
<head>
	<title>Search Results</title>
    <link rel="stylesheet" type="text/css" href="styling.css"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="functions.js"></script>
</head>
<body class="App" >
	<div class="information">
		<div class="bg">
			<div class="bg2" style="margin-bottom:10px;">
				<img class ="SorbMutDB_logo" alt="SorbMutDB_logo" src="https://www.depts.ttu.edu/igcast/Genome_test/SorbMutDB_logo.png"/>
				<p class="_h1" style="padding:10px;">SorbMutDB <br/>(Sorghum bicolor Mutation Database)</p>
			</div>
        </div>
		
        <form method="post" class = "bg">
			<p class="intro"><b>SorbMutDB</b> provides information on the sequence indexed EMS-induced mutations of 1,000 Sorghum mutant lines in the genetic background of the reference genome line Btx623. To provide a solid platform, SorbMutDB maintains a sizable collection of mutation-related data and its impact at the amino acid level in an adaptive framework. Information provided includes the details about the mutant plant line with its ID information, chromosome, location, the function of the gene in Arabidopsis thaliana and Rice (Oryza sativa), the number of mutants affected and a number of alleles, and a detailed summary of mutation type (such synonymous, synonymous-synonymous, coding, or non-coding, the altered amino acids, and whether it is heterozygous or homozygous, along with SIFT (Sorting Intolerant from Tolerant) score.</p>
			<div class="toast-message">
				<h4 style="font-size:150%; text-align:center;">To request seeds of the mutants, please email: <a onclick="copy('Zhanguo.Xin@ttu.edu')">Dr. Zhanguo Xin</a> or <a onclick="copy('yijiao@ttu.edu')">Dr. Yinping Jiao</a>.</h4>
				<div id="toast" style="display: none"></div>
			</div>
			<input type="text" name="search" id= "inp2" pattern = "(^Sobic\.[A-Z\d]{10}$)|(^Sb[a-z\d]{9}$)" required="true"
				placeholder="e.g. Sobic.001G006700" style="margin-top: 15px"/>
			<label style="text-align:justify;">Users start by browsing a list of genes or using a specific gene identifier to search the database <br/>(e.g., <em>"Sobic.001G006700"</em> or <em>"Sb01g004380"</em> with sorghum BTx623 reference genome v3.1.1 and V1.4 gene_id).</label>
			<button type="submit" name="submit" value="Search"> Mutation Summary</button>
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
		$pattern = "/^Sobic\.[A-Z\d]{10}$/";
		$search = mysqli_real_escape_string($connection, $searchrr);
		if(preg_match($pattern,$_POST['search']))
		{
			echo '<script>console.log("'.$_POST['search'].'"); </script>';
			// search query for V3 gene ID
			$sql = "SELECT * FROM igcast_db_main WHERE V3_1_1_gene_id = '$search'";
		}
		else
		{
			echo '<script>console.log("'.$_POST['search'].'"); </script>';
			// search query for V1 gene ID
			$sql = "SELECT * FROM igcast_db_main WHERE V1_4_gene_id = '$search'";
		}

		// fetching the Data from he SQL Table
		$result = mysqli_query($connection, $sql);

		// display search results
		if (mysqli_num_rows($result) > 0) {
			echo '<script>console.log("Data Fetched"); </script>';
			echo "<table id = 'tableID'>";
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
			
			while ($row = mysqli_fetch_assoc($result)) {
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
				
				// Encoding the Data as a JSON String
				$mutData = json_encode($row['Mutation_Detail']);

				// Pass the PHP variable holding the JSON String to a JavaScript variable
				if (isset($mutData))
					echo "<script>
					displayFunc(".$mutData .");
					</script>";
			}

			// Closing the table
			echo "</table>";
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

</body>
<div class="zxc">
	<ul>
		<li>Test 1</li>
		<li>Test 2</li>
		<li>Test 3</li>
		<li>Test 4</li>
	</ul>
</div>
<script src="functions.js"></script>
</html>
