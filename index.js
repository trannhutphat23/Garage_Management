var previousPage = document.querySelector('.page-1');
var previousButton = document.querySelector('.selector-1');

var Page1 = document.querySelector('.page-1');
var Page2 = document.querySelector('.page-2');
var Page3 = document.querySelector('.page-3');
var Page4 = document.querySelector('.page-4');
var Page5 = document.querySelector('.page-5');
var Page6 = document.querySelector('.page-6');

var Button1 = document.querySelector('.selector-1');
var Button2 = document.querySelector('.selector-2');
var Button3 = document.querySelector('.selector-3');
var Button4 = document.querySelector('.selector-4');
var Button5 = document.querySelector('.selector-5');
var Button6 = document.querySelector('.selector-6');

// ------------------------------------------------

function viewPage1() {
    set3();
    set5();
    set2();
    previousPage.classList.add("hidden");
    Page1.classList.remove("hidden");
    previousPage = Page1;

    previousButton.classList.remove("onChose");
    Button1.classList.add("onChose");
    previousButton = Button1;

}

// -------------------------------------------------------
var dropdown2 = document.querySelector('.dropdown2');
var ok2 = document.querySelector('.ok2');

function Rotate2() {
    ok2.classList.toggle("fa-caret-down");
    ok2.classList.toggle("fa-caret-left");
}

function viewPage2() {
    set3();
    set5();
    Rotate2();
    previousPage.classList.add("hidden");
    Page2.classList.remove("hidden");
    previousPage = Page2;

    previousButton.classList.remove("onChose");
    Button2.classList.add("onChose");
    previousButton = Button2;
    dropdown2.classList.toggle("hidden");
}

function Chose2(e) {
    // Xóa class `fa-circle-dot` từ tất cả các div
    var allDivs = document.querySelectorAll(".more2 div");
    allDivs.forEach((div) => {
        div.classList.remove("Chose");
        const icon = div.querySelector("i");
        icon.classList.remove("fa-circle-dot");
        icon.classList.add("fa-circle");
    });
    e.classList.add("Chose");
    // Thêm class `fa-circle-dot` cho div hiện tại
    var icon = e.querySelector("i");
    icon.classList.remove("fa-circle");
    icon.classList.add("fa-circle-dot");
}

var previousIs = document.querySelector(".is1");

function viewPage21() {
    previousIs.classList.toggle("hidden");
    var is1 = document.querySelector(".is1");
    is1.classList.toggle("hidden");
    previousIs = is1;
}

function viewPage22() {
    previousIs.classList.toggle("hidden");
    var is2 = document.querySelector(".is2");
    is2.classList.toggle("hidden");
    previousIs = is2;
}

function viewPage23() {
    previousIs.classList.toggle("hidden");
    var is3 = document.querySelector(".is3");
    is3.classList.toggle("hidden");
    previousIs = is3;
}

//------------------------------------------------------------------

var dropdown3 = document.querySelector('.dropdown3');

var ok3 = document.querySelector('.ok3');
function Rotate3() {
    ok3.classList.toggle("fa-caret-down");
    ok3.classList.toggle("fa-caret-left");
}

function viewPage3() {
    Rotate3();
    set5();
    set2();
    previousPage.classList.add("hidden");
    Page3.classList.remove("hidden");
    previousPage = Page3;

    previousButton.classList.remove("onChose");
    Button3.classList.add("onChose");
    previousButton = Button3;
    dropdown3.classList.toggle("hidden");
}

function Chose3(e) {
    // Xóa class `fa-circle-dot` từ tất cả các div
    var allDivs = document.querySelectorAll(".more3 div");
    allDivs.forEach((div) => {
        div.classList.remove("Chose");
        const icon = div.querySelector("i");
        icon.classList.remove("fa-circle-dot");
        icon.classList.add("fa-circle");
    });
    e.classList.add("Chose");
    // Thêm class `fa-circle-dot` cho div hiện tại
    var icon = e.querySelector("i");
    icon.classList.remove("fa-circle");
    icon.classList.add("fa-circle-dot");
}

var previousIt = document.querySelector(".it1");

function viewPage31() {
    previousIt.classList.toggle("hidden");
    var it1 = document.querySelector(".it1");
    it1.classList.toggle("hidden");
    previousIt = it1;
}

function viewPage32() {
    previousIt.classList.toggle("hidden");
    var it2 = document.querySelector(".it2");
    it2.classList.toggle("hidden");
    previousIt = it2;
}

// ----------------------------------

function viewPage4() {
    set3();
    set5();
    set2();
    previousPage.classList.add("hidden");
    Page4.classList.remove("hidden");
    previousPage = Page4;

    previousButton.classList.remove("onChose");
    Button4.classList.add("onChose");
    previousButton = Button4;
}

// -------------------------------------------

var dropdown5 = document.querySelector('.dropdown5');

function viewPage5() {
    Rotate5();
    set3();
    set2();
    previousPage.classList.add("hidden");
    Page5.classList.remove("hidden");
    previousPage = Page5;

    previousButton.classList.remove("onChose");
    Button5.classList.add("onChose");
    previousButton = Button5;
    dropdown5.classList.toggle("hidden");
}

var ok5 = document.querySelector('.ok5');
function Rotate5() {
    ok5.classList.toggle("fa-caret-down");
    ok5.classList.toggle("fa-caret-left");
}

function Chose5(e) {
    // Xóa class `fa-circle-dot` từ tất cả các div
    const allDivs = document.querySelectorAll(".more5 div");
    allDivs.forEach((div) => {
        div.classList.remove("Chose");
        const icon = div.querySelector("i");
        icon.classList.remove("fa-circle-dot");
        icon.classList.add("fa-circle");
    });
    e.classList.add("Chose");
    // Thêm class `fa-circle-dot` cho div hiện tại
    const icon = e.querySelector("i");
    icon.classList.remove("fa-circle");
    icon.classList.add("fa-circle-dot");
}

var previousIf = document.querySelector(".if1");

function viewPage51() {
    previousIf.classList.toggle("hidden");
    var if1 = document.querySelector(".if1");
    if1.classList.toggle("hidden");
    previousIf = if1;
}

function viewPage52() {
    previousIf.classList.toggle("hidden");
    var if2 = document.querySelector(".if2");
    if2.classList.toggle("hidden");
    previousIf = if2;
}

function viewPage53() {
    previousIf.classList.toggle("hidden");
    var if3 = document.querySelector(".if3");
    if3.classList.toggle("hidden");
    previousIf = if3;
}

function viewPage54() {
    previousIf.classList.toggle("hidden");
    var if4 = document.querySelector(".if4");
    if4.classList.toggle("hidden");
    previousIf = if4;
}

function set5() {
    ok5.classList.remove("fa-caret-down");
    ok5.classList.add("fa-caret-left");

    Button5.classList.remove("onChose");
    dropdown5.classList.add("hidden");
}

function set3() {
    ok3.classList.remove("fa-caret-down");
    ok3.classList.add("fa-caret-left");

    Button3.classList.remove("onChose");
    dropdown3.classList.add("hidden");
}

function set2() {
    ok2.classList.remove("fa-caret-down");
    ok2.classList.add("fa-caret-left");

    Button2.classList.remove("onChose");
    dropdown2.classList.add("hidden");
}

var settingSCR = document.querySelector('.settingSCR');
var settingBTN = document.querySelector('.setting');

function Setting() {
    settingSCR.classList.toggle('hidden');
}
var load1 = document.getElementById('loadFrame1');
load1.addEventListener('click',function(e){
    document.getElementById("loadIframe1").src += '';
});

var load2 = document.getElementById('loadFrame2');
load2.addEventListener('click',function(e){
    document.getElementById("loadIframe2").src += '';
});

var load3 = document.getElementById('loadWarehouse');
load3.addEventListener('click',function(e){
    document.getElementById("loadIframe3").src += '';
});

var load4 = document.getElementById('loadRepair');
load4.addEventListener('click',function(e){
    document.getElementById("loadIRepair").src += '';
});

var load5 = document.getElementById('loadSearch');
load5.addEventListener('click',function(e){
    document.getElementById("loadISearch").src += '';
});