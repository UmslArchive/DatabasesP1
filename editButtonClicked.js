function editButtonClicked(page, selectedRow) {
    console.log(page);
    console.log(selectedRow);
    //Get the relevant DOM objects.
    var updateDiv = document.getElementById("updateDiv");
    var currentTable = document.getElementById("currentTable");

    //Currently displayed table properties.
    var tableRows = currentTable.rows.length - 1;
    var tableCols = currentTable.rows[0].cells.length;

    //Build innerHTML string.
    var updateDivHTMLString = "";
    updateDivHTMLString += "<form action=\"update" + page + ".php\">";

    //Append inputs to the string based on number of columns in the table.
    for(i = 0; i < tableCols * 2; i++) {
        var headerVal = currentTable.rows[0].cells[i % tableCols].innerHTML;
        var currentAttribute = currentTable.rows[selectedRow].cells[i % tableCols].innerHTML;
        if(i < tableCols) {
            updateDivHTMLString += "<input type=\"text\" onclick=\"this.select()\" name=\"" + headerVal + "\" value=\"" + currentAttribute + "\">";
        }   
        else {
            updateDivHTMLString += "<input type=\"hidden\" onclick=\"this.select()\" name=\"ORIGINAL" + headerVal + "\" value=\"" + currentAttribute + "\">";
        }
            
    }
    updateDivHTMLString += "<input type=\"submit\" value=\"Update\"> </form>";
    updateDiv.innerHTML = updateDivHTMLString;
}
