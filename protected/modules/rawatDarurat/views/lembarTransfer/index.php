<style type="text/css">
    .text-center{
        text-align: center !important;
    }
    .font-bold{
        font-weight: bold;
        color: black;
    }
</style>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'lembartransfer-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
));
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row-fluid">
    <div class="col-sm-12">
        <div class="pull-right" style="font-weight: bold; color: black;">RM RI 15.a REV 03</div>
        <br />
        <div class="panel panel-success panel-shadow" style="width: 900px">
            <div class="panel-heading">
                <div class="panel-title"><strong>Riwayat Lembar Transfer 1 </strong></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view.'_riwayatLembarTransfer',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); ?>
            </div>
        </div>
        <div style="font-style: italic; color: red;">Lembar Transfer ini diisi oleh Dokter Pengirim</div>
        <br />
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
            <?php echo $form->hiddenField($model, 'pasienadmisi_id'); ?>
            <div class="control-group ">
                <?php  echo CHtml::label('Ruangan Asal', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'ruanganasal_id'); ?>
                    <?php echo $form->textField($model, 'ruanganasal_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                </div>
            </div>
             <div class="control-group ">
                <?php  echo CHtml::label('Diagnosa Masuk RS', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'diagnosamasukrs', array('class' => 'span3', 'style'=>'width:300px; height:100px')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php  echo $form->labelEx($model, 'indikasidirawat', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'indikasidirawat', array('class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'tanggal_transfer', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'tanggal_transfer',
                        'mode'=>'datetime',
                        'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php  echo $form->labelEx($model, 'waktu_transfer', array('class' => 'control-label')) ?>
                <div class="controls">
                      <?php
                      $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                          'attribute'=>'waktu_transfer',
                            'mode'=>'time',

                            'options'=> array(
                                    'showOn' => false,
                            ),
                            'htmlOptions'=>array(
                        'readonly'=>TRUE,
                        'class'=>'span2',
                        'placeholder'=>'00:00:00',
                        'onkeyup'=>"return $(this).focusNextInputField(event),",
                            ),
                          ));
                      ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php  echo $form->labelEx($model, 'instalasitujuan_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'instalasitujuan_id', CHtml::listData(RuangantransferpasienV::model()->findAll(), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                        'ajax' => array('type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
                            'update' => '#' . CHtml::activeId($model, 'ruangantujuan_id') . ''),));
                    ?>
                 </div>
             </div>

            <div class="control-group ">
                   <?php  echo $form->labelEx($model, 'ruangantujuan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->dropDownList($model, 'ruangantujuan_id', CHtml::listData(RuangantransferpasienV::model()->findAllByAttributes(array('instalasi_id'=>$model->instalasitujuan_id)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
             </div>
            <div class="control-group ">
                <?php  echo $form->labelEx($model, 'alasanditransfer', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'alasanditransfer', array('class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php  echo $form->labelEx($model, 'kebutuhanpelayanan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'kebutuhanpelayanan', array('class' => 'span3')); ?>
                </div>
            </div>
        </div>
    </div>

    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
    'id'=>'form-ringkasanriwayatpasien',
    'content'=>array(
        'content-ringkasanriwayatpasien'=>array(
            'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Ringkasan Riwayat Pasien')).' <b>I. Ringkasan Riwayat Pasien</b>',
            'isi'=>$this->renderPartial($this->path_view.'_formRingkasanRiwayatPasien',array(
                'form'=>$form,
                'model'=>$model,
            ),true),
            'active'=>true,
    )))); ?>
    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
    'id'=>'form-ringkasanriwayatpasienII',
    'content'=>array(
        'content-ringkasanriwayatpasienII'=>array(
            'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Tindakan Medis yang Sudah Dilakukan')).' <b>II. Ringkasan Riwayat Pasien</b>',
            'isi'=>$this->renderPartial($this->path_view.'_formRingkasanRiwayatPasien2',array(
                'form'=>$form,
                'model'=>$model,
                'modTindakans'=>$modTindakans,
            ),true),
            'active'=>true,
    )))); ?>
    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
    'id'=>'form-tindakanmedis',
    'content'=>array(
        'content-tindakanmedis'=>array(
            'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Tindakan Medis yang Sudah Dilakukan')).' <b>III. Tindakan Medis yang Sudah Dilakukan</b>',
            'isi'=>$this->renderPartial($this->path_view.'_formTindakanMedis',array(
                'form'=>$form,
                'model'=>$model,
                'modTindakans'=>$modTindakans,
            ),true),
            'active'=>true,
    )))); ?>

    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
    'id'=>'form-pemberiterapi',
    'content'=>array(
        'content-pemberiterapi'=>array(
            'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Pemberian Terapi')).' <b>IV. Pemberian Terapi</b>',
            'isi'=>$this->renderPartial($this->path_view.'_formPemberiTerapi',array(
                'form'=>$form,
                'model'=>$model,
                'modRiwayatResep'=>$modRiwayatResep,
                'modRiwayatResepBHP'=>$modRiwayatResepBHP,
            ),true),
            'active'=>true,
    )))); ?>

    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
    'id'=>'form-lain',
    'content'=>array(
        'content-lain'=>array(
            'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Lain-lain')).' <b>V. Lain-Lain</b>',
            'isi'=>$this->renderPartial($this->path_view.'_formLiannya',array(
                'form'=>$form,
                'model'=>$model,
            ),true),
            'active'=>true,
    )))); ?>
    <br /><br />
<table width="100%">
	<tr>
            <td style="width:70%; text-align: left;" colspan="2">
            </td>
            <td style="width:30%; text-align: left;" colspan="2" >
        <center><strong style="color: black;">Dokter Pengirim</strong><span class="required">*</span>
                    <br><br><br><br><br><br>
                    <?php echo $form->dropDownList($model, 'dokterpengirim_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState("ruangan_id")),array('order'=>'nama_pegawai')), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3 required')); ?>
                </center>
            </td>
	</tr>
</table>
    <div class="row-fluid">
	<div class="form-actions">
            <?php
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); //RND-8620
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                        $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']),
                        array('class'=>'btn btn-danger',
                            'onclick'=>'return refreshForm(this);'));
            ?>
	</div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailresep',
    'options'=>array(
        'title'=>'Detail Reseptur',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailResep"></div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
