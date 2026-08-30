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
                echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judul_print, 'colspan'=>2)); 
	}
}

//echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judul_print, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>

<style>
   
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

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>
  <?php
if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
    
    
?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                if($caraPrint != 'EXCEL'){
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judul_print));
                } ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    
                 <table class="">
        <tr>
            <td>Tanggal Pengajuan Perawatan Linen</td>
            <td>:</td>
            <td><?php echo isset($modPengPerawataninen->tglpengperawatanlinen) ? $format->formatDateTimeId($modPengPerawataninen->tglpengperawatanlinen) : "-"; ?></td>
        </tr>
        <tr>
            <td>No. Pengajuan Perawatan Linen</td>
            <td>:</td>
            <td><?php echo isset($modPengPerawataninen->pengperawatanlinen_no) ? $modPengPerawataninen->pengperawatanlinen_no : "-"; ?></td>
        </tr>
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td><?php echo isset($modPengPerawataninen->ruangan->ruangan_nama) ? $modPengPerawataninen->ruangan->ruangan_nama : "-"; ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($modPengPerawataninen->keterangan_pengperawatanlinen) ? $modPengPerawataninen->keterangan_pengperawatanlinen : "-"; ?></td>
        </tr>
    </table><br><br>
	
	<table  class="table border">
		<thead>
			<tr>
				<th>Nama Linen</th>
				<th>Jenis Perawatan</th>
				<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach ($modPengPerawataninenDetail as $i=>$modLinen){ 
			?>
				<tr>
					<td><?php echo $modLinen->linen->namalinen; ?></td>
					<td><?php echo $modLinen->jenisperawatan; ?></td>
					<td><?php echo $modLinen->keterangan_pengperawatan; ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<table width="100%" style="margin-top:20px;">
    <tr>
		<td width="35%" align="center">
			<div>Mengajukan<br></div>
			<div style="margin-top:60px;"><?php echo isset($modPengPerawataninen->pegawaiMengajukan->nama_pegawai) ? $modPengPerawataninen->pegawaiMengajukan->nama_pegawai : "-"; ?></div>
		</td>
		<td width="35%" align="center">
			<div>Mengetahui</div>
			<div style="margin-top:60px;"><?php echo isset($modPengPerawataninen->pegawai->nama_pegawai) ? $modPengPerawataninen->pegawai->nama_pegawai : "-"; ?></div>
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

<?php
}
if ($caraPrint == 'PDF'){
?>
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
</div>
<div class="content">
     <br>
    <div class="judulcontent"> <?php echo $judul_print   ?> </div>
     <br>
 <table class="table border">
        <tr>
            <td>Tanggal Pengajuan Perawatan Linen</td>
            <td>:</td>
            <td><?php echo isset($modPengPerawataninen->tglpengperawatanlinen) ? $format->formatDateTimeId($modPengPerawataninen->tglpengperawatanlinen) : "-"; ?></td>
        </tr>
        <tr>
            <td>No. Pengajuan Perawatan Linen</td>
            <td>:</td>
            <td><?php echo isset($modPengPerawataninen->pengperawatanlinen_no) ? $modPengPerawataninen->pengperawatanlinen_no : "-"; ?></td>
        </tr>
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td><?php echo isset($modPengPerawataninen->ruangan->ruangan_nama) ? $modPengPerawataninen->ruangan->ruangan_nama : "-"; ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($modPengPerawataninen->keterangan_pengperawatanlinen) ? $modPengPerawataninen->keterangan_pengperawatanlinen : "-"; ?></td>
        </tr>
    </table><br><br>
	
	<table  class="table border">
		<thead>
			<tr>
				<th>Nama Linen</th>
				<th>Jenis Perawatan</th>
				<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach ($modPengPerawataninenDetail as $i=>$modLinen){ 
			?>
				<tr>
					<td><?php echo $modLinen->linen->namalinen; ?></td>
					<td><?php echo $modLinen->jenisperawatan; ?></td>
					<td><?php echo $modLinen->keterangan_pengperawatan; ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<table width="100%" style="margin-top:20px;">
    <tr>
		<td width="35%" align="center">
			<div>Mengajukan<br></div>
			<div style="margin-top:60px;"><?php echo isset($modPengPerawataninen->pegawaiMengajukan->nama_pegawai) ? $modPengPerawataninen->pegawaiMengajukan->nama_pegawai : "-"; ?></div>
		</td>
		<td width="35%" align="center">
			<div>Mengetahui</div>
			<div style="margin-top:60px;"><?php echo isset($modPengPerawataninen->pegawai->nama_pegawai) ? $modPengPerawataninen->pegawai->nama_pegawai : "-"; ?></div>
			<div></div>
		</td>
    </tr>
    </table>
</div>

<?php
}

 ?> 