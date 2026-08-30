<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gzbahanmakanan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this)'),
    'focus' => '#BahanmakananM_jenisbahanmakanan',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php
        echo $form->dropDownListRow($model, 'sumberdanabhn', CHtml::listData($model->SumberDanaItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'options' => array('Rumah Sakit' => array('selected' => true))));
        ?>
        <?php
        echo $form->dropDownListRow($model, 'golbahanmakanan_id', CHtml::listData($model->GolBahanMakananItems, 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
        ?>
        <?php // echo $form->textFieldRow($model,'jenisbahanmakanan',array('size'=>50,'maxlength'=>50)); 
        ?>
        <?php
        echo $form->dropDownListRow($model, 'jenisbahanmakanan', CHtml::listData($model->JenisBahanMakananItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
        ?>

        <?php // echo $form->textFieldRow($model,'kelbahanmakanan',array('size'=>50,'maxlength'=>50)); 
        ?>
        <?php
        echo $form->dropDownListRow($model, 'kelbahanmakanan', CHtml::listData($model->KelBahanMakananItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
        ?>

        <?php echo $form->textFieldRow($model, 'namabahanmakanan', array('class' => 'span3', 'placeholder' => 'Nama Bahan Makanan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'size' => 60, 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'ket_spesifikasibahanmakanan', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php
        echo $form->dropDownListRow($model, 'satuanbahan', CHtml::listData($model->SatuanBahanMakananItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
        ?>
        <?php echo $form->textFieldRow($model, 'jmlpersediaan', array('class' => "span1 numbers-only", 'style' => 'text-align: right;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php
        echo $form->dropDownListRow($model, 'jmldlmkemasan', CHtml::listData($model->JmlDlmKemasanItems, 'lookup_value', 'lookup_name'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
        ?>

        <?php echo $form->textFieldRow($model, 'jmlminimal', array('class' => "span1 numbers-only", 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'text-align: right;',)); ?>
        <?php // echo $form->textFieldRow($model,'sumberdanabhn',array('size'=>50,'maxlength'=>50)); 
        ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'harganettobahan', array('class' => "span2 integer2", 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'text-align: right;',)); ?>
        <?php echo $form->textFieldRow($model, 'hargajualbahan', array('class' => "span2 integer2", 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'text-align: right;',)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglkadaluarsabahan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglkadaluarsabahan',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => 'dd M yy',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span2 dtPicker3',
                    ),
                ));
                ?>
            </div>
        </div>
        <?php // echo $form->textFieldRow($model,'tglkadaluarsabahan');  
        ?>

        <?php // echo $form->textFieldRow($model,'golbahanmakanan_id'); 
        ?>

        <?php // echo $form->textFieldRow($model,'satuanbahan',array('size'=>50,'maxlength'=>50)); 
        ?>

        <?php echo $form->textFieldRow($model, 'discount', array('class' => "span2 numbers-only", 'style' => 'text-align: right;', 'onkeypress' => "return $(this).focusNextInputField(event)", 'value' => 0)); ?>
    </div>

    <div class="col-sm-6">

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Zat Gizi Bahan Makanan</b></div>
            </div>
            <div class="panel-body table-responsive">
                <div id="divZatgizi">
                    <!--<table id="tblinputZatgizi">
                        <tbody>-->
                    <?php
                    $criteria = new CDbCriteria();
                    $criteria->addCondition("zatgizi_aktif = true");
                    $criteria->order = "zatgizi_nama ASC";
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
                        $tr .= '</td><td width="100%">' . $data->getAttribute('zatgizi_nama');
                        $tr .= '</td><td nowrap>' . CHtml::textField("kandunganbahan[$data->zatgizi_id]", '0,00', array('class' => 'default span1 float2', 'style' => 'text-align: right;'));
                        $tr .= ' ' . $data->zatgizi_satuan;
                        $tr .= "</td></tr>";
                    }
                    $returnVal .= $tr;
                    $returnVal .= '</table>';
                    echo $returnVal;
                    ?>
                    <!--</tbody>
                                        </table>-->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/bahanMakananM/admin'),
        array('class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Bahan Makanan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('bahanMakananM/admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => 'frame')),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit4b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

</div>
<?php $this->endWidget(); ?>