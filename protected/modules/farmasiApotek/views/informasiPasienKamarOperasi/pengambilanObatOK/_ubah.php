<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rjreseptur-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
             'class'=>'form-iframe'
                             ),
)); 
$this->widget('bootstrap.widgets.BootAlert');

?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Resep</div>
    </div>
    <div class="panel-body">
        <div class="col-sm-12">

            <div class="control-group">
                <label for="" class="control-label">Tanggal Resep</label>
                <div class="controls">
                    <?php echo $form->textField($modResepturDetail, 'create_time', ['readonly' => true]) ?>
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Nama Obat</label>
                <div class="controls">
                    <?php echo $form->textField($modResepturDetail, 'obatalkes_nama', ['readonly' => true]) ?>
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">No Resep</label>
                <div class="controls">
                    <?php echo $form->textField($modResepturDetail, 'noresep_ok', ['readonly' => true]) ?>
                </div>
            </div>
           
            <div class="control-group">
                <label for="" class="control-label">Jumlah</label>
                <div class="controls">
                    <?php echo $form->textField($modResepturDetail, 'jumlah') ?>
                </div>
            </div>
        </div>
        
        <div class="form-action">
            <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Edit',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit','id'=>'btn_submit')); //formSubmit(this,event)
            ?>
        </div>
    </div>
</div>
    
<?php $this->endWidget(); ?>