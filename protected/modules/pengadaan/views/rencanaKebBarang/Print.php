
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
	td {
		vertical-align: top;
	}
    .kertas{
     width:100%;
     height:12cm;
    }
');
?>  
<?php
if(!$modRencanaKebBarangDetail){
    echo "Data tidak ditemukan"; exit;
}
//echo $this->renderPartial('application.views.headerReport.headerDefaultNew');
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
			<div class="judulcontent"> <?php echo $judul_print; ?> </div>
 <?php                       
                        $format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$tglrencana = MyFormatter::formatDateTimeForUser($modRencanaKebBarang->renkebbarang_tgl);
?>
<body class="kertas">
    
    <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Rencana : <?php echo $modRencanaKebBarang->renkebbarang_no; ?></td>
            <td>Sumber Dana : <?php echo (!empty($modRencanaKebBarang->sumberdana_id)?$modRencanaKebBarang->sumberdana->sumberdana_nama:""); ?></td>
        </tr>
        <tr>
            <td>Tanggal Rencana : <?php echo $tglrencana; ?></td>
            <td></td>
        </tr>
    </table><br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class = "border">
        <thead class="border">
            <th style="text-align: center;">No.</th>
            <th width="200" style="text-align: center;">Nama Barang</th>
            <th style="text-align: center;">Satuan </th>
            <th>Stok Akhir</th>
            <th>Min Stok</th>
            <th>Maks Stok</th>                    
            <th>Jumlah Kebutuhan</th>
            <th>Harga Satuan (Rp)</th>       
            <th>PPN (%)</th>
            <th>PPN (Rp)</th>
            <th>Sub Total (Rp)</th>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modRencanaKebBarangDetail as $i=>$modBarang){ 
            $barang = BarangM::model()->findByPk($modBarang->barang_id);
            $total += $modBarang->hpp;	
        ?>
            <tr>
                <td style="text-align: center;"><?php echo ($i+1)."."; ?></td>
                <td><?php echo (!empty($modBarang->barang_id)) ? $barang->barang_nama : ""; ?></td>
                <td style="text-align: center;"><?php echo $modBarang->satuanbarangdet; ?></td>
                <td style="text-align: center;" nowrap><?php echo number_format($modBarang->stokakhir_barangdet, 2, ",","."); ?></td>
                <td style="text-align: center;" nowrap><?php echo $modBarang->minstok_barangdet; ?></td>
                <td style="text-align: center;" nowrap><?php echo $modBarang->makstok_barangdet; ?></td>
                <td style="text-align: center;"><?php echo number_format($modBarang->jmlpermintaanbarangdet, 2, ",","."); ?></td>
                <td style="text-align: right;" nowrap><?php echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($modBarang->harga_barangdet,2,",","."):"Hidden"; ?></td>
                <td style="text-align: center;"><?php echo $modBarang->persen_ppn; ?></td>
                 <td style="text-align: right;" nowrap><?php 
                    echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($modBarang->ppn,2,",","."):"Hidden"; ?>
                </td>
                <td style="text-align: right;" nowrap><?php 
                    echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($modBarang->hpp,2,",","."):"Hidden"; ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="10" style="text-align:right;"><strong>Total</strong></td>
            <td style="text-align: right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($total,2,",","."):"Hidden"; ?></td>
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
        renkebbarang_id = '<?php echo isset($modRencanaKebBarang->renkebbarang_id) ? $modRencanaBarang->renkebbarang_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&rencanakebfarmasi_id='+rencanakebfarmasi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo isset($modRencanaKebBarang->pegmenyetujui_id) ? $modRencanaKebBarang->pegawaimenyetujui->NamaLengkap : "" ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Dibuat Oleh :</div>
                        <div style="margin-top:60px;"><?php echo !empty($modRencanaKebBarang->pegawai_id) ? $modRencanaKebBarang->pegawai->NamaLengkap : "" ?></div>
                        <div>(Petugas Gudang Umum)</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</body><br>
<?php } ?>
<div class="footer">
  
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
 
</div>
<?php 

