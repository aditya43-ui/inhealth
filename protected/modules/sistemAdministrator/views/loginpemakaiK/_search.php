<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'loginpemakai-m-search',
)); ?>
<table width='100%'>
    <tr>
        <td>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'nama_pemakai', array('placeholder' => 'Username', 'class' => 'span3', 'maxlength' => 20)); ?>
            </div>
            <div class="control-group">
            <?php echo CHtml::label('Nama Pemakai', 'nama_pegawai', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span3')); ?>
            <div>
            <?php echo $form->checkBox($model, 'is_ppds', array('id' => 'is_ppds')); ?>
            <label>PPDS</label>
            </div>
            </div>
        </div>
       
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'katakunci_pemakai', array('placeholder' => 'Kata kunci', 'class' => 'span3', 'maxlength' => 200)); ?>
                <div class="control-group">
                    <?php echo CHtml::label("", 'loginpemakai_aktif', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($model, 'loginpemakai_aktif', array('checked' => 'loginpemakai_aktif')); ?>
                        <label for="LoginpemakaiK_loginpemakai_aktif">Aktif</label>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>
<?php //echo $form->textFieldRow($model,'loginpemakai_id',array('class'=>'span5')); 
?>

<?php //echo $form->textFieldRow($model,'lastlogin',array('class'=>'span2')); 
?>

<?php //echo $form->textFieldRow($model,'tglpembuatanlogin',array('class'=>'span5')); 
?>

<?php //echo $form->textFieldRow($model,'tglupdatelogin',array('class'=>'span5')); 
?>

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