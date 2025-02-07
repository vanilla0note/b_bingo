
/* 網頁載入後 設定捲軸高度 */
window.onload = function () {

    var variables = window.location.search; //獲取url中攜帶的參數 Ex： ?table=b09
    var variableArray = variables.substr(1).split("="); //依照 = 分割並儲存在陣列 Ex：[0] = table [1] = b09

    //console.log("variables = " + variables);
    //console.log("variableArray = " + variableArray);
    //console.log("variableArray[1] = " + variableArray[1]);

    moveScol(variableArray[1]);

}


/* 進行抽獎 */
function form_run(x) {

    var str = x ;

    document.getElementById("myBtn").disabled = "true";
    document.getElementById("myBtn").style.backgroundColor = "#ffc90f";
    document.getElementById("myBtn").style.color = "#c30707";
    document.getElementById("myBtn").style.border = "2px solid #eae5b9";
    document.getElementById("msg").style.display = "block";

    myForm1.action = "mylottc_execution.php?table=" + str;
    myForm1.submit();

}
function form_run_raise(x) {
    var str = x ;

    document.getElementById("myBtn_raise").disabled = "true";
    document.getElementById("myBtn_raise").style.backgroundColor = "#ffc90f";
    document.getElementById("myBtn_raise").style.color = "#c30707";
    document.getElementById("myBtn_raise").style.border = "2px solid #eae5b9";

    myForm1.action = "mylottc_execution.php?table=" + str;
    myForm1.submit();

}


/* 紀錄捲軸高度 */
function getScrollPosition(x) {
    var bodyTop = 0;
    if (typeof window.pageYOffset != "undefined")
        bodyTop = window.pageYOffset;
    else if (typeof document.compatMode != "undefined" && document.compatMode != "BackCompat")
        bodyTop = document.documentElement.scrollTop;
    else if (typeof document.body != "undefined")
        bodyTop = document.body.scrollTop;


    // 顯示出捲動後的高度值
    //alert( "x = " + x );
    //alert( "bodyTop = " + bodyTop);

    document.cookie = x + "=" + bodyTop;;
    //console.log("document.cookie = " + document.cookie);

    //document.cookie = bodyTop; //將Y座標位置紀錄在cookie上
    //var x = document.cookie;
    //alert(x.split(";")[0]);
}


/* 取得這個網頁的捲軸高度 */
function moveScol(name) {

    var scrollo_y = getCookie(name); // 取出記在 cookie 的數值
    window.scrollTo(0, scrollo_y); //設定捲軸 Y 的高度

    //var scrollo_y = document.cookie.split(";")[0];

    //if (scrollo_y != null) {
    //    window.scrollTo(0, scrollo_y);
    //}

    ////window.scrollTo(0, 200);

}


/* 取出指定的cookie */
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
