<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'klonloginpemakai-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Asli</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'jenispemakai', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('jenispemakai', empty($nama->nama_pasien) ? 'Pegawai' : 'Pasien', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readOnly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'nama_pegawai', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('nama_pegawai', empty($nama->nama_pasien) ? (empty($nama) ? "" : $nama->nama_pegawai) : $nama->nama_pasien, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readOnly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'nama_pemakai', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('nama_pemakai', $model->nama_pemakai, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readOnly' => true)); ?>
            </div>
        </div>

    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Klon</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $form->textFieldRow($models, 'jenispemakai', array('value' => empty($nama->nama_pasien) ? 'Pegawai' : 'Pasien', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'pilihPemakai(this);', 'class' => 'span3',  'readOnly' => true)); ?>
        <?php echo $form->textFieldRow($models, 'nama_pegawai', array('value' =>  empty($nama->nama_pasien) ? (empty($nama) ? "" : $nama->nama_pegawai) : $nama->nama_pasien, 'onblur' => 'nospaces(this);', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 20, 'onkeyup' => "return $(this).focusNextInputField(event)", 'readOnly' => true)); ?>
        <?php echo $form->textFieldRow($models, 'nama_pemakai', array('value' => $model->nama_pemakai . "_clone", 'onblur' => 'nospaces(this);', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 20, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->passwordFieldRow($models, 'new_password', array('onblur' => 'nospaces(this);', 'placeholder' => 'Kata Kunci Baru', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 20, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>



<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'submitButton')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'name' => 'btn_batal', 'onclick' => 'close_dialog()')
    ); ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function close_dialog() {
        window.top.location.href = '<?php echo Yii::app()->createUrl('sistemAdministrator/loginpemakaiK/admin'); ?>';
    }
</script>