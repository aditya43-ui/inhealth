
<?php
$table = 'ext.bootstrap.widgets.BootExcelGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

if ($caraPrint == 'EXCEL') {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => ''));
} else {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'colspan' => ''));
}

$this->widget($table, array(
    'id' => 'sajenis-kelas-m-grid',
    'enableSorting' => false,
    'dataProvider' => $model->searchPrint(),
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'jenisbarangrek_id',
        // array(
        // 	'header' => 'No.',
        //  'htmlOptions' => array('style' => 'text-align: right;'),
        // 	'value'=> '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
        // ),
        array(
            'header' => 'No.',
            'value' => '($this->grid->dataProvider->pagination) ?
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
					: ($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'name' => 'jenisbarang_id',
            'type' => 'raw',
            'value' => function ($data) {
                $jenis = JenisbarangM::model()->findByPk($data->jenisbarang_id);
                if (empty($jenis)) return "-";
                return $jenis->jenisbarang_nama;
            },
        ),
        // 'jenisbarang_id',
        array(
            'header' => 'Rekening 5',
            // 'value' => '$data->rekening5_id'
            'name' => 'rekening5_id',
            'value' => function ($data) {
                $rek = Rekening5M::model()->findByPk($data->rekening5_id);
                if (empty($rek)) {
                    return "-";
                }
                return $rek->kdrekening5 . " - " . $rek->nmrekening5;
            },
        ),
        'debitkredit',
        array(
            'header' => 'Penerimaan Faktur',
            'value' => function ($data) {
                if ($data->ispenerimaan == TRUE) {
                    echo "Ya";
                } else {
                    echo "Tidak";
                }
            }
        ),
        array(
            'header' => 'Retur Penerimaan Faktur',
            'value' => function ($data) {
                if ($data->isreturpenerimaan == TRUE) {
                    echo "Ya";
                } else {
                    echo "Tidak";
                }
            }
        ),
        array(
            'header' => 'Inventarisasi Stok Awal',
            'value' => function ($data) {
                if ($data->isstokopname == TRUE) {
                    echo "Ya";
                } else {
                    echo "Tidak";
                }
            }
        ),
        array(
            'header' => 'Inventarisasi Penyesuaian Berkurang',
            'value' => function ($data) {
                if ($data->isstokopnameberkurang == TRUE) {
                    echo "Ya";
                } else {
                    echo "Tidak";
                }
            }
        ),
        array(
            'header' => 'Inventarisasi Penyesuaian Bertambah',
            'value' => function ($data) {
                if ($data->isstokopnamebertambah == TRUE) {
                    echo "Ya";
                } else {
                    echo "Tidak";
                }
            }
        ),
        array(
            'header' => 'Mutasi',
            'value' => function ($data) {
                if ($data->ismutasi == TRUE) {
                    echo "Ya";
                } else {
                    echo "Tidak";
                }
            }
        ),
        array(
            'header' => 'Pemakaian Ruangan',
            'value' => function ($data) {
                if ($data->ispemakaian == TRUE) {
                    echo "Ya";
                } else {
                    echo "Tidak";
                }
            }
        ),
    ),
));
?>
