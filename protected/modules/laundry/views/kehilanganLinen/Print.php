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

//echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judul_print, 'deskripsi'=>$deskripsi, 'colspan'=>10));
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
			<div class="judulcontent"><?php echo $judul_print ?> </div>
                        
    <table class="table">
        <tr>
            <td width="20%">Tanggal Kehilangan Linen</td>
            <td width="1%">:</td>
            <td><?php echo isset($modPenerimaanLinen->tglpenerimaanlinen) ? $format->formatDateTimeId($modPenerimaanLinen->tglpenerimaanlinen) : "-"; ?></td>
        </tr>
        <tr>
            <td>No. Kehilangan Linen</td>
            <td>:</td>
            <td><?php echo isset($modPenerimaanLinen->nopenerimaanlinen) ? $modPenerimaanLinen->nopenerimaanlinen : "-"; ?></td>
        </tr>
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td><?php echo isset($modPenerimaanLinen->ruangan->ruangan_nama) ? $modPenerimaanLinen->ruangan->ruangan_nama : "-"; ?></td>
        </tr>
        <tr>
            <td>Keterangan Kehilangan</td>
            <td>:</td>
            <td><?php echo isset($modPenerimaanLinen->keterangan_penerimaanlinen) ? $modPenerimaanLinen->keterangan_penerimaanlinen : "-"; ?></td>
        </tr>
    </table><br><br>
	
	<table  class="table">
		<thead>
			<tr>
				<th>Nama Linen</th>
				<th>Jenis Perawatan</th>
				<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach ($modPenerimaanLinenDetail as $i=>$modLinen){ 
			?>
				<tr>
					<td><?php echo $modLinen->linen->namalinen; ?></td>
					<td><?php echo $modLinen->jenisperawatanlinen; ?></td>
					<td><?php echo $modLinen->keterangan_penerimaanlinen; ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<table width="100%" style="margin-top:20px;">
    <tr>
		<td width="35%" align="center">
			<div>Menerima<br></div>
			<div style="margin-top:60px;"><?php echo isset($modPenerimaanLinen->pegawaiMenerima->nama_pegawai) ? $modPenerimaanLinen->pegawaiMenerima->nama_pegawai : "-"; ?></div>
		</td>
		<td width="35%" align="center">
			<div>Mengetahui</div>
			<div style="margin-top:60px;"><?php echo isset($modPenerimaanLinen->pegawaiMengetahui->nama_pegawai) ? $modPenerimaanLinen->pegawaiMengetahui->nama_pegawai : "-"; ?></div>
			<div></div>
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