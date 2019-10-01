function newRowClicked(page, selectedRow) {

    console.log(page);

    //Get the relevant DOM objects.
    var updateDiv = document.getElementById("updateDiv");
    var currentTable = document.getElementById("currentTable");

    //Currently displayed table properties.
    var tableRows = currentTable.rows.length - 1;
    var tableCols = currentTable.rows[0].cells.length;

    //Build innerHTML string.
    var updateDivHTMLString = "";
    updateDivHTMLString += "<form action=\"insert" + page + ".php\">";
    
    //Append inputs to the string based on number of columns in the table.
    for(i = 0; i < tableCols; i++) {
        var currentAttribute = currentTable.rows[0].cells[i].innerHTML;
        updateDivHTMLString += "<input type=\"text\" onclick=\"this.select()\" name=\"" + currentAttribute + "\" value=\"" + currentAttribute + "\">"
    }
    updateDivHTMLString += "<input type=\"submit\" value=\"Enter\"> </form>";
    updateDiv.innerHTML = updateDivHTMLString;
}