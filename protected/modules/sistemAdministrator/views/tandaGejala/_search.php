<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'bataskarakteristik-k-search',
    'type' => 'horizontal',
        ));
?>
<table style="width: 100%">
    <tr>
        <td>
            <br>
        </td>
    </tr>
    <tr>
        <td style="width: 50%">
            <div class="control-group">
                <?php echo Chtml::label('Diagnosa Keperawatan', 'diagnosakep_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'diagnosakep_nama', array('placeholder' => 'Ketik Diagnosa Keperawatan')); ?> 
                </div>
            </div>
        </td>
        <td style="width: 50%">
            <div class="control-group">
                <?php echo CHtml::label("Jenis Tanda dan Gejala", 'jenistandagejala_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropdownlist($model, 'jenistandagejala_id', $model->getDropDownJenis(), array('empty' => '-- Pilih --')); ?> 
                </div>				
            </div>
        </td>
    </tr>
    <tr>
        <td style="width: 50%">
            <div class="control-group">
                <?php echo Chtml::label('Tanda dan Gejala', 'diagnosakep_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'tandagejala_daftar_nama', array('placeholder' => 'Ketik Tanda dan Gejala')); ?> 
                </div>
            </div>
        </td>
        <td style="width: 50%">
            <div class="control-group">
                <?php echo CHtml::label("Status", 'tandagejala_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropdownlist($model, 'tandagejala_aktif', array(0 => 'Tidak Aktif', 1 => 'Aktif'), array('empty' => '-- Pilih --')); ?> 
                </div>				
            </div>
        </td>
    </tr>
</table>
<?php //echo $form->textFieldRow($model,'lookup_id',array('class'=>'span5')); ?>

<?php //echo $form->textFieldRow($model,'lookup_value',array('class'=>'span5','maxlength'=>200)); ?>

<?php //echo $form->textFieldRow($model,'lookup_kode',array('class'=>'span5','maxlength'=>50)); ?>

<?php //echo $form->textFieldRow($model,'lookup_urutan',array('class'=>'span5'));  ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('tandaGejala/admin'), array('class' => 'btn btn-danger', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>

</div>
<?php
//========= Dialog buat cari data Dialog Diagnosa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Diagnosa Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDiagnosaKep = new SADiagnosakepM('search');
$modDiagnosaKep->unsetAttributes();
if (isset($_GET['SADiagnosakepM'])) {
    $modDiagnosaKep->attributes = $_GET['SADiagnosakepM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosakep-m-grid',
    'dataProvider' => $modDiagnosaKep->search(),
    'filter' => $modDiagnosaKep,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'diagnosakep_id') . '\").val(\'$data->diagnosakep_id\');
                                    $(\"#' . CHtml::activeId($model, 'diagnosakep_nama') . '\").val(\'$data->diagnosakep_nama\');

                                    $(\'#dialogDiagnosa\').dialog(\'close\');
                                    return false;"))'
        ),
        array(
            'header' => 'Kode Diagnosa',
            'name' => 'diagnosakep_kode',
            'value' => '$data->diagnosakep_kode',
        ),
        array(
            'header' => 'Diagnosa Keperawatan',
            'type' => 'raw',
            'name' => 'diagnosakep_nama',
            'value' => '$data->diagnosakep_nama',
        ),
        array(
            'header' => 'Deskripsi',
            'name' => 'diagnosakep_deskripsi',
            'value' => '$data->diagnosakep_deskripsi',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php $this->endWidget(); ?>
