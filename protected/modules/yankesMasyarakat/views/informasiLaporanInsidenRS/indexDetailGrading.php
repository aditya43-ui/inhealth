<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'gradinginsidenrs-t-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'focus'=>'#',
)); 
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Detail Laporan Insiden </b> </div>
        <div class="panel-options">
            <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-green', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')); ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="panel panel-success">
                <div class="panel panel-heading">
                    <div class="panel-title"> <b> I. Data Pasien </b></div>

                </div>
                <div class="panel-body">
                    <?php $this->renderPartial($this->path_view.'dataPasien', array('form' => $form, 'model' => $model, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel panel-heading">
                    <div class="panel-title"> <b> II. Insiden Rumah Sakit  </b></div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial($this->path_view.'detail', array('form' => $form, 'model' => $model)); ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel panel-heading">
                    <div class="panel-title"> <b> Grading Risiko </b> </div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial($this->path_view.'detailGrading', array('form' => $form, 'model' => $model, 'grading' => $grading))?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>