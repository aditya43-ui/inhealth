<style>
    body {
        color: black;
    }
    
    .border th, .border td{
        border:1px solid #000;
        padding: 2px;
    }
    
   
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
    
    .text-center{
        text-align: center !important;
    }
</style>
<?php 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Data Approvement berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert'); 
?>

<?php
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>'', 'deskripsi'=>'', 'colspan'=>10));

?>


<table width="100%" style='margin-left:auto; margin-right:auto;' class ="border">
    <thead class="border">
        <th>No.</th>
        <th>Tanggal Pengajuan</th>
        <th>No. Register</th>
        <th>Nama Karyawan</th>
        <th>Unit Kerja</th>
        <th>Tanggal Presensi</th>                                                
        <th>Jam Masuk</th>
        <th>Jam Keluar</th>
        <th>Alasan</th>
        <th>Keterangan</th>
        <th>Mengetahui</th>
        <th>Menyetujui</th>
    </thead>
    <tbody>
        <tr class="border">
            <td>1</td>
            <td><?php echo (!empty($model->tglpengajuan)? MyFormatter::formatDateTimeForUser($model->tglpengajuan):""); ?></td>
            <td><?php echo $model->pegawai->nomorindukpegawai; ?></td>
            <td><?php echo $model->pegawai->namaLengkap; ?></td>
            <td><?php echo (!empty($model->pegawai->unitkerja)? $model->pegawai->unitkerja->namaunitkerja:""); ?></td>
            <td><?php echo (!empty($model->tglabnormalabsen)? MyFormatter::formatDateTimeForUser($model->tglabnormalabsen):""); ?></td>
            <td><?php echo $model->jammasuk; ?></td>
            <td><?php echo $model->jamkeluar; ?></td>    
            <td><?php echo $model->alasan; ?></td>
            <td><?php echo $model->keterangan; ?></td>
            <td><?php echo (!empty($model->pegawaimengetahui)? $model->pegawaimengetahui->namaLengkap : "").'<br/>'. (!empty($model->tglmengetahui)? MyFormatter::formatDateTimeForUser($model->tglmengetahui):""); ?></td>
            <td><?php echo (!empty($model->pegawaimenyetujui)? $model->pegawaimenyetujui->namaLengkap : "").'<br/>'. (!empty($model->tglmenyetujui)? MyFormatter::formatDateTimeForUser($model->tglmenyetujui):""); ?></td>
        </tr>
    </tbody>
</table>
<br><br>
<div class="row">
	<div class="col-sm-6" style="text-align:center;">
        <?php if($type == 'mengetahui'){ ?>
			<?php 
			if(isset($_GET['sukses'])){
				echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
				echo "Mengetahui";
			}else{
				echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
				echo CHtml::link(Yii::t('mds',' Mengetahui'), 
				$this->createUrl($this->id.'/index'), 
				array('class' => 'btn btn-danger',
					'onclick'=>'myConfirm("Apakah Anda yakin akan Menyetujui Abnormal Absen ini?","Perhatian!",
					function(r) {if(r) window.location = "'.$this->createUrl('Approve',array('abnormalabsen_id'=>$model->abnormalabsen_id,'type'=>$type,'approve_status'=>Params::STATUS_ABNORMALABSEN_DISETUJUI)).'";} ); return false;'));  
			}
			?>
		</div>	
		<div class="control-group">
			( <?php echo (!empty($model->pegawaimengetahui)? $model->pegawaimengetahui->namaLengkap : "");?> )
		</div>	
        <?php }else{ ?>
            <div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
			    Mengetahui
            </div>
            <div class="control-group">
                ( <?php echo (!empty($model->pegawaimengetahui)? $model->pegawaimengetahui->namaLengkap : "");?> )
            </div>
        <?php } ?>
	</div>
   
	<div class="col-sm-6" style="text-align:center;">
        <?php if($type == 'menyetujui'){ ?>
			<?php 
			if(isset($_GET['sukses'])){
				echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
                    echo (!empty($model->statuspersetujuan)? ucfirst($model->statuspersetujuan) : "");
			}else{
				echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>"; ?>
                <br>    
                <?php
				echo CHtml::link(Yii::t('mds',' Menyetujui'), 
				$this->createUrl($this->id.'/index'), 
				array('class' => 'btn btn-danger',
					'onclick'=>'myConfirm("Apakah Anda yakin akan Menyetujui Abnormal Absen ini?","Perhatian!",
					function(r) {if(r) window.location = "'.$this->createUrl('Approve',array('abnormalabsen_id'=>$model->abnormalabsen_id,'type'=>$type,'approve_status'=>Params::STATUS_ABNORMALABSEN_DISETUJUI)).'";} ); return false;'));  
					echo "&nbsp";
					echo CHtml::link(Yii::t('mds',' Menolak'), 
					$this->createUrl($this->id.'/index'), 
					array('class'=>'btn btn-default',
						'onclick'=>'myConfirm("Apakah Anda yakin akan Menolak Abnormal Absen ini?","Perhatian!",
						function(r) {if(r) window.location = "'.$this->createUrl('Approve',array('abnormalabsen_id'=>$model->abnormalabsen_id,'type'=>$type,'approve_status'=>Params::STATUS_ABNORMALABSEN_DITOLAK)).'";} ); return false;'));  
			}
			?>
		</div>
		<div class="control-group">
			( <?php echo $model->pegawaimenyetujui->NamaLengkap;?> )
		</div>
        <?php } ?>
	</div>
</div>



