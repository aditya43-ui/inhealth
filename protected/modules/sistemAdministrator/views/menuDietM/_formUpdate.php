<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'samenudiet-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'jenisdiet_id'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<table>
    <tr>
        <td colspan="2">
            <?php // echo $form->textFieldRow($model,'jenisdiet_id'); 
            ?>
            <?php echo $form->dropDownListRow(
                $model,
                'jenisdiet_id',
                CHtml::listData($model->JenisdietItems, 'jenisdiet_id', 'jenisdiet_nama'),
                array(
                    'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --',
                )
            ); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->textFieldRow($model, 'menudiet_nama', array('size' => 60, 'maxlength' => 200)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->textFieldRow($model, 'menudiet_namalain', array('size' => 60, 'maxlength' => 200)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'jml_porsi'); ?>
        </td>
        <td>
            <?php echo $form->dropDownList(
                $model,
                'ukuranrumahtangga',
                CHtml::listData($model->URTItems, 'lookup_name', 'lookup_value'),
                array(
                    'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
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
                $datas = ZatMenuDietM::model()->findAll("menudiet_id='$model->menudiet_id' ORDER BY zatmenudiet_id");
                $returnVal = array();
                $tr = '';
                $inputHiddenZatgizi = '<input type="hidden" size="4" name="zatgizi_id[]" readonly="true"/>';
                /* $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered span3" style="width:500px;"><th> Pilih Semua <br>'.CHtml::checkBox('checkUncheck', false, array('onclick'=>'checkUncheckAll(this);')).'</th>
                                                    <th>Nama Zatgizi</th><th>'.$inputHiddenZatgizi.'Kandungan</th>'; */
                $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered span1" style="width:400px; float:left;"><th> Pilih </th>
                                                    <th>Nama Zatgizi</th><th>' . $inputHiddenZatgizi . 'Kandungan</th>';
                foreach ($datas as $data) {
                    $ZatgiziId = ZatgiziM::model()->findAll("zatgizi_id='$data->zatgizi_id' ORDER BY zatgizi_id");
                    if (!empty($zatgizi[$data->zatgizi_id])) {
                        $ceklis = true;
                        $kandungan = $data->kandunganmenudiet;
                    } else {
                        $ceklis = false;
                        $kandungan = 0;
                    }
                    foreach ($ZatgiziId as $ZatgiziNama) {
                        $tr .= "<tr><td>";
                        $tr .= CHtml::checkBox('zatmenudiet_id[]', $ceklis, array('value' => $data->getAttribute('zatmenudiet_id')));
                        $tr .= '</td><td>' . $ZatgiziNama->getAttribute('zatgizi_nama');
                        $tr .= '</td><td>' . CHtml::textField("kandunganmenudiet[$data->zatmenudiet_id]", $kandungan, array('size' => 6, 'class' => 'default'));
                        $tr .= "</td></tr>";
                    }
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
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)', 'onClick' => 'return formSubmit(this,event)')
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