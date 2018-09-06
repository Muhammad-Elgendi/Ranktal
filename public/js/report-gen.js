var response;
var isCompleted = false;
var isFailed = false;
var refreshIntervalId;
var errorsCount;
var passedCount;
var progress;


function loadData() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            response = JSON.parse(this.responseText);
            if (response.isFailed === true) {
                isFailed = true;
            }
            if (response.isCompleted === true) {
                isCompleted = true;
            }
            change();
            if (isCompleted) {
                clearInterval(refreshIntervalId);
                complete();
            }
            if (isFailed) {
                clearInterval(refreshIntervalId);
                fail();
            }
        }
    };
    request.open("GET", reportURL, true);
    request.send();
}

function fail() {
    // fail state code here
    document.getElementById('content-container').innerHTML = "";
    var content;
    content = "<div class=\"alert alert-danger\">\n" +
        "  <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
        "   <strong>تنبيه</strong>\n" +
        "      <article>حدث خطأ أثناء إعداد التقرير , تفقد الحالات الأتية</article>\n" +
        "        <div class=\"clear padding-top\">\n" +
        "   <ul>" +
        "<li>أدخال رابط غير صحيح للفحص أو أن الرابط غير موجود حالياً</li>" +
        "<li>حدوث خطأ أثناء الإتصال بالرابط</li>" +
        "<li>إذا كنت متأكد من أن الرابط صحيح و يمكن زيارته راسل الدعم الفني</li>" +
        "</ul>" +
        "        </div> " +
        "  </div>";
    document.getElementById('content-container').insertAdjacentHTML('beforeend',
        content
    );

}

function complete() {
    // complete state code here
    document.getElementById('process-container').outerHTML = "";
    document.getElementById('download-btn').style.display = "inline-block";
    document.getElementById('reanalyse-btn').setAttribute('href',regenerateURL);
    document.getElementById('reanalyse-btn').style.display = "inline-block";
    var unfinished =document.getElementsByClassName('transparency');
    for (var i=0;i<unfinished.length;i+=1){
        unfinished[i].style.display = 'none';
    }
}

function downloadReport() {
    printDiv('report-pdf');

}

function showList(listName) {
    var elems = document.getElementsByClassName(listName);
    for (var i=0;i<elems.length;i+=1){
        elems[i].style.display = 'list-item';
    }
}

function hideButtons() {
    var elems = document.getElementsByClassName('show-hide-btn');
    for (var i=0;i<elems.length;i+=1){
        elems[i].style.display = 'none';
    }
}

function preparePDF() {
    document.getElementById('download-btn').style.display = "none";
    document.getElementById('reanalyse-btn').style.display = "none";
    showList('emptyAlt');
    showList('altImg');
    showList('list6');
    showList('list5');
    showList('list4');
    showList('list3');
    showList('list2');
    showList('list1');
    hideButtons();
}



function printDiv(divID) {
    //Get the HTML of div
    var divElements = document.getElementById(divID).innerHTML;
    //Get the HTML of whole page
    var oldPage = document.body.innerHTML;

    //Reset the page's HTML with div's HTML only
    document.body.innerHTML =
        "<html><head><title></title></head><body>" +
        divElements + "</body>";
    preparePDF();
    //Print Page
    window.print();

    //Restore orignal HTML
    document.body.innerHTML = oldPage;
}

window.onload = function pageLoaded() {
    loadData();
    refreshIntervalId = setInterval(loadData, 3000);
}