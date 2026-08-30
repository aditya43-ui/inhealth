<div class="white-container">
        <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
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
        ?>
        <legend class="rim2">Informasi <b>Penerimaan Kas</b></legend>
        <div class="block-tabel">
                <h6>Tabel <b>Penerimaan Kas</b></h6>
                <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                        'id' => 'daftarpenerimaan-m-grid',
                        'dataProvider' => $modPenerimaan->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-condensed',
                        'columns' => array(
                                array(
                                        'header' => 'No.',
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
                                        'header' => 'Retur / Batal',
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
        </div>
        <fieldset class="box">
                <?php $this->renderPartial('_search', array('modPenerimaan' => $modPenerimaan)); ?>
        </fieldset>
</div>
<?php
// ===========================Dialog Retur=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogRetur',
        // additional javascript options for the dialog plugin
        'options' => array(
                'title' => 'Retur Penerimaan Umum',
                'autoOpen' => false,
                'zIndex' => 1002,
                'minWidth' => 1100,
                'height' => 100,
                'resizable' => false,
                'close' => "js:function(){ $.fn.yiiGridView.update('daftarpenerimaan-m-grid', {
							data: $(this).serialize()
						}); }",
        ),
));
?>
<iframe src="" name="iframeRetur" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Retur================================
?>
<br>