<style>
    .grid{
        font-size:11px;
        font-family: tahoma;
    }
</style>
<div align="center" style="font-family: tahoma"><b> KUITANSI</b></div> <br>
<table cellspacing=0 width="100%" border="0" class="grid">
    <tbody>

        <tr style="border:2px;">
            <td width="15%"> Nama Pasien</td>
            <td width="2%">:</td>
            <td align="left"><?php echo $modTandaBukti->pembayaran->pendaftaran->pasien->nama_pasien; ?></td>
        </tr>
        <tr>
            <td> Alamat</td>
            <td>:</td>
            <td width="50%"><?php echo $modTandaBukti->pembayaran->pendaftaran->pasien->alamat_pasien; ?></td>
            <td width="13%"> No. Lab</td>
            <td width="2%">:</td>
            <td><?php echo $modTandaBukti->pembayaran->pendaftaran->no_pendaftaran; ?></td>
        </tr>
        <tr>
            <td> Umur</td>
            <td>:</td>
            <td><?php echo $modTandaBukti->pembayaran->pendaftaran->umur; ;?></td>
            <td> Tgl. Pembayaran</td>
            <td>:</td>
            <td><?php echo $modTandaBukti->pembayaran->tglpembayaran; ;?></td>
        </tr>
    </tbody>
</table>
<div>&nbsp;</div>
<table cellspacing=0 width="100%" border="0" class="grid">
    <tr>
        <td width="15%"> Sudah Terima Dari</td>
        <td width="2%">:</td>
        <td align="left"><?php echo $modTandaBukti->darinama_bkm;?></td>
    </tr>
    <tr>
        <td> Banyak Uang</td>
        <td>:</td>
        <td><?php echo $format->formatNumberTerbilang($modTandaBukti->jmlpembayaran);?></td>
    </tr>
    <tr>
        <td> untuk Pembayaran</td>
        <td>:</td>
        <td><?php echo $modTandaBukti->sebagaipembayaran_bkm;?></td>
    </tr>
</table>
<table cellspacing=0 width="100%" border="0" class="grid">
    <tbody>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="50%" align="center">
                <div style="text-align: center;">
                    <div align="center" style="border:1px solid #000; width:200px;padding:10px;float:left;margin-left:-35px;">
                        <b>Rp <?php echo number_format($modTandaBukti->jmlpembayaran,0,'','.');?></b>
                    </div>                                
                </div>
            </td>
            <td align="center">
                <div style="text-align: center;">
                    <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".$modTandaBukti->tglbuktibayar;?></div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>
                        <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                        <b>(<?php echo $pegawai->nama_pegawai; ?>)</b>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>