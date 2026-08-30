<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
        'id'=>'sajeniskasus-penyakit-m-search'
)); ?>

<div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model,'jeniskasuspenyakit_nama',array('placeholder' => 'Nama Kasus Penyakit', 'class'=>'span3 hurufs-only form-control','maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'jeniskasuspenyakit_namalainnya',array('placeholder' => 'Nama Lainnya', 'class'=>'span3  hurufs-only form-control','maxlength'=>50)); ?>

        </div>
        <div class="col-sm-6">
        <div class="control-group">
                    <?php echo CHtml::label("Ruangan", 'ruangan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true), array('order' => 'ruangan_nama')), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'ruangan_id span4', 'maxlength' => 50)); ?>
                    </div>
                </div>
            <div class="control-group">
				<?php echo CHtml::label("",'jeniskasuspenyakit_aktif', array('class'=>'control-label')) ?>
				  <div class="controls">
						<?php echo $form->checkBox($model,'jeniskasuspenyakit_aktif',array('checked'=>'checked')); ?> <label>Aktif</label>
				  </div>
		  </div>
        </div>
    </div>
  

<?php //echo $form->textFieldRow($model,'jeniskasuspenyakit_id',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
</div>

<?php $this->endWidget(); ?>

<script>

    $(document).ready(function () {

        multi();
    });

function multi() {

    var ruangan_id = jQuery('.ruangan_id');

    jQuery(ruangan_id).multiselect({
        includeSelectAllOption: true,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '240px',
        enableCaseInsensitiveFiltering: true,
    }).hide();

}

</script>
