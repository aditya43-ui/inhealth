<!--
Data dibawah masih belum valid dikarenakan data di tabel penyusutanaset_v belum ada dan belum ada format yang ditentukan
-->
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
    .kertas{
     width:20cm;
     height:12cm;
    }
');
?>  
<?php if(isset($modPemakaianbarang)){ ?>
<?php
if(!$modPemakaianBarangDetail){
    echo "Data tidak ditemukan"; exit;
}
echo $this->renderPartial('application.views.headerReport.headerRincian');
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
?>
<body class="kertas">
	<table class='table'>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPemakaianBarang->getAttributeLabel('nopemakaianbrg')); ?> :</b>
            <?php echo isset($modPemakaianBarang->nopemakaianbrg) ? $modPemakaianBarang->nopemakaianbrg : "-"; ?>
            <br />
            <b>Tanggal Pemakaian Barang :</b>
            <?php echo isset($modPemakaianBarang->tglpemakaianbrg) ? $format->formatDateTimeId($modPemakaianBarang->tglpemakaianbrg) : "-"; ?>
             <br/>
        </td>
        <td>
            <b>Ruangan :</b>
			<?php echo isset($modPemakaianBarang->ruangan->ruangan_nama) ? $modPemakaianBarang->ruangan->ruangan_nama : "-"; ?>
            <br />
            <b>Untuk Keperluan :</b>
            <?php echo isset($modPemakaianBarang->untukkeperluan) ? $modPemakaianBarang->untukkeperluan : "-"; ?>
            <br />
        </td>
    </tr>   
	</table>
<?php } ?>    
	<br/><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th>Kode Barang</th>
            <th>Tipe Barang</th>
            <th>Nama Barang</th>
            <th>Merk / No. Seri</th>
            <th>Ukuran / Bahan Barang</th>
			<th>Satuan</th>
			<th>Jumlah Pakai</th>
            <th>Harga Netto</th>
            <th>Harga Satuan</th>
        </thead>
        <?php 
			$total_harganetto = 0;
			$total_hargajual = 0;
			$total_jmlpakai = 0;
if(isset($modPemakaianBarangDetail)){
			foreach ($modPemakaianBarangDetail as $i=>$modBarang){ 
        ?>
            <tr>
                <td><?php echo $modBarang->barang->bidang->subkelompok->kelompok->golongan->golongan_nama; ?></td>
                <td><?php echo $modBarang->barang->bidang->subkelompok->kelompok->kelompok_nama; ?></td>
                <td><?php echo $modBarang->barang->bidang->subkelompok->subkelompok_nama; ?></td>
                <td><?php echo $modBarang->barang->bidang->bidang_nama; ?></td>
                <td><?php echo $modBarang->barang->barang_nama; ?></td>
                <td><?php echo $modBarang->satuanpakai; ?></td>
				<td style="text-align:center;"><?php echo ($modBarang->jmlpakai); ?></td>
                <td style="text-align:right;"><?php echo $format::formatNumberForUser($modBarang->harganetto); ?></td>
				<td style="text-align:right;"><?php echo $format::formatNumberForUser($modBarang->hargajual); ?></td>
				<?php
					$total_harganetto += $modBarang->harganetto;
					$total_hargajual += $modBarang->hargajual;
					$total_jmlpakai += $modBarang->jmlpakai;
				?>
            </tr>
        <?php } 
}?>
        <tr>
            <td colspan="6" align="center"><strong>Total</strong></td>
            <td style="text-align: center;"><?php echo ($total_jmlpakai); ?></td>
            <td style="text-align: right;"><?php echo $format->formatUang($total_harganetto); ?></td>
            <td style="text-align: right;"><?php echo $format->formatUang($total_hargajual); ?></td>
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
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
                        <div>Mengetahui<br></div>
                        <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
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
