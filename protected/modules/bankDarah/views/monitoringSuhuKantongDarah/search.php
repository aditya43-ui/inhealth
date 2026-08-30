<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'monitoringsuhu-v-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'no_kirimkantong'),
        ));
?>

<div class="col-sm-6"> 
    <div class="control-group">		
        <?php echo CHtml::label("Tanggal Monitoring", 'tglmonitoring', array('class' => 'control-label')) ?>
        <div class="controls">
            <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                <i class="entypo-calendar"></i>
                <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
            </div>
        </div>
    </div>
    <div class = "control-group">
        <?php echo Chtml::label("Nomor Penggunaan Coolbox", 'no_penggunaan_coolbox', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->textField($model, 'no_penggunaan_coolbox', array('placeholder' => 'Ketik Nomor Penggunaan Coolbox', 'class' => 'span4', 'maxlength' => 50)); ?>        
        </div>
    </div>        
</div>    

<div class="col-sm-6">
    <div class = "control-group">
        <?php echo Chtml::label("Jenis Coolbox", 'coolboxdarah_id', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->dropDownList($model, 'coolboxdarah_id', CHtml::listData(CoolboxdarahM::model()->findAll(), 'coolboxdarah_id', 'coolboxdarah_nama'), array('empty' => '--Pilih--')); ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('MonitoringSuhuKantongDarah/informasi'), array('class' => 'btn btn-danger')); ?>
</div>

<?php $this->endWidget(); ?>
