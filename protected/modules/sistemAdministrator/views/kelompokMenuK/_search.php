<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sakelompok-menu-k-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kelmenu_nama', array('placeholder' => 'Kelompok Menu', 'class' => 'span3', 'maxlength' => 30)); ?>
        <?php echo $form->textFieldRow($model, 'kelmenu_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 30)); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("", 'kelmenu_icon', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kelmenu_icon', array()); ?>
                <label for="SAKelompokMenuK_kelmenu_icon">Hanya tampilkan yang belum memiliki icon</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'kelmenu_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kelmenu_aktif', array('checked' => 'kelmenu_aktif')); ?>
                <label for="SAKelompokMenuK_kelmenu_aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php //echo CHtml::label("", 'menu_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php //echo $form->checkBox($model, 'menu_aktif', array('checked' => 'menu_aktif')); ?>
                <!-- <label for="SAMenuModulK_menu_aktif">Aktif</label> -->
            </div>
        </div>
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