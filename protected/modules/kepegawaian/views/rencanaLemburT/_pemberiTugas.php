<style>
    .uang {
        text-align: right !important;
    }
</style>

<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status Pemberi Tugas berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert'); 
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
<div class="row">
    <div class="col-sm-6" style="text-align:center;">
		&nbsp;
	</div>
	<div class="col-sm-6" style="text-align:center;">
			<?php 
			if(isset($_GET['sukses'])){
				echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
				echo "Mengetahui,";
			}else{
				echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
				echo CHtml::link(Yii::t('mds',' Pemberi Tugas'), 
				$this->createUrl($this->id.'/index'), 
				array('class' => 'btn btn-danger',
					'onclick'=>'myConfirm("Apakah Anda yakin?","Perhatian!",
					function(r) {if(r) window.location = "'.$this->createUrl('ApprovePemberiTugas',array('rencanalembur_id'=>$model->rencanalembur_id,'approve'=>true)).'";} ); return false;'));  
			}
			?>
		</div>	
		<!--<div class="control-group">-->
			<!--( <?php // echo $model->getPegawaiAttributes($model->menyetujui_id,'nama_pegawai');?> )-->
		<!--</div>-->	
	<!--</div>-->
	<!--<div class="col-sm-6" style="text-align:center;">-->
<!--		<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
			Pegawai Tugas,
		</div>-->
		<div class="control-group">
			( <?php echo $model->getPegawaiAttributes($model->pemberitugas_id,'nama_pegawai');?> )
		</div>
	<!--</div>-->
</div>

<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    $urlPrint= $this->createUrl('printApprovePemberiTugas',array('rencanalembur_id'=>$model->rencanalembur_id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>