<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'samenu-modul-k-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'modul_id', CHtml::listData($model->getModulItems(), 'modul_id', 'modul_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->dropDownListRow($model, 'kelmenu_id', CHtml::listData($model->getKelompokMenuItems(), 'kelmenu_id', 'kelmenu_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'menu_nama', array('placeholder' => 'Menu', 'class' => 'span3', 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'menu_fungsi', array('placeholder' => 'Fungsi', 'class' => 'span4', 'cols' => 10, 'rows' => 2)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'menu_icon', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'menu_icon', array()); ?>
                <label for="SAMenuModulK_menu_icon">Hanya tampilkan yang belum memiliki icon</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'menu_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'menu_aktif', array('checked' => 'menu_aktif')); ?>
                <label for="SAMenuModulK_menu_aktif">Aktif</label>
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