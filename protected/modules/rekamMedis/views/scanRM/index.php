<?php 
if(!empty($modPendaftaran) && !in_array(Yii::app()->user->getState('modul_id'), [Params::MODUL_ID_LAB, Params::MODUL_ID_RAD])) {
    if($modPendaftaran->validasiRekamMedis()) {
       echo CustomFunction::alertRekamMedis();
    }
}
?>
<?php
$this->breadcrumbs = array(
    'Scan Dokumen Rekam Medis',
); ?>

<style>
    .img_scan {
        margin: 10px;
        padding: 10px;
        border: 1px solid #b4e8a8;
        border-radius: 3px;
        float: left;
    }
</style>

<?php
$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$modul_id = Yii::app()->user->getState('modul_id');
$readonly = false;

// echo '<pre>'; var_dump($pg_login->kelompokpegawai_id == 2, $pg_login->pegawai_id !== 1, $pg_login->pegawai_id !== 1028); die;

$hide = $readonly ? " hide" : "";
$hidden = $readonly ? " hidden" : "";
$visibility = isset($_GET['lihat']) ? 'hide' : '';
?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sadokrekammedis-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Scan Dokumen Rekam Medis
            <?php 
                if(isset($_GET['penunjang'])) {
                    $link = $_GET['penunjang'];
            ?>
                <a href="<?= $this->createUrl("/$link/daftarPasien/index") ?>" class="btn btn-default" style="float: right;">Kembali</a>
            <?php 
                }
            ?>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . "_dataPasien", array('modPendaftaran'=>$modPendaftaran,'modFile'=>$modFile), true); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Dokumen Hasil Scan
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label('Scan Dokumen RM', '', array('class' => 'control-label')); ?>
                    <div class="controls upload_image">
                        <?php

                        // echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i> Refresh Dokumen', array(
                        //     'class' => 'btn btn-primary',
                        //     'onclick' => 'refreshScanRM();'
                        // ));

                        // //                        echo " ";
                        // //                        echo CHtml::htmlButton('Buka Scanner', array(
                        // //                            'class'=>'btn btn-info',
                        // //                            'onclick'=>'launchScanner();'
                        // //                        ));


                        // echo " ";
                        // echo CHtml::link("Upload", 'javascript:;', array('onclick' => 'fileLoad(this);', 'class' => 'btn btn-primary')) . '&nbsp;' . CHtml::link("<u></u>", 'javascript:;', array('onclick' => 'fileLoad(this);', 'class' => 'labelbrowse'));
                        // //echo "<br/>".CHtml::link("<u></u>",$this->createUrl('UnduhDok',array('ruangpertemuan_picture_id'=>$model->ruangpertemuan_picture_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;'));
                        // echo "<div class='hide'>";
                        // echo CHtml::fileField('picture_nama', '', array('onchange' => 'cekFile(this);', 'accept' => 'image/*,application/pdf,.pdf',));
                        // echo "</div>";


                        // echo " ";
                        // echo CHtml::link("<i class='" . MyIcon::getIcons('simpan') . "'></i> Simpan File", 'javascript:;', array('onclick' => 'simpanGambar(this);', 'class' => 'btn btn-primary hide', 'id' => 'simpan_gambar'));
                        echo CHtml::htmlButton('<i class="fas fa-image"></i> Buka Scanner', array(
                            'class' => 'btn btn-primary',
                            'onclick' => 'launchScanner();'
                        )) . CHtml::htmlButton('<i class="entypo-arrows-ccw"></i> Refresh Dokumen', array(
                            'class' => 'btn btn-default',
                            'onclick' => 'refreshScanRM();'
                        ));

                        echo CHtml::link('<i class="fas fa-upload"></i> Upload', 'javascript:;', array('onclick' => 'fileLoad(this);', 'class' => 'btn btn-success hideread')) . '&nbsp;' . CHtml::link("<u></u>", 'javascript:;', array('onclick' => 'fileLoad(this);', 'class' => 'labelbrowse hideread'));
                        //echo "<br/>".CHtml::link("<u></u>",$this->createUrl('UnduhDok',array('ruangpertemuan_picture_id'=>$model->ruangpertemuan_picture_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;'));
                        echo "<div class='hide'>";
                        echo CHtml::activeFileField($model, 'picture_nama[]', array('multiple' => true, 'onchange' => 'cekFile(this);', 'accept' => 'image/*,application/pdf,.pdf',));

                        echo "</div>";
                        // echo CHtml::activeDropDownList(
                        //     $model,
                        //     'instalasi_ids',
                        //     CHtml::listData(InstalasipelayananV::model()->findAll(), 'instalasi_id', 'instalasi_nama'),
                        //     array('class' => 'form-control', 'multiple' => 'multiple')
                        // );

                        if(!isset($_GET['lihat'])) {
                            echo CHtml::link("<i class='" . MyIcon::getIcons('simpan') . "'></i> Simpan File", 'javascript:;', array('onclick' => 'simpanGambar(this);', 'class' => 'btn btn-danger hideread ' . $visibility, 'id' => 'simpan_gambar'));

                        }
                        ?>
                        <!--//?>-->
                    </div>
                </div>
                
                    <table id="tbl_gambar" width="50%">
                        <tbody></tbody>
                    </table>
                
                <hr />
                <div class="panel-gambar">

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php echo $this->renderPartial($this->path_view . "_jsFunctions", array(), true); ?>

<?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog_detail',
    'options' => array(
        'title' => 'Detail Scan - <span id="img_title"></span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 850,
        'height' => 500,
        'resizable' => false,
    ),
));
?>

<iframe src="" name="iframe_detail" style="width: 100%; height: 100%;"></iframe>

<?php
$this->endWidget();
?>
<script>
    
    <?php if(isset($_GET['pendaftaran_id'])){ ?>
        function LoadPasien() {
            var pendaftaran_id = <?php echo $_GET['pendaftaran_id']?>;
    
            $.ajax({
                type:'GET',
                url:'<?php echo $this->createUrl('LoadPasien'); ?>',
                data: {
                    pendaftaran_id: pendaftaran_id
                },
                dataType: "json",
                success:function(data){
                    if(data.no_rekam_medik != ''){
                        inputPasien(data)
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
            
        }
    <?php } ?>
    
    var instalasi_ids = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_ids') ?>');
    $(document).ready(function() {
        jQuery(instalasi_ids).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        <?php if(isset($_GET['pendaftaran_id'])){ ?>
             LoadPasien();
        <?php } ?>

    });
</script>

<script>

$(document).ready(function() {
        // Notifikasi Pasien

<?php if($readonly):?>
                $('input,select,textarea').attr('disabled', true);
                $('.multiselect-selected-text').attr('disabled', true);
                $('.redactor_frame').each(function() {
                    $(this).contents().find('html > body > #page').attr("contenteditable", false);
                });

                $('.form-actions').addClass('hide');
                $('.antirow').addClass('hide');
                $('.hideread').addClass('hide');

        <?php endif;?>
    });
</script>