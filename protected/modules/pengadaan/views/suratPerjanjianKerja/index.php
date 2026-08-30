<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
$ubah = isset($_GET['ubah'])?'ya':'tidak';
?>
<style> 
    .form-horizontal .control-label{
        width: 145px !important
    } 
    #popup_container{
        top: 100px !important
    }
    
    .lineheight td{
        line-height: 1.42857143 !important;
    }
    .input-prepend .add-on, .input-append .add-on{
        float: right;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Data <b> Kontrak </b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'surat-perjanjian-kerja-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event);',
//                'onsubmit' => 'return requiredCheck(this);',
            // 'enctype' => 'multipart/form-data',
            ),
            'focus' => '#SuratperjanjiankerjaT_konfigtemplatesurat_id'
        ));
        
        ?>

        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model, 'konfigtemplatesurat_id', CHtml::listData(KonfigtemplatesuratK::model()->findAllByAttributes(array('jenissurat_id' => 22)), 'konfigtemplatesurat_id', 'konfigtemplatesurat_nama'), array('class' => 'span3 jenisform', 'onkeyup' => "return $(this).focusNextInputField(event)", 'return false;')); ?>
            </div>
            <div class="col-sm-6">
            </div>
        </div>
        <?php
        echo $this->renderPartial($this->path_view . '_dataSuratPerjanjianKerja', array(
            'form' => $form,
            'model' => $model,
            'modPengadaan' => $modPengadaan
                ), true);
        echo $this->renderPartial($this->path_view . '_pihakPertama', array(
            'form' => $form,
            'model' => $model,
                ), true);
        echo $this->renderPartial($this->path_view . '_pihakKedua', array(
            'form' => $form,
            'model' => $model,
                ), true);
        echo $this->renderPartial($this->path_view . '_dataPerencanaan', array(
            'form' => $form,
            'model' => $model,
                ), true);
        
        $hps = '_HPS';
        if (isset($_GET['ubah'])){
            $hps = 'ubah/_HPS';
        }
        
        echo $this->renderPartial($this->path_view . $hps, array(
            'form' => $form,
            'model' => $model,
            'modDet' => $modDet,
            'modTermin2' => $modTermin2,
            'modTermin' => $modTermin
                ), true);
//        echo $this->renderPartial($this->path_view . '_dasarPengerjaan', array(
//            'form' => $form,
//            'model' => $model,
//                ), true);
        echo $this->renderPartial($this->path_view . '_pejabatTerkait', array(
            'form' => $form,
            'model' => $model,
                ), true);
        
        if ($ubah == 'ya'){
            echo $this->renderPartial($this->path_view . 'ubah/_alasan_ubah', array(
                'form' => $form,
                'model' => $model,
                    ), true);
        }
        
        ?>

        <div class="form-actions">
            <?php
            if (!$model->isNewRecord) {                
                if (!isset($_GET['ubah'])){
                    if($model->suratperjanjiankerja_status == 'SPK Diterbitkan'){
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit',
                            'type' => 'button', 'onclick' => 'cekForm();', 'id' =>  'btn_submit', 'disabled' => true));
                    }else{
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary',
                            'type' => 'button' ,'disabled' => true,'id' =>  'btn_submit',   'onclick' => 'window.parent.toastr.error("Data SPK tidak dapat diubah karena SPMK sudah diterbitkan","Perhatian!");'));
                    }
                }else{
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit',
                    'type' => 'button', 'id' =>  'btn_submit', 'onclick' => 'cekForm();'));
                }
            }else{                
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit',
                    'type' => 'button', 'id' =>  'btn_submit', 'onclick' => 'cekForm();'));
            }
            
            echo "&nbsp;";
            if (!isset($_GET['frame']) || $_GET['frame'] != 1) {
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
                    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                echo "&nbsp;";
            }

            if ($ubah == 'tidak'){
                if (!$model->isNewRecord) {
                    echo CHtml::link('<i class="entypo-pencil"></i> Input Pasal', $this->createUrl('/pengadaan/pasalSuratPerjanjianKerja/index', array('id' => $model->suratperjanjiankerja_id, 'frame' => 1)), array(
                        'class' => 'btn btn-success',
                    )) . " ";
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak SPK', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:;', array('class' => 'btn btn-succes', 'onclick' => 'print();'));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak Pasal', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:;', array('class' => 'btn btn-succes', 'onclick' => 'printPasal();'));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak SSUK', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:;', array('class' => 'btn btn-succes', 'onclick' => 'pilihSSUK();'));
                    echo "&nbsp;";
                }
            


                $content = $this->renderPartial($this->path_view . 'tips/transaksi', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            }
            ?>
        </div>    
        <?php if ($ubah == 'tidak'){ ?>
        <br>
        <span class="required"><i>SPK yang sudah disimpan tidak bisa diubah, mohon dipastikan data yang dimasukkan sudah benar sebelum menyimpan data</i></span>
        <?php } ?>
        
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php
echo $this->renderPartial($this->path_view . '_dialog', array('model'=>$model), true);
echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modTermin' => $modTermin, 'modTermin2' => $modTermin2), true);
?>
<?php
// ===========================Dialog Import SPK =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogUpload',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Unggah Dokumen',
    'autoOpen'=>false,
    'width'=>650,
    'height'=>500,
    'resizable'=>true,
    'scroll'=>false,
    ),
));
?>
<iframe src="" name="iframe3" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Import SPK================================
?>

<script>
    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->suratperjanjiankerja_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }
    
    function printPasal() {
        window.open('<?php echo $this->createUrl('/pengadaan/pasalSuratPerjanjianKerja/print', array('id' => $model->suratperjanjiankerja_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }
    
    
    
    function pilihSSUK(){
        $("#dokssuk").val('');
        
        window.parent.$("#dialogPilihSSUK").dialog('open');
    }
</script>