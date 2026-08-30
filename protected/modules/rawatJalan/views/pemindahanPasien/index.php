<?php
$labelheader = "Formulir Transfer Pasien Antar Ruangan";
$labelheaderDataIsi = "Data Pengisi";

if(isset($_GET['pasienditerima']) && ($_GET['pasienditerima'] == 'diterima')){
  $labelheader = "Form Penerimaan";
  $labelheaderDataIsi = "Data Pegawai Asal";
}
    $this->breadcrumbs = array(
        $labelheader,
    );
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    }
    $this->widget('bootstrap.widgets.BootAlert');


?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>


<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title" style="width: 100%">
            <b><?php echo $labelheader; ?></b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); ?>

        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>Riwayat Pemindahan Pasien</strong></div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'_riwayat', array('modPendaftaran'=>$modPendaftaran)); ?>
            </div>
        </div>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'frm-pemindahanpasien',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)',),
        ));
        ?>
        <?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
        <?php echo $form->hiddenField($model, 'pasienadmisi_id'); ?>

        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>Catatan Pemindahan Pasien</strong></div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'_form', array('form'=>$form,'model'=>$model,'modPendaftaran'=>$modPendaftaran,'labelheaderDataIsi'=>$labelheaderDataIsi)); ?>
            </div>
        </div>

        <div class="row-fluid">
            <div class="form-actions">
                <?php
                  $disabledSimpan = (isset($_GET['sukses'])?true:false);
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'button', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>$disabledSimpan, 'onclick' => 'cekTujuanTransfer();'));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                        $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']),
                        array('class'=>'btn btn-danger',
                            'onclick'=>'return refreshForm(this);'))."&nbsp;";
                            
                    if(isset($_GET['pasienditerima']) && ($_GET['pasienditerima'] == 'diterima')){
                      echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')),
                              'javascript:void(0);', array('class'=>'btn btn-info',
                              'onclick'=>"print(".(isset($_GET['pemindahanpasien_id'])?$_GET['pemindahanpasien_id']:"").");return false",'disabled'=>($disabledSimpan==true)?false:true))."&nbsp;";
                    }
                ?>
                <?php
                    $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
                    $this->widget('UserTips',array('type'=>'admin','content'=>$content));
                ?>
            </div>
        </div>
      <?php $this->endWidget(); ?>
    </div>
</div>

<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modPasien'=>$modPasien)); ?>
