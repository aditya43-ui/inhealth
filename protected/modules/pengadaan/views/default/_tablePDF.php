<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridViewRp';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchDashboardPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridViewRp';
    }

    echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemCssClass = 'table border';
} else {
    $data = $model->searchDashboardPrint();
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'dashboardpengadaan-v-grid',
    'replaceUrl' => true,
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'mergeColumns' => array('rencanaumumpengadaan_kategori', 'nomor_rup', 'nomor_kontrak'),
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                        : ($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
        ),
        array(
            'header' => 'Kategori',
            'type' => 'raw',
            'name' => 'rencanaumumpengadaan_kategori',
            'htmlOptions' => array('style' => 'text-align:left; vertical-align: middle'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                return $data->rencanaumumpengadaan_kategori;
            },
        ),
        array(
            'header' => 'RUP',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                echo $data->nomor_rup . "<br>" .
                        MyFormatter::formatDateTimeForUser($data->tanggal_rup) . "<br>" .
                        MyFormatter::formatUang($data->nominal_rup, "Rp.", 2) . "<span style='display: none'>".$data->rencanaumumpengadaan_kategori. $data->nomor_kontrak."</span>";
            },
        ),
        array(
            'header' => 'Kontrak',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                if (!empty($data->suratperjanjiankerja_id)) {
                    echo $data->nomor_kontrak . "<br>" .
                            MyFormatter::formatDateTimeForUser($data->tanggal_kontrak) . "<br>" .
                            MyFormatter::formatUang($data->nominal_kontrak, "Rp.", 2) ;
                } else {
                    return "-";
                }
            },
        ),
        array(
            'header' => 'Serah Terima',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                if (!empty($data->baserahterima_id)) {
                    return $data->nomor_bast . "<br>" .
                    MyFormatter::formatDateTimeForUser($data->tanggal_bast) . "<br>" .
                    MyFormatter::formatUang($data->nominal_bast, "Rp.", 2);
                } else {
                    echo "-";
                }
            },
        ),
        array(
            'header' => 'Penyerahan <br> Barang / Jasa',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'headerHtmlOptions' => array('style' => 'text-align: center',), 'value' => function($data) {
                if (!empty($data->bapenyerahanbarangjasa_id)) {
                    echo $data->nomor_bapbj . "<br>" .
                    MyFormatter:: formatDateTimeForUser($data->tanggal_bapbj) . "<br>" .
                    MyFormatter::formatUang($data->nominal_bapbj, "Rp.", 2);
                } else {
                    echo "-";
                }
            },
        ),
        array(
            'header' => 'PPHP/PjPHP',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                if (!empty($data->bapemeriksaanadmpphp_id) || !empty($data->bapemeriksaanadmpjphp_id)) {
                    if (!empty($data->bapemeriksaanadmpphp_id)) {
                        if (!empty($data->nominal_pphp)) {
                            $nominal = MyFormatter::formatUang($data->nominal_pjphp, "Rp.", 2);
                        } else {
                            $nominal = MyFormatter::formatUang(0, "Rp.", 2);
                        }
                        echo $data->bapemeriksaanadmpphp_nomor. "<br>" .
                        MyFormatter:: formatDateTimeForUser($data->tanggal_pphp) . "<br>" .
                        $nominal;
                    } else if (!empty($data->bapemeriksaanadmpjphp_id)) {
                        if (!empty($data->nominal_pjphp)) {
                            $nominal = MyFormatter::formatUang($data->nominal_pjphp, "Rp.", 2);
                        } else {
                            $nominal = MyFormatter::formatUang(0, "Rp.", 2);
                        }
                        echo $data->bapemeriksaanadmpjphp_nomor . "<br>" .
                        MyFormatter::formatDateTimeForUser($data->tanggal_pjphp) . "<br>" .
                        $nominal;
                    }
                } else {
                    echo "-";
                }
            },
        ),
        array(
            'header' => 'Nota Dinas',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                if (!empty($data->nomor_notadinaspptk)) {
                    echo $data->nomor_notadinaspptk . "<br>" .
                    MyFormatter::formatDateTimeForUser($data->tanggal_notadinaspptk) . "<br>" .
                    MyFormatter ::formatUang($data->nominal_notadinaspptk, "Rp.", 2);
                } else {
                    echo "-";
                }
            }
        ),
        array(
            'header' => 'Verifikasi',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                if (!empty($data->nomor_verifikasi)) {
                    echo $data->nomor_verifikasi . "<br>" .
                    MyFormatter::formatDateTimeForUser($data->tanggal_verifikasi) . "<br>" .
                    MyFormatter::formatUang($data->nominal_verifikasi, "Rp.", 2);
                } else {
                    echo "-";
                }
            }
        ),
        array(
            'header' => 'Realisasi',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                if (!empty($data->nomor_realisasi)) {
                    echo $data->nomor_realisasi . "<br>" . MyFormatter::formatDateTimeForUser($data->tanggal_realisasi) . "<br>" .
                    MyFormatter ::formatUang($data->nominal_realisasi, "Rp.", 2);
                } else {
                    echo "-";
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

?>