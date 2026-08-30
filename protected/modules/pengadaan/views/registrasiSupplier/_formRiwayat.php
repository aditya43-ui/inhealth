<?php
$modSPK = new PenawaranpenyediaT; 
//$modSPK = new SuratperjanjiankerjaT;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'persiapanpengadaan-m-grid',
    'dataProvider' => $modSPK->searchRiwayatPenawaran(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header'=>'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                            : ($row+1)',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:left;'),
            'headerHtmlOptions'=>array(
                'style'=>'text-align: center',
            ),
        ),
        array(
            'header' => 'Nama Pekerjaan',
            'value' => '$data->nama_pekerjaan',
            'headerHtmlOptions'=>array(
                'style'=>'text-align: center',
            ),
        ),
        array(
            'header' => 'Total Penawaran',
            'value' => 'number_format($data->penawaranpenyedia_harga,2)',
            'htmlOptions'=>array(
                'style'=>'text-align: right',
            ),
            'headerHtmlOptions'=>array(
                'style'=>'text-align: center',
            ),
        ),
        array(
            'header' => 'Nomor Persiapan Pengadaan',
            'headerHtmlOptions'=>array(
                'style'=>'text-align: center',
            ),
            'value' => '$data->persiapanpengadaan_nomor',
//            'filter' => Chtml::activeTextField($modPenawaranPenyedia, 'persiapanpengadaan_nomor'),
        ),
        array(
            'header' => 'Nomor Penawaran',
            'headerHtmlOptions'=>array(
                'style'=>'text-align: center',
            ),
            'value' => '$data->penawaranpenyedia_nomorsurat',
//            'filter' => Chtml::activeTextField($modPenawaranPenyedia, 'penawaranpenyedia_nomor'),
        ),
        array(
            'header' => 'Nomor SPK',
            'headerHtmlOptions'=>array(
                'style'=>'text-align: center',
            ),
            'value' => '$data->nosuratperjanjiankerja',
//            'filter' => Chtml::activeTextField($modPenawaranPenyedia, 'nosuratperjanjiankerja'),
        ),
        array(
            'header' => 'Status',
            'headerHtmlOptions'=>array(
                'style'=>'text-align: center',
            ),
            'value' => '$data->suratperjanjiankerja_status'
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>  