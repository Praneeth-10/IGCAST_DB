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
            toast.style.display = "inline";
            setTimeout(() => {
            toast.style.display = "none";
            }, 3000);
        })
      .catch(function(error) {
        console.error('Failed to copy text: ', error);
      });

    // Creating a mailto link for the copied email address
    var mailtoLink = "mailto:" + emailAddr;

    // Opening mailbox in a new tab
    window.open(mailtoLink, "_blank");
  }

// Displaying the Mutation Data
function displayFunc(mutID,myJSData){
    //Accessing the myJSData and mutID from the main page .php
    if(myJSData !== ""){

        // Creating a Table with Table head first
        var table = document.createElement("table");

        // Getting the heading variable and would split into the table head
        var headRow = "V3_ID; Mutant_ID; SNP_location; Mutation_effect; Amino_acid_change; Homozyhous or Hetrozygous; Low read depth; SIFT score; SIFT median; Ref_allele; Alt_allele";

        // Spliting the Head row into columns and adding it to <th> element
        headColumns = headRow.split(";");

        // Creating table head and table row for a table
        var thead = document.createElement("thead");
        var tr = document.createElement("tr");

        for(var i = 0; i < headColumns.length; i++)
        {
            var th = document.createElement("th");
            th.textContent = headColumns[i].trim();
            tr.appendChild(th);
        }

        // Adding the Head row to the table head
        thead.appendChild(tr);
        
        // Append the table head to the table
        table.appendChild(thead);

        // Creating table head and table row for a table
        var tBody = document.createElement("tbody");

        // Splitting the one Mutation Detail data into an array
        var mutData = myJSData.split("||");

        for (var i = 0; i < mutData.length-1; i++) {
            var tr = document.createElement("tr");
            var Id = document.createElement("td");
            Id.textContent = mutID.trim();
            tr.appendChild(Id);

            var mutDetail = mutData[i].split(";");

            for(var j = 0; j < headColumns.length-1; j++){
                if(mutDetail[j]){
                    var td = document.createElement("td");
                    td.textContent = mutDetail[j].trim();
                    tr.appendChild(td);
                }
                else{
                    var td = document.createElement("td");
                    td.textContent = "";
                    tr.appendChild(td);
                }       
            }
            tBody.appendChild(tr);
        }

        table.appendChild(tBody);

        document.getElementById("submission-list").appendChild(table);
    }
        
}

// Adding a division for showing the Mutation Data
function newDiv(){
	var downloadDiv = document.createElement("div");
	downloadDiv.setAttribute("id","submission-list");
    document.getElementById("tableID").after(downloadDiv);

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
    newButton.style.marginBottom = "10px";

    // Adding the button to the parent page
    document.getElementById("submission-list").before(newButton);
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // Assigning CSV file function
    csvFile = new Blob([csv], {type: "text/csv"});

    // Creating a dummy Download link
    downloadLink = document.createElement("a");

    // Assigning the File name from the function call
    downloadLink.download = filename;

    // Creating a link to the csv file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hiding the download link
    downloadLink.style.display = "none";

    // Adding link to the main page
    document.body.appendChild(downloadLink);

    // Automating the download link
    downloadLink.click();
}

function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll(".App table tr");

    //console.log(rows);
    for (var i = 0; i < rows.length; i++) {
        var row1 = [], cols = rows[i].querySelectorAll(".App td, th");

        for (var j = 0; j < cols.length; j++) {
            row1.push('"' + cols[j].innerText + '"');
        }
        
        csv.push(row1.join(","));
        //console.log(i+" CSV-> "+csv);
    }
    csv.push([]);


    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}
