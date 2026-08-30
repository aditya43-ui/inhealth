<?php

$itemCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPrintLaporanTAT();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.BootGridViewPDF';
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
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemCssClass='table border';
} else {
    $data = $model->searchLaporanTAT();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php

$this->widget($table, array(
    'id' => 'laporan-tat-grid',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$row+1',
        ),
        array(
            'header' => 'No. Rekam Medik',
            'value' => function($data) {
                if (!empty($data->no_rekam_medik)) {
                    return $data->no_rekam_medik;
                }
            },
        ),
        array(
            'header' => 'Nama Pasien',
            'value' => function($data) {
                if (!empty($data->nama_pasien)) {
                    return $data->nama_pasien;
                }
            },
        ),
        array(
            'header' => 'Waktu Pendaftaran',
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);
            },
        ),
        array(
            'header' => 'Waktu Pemeriksaan',
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser($data->waktumulaiperiksa);
            },
        ),
        array(
            'header' => 'Waktu Pengambilan Hasil',
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser($data->waktuselesaiperiksa);
            },
        ),
        array(
            'header' => 'Waktu Tunggu MCU',
            'value' => function($data) {
                if(!empty($data->waktumulaiperiksa)){
                    $mulai  = new DateTime($data->tgl_pendaftaran);
                    $sampai = $mulai->diff(new DateTime($data->waktumulaiperiksa));
                    $menit  = $sampai->days * 24 * 60;
                    $menit += $sampai->h * 60;
                    $menit += $sampai->i;
                    echo $menit.' menit';
                }else{
                    echo '';
                }
            },
        ),
        array(
            'header' => 'Turn Around Time',
            'value' => function($data) {
                if(!empty($data->waktumulaiperiksa)){
                    $mulai  = new DateTime($data->tgl_pendaftaran);
                    $sampai = $mulai->diff(new DateTime($data->waktumulaiperiksa));
                    $menit  = $sampai->days * 24 * 60;
                    $menit += $sampai->h * 60;
                    $menit += $sampai->i;
                    
                    if(!empty($data->waktuselesaiperiksa)){
                        $mulai2  = new DateTime($data->waktumulaiperiksa);
                        $sampai2 = $mulai2->diff(new DateTime($data->waktuselesaiperiksa));
                        $menit2  = $sampai2->days * 24 * 60;
                        $menit2 += $sampai2->h * 60;
                        $menit2 += $sampai2->i;
                        echo $menit+$menit2.' menit';
                    } else {
                        echo '';
                    }
                } else {
                    echo '';
                }
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
            $("table").find("select").each(function(){
                cekForm(this);
            })
        }',
));
?>