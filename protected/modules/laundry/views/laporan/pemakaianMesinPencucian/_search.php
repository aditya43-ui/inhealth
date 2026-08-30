<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'laporanlogbookpemasukanlimbahb3-search',
        ));
?>
<div class="col-sm-6">
    <div class="control-group">		
        <?php echo CHtml::label("Tanggal Pemakaian", 'tgl_rekam', array('class' => 'control-label')) ?>
        <div class="controls">
            <div class="daterange daterange-inline add-ranges input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                <i class="entypo-calendar"></i>
                <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
            </div>
        </div>
    </div>
    <?= $form->dropDownListRow($model, 'mesinpencucian_nama', CHtml::listData(Yii::app()->db->createCommand(" SELECT mesinpencucian_id, mesinpencucian_nama FROM mesinpencucian_m WHERE mesinpencucian_aktif = TRUE ORDER BY mesinpencucian_nama ASC ")->queryAll(),'mesinpencucian_nama','mesinpencucian_nama'),['empty'=>'-- Pilih', 'class'=>'span3']) ?>
</div>
<div class="col-sm-6">
    <?= $form->dropDownListRow($model, 'bahanperawatan_nama', CHtml::listData(BahanperawatanM::model()->findAll(" bahanperawatan_aktif = TRUE ORDER BY bahanperawatan_nama ASC "), 'bahanperawatan_nama', 'bahanperawatan_nama'),['empty'=>'-- Pilih', 'class'=>'span3']) ?>    
</div>
<div class="actions clear">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
</div>
<?php $this->endWidget(); ?>
