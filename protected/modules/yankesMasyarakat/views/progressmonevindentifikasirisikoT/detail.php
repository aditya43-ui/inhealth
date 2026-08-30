<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'penelitian-t-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event);'),
    'focus'=>'#',
)); ?>
<?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><b>Risk Register</b></div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <?php echo CHtml::label('Sumber', 'sumber_riskregister', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'sumber_riskregister', LookupM::getItems("sumber_riskregister"), array('class'=>'span3','empty'=>'-- Pilih --','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Deskripsi Risiko', 'riskregister_deskripsiresiko', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'riskregister_deskripsiresiko',array('class'=>'span3','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Penyebab', 'riskregister_penyebab', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'riskregister_penyebab',array('class'=>'span3','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tipe / Area Risiko', 'tiperesiko_id', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'tiperesiko_id',Chtml::listData(TiperesikoM::model()->findAllByAttributes(array('tiperesiko_aktif'=>true)),'tiperesiko_id','tiperesiko_nama'),array('class'=>'span3','empty'=>'-- Pilih --','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Existing Control', 'penelitian_nomor', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model,'riskregister_deskripsiresiko',array('class'=>'span3','disabled'=>true)); ?>
                    </div>
                </div>

            </div>
            <div class="span6">
                <div class="control-group">
                    <?php echo CHtml::label('Konsekuensi', 'penelitian_nomor', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model,'konsekuensi_skor',array('class'=>'span3','value'=>!empty($model->konsekuensi_skor)? $model->konsekuensi_skor : 0)); ?>
                        <?php echo $form->dropDownList($model,'konsekuensi_id', RiskregisterM::getDropDownKonsekuensi(), array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihKonsekuensi(this);loadTingkatRisiko();return false;','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Peluang', 'penelitian_nomor', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model,'peluang_skor',array('class'=>'span3','value'=>!empty($model->peluang_skor)? $model->peluang_skor : 0)); ?>
                        <?php echo $form->dropDownList($model,'peluang_id', RiskregisterM::getDropDownPeluang(), array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihPeluang(this);loadTingkatRisiko();return false;','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Detectability', 'penelitian_nomor', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model,'detectability_skor',array('class'=>'span3','value'=>!empty($model->detectability_skor)? $model->detectability_skor : 0)); ?>
                        <?php echo $form->dropDownList($model,'detectability_id', RiskregisterM::getDropDownDetectability(), array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihDetectability(this);return false;','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('RPN', 'riskregister_rpn', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'riskregister_rpn',array('class'=>'span3','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Target RPN', 'riskregister_targetrpn', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'riskregister_targetrpn',array('class'=>'span3 numbers-only','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tingkat Risiko', 'tingkatrisiko_nama', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'tingkatrisiko_nama',array('class'=>'span3','disabled'=>true)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><b>Risk Register</b></div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="span6">
                <h6>&nbsp;</h6>
                <div class="control-group">
                    <?php echo CHtml::label('Evaluasi Risiko', 'evaluasi_risiko', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'evaluasi_risiko', LookupM::getItems("evaluasi_risiko"), array('class'=>'span3','empty'=>'-- Pilih --','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Penanggungjawab Risiko', 'jabatan_id', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'penanggungjawab',array('class'=>'span3','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tanggal Mulai', 'riskregister_tanggalmulai', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php   
                            $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'riskregister_tanggalmulai',
                                    'mode'=>'date',
                                    'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'changeYear' => false,
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker2 span3','onkeyup' => "return $(this).focusNextInputField(event)",'disabled'=>true),

                    )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tanggal Tinjauan', 'riskregister_tanggaltinjauan', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php   
                            $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'riskregister_tanggaltinjauan',
                                    'mode'=>'date',
                                    'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'changeYear' => false,
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker2 span3','onkeyup' => "return $(this).focusNextInputField(event)",'disabled'=>true),

                    )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Risk Response and Action Plan <span class="required">*</span>', 'riskregister_riskresponse', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model,'riskregister_riskresponse',array('class'=>'span3 required','disabled'=>true)); ?>
                    </div>
                </div>

            </div>
            <div class="span6">
                <h6><b>Progress-Laporan Monev</b></h6>
                <div class="control-group">
                    <?php echo CHtml::label('Konsekuensi', 'konsekuensi_rpnsisa_id', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model,'konsekuensi_skor_rpnsisa',array('class'=>'span3','value'=>!empty($model->konsekuensi_skor_rpnsisa)? $model->konsekuensi_skor_rpnsisa : 0)); ?>
                        <?php echo $form->dropDownList($model,'konsekuensi_rpnsisa_id', RiskregisterM::getDropDownKonsekuensi(), array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihKonsekuensiSisa(this);return false;','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Peluang', 'peluang_rpnsisa_id', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model,'peluang_skor_rpnsisa',array('class'=>'span3','value'=>!empty($model->peluang_skor_rpnsisa)? $model->peluang_skor_rpnsisa : 0)); ?>
                        <?php echo $form->dropDownList($model,'peluang_rpnsisa_id', RiskregisterM::getDropDownPeluang(), array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihPeluangSisa(this);return false;','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Detectability', 'detectability_rpnsisa_id', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model,'detectability_skor_rpnsisa',array('class'=>'span3','value'=>!empty($model->detectability_skor_rpnsisa)? $model->detectability_skor_rpnsisa : 0)); ?>
                        <?php echo $form->dropDownList($model,'detectability_rpnsisa_id', RiskregisterM::getDropDownDetectability(), array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihDetectabilitySisa(this);return false;','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('RPN Sisa', 'riskregister_rpnsisa', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'riskregister_rpnsisa',array('class'=>'span3','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Laporan Singkat', 'laporansingkat', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model,'laporansingkat',array('class'=>'span3','disabled'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Status', 'status_riskregister', array('class' => 'control-label ')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'status_riskregister', LookupM::getItems("status_riskregister"), array('class'=>'span3','empty'=>'-- Pilih --','disabled'=>true)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>