<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td align="center" valig="middle" colspan="3">
            <table align="center" cellspacing=0 width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" align="center">
                            <div align="center" style="font-size:18pt;text-decoration: underline;"><b>KUITANSI</b></div>
                        </td>
                    </tr>                    
                    <tr>
                        <td width="20%">No. Kuitansi</td>
                        <td width="2%">:</td>
                        <td align="left"><?php echo $modTandaBukti->nobuktibayar;?></td>
                    </tr>
                    <tr>
                        <td>No, Penerimaan / Jenis Penerimaan</td>
                        <td>:</td>
                        <td><?php echo $modPenerimaanUmum->nopenerimaan;?> / <?php echo $modPenerimaanUmum->jenispenerimaan->jenispenerimaan_nama; ?></td>
                    </tr>
                    <tr>
                        <td>Sudah Terima Dari</td>
                        <td>:</td>
                        <td><?php echo $modTandaBukti->darinama_bkm;?></td>
                    </tr>
                    <tr>
                        <td>Banyak Uang</td>
                        <td>:</td>
                        <td class="terbilang">
                            <?php
                                if($modTandaBukti->jmlpembayaran == 0)
                                {
                                    echo '-';
                                }else{
                                    echo strtoupper(MyFormatter::formatNumberTerbilang($modTandaBukti->jmlpembayaran)) . ' RUPIAH';
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Untuk Pembayaran</td>
                        <td>:</td>
                        <td><?php echo $modTandaBukti->sebagaipembayaran_bkm;?><?php //echo date('d/m/Y',  strtotime($modPendaftaran->tgl_pendaftaran));?></td>
                    </tr>
                </tbody>
            </table>
            <table frame=void align=left cellspacing=0 cols=11 rules=none border=0 width="100%">
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="60%" align="center">
                            <div style="text-align: center;">
                                <br>
                                <div align="center" style="border:1px solid #000000;width:200px;padding:5px;" class="uang">
                                    Rp <?php echo number_format($modTandaBukti->jmlpembayaran,0,'','.');?>,-
                                </div>
                                <br><br>
                                <div colspan="2" class="catatan">
                                    Catatan : untuk pembayaran melalui Cheque / Bilyet Giro (BG)<br>
                                    Belum dianggap lunas apabila Cheque/Bilyet Giro (BG) Belum Diuangkan<br>
                                    <i>*Kuitansi ini sah bila ada tandatangan petugas dan cap <?php echo $data->nama_rumahsakit; ?>*</i>
                                </div>
                            </div>
                        </td>
                        <td class="tandatangan">

                            <?php echo Yii::app()->user->getState('kabupaten_nama') ?>, 
                            <?php 
	                            echo MyFormatter::formatDateTimeId($modTandaBukti->tglbuktibayar);

                            ?>
                           
                            <br>
                            Petugas RS,<br><br><br><br><br>                             
                            <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                            <b><?php echo $pegawai->nama_pegawai; ?></b>
                                
                            <?php echo CHtml::hiddenField('isprint',$modTandaBukti->isprint); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <?php if (!isset($caraPrint)){ ?>
        <tr>
            <td colspan="3" style="border-bottom:1px solid #000000;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">Printed at <?php echo date("d/m/y h:m:s");?></td>
        </tr>   
    <?php } ?>
</table>
