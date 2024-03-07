<!DOCTYPE html>
<html lang="en">
<head>
 <!--Load the AJAX API-->
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Mushrooms', 3],
          ['Onions', 1],
          ['Olives', 1],
          ['Zucchini', 1],
          ['Pepperoni', 2]
        ]);

        // Set chart options
        var options = {'title':'How Much Pizza I Ate Last Night',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  	<title>Search Results</title>
	<link rel="stylesheet" type="text/css" href="styling.css"/>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="functions.js"></script>
</head>
<body class="App" >
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
	
	<div id="mainContent" class="mainContent">
	
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div id="chart_div"></div>
		<div class="filterContiner">
			<form class="row gy-2 gx-3 align-items-center" >
				<div class="col-auto">
					<div class="input-group">
						<div class="input-group-text">Formula:</div>
						<input type="text" class="form-control" name="formula" id="autoSizingInputGroup" placeholder="Eg: C6H12O6">
						</div>
					</div>
				<div class="col-auto">
					<div class="input-group">
						<div class="input-group-text">Name:</div>
						<input type="text" class="form-control" name="name" id="autoSizingInputGroup" placeholder="Eg: Dimethyl Phthalate">
					</div>
				</div>
				<div class="col-auto">
					<div class="input-group">
						<div class="input-group-text">PI Number:</div>
						<input type="text" class="form-control" name="pId" id="autoSizingInputGroup" placeholder="Eg: PI534123 03">
					</div>
				</div>
				<div class="col-auto">
					<button type="submit" name="submit"  class="btn btn-success btn-sm" onclick="fetchData()">
					<i class="fas fa-search"></i> Search
					</button>
				</div>
			</form>
		</div>
		<div> This is some sample data</div>
		<div>
			<nav aria-label="Page navigation example">
				<ul class="pagination justify-content-end">
					<!-- <li class="page-item">
					<a class="page-link" href="#" aria-label="Previous">
						<span aria-hidden="true">&laquo;</span>
					</a>
					</li>
					<li class="page-item">
					<a class="page-link" href="#" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
					</a>
					</li> -->
				</ul>
			</nav>
		</div>
		<div class="table-responsive tableContainer">
			<table class="table table-striped">
				<thead id="tableHeader">
				<tr>
						<th scope="col">Formula</th>
						<th scope="col">Name</th>
						<th scope="col">Molecular Weight</th>
						<th scope="col">RT Min</th>
						<th scope="col">Area Max</th>
					</tr>
				</thead>
				<tbody class="tableBody" id="tableBody">

				</tbody>
			</table>
		</div>
		<div class="row">
			
			<div class="col" style="display:flex">
				<div>
				Showing 1 to 10 of 250 entries
				</div>
				<div>
					<select class="form-select" aria-label="Default select example">
						<option value="10" selected>10</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="200">500</option>
					</select>
				</div>	
			</div>
			<div class="col-8">
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-end">
						<li class="page-item">
						<a class="page-link" href="#" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						</a>
						</li>
						<li class="page-item">
						<a class="page-link" href="#" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
						</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	
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
