<?php
$this->breadcrumbs = array(
    'Daftar Penerimaan Kas',
);

Yii::app()->clientScript->registerScript('search', "
$('#penerimaan-t-search').submit(function()
{
    $.fn.yiiGridView.update('daftarpenerimaan-m-grid', {
        data: $(this).serialize()
    });
    return false;
});
$('#btn_resset').click(function()
{
    setTimeout(function(){
        $.fn.yiiGridView.update('daftarpenerimaan-m-grid', {
            data: $('#penerimaan-t-search').serialize()
        });    
    }, 1000);
});
");

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'penerimaan-t-search',
        'type' => 'horizontal',
    )
);
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Penerimaan Kas</b></legend>
    <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
        'id' => 'daftarpenerimaan-m-grid',
        'dataProvider' => $modPenerimaan->searchInformasi(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-condensed',
        'columns' => array(
            array(
                'header' => 'No.',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
            ),
            array(
                'header' => 'Tgl. Penerimaan',
                'type' => 'raw',
                'value' => '$data->tglpenerimaan',
            ),
            array(
                'header' => 'No. Penerimaan',
                'type' => 'raw',
                'value' => '$data->nopenerimaan',
            ),
            array(
                'header' => 'Kelompok Transaksi',
                'type' => 'raw',
                'value' => '$data->kelompoktransaksi',
            ),
            array(
                'header' => 'Jenis Penerimaan',
                'type' => 'raw',
                'value' => '$data->jenispenerimaan->jenispenerimaan_nama',
                'footerHtmlOptions' => array('colspan' => 6, 'style' => 'text-align:right;font-style:italic;'),
                'footer' => 'Jumlah Total',
            ),
            'volume',
            //            'satuanvol',
            array(
                'header' => 'Harga',
                'name' => 'hargasatuan',
                'value' => 'number_format($data->hargasatuan)',
                'htmlOptions' => array('style' => 'width:100px;text-align:right'),
                'footerHtmlOptions' => array('style' => 'text-align:right;'),
                'footer' => 'sum(hargasatuan)',
            ),
            array(
                'header' => 'Total Harga',
                'name' => 'totalharga',
                'value' => 'number_format($data->totalharga)',
                'htmlOptions' => array('style' => 'width:100px;text-align:right'),
                'footerHtmlOptions' => array('style' => 'text-align:right;'),
                'footer' => 'sum(totalharga)',
            ),
            array(
                'header' => 'Keterangan',
                'type' => 'raw',
                'value' => '$data->keterangan_penerimaan',
                'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                'footer' => '-',
            ),
            array(
                'header' => 'Retur/Batal',
                'type' => 'raw',
                'htmlOptions' => array(
                    'style' => 'width: 100px; text-align: left;',
                ),
                'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                'footer' => '-',
                'value' => 'CHtml::link("<i class=\'icon-form-retur\'></i> ",Yii::app()->controller->createUrl("returPenerimaanKas/index",array("frame"=>1,"idPenerimaan"=>$data->penerimaanumum_id)) ,array("title"=>"Klik untuk Meretur Penerimaan Umum","target"=>"iframeRetur", "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");", "rel"=>"tooltip"))',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); ?>
    <fieldset class="box">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <div class="control-group">
                        <?php // $modPenerimaan->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenerimaan->tgl_awal, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); 
                        ?>
                        <?php echo CHtml::label('Tgl. Penerimaan Kas', 'tglPenerimaanKas', array('class' => 'control-label inline')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPenerimaan,
                                'attribute' => 'tgl_awal',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php // $modPenerimaan->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenerimaan->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); 
                        ?>
                        <?php echo CHtml::label('Sampai Dengan', 'sampaiDengan', array('class' => 'control-label inline')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPenerimaan,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'minDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $form->textFieldRow($modPenerimaan, 'nopenerimaan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Pengeluaran', 'jenisPengeluaran', array('class' => 'control-label inline')) ?>
                        <div class="controls">
                            <?php
                            echo  $form->dropDownList($modPenerimaan, 'jenispenerimaan_id', CHtml::listData(
                                JenispenerimaanM::model()->findAll(),
                                'jenispenerimaan_id',
                                'jenispenerimaan_nama'
                            ), array('class' => 'span2', 'style' => "width:140px;", 'empty' => '-- Pilih --'));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/informasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </fieldset>
</div>
<?php $this->endWidget(); ?>
<?php
// ===========================Dialog Retur=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRetur',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Retur Penerimaan Umum',
        'autoOpen' => false,
        'minWidth' => 1100,
        'height' => 100,
        'zIndex' => 1004,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframeRetur" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Retur================================
