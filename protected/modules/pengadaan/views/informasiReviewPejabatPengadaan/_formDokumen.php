<?php
/**
 * view ini digunakan untuk menampilkan semua form pada menu transaksi persiapan pengadaan
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);

$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'dokumenreview-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    ));
?>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Dokumen Pendukung RUP </b></div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed table-striped" id="form-dokpendukung">
            <thead>
                <tr>
                    <th style="text-align: center; width: 10%"> No </th>
                    <th style="text-align: center"> Jenis Dokumen </th>
                    <th style="text-align: center"> File</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Dokumen Pendukung Persiapan Pengadaan </b></div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed table-striped" id="form-dokpendukung-persiapanpengadaan">
            <thead>
                <tr>
                    <th style="text-align: center; width: 10%"> No </th>
                    <th style="text-align: center"> Jenis Dokumen </th>
                    <th style="text-align: center"> File</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
<?php 
if (empty($_GET['sukses'])) {
    if ($modInfo->infoumumpengadaan_status == Params::STATUS_INFORMASI_UMUM_REVISI_DOKUMEN || $modInfo->infoumumpengadaan_status == Params::STATUS_INFORMASI_UMUM_DIAJUKAN) {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => "<i class='fa fa-check'></i>")), array('class' => 'btn btn-succes', 'type' => 'button', 'onclick' => 'cekForm();return false;', 'id' => 'btn_submit'));
    }   
    echo "&nbsp"; 
    echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;'));
} else {
    echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.go(-2);return false;', 'style' => 'color: white;'));
}

?>
<?php $this->endWidget(); ?>

<script>
    function cekForm() {
        $('#dokumenreview-t-form').submit();
        disableOnSubmit($("#btn_submit"), 'no_unformat');
    }
    
    function setDokumenLoad() {
        var id = <?php echo $model->rencanaumumpengadaan_id; ?>;
        $('#form-dokpendukung > tbody').html("");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadDokumen'); ?>',
            data: {
                rencanaumumpengadaan_id: id,
                is_update: 'ya',
                tipe: 'load'
            }, //
            dataType: "json",
            success: function (data) {
                $('#form-dokpendukung > tbody').append(data.dokDukung);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                renameInputRow($("#form-dokpendukung"));

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function setDokumenLoadPersiapan() {
        var id = <?php echo $model->persiapanpengadaan_id; ?>;
        $('#form-dokpendukung > tbody').html("");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadDokumenPersiapanPengadaan'); ?>',
            data: {
                persiapanpengadaan_id: id,
                is_update: 'ya',
                tipe: 'load'
            }, //
            dataType: "json",
            success: function (data) {
                $('#form-dokpendukung-persiapanpengadaan > tbody').append(data.dokDukung);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                renameInputRow($("#form-dokpendukung-persiapanpengadaan"));

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function renameInputRow(obj_table) {
        var row = 0;
        var count = $(obj_table).find("tbody > tr").length;

        $(obj_table).find("tbody > tr").each(function () {
            $(this).attr('rowdata', row);
            $(this).find('.no-urut').html(row + 1);
            $(this).find('span').each(function () { //element <input>
                if (typeof $(this).attr("name") != 'undefined') {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                    }
                }
            });
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }

                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });

            if (count == 1) {
                $(this).find('.btntambah').removeClass('hide');
                $(this).find('.btnhapus').addClass('hide');
            } else {
                if (count == (row + 1)) {
                    $(this).find('.btntambah').removeClass('hide');
                    $(this).find('.btnhapus').addClass('hide');
                } else {
                    $(this).find('.btnhapus').removeClass('hide');
                    $(this).find('.btntambah').addClass('hide');
                }
            }

            row++;
        });

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    function fileLoad(obj){
        $(obj).parents(".load-gambar").find('input:file').trigger('click');
    }
    
    function cekFile(obj){       
        
        var cek = $(obj).val();       
        if (cek != ''){
            var type = $(obj).get(0).files[0]['type'];
            var tipeFile = type.split('/');                    
            var ext = '.'+$(obj).val().split('.').pop().toLowerCase();           
            var fileExt = $(obj).attr('accept').split(',');        
                                                
            if($.inArray(ext, fileExt) == -1 && $.inArray(tipeFile[0]+'/*', fileExt) == -1) {
                myAlert('Tipe file yang diupload tidak diizinkan !',"Perhatian!");
                $(obj).val(""); 
                $(".fileinput-exists").trigger('click');
                return false;
            }

            var sizee = $(obj).get(0).files[0].size; //file size in bytes
            sizee = sizee / 1024; //file size in Kb
            sizee = sizee / 1024; //file size in Mb

            if (sizee > 10) {
                myAlert("Ukuran file tidak boleh lebih dari 200kb/2mb","perhatian !");
                $(obj).val("");                 
                $(obj).parents(".load-gambar").find('.labelbrowse').html('');
                $(".fileinput-exists").trigger('click');
                return false;
            }else{                
                $(obj).parents(".load-gambar").find('.labelbrowse').html("<u>"+$(obj).get(0).files[0]['name']+"</u>");
            }
        }
       
    }

    $(document).ready(function () {
        setDokumenLoad();
        setDokumenLoadPersiapan();
    });
</script>