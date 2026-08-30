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

<table width="100%">
    <tr>
        <td colspan="3">
            <?php echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
        </td>
    </tr>
    <tr>
        <td align="center" valig="middle" colspan="3">
            <TABLE FRAME=VOID ALIGN=LEFT CELLSPACING=0 COLS=11 RULES=NONE BORDER=0 width="100%">
                <TBODY>
                        <TR>
                                <TD COLSPAN=10 ALIGN=CENTER VALIGN=MIDDLE><B>TANDA BUKTI PEMBAYARAN RETUR PENJUALAN </B></TD>
                                <TD ALIGN=LEFT><BR></TD>
                        </TR>
                        <TR>
                                <TD COLSPAN=10 ALIGN=CENTER VALIGN=MIDDLE><B>NOMOR BUKTI <?php echo $modTandaBuktiKeluar->nokaskeluar;?></B></TD>
                                <TD ALIGN=LEFT><BR></TD>
                        </TR>
                        <TR>
                            <TD  COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT >Bendahara Penerimaan/Bendahara Penerimaan Pembantu Telah mengeluarkan uang sebesar  Rp <?php echo number_format($modTandaBuktiKeluar->jmlkaskeluar,0,'','.');?></TD>
                        </TR>
                        <TR>
                                <TD COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT>Dengan Huruf (<?php echo $format->formatNumberTerbilang($modTandaBuktiKeluar->jmlkaskeluar);?>)</TD>
                                
                        </TR>
                        <TR>
                            <TD VALIGN=MIDDLE ALIGN=LEFT >Dari Nama                   :    <?php echo $modTandaBuktiKeluar->namapenerima;?></TD>
                            <TD COLSPAN=1 VALIGN=MIDDLE ALIGN=LEFT></TD>
                            <TD COLSPAN=9 VALIGN=MIDDLE ALIGN=LEFT>    Alamat                        :    <?php echo $returresep->penjualanresep->pendaftaran->pasien->alamat_pasien;?></TD>       
                        </TR>
                        <TR>
                            <TD VALIGN=MIDDLE ALIGN=LEFT >Tgl. Retur                 :    <?php echo $returresep->tglretur;?></TD>      
                        </TR>
                        <TR>
                            <TD VALIGN=MIDDLE ALIGN=LEFT >No. Nota                   :    <?php echo $modTandaBuktiKeluar->nokaskeluar;?></TD>      
                        </TR>
                        <TR>
                            <TD COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT>No. Retur   :    <?php echo $returresep->noreturresep; ?></TD>
                                
                        </TR>
                        <TR>
                            <TD COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT>Sebagai Pembayaran   :    <?php echo $modTandaBuktiKeluar->untukpembayaran;?></TD>
                                
                        </TR>
<!--                        <TR>
                            <TD COLSPAN=11 VALIGN=MIDDLE ALIGN=LEFT>No. Resep   :    <?php //echo $obatalkespasien->penjualanresep->noresep; ?></TD>
                                
                        </TR>-->

                        

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
                                             $oaSudahBayar = OasudahbayarT::model()->findAllByAttributes(array('pembayaranpelayanan_id'=>$rincianpembayaran->pembayaranpelayanan_id));
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
                                                <td style="text-align: right;"><?php echo "Rp. ".number_format($totalSubTotal); //echo number_format($pembayaran->totaliurbiaya); ?></td>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                        
                        <TR>
                            <TD COLSPAN=11 VALIGN=MIDDLE HEIGHT=20 ALIGN=LEFT>Tanggal Diterima Uang   :   <?php echo $modTandaBuktiKeluar->tglkaskeluar;?></TD>
                                
                        </TR>
                        <TR>
                                <TD ALIGN=LEFT COLSPAN=11><BR></TD>
                             
                        </TR>
                        <TR>
                            <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                                <TD COLSPAN=6 HEIGHT=17 ALIGN=CENTER VALIGN=MIDDLE><B>Mengetahui</B><br/>
                                    <B>Bendahara Penerimaan / Bendahara Penerimaan Pembantu</B>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <b><?php echo $pegawai->nama_pegawai; ?></b>
                                    <br/>
<!--                                    <B>NIP. <?php //echo $pegawai->nomorindukpegawai; ?> </B>-->
                                </TD>
                                <TD colspan=5 ALIGN=center VALIGN=TOP><B>Pembayar / Penyetor</B></TD>
                        </TR>
                        <TR>
                                <TD COLSPAN=5 HEIGHT=17 ALIGN=CENTER VALIGN=MIDDLE></TD>
                                <TD ALIGN=LEFT><BR></TD>
                                <TD ALIGN=LEFT><BR></TD>
                                <TD ALIGN=LEFT><BR></TD>
                                <TD ALIGN=LEFT><BR></TD>
                                <TD ALIGN=LEFT><BR></TD>
                                <TD ALIGN=LEFT><BR></TD>
                        </TR>
                        <TR>
                                <TD HEIGHT=17 COLSPAN=11 ALIGN=LEFT><BR></TD>
                        </TR>
                        <TR>
                                <TD HEIGHT=17 COLSPAN=11 ALIGN=LEFT><BR></TD>
                        </TR>
                        <TR>
                                <TD HEIGHT=17 COLSPAN=11 ALIGN=LEFT><BR></TD>
                        </TR>
                        <TR>
                                <TD HEIGHT=17 ALIGN=LEFT><BR></TD>
                                <TD STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><BR></TD>
                                <TD STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><BR></TD>
                                <TD STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><BR></TD>
                                <TD STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><BR></TD>
                                <TD ALIGN=LEFT><BR></TD>
                                <TD ALIGN=LEFT><BR></TD>
                                <TD STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><BR></TD>
                                <TD STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><BR></TD>
                                <TD STYLE="border-bottom: 1px solid #000000" ALIGN=LEFT><BR></TD>
                                <TD ALIGN=LEFT><BR></TD>
                        </TR>
                        <TR>
                                <TD HEIGHT=17 ALIGN=LEFT COLSPAN=7><BR></TD>
                                <TD ALIGN=LEFT COLSPAN=4></TD>
                                
                        </TR>
                </TBODY>
        </TABLE>
        </td>
    </tr>
</table>