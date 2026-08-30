<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>

<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
');
?>  

<style>
    body {
        color: black;
    }
	.det td, .det th {
		border: 1px solid black;
		padding: 2px;
	}
    .judulcontent{
        text-align: center !important;
    }

    .tblpadding td{
     padding: 5px;
    }
</style>

<?php
if(!$modFakturPembelianDetail){
    echo "Data tidak ditemukan"; exit;
}
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    
    
    //echo $this->renderPartial($this->path_view.'_headerPrint'); 
	//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judul_print, 'periode'=>'', 'colspan'=>10)); 
}else{
    echo "<style>.judulcontent{font-size:12pt;text-align:center;font-weight:bold}</style>";
    //echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>'RINCIAN FAKTUR PEMBELIAN', 'deskripsi'=>"", 'colspan'=>10));
}
?>
<table width="100%">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <div class="judulcontent"> RINCIAN FAKTUR PEMBELIAN OBAT DAN ALKES </div>
                    <br />
                        <table width="100%">   
                            <tr>
                                <td width="50%" valign="top">
                                    <table width="100%" class="tblpadding">
                                        <tr>
                                            <td width="200px">No Permintaan</td>
                                            <td> : <?php echo (!empty($modFakturPembelian->penerimaanbarang->permintaanpembelian)? $modFakturPembelian->penerimaanbarang->permintaanpembelian->nopermintaan : ""); ?></td>
                                        </tr>
                                         <tr>
                                            <td>No Penerimaan</td>
                                            <td> : <?php echo $modFakturPembelian->penerimaanbarang->noterima; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tgl. Penerimaan</td>
                                            <td> : <?php echo MyFormatter::formatDateTimeForUser($modFakturPembelian->penerimaanbarang->tglterima); ?></td>
                                        </tr>
                                        <tr>
                                            <td>No Faktur</td>
                                            <td> : <?php echo $modFakturPembelian->nofaktur; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tgl. Faktur</td>
                                            <td> : <?php echo MyFormatter::formatDateTimeForUser($modFakturPembelian->tglfaktur); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tgl. Jatuh Tempo</td>
                                            <td> : <?php echo (!empty($modFakturPembelian->tgljatuhtempo)? MyFormatter::formatDateTimeForUser($modFakturPembelian->tgljatuhtempo): "-"); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan</td>
                                            <td> : <?php echo $modFakturPembelian->keteranganfaktur; ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="50%" valign="top">
                                    <table width="100%" class="tblpadding">
                                        <tr>
                                            <td width="200px">Total Harga</td>
                                            <td> : Rp. <?php echo (!empty($modFakturPembelian->totharganetto)? MyFormatter::formatNumberForPrint($modFakturPembelian->totharganetto, 2): "-"); ?></td>
                                        </tr>
                                         <tr>
                                            <td>Total Keringanan</td>
                                            <td> : Rp. <?php echo (!empty($modFakturPembelian->jmldiscount)? MyFormatter::formatNumberForPrint($modFakturPembelian->jmldiscount, 2): "-"); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total PPN</td>
                                            <td> : Rp. <?php echo (!empty($modFakturPembelian->totalpajakppn)? MyFormatter::formatNumberForPrint($modFakturPembelian->totalpajakppn, 2): "-"); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total PPh</td>
                                            <td> : Rp. <?php echo (!empty($modFakturPembelian->totalpajakpph)? MyFormatter::formatNumberForPrint($modFakturPembelian->totalpajakpph, 2): "-"); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Keseluruhan</td>
                                            <td> : Rp. <?php echo (!empty($modFakturPembelian->totalhargabruto)? MyFormatter::formatNumberForPrint($modFakturPembelian->totalhargabruto, 2): "-"); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Uang Muka</td>
                                            <td> : Rp. <?php echo (!empty($modFakturPembelian->jmluangmukabeli)? MyFormatter::formatNumberForPrint($modFakturPembelian->jmluangmukabeli, 2): "-"); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Harga Netto</td>
                                            <td> : Rp. <?php echo (!empty($modFakturPembelian->totalhutangusaha)? MyFormatter::formatNumberForPrint($modFakturPembelian->totalhutangusaha, 2): "-"); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
    </table><br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class="det">
        <thead class="border">
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">Kode</th>
            <th style="text-align: center;">Nama Obat & Alkes</th>            
            <th style="text-align: center;">Jumlah Terima</th>
            <th style="text-align: center;">Harga Satuan (Rp)</th>
            <th style="text-align: center;">Keringanan (%)</th>
            <th style="text-align: center;">Keringanan (Rp.)</th>            
            <th style="text-align: center;">PPN (%)</th>
            <th style="text-align: center;">PPN (Rp.)</th>
            <th style="text-align: center;">PPh (%)</th>
            <th style="text-align: center;">PPh (Rp)</th>
            <th style="text-align: center;">HPP</th>
            <th style="text-align: center;">Sub Total</th>
        </thead>
		<tbody>
        <?php 
        $total = 0;
        $subtotal = 0;
		$grandTotal = 0;
        $diskon = 0;
        foreach ($modFakturPembelianDetail as $i=>$modObat){ 
            if (!empty($modObat->satuanbesar_id)) {
                if($modObat->kemasanbesar>0){
                    $kemasanJml = ($modObat->jmlterima * $modObat->kemasanbesar);
                }
            }else{
                $kemasanJml = $modObat->jmlterima;
            } 
                
            $jmlQty = ($modObat->harganettofaktur * $kemasanJml);
            $jmlDiskon = round((($jmlQty * $modObat->persendiscount)/100),2);
            $jmlPpn = round(((($jmlQty - $jmlDiskon) * $modObat->persenppnfaktur)/100),2);
            $jmlPph = round(((($jmlQty - $jmlDiskon) * $modObat->persenpphfaktur)/100),2);
            $totalAll = round(($jmlQty - $jmlDiskon + $jmlPpn - $jmlPph),2);
            
            $grandTotal +=$totalAll
            
        ?>
            <tr>
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo $modObat->obatalkes->obatalkes_kode; ?></td>
                <td><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                <td style="text-align:right;"><?php echo number_format($modObat->jmlterima,2,",",".").' '.(!empty($modObat->satuanbesar_id)?$modObat->obatalkes->satuanbesar->satuanbesar_nama:$modObat->obatalkes->satuankecil->satuankecil_nama); ?></td>                
                <td style="text-align:right;"><?php 
                    echo (Params::cekHiddenHargaGudangFarmasi()==true)? number_format($modObat->harganettofaktur,2,",","."):"hidden"; 
                ?></td>
                <td style="text-align:right;"><?php echo number_format($modObat->persendiscount,2,",","."); ?></td>
                <td style="text-align:right;"><?php echo number_format($jmlDiskon,2,",","."); ?></td>
                <td style="text-align:right;"><?php echo $modObat->persenppnfaktur; ?></td>
                <td style="text-align:right;"><?php 
                    echo (Params::cekHiddenHargaGudangFarmasi()==true)? number_format($jmlPpn,2,",","."):"hidden"; 
                ?></td>
                <td style="text-align:right;"><?php echo number_format($modObat->persenpphfaktur,2,",","."); ?></td>
                <td style="text-align:right;"><?php 
                    echo (Params::cekHiddenHargaGudangFarmasi()==true)? number_format($jmlPph,2,",","."):"hidden"; 
                ?></td>
                <td style="text-align:right;"><?php 
                    echo (Params::cekHiddenHargaGudangFarmasi()==true)? number_format($totalAll,2,",","."):"hidden"; 
					?>
                </td>
                <td style="text-align:right;"><?php 
                    echo (Params::cekHiddenHargaGudangFarmasi()==true)? number_format($totalAll,2,",","."):"hidden"; 
					?>
                </td>
            </tr>
        <?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="12" align="right"><strong>Total</strong></td>
				<td style="text-align:right;"><strong><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?$format->formatNumberForPrint($grandTotal, 2):"Hidden"; ?></strong></td>
			</tr>
		</tfoot>
    </table>
    <br>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
<!--                    <td width="35%" align="center">
                        <div>Pegawai Mengetahui</div>
                        <div style="margin-top:60px;"><?php //echo $data['pegawaimengetahui']; ?></div>
                    </td>-->
                    <td width="35%" align="center">
<!--                        <div>Operator</div>
                        <div style="margin-top:60px;"><?php //echo $data['pegawaimenyetujui']; ?></div>-->
                    </td>
                    <td width="35%" align="center">
                        <!--<div><?php // echo Yii::app()->user->getState("kabupaten_nama").", ".Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></div>-->
                        <div>Yang Mengetahui</div>
						<div style="margin-top:60px;"><?php
                                                $modApprKeu = ApprovalotorisasiM::model()->find();
                                                
                                                echo isset($modApprKeu->managerkeuangan_id) ? $modApprKeu->managerkeuangan->NamaLengkap : "" ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
    <br>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
    
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')")).'&nbsp;';
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        fakturpembelian_id = '<?php echo isset($modFakturPembelian->fakturpembelian_id) ? $modFakturPembelian->fakturpembelian_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&fakturpembelian_id='+fakturpembelian_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    
<?php } ?>
