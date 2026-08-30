<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gradingrisiko-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>
<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Formulir Laporan Insiden Kebakaran </b> </div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="panel panel-success">
                <div class="panel panel-heading">
                    <div class="panel-title"> <b> Data Pelaporan </b> </div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial($this->path_view.'/form/_1_dataPelaporan', array('model' => $model, 'form' => $form))?>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="panel panel-success">
                <div class="panel panel-heading">
                    <div class="panel-title"> <b> Data Kejadian </b> </div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial($this->path_view.'/form/_2_dataKejadian', array('model' => $model, 'form' => $form))?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->endWidget(); ?>