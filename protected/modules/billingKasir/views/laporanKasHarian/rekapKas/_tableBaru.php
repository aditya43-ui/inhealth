<style>
    .allborder {
        text-align: right;
        border: 1px solid #333;
    }

    .tabel-akun tbody tr:hover td.allborder,
    .tabel-akun tbody tr:hover th.allborder {
        border: 1px solid #333;
    }

    .kiriborder {
        text-align: right;
        border-left: 1px solid #333;
    }

    .tabel-akun tbody tr:hover td.kiriborder,
    .tabel-akun tbody tr:hover th.kiriborder {
        border-left: 1px solid #333;
    }

    .kananborder {
        text-align: right;
        border-right: 1px solid #333;
    }

    .tabel-akun tbody tr:hover td.kananborder,
    .tabel-akun tbody tr:hover th.kananborder {
        border-right: 1px solid #333;
    }

    .atasborder {
        text-align: right;
        border-top: 1px solid #333;
    }

    .tabel-akun tbody tr:hover td.atasborder,
    .tabel-akun tbody tr:hover th.atasborder {
        border-top: 1px solid #333;
    }

    .bawahborder {
        text-align: right;
        border-bottom: 1px solid #333;
    }

    .tabel-akun tbody tr:hover td.bawahborder,
    .tabel-akun tbody tr:hover th.bawahborder {
        border-bottom: 1px solid #333;
    }

    .tabel-akun tbody tr:hover td.border-sub,
    .tabel-akun tbody tr:hover th.border-sub {
        border-top: 1px solid #333;
        /**#dee0e2**/
    }

    .table-akun {
        margin-left: 15px;
    }
</style>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutTable.css');
$rim = '';
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$data = '';
//$template = "{summary}\n{items}\n{pager}";
$template = "{items}";
$sort = true;
if (isset($caraPrint)) {
    $sort = false;
    $data = '';
    $rim = '';
    $template = "{items}";
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>

<div class="biru" id="rekapKas">
    <div class="white" style="<?php echo $rim; ?>">
        <?php
        if (isset($caraPrint)) {
        } else {
        ?>
            <!--<legend class="rim"> Tabel Rekap Kas Harian </legend>-->
        <?php } ?>

    </div>

</div>

<div class="biru" id="detailKas">
    <div class="white" style="<?php echo $rim; ?>">
        <?php
        if (isset($caraPrint)) {
            $dataDetail = $model->searchLaporanPrint();
        } else {
            $dataDetail = $model->searchLaporan();
        ?>
            <!--<legend class="rim"> Tabel Detail Kas Harian</legend>-->
        <?php } ?>
        <?php
        $this->widget($table, array(
            'id' => 'detaillaporankasharianlab-grid',
            'dataProvider' => $dataDetail,
            //'enableSorting'=>$sort,
            'template' => $template,
            'multipleHeader' => array(
                array(
                    array('text' => 'Saldo Awal ' . MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->tgl_awal))), 'colspan' => 9, 'options' => array('style' => 'text-align:right;font-size:10px;')),
                    array('text' => number_format($model->getSaldoAwalClosing(), 0, "", "."), 'colspan' => 9, 'options' => array('style' => 'text-align:right;')),
                ),
                array(
                    array('text' => 'No', 'colspan' => 1, 'options' => array()),
                    array('text' => 'Tanggal', 'colspan' => 1, 'options' => array()),
                    array('text' => 'BKM', 'colspan' => 1, 'options' => array()),
                    array('text' => 'BKK', 'colspan' => 1, 'options' => array()),
                    array('text' => 'Bukti', 'colspan' => 1, 'options' => array()),
                    array('text' => 'Keterangan', 'colspan' => 1, 'options' => array()),
                    array('text' => 'Kasir', 'colspan' => 1, 'options' => array()),
                    array('text' => 'Debet', 'colspan' => 1, 'options' => array()),
                    array('text' => 'Kredit', 'colspan' => 1, 'options' => array()),
                    array('text' => 'Saldo', 'colspan' => 1, 'options' => array()),
                ),
            ),
            'itemsCssClass' => 'table border paddingtext2',
            'columns' => array(
                array(
                    'header' => 'No.',
                    //  'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'value' => '$row+1',
                    'footerHtmlOptions' => array('colspan' => '6', 'style' => 'text-align:right;font-style:italic;'),
                ),
                array(
                    'header' => 'Tanggal',
                    'type' => 'raw',
                    'value' => function ($data) {
                        return MyFormatter::formatDateTimeForUser($data->tanggal);
                    }
                ),
                array(
                    'header' => 'BKM',
                    'value' => '$data->no_bkm'
                ),
                array(
                    'header' => 'BKK',
                    'value' => '$data->no_bkk'
                ),
                array(
                    'header' => 'Bukti',
                    'value' => '$data->no_bukti'
                ),
                array(
                    'header' => 'Keterangan',
                    'value' => '$data->keterangan'
                ),
                array(
                    'header' => 'Kasir',
                    'value' => '$data->nama_pegawai'
                ),
                array(
                    'header' => 'Debet',
                    'value' => 'number_format($data->debit,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Kredit',
                    'value' => 'number_format($data->kredit,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Saldo',
                    'value' => function ($data) use (&$saldo, $model) {
                        if (empty($saldo)) {

                            //if (count((array)$getSaldo)>0){
                            $saldo += $model->getSaldoAwalClosing() + ($data->debit - $data->kredit);
                            //}else{

                            //	$saldo = ($data->debit - $data->kredit);

                            //}								
                        } else {
                            $saldo += ($data->debit - $data->kredit);
                        }

                        return number_format($saldo, 0, "", ".");
                    },
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>

</div>

<br>

<table class="tabel-akun" id="data-footer">
    <tr>
        <td>
            <table class="tabel-akun">
                <tr>
                    <td colspan="4" class="allborder">Rekapitulasi Closing</td>
                </tr>
                <tr>
                    <td width="40px;" class="kiriborder"></td>
                    <td width="140px;">Pendapatan Umum RJ</td>
                    <td style="text-align:right;width:150px;"><span id="rekapclosing-umumrj"></span></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Pendapatan Umum RI</td>
                    <td style="text-align:right;"><span id="rekapclosing-umumri"></span></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Terima Ekses</td>
                    <td style="text-align:right;"><span id="rekapclosing-ekses"></span></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Pengurangan Piutang</td>
                    <td style="text-align:right;"><span id="rekapclosing-piutang"></span></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Saldo Malam</td>
                    <td style="text-align:right;"><span id="rekapclosing-saldomalam"></span></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Debet BCA</td>
                    <td style="text-align:right;"><span id="rekapclosing-debetbca"></span></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Pelunasan Piutang</td>
                    <td style="text-align:right;"><span id="rekapclosing-pelunasanpiutang"></span></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Lain-Lain</td>
                    <td style="text-align:right;"><span id="rekapclosing-lainlain"></span></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder bawahborder"></td>
                    <td class="bawahborder">Total uang cash</td>
                    <td class="bawahborder" style="text-align:right;border-top: 1px solid #333;"><span id="rekapclosing-totalcash"></span></td>
                    <td class="kananborder bawahborder">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="allborder" colspan="4">Rekapitulasi Uang Pelayanan</td>
                </tr>
                <?php
                if (count((array)$nilaiuang)) {
                    $a = 0;
                    foreach ($nilaiuang as $nilai) {
                ?>
                        <tr>
                            <td class="kiriborder"><?php echo ($a == 0) ? 'Cash' : '' ?></td>
                            <td style="text-align:right;padding-right:20px;"><?php echo $nilai->lookup_value; ?> x</td>
                            <td style="text-align:right;"><span id="rekapuangpelayanan-<?php echo $nilai->lookup_value; ?>"></span></td>
                            <td class="kananborder" style="text-align:right;width:120px;"><span id="rekapuangpelayanan-jumlah<?php echo $nilai->lookup_value; ?>"></span></td>
                        </tr>
                <?php
                        $a++;
                    }
                }
                ?>
                <tr>
                    <td class="kiriborder bawahborder">&nbsp;</td>
                    <td class="bawahborder">&nbsp;</td>
                    <td class='bawahborder' style="text-align:right;padding-right:20px">JUMLAH</td>
                    <td class="kananborder bawahborder border-sub" style="text-align:right;"><span id="rekapuangpelayanan-total"></span></td>
                </tr>
            </table>
        </td>
        <td>
            <table class="table-akun">
                <tr>
                    <td class="allborder" colspan="3">Rekapitulasi Pendapatan</td>
                </tr>
                <tr>
                    <td class="kiriborder" width="50px">B</td>
                    <td style="text-align:right;width:120px;"><span id="rekappendapatan-bpjs"></span></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder">A</td>
                    <td style="text-align:right;"><span id="rekappendapatan-asuransi"></span></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder">U</td>
                    <td style="text-align:right;"><span id="rekappendapatan-umum"></span></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder">JUMLAH</td>
                    <td style="text-align:right;" class="border-sub"><span id="rekappendapatan-jumlah"></span></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder" colspan="2"><b>Keterangan Ekses</b></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" class="kananborder bawahborder kiriborder">
                        <table class="tabel-akun" id="rekappendapatan-ekses"></table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>