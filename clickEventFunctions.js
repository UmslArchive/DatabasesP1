function newRowClicked() {
    //Get the relevant DOM objects.
    var updateDiv = document.getElementById("updateDiv");
    var currentTable = document.getElementById("currentTable");
    var tableRows = currentTable.rows.length - 1;
    var tableCols = currentTable.rows[0].cells.length;

    //Build innerHTML string.
    var updateDivHTMLString = "";
    updateDivHTMLString += "<form action=\"insertNewRow.php\">";
    
    //Append inputs to the string based on number of columns in the table.
    for(i = 0; i < tableCols; i++) {
        var currentAttribute = currentTable.rows[0].cells[i].innerHTML;
        updateDivHTMLString += "<input type=\"text\" name=\"" + currentAttribute + "\">"
    }
    updateDivHTMLString += "<input type=\"submit\" value=\"Enter\" href=\'index.php?fetchStudent=true\'> </form>";
    updateDiv.innerHTML = updateDivHTMLString;
}