/**import maskMoney dari extensions/moneymask*/
//document.writeln("<script type='text/javascript' src='js/jquery.maskMoney.js'></script>");
//document.writeln("<script type='text/javascript' src='js/jquery.maskedinput.js'></script>");
//document.writeln("<script type='text/javascript' src='js/realtimeClock.js'></script>");
//document.writeln("<script type='text/javascript' src='js/accounting.js'></script>");
/**
 * Dihapus / sudah tidak digunakan
 * digantikan : focusNextInputField
 */
function nextFocus(obj, evt, next_id, before_id)
{
    console.log("Function nextFocus() sudah tidak digunakan lagi. Gunakan focusNextInputField !");
}
/**
 * Dihapus / sudah tidak digunakan
 * digantikan : focusNextInputField
 */
$.fn.nextFocus = function () {
    console.log("Function nextFocus() sudah tidak digunakan lagi. Gunakan focusNextInputField !");
};

/**
 * untuk next focus jika ditekan enter
 * @param {type} evt
 * @returns {Boolean|$.fn@call;each}
 */
$.fn.focusNextInputField = function (evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13) {
        return this.each(function () {
            var fields = $(this).parents('form:eq(0),body').find('button,input,textarea,select,link,checkbox').not('[type=hidden],[readonly]').not(':hidden').not(':disabled');
            var index = fields.index(this);
            if (index > -1 && (index + 1) < fields.length) {
                fields.eq(index + 1).focus();
                fields.eq(index + 1).select();
            }
            return false;
        });
        return false;
    }
//        charCode == 40 ||
    else if (charCode == 34) { //arrow down || pg down
        return this.each(function () {
            var fields = $(this).parents('form:eq(0),body').find('button,input,textarea,link,checkbox').not('[type=hidden]');
            var index = fields.index(this);
            if (index > -1 && (index + 1) < fields.length) {
                fields.eq(index + 1).focus();
                fields.eq(index + 1).select();
            }
            return false;
        });
        return false;
    }
//        charCode == 38 ||
    else if (charCode == 33) { //arrow down || pg down
        return this.each(function () {
            var fields = $(this).parents('form:eq(0),body').find('button,input,textarea,link,checkbox').not('[type=hidden]');
            var index = fields.index(this);
            if (index > -1 && (index + 1) < fields.length) {
                fields.eq(index - 1).focus();
                fields.eq(index + 1).select();
            }
            return false;
        });
        return false;
    }
};
/**
 * untuk mencegah tombol enter ditekan (return false)
 * @param {type} e
 * @returns {Boolean}
 */
function disableKeyPress(e)
{
    var key;
    if (window.event)
    {
        key = window.event.keyCode; //IE
    } else {
        key = e.which; //firefox
    }

    if (key != 13)
    {
        return true;
    } else {
        if ((e.target.type == 'textarea'))
        {
            return (e.shiftKey);
        } else {
            return false;
        }
    }
}
/**
 * Submit form untuk tombol submit jika ditekan enter / klik
 * @param {type} obj <button>
 * @param {type} evt
 * @returns {undefined}
 */
function formSubmit(obj, evt)
{
    evt = (evt) ? evt : event;
    var form_id = $(obj).closest('form').attr('id');
    var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13) {
        if (requiredCheck($(obj).parents('form'))) {
            document.getElementById(form_id).submit();
            disableOnSubmit(obj);
        }
    }
    return false;
}

/**
 * Mengecek element bernilai kosong dengan label yg memiliki class "required"
 * @param {type} <form>
 * @returns {Boolean}
 */
function requiredCheck(obj) {
    var kosong = 0;
    var attr = '';
    var attr_id = '';
    $(obj).find('input,select,textarea').not('.multiselect-search, .multiselect-container input').each(function () {
        if ($(this).parents(".control-group").find("label").hasClass('required') === true) {
            $(this).parents(".control-group").removeClass("error").removeClass("success");
        }
    });
    $(obj).find('input,select,textarea').not('.multiselect-search, .multiselect-container input').each(function () {
        if ($(this).parents(".control-group").find("label").hasClass('required') === true || $(this).hasClass('required')) {
            if (($(this).val() === "") && !$(this).is(":disabled")) {
                if ($(this).is(":hidden")) { //untuk element type:hidden
                    var radio_checked = false;
                    $(this).parent().find(".radio").each(function () { //mengecek element radio button
                        if ($(this).find("input").is(":checked")) {
                            radio_checked = true;
                        }
                    });
                    if (radio_checked == false) {
                        if ($(this).parents(".multiselect-container").length == 0){
                            $(this).parents(".control-group").addClass("error");
                            $(this).addClass("error");                            
                            kosong++;
                        }
                    } else {
                        $(this).parents(".control-group").removeClass("error");
                        $(this).removeClass("error");
                    }
                } else {
                    if (attr == ''){
                        attr = $(this);
                    }
                    $(this).parents(".control-group").addClass("error");
                    $(this).addClass("error");
                    kosong++;
                }
            } else {
                $(this).parents(".control-group").removeClass("error");
                $(this).removeClass("error");
            }
        }
    });
    
    $(obj).find('select').each(function(){        
        attr_id = $(this).attr("id");        
        if ($(this).parents(".control-group").find("label").hasClass('required') === true || $(this).hasClass('required')) {            
            $(this).parents(".control-group").find("span.multiselect-native-select").each(function(){                        
                var pilih = $("#"+attr_id+" option:selected[value!='']").length;
                if (pilih == 0){
                    if (attr == ''){
                        attr = $(this).find("button.multiselect");
                    }
                    $(this).parents(".control-group").addClass("error");
                    $(this).addClass("error");
                    kosong++;
                }else{
                    $(this).parents(".control-group").removeClass("error");
                    $(this).removeClass("error");
                }
            });
        }        
    });
    
    if (kosong > 0) {
        if (attr != ''){
            attr.focus();
        }
        myAlert("Silakan isi yang bertanda bintang &lt;span class='required'&gt;*&lt;/span&gt; !");//("+kosong+" input)
        return false;
    } else {
        disableOnSubmit($(obj).find("button[type='submit']"));
        return true;
    }
}

/**
 * Mengecek element bernilai kosong dengan label yg memiliki class "required"
 * @param {type} <form>
 * @returns {Boolean}
 */
function cekDisabled(obj, validasiTambahan) {
    var kosong = 0;
    var is_form_valid = true;
    $(obj).find('input,select,textarea').each(function () {
        if ($(this).parents(".control-group").find("label").hasClass('required') === true) {
            $(this).parents(".control-group").removeClass("error").removeClass("success");
        }
    });
    $(obj).find('input,select,textarea').each(function () {
        if ($(this).is(":disabled")) {

        } else {
            if ($(this).parents(".control-group").find("label").hasClass('required') === true || $(this).hasClass('required')) {
                if (($(this).val() === "") && !$(this).is(":disabled")) {
                    if ($(this).is(":hidden")) { //untuk element type:hidden
                        var radio_checked = false;
                        $(this).parent().find(".radio").each(function () { //mengecek element radio button
                            if ($(this).find("input").is(":checked")) {
                                radio_checked = true;
                            }
                        });
                        if (radio_checked == false) {
                            kosong++;
                        } else {

                        }
                    } else {
                        kosong++;
                    }
                } else {
                    $(this).parents(".control-group").removeClass("error");
                    $(this).removeClass("error");
                }
            }
        }
    });

    if (validasiTambahan != null)
        is_form_valid = validasiTambahan();

    // console.log(kosong, is_form_valid);

    if (kosong > 0 || !is_form_valid) {
        $(obj).find(".submit").prop('disabled', true);
    } else {
        $(obj).find(".submit").prop('disabled', false);
    }
}


function setValidasiCekDisabled(obj, validasiTambahan) {
    $(obj).find('input[type=text], textarea').blur(function () {
        cekDisabled(obj, validasiTambahan);
    });
    $(obj).find("input[type=text], select").change(function () {
        cekDisabled(obj, validasiTambahan);
    });

    cekDisabled(obj, validasiTambahan);
}

function toggleAccordion(obj) {

}
/**
 * remove / replace button / link ketika submit
 * untuk menghindari multiple submit
 * @param {type} obj
 * @returns {undefined}
 */
function disableOnSubmit(obj) {
    $(obj).parent().html('<span class="animation-loading-1" style="display: block; height:32px; vertical-align:"></span>');
    $('.float').each(function () {
        $(this).val(unformatNumber($(this).val()));
    });
    $('.integer').each(function () {
        $(this).val(unformatNumber($(this).val()));
    });
    $('.angkacoma-only').each(function(){
        $(this).val(unformatNumber($(this).val()));
    });
    // $('.integer-decimal').each(function () {
    //     $(this).val(unformatNumber($(this).val()));
    // });
}

/**
 * untuk refresh halaman dari tombol (link) ulang
 * @param {type} obj
 * @returns {undefined}
 */
function refreshForm(obj) {
    myConfirm("Apakah Anda ingin mengulang ini?", "Perhatian!", function (r) {
        if (r)
            window.location = $(obj).attr("href");
    });
    return false;
}

/**
 * Refresh form element
 * RND-5940
 * @param {type} param
 */
function resetElement() {
    $("label.refreshable").each(function () {
        $(this).attr('title', 'Klik untuk refresh ini');
        $(this).attr('rel', 'tooltip');
        $(this).append('<i class="entypo-arrows-ccw"></i> ');
        $(this).tooltip();
    });
    $("label.refreshable").click(function () {
        var control = $(this).parent();
        control.addClass('animation-loading-1');
        var element_id = $(this).parent().find('input,textarea,select').attr('id');
        $.ajax({
            type: 'GET',
            url: window.location.href,
            success: function (jqXHR, textStatus, errorThrown) {
                control.removeClass('animation-loading-1');
                var elemenbaru = $(jqXHR).find("#" + element_id).html();
                $("#" + element_id).html(elemenbaru);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                control.removeClass('animation-loading-1');
            }
        });
    });
}
/**
 * filter karakter selain number
 */
function setNumbersOnly(obj) {
    var d = $(obj).attr('numeric');
    var value = $(obj).val();
    var orignalValue = value;
    value = value.replace(/[0-9]*/g, "");
    var msg = "Only Integer Values allowed.";

    if (d == 'decimal') {
        value = value.replace(/\./, "");
        msg = "Only Numeric Values allowed.";
    }

    if (value != '') {
        orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
        $(obj).val(orignalValue);
    }
}

function setHurufsOnly(obj) {

    var value = $(obj).val();
    var orignalValue = value;
    value = value.replace(/[a-zA-Z ]*/g, "");
    var msg = "Only Alphabet Values allowed.";

    if (value != '') {
        orignalValue = orignalValue.replace(/([^a-zA-Z ].*)/g, "")
        $(obj).val(orignalValue);
    }
}

function setHurufCharacterOnly(obj) {

    var value = $(obj).val();
    var orignalValue = value;
    value = value.replace(/[^0-9]*/g, "");
    var msg = "Only Alphabet dan Character Values allowed.";

    if (value != '') {
        orignalValue = orignalValue.replace(/([0-9].*)/g, "")
        $(obj).val(orignalValue);
    }
}


function setAngkaComaOnly(obj, e){
	
	var value = $(obj).val();
	var orignalValue = value;        
	value = value.replace(/[0-9,]*/g, "");        
	var msg = "Only Alphabet dan Character Values allowed.";
        
        if (orignalValue == ''){
            if($(obj).hasClass('setkosong')){
                $(obj).val('');
            }else{                
                $(obj).val(0);
            }
        }else{
            if (value != '') {                                       
                orignalValue = orignalValue.replace(/[^0-9,]*/g,"");                
                $(obj).val(orignalValue);
            }else{
                orignalValue = orignalValue.replace(/[^0-9,]*/g,"").replace(/\,/,"x").replace(/\,/g,"").replace(/\x/,",");                                
                $(obj).val(orignalValue);
            }
        }
}

function setAngkaSpasiOnly(obj, e) {

    var value = $(obj).val();
    var orignalValue = value;
    value = value.replace(/[0-9\s]*/g, "");
    var msg = "Only Alphabet and Space allowed.";


    if (value != '') {
        orignalValue = orignalValue.replace(/([^0-9\s].*)/g, "");
        $(obj).val(orignalValue);
    }
}


function setAngkaDotOnly(obj) {

    var value = $(obj).val();
    var orignalValue = value;
    value = value.replace(/[0-9.]*/g, "");
    var msg = "Only Alphabet dan Character Values allowed.";

    if (value != '') {
        orignalValue = orignalValue.replace(/([^0-9.].*)/g, "")
        $(obj).val(orignalValue);
    }
}

function setAngkaHurufsOnly(obj) {

    var value = $(obj).val();
    var orignalValue = value;
    value = value.replace(/[ a-zA-Z 0-9]*/g, "");
    var msg = "Only Alphabet Values allowed.";

    if (value != '') {
        orignalValue = orignalValue.replace(/([^a-zA-Z 0-9].*)/g, "")
        $(obj).val(orignalValue);
    }
}


function setHurufsKomaTitikOnly(obj){

	var value = $(obj).val();
	var orignalValue = value;
	value = value.replace(/[ a-zA-Z .,]*/g, "");
	var msg = "Only Alphabet dan Character Values allowed.";

	if (value != '') {
		orignalValue = orignalValue.replace(/([^ a-zA-Z .,].*)/g, "")
		$(obj).val(orignalValue);
	}
}

function setAlphaNumericOnly(obj) {

    var value = $(obj).val();
    var orignalValue = value;
    value = value.replace(/[a-zA-Z0-9]*/g, "");
    var msg = "Only Alphabet Values allowed.";

    if (value != '') {
        orignalValue = orignalValue.replace(/([^a-zA-Z0-9].*)/g, "")
        $(obj).val(orignalValue);
    }
}

function setCustomOnly(obj) {

    var value = $(obj).val();
    var orignalValue = value;
    value = value.replace(/[- a-zA-Z0-9.,/<>()]*/g, "");
    var msg = "Only Alphabet Values allowed.";

    if (value != '') {
        orignalValue = orignalValue.replace(/([^- a-zA-Z0-9.,/<()].*)/g, "")
        $(obj).val(orignalValue);
    }
}

function setKodeICD(obj) {

    var value = $(obj).val();
    var orignalValue = value;
    value = value.replace(/[-a-zA-Z0-9.+]*/g, "");
    var msg = "Only Alphabet Values allowed.";

    if (value != '') {
        orignalValue = orignalValue.replace(/([^-a-zA-Z0-9.+].*)/g, "")
        $(obj).val(orignalValue);
    }
}

function setKodeDTD(obj) {

    var value = $(obj).val();
    var orignalValue = value;
    value = value.replace(/[-a-zA-Z0-9]*/g, "");
    var msg = "Only Alphabet Values allowed.";

    if (value != '') {
        orignalValue = orignalValue.replace(/([^-a-zA-Z0-9].*)/g, "")
        $(obj).val(orignalValue);
    }
}

function setKodeAlatMedis(obj) {

    var value = $(obj).val();
    var orignalValue = value;
    value = value.replace(/[-a-zA-Z0-9 ]*/g, "");
    var msg = "Only Alphabet Values allowed.";

    if (value != '') {
        orignalValue = orignalValue.replace(/([^-a-zA-Z0-9 ].*)/g, "")
        $(obj).val(orignalValue);
    }
}

function setUsernameVal(obj) {

    var value = $(obj).val();
    var orignalValue = value;
    value = value.replace(/[a-z0-9.]*/g, "");
    var msg = "Only Alphabet Values allowed.";

    if (value != '') {
        orignalValue = orignalValue.replace(/([^a-z0-9.].*)/g, "");
        $(obj).val(orignalValue);
    }
}

function tambah_data_baris(obj){    
    var tr = $(obj).parents(".baris").clone();
    
    $(obj).parents(".form-body").append(tr);
}

function hapus_data_baris(obj, func){
    var id_attr = $(obj).parents(".form-utama").attr('id');
    var id = $(obj).parents(".baris").find('.det_id').val();    
    var del = $(obj).parents(".form-utama").attr('del');    
    var elAda = document.getElementById(id_attr+'-hapus');
    
    
    
    window.parent.myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!", function(r){
        if (r){
            if (elAda === null){                
                var newNode = document.createElement('table');                
                var referenceNode = document.querySelector('#'+id_attr);  
                var childNode = document.createElement('tbody');
                                
                newNode.setAttribute('id',id_attr+'-hapus');
                newNode.setAttribute('class','hide');
                
                childNode.setAttribute('class','form-body');
                                
                referenceNode.after(newNode);    
                newNode.appendChild(childNode);
            }
            
            if (id != ''){
                $("#"+id_attr+'-hapus > .form-body').append("<tr><td><input type='hidden' name='"+del+"_hapus[]' value='"+id+"'></td></tr>");
            }
            
            $(obj).parents(".baris").remove();
            if (typeof func === "function") {                 
                func();
            }
            
        }
    })
    
    return false;
}

var set_dis = (obj, disabled) => {
    var cek = $(obj).prop("checked");
    var jenis = $(obj).attr("jenis");
    
    if (!$(obj).hasClass('ket-dis')){
        $(obj).parents(".kelompok").find(".ket-dis").attr("disabled", true);
        $(obj).parents(".kelompok").find(".ket-dis-2").attr("disabled", true);
        $(obj).parents(".kelompok").find(".add-on").hide();
    }
    $(obj).parents(".kelompok-2").find(".ket-dis-2").attr("disabled", true);                
   

    if (cek && $(obj).hasClass('open-ket-dis') && !$(obj).hasClass('data-terpisah') ){        
        $(obj).parents(".kelompok").find(".ket-dis:not(.ket-dis-2)").removeAttr("disabled");            
        $(obj).parents(".kelompok").find(".add-on").show();
    }

    if (cek && $(obj).hasClass('open-ket-dis') && $(obj).hasClass('data-terpisah') ){        
        $(obj).parents(".kelompok-data").find(".ket-dis:not(.ket-dis-2)").removeAttr("disabled");            
    }

    if (cek && $(obj).hasClass('open-ket-dis-2')){        
        $(obj).parents(".kelompok-2").find(".ket-dis-2").removeAttr("disabled");            
    }
    
    if (cek && $(obj).hasClass('tidak-ada')){        
        $(obj).parents(".kelompok").find(".ket-dis").attr("disabled",true);
        $(obj).parents(".kelompok").find("input:radio,input:checkbox").prop('checked',false);
    }else{
        if (cek){
            $(obj).parents(".kelompok").find("input:radio.tidak-ada,input:checkbox.tidak-ada").prop('checked',false);
        }
    }

    if (typeof jenis !== 'undefined'){                        
        $(obj).parents(".form-data").find("input:not(.not-dis),select:not(.not-dis)").attr("disabled",true);            
        if (cek){
            $(obj).parents(".form-data").find("input."+jenis+":not(.ket-dis,.ket-dis2),select."+jenis+":not(.ket-dis,.ket-dis2)").removeAttr("disabled");            
        }
    }

    $(obj).prop("checked", cek);
}

/**
 * Set functions on ready windows
 */
$(document).ready(function () {
    $( "#instruction_form" ).wrapInner( "<div class='outlinepetunjuk'></div>");
    $('.comadesimal-only').keypress(function (event) {
        if ((event.keyCode != 37) && (event.keyCode != 39) && (event.which != 8) && (event.which != 44) && ((event.which < 48) || (event.which > 57)))
        {
            event.preventDefault();
        }

        if (event.which == 44 && $(this).val().indexOf(',') != -1) {
            event.preventDefault();
        }//prevent coma more than one
    });
    //numbers-only = input hanya nomor
    $('.numbers-only').keyup(function () {
        setNumbersOnly(this);
    });

    $('.angka-spasi').keyup(function () {
        setAngkaSpasiOnly(this);
    });

    $('.hurufs-only').keyup(function () {
        setHurufsOnly(this);
    });

    $('.hurufkomatitik-only').keyup(function() {
        setHurufsKomaTitikOnly(this);
    });

    $('.angkacoma-only').keyup(function (e) {
        setAngkaComaOnly(this);
    });

    $('.angkadot-only').keyup(function () {
        setAngkaDotOnly(this);
    });

    $('.hurufcharacter-only').keyup(function () {
        setHurufCharacterOnly(this);
    });

    $('.angkahuruf-only').keyup(function () {
        setAngkaHurufsOnly(this);
    });

    $('.alphanumeric-only').keyup(function () {
        setAlphaNumericOnly(this);
    });

    $('.custom-only').keyup(function () {
        setCustomOnly(this);
    });

    $('.kode-icd').keyup(function () {
        setKodeICD(this);
    });

    $('.kode-alatmedis').keyup(function () {
        setKodeAlatMedis(this);
    });

    $('.kode-dtd').keyup(function () {
        setKodeDTD(this);
    });

    $('.username-only').keyup(function () {
        setUsernameVal(this);
    });

    /**class : all-caps = kapital semua */
    $('.all-caps').keyup(function () {
        var allcaps = $(this).val().toUpperCase();
        $(this).val(allcaps);
    });
     /**class : all-lower = kecil semua */
    $('.all-lower').keyup(function() {
        var alllower = $(this).val().toLowerCase();
        $(this).val(alllower);
    });
    /**class : integer = format integer*/
    $(".integer").maskMoney(
            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
    );
    /**class : float = format float / double (2 angka dibelakang koma)*/
    $(".float").maskMoney(
            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 2}
    );
    /**class : umur = 00 Thn 00 Bln 00 Hr */
    $(".umur").mask("99 Thn 99 Bln 99 Hr");
    /**class : datemask = 00/00/0000 */
    $(".datemask").mask("99/99/9999");
    /**class : datetimemask = 00/00/0000 */
    $(".datetimemask").mask("99/99/9999 99:99:99");
    /** realtime clock */
    if ($(".realtime").length > 0) {
        setInterval('date_time()', 1000);
    }

     /** realtime clock Header RSPMC-770 */
    if ($(".headerTimeClock").length > 0) {
        setInterval('date_time_id()', 1000);
    }

    /**
     * set class "required" when accordion show hide
     */
    $(".accordion-heading").click(function () {
        var collapse = false;
        $(this).parent().find(".accordion-body.in.collapse").each(function () {
            collapse = true;
        });
        if (collapse) {
            $(this).find(".icon-minus").addClass("icon-plus").removeClass("icon-minus");
            $(this).find(".btn").removeClass("btn-primary");
            $(this).parent().find(".required").addClass("not-required").removeClass("required");
        } else {
            $(this).find(".icon-plus").addClass("icon-minus").removeClass("icon-plus");
            $(this).find(".btn").addClass("btn-primary");
            $(this).parent().find(".not-required").addClass("required").removeClass("not-required");
        }
        $(this).parent().find(".control-group.error").removeClass("error");
        $(this).parent().find(".control-group.success").removeClass("success");
        $(this).parent().find('.disabledCollapseAll').attr("disabled", true);
    });
    $(".accordion-group").find(".required").addClass("not-required").removeClass("required");
    $(".accordion-group > .accordion-heading").find(".btn").removeClass("btn-primary");
    $(".accordion-group").find(".accordion-body.collapse").each(function () {
        $(this).parent().find("input,select").not('.disabledCollapseAll').attr("disabled", true);
    });
    $(".accordion-group").find(".accordion-body.collapse.in").each(function () {
        $(this).find(".not-required").addClass("required").removeClass("not-required");
        $(this).parent().find(".btn").addClass("btn-primary");
        $(this).parent().find(".icon-ok").addClass("icon-menus").removeClass("icon-ok");
        $(this).parent().find("input,select").not('.disabledCollapseAll').removeAttr("disabled");
    });
    //tambahkan class 'refreshable' di label
    resetElement();
});

function requiredCheckInformasi(obj) {
    var kosong = 0;
    $(obj).find('input,select,textarea').each(function () {
        if ($(this).parents(".control-group").find("label").hasClass('required') === true) {
            $(this).parents(".control-group").removeClass("error").removeClass("success");
        }
    });
    $(obj).find('input,select,textarea').each(function () {
        if ($(this).parents(".control-group").find("label").hasClass('required') === true || $(this).hasClass('required')) {
            if (($(this).val() === "") && !$(this).is(":disabled")) {
                if ($(this).is(":hidden")) { //untuk element type:hidden
                    var radio_checked = false;
                    $(this).parent().find(".radio").each(function () { //mengecek element radio button
                        if ($(this).find("input").is(":checked")) {
                            radio_checked = true;
                        }
                    });
                    if (radio_checked == false) {
                        $(this).parents(".control-group").addClass("error");
                        $(this).addClass("error");
                        kosong++;
                    } else {
                        $(this).parents(".control-group").removeClass("error");
                        $(this).removeClass("error");
                    }
                } else {
                    $(this).parents(".control-group").addClass("error");
                    $(this).addClass("error");
                    kosong++;
                }
            } else {
                $(this).parents(".control-group").removeClass("error");
                $(this).removeClass("error");
            }
        }
    });
    if (kosong > 0) {
        myAlert("Silakan isi yang bertanda bintang &lt;span class='required'&gt;*&lt;/span&gt; !");//("+kosong+" input)
        return false;
    } else {

        return true;
    }
}
