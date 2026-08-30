<style>
   
    #judul{
        font-size:14pt !important;
    }
</style>
<?php
$itemCssClass='table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $template = "{items}";
   
    if ($caraPrint == 'PDF') {
        echo "<style> @media print {
        #space {page-break-before: always;}
    }</style>";
        $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
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
}

$tmp = 1;
$triwulan = 1;
for ($i = 1; $i <= 12; $i++) {
    
    if ($tmp == 1) {
        echo '<table style="width: 100%; border: none;"><tr><td align="center">
            <div id="judul"><b>Laporan Pendidikan Pasien & Keluarga RSUD Dr. SOETOMO <br> TRIWULAN ' . $triwulan . " Tahun " . $periode . '</b><div></td></tr></table>';

        $rekap = $triwulan;
        $triwulan++;
    }
    if ($tmp <= 3) {
        $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
        $data = $model->search($i);

        $sort = false;
        $kaset = 0;
        $poster = 0;
        $jumlah = 0;
        $metode_ceramah = 0;
        $metode_demonstrasi = 0;
        $metode_diskusi = 0;
        $metode_wawancara = 0;

        foreach ($data->data as $item) {
            $metode_ceramah += $item->metode_ceramah;
            $metode_demonstrasi += $item->metode_demonstrasi;
            $metode_diskusi += $item->metode_diskusi;
            $metode_wawancara += $item->metode_wawancara;
        }
        $jumlah = $metode_ceramah + $metode_demonstrasi + $metode_diskusi + $metode_wawancara;
        ?>
        <?php
        $this->widget($table, array(
            'id' => 'tableInformasi' . $i,
            'dataProvider' => $data,
            'enableSorting' => $sort,
            'template' => $template,
            'mergeColumns' => array('bulanedukasi'),
            'extraRowColumns' => array('bulanedukasi'),
            'itemsCssClass' => $itemCssClass,
            'columns' => array(
                array(
                    'header' => 'Bulan',
                    'name' => 'bulanedukasi',
                    'type' => 'raw',
                    'value' => function($data) {

                        if (!empty($data->bulanedukasi)) {
                            return "Bulan: " . MyFormatter::getMonthId($data->bulanedukasi);
                        } else {
                            return "-";
                        }
                    },
                    'footerHtmlOptions' => array('colspan' => 2, 'style' => 'text-align:right;'),
                    'footer' => '<b>Jumlah</b>',
                // 'visible'=>false,
                ),
                array(
                    'header' => 'Topik Penyuluhan',
                    'type' => 'raw',
                    'name' => 'topikedukasi',
                    'value' => function($data) {

                        if (!empty($data->topikedukasi)) {
                            return $data->topikedukasi;
                        } else {
                            return "-";
                        }
                    },
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'header' => 'Pemasangan Poster',
                    'value' => function($data) {

                        return "-";
                    },
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => number_format($poster, 0, "", "."),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Pemutaran Kaset',
                    'value' => function($data) {

                        return "-";
                    },
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => number_format($kaset, 0, "", "."),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Ceramah',
                    'name' => 'metode_ceramah',
                    'type' => 'raw',
                    'value' => function($data) {
                        if (!empty($data->metode_ceramah)) {
                            return number_format($data->metode_ceramah, 0, "", ".");
                        } else {
                            return "-";
                        }
                    },
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => 'sum(metode_ceramah)',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Demonstrasi',
                    'name' => 'metode_demonstrasi',
                    'type' => 'raw',
                    'value' => function($data) {
                        if (!empty($data->metode_demonstrasi)) {

                            return $data->metode_demonstrasi;
                        } else {
                            return "-";
                        }
                    },
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => 'sum(metode_demonstrasi)',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Diskusi Kelompok',
                    'name' => 'metode_diskusi',
                    'type' => 'raw',
                    'value' => function($data) {
                        if (!empty($data->metode_diskusi)) {

                            return $data->metode_diskusi;
                        } else {
                            return "-";
                        }
                    },
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => 'sum(metode_diskusi)',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Tatap Muka',
                    'name' => 'metode_wawancara',
                    'type' => 'raw',
                    'value' => function($data) {
                        if (!empty($data->metode_wawancara)) {
                            return $data->metode_wawancara;
                        } else {
                            return "-";
                        }
                    },
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => 'sum(metode_wawancara)',
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Jumlah',
                    'value' => function($data) {

                        return "-";
                    },
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => number_format($jumlah, 0, "", "."),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
        ));
        echo "<br>";
        if ($tmp == 3) {
            $tmp = 1;

            $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
            $data = $model->searchRekap($rekap);

            $sort = false;
            $kaset = 0;
            $poster = 0;
            $jumlah = 0;
            $metode_ceramah = 0;
            $metode_demonstrasi = 0;
            $metode_diskusi = 0;
            $metode_wawancara = 0;

            foreach ($data->data as $item) {
                $metode_ceramah += $item->metode_ceramah;
                $metode_demonstrasi += $item->metode_demonstrasi;
                $metode_diskusi += $item->metode_diskusi;
                $metode_wawancara += $item->metode_wawancara;
            }
            $jumlah = $metode_ceramah + $metode_demonstrasi + $metode_diskusi + $metode_wawancara;
            ?>
            <?php
            $this->widget($table, array(
                'id' => 'tableRekap' . $triwulan,
                'dataProvider' => $data,
                'enableSorting' => $sort,
                'template' => $template,
                'itemsCssClass' => $itemCssClass,
                'columns' => array(
                    array(
                        'header' => 'No.',
                        'value' => '$row+1',
                        'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                        'footerHtmlOptions' => array('colspan' => 3, 'style' => 'text-align:right;'),
                        'footer' => '<b>Jumlah</b>',
                    ),
                    array(
                        'header' => 'Topik Penyuluhan',
                        'type' => 'raw',
                        'name' => 'topikedukasi',
                        'value' => function($data) {

                            if (!empty($data->topikedukasi)) {
                                return $data->topikedukasi;
                            } else {
                                return "-";
                            }
                        },
                        'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                    ),
                    array(
                        'header' => 'Topik Penyuluhan',
                        'type' => 'raw',
                        'name' => 'topikedukasi',
                        'value' => function($data) {

                            if (!empty($data->topikedukasi)) {
                                return $data->topikedukasi;
                            } else {
                                return "-";
                            }
                        },
                        'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                    ),
                    array(
                        'header' => 'Pemasangan Poster',
                        'value' => function($data) {

                            return "-";
                        },
                        'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                        'htmlOptions' => array('style' => 'text-align: right;'),
                        'footer' => number_format($poster, 0, "", "."),
                        'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    ),
                    array(
                        'header' => 'Pemutaran Kaset',
                        'value' => function($data) {

                            return "-";
                        },
                        'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                        'htmlOptions' => array('style' => 'text-align: right;'),
                        'footer' => number_format($kaset, 0, "", "."),
                        'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    ),
                    array(
                        'header' => 'Ceramah',
                        'name' => 'metode_ceramah',
                        'type' => 'raw',
                        'value' => function($data) {
                            if (!empty($data->metode_ceramah)) {
                                return number_format($data->metode_ceramah, 0, "", ".");
                            } else {
                                return "-";
                            }
                        },
                        'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                        'htmlOptions' => array('style' => 'text-align: right;'),
                        'footer' => 'sum(metode_ceramah)',
                        'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    ),
                    array(
                        'header' => 'Demonstrasi',
                        'name' => 'metode_demonstrasi',
                        'type' => 'raw',
                        'value' => function($data) {
                            if (!empty($data->metode_demonstrasi)) {

                                return $data->metode_demonstrasi;
                            } else {
                                return "-";
                            }
                        },
                        'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                        'htmlOptions' => array('style' => 'text-align: right;'),
                        'footer' => 'sum(metode_demonstrasi)',
                        'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    ),
                    array(
                        'header' => 'Diskusi Kelompok',
                        'name' => 'metode_diskusi',
                        'type' => 'raw',
                        'value' => function($data) {
                            if (!empty($data->metode_diskusi)) {

                                return $data->metode_diskusi;
                            } else {
                                return "-";
                            }
                        },
                        'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                        'htmlOptions' => array('style' => 'text-align: right;'),
                        'footer' => 'sum(metode_diskusi)',
                        'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    ),
                    array(
                        'header' => 'Tatap Muka',
                        'name' => 'metode_wawancara',
                        'type' => 'raw',
                        'value' => function($data) {
                            if (!empty($data->metode_wawancara)) {
                                return $data->metode_wawancara;
                            } else {
                                return "-";
                            }
                        },
                        'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                        'htmlOptions' => array('style' => 'text-align: right;'),
                        'footer' => 'sum(metode_wawancara)',
                        'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    ),
                    array(
                        'header' => 'Jumlah',
                        'value' => function($data) {

                            return "-";
                        },
                        'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                        'htmlOptions' => array('style' => 'text-align: right;'),
                        'footer' => number_format($jumlah, 0, "", "."),
                        'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
            ));

            echo " <br>";
            if($caraPrint != 'PRINT' && $caraPrint != 'EXCEL'){
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <table class="tabel-surat" width="100%">
                        <tr style="text-align: center;">
                            <td width="50%">
                                &nbsp;
                            </td>
                           
                            <td width="50%" align="center">                        
                                <?php $date = date('Y-m-d'); ?>
                                Surabaya, <?php echo MyFormatter::formatDateTimeForUser($date) ?><br>
                                <br>
                                Kepala,
                                <br><br><br><br><br>

                                <?php
                                echo !empty($pegawaiMengetahui->NamaLengkap)?$pegawaiMengetahui->NamaLengkap:""; 
                                
                                echo '<br>NIP. ' . !empty($pegawaiMengetahui->nomorindukpegawai)?$pegawaiMengetahui->nomorindukpegawai:"";
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <?php
        }
            if($i!=12){
            echo "
            <div id='space'></div>    
            ";
            
            }
            //rekap hasil
        } else {
            $tmp++;
        }
    }
}
?>