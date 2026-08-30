
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
//        font-size:8pt;
    }
    body{
//        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
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
        border-spacing: 0;
        padding: 0;
    }
');
?>  
<?php
if(!$modPemakaianBarangDetail){
    echo "Data tidak ditemukan."; exit;
}

?>
<table style="width: 100%; border: none;">
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
			<div class="judulcontent">  </div>
                        <?php
                        $format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
?>
<body class="kertas">
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td><b>Tanggal Pemakaian Barang</b></td>
            <td>:</td>
            <td><?php echo isset($modPemakaianBarang->tglpemakaianbrg) ? $format->formatDateTimeId($modPemakaianBarang->tglpemakaianbrg) : "-"; ?></td>
        </tr>
        <tr>
            <td><b>No. Pemakaian Barang</b></td>
            <td>:</td>
            <td><?php echo isset($modPemakaianBarang->nopemakaianbrg) ? $modPemakaianBarang->nopemakaianbrg : "-"; ?></td>
        </tr>
        <tr>
            <td><b>Untuk Keperluan</b></td>
            <td>:</td>
            <td><?php echo isset($modPemakaianBarang->untukkeperluan) ? $modPemakaianBarang->untukkeperluan : "-"; ?></td>
        </tr>
        <tr>
            <td><b>Keterangan</b></td>
            <td>:</td>
            <td><?php echo isset($modPemakaianBarang->keteranganpakai) ? $modPemakaianBarang->keteranganpakai : "-"; ?></td>
        </tr>
    </table><br><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class="border">
        <thead class="border">
            <th>Kode Barang</th>
            <th>Tipe Barang</th>
            <th>Nama Barang</th>
            <th>Merk / No. Seri</th>
            <th>Ukuran / Bahan Barang</th>
			<!--th>Satuan</th-->
			<th>Jumlah Pakai</th>
            <th>Harga Netto</th>
            <th>Harga Satuan</th>
        </thead>
        <?php 
			$total_harganetto = 0;
			$total_hargajual = 0;
			$total_jmlpakai = 0;
			foreach ($modPemakaianBarangDetail as $i=>$modBarang){ 
                             $brg = $modBarang->barang;
        ?>                 
            <tr>
                <td><?php echo !empty($brg->barang_kode)?$brg->barang_kode:null;  ?></td>
                <td><?php echo !empty($brg->barang_type)? $brg->barang_type:null; ?></td>
                <td><?php echo !empty($brg->barang_nama)?$brg->barang_nama:null; ?></td>
                <td><?php echo !empty($brg->barang_merk)?$brg->barang_merk."/ <br>".$brg->barang_noseri:null; ?></td>
                <td><?php echo !empty($brg->barang_ukuran)?$brg->barang_ukuran."/ <br>".$brg->barang_bahan:null; ?></td>
                <!--td><?php //echo $modBarang->satuanpakai; ?></td-->
				<td style="text-align:center;"><?php echo ($modBarang->jmlpakai)." ".$modBarang->satuanpakai; ?></td>
                <td style="text-align:right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true || Params::cekHiddenHargaGudangFarmasi()==true)?$format::formatNumberForPrint($modBarang->harganetto):"Hidden"; ?></td>
				<td style="text-align:right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true || Params::cekHiddenHargaGudangFarmasi()==true)? $format::formatNumberForPrint($modBarang->hargajual):"Hidden"; ?></td>
				<?php
					$total_harganetto += $modBarang->harganetto;
					$total_hargajual += $modBarang->hargajual;
					$total_jmlpakai += $modBarang->jmlpakai;
				?>
            </tr>
        <?php } ?>
        <tr style = "border-top:solid #000 1px;">
            <td colspan="5" align="right" class="border"><b>Total</b></td>
            <td style="text-align: center;"><?php //echo ($total_jmlpakai); ?></td>
            <td style="text-align: right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true || Params::cekHiddenHargaGudangFarmasi()==true)? $format->formatNumberForPrint($total_harganetto):"Hidden"; ?></td>
            <td style="text-align: right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true || Params::cekHiddenHargaGudangFarmasi()==true)?$format->formatNumberForPrint($total_hargajual):"Hidden"; ?></td>
        </tr>
    </table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        pemakaianbarang_id = '<?php echo isset($modPemakaianBarang->pemakaianbarang_id) ? $modPemakaianBarang->pemakaianbarang_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&pemakaianbarang_id='+pemakaianbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Mengetahui<br></div>
                        <div style="margin-top:60px;"><?php echo $modPemakaianBarang->pegawai->nama_pegawai; ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Dibuat Oleh :</div>
                        <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
                        <div></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</body>
<?php } ?>
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

