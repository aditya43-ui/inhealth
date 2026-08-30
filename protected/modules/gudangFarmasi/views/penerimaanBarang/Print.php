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
        color: black;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
    thead th {
    background: none;
    border-bottom: 4px solid #6B994D;
    color: #000;
}

    .tab_detail {
        width: 100%;
    }
    
    .tab_detail th {
        font-weight: bold;
    }
    
    .tab_detail th, .tab_detail td {
        border: 1px solid black;
        padding: 3px;
    }
    .judulcontent{
        text-align: center !important;
    }
    .tblpadding td{
        padding: 5px;
    }
');
?>  

<?php
if(!$modPenerimaanBarangDetail){
    echo "Data tidak ditemukan"; exit;
}
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    //echo $this->renderPartial($this->path_view.'_headerPrint'); 
}

$permintaanpembelian_id = (isset($modPenerimaanBarang->permintaanpembelian->permintaanpembelian_id) ? $modPenerimaanBarang->permintaanpembelian->permintaanpembelian_id : null);
$modUangMuka = GFUangMukaBeliT::model()->findByAttributes(array('permintaanpembelian_id'=> $permintaanpembelian_id));
$pajak_nama = (isset($modPenerimaanBarang->permintaanpembelian)? (isset($modPenerimaanBarang->permintaanpembelian->pajak)?$modPenerimaanBarang->permintaanpembelian->pajak->pajak_nama:""):"-");
if(isset($modUangMuka)){
    $modPenerimaanBarang->tgluangbelimuka = MyFormatter::formatDateTimeForUser($modUangMuka->tgluangmukabeli);
    $modPenerimaanBarang->jumlahuang = $modUangMuka->jumlahuang;
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
                    <div class="judulcontent"> <?php echo $judul_print ?> </div>
                    <br/>
                    <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="50%" valign="top">
                                <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0" class="tblpadding">
                                    <tr>
                                        <td width="200px">No Penerimaan</td>
                                        <td>
                                            : <?php echo $modPenerimaanBarang->noterima; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tgl. Terima</td>
                                        <td>
                                            : <?php echo MyFormatter::formatDateTimeForUser($modPenerimaanBarang->tglterima); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>No Faktur</td>
                                        <td>
                                            : <?php echo $modPenerimaanBarang->nosuratjalan; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tgl. Faktur</td>
                                        <td>
                                            : <?php echo (!empty($modPenerimaanBarang->tglsuratjalan)?MyFormatter::formatDateTimeForUser($modPenerimaanBarang->tglsuratjalan):"-"); ?>
                                        </td>
                                    </tr>
                                    <?php if(Yii::app()->user->getState('isfakturdigudang') == true){ ?>
                                        <tr>
                                            <td>No. Faktur</td>
                                            <td>
                                                : <?php echo $modFakturPembelian->nofaktur; ?>
                                            </td>
                                        </tr>    
                                        <tr>
                                            <td>Tgl. Faktur</td>
                                            <td>
                                                : <?php echo (!empty($modFakturPembelian->tglfaktur)? MyFormatter::formatDateTimeForUser($modFakturPembelian->tglfaktur) : ""); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tgl. Jatuh Tempo</td>
                                            <td>
                                            : <?php echo (!empty($modFakturPembelian->tgljatuhtempo)? MyFormatter::formatDateTimeForUser($modFakturPembelian->tgljatuhtempo) : ""); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td>Sumber Dana</td>
                                        <td>
                                            : <?php echo (!empty($modPenerimaanBarang->sumberdana)? $modPenerimaanBarang->sumberdana->sumberdana_nama : ""); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Supplier</td>
                                        <td>
                                            : <?php echo $modPenerimaanBarang->supplier->supplier_nama; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pegawai Penerima</td>
                                        <td>
                                            : <?php echo (isset($modPenerimaanBarang->pegawai)? $modPenerimaanBarang->pegawai->namaLengkap: "-"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan Penerimaan</td>
                                        <td>
                                            : <?php echo $modPenerimaanBarang->keteranganterima; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status Penerimaan</td>
                                        <td>
                                            : <?php echo $modPenerimaanBarang->statuspenerimaan; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jenis PPh</td>
                                        <td>
                                            : <?php echo $pajak_nama; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%" valign="top">
                                <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0" class="tblpadding">
                                    <tr>
                                        <td width="200px">Tgl. Pembayaran Uang Muka</td>
                                        <td>
                                            : <?php echo (!empty($modPenerimaanBarang->tgluangbelimuka)?MyFormatter::formatDateTimeForUser($modPenerimaanBarang->tgluangbelimuka):"-"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Uang Muka</td>
                                        <td>
                                            : <?php echo ((Params::cekHiddenHargaGudangFarmasi()==true)? "Rp. ".(isset($modPenerimaanBarang->jumlahuang)?MyFormatter::formatNumberForPrint($modPenerimaanBarang->jumlahuang, 2):"-"):"Hidden"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Harga</td>
                                        <td>
                                            : <?php echo ((Params::cekHiddenHargaGudangFarmasi()==true)? "Rp. ".(isset($modPenerimaanBarang->harganetto)?MyFormatter::formatNumberForPrint($modPenerimaanBarang->harganetto, 2):"-"):"Hidden"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Keringanan</td>
                                        <td>
                                            : <?php echo ((Params::cekHiddenHargaGudangFarmasi()==true)? "Rp. ".(isset($modPenerimaanBarang->jmldiscount)?MyFormatter::formatNumberForPrint($modPenerimaanBarang->jmldiscount, 2):"-"):"Hidden"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total PPN</td>
                                        <td>
                                            : <?php echo ((Params::cekHiddenHargaGudangFarmasi()==true)? "Rp. ".(isset($modPenerimaanBarang->totalpajakppn)?MyFormatter::formatNumberForPrint($modPenerimaanBarang->totalpajakppn, 2):"-"):"Hidden"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total PPh</td>
                                        <td>
                                            : <?php echo ((Params::cekHiddenHargaGudangFarmasi()==true)? "Rp. ".(isset($modPenerimaanBarang->totalpajakpph)?MyFormatter::formatNumberForPrint($modPenerimaanBarang->totalpajakpph, 2):"-"):"Hidden"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Keseluruhan</td>
                                        <td>
                                            : <?php echo ((Params::cekHiddenHargaGudangFarmasi()==true)? "Rp. ".(isset($modPenerimaanBarang->totalharga)?MyFormatter::formatNumberForPrint($modPenerimaanBarang->totalharga, 2):"-"):"Hidden"); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                            
                            
                            
    </table>
    <br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class="tab_detail">
        <thead >
            <tr>
            <th class = "border" style="text-align: center;">No.</th>
            <th class = "border" style="text-align: center;">Kode</th>
            <th class = "border" style="text-align: center;">No. Batch</th>
            <th class = "border" style="text-align: center;">Tanggal Kadaluarsa</th>
            <th class = "border" style="text-align: center;">Nama Obat & Alkes</th>                        
            <th class = "border" style="text-align: center;">Isi Kemasan Satuan Besar</th>
            <th class = "border" style="text-align: center;">Jml Terima</th>
            <th class = "border" style="text-align: center;">Harga Satuan (Rp)</th>
            <th class = "border" style="text-align: center;">Keringanan (%)</th>
            <th class = "border" style="text-align: center;">Keringanan (Rp.)</th>
            <th class = "border" style="text-align: center;">PPN (%)</th>
            <th class = "border" style="text-align: center;">PPN (Rp)</th>
            <th class = "border" style="text-align: center;">PPh (%)</th>
            <th class = "border" style="text-align: center;">PPh (Rp)</th>
            <th class = "border" style="text-align: center;">HPP</th>
            <th class = "border" style="text-align: center;">Subtotal</th>
            </tr>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
		
        foreach ($modPenerimaanBarangDetail as $i=>$modObat){ 
			$modStokObatAlkes = StokobatalkesT::model()->findByAttributes(array('penerimaandetail_id'=>$modObat->penerimaandetail_id));
               
                $kemasanJml = 0;        
                if (!empty($modObat->satuanbesar_id)) {
                    if($modObat->kemasanbesar>0){
                        $kemasanJml = ($modObat->jmlterima * $modObat->kemasanbesar);
                    }
                }else{
                    $kemasanJml = $modObat->jmlterima;
                } 
                        
                $jmlTotal = round(($modObat->harganettoper * $kemasanJml),2);
                $jmlDiskon = round((($jmlTotal * $modObat->persendiscount)/100),2);
                $jmlPPn = round(((($jmlTotal - $jmlDiskon) * $modObat->persenppn)/100),2);
                $jmlPPh = round(((($jmlTotal - $jmlDiskon) * $modObat->persenpph)/100),2);
                $total = ($jmlTotal - $jmlDiskon + $jmlPPn - $jmlPPh);
                        
        ?>
            <tr>
                <td align="center" class = "border"><?php echo ($i+1)."."; ?></td>
                <td class = "border" hidden><?php echo $modObat->sumberdana->sumberdana_nama; ?></td>
                <td class = "border"><?php echo $modObat->obatalkes->obatalkes_kode; ?></td>
                <td class = "border"><?php echo (!empty($modStokObatAlkes->nobatch) ? $modStokObatAlkes->nobatch : ""); ?></td>
                <td class = "border"><?php echo $format->formatDateTimeForUser($modObat->tglkadaluarsa); ?></td>
				<td style="text-align:right;" class = "border"><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                <td style="text-align:right;" class = "border"><?php echo number_format($modObat->kemasanbesar,0,"",".")." ".(!empty($modObat->obatalkes->satuankecil)? $modObat->obatalkes->satuankecil->satuankecil_nama : ""); ?></td>
                <td style="text-align:right;" class = "border"><?php echo number_format($modObat->jmlterima,2,",",".").' '.(!empty($modObat->satuanbesar_id)?$modObat->obatalkes->satuanbesar->satuanbesar_nama:$modObat->obatalkes->satuankecil->satuankecil_nama); ?></td>
                <td style="text-align:right;" class = "border"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($modObat->harganettoper,2,",","."):"Hidden"; ?></td>
                <td style="text-align:right;" class = "border"><?php echo number_format($modObat->persendiscount,2,",",""); ?></td>
                <td style="text-align:right;" class = "border"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($jmlDiskon,2,",","."):"Hidden"; ?></td>
                <td style="text-align:right;" class = "border"><?php echo number_format($modObat->persenppn,0,"","."); ?></td>	
                <td style="text-align:right;" class = "border"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($jmlPPn,2,",","."):"Hidden"; ?></td>
                <td style="text-align:right;" class = "border"><?php echo number_format($modObat->persenpph,2,",","."); ?></td>
                <td style="text-align:right;" class = "border"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($jmlPPh,2,",","."):"Hidden"; ?></td>
				<td style="text-align:right;" class = "border"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($total,2,",","."):"Hidden"; ?></td>
                <td style="text-align:right;" class = "border">
                    <?php 
//						$subtotal = $modObat->hargasatuanper * $modObat->jmlterima;
                    $subtotal = $total;
						echo (Params::cekHiddenHargaGudangFarmasi()==true)? number_format($subtotal,2,",","."):"Hidden";
						
						//$total += $subtotal;
					?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td class = "border" colspan="15" style="text-align:right;"><strong>Total</strong></td>
            <td class = "border" style="text-align:right;"><b><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? number_format($modPenerimaanBarang->totalharga,2,",","."):"Hidden"; ?></b></td>
        </tr>
    </table>
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

    
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        penerimaanbarang_id = '<?php echo isset($modPenerimaanBarang->penerimaanbarang_id) ? $modPenerimaanBarang->penerimaanbarang_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&penerimaanbarang_id='+penerimaanbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <br>
    <!--<div style="float: right; padding-right: 10px"><?php // echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('d F Y')); ?></div>-->
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
<!--                        <div>Pegawai Penerima</div>
                        <div style="margin-top:60px;"><?php // echo isset($modPenerimaanBarang->pegawai_id) ? $modPenerimaanBarang->pegawai->NamaLengkap : "" ?></div>-->
                    </td>
                    <td width="35%" align="center">
<!--                        <div>Pegawai Penerima</div>
                        <div style="margin-top:60px;"><?php // echo isset($modPenerimaanBarang->pegawai_id) ? $modPenerimaanBarang->pegawai->NamaLengkap : "" ?></div>-->
                    </td>
<!--                    <td width="35%" align="center">
                        <div>Operator</div>
                        <div style="margin-top:60px;"><?php // echo isset($modPenerimaanBarang->pegawai->NamaLengkap) ? $modPenerimaanBarang->pegawai->NamaLengkap : "" ?></div>
                    </td>-->
                    <td width="30%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('d F Y')); ?><br />Pegawai Menyetujui</div>
                        <div style="margin-top:60px;"><?php 
                        $konfigOto = ApprovalotorisasiM::model()->find();
                        echo isset($konfigOto->kepalafarmasi_id) ? $konfigOto->kepalafarmasi->NamaLengkap : "" ?></div>
                    </td>
                </tr>
<!--                <tr>
                    <td width="35%" align="center">
                        <div>Pegawai Mengetahui</div>
                        <div style="margin-top:60px;"><?php // echo isset($modPenerimaanBarang->pegawaimengetahui->NamaLengkap) ? $modPenerimaanBarang->pegawaimengetahui->NamaLengkap : "" ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div>Operator</div>
                        <div style="margin-top:60px;"><?php // echo isset($modPenerimaanBarang->pegawai->NamaLengkap) ? $modPenerimaanBarang->pegawai->NamaLengkap : "" ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php // echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Pegawai Menyetujui</div>
                        <div style="margin-top:60px;"><?php // echo isset($modPenerimaanBarang->pegawaimenyetujui->NamaLengkap) ? $modPenerimaanBarang->pegawaimenyetujui->NamaLengkap : "" ?></div>
                    </td>
                </tr>-->
            </table>
        </td>
    </tr>
    </table>
<?php } ?>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>