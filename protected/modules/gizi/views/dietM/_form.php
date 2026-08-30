<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gzdiet-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#DietM_tipediet_id',
));
?>
<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->errorSummary($model); ?>

        <?php /* echo $form->textField($model,'tipediet_id'); */ ?>
        <?php
        echo $form->dropDownListRow($model, 'tipediet_id', CHtml::listData($model->TipeDietItems, 'tipediet_id', 'tipediet_nama'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
        ?>

        <?php /* echo $form->textField($model,'zatgizi_id'); */ ?>
        <?php /* echo $form->dropDownListRow($model,'zatgizi_id',
          CHtml::listData($model->ZatgiziItems, 'zatgizi_id', 'zatgizi_nama'),
          array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
          'empty'=>'-- Pilih --',)); */ ?>

        <?php /* echo $form->textField($model,'jenisdiet_id'); */ ?>
        <?php
        echo $form->dropDownListRow($model, 'jenisdiet_id', CHtml::listData($model->JenisdietItems, 'jenisdiet_id', 'jenisdiet_nama'), array(
            'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'empty' => '-- Pilih --',
        ));
        ?>

        <?php /* echo $form->textFieldRow($model,'diet_kandungan'); */ ?>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Zat Gizi</b></div>
            </div>
            <div class="panel-body table-responsive">
                <div id="divZatgizi">
                    <?php
                    $datas = ZatgiziM::model()->findAll(array(
                        'order' => 'zatgizi_nama',
                    ));
                    $returnVal = array();
                    $tr = '';
                    $inputHiddenZatgizi = '<input type="hidden" size="4" name="zatgizi[]" readonly="true"/>';
                    /* $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered span3" style="width:500px;"><th> Pilih Semua <br>'.CHtml::checkBox('checkUncheck', false, array('onclick'=>'checkUncheckAll(this);')).'</th>
              <th>Nama Zatgizi</th><th>'.$inputHiddenZatgizi.'Kandungan</th>'; */
                    $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered table-striped" style="width:400px;">
                                <th> Pilih </th>
                                <th>Nama Zatgizi</th>
                                <th>' . $inputHiddenZatgizi . 'Kandungan</th>';
                    foreach ($datas as $data) {
                        $tr .= "<tr><td>";
                        $tr .= CHtml::checkBox('zatgizi_id[]', false, array('value' => $data->getAttribute('zatgizi_id')));
                        $tr .= '</td><td width="100%">' . $data->getAttribute('zatgizi_nama');
                        $tr .= '</td><td nowrap>' . CHtml::textField("diet_kandungan[$data->zatgizi_id]", '0,00', array('size' => 6, 'class' => 'default float2 span1', 'style' => 'text-align: right'));
                        $tr .= ' ' . $data->zatgizi_satuan;
                        $tr .= "</td></tr>";
                    }
                    $returnVal .= $tr;
                    $returnVal .= '</table>';
                    echo $returnVal;
                    ?>
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
        Yii::app()->createUrl($this->module->id . '/dietM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('dietM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php
$this->endWidget();
$jscript = <<< JSCRIPT

function checkUncheckAll(obj)
{
    var check = obj.checked;
    $('#tblinputzatgizi tr:not(:first)').each(function(){
       $(this).find("input[name='zatgizi_id[]']").each(function(){
            if(!check)
                $(this).attr('checked',false);
            else
                $(this).attr('checked',true);
        });
    });
}

JSCRIPT;
?>

</div><!--form-->