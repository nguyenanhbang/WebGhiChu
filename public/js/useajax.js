function load_ajax_listghichu(dstheastring) {
    var dsghichu = document.getElementById("dsghichudiv");
    dsghichu.innerHTML = dstheastring;
}

function load_ajax_tieude() {
    // Tạo một biến lưu trữ đối tượng XML HTTP. Đối tượng này
    // tùy thuộc vào trình duyệt browser ta sử dụng nên phải kiểm
    // tra như bước bên dưới
    var xmlhttp;
    var title = document.getElementById("txt_tktieude");
    // Nếu trình duyệt là  IE7+, Firefox, Chrome, Opera, Safari
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    // Nếu trình duyệt là IE6, IE5
    else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    // Khởi tạo một hàm gửi ajax
    xmlhttp.onreadystatechange = function () {
        // Nếu đối tượng XML HTTP trả về với hai thông số bên dưới thì mọi chuyện 
        // coi như thành công
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            load_ajax_listghichu(xmlhttp.responseText);
        }
    };

    // Khai báo với phương thức GET, và url
    xmlhttp.open("GET", "/home/searchtitle?name=" + title.value + "&currentmaghichu=" + document.getElementById("myGCid").value, true);

    // Cuối cùng là Gửi ajax, sau khi gọi hàm send thì function vừa tạo ở
    // trên (onreadystatechange) sẽ được chạy
    xmlhttp.send();
}

function load_ajax_ghichu(maghichu) {

    $.get("/home/ghichu?maghichu=" + maghichu, function (data, status) {

        var ghichu = JSON.parse(data);
        //alert(data);
        $('#icon_gc').html(ghichu.iconghichu);
        $('#txt_title').html(ghichu.tieudeghichu);
        $('#textBox').html(ghichu.ndghichu+" ");

        $('#textBox').attr('contenteditable','true');
        var maghichutrc = $('#myGCid').val();
        $("#ghichu" + maghichu).addClass("active");
        $("#ghichu" + maghichutrc).removeClass("active");
        $('#myGCid').val(maghichu);

        reloaddsthecuaghichu(maghichu);
    });
}

function reloaddsthecuaghichu(maghichu) {
    $.get("/home/theghichu?maghichu=" + maghichu, function (data, status) {
        //alert(data);
        $("#dscuathe").selectpicker("destroy");
        $("#dscuathe").remove();

        $('#divdscuathe').html(data);
        $('#dscuathe').selectpicker();

    });
}

function reloaddsthetk(){
    $.get("/home/theghichutk", function (data, status) {
        //alert(data);
        $("#dscuathetk").selectpicker("destroy");
        $("#dscuathetk").remove();

        $('#divdscuathetk').html(data);
        $('#dscuathetk').selectpicker();

    });
}
function qlthe_onclick(mathe, tenthe) {
    var etenthe = document.getElementById("txt_tenthe");
    var emathe = document.getElementById("ql_mathe");
    etenthe.value = tenthe;
    emathe.value = mathe;
    //alert(emathe.value);
}

$(document).on('click', '#btntkthe', function () {
    var dsthetk = $('#dscuathetk').val();
    var cmaghichu = $('#myGCid').val();
    //alert(dsthetk);
    $.post('/home/searchthe', {
        tkdsthe: dsthetk,
        currentmaghichu: cmaghichu
    }, function (ketqua) {
        load_ajax_listghichu(ketqua);
    });
});

$(document).on('click', '#btn_xoaghichu', function () {
    var maghichu = $('#myGCid').val();
    $.get("/home/deletenote?currentmaghichu=" + maghichu, function (data, status) {

        $('#icon_gc').html("🗒️");
        $('#txt_title').empty();

        $('#textBox').html("1234");
        $('#textBox').attr("contenteditable", "true");

        var maghichutrc = $('#myGCid').val();
        $("#ghichu" + maghichutrc).remove();
        $('#myGCid').val(0);
        reloaddsthecuaghichu(0);
        alert("xoa thanh cong");
    });
});

$(document).on('click', '#btn_suaghichu', function () {

    var maghichu = $('#myGCid').val();
    var iconghichu = $('#icon_gc').html();
    var tieudeghichu = $('#txt_title').html();
    var ndghichu = $('#textBox').html();

    var theghichu = $('#dscuathe').val();
    //alert(maghichu)
    //alert(theghichu);
    $.post('/home/updatenote', {
        myGCid: maghichu,
        myGCicon: iconghichu,
        myTitle: tieudeghichu,
        myDoc: ndghichu,
        dsthe: theghichu

    }, function (ketqua) {
        //alert("ma ghi chu la "+ketqua);

        if (ketqua != 0) {
            $('#myGCid').val(ketqua);
            var listtrc = $('#dsghichudiv').html();
            $('#dsghichudiv').html(" <div id='ghichu" + ketqua + "' class='active' onclick= 'load_ajax_ghichu(" + ketqua + ");'>" + iconghichu + " " + tieudeghichu + "</div>" + listtrc);
        } else {
            $('#ghichu' + maghichu).html(iconghichu + " " + tieudeghichu);
        }
        reloaddsthecuaghichu(maghichu);
        alert("cap nhat thanh cong");
    });
});

$(document).on('click', '#btn_newnote', function () {
    var maghichutrc = $('#myGCid').val();
    $.get("/home/newnote", function (data, status) {
        //alert(data);
        var ghichunew = JSON.parse(data);
        //alert(ghichunew);
        $('#icon_gc').html(ghichunew.iconghichu);
        $('#txt_title').html(ghichunew.tieudeghichu);

        $('#textBox').html(ghichunew.ndghichu);
        $('#textBox').attr("contenteditable", "true");

        $('#myGCid').val(ghichunew.maghichu);
        var listtrc = $('#dsghichudiv').html();
        $('#dsghichudiv').html(" <div id='ghichu" + ghichunew.maghichu + "' onclick= 'load_ajax_ghichu(" + ghichunew.maghichu + ")'>" + ghichunew.iconghichu + " " + ghichunew.tieudeghichu + "</div>" + listtrc);

        $("#ghichu" + ghichunew.maghichu).addClass("active");
        $("#ghichu" + maghichutrc).removeClass("active");

        $('#myGCid').val(ghichunew.maghichu);
        reloaddsthecuaghichu(0);
    });
});

$(document).on('click', '#btn_themthe', function () {
    var bla = $('#txt_tenthe').val();
    if (bla == "" || bla == null) {
        alert("Bạn chưa nhập tên thẻ")
    } else {
        $.get("/home/themthe?name=" + bla, function (data, status) {

            if (data == "1") {
                alert("Trùng tên thẻ");
            } else {

                alert("Thêm thành công");
                var obj = JSON.parse(data);
                var mathe = obj.mathe;
                var tenthe = obj.tenthe;

                // Append the option to select
                $('#dscuathe').append('<option value="' + mathe + '">' + tenthe + '</option>');
                // Refresh the selectpicker
                $("#dscuathe").selectpicker("refresh");
                // Append the option to select
                $('#dscuathetk').append('<option value="' + mathe + '">' + tenthe + '</option>');
                // Refresh the selectpicker
                $("#dscuathetk").selectpicker("refresh");
                
                $('#ql_dsthe').append("<option onclick ='qlthe_onclick("+mathe+",'"+tenthe+"')' value= "+mathe+" id = 'qlthe"+mathe+"' >"+tenthe+"</option>");
            }
        });
    }

});

$(document).on('click', '#btn_suathe', function () {
    var bla = $('#txt_tenthe').val();
    var mathe = $("#ql_mathe").val();
    if (bla == "" || bla == null) {
        alert("Bạn chưa nhập tên thẻ");
    } else {
        $.get("/home/suathe?name=" + bla+"&mathe="+mathe, function (data, status) {

            if (data == "1") {
                alert("Trùng tên thẻ");
            } else {

                alert("sua thành công");
                var currentghichu = $("#myGCid").val();

                reloaddsthecuaghichu(currentghichu);
                reloaddsthetk();
                //thay doi the select
                $("#qlthe"+mathe).html(bla);
            }
        });
    }

});

$(document).on('click', '#btn_xoathe', function () {
    var bla = $('#ql_mathe').val();
    if (bla == "" || bla == null) {
        alert("Bạn chưa chon thẻ can xoa")
    } else {
        $.get("/home/xoathe?mathe=" + bla, function (data, status) {
            if(data =1){
                alert("xoa thanh cong")
                var currentghichu = $("#myGCid").val();
                $("#qlthe"+bla).remove();
                reloaddsthecuaghichu(currentghichu);
                reloaddsthetk();

            }else{
                alert("xoa khong thanh cong")
            }
            

        });
    }
});