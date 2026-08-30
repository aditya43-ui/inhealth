<legend class="rim2">Informasi Penjualan Resep</legend>
<?php
$this->widget('bootstrap.widgets.BootAlert');

Yii::app()->clientScript->registerScript('cariPasien', "
$('#caripasien-form').submit(function(){
	$.fn.yiiGridView.update('infopenjualanapotik-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'method' => 'get',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'infopenjualanapotik-grid',
    'dataProvider' => $modInfo->searchInfoJualResep(),
    //        'filter'=>$modInfo,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        'jenispenjualan',
        'noRekamMedisNoPendaftaran',
        'namapasien',
        'tanggal_lahir',
        'tglpenjualan',
        'noresep',
        'totharganetto',
        'totalhargajual',
        'InstalasiRuanganAsal',
        array(
            'header' => 'Lihat Penjualan',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("infoPenjualanResep/lihatPenjualan",array("idReseptur"=>$data->reseptur_id)),
                            array("class"=>"", 
                                  "target"=>"iframePenjualanResep",
                                  "onclick"=>"$(\"#dialogLihatPenjualan\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk lihat penjualan",
                            ))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Retur Penjualan',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("infoPenjualanResep/returPenjualan",array("idReseptur"=>$data->reseptur_id)),
                            array("class"=>"", 
                                  "target"=>"iframeReturResep",
                                  "onclick"=>"$(\"#dialogReturPenjualan\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk retur penjualan",
                            ))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>

<fieldset>
    <legend class="rim"><?php echo  Yii::t('mds', 'Search Patient') ?></legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php echo $form->textFieldRow($modInfo, 'no_rekam_medik', array('class' => 'span3 numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($modInfo, 'nama_pasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($modInfo, 'nama_bin', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </td>
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($modInfo, 'tglpenjualan', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modInfo,
                            'attribute' => 'tgl_awal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                //
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label(' Sampai dengan', 'tgl_akhir', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modInfo,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'minDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>

                    </div>
                </div>
                <?php echo $form->textFieldRow($modInfo, 'noresep', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </td>
        </tr>
    </table>
</fieldset>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?>
    <?php
    $this->widget('UserTips', array());
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
// Dialog buat lihat penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogLihatPenjualan',
    'options' => array(
        'title' => 'Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframePenjualanResep" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end lihat penjualan resep dialog =============================
?>

<?php
// Dialog buat retur penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogReturPenjualan',
    'options' => array(
        'title' => 'Retur Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('infopenjualanapotik-grid', {
                        data: $('#caripasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframeReturResep" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end retur penjualan resep dialog =============================
?>