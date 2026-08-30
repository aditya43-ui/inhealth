<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

//echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judul_print, 'colspan'=>10));
?>
<?php 
if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
    
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
                        <br>
			<div class="judulcontent"> <?php echo $judul_print   ?> <br> <?php //echo $periode   ?></div>
                        <br>
                <div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label('Tgl. Penerimaan Linen', 'tglpenerimaanlinen', array('class' => 'control-label')); echo " :";?>
			<?php echo isset($model->tglpenerimaanlinen) ? $format->formatDateTimeId($model->tglpenerimaanlinen) : "-";  ?>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('No. Penerimaan Linen', 'nopenerimaanlinen', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->nopenerimaanlinen) ? $model->nopenerimaanlinen : "-";  ?>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->ruangan->instalasi->instalasi_nama) ? $model->ruangan->instalasi->instalasi_nama : "-";  ?>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->ruangan->ruangan_nama) ? $model->ruangan->ruangan_nama : "-";  ?>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Keterangan', 'keterangan_penerimaanlinen', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->keterangan_penerimaanlinen) ? $model->keterangan_penerimaanlinen : "-";  ?>
		</div>
	</div>
</div>	
    <table border="1" width="100%" style='margin-left:auto; margin-right:auto;' class="tab-detail">
        <thead class="border">
            <tr>
                <th>Nama Linen</th>
                <th>Jenis Perawatan</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        
            $main_total = 0;
        
            foreach ($modDetail as $i=>$modLinen){ 
        ?>
            <tr>
                <td><?php echo $modLinen->linen->namalinen; ?></td>
                <td><?php echo $modLinen->jenisperawatanlinen; ?></td>
                <td style="text-align: right;"><?php echo $modLinen->jumlah; ?></td>
                <td style="text-align: right;"><?php 
                $linen = LinenM::model()->findByPk($modLinen->linen_id);
                $harga = empty($linen->barang) ? 0 : $linen->barang->barang_harganetto;
                
                echo MyFormatter::formatNumberForPrint($harga);
                
                $main_total += $modLinen->jumlah * $harga;
                
                ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modLinen->jumlah * $harga); ?></td>
                <td><?php echo $modLinen->keterangan_penerimaanlinen; ?></td>
            </tr>
        <?php } ?>
            <tr>
                <td colspan="4" style="font-weight: bold;">Total Keseluruhan</td>
                <td style="text-align: right; font-weight: bold;"><?php echo MyFormatter::formatNumberForPrint($main_total); ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
	<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Menerima<br></div>
                        <div style="margin-top:60px;"><?php echo isset($model->pegawaiMenerima->nama_pegawai) ? $model->pegawaiMenerima->nama_pegawai : "-"; ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo isset($model->pegawaiMengetahui->nama_pegawai) ? $model->pegawaiMengetahui->nama_pegawai : "-"; ?></div>
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
}
if ($caraPrint == 'PDF'){
?>
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
</div>
<div class="content">
     <br>
    <div class="judulcontent"> <?php echo $judul_print   ?> <br> <?php //echo $periode   ?></div>
     <br>
<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label('Tgl. Penerimaan Linen', 'tglpenerimaanlinen', array('class' => 'control-label')); echo " :";?>
			<?php echo isset($model->tglpenerimaanlinen) ? $format->formatDateTimeId($model->tglpenerimaanlinen) : "-";  ?>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('No. Penerimaan Linen', 'nopenerimaanlinen', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->nopenerimaanlinen) ? $model->nopenerimaanlinen : "-";  ?>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->ruangan->instalasi->instalasi_nama) ? $model->ruangan->instalasi->instalasi_nama : "-";  ?>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->ruangan->ruangan_nama) ? $model->ruangan->ruangan_nama : "-";  ?>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Keterangan', 'keterangan_penerimaanlinen', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->keterangan_penerimaanlinen) ? $model->keterangan_penerimaanlinen : "-";  ?>
		</div>
	</div>
</div>	
    <table border="1" width="100%" style='margin-left:auto; margin-right:auto;' class="tab-detail">
        <thead class="border">
            <tr>
                <th>Nama Linen</th>
                <th>Jenis Perawatan</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        
            $main_total = 0;
        
            foreach ($modDetail as $i=>$modLinen){ 
        ?>
            <tr>
                <td><?php echo $modLinen->linen->namalinen; ?></td>
                <td><?php echo $modLinen->jenisperawatanlinen; ?></td>
                <td style="text-align: right;"><?php echo $modLinen->jumlah; ?></td>
                <td style="text-align: right;"><?php 
                $linen = LinenM::model()->findByPk($modLinen->linen_id);
                $harga = empty($linen->barang) ? 0 : $linen->barang->barang_harganetto;
                
                echo MyFormatter::formatNumberForPrint($harga);
                
                $main_total += $modLinen->jumlah * $harga;
                
                ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modLinen->jumlah * $harga); ?></td>
                <td><?php echo $modLinen->keterangan_penerimaanlinen; ?></td>
            </tr>
        <?php } ?>
            <tr>
                <td colspan="4" style="font-weight: bold;">Total Keseluruhan</td>
                <td style="text-align: right; font-weight: bold;"><?php echo MyFormatter::formatNumberForPrint($main_total); ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
	<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Menerima<br></div>
                        <div style="margin-top:60px;"><?php echo isset($model->pegawaiMenerima->nama_pegawai) ? $model->pegawaiMenerima->nama_pegawai : "-"; ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo isset($model->pegawaiMengetahui->nama_pegawai) ? $model->pegawaiMengetahui->nama_pegawai : "-"; ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</div>

<?php
}

 ?>   