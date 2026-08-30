<style>
	body {
		color: black;
	}
	
    .tab_detail {
        width: 100%;
    }
    
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 2px;
    }
    
    
</style>
<?php 
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>"Rencana Lembur", 'colspan'=>'2'));  
$arrMenu = array();
                 // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>'Lihat Detail Rencana Lembur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
$this->menu=$arrMenu;
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'lihat-detail-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<table class="table-condensed tab_header">
    <tr>
        <td nowrap>Tgl. Rencana</td>
        <td>:</td>
        <td width="100%"><?php echo $modRencanaLembur->tglrencana; ?></td>
        <td>Mengetahui</td>
        <td>:</td>
        <td nowrap><?php
        
        if (!empty($modRencanaLembur->mengetahui_id)) {
            echo $modRencanaLembur->getPegawaiAttributes($modRencanaLembur->mengetahui_id,'nama_pegawai');
        }
        
        ?></td>
    </tr>
    <tr>
        <td nowrap>No. Rencana</td>
        <td>:</td>
        <td><?php echo $modRencanaLembur->norencana; ?></td>
        <td>Menyetujui</td>
        <td>:</td>
        <td nowrap><?php 
        
        if (!empty($modRencanaLembur->menyetujui_id)) {
            echo $modRencanaLembur->getPegawaiAttributes($modRencanaLembur->menyetujui_id,'nama_pegawai');
        }
        
        ?></td>
    </tr>
    <tr>
        <td>Keterangan</td>
        <td>:</td>
        <td><?php echo $modRencanaLembur->keterangan; ?></td>
        <td nowrap>Pemberi Tugas</td>
        <td>:</td>
        <td nowrap><?php 
        
        if (!empty($modRencanaLembur->pemberitugas_id)) {
            echo $modRencanaLembur->getPegawaiAttributes($modRencanaLembur->pemberitugas_id,'nama_pegawai');
        }
        
        ?></td>
    </tr>
</table>
<table id="tabelPegawaiLembur" class="tab_detail">
    <thead>
    <tr>
        <th>No.</th>
        <th>No. Induk Pegawai</th>
        <th>Nama Pegawai</th>
        <!--<th>Departemen</th>-->
        <th>Jam Mulai</th>
        <th>Jam Selesai</th>
            <th>Jenis Lembur</th>
        <th>Alasan Lembur</th>
        
    </tr>
    </thead>
    <tbody>
        <?php                    
            $tr = '';
            $no = 1;
            $format = new MyFormatter;
             foreach ($modDetail as $key => $detail) {
                    $modDetail[$key]->jamMulai = date('H:i', strtotime($modDetail[$key]->tglmulai));
                    $modDetail[$key]->jamSelesai = date('H:i', strtotime($modDetail[$key]->tglselesai));
					$lembur = BiayalemburM::model()->findByPk($detail->biayalembur_id);
                    $tr.="<tr>
                       <td style=\"text-align: right;\">". $no++. //CHtml::TextField('noUrut',$no++,array('class'=>'span1 noUrut','readonly'=>TRUE)).
                        "</td>
                       <td>".$modDetail[$key]->pegawai->nomorindukpegawai."</td>
                       <td>".$modDetail[$key]->pegawai->nama_pegawai."</td>
                       <td>".$modDetail[$key]->jamMulai."</td>
                       <td>".$modDetail[$key]->jamSelesai."</td>
                       <td>".$lembur->biayalembur_nama."</td>
                       <td>".$modDetail[$key]->alasanlembur."</td>
                       </tr>   
                   "; // <td>".$modDetail[$key]->pegawai->departement->departement_nama."</td>
                    
             }
             echo $tr;
        ?>
    </tbody>
</table>
            

<?php $this->endWidget(); ?>

