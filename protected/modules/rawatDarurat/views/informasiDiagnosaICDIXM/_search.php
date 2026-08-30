<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'sadiagnosa-icdixm-search',
    'type'=>'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'diagnosaicdix_kode'),
)); ?>
<?php //echo $form->textFieldRow($model,'diagnosaicdix_id',array('class'=>'span5')); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label for="SADiagnosaICDIXM_diagnosaicdix_kode" class="control-label">Kode Diagnosa</label>
            <div class="controls">
                <?php echo $form->textField($model,'diagnosaicdix_kode',array('class'=>'span3 angkadot-only','maxlength'=>10, 'placeholder'=>'Kode Diagnosa')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label for="SADiagnosaICDIXM_diagnosaicdix_nama" class="control-label">Nama Diagnosa</label>
            <div class="controls">
                <?php echo $form->textField($model,'diagnosaicdix_nama',array('class'=>'span3 custom-only','maxlength'=>50, 'placeholder'=>'Nama Diagnosa')); ?>
            </div>
        </div>
    </div>
</div>

<?php //cho $form->textFieldRow($model,'diagnosaicdix_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>

<?php //echo $form->textFieldRow($model,'diagnosatindakan_katakunci',array('class'=>'span5','maxlength'=>50)); ?>

<?php //echo $form->textFieldRow($model,'diagnosaicdix_nourut',array('class'=>'span5')); ?>

<?php //echo $form->checkBoxRow($model,'diagnosaicdix_aktif',array('checked'=>'diagnosaicdix_aktif')); ?>

<?php $this->endWidget(); ?>
