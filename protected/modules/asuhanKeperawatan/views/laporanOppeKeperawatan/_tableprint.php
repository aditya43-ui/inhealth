<table width="60%">
    <?php if (!empty($model->jenis)) : ?>
        <?php if ($model->jenis == 'Pegawai'): ?>
            <tr>
                <td> Nama </td>
                <td> : 
                    <?php
                    $modPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
                    echo $modPegawai->namaLengkap;
                    ?>
                </td>
            </tr>
            <tr>
                <td> Unit Kerja </td>
                <td> : 
                    <?php
                    echo!empty($modPegawai->unitkerja_id) ? $modPegawai->unitkerja->namaunitkerja : "";
                    ?>
                </td>
            </tr>
        <?php endif; ?>
        <?php if ($model->jenis == 'Unit') : ?>
            <tr>
                <td> Unit Kerja </td>
                <td> :
                    <?php
                    $modPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
                    $modUnit = UnitkerjaM::model()->findByAttributes(
                        array('unitkerja_id' => $modPegawai->unitkerja_id)
                    );
                    // $modUnit = UnitkerjaM::model()->findByPk($model->pegawai_id);
                    // echo !empty($modUnit->namaunitkerja;
                    // echo CJSON::encode($modPegawai);
                    echo !empty($modUnit->unitkerja_id) ? $modUnit->namaunitkerja : '-';
                    ?>
                </td>
            </tr>
        <?php endif; ?>
    <?php endif; ?>
    <tr>
        <td> Periode </td>
        <td> : <?= $periode ?></td>
    </tr>
</table>
<br>

<?php
$itemCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPrintLaporan();
    $data2 = $model->searchPrintLaporan();
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
                color:#000;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }
            .table thead th{
                color: black;
            }
            .table tbody td{
                color: black;
            }
            .table tbody td, .table tbody th {
                align: center;
                background-color: none;
                color: black;
            }
        </style>";
    $itemCssClass='table border';
} else {
    $data = $model->searchLaporanTAT();
    $data2 = $model->searchPrintLaporanTAT();
    $template = "{summary}\n{items}\n{pager}";
}
$jumlah = 0;
$skor = 0;
foreach ($data->data as $item) {
    if (!empty($item->skor)) {
        $jumlah += $item->skor;
    } else {
        $jumlah += 0;
    }
}
if (!empty($data->data)) {
    $skor = $jumlah / count($data->data);
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
            'headerHtmlOptions' => array('style' => 'text-align: center;',),
            'htmlOptions' => array('style' => 'text-align: center;',),
            'value' => '$row+1',
        ),
        array(
            'header' => 'Indikator Kinerja',
            'headerHtmlOptions' => array('style' => 'text-align: center;',),
            'value' => function($data) {
                $modIndikator = IndikatoroppekeperawatanM::model()->findByPk($data->indikatoroppekeperawatan_id);
                echo $modIndikator->nama_indikator;
            },
            'footerHtmlOptions' => array('colspan' => 4, 'style' => 'text-align:center;'),
            'footer' => 'Skor Kinerja',
        ),
        array(
            'header' => 'Standar',
            'headerHtmlOptions' => array('style' => 'text-align: center;',),
            'htmlOptions' => array('style' => 'text-align: center;',),
            'value' => function($data) {
                echo MyFormatter::formatNumberForPrint($data->standar_nilai, 2) . " %";
            }
        ),
        array(
            'header' => 'Capaian',
            'headerHtmlOptions' => array('style' => 'text-align: center;',),
            'htmlOptions' => array('style' => 'text-align: center;',),
            'value' => function($data) {
                echo MyFormatter::formatNumberForPrint($data->capaian, 2) . " %";
            }
        ),
        array(
            'header' => 'Skor',
            'headerHtmlOptions' => array('style' => 'text-align: center;',),
            'htmlOptions' => array('style' => 'text-align: center;',),
            'value' => function($data) {
                echo MyFormatter::formatNumberForPrint($data->skor, 2) . " %";
            },
            'footerHtmlOptions' => array('style' => 'text-align:center;'),
            'footer' => MyFormatter::formatNumberForPrint($skor, 2),
        ),
        array(
            'header' => 'Keterangan',
            'headerHtmlOptions' => array('style' => 'text-align: center;',),
            'value' => function($data) {
                if ($data->skor < 80) {
                    echo "Kurang";
                } else if ($data->skor >= 80 && $data->skor < 90) {
                    echo "Baik";
                } else {
                    echo "Sangat Baik";
                }
            },
            'footerHtmlOptions' => array('colspan' => 2, 'style' => 'text-align:center;'),
            'footer' => ' ',
        ),
        array(
            'header' => 'Rekomendasi',
            'headerHtmlOptions' => array('style' => 'text-align: center; width: 15%',),
            'value' => function($data) {
                $modIndikator = IndikatoroppekeperawatanM::model()->findByPk($data->indikatoroppekeperawatan_id);
                if ($data->skor < 80) {
                    echo $modIndikator->rekomendasi;
                } else {
                    echo "-";
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

<br>
<br>
<br>
<?php
$modPegawai = PegawaiM::model()->findByPk(4177);
$modKomite = PegawaiM::model()->findByPk(3790);
?>
<?php if ($model->jenis == 'Semua') { ?>
    <table width="100%">
        <tr>
            <td width="50%" style="text-align: center; vertical-align: top">
                Kepala Bidang Keperawatan
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <u> <b> <?= !empty($modPegawai) ? $modPegawai->namaLengkap : "" ?></b> </u> <br>
                <?= !empty($modPegawai) ? $modPegawai->nomorindukpegawai : "" ?> <br>
            </td>
            <td width="50%" style="text-align: center; vertical-align: top">
                Ketua Komite Keperawatan
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <u> <b> <?= !empty($modKomite) ? $modKomite->namaLengkap : "" ?></b> </u> <br>
                <?= !empty($modKomite) ? $modKomite->nomorindukpegawai : "" ?> <br>
            </td>
        </tr>
    </table> 
<?php } else { ?>
    <table width="100%">
        <tr>
            <td width="50%" style="text-align: center; vertical-align: top">
                Kepala Bidang Keperawatan
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <u> <b> <?= !empty($modPegawai) ? $modPegawai->namaLengkap : "" ?></b> </u> <br>
                <?= !empty($modPegawai) ? $modPegawai->nomorindukpegawai : "" ?> <br>
            </td>
            <td width="50%" style="text-align: center; vertical-align: top">
                <?php
                $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                $modUnit = UnitkerjaM::model()->findByPk($modPegawai->unitkerja_id);
                $nama = !empty($modPegawai) ? $modPegawai->namaLengkap : "";
                $nip = !empty($modPegawai) ? $modPegawai->nomorindukpegawai : "";
                ?>
                Penilai Kinerja <br> Kepala Ruangan
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <u> <b> <?=  !empty($nama) ? $nama : "" ?></b> </u> <br>
                <?= !empty($nip) ? $nip : "" ?> <br>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; vertical-align: top">
                <Br>
                Ketua Komite Keperawatan

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <u> <b> <?= !empty($modKomite) ? $modKomite->namaLengkap : "" ?></b> </u> <br>
                <?= !empty($modKomite) ? $modKomite->nomorindukpegawai : "" ?> <br>
            </td> 
        </tr>
    </table> 
<?php } ?>