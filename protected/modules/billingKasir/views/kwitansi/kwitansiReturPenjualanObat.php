<?php $format = new MyFormatter; ?>
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
<style>
    .table th, .table td{
        line-height: 5px;
    }
    </style>

<table style="width: 100%; border: none;">
    <tr>
        <td colspan="3">
            <?php echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
        </td>
    </tr>
    <tr>
        <td align="center" valig="middle" colspan="3">
            <TABLE FRAME=VOID ALIGN=LEFT CELLSPACING=0 COLS=11 RULES=NONE BORDER=0 width="100%">
                <TBODY>
                        <tr>
                                <td COLSPAN=10 ALIGN=CENTER VALIGN=MIDDLE><B>TANDA BUKTI PEMBAYARAN RETUR PENJUALAN </B></td>
                                <td ALIGN=LEFT><br></td>
                        </tr>
                        <tr>
                                <td COLSPAN=10 ALIGN=CENTER VALIGN=MIDDLE><B>NOMOR BUKTI <?php echo $modTandaBuktiKeluar->nokaskeluar;?></B></td>
                                <td ALIGN=LEFT><br></td>
                        </tr>
                        <tr>
                            <td COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT >Bendahara Penerimaan/Bendahara Penerimaan Pembantu Telah mengeluarkan uang sebesar  Rp <?php echo number_format($modTandaBuktiKeluar->jmlkaskeluar,0,'','.');?></td>
                        </tr>
                        <tr>
                                <td COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT>Dengan Huruf (<?php echo $format->formatNumberForPrint($modTandaBuktiKeluar->jmlkaskeluar);?>)</td>
                                
                        </tr>
                        <tr>
                            <td VALIGN=MIDDLE ALIGN=LEFT >Dari Nama                   :    <?php echo $modTandaBuktiKeluar->namapenerima;?></td>
                            <td COLSPAN=1 VALIGN=MIDDLE ALIGN=LEFT></td>
                            <td COLSPAN=9 VALIGN=MIDDLE ALIGN=LEFT>    Alamat                        :    <?php echo isset($returresep->penjualanresep->pendaftaran->pasien->alamat_pasien) ? $returresep->penjualanresep->pendaftaran->pasien->alamat_pasien:'-';?></td>       
                        </tr>
                        <tr>
                            <td VALIGN=MIDDLE ALIGN=LEFT >Tgl. Retur                 :    <?php echo isset($returresep->tglretur)?$returresep->tglretur:'-';?></td>      
                        </tr>
                        <tr>
                            <td VALIGN=MIDDLE ALIGN=LEFT >No. Nota                   :    <?php echo $modTandaBuktiKeluar->nokaskeluar;?></td>      
                        </tr>
                        <tr>
                            <td COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT>No. Retur   :    <?php echo isset($returresep->noreturresep)?$returresep->noreturresep:'-'; ?></td>
                                
                        </tr>
                        <tr>
                            <td COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT>Sebagai Pembayaran   :    <?php echo $modTandaBuktiKeluar->untukpembayaran;?></td>
                                
                        </tr>
<!--<tr>
                            <td COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT>No. Resep   :    <?php //echo $obatalkespasien->penjualanresep->noresep; ?></td>
                                
                        </tr>-->

                        

                        <tr>
                            <td colspan="11">
                                <table class="table table-condensed table-striped table-bordered" style='margin-top:5px;'>
                                        <thead>

                                            <tr>
                                                <th>No.</th><th>Uraian</th><th>Total Harga Jual </th><th>Administrasi Retur</th><th>Total Harga Retur</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            // $rincianpembayaran = null;
                                             $oaSudahBayar = OasudahbayarT::model()->findAllByAttributes(array('pembayaranpelayanan_id'=>isset($rincianpembayaran->pembayaranpelayanan_id) ? $rincianpembayaran->pembayaranpelayanan_id:null ));
                                            $total = 0;
                                            $kelompoktindakan = '';
                                            $counter = 1;
                                            
                                            $totalSubTotal = 0;
//                                            foreach($modReturPenjualan as $i=>$rincian) { 
//                                                    $biayaLainLain += $value['biayaadministrasi']+$value['biayaservice']+$value['biayakonseling'];
//                                                    $value['harga']+=$biayaLainLain;
//                                                    if ($i == 'oa'){
//                                                        $value['harga'] += $model->biayaadministrasi +$model->biayamaterai;
//                                                    }
//                                                    if ($firstKey){
//                                                        $value['harga'] += $model->biayaadministrasi +$model->biayamaterai;
//                                                        $firstKey = false;
//                                                    }
                                                    $subTotal = ($modReturPenjualan->totaloaretur -  $modReturPenjualan->biayaadministrasi);
                                                    $totalSubTotal+= $subTotal;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo ($counter++); ?></td>
                                                        <td><?php echo "Obat Alkes"  ?><?php //echo '/'.$rincian->daftartindakan_nama ?></td>
                                                        <td style="text-align: right;"><?php echo number_format($modReturPenjualan->totaloaretur ); ?></td>
                                                        <td style="text-align: right;"><?php echo number_format($modReturPenjualan->biayaadministrasi ); ?></td>
                                                        <td style="text-align: right;"><?php echo number_format($subTotal); ?></td>
                                                    </tr>
                                            <?php 
                                                
                                           // }?>
                                            <tr>
                                                <td style="text-align: right;" colspan="4">TOTAL</td>
                                                <td style="text-align: right;"><?php echo "Rp ".number_format($totalSubTotal); //echo number_format($pembayaran->totaliurbiaya); ?></td>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                        
                        <tr>
                            <td COLSPAN=11 VALIGN=MIDDLE HEIGHT=20 ALIGN=LEFT>Tanggal Diterima Uang   :   <?php echo $modTandaBuktiKeluar->tglkaskeluar;?></td>
                                
                        </tr>
                        <tr>
                                <td ALIGN=LEFT COLSPAN=11><br></td>
                             
                        </tr>
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
                        <tr>
                                <td COLSPAN=5 HEIGHT=17 ALIGN=CENTER VALIGN=MIDDLE></td>
                                <td ALIGN=LEFT><br></td>
                                <td ALIGN=LEFT><br></td>
                                <td ALIGN=LEFT><br></td>
                                <td ALIGN=LEFT><br></td>
                                <td ALIGN=LEFT><br></td>
                                <td ALIGN=LEFT><br></td>
                        </tr>
                        <tr>
                                <td HEIGHT=17 COLSPAN=11 ALIGN=LEFT><br></td>
                        </tr>
                        <tr>
                                <td HEIGHT=17 COLSPAN=11 ALIGN=LEFT><br></td>
                        </tr>
                        <tr>
                                <td HEIGHT=17 COLSPAN=11 ALIGN=LEFT><br></td>
                        </tr>
                        <tr>
                                <td HEIGHT=17 ALIGN=LEFT><br></td>
                                <td STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><br></td>
                                <td STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><br></td>
                                <td STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><br></td>
                                <td STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><br></td>
                                <td ALIGN=LEFT><br></td>
                                <td ALIGN=LEFT><br></td>
                                <td STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><br></td>
                                <td STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><br></td>
                                <td STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><br></td>
                                <td ALIGN=LEFT><br></td>
                        </tr>
                        <tr>
                                <td HEIGHT=17 ALIGN=LEFT COLSPAN=7><br></td>
                                <td ALIGN=LEFT COLSPAN=4></td>
                                
                        </tr>
                </TBODY>
        </TABLE>
        </td>
    </tr>
</table>