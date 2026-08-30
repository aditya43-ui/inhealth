
<?php 
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }     
}
?>
<?php $this->renderPartial('application.views.headerReport.headerDefault',array('colspan'=>10)); ?>

<!--<table class="table table-condensed">
    <tr>
        <td>NOTA</td>
        <td>: <?php //echo $modBayar->nopembayaran; ?></td>
        <td>NO PENDAFTARAN</td>
        <td>: <?php //echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>KELAS</td>
        <td>: <?php //echo $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
        <td>TGL PENDAFTARAN</td>
        <td>: <?php //echo $modPendaftaran->tgl_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>PASIEN</td>
        <td>: <?php //echo $modPendaftaran->pasien->nama_pasien; ?></td>
        <td>TGL PEMBAYARAN</td>
        <td>: <?php //echo $modBayar->tglpembayaran; ?></td>
    </tr>
    <tr>
        <td>DOKTER</td>
        <td>: <?php //echo $modPendaftaran->dokter->nama_pegawai; ?></td>
        <td>KASUS PENYAKIT</td>
        <td>: <?php //echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama; ?></td>
    </tr>
</table>-->
<table style="width: 100%; border: none;">
 <tr>
        <td align="center" valig="middle" colspan="3">
            <TABLE FRAME=VOID ALIGN=LEFT CELLSPACING=0 COLS=11 RULES=NONE BORDER=0 width="100%">
                <TBODY>
                        <tr>
                                <td COLSPAN=10 ALIGN=CENTER VALIGN=MIDDLE><B>TANDA BUKTI PEMBAYARAN</B></td>
                                <td ALIGN=LEFT><br></td>
                        </tr>
                        <tr>
                                <td COLSPAN=10 ALIGN=CENTER VALIGN=MIDDLE><B>NOMOR BUKTI <?php echo $modTandaBukti->nobuktibayar;?></B></td>
                                <td ALIGN=LEFT><br></td>
                        </tr>
                        <tr>
                            <td COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT >Bendahara Penerimaan/Bendahara Penerimaan Pembantu Telah menerima uang sebesar  Rp <?php echo number_format($modTandaBukti->jmlpembayaran,0,'','.');?></td>
                        </tr>
                        <tr>
                                <td COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT>Dengan Huruf (<?php echo $format->formatNumberTerbilang($modTandaBukti->jmlpembayaran);?>)</td>
                                
                        </tr>
                        <tr>
                            <td VALIGN=MIDDLE ALIGN=LEFT >Dari Nama                   :    <?php echo $modTandaBukti->darinama_bkm;?></td>
                            <td COLSPAN=1 VALIGN=MIDDLE ALIGN=LEFT></td>
                            <td COLSPAN=9 VALIGN=MIDDLE ALIGN=LEFT>    Alamat                        :    <?php echo $modTandaBukti->alamat_bkm;?></td>       
                        </tr>
                        <tr>
                            <td VALIGN=MIDDLE ALIGN=LEFT >No. Rekam Medik / No. Pendaftaran                   :    <?php echo $modTandaBukti->pembayaran->pendaftaran->pasien->no_rekam_medik."&nbsp;/&nbsp;".$modTandaBukti->pembayaran->pendaftaran->no_pendaftaran ;?></td>      
                        </tr>
                        <tr>
                            <td VALIGN=MIDDLE ALIGN=LEFT >Kelas Pelayanan / Kasus Penyakit                   :    <?php echo $modTandaBukti->pembayaran->pendaftaran->kelaspelayanan->kelaspelayanan_nama."&nbsp;/&nbsp;".$modTandaBukti->pembayaran->pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama ;?></td>      
                        </tr>
                        <tr>
                            <td COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT>Sebagai Pembayaran   :    <?php echo $modTandaBukti->sebagaipembayaran_bkm;?></td>
                                
                        </tr>
                        <tr>
                            <td COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT>Cara Membayar / Penjamin   :    <?php echo $modTandaBukti->pembayaran->pendaftaran->carabayar->carabayar_nama."&nbsp;/&nbsp;".$modTandaBukti->pembayaran->pendaftaran->penjamin->penjamin_nama ;?></td>
                                
                        </tr>
<!--<tr>
                            <td COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT>No. Resep   :    <?php //echo $obatalkespasien->penjualanresep->noresep; ?></td>
                                
                        </tr>-->

                        

<table class="table table-condensed table-striped table-bordered" style='margin-top:5px;'>
                                        <thead>

                                            <tr>
                                                <th>No.</th><th>Uraian</th><th>Keringanan</th><th>JUMLAH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $total = 0;
                                            $kelompoktindakan = '';
                                            $counter = 1;
                                            
                                            $totalSubTotal = 0;
                                            $firstKey = (count((array)$rincianpembayaran['oa']) > 0) ? false : true;
                                            foreach($rincianpembayaran as $i=>$rincian) { 
                                                if (count((array)$rincian) > 0){
                                                    
                                                foreach ($rincian as $key => $value) {
                                                    $biayaLainLain += $value['biayaadministrasi']+$value['biayaservice']+$value['biayakonseling'];
                                                    $value['harga']+=$biayaLainLain;
                                                    if ($i == 'oa'){
                                                        $value['harga'] += $modTandaBukti->biayaadministrasi + $modTandaBukti->biayamaterai;
                                                    }
                                                    if ($firstKey){
                                                        $value['harga'] += $modTandaBukti->biayaadministrasi + $modTandaBukti->biayamaterai;
                                                        $firstKey = false;
                                                    }
                                                    $subTotal = ($value['harga']-$value['discount']);
                                                    $totalSubTotal+= $subTotal;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo ($counter++); ?></td>
                                                        <td><?php echo ((!isset($rincianpembayaran['tindakan'])) ? "Obat Alkes" : $value['kelompoktindakan']); ?><?php //echo '/'.$rincian->daftartindakan_nama ?></td>
<!--<td style="text-align: right;"><?php //echo number_format($value['harga'] ); ?></td>
                                                        <td style="text-align: right;"><?php // echo number_format(1); ?></td>-->
                                                        <td style="text-align: right;"><?php echo number_format($value['discount']); ?></td>
                                                        <td style="text-align: right;"><?php echo number_format($subTotal); ?></td>
                                                    </tr>
                                            <?php }
                                                }
                                            }?>
                                            <tr>
                                                <td style="text-align: right;" colspan="3">TOTAL</td>
                                                <td style="text-align: right;"><?php echo number_format($totalSubTotal); //echo number_format($pembayaran->totaliurbiaya); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;" colspan="3">BIAYA ADMINISTRASI, DLL</td>
                                                <td style="text-align: right;"><?php echo number_format($biayaLainLain + $modTandaBukti->biayaadministrasi + $modTandaBukti->biayamaterai); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;" colspan="3">SUDAH BAYAR</td>
                                                <td style="text-align: right;"><?php echo number_format($modBayar->totalbayartindakan); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;" colspan="3">SISA TAGIHAN</td>
                                                <td style="text-align: right;"><?php echo number_format($modBayar->totalsisatagihan); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>

<table style="width: 100%; border: none;">
<!--<tr><td><?php //echo Yii::app()->user->getState('kabupaten_nama').', '.date('d-M-Y'); ?></td></tr>
    <tr><td>Yang membuat,</td></tr>
    <tr><td>Petugas I</td><td></td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td><?php //echo Yii::app()->user->getState('nama_pegawai'); ?></td><td></tr>-->
    <tr>
        <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
            <td COLSPAN=6 HEIGHT=17 ALIGN=CENTER VALIGN=MIDDLE><B>Mengetahui</B><br>
                <B>Bendahara Penerimaan / Bendahara Penerimaan Pembantu</B>
                <br>
                <br>
                <br>
                <br>
                <br>
                <b><?php echo $pegawai->nama_pegawai; ?></b>
                <br>
<!--<B>NIP. <?php //echo $pegawai->nomorindukpegawai; ?> </B>-->
            </td>
            <td colspan=5 ALIGN=center VALIGN=TOP><B>Pembayar / Penyetor</B></td>
    </tr>
</table>
<?php if (isset($caraPrint)) { ?>
<?php  }else{

        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
//      $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printKwitansi');
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$idPasienadmisi = ((isset($modBayar->pasienadmisi_id)) ? $modBayar->pasienadmisi_id : null);
$idPembayaranPelayanan = $modBayar->pembayaranpelayanan_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&pendaftaran_id=${pendaftaran_id}&idPasienadmisi=${idPasienadmisi}&idPembayaranPelayanan=${idPembayaranPelayanan}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
}?>
