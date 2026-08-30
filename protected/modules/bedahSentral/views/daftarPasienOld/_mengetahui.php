<style>
    .uang {
        text-align: right !important;
    }
</style>

<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>"", 'colspan'=>10));
 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status Menyetujui berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert'); 
?>
<h4><b>Data Pasien</b></h4>
<table bgcolor='white' class='table' style = "box-shadow:none;">
    <tr bgcolor='white' >
        <td>
             <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('tgl_pendaftaran')); ?></b>
        </td>
        <td>
            : <?php echo !empty($modPasienMasukPenunjang->tgl_pendaftaran)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($modPasienMasukPenunjang->tgl_pendaftaran)))):"-" ?>
        </td>
        <td>
            &nbsp;
        </td>    
        <td>
            <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('no_rekam_medik')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modPasienMasukPenunjang->no_rekam_medik); ?></td>
    </tr>
    <tr bgcolor='white' >
        <td>
             <b>No. Pendaftaran - Penunjang</b>
        </td>
        <td>
            : <?php echo CHtml::encode($modPasienMasukPenunjang->no_pendaftaran); ?> - <?php echo CHtml::encode($modPasienMasukPenunjang->no_masukpenunjang); ?>
        </td>
        <td>
            &nbsp;
        </td>    
        <td>
            <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('jeniskelamin')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modPasienMasukPenunjang->jeniskelamin); ?></td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('umur')); ?></b>
        </td>
        <td>  
            : <?php echo CHtml::encode($modPasienMasukPenunjang->umur); ?>
        </td>
        <td>
            &nbsp;
        </td> 
         <td> 
            <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('nama_pasien')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modPasienMasukPenunjang->nama_pasien); ?></td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('jeniskasuspenyakit_nama')); ?></b>
        </td>
        <td>  
            : <?php echo CHtml::encode($modPasienMasukPenunjang->jeniskasuspenyakit_nama); ?>
        </td>
        <td>
            &nbsp;
        </td> 
         <td> 
            <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('kelaspelayanan_nama')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modPasienMasukPenunjang->kelaspelayanan_nama); ?></td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('ruanganasal_nama')); ?></b>
        </td>
        <td>  
            : <?php echo CHtml::encode($modPasienMasukPenunjang->ruanganasal_nama); ?>
        </td>
        <td>
            &nbsp;
        </td> 
         <td> 
            <b>Kelas Tanggungan</b>            
        </td>
        <td>: <?php echo CHtml::encode($modPasienMasukPenunjang->kelastanggungan_nama); ?></td>
    </tr>
     <tr>
        <td>
             <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('Dokter Penerima')); ?></b>
        </td>
        <td>  
            : <?php echo CHtml::encode($modPasienMasukPenunjang->dokterpenerima_nama); ?>
        </td>
        <td>
            &nbsp;
        </td> 
         <td> 
            <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('Jenis Penjamin')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modPasienMasukPenunjang->penjamin_nama); ?></td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('DPJP')); ?></b>
        </td>
        <td>  
            : <?php echo CHtml::encode($modPasienMasukPenunjang->dpjp_nama); ?>
        </td>
        <td>
            &nbsp;
        </td> 
         <td> 
            <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('Penjamin')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modPasienMasukPenunjang->carabayar_nama); ?></td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('Kamar')); ?></b>
        </td>
        <td>  
            : <?php echo CHtml::encode($modPasienMasukPenunjang->kamarruangan_nokamar); ?>
        </td>
        <td>
            &nbsp;
        </td> 
         <td> 
            <b><?php echo CHtml::encode($modPasienMasukPenunjang->getAttributeLabel('No. Bed')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modPasienMasukPenunjang->kamarruangan_nobed); ?></td>
    </tr>
</table>
 
 <h4><b>Data Rencana Operasi</b></h4>
 <table bgcolor='white' class='table' style = "box-shadow:none;">
    <tr bgcolor='white' >
        <td>
             <b><?php echo CHtml::encode($modRencanaOperasi->getAttributeLabel('tglrencanaoperasi')); ?></b>
        </td>
        <td>
            : <?php echo !empty($modRencanaOperasi->tglrencanaoperasi)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($modRencanaOperasi->tglrencanaoperasi)))):"-" ?>
        </td>
        <td>
            &nbsp;
        </td>    
        <td>
            <b><?php echo CHtml::encode($modRencanaOperasi->getAttributeLabel('kamarruangan_id')); ?></b>            
        </td>
        <td>: <?php 
            $modKamar = KamarruanganM::model()->findByPk($modRencanaOperasi->kamarruangan_id);
        echo CHtml::encode(isset($modKamar)?$modKamar->kamarruangan_nokamar:""); ?></td>
    </tr>
    <tr bgcolor='white' >
        <td>
             <b><?php echo CHtml::encode($modRencanaOperasi->getAttributeLabel('Operator')); ?></b>
        </td>
        <td>
            : <?php 
            $modOp = PegawaiM::model()->findByPk($modRencanaOperasi->dokterpelaksana1_id);
            echo CHtml::encode(isset($modOp)?$modOp->nama_pegawai:""); ?>
        </td>
        <td>
            &nbsp;
        </td>    
       <td>
             <b><?php echo CHtml::encode($modRencanaOperasi->getAttributeLabel('Asisten Operator')); ?></b>
        </td>
        <td>
            : <?php 
            $modPlk = PegawaiM::model()->findByPk($modRencanaOperasi->dokterpelaksana2_id);
            echo CHtml::encode(isset($modPlk)?$modPlk->nama_pegawai:""); ?>
        </td>
    </tr>
    <tr bgcolor='white' >
        <td>
             <b><?php echo CHtml::encode($modRencanaOperasi->getAttributeLabel('Petugas RR')); ?></b>
        </td>
        <td>
            : <?php 
            $modStr = PegawaiM::model()->findByPk($modRencanaOperasi->suster_id);
            echo CHtml::encode(isset($modStr)?$modStr->nama_pegawai:""); ?>
        </td>
        <td>
            &nbsp;
        </td>    
       <td>
             <b><?php echo CHtml::encode($modRencanaOperasi->getAttributeLabel('Perawat Instrument')); ?></b>
        </td>
        <td>
            : <?php 
            $modBdn = PegawaiM::model()->findByPk($modRencanaOperasi->bidan_id);
            echo CHtml::encode(isset($modBdn)?$modBdn->nama_pegawai:""); ?>
        </td>
    </tr>
    <tr bgcolor='white' >
        <td>
             <b><?php echo CHtml::encode($modRencanaOperasi->getAttributeLabel('Perawat Sirkuler')); ?></b>
        </td>
        <td>
            : <?php 
            $modPrs = PegawaiM::model()->findByPk($modRencanaOperasi->perawatsirkuler_id);
            echo CHtml::encode(isset($modPrs)?$modPrs->nama_pegawai:""); ?>
        </td>
        <td>
            &nbsp;
        </td>    
       <td>
             <b><?php echo CHtml::encode($modRencanaOperasi->getAttributeLabel('keterangan_rencana')); ?></b>
        </td>
        <td>
            : <?php 
            echo CHtml::encode($modRencanaOperasi->keterangan_rencana); ?>
        </td>
    </tr>
    
 </table> 
 
 <div class="row">
     <div class="col-sm-6" style="text-align:center;">
		&nbsp;
	</div>
    <div class="col-sm-6" style="text-align:center;">
            <?php 
            if(isset($_GET['sukses'])){
                    echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
//                    echo "Menyetujui,";
            }else{
                    echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
                    echo CHtml::link(Yii::t('mds',' Menyetujui'), 
                    $this->createUrl($this->id.'/index'), 
                    array('class' => 'btn btn-danger',
                            'onclick'=>'myConfirm("Apakah Anda yakin?","Perhatian!",
                            function(r) {if(r) window.location = "'.$this->createUrl('ApproveMengetahui',array('pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id,'approve'=>true)).'";} ); return false;'));  
            }
            ?>
       
    </div>	
    <div class="control-group">
            ( <?php echo isset($modRencanaOperasi->pegmengetahui_id)?$modRencanaOperasi->pegmengetahuis->nama_pegawai:"";?> )
        </div>
     
</div>
 
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    $urlPrint= $this->createUrl('printApproveMengetahui',array('pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id));
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