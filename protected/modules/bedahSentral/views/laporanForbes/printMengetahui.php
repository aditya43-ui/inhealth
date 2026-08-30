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

echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>"", 'colspan'=>10));
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
<table style="width: 100%; border: none;">
	<tr>
            <th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
                &nbsp;
            </th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
		<?php 
		if(isset($modRencanaOperasi->tgl_mengetahui)){ ?>
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo isset($modRencanaOperasi->pegmengetahui_id)?$modRencanaOperasi->pegmengetahuis->nama_pegawai:"";?> )
		<?php } ?>			
		</th>
	</tr>
</table>