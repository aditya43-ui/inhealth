<?php
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('penawaran-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<legend class="rim2">Informasi Faktur Pembelian Umum</legend>
<div id="divSearch-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'rencana-t-search',
        'type' => 'horizontal',
    )); ?>
    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'penawaran-m-grid',
        'dataProvider' => $modFaktur->searchInformasi(),
        'template' => "{pager}{summary}\n{items}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            'tglfaktur',
            'nofaktur',
            'tgljatuhtempo',
            array(
                'name' => 'supplier_id',
                'type' => 'raw',
                'value' => '$data->supplier->supplier_nama',
            ),
            array(
                'header' => 'Total Harga Netto (Rp)',
                'type' => 'raw',
                'value' => 'MyFunction::formatNumber($data->totharganetto)',
            ),
            //                'totharganetto',
            'jmldiscount',
            'biayamaterai',
            'totalpajakpph',
            'totalpajakppn',
            array(
                'header' => 'Total Harga Bruto (Rp)',
                'type' => 'raw',
                'value' => 'MyFunction::formatNumber($data->totalhargabruto)',
            ),
            //                'totalhargabruto',            

            array( //Details ini langsung terhubung ke details Faktur d peneriaam Items supaya mudah memaintenance karena 1 view dan action 
                'header' => 'Details',
                'type' => 'raw',
                'value' => 'CHtml::link("<i class=\'icon-list-alt\'></i> ",Yii::app()->controller->createUrl("PenerimaanItems/detailsFaktur",array("idFakturPembelian"=>$data->fakturpembelian_id)) ,array("title"=>"Klik untuk Melihat Detail Faktur","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsFaktur\").dialog(\"open\");", "rel"=>"tooltip"))',
            ),
            array(
                'header' => 'Retur',
                'type' => 'raw',
                'value' => 'CHtml::link("<i class=\'icon-list-alt\'></i> ",Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/retur",array("idFakturPembelian"=>$data->fakturpembelian_id)) ,array("title"=>"Klik untuk Melihat Detail Faktur","target"=>"iframeRetur", "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");", "rel"=>"tooltip"))',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); ?>
    <legend class="rim">Pencarian</legend>
    <table>
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Faktur Pembelian', 'tglFakturPembelian', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modFaktur,
                            'attribute' => 'tglAwal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_TIME_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Sampai Dengan', 'sampaiDengan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modFaktur,
                            'attribute' => 'tglAkhir',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_TIME_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                    </div>
                </div>
            </td>
            <td>
                <?php echo $form->textFieldRow($modFaktur, 'nofaktur', array('class' => 'numberOnly')); ?>
                <?php echo $form->dropDownListRow(
                    $modFaktur,
                    'supplier_id',
                    CHtml::listData($modFaktur->SupplierItems, 'supplier_id', 'supplier_nama'),
                    array(
                        'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'empty' => '-- Pilih --',
                    )
                ); ?>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?><?php
                                                                                                                                                                                $content = $this->renderPartial('keuangan.views.tips.informasi', array(), true);
                                                                                                                                                                                $this->widget('TipsMasterData', array('type' => 'transaksi', 'content' => $content));
                                                                                                                                                                                ?>
    </div>
    <?php $this->endWidget(); ?>

</div>
<?php
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$action = $this->getAction()->getId();
$currentUrl =  Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'form_hiddenFaktur',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('target' => '_new'),
    'action' => Yii::app()->createUrl($module . '/fakturPembelian/index'),
)); ?>
<?php echo CHtml::hiddenField('idPenerimaanForm', '', array('readonly' => true)); ?>
<?php echo CHtml::hiddenField('noPenerimaanForm', '', array('readonly' => true)); ?>
<?php echo CHtml::hiddenField('tglPenerimaanForm', '', array('readonly' => true)); ?>
<?php echo CHtml::hiddenField('currentUrl', $currentUrl, array('readonly' => true)); ?>
<?php $this->endWidget(); ?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailsFaktur',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Details Permintaan Pembelian',
        'autoOpen' => false,
        'minWidth' => 1100,
        'minHeight' => 100,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframe" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================

// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRetur',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Retur',
        'autoOpen' => false,
        'minWidth' => 1100,
        'minHeight' => 100,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframeRetur" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================

$js = <<< JSCRIPT
function formFaktur(idPenerimaan,noPenerimaan,tglPenerimaan)
{
    $('#idPenerimaanForm').val(idPenerimaan);
    $('#noPenerimaanForm').val(noPenerimaan);
    $('#tglPenerimaanForm').val(tglPenerimaan);
    $('#form_hiddenFaktur').submit();
}
JSCRIPT;
Yii::app()->clientScript->registerScript('javascript', $js, CClientScript::POS_HEAD);

?>