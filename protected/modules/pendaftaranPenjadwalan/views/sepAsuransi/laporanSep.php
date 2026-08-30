<style>
    th,
    td,
    div {
        font-family: Arial;
        font-size: 9.7pt;
    }

    .tandatangan {
        vertical-align: bottom;
        text-align: center;
    }

    body {
        width: 10cm;
        height: 11cm;
    }

    .identitas {
        line-height: 10px;
    }
</style>
<?php
$format = new MyFormatter;
echo $this->renderPartial('application.views.headerReport.headerRincian');
?>
<table class="identitas" width="100%">
    <tr>
        <td>Kode INA-CBG</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->kdinacbg) ? $laporanSep->kdinacbg : ""; ?></td>

        <td>Nama INA-CBG</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->nminacbg) ? $laporanSep->nminacbg : ""; ?></td>
    </tr>
    <tr>
        <td>Kode Severity</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->kdseverity) ? $laporanSep->kdseverity : ""; ?></td>

        <td></td>
        <td>:</td>
        <td></td>
    </tr>
    <tr>
        <td>By Tagihan</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->bytagihan) ? $laporanSep->bytagihan : 0; ?></td>

        <td>By Tarif RS</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->bytarifrs) ? $laporanSep->bytarifrs : 0; ?></td>
    </tr>
    <tr>
        <td>By Tarif Gruper</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->bytarifgruper) ? $laporanSep->bytarifgruper : 0; ?></td>

        <td>By Top Up</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->bytopup) ? $laporanSep->bytopup : 0; ?></td>
    </tr>
    <tr>
        <td>Jenis Pelayanan</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->jnspelayanan) ? $laporanSep->jnspelayanan : ""; ?></td>

        <td>No. SEP</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->nosep) ? $laporanSep->nosep : ""; ?></td>
    </tr>
    <tr>
        <td>No. Medical Record</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->nomr) ? $laporanSep->nomr : ""; ?></td>

        <td>Nama</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->nama) ? $laporanSep->nama : ""; ?></td>
    </tr>
    <tr>
        <td>No. Kartu Asuransi</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->nokartu) ? $laporanSep->nokartu : ""; ?></td>

        <td></td>
        <td>:</td>
        <td></td>
    </tr>
    <tr>
        <td>Kode Status SEP</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->kdstatsep) ? $laporanSep->kdstatsep : ""; ?></td>

        <td>Nama Status SEP</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->nmstatsep) ? $laporanSep->nmstatsep : ""; ?></td>
    </tr>
    <tr>
        <td>Tanggal Pulang</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->tglpulang) ? $format->formatDateTimeForUser($laporanSep->tglpulang) : ""; ?></td>

        <td>Tanggal SEP</td>
        <td>:</td>
        <td><?php echo isset($laporanSep->tglsep) ? $format->formatDateTimeForUser($laporanSep->tglsep) : ""; ?></td>
    </tr>
</table>

<br />
<br />
<table>
    <tr align="right">
        <td colspan="5"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td class="tandatangan">Petugas</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr align="right">
        <td colspan="5"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td class="tandatangan" style="height: 50px;">.........................</td>
    </tr>
</table>
<?php
if (isset($_GET['frame'])) {
    echo CHtml::link(Yii::t('mds', '{icon} Print Laporan SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();"));
?>
    <script type='text/javascript'>
        /**
         * print
         */
        function print() {
            window.open("<?php echo $this->createUrl("lihatLaporanSEP", array("sep_id" => $_GET['sep_id'])) ?>", "", 'location=_new, width=1024px');
        }
    </script>
<?php
}
?>