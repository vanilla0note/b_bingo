function login_run() {

    $.blockUI({
        message: '系統登入中，請稍候！',
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


        }
        //onOverlayClick: $.unblockUI
    });

    myForm1.action = "myhavenwife.php";
    myForm1.submit();

}