// If the cells are empty, displaying NA value
document.querySelectorAll(".check").forEach(function (obj) {
    if (obj.innerText.trim() === "") {
        obj.innerText = "NA";
    }
});

// For making the Id searched global in this file
var temp;

// For copying the Email addresses of professors
function copy(emailAddr) {
    navigator.clipboard.writeText(emailAddr)
      .then(function() {
            const toast = document.getElementById("toast");
            toast.innerText = "Email address copied!";
            toast.style.display = "block";
            setTimeout(() => {
            toast.style.display = "none";
            }, 3000);
        })
      .catch(function(error) {
        console.error('Failed to copy text: ', error);
      });
  }

// Displaying the Mutation Data
function displayFunc(myJSData){
    //accessing the myJSData from the main page .php
    if(myJSData !== ""){
        //adding a division for showing the Mutation Data
		var downloadDiv = document.createElement("div");
		downloadDiv.setAttribute("id","submission-list");
        document.getElementById("tableID").after(downloadDiv);
        //adding Download Button
        showDownload();

        // Splitting the one Mutation Detail data into an array
        var mutData = myJSData.split("||");

        // Creating a new <ul> element
        var list = document.createElement("ul");

        // Creating a headerfor the Mutation
        var newList = document.createElement("li");
        newList.innerText = "Mutant_ID; SNP_location; mutation_effect; amino_acid_change;homozyhous or hetrozygous;low read depth;SIFT score;SIFT median;Ref_allele;Alt_allele";
        newList.style.fontSize = "16px";
        newList.style.fontWeight = "bold";
        newList.style.backgroundColor = "black";
        newList.style.color = "white";
        list.appendChild(newList);

        // Adding the mutation array data to a new <li> element
        for (var i = 0; i < mutData.length-1; i++) 
            {
                var newList = document.createElement("li");
                newList.innerText = mutData[i];
                list.appendChild(newList);
            }

            // Adding <ul> to the parent page
            document.getElementById("submission-list").appendChild(list);
        }
        
}

function showDownload(){
    // Creating a Button to download the displayed Data only if Data is present
    var newButton = document.createElement("button");
    newButton.setAttribute("id","downloadBtn");
    newButton.innerText = "Download the Data";

    newButton.onclick = function() {
        // Calling the export function
        exportTableToCSV('myTable.csv');
    };

    // Adding the button to the parent page
    document.getElementById("submission-list").appendChild(newButton);
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // Assigning CSV file function
    csvFile = new Blob([csv], {type: "text/csv"});

    // Creating a dummy Download link
    downloadLink = document.createElement("a");

    // assigning the File name from the function call
    downloadLink.download = filename;

    // Creating a link to the csv file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hiding the download link
    downloadLink.style.display = "none";

    // Adding link to the main page
    document.body.appendChild(downloadLink);

    // automating the download link
    downloadLink.click();
}

function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");

    //console.log(rows);
    for (var i = 0; i < rows.length; i++) {
        var row1 = [], cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++) {
            row1.push('"' + cols[j].innerText + '"');
        }
        
        csv.push(row1.join(","));
        console.log(i+" CSV-> "+csv);
    }

    csv.push([]);

    var list = document.querySelector(".App ul");
    var items = list.querySelectorAll(".App li");

    for (var i = 0; i < items.length; i++) {
        var row2 = ['"'+items[i].textContent.trim()+'"'];
        csv.push(row2.join(","));
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}