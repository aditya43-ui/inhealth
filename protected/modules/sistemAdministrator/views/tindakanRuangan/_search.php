<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'saruangan-m-search',
    'type' => 'horizontal',
)); ?>

<?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span5')); 
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow(
            $model,
            'kelompoktindakan_nama',
            Chtml::listData(KelompoktindakanM::model()->findAll("kelompoktindakan_aktif = TRUE ORDER BY kelompoktindakan_nama ASC"), 'kelompoktindakan_nama', 'kelompoktindakan_nama'),
            array(
                'empty' => '-- Pilih --',
                'class' => 'span3',
                'maxlength' => 50
            )
        ); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'komponenunit_nama',
            Chtml::listData(KomponenunitM::model()->findAll("komponenunit_aktif = TRUE ORDER BY komponenunit_nama ASC"), 'komponenunit_nama', 'komponenunit_nama'),
            array(
                'empty' => '-- Pilih --',
                'class' => 'span3',
                'maxlength' => 50
            )
        ); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'kategoritindakan_nama',
            Chtml::listData(KategoritindakanM::model()->findAll("kategoritindakan_aktif = TRUE ORDER BY kategoritindakan_nama ASC"), 'kategoritindakan_nama', 'kategoritindakan_nama'),
            array(
                'empty' => '-- Pilih --',
                'class' => 'span3',
                'maxlength' => 50
            )
        ); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow(
            $model,
            'daftartindakan_kode',
            array(
                'class' => 'span3',
                'maxlength' => 20,
                'placeholder' => 'Kode Tindakan',
            )
        ); ?>
        <?php echo $form->textFieldRow(
            $model,
            'daftartindakan_nama',
            array(
                'class' => 'span3',
                'maxlength' => 20,
                'placeholder' => 'Uraian Tindakan',
            )
        ); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array(
            'title' => 'Cari',
            'class' => 'btn btn-primary',
            'type' => 'submit',
        )
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