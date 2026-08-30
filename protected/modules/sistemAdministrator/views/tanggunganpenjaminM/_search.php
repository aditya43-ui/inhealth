<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    //'action'=>Yii::app()->createUrl($this->module->id . '/tanggunganpenjaminM/admin'), 
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sacara-bayar-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($modCaraBayar, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAllByAttributes(array('carabayar_aktif' => true)), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->dropDownListRow($modCaraBayar, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif' => true)), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($modCaraBayar, 'penjamin_id', CHtml::listData(PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif' => true)), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->checkBoxRow($modCaraBayar, 'tanggunganpenjamin_aktif', array('checked' => 'tanggunganpenjamin_aktif')); ?>
    </div>
</div>

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