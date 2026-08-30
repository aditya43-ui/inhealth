<style type="text/css">
    .text-center{
        text-align: center !important;
    }
    .font-bold{
        font-weight: bold;
        color: black;
    }
    .disable-panel{
        margin:0;padding:0!important;cursor:not-allowed;position: absolute;z-index:99999;height:96%;width:97%;
    }

    select[disabled]{
        background:#eeeeee;
    }
    .bodydivObservasi{
        height: 1000px
    }
</style>
<div class="bodydivObservasi">
<?php
if(isset($_GET['sukses'])){
    Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'observasiri-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id'); ?>
<?php echo $form->hiddenField($model, 'pasien_id'); ?>

<div class="row-fluid">
    <div class="col-md-12">
        <p class="help-block"><?php echo Yii::t('mds','Pilih Salah Satu Lembar Observasi') ?></p>  
        <div class="panel panel-success panel_choise" id="choise_observasiAnak">
            <div class="panel-heading">
                <div class="panel-title"><?php echo $form->radioButton($model, 'isobservasi_anakbayi', array('onclick' => 'choiseObservasi(this)', 'value' => 'anak', 'class'=>'pilih_anak', 'uncheckValue'=>null)); ?> Observasi Pasien Anak/ Bayi</div>
            </div>
            <div class="panel-body" >
                <div class="formObservasiAnak">
                    <?php $this->renderPartial($this->path_view.'_formAnak',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)) ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success panel_choise" id="choise_observasiDewasa">
            <div class="panel-heading">
                <div class="panel-title"><?php echo $form->radioButton($model, 'isobservasi_anakbayi', array('onclick' => 'choiseObservasi(this)', 'value' => 'dewasa', 'class'=>'pilih_dewasa', 'uncheckValue'=>null)); ?> Observasi Pasien Dewasa</div>
            </div>
            <div class="panel-body" >
                <div class="formObservasiDewasa">
                    <?php $this->renderPartial($this->path_view.'_formDewasa',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>
</div>