<?php
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>

<style>
    .content .judulcontent{
                font-size:12pt !important;
                font-family: calbiri_b !important;
                 color:black !important;
                 font-weight:bold !important;
                  text-align:center !important;
            }
    .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .border {
        box-shadow:none;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
    
    .table tfoot td {
        font-weight: bold;
    }
    .tblpadding td, .tblpadding th {
        padding: 5px !important;
    }
</style>
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
                    <div class="judulcontent" ><?php  echo $judulLaporan  ?>  </div>
                        <table bgcolor='white' class='' style = "box-shadow:none; width: 100%">
    <tr bgcolor='white' >
        <td width="50%">
            <table bgcolor='white' class='tblpadding' style = "box-shadow:none;">
                <tr bgcolor='white' >
                     <td>
                        <b><?php echo CHtml::encode($modBeli->getAttributeLabel('nopembelian')); ?></b>
                    </td>
                    <td>
                        : <?php echo CHtml::encode($modBeli->nopembelian); ?>
                    </td>
                </tr>
                <tr>
                     <td>
                        <b><?php echo CHtml::encode($modBeli->getAttributeLabel('tglpembelian')); ?></b>
                   </td>
                   <td>
                       : <?php echo !empty($modBeli->tglpembelian)?MyFormatter::formatDateTimeForUser($modBeli->tglpembelian):"-" ?>
                   </td>
                </tr>
                <tr>
                    <td>
                        <b><?php echo CHtml::encode($modBeli->getAttributeLabel('tgldikirim')); ?></b>
                   </td>
                   <td>
                       : <?php echo !empty($modBeli->tgldikirim)?MyFormatter::formatDateTimeForUser($modBeli->tgldikirim):"-"; ?>
                   </td>
                </tr>
                <tr>
                    <td>
                        <b>No Referensi</b>            
                    </td>
                    <td>
                        : <?php echo (!empty($modBeli->noreferensi)?$modBeli->noreferensi:""); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b><?php echo "Supplier" ?></b>            
                   </td>
                   <td>
                       : <?php 
                           echo $modBeli->supplier->supplier_nama;
                       ?>
                   </td>
                </tr>
                <tr>
                    <td>
                        <b><?php echo "Sumber Dana" ?></b>            
                   </td>
                   <td>
                       : <?php 
                           $sumberdana = SumberdanaM::model()->findByAttributes(array('sumberdana_id'=>$modBeli->sumberdana_id));
                           echo (isset($sumberdana)?$sumberdana->sumberdana_nama:"");
                       ?>
                   </td>
                </tr>
                <tr>
                    <td>
                        <b>Keterangan</b>            
                    </td>
                    <td>
                        : <?php echo preg_replace('/\s\s+/', '<br />', $modBeli->keterangan); ?>
                    </td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table bgcolor='white' class='tblpadding' style = "box-shadow:none;">
                <tr bgcolor='white' >
                    <td>
                        <b><?php echo CHtml::encode($modBeli->getAttributeLabel('peg_pemesanan_id')); ?></b>            
                    </td>
                    <td>: <?php echo CHtml::encode($modBeli->pemesan->nama_pegawai); ?></td>
                </tr>
                <tr>
                    <td>
                        <b><?php echo "Alamat" ?></b>
                    </td>
                    <td> :
                        <?php 
                            echo $modBeli->supplier->supplier_alamat;
                        ?>
                    </td> 
                </tr>
                <tr>
                    <td>
                        <b><?php echo "No Telp" ?></b>
                    </td>
                    <td> :
                        <?php 
                            $nama = SupplierM::model()->findByAttributes(array('supplier_id'=>$modBeli->supplier_id));
                            echo $nama->supplier_telp;
                        ?>
                    </td> 
                </tr>
                <tr>
                    <td>
                        <b>Jenis PPh</b>            
                    </td>
                    <td>
                        : <?php echo (isset($modBeli->pajak)?$modBeli->pajak->pajak_nama:"-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Tanggal Permintaan Uang Muka Pembelian</b>            
                    </td>
                    <td>
                        : <?php echo !empty($modBeli->tglpermintaanuangmuka)?MyFormatter::formatDateTimeForUser($modBeli->tglpermintaanuangmuka):"-"; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Jumlah Permintaan Uang Muka Pembelian</b>            
                    </td>
                    <td>
                        : Rp. <?php echo (!empty($modBeli->jmlpermintaanuangmuka)? MyFormatter::formatNumberForPrint($modBeli->jmlpermintaanuangmuka,2): "-"); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table id="tableObatAlkes" class="table border" bgcolor='white'>
    <thead>
        <th>No.Urut</th>
         <th>Tipe Barang</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Isi Dalam Kemasan</th>
        <th>Jumlah Permintaan</th>    
        <th>Harga Satuan (Rp)</th>
        <th>Keringanan (%)</th>    
        <th>Keringanan (Rp)</th>
        <th>PPN (%)</th>    
        <th>PPN (Rp)</th>
        <th>PPh (%)</th>    
        <th>PPh (Rp)</th>    
        <th>Subtotal (Rp)</th>
    </thead>
    <tbody>
    <?php
    $no=1;
        $total = 0;
        foreach($modDetailBeli AS $detail):
            $jmlQty = round(($detail->hargasatuan * $detail->jmlbeli),2);
            $jmlDiskon = round((($jmlQty * $detail->persendiscount)/100),2);
            $jmlPpn = ((($jmlQty - $jmlDiskon) * $detail->persen_ppn)/100);
            $jmlPph = round(((($jmlQty - $jmlDiskon) * $detail->persenpph)/100),2);
            $totalAll = round(($jmlQty - $jmlDiskon + $jmlPpn - $jmlPph),2);
            
            $total += $totalAll;
            
            ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr bgcolor='white'>   
                <td bgcolor='white'><?php echo $no; ?></td>
                <td bgcolor='white'><?php echo !empty($modBarang->barang_type)?$modBarang->barang_type:null;  ?></td>
                <td bgcolor='white'><?php echo $modBarang->barang_kode; ?></td>
                <td bgcolor='white'><?php echo $modBarang->barang_nama; ?></td>
                <td bgcolor='white'><?php echo $detail->jmldlmkemasan; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo number_format($detail->jmlbeli,2,",",".").' '.$detail->satuanbeli; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($detail->hargasatuan,2,",","."):"Hidden"; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo number_format($detail->persendiscount,2,",","."); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($jmlDiskon,2,",","."):"Hidden"; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo $detail->persen_ppn; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($jmlPpn,2,",","."):"Hidden"; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo number_format($detail->persenpph,2,",","."); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($jmlPph,2,",","."):"Hidden"; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($totalAll,2,",","."):"Hidden"; ?></td>
            </tr>   
            <?php 
        $no++;
        
        endforeach;
     
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td bgcolor='white' style = "text-align:right;" colspan="13">Total Harga</td>
            <td bgcolor='white' style = "text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($total,2,",","."):"Hidden"; ?> </td>
        </tr>
    </tfoot>
</table>
<br/>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3">Pesanan tersebut akan dipergunakan untuk :</td>
    </tr>
        <tr>
            <td  width="20%">Nama Sarana</td>
            <td>:</td>
            <td>Instalasi Gudang Umum <?php echo $modProfilRs->nama_rumahsakit; ?></td>
        </tr>
        <tr>
            <td  width="20%">Alamat</td>
            <td>:</td>
            <td><?php 
            $alamatrs = $modProfilRs->alamatlokasi_rumahsakit.", Kelurahan ".$modProfilRs->kelurahan->kelurahan_nama.", Kecamatan ".$modProfilRs->kecamatan->kecamatan_nama.", ".$modProfilRs->kabupaten->kabupaten_nama;
            echo ucwords(strtolower($modBeli->alamatpengirim)); ?></td>
        </tr>
    </table><br/>
<table width="100%" style="margin-top:20px;">
	<tr>
		<td width="100%" align="left" align="top">
			<table width="100%">
				<tr>
					<td width="35%" align="center">
<!--						<div>Manajer Umum, <br> Mengetahui</div>
						<div style="margin-top:60px;"><?php // echo isset($modBeli->peg_mengetahui_umum_id) ? $modBeli->mengetahuiumum->NamaLengkap : "" ?></div>-->
					</td>
					<td width="35%" align="center">
                                            <!--<div>Manajer Keuangan, <br> Mengetahui</div>-->
						<!--<div style="margin-top:60px;"><?php // echo isset($modBeli->peg_mengetahui_id) ? $modBeli->mengetahui->NamaLengkap : "" ?></div>-->
					</td>
					<td width="35%" align="center">
						<div>Direktur, <br> Menyetujui</div>
						<div style="margin-top:60px;"><?php echo isset($modBeli->peg_menyetujui_id) ? $modBeli->menyetujui->NamaLengkap : "" ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
    <br/>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
<tr>
    <td>Surat Pesanan ini telah disetujui dan disahkan secara Elektronik</td>
</tr>

</table>
    <br/>
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
   
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

</div>

<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    //echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        pembelianbarang_id = '<?php echo isset($modBeli->pembelianbarang_id) ? $modBeli->pembelianbarang_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&id='+pembelianbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}
?>
