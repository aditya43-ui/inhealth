<script type="text/javascript">	

function cekSuplesi(obj){
    if($(obj).val() == 1){
        $("#PPSepT_no_suplesi").addClass("required");
        $("#PPSepT_no_suplesi").attr('disabled',false);
        $('.cari_suplesi').show();
    }else{
        $("#PPSepT_no_suplesi").attr('disabled','disabled');
        $("#PPSepT_no_suplesi").removeClass("required");
        $("#PPSepT_no_suplesi").removeClass("error");
        $("#PPSepT_no_suplesi").parents(".control-group").removeClass("error");
        $('.cari_suplesi').hide();
    }
}

function setPropinsi(){
    var setting = {
        url: "<?php echo Yii::app()->createUrl('asuransi/propinsi/bpjsInterface'); ?>",
        type: 'GET',
        dataType: 'html',
        data: 'param=1',
        beforeSend: function () {
        },
        success: function (data) {
            var obj = JSON.parse(data);
            var obj1 = JSON.parse(data);
            if (obj1.metaData.message != 'Sukses') {
                myAlert(obj1.metaData.message);
            }
            var list = obj.response.list;
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('asuransi/sep/SetDropdownPropinsi'); ?>',
                data: {propinsiList: list}, //
                dataType: "json",
                success: function (data) {    
                    $("#<?php echo CHtml::activeId($model, 'propinsi_lakalantas_id') ?>").empty();
                    $("#<?php echo CHtml::activeId($model, 'propinsi_lakalantas_id') ?>").append(data.form);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
            // OVERWRITES old selecor
            jQuery.expr[':'].contains = function (a, i, m) {
                return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
            };
        },
        error: function (data) {
        }
    }

    if (typeof ajax_request !== 'undefined')
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function setKabupaten(obj){
    var katakunci = $(obj).val();
    
    var propinsi = $("#<?php echo CHtml::activeId($model, 'propinsi_lakalantas_id') ?> option:selected").text();
    $("#<?php echo CHtml::activeId($model, 'propinsi_lakalantas_nama') ?>").val(propinsi);
    
    isi = "";
    if (katakunci != '') {
        var isi = katakunci;
        var aksi = 1; // 1 untuk mencari data fasilitas kesehatan
    }

    if (isi == "") {
        return false;
    }
    ;
    var setting = {
        url: "<?php echo Yii::app()->createUrl('asuransi/kabupaten/bpjsInterface'); ?>",
        type: 'GET',
        dataType: 'html',
        data: 'param=' + aksi + '&query=' + isi,
        beforeSend: function () {
        },
        success: function (data) {
            var obj = JSON.parse(data);
            var obj1 = JSON.parse(data);
            if (obj1.metaData.message != 'Sukses') {
                myAlert(obj1.metaData.message);
            }
            var list = obj.response.list;
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('asuransi/sep/SetDropdownKabupaten'); ?>',
                data: {propinsiList: list}, //
                dataType: "json",
                success: function (data) {    
                    $("#<?php echo CHtml::activeId($model, 'kabupaten_lakalantas_id') ?>").empty();
                    $("#<?php echo CHtml::activeId($model, 'kabupaten_lakalantas_id') ?>").append(data.form);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
            // OVERWRITES old selecor
            jQuery.expr[':'].contains = function (a, i, m) {
                return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
            };
        },
        error: function (data) {
            myAlert('Terjadi kesalahan saat briging');
        }
    }

    if (typeof ajax_request !== 'undefined')
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function setKecamatan(obj){
    var katakunci = $(obj).val();
    
    var kabupaten = $("#<?php echo CHtml::activeId($model, 'kabupaten_lakalantas_id') ?> option:selected").text();
    $("#<?php echo CHtml::activeId($model, 'kabupaten_lakalantas_nama') ?>").val(kabupaten);
    
    isi = "";
    if (katakunci != '') {
        var isi = katakunci;
        var aksi = 1; // 1 untuk mencari data fasilitas kesehatan
    }

    if (isi == "") {
        return false;
    }
    ;
    var setting = {
        url: "<?php echo Yii::app()->createUrl('asuransi/kabupaten/bpjsInterface'); ?>",
        type: 'GET',
        dataType: 'html',
        data: 'param=' + aksi + '&query=' + isi,
        beforeSend: function () {
        },
        success: function (data) {
            var obj = JSON.parse(data);
            var obj1 = JSON.parse(data);
            if (obj1.metaData.message != 'Sukses') {
                myAlert(obj1.metaData.message);
            }
            var list = obj.response.list;
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('asuransi/sep/SetDropdownKecamatan'); ?>',
                data: {kabupatenList: list}, //
                dataType: "json",
                success: function (data) {    
                    $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_id') ?>").empty();
                    $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_id') ?>").append(data.form);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
            // OVERWRITES old selecor
            jQuery.expr[':'].contains = function (a, i, m) {
                return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
            };
        },
        error: function (data) {
            myAlert('Terjadi kesalahan saat briging');
        }
    }

    if (typeof ajax_request !== 'undefined')
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function setKecamatanValue(obj){
    var kecamatan = $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_id') ?> option:selected").text();
    $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_nama') ?>").val(kecamatan);
}

$( document ).ready(function(){ 
    $("#form-suplesi .accordion-heading a").click(function()
    {
        $("#<?php echo CHtml::activeId($model, 'lakalantas') ?>").val(0);
        if($('#content-suplesi').hasClass('accordion-body  in collapse')) {
            cekSuplesi($('input:radio[name="PPSepT[suplesi_jasaraharja]"]:checked'));
        }else {
            var suplesi_jasaraharja = $('input:radio[name="PPSepT[suplesi_jasaraharja]"]:checked').val();
            if(suplesi_jasaraharja==1){
                $("#<?php echo CHtml::activeId($model, 'lakalantas') ?>").val(0);
            }else{
                $("#<?php echo CHtml::activeId($model, 'lakalantas') ?>").val(1);
                setPropinsi();
            }
        }
    });
    $(document).on('click keyup select change',function(){ 
        cekSuplesi($('input:radio[name="PPSepT[suplesi_jasaraharja]"]:checked'));
        if($("#<?php echo CHtml::activeId($model, 'lakalantas') ?>").val()==0){
            $('#content-suplesi').find(".required").addClass("not-required").removeClass("required");
            $('#content-suplesi').find("input,select,textarea").attr("disabled",true);
        }
    });
});

</script>