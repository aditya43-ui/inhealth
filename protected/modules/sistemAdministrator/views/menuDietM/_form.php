<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'samenudiet-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'jenisdiet_id'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onClick' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<table style="width:410px">
    <tr>
        <td colspan="2">
            <?php // echo $form->textFieldRow($model,'jenisdiet_id'); 
            ?>
            <?php echo $form->dropDownListRow(
                $model,
                'jenisdiet_id',
                CHtml::listData($model->JenisdietItems, 'jenisdiet_id', 'jenisdiet_nama'),
                array(
                    'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onClick' => "return $(this).focusNextInputField(event);",
                    'empty' => '-- Pilih --',
                )
            ); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->textFieldRow($model, 'menudiet_nama', array('size' => 60, 'maxlength' => 200, 'onKeyPress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'namaLain(this)')); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->textFieldRow($model, 'menudiet_namalain', array('size' => 60, 'maxlength' => 200, 'onKeyPress' => "return $(this).focusNextInputField(event);")); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'jml_porsi', array('class' => 'span1', 'onKeyPress' => "return $(this).focusNextInputField(event);")); ?>
        </td>
        <td>
            <?php echo $form->dropDownList(
                $model,
                'ukuranrumahtangga',
                CHtml::listData($model->URTItems, 'lookup_name', 'lookup_value'),
                array(
                    'class' => 'inputRequire span2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --',
                )
            ); ?>
        </td>
    </tr>
</table>
<fieldset>
    <div id="divZatgizi">
        <span class="help-block">Kandungan Menu Diet :</span>
        <table id="tblinputZatgizi">
            <tbody>
                <?php
                $datas = ZatgiziM::model()->findAll();
                $returnVal = array();
                $tr = '';
                //							  $inputHiddenZatgizi = '<input type="hidden" size="4" name="zatgizi_id[]" readonly="true"/>';
                /* $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered span3" style="width:500px;"><th> Pilih Semua <br>'.CHtml::checkBox('checkUncheck', false, array('onclick'=>'checkUncheckAll(this);')).'</th>
                                                  <th>Nama Zatgizi</th><th>'.$inputHiddenZatgizi.'Kandungan</th>'; */
                $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered span1" style="width:400px; float:left;"><th> Pilih </th>
                                                  <th>Nama Zatgizi</th><th>Kandungan</th>';
                foreach ($datas as $data) {
                    $tr .= "<tr><td>";
                    $tr .= CHtml::checkBox('zatgizi_id[]', false, array('value' => $data->getAttribute('zatgizi_id')));
                    $tr .= '</td><td>' . $data->getAttribute('zatgizi_nama');
                    $tr .= '</td><td>' . CHtml::textField("kandunganmenudiet[$data->zatgizi_id]", '0', array('size' => 6, 'class' => 'default'));
                    $tr .= "</td></tr>";
                }
                $returnVal .= $tr;
                $returnVal .= '</table>';
                echo $returnVal;
                ?>
            </tbody>
        </table>
    </div>
</fieldset>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/menuDietM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Menu Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/sistemAdministrator/MenuDietM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('MenuDietM_menudiet_namalain').value = nama.value.toUpperCase();
    }
</script>