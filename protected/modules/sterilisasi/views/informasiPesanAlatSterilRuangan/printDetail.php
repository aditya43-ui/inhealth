<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<fieldset>
    <table class="items table table-striped table-bordered table-condensed">
        <tr>
            <td>No. Pemesanan</td>
            <td>:</td>
            <td><?php echo isset($model->pesanperlinensteril_no) ? $model->pesanperlinensteril_no : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pemesanan</td>
            <td>:</td>
            <td><?php echo isset($model->pesanperlinensteril_tgl) ? MyFormatter::formatDateTimeForUser($model->pesanperlinensteril_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Pemesanan</td>
            <td>:</td>
            <td><?php echo (isset($model->pegawaiMemesan->NamaLengkap) ? $model->pegawaiMemesan->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->pesanperlinensteril_ket) ? $model->pesanperlinensteril_ket : "-"; ?></td>
        </tr>
    </table><br>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>Nama Peralatan dan Linen</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modDetails) > 0){
				$disabled = false;
                foreach($modDetails AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->pesan->ruangan_id) ? $detail->pesan->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->barang->barang_id) ? $detail->barang->barang_id : ""); ?></td>
                <td><?php echo (!empty($detail->pesanperlinensterildet_jml) ? $detail->pesanperlinensterildet_jml : ""); ?></td>
                <td><?php echo (!empty($detail->pesanperlinensterildet_ket) ? $detail->pesanperlinensterildet_ket : ""); ?></td>
            </tr>
            <?php    }
            }else{ $disabled = false;
            ?>
			<tr>
				<td colspan="5">Data tidak ditemukan.</td>
			</tr>
			<?php } ?>
        </tbody>
    </table>
</fieldset>

<table class="table">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
			Mengetahui,
			<br><br><br><br><br><br>
			( <?php echo isset($model->pegmengetahui_id) ? $model->pegawaiMengetahui->NamaLengkap : "-";?> )		
		</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
			Memesan,
			<br><br><br><br><br><br>
			( <?php echo $model->pegawaiMemesan->NamaLengkap;?> )
		</th>
	</tr>
</table>