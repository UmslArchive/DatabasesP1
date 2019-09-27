function newRowClicked() {
    //Get the relevant DOM objects.
    var updateDiv = document.getElementById("updateDiv");
    var currentTable = document.getElementById("currentTable");
    var tableRows = currentTable.rows.length - 1;
    var tableCols = currentTable.rows[0].cells.length;

    //Build innerHTML string.
    var updateDivHTMLString = "";
    updateDivHTMLString += "<form action=\"insertNewRow.php\">";
    updateDiv.innerHTML = tableRows + "," + tableCols;

    
}