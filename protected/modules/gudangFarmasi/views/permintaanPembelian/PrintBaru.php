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
    
    .border th, .border td{
        border:1px solid #000;
        padding:2px;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php
if(!$modPermintaanPembelianDetail){
    echo "Data tidak ditemukan"; exit;
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
                    <div class="judulcontent"> <center><b>PERMINTAAN PEMBELIAN OBAT ALKES</b></center></div>
                    <br/>
                        <?php
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$alamatrs = $modProfilRs->alamatlokasi_rumahsakit.", Kelurahan ".$modProfilRs->kelurahan->kelurahan_nama.", Kecamatan ".$modProfilRs->kecamatan->kecamatan_nama.", ".$modProfilRs->kabupaten->kabupaten_nama;

$norencana = "";
$tglrencan = "";
if(isset($modPermintaanPembelian->rencanakebfarmasi)){
    $norencana = $modPermintaanPembelian->rencanakebfarmasi->noperencnaan;
    $tglrencan = MyFormatter::formatDateTimeForUser($modPermintaanPembelian->rencanakebfarmasi->tglperencanaan);
}

?>
                    
                <table width="100%">
                    <tr>
                        <td width="50%">
                            <table width="100%">
                                <tr>
                                    <td width="200px">No. Permintaan</td>
                                    <td>
                                        : <?php echo $modPermintaanPembelian->nopermintaan; ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tgl. Permintaan</td>
                                    <td>
                                        : <?php echo MyFormatter::formatDateTimeForUser($modPermintaanPembelian->tglpermintaanpembelian); ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tgl. minta Dikirim</td>
                                    <td>
                                        : <?php echo MyFormatter::formatDateTimeForUser($modPermintaanPembelian->tgldikirim); ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>No. Rencana</td>
                                    <td>
                                        : <?php echo $norencana; ?>  
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tgl. Rencana</td>
                                    <td>
                                        : <?php echo $tglrencan; ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pegawai Pemesan</td>
                                    <td>
                                        : <?php echo (isset($modPermintaanPembelian->pegawai)?$modPermintaanPembelian->pegawai->namaLengkap:""); ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td>
                                        : <?php echo preg_replace('/\s\s+/', '<br />', $modPermintaanPembelian->keteranganpermintaan); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jenis PPh</td>
                                    <td>
                                        : <?php echo (isset($modPermintaanPembelian->pajak)?$modPermintaanPembelian->pajak->pajak_nama:""); ?> 
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%">
                            <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="200px">No Referensi</td>
                                    <td>
                                        : <?php echo $modPermintaanPembelian->noreferensi; ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sumber Dana</td>
                                    <td>
                                        :  <?php echo (isset($modPermintaanPembelian->sumberdana)?$modPermintaanPembelian->sumberdana->sumberdana_nama:""); ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Supplier</td>
                                    <td>
                                        :  <?php echo (isset($modPermintaanPembelian->supplier)?$modPermintaanPembelian->supplier->supplier_nama:""); ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>
                                        :  <?php echo $modPermintaanPembelian->alamatpengiriman; ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>No. Telp</td>
                                    <td>
                                        :  <?php echo (isset($modPermintaanPembelian->supplier)?$modPermintaanPembelian->supplier->supplier_telp:""); ?>  
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tgl. Permintaan Uang Muka</td>
                                    <td>
                                        :  <?php echo (!empty($modPermintaanPembelian->tglpermintaanuangmuka)?MyFormatter::formatDateTimeForUser($modPermintaanPembelian->tglpermintaanuangmuka):"-"); ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jumlah Permintaan Uang Muka</td>
                                    <td>
                                        :  Rp. <?php echo (!empty($modPermintaanPembelian->jmlpermintaanuangmuka)? MyFormatter::formatNumberForPrint($modPermintaanPembelian->jmlpermintaanuangmuka,2): "-"); ?> 
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>              
                    
                    
                    

    <br/><br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class ="border" >
        <thead class="border">
            <th>No.</th>
            <th>Kode</th>
            <th>Nama Obat & Alkes</th>
            <th hidden>Zat Aktif</th>
            <th hidden>Bentuk/<br/> Kekuatan</th>
            <th>Jumlah Permintaan</th>    
            <th hidden>Jumlah Kemasan (Satuan)</th>                                                
            <th>Harga Satuan (Rp.)</th>
            <th>Keringanan (%)</th>
            <th>Keringanan (Rp.)</th>
            <th>PPN (%)</th>
            <th>PPN (Rp.)</th>
            <th hidden>PPh (%)</th>
            <th hidden>PPh (Rp.)</th>
            <th>HPP</th>
            <th>Sub Total (Rp.)</th>
            <th hidden>Keterangan</th>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        $satuanobat = "";
        foreach ($modPermintaanPembelianDetail as $i=>$modObat){ 
            $oa = ObatalkesM::model()->findByPk($modObat->obatalkes_id);
            
            $kemasanJml = 0;        
                if (!empty($modObat->satuanbesar_id)) {
                    if($modObat->kemasanbesar>0){
                        $kemasanJml = ($modObat->jmlpermintaan * $modObat->kemasanbesar);
                    }
                }else{
                    $kemasanJml = $modObat->jmlpermintaan;
                } 
            
             $jmlTotal = round(($modObat->harganettoper * $kemasanJml),2);
                $jmlDiskon = round((($jmlTotal * $modObat->persendiscount)/100),2);
                $jmlPPn = round(((($jmlTotal - $jmlDiskon) * $modObat->persenppn)/100),2);
                $jmlPPh = round(((($jmlTotal - $jmlDiskon) * $modObat->persenpph)/100),2);
                $total = ($jmlTotal - $jmlDiskon + $jmlPPn - $jmlPPh);
                
                 if (!empty($modObat->satuanbesar_id)) {
                    $besar = SatuanbesarM::model()->findByPk($modObat->satuanbesar_id);
                    $satuanobat = $besar->satuanbesar_nama;
                } else if (!empty($modObat->satuankecil_id)) {
                    $kecil = SatuankecilM::model()->findByPk($modObat->satuankecil_id);
                    $satuanobat = $kecil->satuankecil_nama;
                }
        ?>
             <tr class="border">
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo $modObat->obatalkes->obatalkes_kode; ?></td>
                <td><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                <td hidden>
                    <?php 
                    $modZatAktif = ObatalkeszataktifM::model()->findAllByAttributes(array(
                        'obatalkes_id'=>$oa->obatalkes_id
                    ));

                    $zatAktif = "-";
                    if (count((array)$modZatAktif) > 0) {
                        $zatAktif = "<ul>";
                        foreach ($modZatAktif as $item) {
                            $zatAktif .= "<li>".$item->obatalkeszataktif_nama."</li>";
                        }
                        $zatAktif .= "</ul>";
                    }
                    echo $zatAktif;
                    ?>
                </td>
                <td hidden>
                    <?php echo $oa->bentuk_obat." / ".$oa->kekuatan." ".$oa->satuankekuatan; ?>
                </td>
                <td style = "text-align:right;"><?php echo number_format($modObat->jmlpermintaan,0,"",".")." ".$satuanobat; ?></td>
                <td style = "text-align:right;" hidden><?php echo number_format($modObat->kemasanbesar,0,"",".")." ".(!empty($oa->satuankecil)? $oa->satuankecil->satuankecil_nama : ""); ?></td>
                <td style = "text-align:right;"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?MyFormatter::formatNumberForPrint($modObat->harganettoper, 2):"Hidden"; ?></td>
                <td style="text-align:right;"><?php echo number_format($modObat->persendiscount,2,",",""); ?></td>
                <td style="text-align:right;"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($jmlDiskon,2,",","."):"Hidden"; ?></td>
                <td style="text-align:right;"><?php echo number_format($modObat->persenppn,0,"","."); ?></td>	
                <td style="text-align:right;" ><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($jmlPPn,2,",","."):"Hidden"; ?></td>
                <td style="text-align:right;" hidden><?php echo number_format($modObat->persenpph,2,",","."); ?></td>
                <td style="text-align:right;" hidden><?php echo ( Params::cekHiddenHargaGudangFarmasi()==true)?number_format($jmlPPh,2,",","."):"Hidden"; ?></td>
                <td style="text-align:right;"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($total,2,",","."):"Hidden"; ?></td>
                <td style="text-align:right;"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($total,2,",","."):"Hidden"; ?></td>
                <td hidden>
                    <?php echo $modObat->keterangan; ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan = "10" style="text-align:right;" align="center"><strong>Total</strong></td>
            <td style = "text-align:right;" class="border"><strong><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? MyFormatter::formatNumberForPrint($total, 2):"Hidden"; ?></strong></td>
        </tr>
</table><br><br>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3">Pesanan tersebut akan dipergunakan untuk :</td>
    </tr>
        <tr>
            <td  width="20%">Nama Sarana</td>
            <td>:</td>
            <td>Instalasi Farmasi <?php echo $modProfilRs->nama_rumahsakit; ?></td>
        </tr>
        <tr>
            <td  width="20%">Alamat</td>
            <td>:</td>
            <td><?php echo ucwords(strtolower($modPermintaanPembelian->alamatpengiriman)); ?></td>
        </tr>
    </table><br/>
    	
<div class="row-fluid">
	<div class="span4" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
		</div>
		<div class="control-group">
		</div>	
	</div>
    <div class="span4" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
		</div>
		<div class="control-group">
		</div>
	</div>
	<div class="span4" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
			Direktur, <br> Menyetujui
		</div>
		<div class="control-group">
			<?php echo $modPermintaanPembelian->pegawaimenyetujui->NamaLengkap;?>
		</div>
	</div>
</div>
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
    <p>Surat Pesanan ini telah disetujui dan disahkan secara Elektronik</p>
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>

<br><br>
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
        permintaanpembelian_id = '<?php echo isset($modPermintaanPembelian->permintaanpembelian_id) ? $modPermintaanPembelian->permintaanpembelian_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&permintaanpembelian_id='+permintaanpembelian_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php } ?>
