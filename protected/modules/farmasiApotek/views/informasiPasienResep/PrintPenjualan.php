<?php


$style = 'margin-left:auto; margin-right:auto;';
if (isset($caraPrint)) {
    if ($caraPrint == "EXCEL")
        $style = "cellpadding='10',cellspasing='6', width='100%'";
    $td = "width='100%'";
} else {
    $style = "style='margin-left:auto; margin-right:auto;'";
}

?>
<style>
    body{
        font-size: 9pt;
    }

    @page {
        font-size: 9pt !important;
        margin: 0;
    }

    @media print {

        html,
        body {
            margin: 5mm;
            font-family: "Arial" !important;
            font-size: 9pt;
            /* width: 21cm; */
            height: 7.5cm;
            color:black;
        }

        div.footer {
            position: fixed;
            bottom: 0;
        }

        .page-break {
            display: block;
            page-break-before: always;
        }
    }
</style>

<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="100%" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                                    ?></div>
            </td>
        </tr>
    </thead>
    <!-- <tbody>
        <tr>
            <td valign="LEFT" align="LEFT" colspan=" 9">
                <b>
                    <font color="black" ><b><?php // echo strtoupper($modProfilRs->nama_rumahsakit); ?></b></font>
                </b>
            </td>
        </tr>
        <tr>
            <td valign="LEFT" align="LEFT" colspan=" 9">
                <font color="black" ><?php // echo $modProfilRs->alamatlokasi_rumahsakit; ?></font>
            </td>
        </tr>
        <tr>
            <td valign="LEFT" align="LEFT" colspan=" 9">
                <font color="black" >Telp. <?php // echo $modProfilRs->no_telp_profilrs; ?> Fax. / <?php //echo $modProfilRs->no_faksimili?></font>
            </td>
        </tr>
        <tr>
            <td height="2" style="border-bottom: 1px solid #000000" colspan=" 10"></td>
        </tr>
        <tr>
            <td valign="LEFT" align="LEFT" colspan=" 10">
                <font color="black">
                    <h3></h3>
                </font>
            </td>
        </tr>
        <tr>
            <td valign="LEFT" align="LEFT" colspan=" 10"></td>
        </tr>
    </tbody> -->
</table>


<table width="100%" <?php echo $style; ?> cellspacing="0" cellpadding="0">
<tr>
                            <td width='22%'>
                                <label class='control-label'>No. RM / No. Pendaftaran</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modPendaftaran->pasien->no_rekam_medik; ?> / <?php echo $modPendaftaran->no_pendaftaran; ?></td>
                            <td width='15%'>
                                <label class='control-label'>No. Resep</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modReseptur->noresep; ?></td>
                        </tr>
                        <tr>
                            <td width='15%'>
                                <label class='control-label'>Nama Pasien</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
                            <td width='20%'>
                                <label class='control-label'>Dokter Penulis Resep</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modReseptur->GetNamaLengkapPegawai($modReseptur->pegawai_id); ?></td>
                        </tr>
                        <tr>
                            <td width='15%'>
                                <label class='control-label'>Tgl. Lahir/Umur</label>
                            </td>
                            <td>:</td>
                            <td width='35%'><?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir) ?> / <?php echo $modPendaftaran->umur; ?></td>
                            <td width='15%'>
                                <label class='control-label'>Tanggal Resep</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modReseptur->tglreseptur; ?></td>
                        </tr>
                        <tr>
                            <td width='15%'>
                                <label class='control-label'>Alamat</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modPendaftaran->pasien->alamat_pasien; ?></td>
                            <td width='15%'>
                                <label class='control-label'>Ruangan</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modReseptur->ruanganreseptur->ruangan_nama; ?></td>
                        </tr>

</table>

<?php //if ($modPenjualan->is_resepemergency == false) { 
    //echo "<br>";
//}?>
<table width="100%" <?php echo $style; ?>>

</table>
<style>
    .iter {
        border-top: 2px solid #000000;
        padding: 5px;
        width: 50%;
    }

    .iter legend {
        padding: 3px;
        background: #ffffff;
        color: #000000;
        text-align: center;
        width: 15%;
        margin-left: 85%;
    }
</style>
<?php foreach ($data as $i => $detail) { ?>
    <?php if ($detail['racikan_id'] == Params::RACIKAN_ID_NONRACIKAN) { ?>
        <table width="100%" cellspacing="0.8" cellpadding="0.8">
            <tbody>
                <tr>
                    <td><b>R/ <?php echo $detail['rke']; ?></b></td>
                </tr>
                <tr>
                    <td style="border-left: 0px; border-right: 0px;">
                        <?php foreach ($detail['det'] as $ii => $item) { ?>
                            <?php echo $item['obatalkes_nama'] .' ---> '. $item['qty_oa'] . ' ' . $item['satuankecil_nama']; ?>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo "∫ ".$item['etiket']; ?></td>
                </tr>
                <tr>
                    <td><?php echo $item['keterangan']; ?></td>
                </tr>
            </tbody>
        </table>
    <?php } else { 
        ?>
        <table width="100%" cellspacing="0.8" cellpadding="0.8">
            <tbody>
                <tr>
                    <td><b>R/ <?php echo $detail['rke']; ?></b></td>
                </tr>
                <tr>
                    <td style="border-left: 0px; border-right: 0px;">
                        <?php foreach ($detail['det'] as $ii => $item) { ?> 
                            <?php echo $item['obatalkes_nama'] .' >> '. $item['permintaan_oa'] . ' ' . ' >> '. $item['qty_oa'] . ' ' . $item['satuankecil_nama']; ?> <br>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <!-- <td><?php //echo $detail['signa_oa'] . ' ' . $detail['satuansediaan'] . ' No. ' .CustomFunction::Romawi($detail['jmlkemasan_oa'])?></td> -->
                    <td style="font-weight: bold;"><?php echo "m.f.l.a. " . $detail['satuansediaan'] . " No " . CustomFunction::Romawi(ceil($detail['jmlkemasan_oa'])); ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;"><?php echo empty($item['etiket']) ? "" : ("∫ " . $item['etiket']); ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;"><?php echo empty($item['keterangan']) ? "-" : $item['keterangan']; ?></td>
                </tr>
            </tbody>
        </table>
    <?php } ?>
    
<table width="100%">
    <tbody>
        <tr>
            <td height="2" style="border-bottom: 1px solid #000000" colspan=" 10"></td>
        </tr>

    </tbody>
</table>
<?php } ?>
            <?php
            //$modPegawai = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);
            //$modCari = PegawaiM::statusTTDDigital($modPenjualan->pegawai_id);
            //$url = '';
            //if ($modCari == 1) {
            //    if (!empty($modPegawai->ttd_pegawai)) {
            //        $url = Params::urlPegawaiDirectory() . $modPegawai->ttd_pegawai; ?>
                    <!-- <img src="<?php //$url ?>" width="20mm" height="20mm"> -->
            <?php  //}
            //}  ?>
<br />
<style>
    .top-left {
        vertical-align: top;
}
</style>
<table>
    <tr>
        <?php $date = date('Y-m-d'); ?>
        <td>Dibuat di : <?php echo $modProfilRs->kabupaten->kabupaten_nama; ?>, <?php echo MyFormatter::formatDateTimeForUser($date); ?></td>
    </tr>
    <tr>
        <td>
            Resume medis elektronik ini syah tanpa tanda tangan, UU Pradok No 29/2004 Penjelasan Ps 46(3)
        </td>
    </tr>
</table>

<?php
if (isset($_GET['frame'])) {
    echo CHtml::Link("<i class='entypo-print'></i> Print Resep Penjualan", '#', array('class' => 'btn btn-success', "rel" => "tooltip", "title" => "Klik untuk print resep dari dokter", 'onclick' => 'printRecordTerakhir(\'PDF\')'));
    $urlPrintPenjualan = Yii::app()->createAbsoluteUrl($this->module->id . '/informasiPasienResep/printResepPenjualan&penjualanresep_id='.$_GET['penjualanresep_id']);
    $js = <<< JSCRIPT
    function printRecordTerakhir(caraPrint)
    {
        window.open("${urlPrintPenjualan}&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
    JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
}?>