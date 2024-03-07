
function fetchData() {debugger;
    currentPage = 1;
    // Fetch data from fetch_data.php using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'fetch.php?page=' + currentPage, true);
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            // Parse JSON response
            records = JSON.parse(xhr.responseText);
            console.log("response::::", records)
            createLayout(records);
            // renderPagination();
        } else {
            console.error('Failed to fetch data');
        }
    };
    xhr.onerror = function () {
        console.error('Failed to fetch data');
    };
    xhr.send();
}

// Initial fetching of data and rendering pagination
fetchData();

function createLayout(response, searchCol, col) {
    renderTable(response, searchCol, col)
    // call pagination function to create layout for it
//paginationLayout(response,searchCol, col)
    

}

function renderTable(res, searchCol, col,itemsPerPage,page){
    console.log("response:::::::::",res, searchCol, col,itemsPerPage,page)
    // var startIndex = (page - 1) * itemsPerPage;
    // var endIndex = startIndex + itemsPerPage;
    var response = res;//res.slice(startIndex, endIndex);

    let headKeys = ["formula", "formulaName", "molecularWeight", "rtMin", "areaMax"];
    if (document.getElementById("#tableBody")) {
        document.getElementById("#tableBody").remove();
    }
console.log("after slice", response)
    if (searchCol === "name" || searchCol === "formula") {
        let table = document.querySelector("table");
        table.deleteTHead();
        for (const [key, value] of Object.entries(response[0])) {
            let tr = document.createElement("tr");
            var headKey = document.createElement("td");
            headKey.textContent = key;
            tr.appendChild(headKey);
            var headVal = document.createElement("td");
            headVal.textContent = value;
            tr.appendChild(headVal);
            document.getElementById("tableBody").appendChild(tr);
        }
    } else {
        let header = ["PI534123_03", "PI534124_02", "PI534127_03"]
        if (searchCol === "pId") {
            console.log("pid", col)
            headKeys.push(col);
            header = [col]
        } else {
            headKeys = headKeys.concat(["PI534123_03", "PI534124_02", "PI534127_03"])
        }
        createHeader(header);
        for (let i = 0; i < response.length; i++) {
            let tr = document.createElement("tr");
            for (let j = 0; j < headKeys.length; j++) {

                let td = document.createElement("td");
                td.textContent = response[i][headKeys[j]];
                tr.appendChild(td);
            }
            document.getElementById("tableBody").appendChild(tr);
        }
    }
}
function createHeader(headerArr) {
    for (let j = 0; j < headerArr.length; j++) {
        let head = headerArr[j].replace(/_/g, ' ');
        // Select the table head element
        var tableHead = document.querySelector("#tableHeader > tr");

        // Create a new th element
        var newTh = document.createElement("th");
        newTh.textContent = head; // Set the text content of the new th element

        // Append the new th element to the table head row
        tableHead.appendChild(newTh);
    }
}

function paginationLayout(items,searchCol, col,currentPage) {
    var currentPage = currentPage ? currentPage :1;
        var itemsPerPage = 10;
        var paginationWindow = 5;
    var totalPages = Math.ceil(items.length / itemsPerPage);
    var paginationContainer = document.querySelectorAll(".pagination");
    

    var startPage = Math.max(1, currentPage - Math.floor(paginationWindow / 2));
    var endPage = Math.min(totalPages, startPage + paginationWindow - 1);
    paginationContainer.forEach(function(div) {
        div.innerHTML = "";
    // if (startPage > 1) {
        var newLi = document.createElement('li');
        newLi.className = 'page-item'; // Set the class name for the new li
        var newAnchor = document.createElement('a');
        newAnchor.className = 'page-link'; // Set the class name for the new anchor link
        newAnchor.href = '#'; 
        newAnchor.setAttribute("aria-label", "Previous");
       
        var span = document.createElement("span");
        span.setAttribute("aria-hidden", "true");
        span.textContent = "«"; // This is the &laquo; symbol
        newAnchor.appendChild(span);
        newLi.appendChild(newAnchor);
        newLi.addEventListener("click", function(event) {
            event.preventDefault();
            currentPage--;
           // renderTable(currentPage);
           // paginationLayout();
        });
        div.appendChild(newLi);
    // }

    for (var i = startPage; i <= endPage; i++) {
        var newLi = document.createElement('li');
        newLi.className = 'page-item'; // Set the class name for the new li
        var newAnchor = document.createElement('a');
        newAnchor.className = 'page-link'; // Set the class name for the new anchor link
        newAnchor.href = '#'; // Set the href attribute for the anchor link
        newAnchor.textContent = i; // Set the text content for the anchor link
        newLi.appendChild(newAnchor);
       
        //pageLink.textContent = i;
        if (i === currentPage) {
            newAnchor.classList.add("active");
        }
        newAnchor.addEventListener("click", function(event) {
            event.preventDefault();
            currentPage = parseInt(event.target.textContent);
            renderTable(items,searchCol,col,10,currentPage);
            paginationLayout(items,searchCol,col,currentPage);
        });
        div.appendChild(newLi);
    }

    
        var newLi = document.createElement('li');
        newLi.className = 'page-item'; // Set the class name for the new li
        var newAnchor = document.createElement('a');
        newAnchor.className = 'page-link'; // Set the class name for the new anchor link
        newAnchor.href = '#'; // Set the href attribute for the anchor link
      //  newAnchor.textContent = i; // Set the text content for the anchor link
        newAnchor.setAttribute("aria-label", "Next");
       
        var span = document.createElement("span");
        span.setAttribute("aria-hidden", "true");
        span.textContent = "»"; // This is the &laquo; symbol
        newAnchor.appendChild(span);
        newLi.appendChild(newAnchor);
        newLi.addEventListener("click", function(event) {
            event.preventDefault();
            currentPage++;
           // displayData(currentPage);
           // renderPagination();
        });
        div.appendChild(newLi);
    // }
})
}
function paginationLayout1(res){debugger
    var page = Math.ceil(res/10);
     // Get the reference to the UL element
  var divs = document.querySelectorAll('.pagination');
  // Create and append five new list items after the first one <li class="page-item"><a class="page-link" href="#">1</a></li>
  divs.forEach(function(div) {
    for (var i = 0; i < page; i++) {
      // Get all list items within the UL
    var lis = div.getElementsByTagName("li");
  
    // Calculate the index of the last list item
    var lastLiIndex = lis.length - 1;
      var newLi = document.createElement('li');
      newLi.className = 'page-item'; // Set the class name for the new li
      var newAnchor = document.createElement('a');
      newAnchor.className = 'page-link'; // Set the class name for the new anchor link
      newAnchor.href = '#'; // Set the href attribute for the anchor link
      newAnchor.textContent = i + 1; // Set the text content for the anchor link
      newLi.appendChild(newAnchor);
      div.insertBefore(newLi, lis[lastLiIndex]);
    }

  });
}




function showDownload() {
    // Creating a Button to download the displayed Data only if Data is present
    var newButton = document.createElement("button");
    newButton.setAttribute("id", "downloadBtn");
    newButton.setAttribute("class", "mutationBtn");
    newButton.innerText = "Download the Data";

    newButton.onclick = function () {
        // Calling the export function
        exportTableToCSV('myTable.csv');
    };
    newButton.style.marginBottom = "10px";

    // Adding the button to the parent page
    document.getElementById("submission-list").appendChild(newButton);
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // Assigning CSV file function
    csvFile = new Blob([csv], { type: "text/csv" });

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
