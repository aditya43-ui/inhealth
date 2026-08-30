<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'satabular-list-m-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'tabularlist_chapter', array('placeholder' => 'Chapter', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php //echo $form->textFieldRow($model,'tabularlist_id',array('class'=>'span5')); 
        ?>
        <?php echo $form->textFieldRow($model, 'tabularlist_block', array('placeholder' => 'Block', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'tabularlist_revisi', array('placeholder' => 'Revisi', 'class' => 'span3', 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'tabularlist_title', array('placeholder' => 'Title', 'rows' => 4, 'cols' => 35, 'class' => 'span3')); ?>
        <?php //echo $form->textFieldRow($model,'tabularlist_versi',array('class'=>'span5','maxlength'=>50)); 
        ?>
        <?php //echo $form->checkBoxRow($model,'tabularlist_aktif',array('checked'=>'tabularlist_aktif')); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'tabularlist_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'tabularlist_aktif', array('checked' => 'tabularlist_aktif')); ?> <label for="SATabularListM_tabularlist_aktif">Aktif</label>
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