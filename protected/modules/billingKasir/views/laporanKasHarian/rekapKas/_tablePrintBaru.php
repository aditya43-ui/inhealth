<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutTable.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/themes/neon18/assets/css/custom.css');

$imp = ' !important';
$nilaiuang = LookupM::model()->findAllByAttributes(array('lookup_type' => Params::LOOKUPTYPE_NILAI_UANG, 'lookup_aktif' => true), array('order' => 'lookup_urutan ASC'));
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
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    if ($caraPrint == "PDF") {
        $imp = '';
    }
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
                    array('text' => 'Saldo Awal ' . MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->tgl_awal))), 'colspan' => 9, 'options' => array('style' => 'text-align:right;font-size:10px;border-top:1px solid #fff ' . $imp . ';border-right:1px solid #fff ' . $imp . ';border-left:1px solid #fff ' . $imp . '')),
                    array('text' => number_format($model->getSaldoAwalClosing(), 0, "", "."), 'colspan' => 9, 'options' => array('style' => 'text-align:right;border-top:1px solid #fff ' . $imp . ';border-right:1px solid #fff ' . $imp . ';border-left:1px solid #fff ' . $imp . ';')),
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

<table class="tabel-akun" style=" page-break-after: always;">
    <tr>
        <td width="120px">&nbsp;</td>
        <td style="text-align: center;"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-align: center;"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-align: left;">Jombang, <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d')); ?></td>
        <td width="120px">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td style="text-align: center;">Mengetahui</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-align: center;">Menerima</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-align: center;">Memberikan</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td style="text-align: center;">Manajer Keuangan</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-align: center;">Kasir - 2</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-align: center;">Kasir - 1</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="11">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="11">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="11">&nbsp;</td>
    </tr>
    <tr>
        <td style="text-align:right;">(</td>
        <td style="text-align: center;"></td>
        <td style="text-align:left;">)</td>
        <td>&nbsp;</td>
        <td style="text-align:right;">(</td>
        <td style="text-align: center;"></td>
        <td style="text-align:left;">)</td>
        <td>&nbsp;</td>
        <td style="text-align:right;">(</td>
        <td style="text-align: center;"></td>
        <td style="text-align:left;">)</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td style="text-align: center;width:150px" class="border-sub"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-align: center;width:150px" class="border-sub"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-align: center;width:150px" class="border-sub"></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
</table>


<table class="tabel-akun" id="data-footer">
    <tr>
        <td>
            <table class="tabel-akun">
                <tr>
                    <td class="allborder" colspan="4">Rekapitulasi Closing</td>
                </tr>
                <tr>
                    <td class="kiriborder" width="40px;"></td>
                    <td width="140px;">Pendapatan Umum RJ</td>
                    <td style="text-align:right;width:120px;"><?php echo $model->rekapclosing_umumrj; ?></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Pendapatan Umum RI</td>
                    <td style="text-align:right;"><?php echo $model->rekapclosing_umumri; ?></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Terima Ekses</td>
                    <td style="text-align:right;"><?php echo $model->rekapclosing_ekses; ?></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Pengurangan Piutang</td>
                    <td style="text-align:right;"><?php echo $model->rekapclosing_piutang; ?></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Saldo Malam</td>
                    <td style="text-align:right;"><?php echo $model->rekapclosing_saldomalam; ?></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Debet BCA</td>
                    <td style="text-align:right;"><?php echo $model->rekapclosing_debetbca; ?></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Pelunasan Piutang</td>
                    <td style="text-align:right;"><?php echo $model->rekapclosing_pelunasanpiutang; ?></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder"></td>
                    <td>Lain-Lain</td>
                    <td style="text-align:right;"><?php echo $model->rekapclosing_lainlain; ?></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder bawahborder"></td>
                    <td class="bawahborder">Total uang cash</td>
                    <td class="bawahborder" style="text-align:right;border-top: 1px solid #333;"><?php echo $model->rekapclosing_totalcash; ?></td>
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
                            <td style="text-align:right;"><?php echo $model->rekapuangpelayanan_nilaiuang[$nilai->lookup_value]['banyaknya'] ?></td>
                            <td class="kananborder" style="text-align:right;width:120px;"><?php echo $model->rekapuangpelayanan_nilaiuang[$nilai->lookup_value]['jumlahnya'] ?></td>
                        </tr>
                <?php
                        $a++;
                    }
                }
                ?>
                <tr>
                    <td class="kiriborder bawahborder">&nbsp;</td>
                    <td class="bawahborder">&nbsp;</td>
                    <td class="bawahborder" style="text-align:right;padding-right:20px">JUMLAH</td>
                    <td class="kananborder bawahborder" style="text-align:right;" class="border-sub"><?php echo $model->rekapuangpelayanan['total']; ?></td>
                </tr>
            </table>
        </td>
        <td style="vertical-align:top;">
            <table class="tabel-akun">
                <tr>
                    <td class="allborder" colspan="3">Rekapitulasi Pendapatan</td>
                </tr>
                <tr>
                    <td class="kiriborder" width="50px">B</td>
                    <td style="text-align:right;width:120px;"><?php echo $model->rekappendapatan_bpjs ?></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder">A</td>
                    <td style="text-align:right;"><?php echo $model->rekappendapatan_asuransi ?></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder">U</td>
                    <td style="text-align:right;"><?php echo $model->rekappendapatan_umum ?></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td class="kiriborder">JUMLAH</td>
                    <td style="text-align:right;" class="border-sub"><?php echo $model->rekappendapatan_jumlah ?></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" class="kiriborder"><b>Keterangan Ekses</b></td>
                    <td class="kananborder">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" class="kiriborder bawahborder kananborder">
                        <table class="tabel-akun" id="rekappendapatan-ekses">
                            <?php echo $model->rekappendapatan_ekses ?>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>