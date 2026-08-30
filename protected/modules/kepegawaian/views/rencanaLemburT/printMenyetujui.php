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
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
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

echo $this->renderPartial('application.views.headerReport.headerDefaultNewest',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<table bgcolor='white' class='table' style = "box-shadow:none;">
    <tr bgcolor='white' >
        <td>
             <b><?php echo CHtml::encode($model->getAttributeLabel('tglrencana')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($model->tglrencana); ?>
        </td>
        <td>
            &nbsp;
        </td>    
        <td>
            <b><?php echo CHtml::encode($model->getAttributeLabel('norencana')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($model->norencana); ?></td>
    </tr>
     <tr>
        <td>
             <b><?php echo CHtml::encode($model->getAttributeLabel('keterangan')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($model->keterangan); ?>
        </td>
    </tr>
        
</table>

<table id="tableBarang" class="table border" bgcolor='white'>
    <thead>
        <th>No.Urut</th>
        <th>No. Induk Pegawai</th>
        <th>Nama Pegawai</th>
        <th>Jam Mulai</th>
        <th>Jam Selesai</th>
        <th>Jenis Lembur</th>
        <th>Alasan Lembur</th>
    </thead>
    <tbody>
    <?php
    $no=1;
        foreach($modDetail AS $detail): ?>
        <?php $modPegawai = PegawaiM::model()->findByPk($detail->pegawai_id);
            $lembur = BiayalemburM::model()->findByPk($detail->biayalembur_id);
        ?>
            <tr bgcolor='white'>   
                <td bgcolor='white'><?php echo $no; ?></td>
                <td bgcolor='white'><?php echo !empty($modPegawai->nomorindukpegawai)?$modPegawai->nomorindukpegawai:null;  ?></td>
                <td bgcolor='white'><?php echo !empty($modPegawai->nama_pegawai)?$modPegawai->nama_pegawai:null;  ?></td>
                <td bgcolor='white'><?php echo !empty($detail->tglmulai)?date('H:i:s', strtotime($detail->tglmulai)):null; ?></td>
                <td bgcolor='white'><?php echo !empty($detail->tglselesai)?date('H:i:s', strtotime($detail->tglselesai)):null; ?></td>
                <td bgcolor='white'><?php echo !empty($detail->biayalembur_id)?$lembur->biayalembur_nama:null; ?></td>
                <td bgcolor='white'><?php echo $detail->alasanlembur; ?></td>
            </tr>   
            <?php 
        $no++;
        
        endforeach;
     
    ?>
    </tbody>
</table>
<table style="width: 100%; border: none;">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
		<?php 
		if(isset($model->tgl_menyetujui)){ ?>
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo $model->getPegawaiAttributes($model->menyetujui_id,'nama_pegawai');?> )
		<?php } ?>			
		</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
			Pemberi Tugas,
			<br><br><br><br><br><br>
			( <?php echo $model->getPegawaiAttributes($model->pemberitugas_id,'nama_pegawai');?> )
		</th>
	</tr>
</table>