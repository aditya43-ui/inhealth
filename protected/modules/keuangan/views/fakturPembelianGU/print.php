<?php
$format = new MyFormatter;
?>

<style>
 
    tr:last-child > td:first-child 
    {
        border-bottom-left-radius: 0;
    }    
    
    .table
    {
        border: 1px solid #000;
        border-radius: 0 0px 0px 0px;
        box-shadow: 0 0px 0px 0px;
    }

    .table-striped tbody tr:nth-child(2n+1) td
    {
        background-color: #fff;
    }

    .table th
    {
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;

    }

    .c th + th, .c td + td, .c th + td, .c td + th 
    {
        border-left: 1px solid #000;

    }
   
    .d th + th, .d td + td, .d th + td, .d td + th 
    {
        border-left: 0;

    }
    
    table.d{
        border: 0;
    }
    
    
   thead th {
    background: none;
    border-bottom: 4px solid #6B994D;
    color: #333333;
    }
</style>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>'RINCIAN FAKTUR PEMBELIAN BARANG'));
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                <div class="judulcontent">  </div>
                <table class='table' style = "border: 0;">
                    <tr>
                        <td width="50%">
                            <table class='table' style = "border: 0;">
                                <tr>
                                    <td>
                                        <b>No. Permintaan</b>
                                   </td>
                                   <td>
                                       : <?php echo CHtml::encode($modTerima->pembelianbarang->nopembelian); ?>
                                   </td>
                                       
                                </tr>
                                <tr>
                                    <td>
                                        <b><?php echo CHtml::encode($modTerima->getAttributeLabel('nopenerimaan')); ?></b>
                                   </td>
                                   <td>
                                       : <?php echo CHtml::encode($modTerima->nopenerimaan); ?>
                                   </td>
                                       
                                </tr>
                                <tr>
                                    <td>
                                        <b>Tgl. Penerimaan</b>
                                   </td>
                                   <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime(CHtml::encode(MyFormatter::formatDateTimeForDb($modTerima->tglterima))))); ?>
                                   </td>
                                </tr>
                                <tr>
                                     <td>
                                        <b>No. Faktur</b>
                                   </td>
                                   <td>
                                       : <?php echo CHtml::encode($modTerima->nofaktur); ?>
                                   </td>
                                </tr>
                                <tr>
                                     <td>
                                        <b>Tgl. Faktur</b>
                                   </td>
                                   <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser(CHtml::encode(MyFormatter::formatDateTimeForDb($modTerima->tglfaktur))); ?>
                                   </td>
                                </tr>
                                <tr>
                                     <td>
                                        <b>Tgl. Jatuh Tempo</b>
                                   </td>
                                   <td>
                                       : <?php echo (!empty($modTerima->tgljatuhtempo)? MyFormatter::formatDateTimeForUser(CHtml::encode(MyFormatter::formatDateTimeForDb($modTerima->tgljatuhtempo))):""); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b><?php echo CHtml::encode($modTerima->getAttributeLabel('supplier_id')); ?></b>
                                   </td>
                                   <td>
                                       : <?php echo CHtml::encode((isset($modTerima->supplier)?$modTerima->supplier->supplier_nama : "")); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b><?php echo CHtml::encode($modTerima->getAttributeLabel('keteranganfaktur')); ?></b>
                                   </td>
                                   <td>
                                       : <?php echo CHtml::encode($modTerima->keteranganfaktur); ?>
                                   </td>
                                </tr>
                            </table>
                        </td> 
                        <td width="50%">
                            <table class='table' style = "border: 0;">
                               <tr>
                                    <td>
                                        <b>Total Harga</b>
                                   </td>
                                   <td>
                                       : Rp <?php echo (!empty($modTerima->totalharga)? MyFormatter::formatNumberForPrint($modTerima->totalharga, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Total Keringanan</b>
                                   </td>
                                   <td>
                                       : Rp <?php echo (!empty($modTerima->discount)? MyFormatter::formatNumberForPrint($modTerima->discount, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Total PPN</b>
                                   </td>
                                   <td>
                                       : Rp <?php echo (!empty($modTerima->pajakppn)? MyFormatter::formatNumberForPrint($modTerima->pajakppn, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Total PPh</b>
                                   </td>
                                   <td>
                                       : Rp <?php echo (!empty($modTerima->pajakpph)? MyFormatter::formatNumberForPrint($modTerima->pajakpph, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Total Keseluruhan</b>
                                   </td>
                                   <td>
                                       : Rp <?php echo (!empty($modTerima->totalkeseluruhan)? MyFormatter::formatNumberForPrint($modTerima->totalkeseluruhan, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Jumlah Uang Muka</b>
                                   </td>
                                   <td>
                                       : Rp <?php echo (!empty($modTerima->jlmuangmukabeli)? MyFormatter::formatNumberForPrint($modTerima->jlmuangmukabeli, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Total Harga Netto</b>
                                   </td>
                                   <td>
                                       : Rp <?php echo (!empty($modTerima->totalhutangusaha)? MyFormatter::formatNumberForPrint($modTerima->totalhutangusaha, 2): "-"); ?>
                                   </td>
                                </tr>

                            </table>
                        </td>  
                    </tr>
                </table>

<table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
    <thead>
        <th>No.Urut</th>
        <th>Tipe Barang</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>            
        <th>Isi Kemasan</th>
         <th>Jumlah Beli</th>
        <th>Jumlah Terima</th>
        <th>Harga Satuan (Rp)</th>
        <th>Keringanan (%)</th>
        <th>Keringanan (Rp)</th>
        <th>PPN (%)</th>
        <th>PPN (Rp)</th>
        <th>PPh (%)</th>
        <th>PPh (Rp)</th>
        <th>Subtotal (Rp)</th>
        <th>Kondisi Barang</th>
    </thead>
    <tbody>
    <?php
    $total = 0;     
    $no=1;
   
    foreach($modDetailTerima AS $detail): ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); 
            $jmlQty = ($detail->hargasatuan * $detail->jmlterima);
            $jmlDiskon = round((($jmlQty * $detail->persendiscount)/100),2);
            $jmlPpn = round(((($jmlQty - $jmlDiskon) * $detail->persenppn)/100),2);
            $jmlPph = round(((($jmlQty - $jmlDiskon) * $detail->persenpph)/100),2);
            $totalAll = round(($jmlQty - $jmlDiskon + $jmlPpn - $jmlPph),2);
            
            $total += $totalAll;
              
        ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo $modBarang->barang_type; ?></td>
                <td><?php echo $modBarang->barang_kode; ?></td>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td><?php echo $detail->jmldalamkemasan; ?></td>
                <td><?php echo number_format($detail->jmlbeli,2,",","."); ?></td>
                <td><?php echo number_format($detail->jmlterima,2,",",".").' '.$detail->satuanbeli; ?></td>
                <td style = "text-align:right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true)? number_format($detail->hargasatuan,2,",","."):"Hidden"; ?></td>
                <td style = "text-align:right;"><?php echo number_format($detail->persendiscount,2,",","."); ?></td>
                <td style = "text-align:right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true)? number_format($jmlDiskon,2,",","."):"Hidden"; ?></td>
                <td style = "text-align:right;"><?php echo number_format($detail->persenppn,2,",","."); ?></td>
                <td style = "text-align:right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true)? number_format($jmlPpn,2,",","."):"Hidden"; ?></td>
                <td style = "text-align:right;"><?php echo number_format($detail->persenpph,2,",","."); ?></td>
                <td style = "text-align:right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true)? number_format($jmlPph,2,",","."):"Hidden"; ?></td>
                <td style = "text-align:right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true)? number_format($totalAll,2,",",".") :"Hidden"; ?></td>
                <td><?php echo $detail->kondisibarang; ?></td>
            </tr>   
            <?php 
        $no++;
        
        endforeach;
     
         $diskon = $modTerima->discount;
         $ppn = $modTerima->pajakppn;
         $pph = $modTerima->pajakpph;
//         $biayaadmin = $modTerima->biayaadministrasi;
////         $totalseluruh = ($total - $diskon) + $ppn + $pph + $biayaadmin;
         $totalseluruh = $modTerima->totalkeseluruhan;
         $cek_harga = (Params::cekHiddenHargaGudangUmum()==true);
    ?>
            <tr>
                <td colspan = "14" style = "text-align:right;border-top: 1px solid #000;"><b>Total</b></td>
                <td style = "border-top: 1px solid #000;text-align:right;"><b><?php echo  ($cek_harga ? number_format($total,2,",","."):"Hidden"); ?></b></td>
                <td style = "border-top: 1px solid #000;text-align:right;"></td>
            </tr>
    </tbody>
</table>
<table width="100%" style="margin-top:20px;">
	<tr>
		<td width="100%" align="left" align="top">
			<table style="width: 100%; border: none;">
				<tr>
					<td width="35%" align="center">						
					</td>
					<td width="35%" align="center">
					</td>
					<td width="35%" align="center">
						<div>Yang Mengetahui</div>
						<div style="margin-top:60px;"><?php 
                                                $modApproval = ApprovalotorisasiM::model()->find();
                                                $namapegawai = "";
                                                if($modTerima->sumberdana_id = Params::SUMBERDANA_ID_RS){
                                                    $namapegawai = (isset($modApproval->managerkeuangan) ? $modApproval->managerkeuangan->NamaLengkap : "");
                                                }else{
                                                    $namapegawai = (isset($modApproval->managerkeuanganpt) ? $modApproval->managerkeuanganpt->NamaLengkap : "");
                                                }
                                                
                                                
                                                echo $namapegawai; ?></div>
					</td>
				</tr>
			</table>
		</td>
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
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>

<?php
//if (isset($_GET['frame'])){
//    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT');"));
    //echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 

?>
<!--<script type='text/javascript'>
    /**
     * print
     */    
    function print(caraprint)
    {        
        var terimapersediaan_id = '<?php // echo $modTerima->terimapersediaan_id; ?>';
        // alert('<?php //echo $this->createUrl('print'); ?>&id='+terimapersediaan_id+'&caraPrint='+caraprint);
        
        window.open('<?php // echo $this->createUrl('print'); ?>&id='+terimapersediaan_id+'&caraPrint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    };                                                             
  </script>-->
<?php // } ?>
 <?php 
$profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $alamat=!empty($profil->alamatlokasi_rumahsakit)?$profil->alamatlokasi_rumahsakit:"";
	$motto=!empty($profil->motto)?$profil->motto:"";
        $telp=!empty($profil->no_telp_profilrs)?$profil->no_telp_profilrs:"";
        $email=!empty($profil->email)?$profil->email:"";
        $website=!empty($profil->website)?$profil->website:"";
        $layoutkiri=$alamat."<br>"."Telp:".$telp." Email:".$email." Website:".$website;
?>
<table width="100%" class="footer">
    <tr><td width="70%" style="text-align:left" align="left" class="alamatfooter"><?php echo  $layoutkiri ?></td><td class="mottofooter" style="text-align:right"  width="30%" align="right"><?php echo $motto ?></td></tr>
        
</table>