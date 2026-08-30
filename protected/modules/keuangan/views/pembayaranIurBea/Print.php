<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
    //echo $this->renderPartial('application.views.headerReport.headerDefaultV3',array('judulLaporan'=>$judulLaporan));  
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:12px;
    }

    td .tengah{
       text-align: center;  
    }

    .text tr td{
        font-size:14px;
        text-align: center;
        font-weight:bold;
    }
');
?>
<?php 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
?>
<table>
    <thead>
        <tr>
             <!-- <td>
                <div class="header"><?php
                    //echo $this->renderPartial('application.views.headerReport.headerDefaultV3', array());
                    ?></div>
            </td> -->
            <td style="padding-left:350px;" valign="MIDDLE" align="right" colspan=" 9">
                <br>
                <!-- <b><font size="5" color="black" face="Liberation Serif">INSTALASI FARMASI APOTEK</font></b><br> -->
                <b><font size="4" color="black" face="Liberation Serif"><b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b></font></b><br>
                <font color="black" face="Liberation Serif"><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?></font><br>
                <font color="black" face="Liberation Serif">Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?></font>
            </td>
        </tr>
    </thead>
</table>
<br>
<table class="text" width="100%">
    <tr>
        <td><?php echo $judulLaporan;?></td>
    </tr>
</table>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table style="width: 100%; border: none;">
                <tr>
                    <td>Tanggal Penerimaan</td><td>:</td>
                    <td width="100%">
                        <?php echo CHtml::encode($model->tglpenerimaan); ?>
                    </td>
                    <td>Harga Satuan</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode(isset($model->hargasatuan) ? MyFormatter::formatNumberForPrint($model->hargasatuan) : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>No. Penerimaan</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode(isset($model->nopenerimaan) ? $model->nopenerimaan : "-"); ?>
                    </td>
                    <td>Total Harga</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->totalharga)); ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap>Kelompok Transaksi</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($model->kelompoktransaksi); ?>
                    </td>
                    <td nowrap>Keterangan Penerimaan</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode(isset($model->keterangan_penerimaan) ? $model->keterangan_penerimaan : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Jenis Penerimaan </td><td>:</td>
                    <td>
                        <?php 
						$p = JenispenerimaanM::model()->findByPk($model->jenispenerimaan_id);
						echo CHtml::encode($p->jenispenerimaan_nama); ?>
                    </td>
                    <td>Nama Penandatangan </td><td>:</td>
                    <td nowrap>
                        <?php echo CHtml::encode(isset($model->namapenandatangan) ? $model->namapenandatangan : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Volume  </td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($model->volume).' '.CHtml::encode($model->satuanvol); ?>
                    </td>
                </tr>
                   
            </table>            
        </td>
    </tr>
</table><br><br><br><br>

<?php if (count((array)$modUraian) != 0): ?>

<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>Uraian</th>
            <th>Volume</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($modUraian as $i => $uraian) { ?>
        <tr>
            <td>
                <?php echo isset($uraian->uraiantransaksi)?$uraian->uraiantransaksi:'-'; ?>
            </td>
            <td style="text-align: right;">
                <?php echo isset($uraian->volume)?$uraian->volume:'-'; ?>
            </td>
            <td>
                <?php echo isset($uraian->satuanvol)?$uraian->satuanvol:'-'; ?>
            </td>
            <td style="text-align: right;">
                <?php echo isset($uraian->hargasatuan)?  MyFormatter::formatNumberForPrint($uraian->hargasatuan):'-'; ?>
            </td>
            <td style="text-align: right;">
                <?php echo isset($uraian->totalharga)?MyFormatter::formatNumberForPrint($uraian->totalharga):'-'; ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php endif; ?>
<?php
$modPegawaiKeluar = PegawaiM::model()->findByPk($model->pegawai_id);
// $modPegawaiKetahui = PegawaiM::model()->findByPk($model->pegawaimengetahui_id);
?>
<table width='100%' style="text-align: center;">
    <tr>
        <td>Pegawai Pengirim</td>
        <td>Pegawai Penerima</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>(<?php echo !empty($modTanda->darinama_bkm)  ? $modTanda->darinama_bkm: "______________________" ?>)</td>
        <td>(<?php echo !empty($modPegawaiKeluar->namaLengkap)?$modPegawaiKeluar->namaLengkap :'-'; ?>)</td>
    </tr>
</table>