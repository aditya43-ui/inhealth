<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'insiden-rs-t-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'focus'=>'#',
)); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Laporan Insiden </strong></div>
        <div class="panel-options">
            <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-green', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')); ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><b>Data Pasien </b></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <?php echo $this->renderPartial($this->path_detail.'/_dataPasien', array('model'=>$model, 'form'=>$form)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><b>Data Kejadian </b></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <?php echo $this->renderPartial($this->path_detail.'/_dataKejadian', array('model'=>$model, 'form'=>$form)); ?>
                </div>
            </div>
        </div>
        <?php 
         if(!empty($modGrading->gradinginsidenrs_id)){
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><b>Grading Resiko</b></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <?php echo $this->renderPartial($this->path_detail.'/_dataGradingResiko', array('modGrading'=>$modGrading, 'form'=>$form)); ?>
                </div>
            </div>
        </div>
        <?php
         }
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php 
    $this->renderPartial($this->path_detail.'/_jsFunctions', array('model' => $model));
?>