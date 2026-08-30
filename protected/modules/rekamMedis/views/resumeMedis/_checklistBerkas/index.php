<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><b> FORM PENGECEKAN KELENGKAPAN BERKAS DOKUMEN PASIEN</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
				'id'=>'checklist-berkas-form',
				'enableAjaxValidation'=>false,
				'type'=>'horizontal',
				'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
				'focus'=>'#no_pendaftaran',
		)); ?>

        <div class="panel-body" id="form-datakunjungan">
            <div class="row-fluid">
                <?php $this->renderPartial($this->path_view . '_checklistBerkas._formDataPasien', array('modPendaftaran' => $modPendaftaran));?>
            </div>
            <div class="row-fluid">
                <?php $this->renderPartial($this->path_view . '_checklistBerkas._riwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayat' => $modRiwayat));?>
            </div>
            <div class="row-fluid">
                <?php $this->renderPartial($this->path_view . '_checklistBerkas._formKelengkapan', array('modPendaftaran' => $modPendaftaran, 'model' => $model, 'form' => $form));?>
            </div>
            <div class="row-fluid">
                <div class="form-actions">
                    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<script>

function printChecklist(pendaftaran_id, kelengkapandokumen_id) {

    window.open('<?php echo $this->createUrl('printChecklistBerkas'); ?>&pendaftaran_id=' + pendaftaran_id + '&id=' + kelengkapandokumen_id, 'printwin',
        'left=100,top=100,width=1400,height=1000');

}

</script>