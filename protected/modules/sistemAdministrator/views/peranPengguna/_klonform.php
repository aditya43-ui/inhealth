<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'klon-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<div class="row">
    <?php
    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <fieldset class="box" id="form-pasien">
        <legend class="rim">Data Asli
            <span class='tombol' style='display:none;'></span>
        </legend>
        <table>
            <tr>
                <td style="width: 140px;"><?php echo CHtml::activeLabel($model, 'peranpenggunanama'); ?></td>
                <td><?php echo CHtml::textField('peranpenggunanama', $model->peranpenggunanama, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readOnly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($model, 'peranpenggunanamalain'); ?></td>
                <td> <?php echo CHtml::textField('peranpenggunanamalain', $model->peranpenggunanamalain, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readOnly' => true)); ?> </td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="box" id="form-pasien">
        <legend class="rim">Data Klon
            <span class='tombol' style='display:none;'></span>
        </legend>
        <?php echo $form->textFieldRow($models, 'peranpenggunanama', array('class' => 'span3', 'value' => $model->peranpenggunanama . "_clone", 'onkeyup' => "namaLain(this); return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($models, 'peranpenggunanamalain', array('class' => 'span3', 'value' => $model->peranpenggunanamalain . "_CLONE", 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    </fieldset>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')),
            array('class' => 'btn btn-default', 'type' => 'button', 'name' => 'btn_batal', 'onclick' => 'close_dialog()')
        ); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAPeranpenggunaK_peranpenggunanamalain').value = nama.value.toUpperCase();
    }

    function close_dialog() {
        window.top.location.href = '<?php echo Yii::app()->createUrl('sistemAdministrator/peranPengguna/admin'); ?>';
    }
</script>