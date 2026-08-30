<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sabahanmakanan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
        ));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php // echo $form->textFieldRow($model,'jenisbahanmakanan',array('size'=>50,'maxlength'=>50)); ?>
            <?php
            echo $form->dropDownListRow($model, 'jenisbahanmakanan', LookupM::getItems('jenisbahanmakanan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'inputRequire span3'));
            ?>

            <?php // echo $form->textFieldRow($model,'kelbahanmakanan',array('size'=>50,'maxlength'=>50)); ?>
            <?php
            echo $form->dropDownListRow($model, 'kelbahanmakanan', LookupM::getItems('kelompokbahanmakanan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'inputRequire span3'));
            ?>

            <?php echo $form->textFieldRow($model, 'namabahanmakanan', array('size' => 60, 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($model, 'jmlpersediaan', array('class' => 'span2')); ?>

            <?php
            echo $form->dropDownListRow($model, 'jmldlmkemasan', LookupM::getItems('jmldlmkemasan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'inputRequire span3'));
            ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'jmlminimal', array('class' => 'span2')); ?>
            <?php // echo $form->textFieldRow($model,'sumberdanabhn',array('size'=>50,'maxlength'=>50)); ?>
            <?php
            echo $form->dropDownListRow($model, 'sumberdanabhn', LookupM::getItems('sumberdanabahan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'inputRequire span3'));
            ?>
            <?php echo $form->textFieldRow($model, 'harganettobahan', array('class' => 'span2')); ?>
            <?php echo $form->textFieldRow($model, 'hargajualbahan', array('class' => 'span2')); ?>
        </td>
        <td>
            <div class="control-group">
                <?php // echo $form->textFieldRow($model,'tglkadaluarsabahan'); ?>
                <?php echo $form->labelEx($model, 'tglkadaluarsabahan', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglkadaluarsabahan',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array('readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3 dtPicker3',
                        ),
                    ));
                    ?> 
                </div>
            </div>
            <?php // echo $form->textFieldRow($model,'golbahanmakanan_id'); ?>
            <?php
            echo $form->dropDownListRow($model, 'golbahanmakanan_id', CHtml::listData($model->GolBahanMakananItems, 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
            ?>
            <?php // echo $form->textFieldRow($model,'satuanbahan',array('size'=>50,'maxlength'=>50)); ?>
            <?php
            echo $form->dropDownListRow($model, 'satuanbahan', LookupM::getItems('satuanbahanmakanan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'inputRequire span3'));
            ?>
            <?php echo $form->textFieldRow($model, 'discount', array('class' => 'span1')); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <hr>
            <span class="help-block">Zat Gizi Bahan Makanan :</span>
            <fieldset>
                <div id="divZatgizi">
                    <?php
                    $criteria = new CDbCriteria();
                    $criteria->compare('zatgizi_aktif', true);
                    $datas = ZatgiziM::model()->findAll($criteria);
                    $returnVal = array();
                    $tr = '';
                    $inputHiddenZatgizi = '<input type="hidden" size="4" name="zatgizi_id[]" readonly="true"/>';
                    /* $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered span3" style="width:500px;"><th> Pilih Semua <br>'.CHtml::checkBox('checkUncheck', false, array('onclick'=>'checkUncheckAll(this);')).'</th>
                      <th>Nama Zatgizi</th><th>'.$inputHiddenZatgizi.'Kandungan</th>'; */
                    $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered span1" style="width:400px; float:left;"><th> Pilih </th>
                                            <th>Nama Zatgizi</th><th>' . $inputHiddenZatgizi . 'Kandungan</th>';
                    foreach ($datas as $data) {
                        $tr .= "<tr><td>";
                        $tr .= CHtml::checkBox('zatgizi_id[]', false, array('value' => $data->getAttribute('zatgizi_id')));
                        $tr .= '</td><td>' . $data->getAttribute('zatgizi_nama');
                        $tr .= '</td><td>' . CHtml::textField("kandunganbahan[$data->zatgizi_id]", '0', array('size' => 6, 'class' => 'default'));
                        $tr .= "</td></tr>";
                    }
                    $returnVal .= $tr;
                    $returnVal .= '</table>';
                    echo $returnVal;
                    ?>
                </div>
            </fieldset>
            <div class="form-actions">
                <?php
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Bahan Makanan', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
                $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>
            </div>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>