<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sadiagnosakeperawatan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#DiagnosakeperawatanM_diagnosa_keperawatan_aktif',
)); ?>
<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-12">
        <?php echo $form->textFieldRow($model, 'diagnosa_id', array('value' => $modDiagnosa->diagnosa_nama, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
        <?php echo $form->checkBoxRow($model, 'diagnosa_keperawatan_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-12" style="overflow-x: auto;max-width: 100%;">
        <table id="tbl-DiagnosaKeperawatan" class="table table-striped table-bordered table-condensed table-responsive table-striped table-condensed">
            <thead>
                <tr>
                    <th></th>
                    <th>Kode</th>
                    <th>Diagnosa Medis</th>
                    <th>Diagnosa Keperawatan</th>
                    <th>Diagnosa Tujuan</th>
                    <th>Kriteria Hasil</th>
                    <th>Tambah</th>
                </tr>
            </thead>
            <tbody>
                <?php $row = array();
                foreach ($modIdDiagnosa as $i => $DiagnosaId) { ?>
                    <tr>
                        <td>
                            <?php echo $form->hiddenField($DiagnosaId, "[$i]diagnosakeperawatan_id", array('value' => (isset($DiagnosaId->diagnosakeperawatan_id) ? $DiagnosaId->diagnosakeperawatan_id : ""))); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($DiagnosaId, "[$i]diagnosakeperawatan_kode", array('value' => (isset($DiagnosaId->diagnosakeperawatan_kode) ? $DiagnosaId->diagnosakeperawatan_kode : ""), 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($DiagnosaId, "[$i]diagnosa_medis", array('value' => (isset($row->diagnosakeperawatan_medis) ? $row->diagnosakeperawatan_medis : ""), 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($DiagnosaId, "[$i]diagnosa_keperawatan", array('value' => (isset($row->diagnosakeperawatan_keperawatan) ? $row->diagnosakeperawatan_keperawatan : ""), 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($DiagnosaId, "[$i]diagnosa_tujuan", array('value' => (isset($row->diagnosakeperawatan_tujuan) ? $row->diagnosakeperawatan_tujuan : ""), 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </td>

                        <?php //echo $form->checkBoxRow($model,'[1]lookup_aktif', array('onkeypress'=>"return nextFocus(this,event,'btn_simpan','LookupM_lookup_urutan')")); 
                        ?>
                        <td>
                            <?php //echo CHtml::activeTextField($modKriteriaHasil,'[1]kriteriahasil_nama',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                            ?>
                            <?php //echo $form->textField($model,'[1]kriteriahasil_id',CHtml::listData(KriteriahasilM::model()->findAllByAttributes($attributes), 'kriteriahasil_id', 'kriteriahasil_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)array('empty'=>'-- Pilih --')")); 
                            ?>
                        </td>
                        <td>
                            <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger', 'onclick' => 'addRow(this)', 'id' => 'row1-plus')); ?>
                        </td>
    </div>
</div>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Diagnosa Keperawatan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_views . '/tips/tipsaddedit2', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>

</div>

<?php $this->endWidget(); ?>
<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
$js = <<< JSCRIPT
function addRow(obj)
{
    var tr = $('#tbl-DiagnosaKeperawatan tbody tr:first').html();
    $('#tbl-DiagnosaKeperawatan tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-DiagnosaKeperawatan tr:last td:last').append('$buttonMinus');
        
        renameInput('RIDiagnosakeperawatanM','diagnosa_id');
        renameInput('RIDiagnosakeperawatanM','diagnosakeperawatan_id');
        renameInput('RIDiagnosakeperawatanM','diagnosakeperawatan_kode');
        renameInput('RIDiagnosakeperawatanM','diagnosa_medis');
        renameInput('RIDiagnosakeperawatanM','diagnosa_keperawatan');
        renameInput('RIDiagnosakeperawatanM','diagnosa_tujuan');
    $('#tbl-DiagnosaKeperawatan tr:last').find('input').val('');
    $('#tbl-DiagnosaKeperawatan tr:last').find('textarea').val('');
    $('#tbl-DiagnosaKeperawatan tr:last').find('select').val('');

}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-DiagnosaKeperawatan tbody tr').length;
    var i = 1;
    $('#tbl-DiagnosaKeperawatan tbody tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('textarea[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    i++;    
    });
}

function delRow(obj)
{
    if(!confirm("$confimMessage")) return false;
    else {
        $(obj).parent().parent().remove();
        renameInput('RIDiagnosakeperawatanM','diagnosa_id');
        renameInput('RIDiagnosakeperawatanM','diagnosakeperawatan_id');
        renameInput('RIDiagnosakeperawatanM','diagnosakeperawatan_kode');
        renameInput('RIDiagnosakeperawatanM','diagnosa_medis');
        renameInput('RIDiagnosakeperawatanM','diagnosa_keperawatan');
        renameInput('RIDiagnosakeperawatanM','diagnosa_tujuan');
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>