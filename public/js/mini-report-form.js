function getLinesCount(textarea) {
    var text = document.getElementById(textarea).value;
    var lines = text.split(/\r|\r\n|\n/);
    return lines.length;
}

function getInput() {

    var area = document.getElementById("bulk-area");
    var lines = area.value.replace(/\r\n/g,"\n").split("\n");
    document.getElementById('arrayOfLines').value=JSON.stringify(lines);
}

function processBulkURLs() {
    if(getLinesCount('bulk-area') > 100){
        document.getElementById('note-form').innerText="عدد الروابط تجاوز 100";
        document.getElementById('note-form').style.color="red";
    }else{
        getInput();
        document.getElementById('blk-form').submit();
    }
    // document.getElementById('note-form').innerHTML="000100";




}

window.onload = function pageLoaded() {
    document.getElementById("blk-btn").onclick = function() {processBulkURLs()};
};