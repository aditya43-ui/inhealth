<?php
//check pegawai login berdasarkan jabatan_id
$checkLoginPegawai = false;
$modePgLogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
if(isset($modePgLogin)){
    if($modePgLogin->jabatan_id == 71 || $modePgLogin->jabatan_id == 131 ||$modePgLogin->jabatan_id == 97){
        $checkLoginPegawai = true;
    }
}
?>
<style>
    body {
        color: black;
    }
    
    .tab_detail {
        width: 100%;
    }
    
    .tab_detail th {
        font-weight: bold;
    }
    
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 2px;
        color: black;
    }
    
    
</style>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'lihat-detail-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<div><br>
<table class="table-condensed" width="100%">
        <tr>
            <td nowrap>Tgl. Realisasi</td>
            <td>:</td>
            <td width="100%"><?php echo MyFormatter::formatDateTimeForUser($modRealisasiLembur->tglrealisasi); ?></td>
<!--<td>Mengetahui</td>
            <td>:</td>
            <td nowrap><?php 
//            if (!empty($modRealisasiLembur->mengetahui_id))
//                echo $modRealisasiLembur->pegawaimengetahui->nama_pegawai;
            ?></td>-->
        </tr>
        <tr>
            <td nowrap>No Realisasi</td>
            <td>:</td>
            <td><?php echo $modRealisasiLembur->norealisasi; ?></td>
            <td>Menyetujui</td>
            <td>:</td>
            <td nowrap><?php 
            if (!empty($modRealisasiLembur->menyetujui_id))
                echo $modRealisasiLembur->pegawaimenyetujui->nama_pegawai;
            ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $modRealisasiLembur->keterangan; ?></td>
            <td nowrap>Pemberi Tugas</td>
            <td>:</td>
            <td nowrap><?php 
            if (!empty($modRealisasiLembur->pemberitugas_id))
                echo $modRealisasiLembur->pemberitugas->nama_pegawai;
            ?></td>
        </tr>
</table></div>

<table id="tabelKaryawanLembur" class="tab_detail">
    <thead>
    <tr><tr>
            <th style="text-align: center;" rowspan="2">No.</th>
            <th style="text-align: center;" rowspan="2">No. Induk Pegawai</th>
            <th style="text-align: center;" rowspan="2">Nama Pegawai</th>
            <th style="text-align: center;" rowspan="2">Jam Mulai</th>
            <th style="text-align: center;" rowspan="2">Jam Selesai</th>
            <th style="text-align: center;" rowspan="2">Total Jam Lembur</th>
            <th style="text-align: center;" rowspan="2">Jam Normal</th>
            <th style="text-align: center;" rowspan="2">Upah Sejam Lembur Hari Kerja</th>
            <th style="text-align: center;" rowspan="2">Upah Bulanan</th>
            <th style="text-align: center;" colspan="3">Upah Lembur</th>
            <th style="text-align: center;" rowspan="2">Total</th>
            <th style="text-align: center;" rowspan="2">Alasan Lembur</th>
        </tr>
            <th>Jam ke-1</th>
            <th>Jam ke-2</th>
            <th>Jam ke-3</th>
        <tr>
        
    </tr>
    </thead>
    <tbody>
        <?php                    
            $tr = '';
            $no = 1;
            $format = new MyFormatter;
             foreach ($modDetail as $key => $detail) {
                    $modDetail[$key]->jamMulai = date('H:i:s', strtotime($modDetail[$key]->tglmulai));
                    $modDetail[$key]->jamSelesai = date('H:i:s', strtotime($modDetail[$key]->tglselesai));
                    $tr.="<tr>
                       <td>". $no++ ."</td>
                       <td>".$modDetail[$key]->pegawai->nomorindukpegawai."</td>
                       <td>".$modDetail[$key]->pegawai->nama_pegawai."</td>
                       
                       <td>".$modDetail[$key]->jamMulai."</td>
                       <td>".$modDetail[$key]->jamSelesai."</td>
                       <td style='text-align: right;'>".$modDetail[$key]->total_jam."</td>
                       <td style='text-align: right;'>".$modDetail[$key]->total_jam_normal."</td>
                        <td style='text-align: right;'>".(($checkLoginPegawai == true)?MyFormatter::formatNumberForPrint($modDetail[$key]->upahsejamlembur):"Hidden")."</td>
                       <td style='text-align: right;'>".(($checkLoginPegawai == true)?MyFormatter::formatNumberForPrint($modDetail[$key]->upah_bulanan):"Hidden")."</td>
                       <td style='text-align: right;'>".(($checkLoginPegawai == true)?MyFormatter::formatNumberForPrint($modDetail[$key]->nilai_lembur):"Hidden")."</td>
                       <td style='text-align: right;'>".(($checkLoginPegawai == true)?MyFormatter::formatNumberForPrint($modDetail[$key]->upah_lembur_jam2):"Hidden")."</td>
                       <td style='text-align: right;'>".(($checkLoginPegawai == true)?MyFormatter::formatNumberForPrint($modDetail[$key]->upah_lembur_jam3):"Hidden")."</td>
                       <td style='text-align: right;'>".(($checkLoginPegawai == true)?MyFormatter::formatNumberForPrint($modDetail[$key]->total_nilai_lembur):"Hidden")."</td>
                       <td>".$modDetail[$key]->alasanlembur."</td>
                       </tr>   
                   "; //<td>".$modDetail[$key]->pegawai->departement->departement_nama."</td>
                    
             }
             echo $tr;
        ?>
    </tbody>
</table>
<div class="form-actions">
        <?php 
		echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
		echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
		?>	
	</div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print&id='.$modRealisasiLembur->realisasilembur_id);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}   
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);  

?>
<?php $this->endWidget(); ?>

