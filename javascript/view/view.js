$(document).ready(function () {
    $("input").focus(function () {
        $("myresult").css("border", "#FFFFFF 2px dashed;");
    });
});


/* 查詢員工代號得獎資訊 */
function sn_view() {

    //alert("sn_view");

    $(function () {
        $("#dialog").remove();
        $("body").append(
            "<div id='dialog' title='得獎人員 快速查詢' style='font-size:20px;letter-spacing:2px;' style='line-height:24px'>" +
            "查詢帳號：<input  id='mysn'     type='text' value='' maxlength='12'  style='width:200px;'   placeholder=' 請輸入查詢員工帳號' >&nbsp;大小寫需完全符合！<br />" + 
            "查詢類型：<select id='mycode'  ><option value='1'>一般員工</option><option value='2'>庇護員工</option><option value='3'>憨兒工讀</option></select><br /><br />" +
            "查詢結果：<input  id='myresult' type='text' value='' maxlength='12'  style='width:200px;border: #FFFFFF 2px dashed;font-size: 24px;' readonly ><br />" + 
            "</div >");


        $("#dialog").dialog({
            modal: true,
            width: 600,
            height: 350,
            buttons: {

                "查詢": function () {
                    $.blockUI({
                        message: '資料查詢中！',
                        css: {
                            border: 'none',
                            padding: '15px',
                            'text-align': 'center',
                            'font-size': '25px',
                            'font-family': 'Microsoft JhengHei',

                            backgroundColor: '#000',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            opacity: .5,
                            color: '#fff'
                        },
                    });

                    $.ajax({
                        type: "POST",
                        url: "sn_view_service.php",
                        dataType: "json",
                        //async: false,
                        data: {
                            myckeck_sn   : $("#mysn").val(),
                            myckeck_code : $("#mycode").val(),
                        },
                        success: function (data) {
                            $.unblockUI(); //解除前台搜尋狀態 
                            var bingo_result = data.bingo_result;

                            //console.log("mytest=" + bingo_result);
                            $("#myresult").val(bingo_result);

                        },
                        error: function (jqxhr) {
                            alert("錯誤！請洽設計開發人員！");
                            $.unblockUI(); //解除前台搜尋狀態
                            console.log(jqxhr.readystate);
                            console.log(jqxhr.status);
                            console.log(jqxhr.statustext);
                            console.log(jqxhr.responsetext);
                        }
                    })


                },

                "關閉": function () {
                    $(this).dialog("close");
                    //window.location.href = '';
                }
            }
        });

    })




}

