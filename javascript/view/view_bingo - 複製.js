function view_exchange(table, no) {

    //alert("table =" + table);
    //alert("no =" + no);


    $.blockUI({
        message: '設定中，請勿關閉視窗！',
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
        url: "view_exchange_service.php",
        dataType: "json",
        data: {
            myckeck_table_val: table,
            myckeck_no_val: no,
        },

        success: function (data) {
            $.unblockUI(); //解除前台搜尋狀態

            console.log("no = " + data.myno);
            console.log("ordering = " + data.myordering_state);

            set_ordering(data.myno, data.myordering_state); 

            //window.location.assign("view_bingo_display.php?table=" + table);        
        },

        error: function (jqXHR, textStatus, errorThrown) {

            $.unblockUI(); //解除前台搜尋狀態

            alert("錯誤！請洽設計開發人員！");
            //console.log(jqXHR.readyState);
            //console.log(jqXHR.status);
            //console.log(jqXHR.statusText);
            //console.log(jqXHR.responseText);
            //console.log(textStatus);
            //console.log(errorThrown);

        }
    })

}

/* 設定領獎人狀態資訊 */
function set_ordering(no, ordering) {

    //alert("no =" + no);
    //alert("ordering =" + ordering);

    object_no_id       = "#no_"       + no;
    object_name_id     = "#name_"     + no;
    object_ordering_id = "#ordering_" + no;
    object_exchange_id = "#exchange_" + no;

    object_goods_id    = "#goods_" + no;

    //尚未領取 ==> 已領取
    if (ordering == 'OK') {

        $(object_no_id).removeClass("bingo_no");
        $(object_no_id).addClass("bingo2_no");

        $(object_goods_id).removeClass("bingo_name");
        $(object_goods_id).addClass("bingo2_name");

        $(object_name_id).removeClass("bingo_name");
        $(object_name_id).addClass("bingo2_name");

        $(object_ordering_id).removeClass("bingo_ordering");
        $(object_ordering_id).addClass("bingo2_ordering");

        $(object_ordering_id).removeClass("bingo_ordering");
        $(object_ordering_id).addClass("bingo2_ordering");

        $(object_exchange_id).removeClass("exchange_online");
        $(object_exchange_id).addClass("exchange_offline");
        $(object_exchange_id).text("已領取");
    }
    //已領取 ==>  尚未領取
    else if (ordering == 'nodata') {

        $(object_no_id).removeClass("bingo2_no");
        $(object_no_id).addClass("bingo_no");

        $(object_goods_id).removeClass("bingo2_name");
        $(object_goods_id).addClass("bingo_name");

        $(object_name_id).removeClass("bingo2_name");
        $(object_name_id).addClass("bingo_name");

        $(object_ordering_id).removeClass("bingo2_ordering");
        $(object_ordering_id).addClass("bingo_ordering");

        $(object_exchange_id).removeClass("exchange_offline");
        $(object_exchange_id).addClass("exchange_online");
        $(object_exchange_id).text("尚未領取");
    }

}

/* 查詢員工代號得獎資訊 */
function sn_view() {

    $("#dialog").remove();
    $("body").append(
        "<div id='dialog' title='喜歡你購物網x遠雄人壽 VIP保戶專屬優惠活動' style='font-size:16px;letter-spacing:2px;'>" +
        "序號號碼　<input id='myckeck_keynum' type='text' value='" + sn + "'style='width:350px;font-weight:bold;border:#fff 1px solid;' readonly><br /><br />" +
        "收件姓名：<input id='myname' type='text' value='' maxlength='8'  style='width:350px;' ><br />" +
        "收件地址：<input id='myaddr' type='text' value='' maxlength='30' style='width:350px;'><br />" +
        "郵遞區號：<input id='myaddrnum' type='text' value=''  maxlength='5' style='width:350px;'><br />" +
        "連絡電話：<input id='mytel'   type='text' value=''  maxlength='18' style='width:350px;'><br />" +
        "聯絡信箱：<input id='mymail'  type='text' value=''  maxlength='40' style='width:350px;'><br />" +
        "序號狀態：<select id='mygoods' style='width:auto;'><option value='A'>尚未登錄</option><option value='B'>已經登錄</option><option value='C'>備貨中</option><option value='D'>已出貨</option></select>&nbsp;&nbsp;&nbsp;&nbsp;" +
        "<input id='myCB' type='checkbox' value='off'> <tt_mail>發送郵件通知</tt_mail> <br />" +
        "送達日期：<input id='mygoods_date'  type='text' value=''  maxlength='40' style='width:350px;'><br />" +
        "序號使用期限：<input id='myexpiry_date' type='text' value='' style='width:350px;font-weight:bold;border:#fff 1px solid;' readonly><br />" +
        "上次寄信時間：<input id='mymail_date' type='text' value='' style='width:350px;font-weight:bold;border:#fff 1px solid;' readonly><br />" +
        "</div >");    

}





///* 設定返回捲軸高度 */
//function set_scrollTop() {
//    console.log( "@@@" ) ;
//    window.scroll(1000, 500);

//}












/*序號搜尋器*/
function filter_ready() {
    //alert("序號資料查詢中！");

    $.blockUI({
        message: '序號資料查詢中，請勿關閉視窗！',
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
        url: "view02_filter_service.php",
        //dataType: "json",
        data: {
            myckeck_num_val: $("#filter-num").val(),
            myckeck_state_val: $("#filter-state").val(),
            myckeck_time_val: $("#filter-time").val(),
        },

        success: function () {

            //$.unblockUI(); //解除前台搜尋狀態

            window.location.assign("view02.html?page=1");
        },

        error: function (jqXHR, textStatus, errorThrown) {

            $.unblockUI(); //解除前台搜尋狀態

            alert("錯誤！請洽設計開發人員！");
            //console.log(jqXHR.readyState);
            //console.log(jqXHR.status);
            //console.log(jqXHR.statusText);
            //console.log(jqXHR.responseText);
            //console.log(textStatus);
            //console.log(errorThrown);

        }
    })
}


/*檢視處理單一序號*/
function sn_view(sn) {
    //alert(sn);

    $(function () {

        $("#dialog").remove();
        $("body").append(
            "<div id='dialog' title='喜歡你購物網x遠雄人壽 VIP保戶專屬優惠活動' style='font-size:16px;letter-spacing:2px;'>" +
            "序號號碼　<input id='myckeck_keynum' type='text' value='" + sn +"'style='width:350px;font-weight:bold;border:#fff 1px solid;' readonly><br /><br />" +
            "收件姓名：<input id='myname' type='text' value='' maxlength='8'  style='width:350px;' ><br />" + 
            "收件地址：<input id='myaddr' type='text' value='' maxlength='30' style='width:350px;'><br />" + 
            "郵遞區號：<input id='myaddrnum' type='text' value=''  maxlength='5' style='width:350px;'><br />" +
            "連絡電話：<input id='mytel'   type='text' value=''  maxlength='18' style='width:350px;'><br />" +
            "聯絡信箱：<input id='mymail'  type='text' value=''  maxlength='40' style='width:350px;'><br />" + 
            "序號狀態：<select id='mygoods' style='width:auto;'><option value='A'>尚未登錄</option><option value='B'>已經登錄</option><option value='C'>備貨中</option><option value='D'>已出貨</option></select>&nbsp;&nbsp;&nbsp;&nbsp;" + 
            "<input id='myCB' type='checkbox' value='off'> <tt_mail>發送郵件通知</tt_mail> <br />" + 
            "送達日期：<input id='mygoods_date'  type='text' value=''  maxlength='40' style='width:350px;'><br />" +
            "序號使用期限：<input id='myexpiry_date' type='text' value='' style='width:350px;font-weight:bold;border:#fff 1px solid;' readonly><br />" +
            "上次寄信時間：<input id='mymail_date' type='text' value='' style='width:350px;font-weight:bold;border:#fff 1px solid;' readonly><br />" +
            "</div >");

        $.ajax({
            type: "POST", 
            url: "view02_sn_view_read_service.php",
            dataType: "json", 
            data: { 
                myckeck_keynum: $("#myckeck_keynum").val(), 
            },

            success: function (data) {
                $("#myname").val(data.myname);
                $("#myaddr").val(data.myaddr);
                $("#myaddrnum").val(data.myaddrnum);
                $("#mytel").val(data.mytel);
                $("#mymail").val(data.mymail);
                $("#mygoods").val(data.mygoods);
                $("#mygoods_date").val(data.mygoods_date);
                $("#myexpiry_date").val(data.myexpiry_date);
                $("#mymail_date").val(data.mymail_date);
            },

            error: function (jqXHR) {
                alert("錯誤！請洽設計開發人員！");
                //console.log(jqxhr.readystate);
                //console.log(jqxhr.status);
                //console.log(jqxhr.statustext);
                //console.log(jqxhr.responsetext);
            }
        })


        $("#dialog").dialog({
            modal: true,
            width: 550,
            height: 580,
            buttons: {
                "修改儲存": function () {

                    $.blockUI({
                        message: '序號資料變更中，請勿關閉視窗！',
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
                        type: "post",
                        url: "view02_sn_view_write_service.php",
                        datatype: "json",
                        data: {
                            myckeck_keynum:$("#myckeck_keynum").val(),
                            myname   :$("#myname").val(),                         
                            myaddr   :$("#myaddr").val(),
                            myaddrnum:$("#myaddrnum").val(), 
                            mytel    :$("#mytel").val(),
                            mymail   :$("#mymail").val(),
                            mygoods  :$("#mygoods").val(),
                            myCB     :$("#myCB").is(":checked"),
                            mygoods_date: $("#mygoods_date").val(),
                            mymail_date: $("#mymail_date").val(),
                        },
                        success: function () {     
                            //console.log(data.CB);

                            alert("修改完成！");
                            $.unblockUI(); //解除前台搜尋狀態                            
                            $("#dialog").dialog("close");
                            window.location.reload();
                        },
                        error: function (jqxhr) {
                            alert("錯誤！請洽設計開發人員！");
                            $.unblockUI(); //解除前台搜尋狀態
                            //console.log(jqxhr.readystate);
                            //console.log(jqxhr.status);
                            //console.log(jqxhr.statustext);
                            //console.log(jqxhr.responsetext);
                        }
                    })
                },
                "關閉": function () {
                    $(this).dialog("close");
                }
            }
        });
    });

}


/*處理全部序號*/
function sn_allrun(data_nums) {
    //alert(data_nums);

    $(function() {

        $("#dialog").remove();
        $("body").append(
            "<div id='dialog' title='喜歡你購物網x遠雄人壽 VIP保戶專屬優惠活動' style='font-size:16px;letter-spacing:2px;'>" +
            "預計執行筆數：<input id='all_num' type='text' value='" + data_nums + "' style='width:100px;font-weight:bold;border:#fff 1px solid;' readonly><br /><br />" +
            "<b>確認執行動作（一次最多處理 25 筆資料，此動作無法復原，請注意！）</b><br />" + 
            "變更序號狀態：<select id='mygoods' style='width:auto;'><option value='A'>尚未登錄</option><option value='B'>已經登錄</option><option value='C'>備貨中</option><option value='D'>已出貨</option></select>&nbsp;&nbsp;&nbsp;&nbsp;" +
            "<input id='myCB' type='checkbox' value='off'> <tt_mail>發送郵件通知</tt_mail> <br />" + 
            "送達日期：<input id='mygoods_date'  type='text' value=''  maxlength='40' style='width:300px;'><br />" +
            "</div>");

        $("#dialog").dialog({
            modal: true,
            width: 650,
            height: 360,
            buttons: {
             
                "執行": function () {

                    $.blockUI({
                        message: '序號資料變更中，請勿關閉視窗！',
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
                        url: "view02_sn_allrun_write_service.php",
                        dataType: "json",
                        data: {
                            all_num: $("#all_num").val(),
                            mygoods: $("#mygoods").val(), 
                            myCB: $("#myCB").is(":checked"),
                            mygoods_date: $("#mygoods_date").val(),
                        },
                        success: function (data) {
                            //console.log(data.CB);
                            //console.log(data.mytest);

                            alert(data.msg);
                            $.unblockUI(); //解除前台搜尋狀態
                            $("#dialog").dialog("close");
                            window.location.reload();
                        },
                        error: function (jqXHR) {
                            alert("錯誤！請洽管理員！");
                            $.unblockUI(); //解除前台搜尋狀態
                            //console.log(jqXHR.readyState);
                            //console.log(jqXHR.status);
                            //console.log(jqXHR.statusText);
                            //console.log(jqXHR.responseText);
                        }
                    })
                },
                "關閉": function() {
                    $(this).dialog("close");               
                }
            }
        });
    });
        
}

