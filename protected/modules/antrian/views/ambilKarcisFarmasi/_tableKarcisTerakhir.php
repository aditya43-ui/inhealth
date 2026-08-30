<!--<h6>Tabel <b>Karcis Terakhir</b></h6>-->
<?php
$modKarcisTerakhir = new ANAntrianfarmasiT('search');
$modKarcisTerakhir->unsetAttributes();
if (isset($_GET['ANAntrianfarmasiT'])) {
    $modKarcisTerakhir->attributes = $_GET['ANAntrianfarmasiT'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'anantrianfarmasi-t-grid',
    'dataProvider' => $modKarcisTerakhir->searchKarcisTerakhir(),
    'filter' => $modKarcisTerakhir,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '(($this->grid->dataProvider->pagination) ? '
            . '($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)'
            . ' : $row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'name' => 'tglambilantrian',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglambilantrian)',
            'filter' => false,
        ),
        array(
            'header' => 'Tanggal Akan Dilayani', 
            'name' => 'tglakandilayani',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglakandilayani)',
            'filter' => false,
        ),
        array(
            'name' => 'racikan_id',
            'type' => 'raw',
            'value' => '$data->racikan->racikan_nama." (".$data->racikan->racikan_singkatan.")"',
            'filter' => $modKarcisTerakhir->getListRacikans(),
        ),
        'noantrian',
        array(
            'name' => 'panggilantrian',
            'filter' => array(1 => 'Sudah', 0 => 'Belum'),
            'type' => 'raw',
            'value' => '($data->panggilantrian) ? "Sudah" : "Belum"',
        ),
        array(
            'name' => 'antrianlewat',
            'filter' => array(1 => 'Ya', 0 => 'Tidak'),
            'type' => 'raw',
            'value' => '($data->antrianlewat) ? "Ya" : "Tidak"',
        ),
        array(
            'header' => 'Print Karcis',
            'filter' => false,
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"entypo-print\"></i>","javascript:void(0);",
                            array(
                                  "onclick"=>"printKarcisFarmasi($data->antrianfarmasi_id,\"PRINT\")",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk Membatalkan Pembayaran",
                            ))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            )
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>