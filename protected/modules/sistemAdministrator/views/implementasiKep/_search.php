<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'implementasi-k-search',
    'type' => 'horizontal',
        ));
?>
<style>
    .form-horizontal .control-label{
        width: 200px !important;
    }
</style>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Intervensi Keperawatan', 'diagnosakep_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenisintervensi_id', Chtml::listData(JenisintervensiM::model()->findAll("jenisintervensi_aktif = TRUE ORDER BY jenisintervensi_nama ASC"), 'jenisintervensi_id', 'jenisintervensi_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('Jenis Tindakan Intervensi', 'diagnosakep_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                    <?php echo $form->dropDownList($model, 'jenistindakan', LookupM::getItems('jenistindakanintervensi'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Indikator Implementasi Keperawatan', 'indikatorimplkepdet_indikator', array('class' => 'control-label')) ?>
            <div class="controls">

                <?php echo $form->textField($model, 'indikatorimplkepdet_indikator', array('placeholder' => 'Indikator', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'indikatorimplkepdet_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'indikatorimplkepdet_aktif', array('rel' => 'tooltip', 'title' => 'Klik untuk mengaktifkan / menonaktifkan status', 'checked' => 'indikatorimplkepdet_aktif')); ?> <label>Aktif</label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('implementasikepM/admin'), array('class' => 'btn btn-danger', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>
