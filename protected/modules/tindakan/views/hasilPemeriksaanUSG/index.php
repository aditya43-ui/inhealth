<style type="text/css">
    .text-center{
        text-align: center !important;
    }
</style>
<?php
    $this->breadcrumbs = array(
        'Hasil Pemeriksaan USG',
    );
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data Hasil Pemeriksaan USG berhasil disimpan");
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>

<?php $this->renderPartial($this->path_view.'_riwayatHasilPemeriksaan',array('model'=>$model)); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'hasilpemeriksaanusg-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
));
?>
<div class="panel panel-default panel-shadow">
    <div class="panel-heading">
            <div class="panel-title">Input <strong>Hasil Pemeriksaan USG</strong></div>
    </div>
    <div class="panel-body">
        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>
        <div class="row-fluid">
            <div class="col-sm-12">
                 <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                <?php echo $form->hiddenField($model, 'pemeriksaanusgpasien_id'); ?>
                <?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
                <?php echo $form->hiddenField($model, 'pasienadmisi_id'); ?>
                <?php echo $form->hiddenField($model, 'pasien_id'); ?>
                <?php echo $form->hiddenField($model, 'ruanganperiksausg_id'); ?>
                
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tgl_pemeriksaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                          <?php 
                          $this->widget('MyDateTimePicker',array(		                                        
                            'model'=>$model,	
                              'attribute'=>'tgl_pemeriksaan',
                                'mode'=>'datetime',
                                'options'=> array(
                                     'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',	
                                ),
                                'htmlOptions'=>array(
                            'readonly'=>TRUE,
                            'class'=>'span3',
                            'onkeyup'=>"return $(this).focusNextInputField(event),",
                                ),
                              ));
                          ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($model, 'dokterpemeriksa_id', CHtml::listData(DokterV::model()->findAll('pegawai_aktif = true ORDER BY nama_pegawai ASC'), 'pegawai_id', 'NamaLengkap'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
            </div>
        </div>
        <?php $this->renderPartial($this->path_view.'_formTabulasi',array('model'=>$model,'modDetail'=>$modDetail,'form'=>$form, 'modDetailUsg'=>$modDetailUsg)) ?>
    </div>
</div>    
<div class="row-fluid">
    <div class="form-actions">
            <?php
                    if(isset($_GET['sukses'])){
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','enabled'=>true));
                            echo "&nbsp;";
                    }else{
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekSimpanData();', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>false)); //RND-8620
                            echo "&nbsp;";
                    }
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']), 
                        array('class'=>'btn btn-danger',
                            'onclick'=>'return refreshForm(this);'));
            ?>
            <?php 
                    $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
                    $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model, 'modDetailUsg'=>$modDetailUsg)); ?>
