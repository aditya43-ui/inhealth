<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<h3>HASIL PEMERIKSAAN PENUNJANG</h3>
<h3>Laboratorium</h3>
<table id="tblListPemeriksaanLab" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>No. Lab</th>
            <th>Dari Lab</th>
            <th>Tanggal Order</th>
            <th>Tanggal Selesai</th>
            <th>Lihat Hasil</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
    $modPermintaan = RJPermintaanPenunjangT::model()->with('daftartindakan','pemeriksaanlab')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));

    // echo '<pre>'; var_dump($modPermintaan); die;
    ?>
    <tr>
        <td><?php echo "-"; ?></td>
        <td><?php echo $riwayat->ruangan->ruangan_nama; ?></td>
        <td><?php echo MyFormatter::formatDateTimeForUser($riwayat->tgl_kirimpasien); ?></td>
        <td><?php echo "-"; ?></td>
        <td><?php echo CHtml::button("Lihat Detail", array('class' => 'btn btn-primary', 'onclick' => '$("#table-penunjang").slideToggle("slow");'))  ?></td>
    </tr>
    <?php
}
?>
    </tbody>
    
</table>
<?php if(!empty($hasil)):?>
    <table id="table-penunjang" class="table table-bordered table-condensed">
        <tbody>
            <?php 
//var_dump($hasil['data']); die;

if (empty($hasil['data'])) {
    $hasil['data'] = array();
} 
foreach($hasil['data'] as $data):
?>
                <tr>
                    <td>
                        <?php echo CHtml::link($data['nama'], $data['url'], array('rel' => 'tooltip', 'title' => 'Klik untuk melihat hasil pemeriksaan penunjang', "target" => "iframeHasil", "onclick" => '$("#dialogHasil").dialog("open");',)) ?>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
<?php endif; ?>


<br/>
<?php if(!isset($_GET['is_lab'])):?>
<h3>Radiologi</h3>
<table id="tblListPemeriksaanRad" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>No. Rad</th>
            <th>Nama Pemeriksaan</th>
            <th>Tanggal Order</th>
            <th>Tanggal Selesai</th>
            <th width='250'>Lihat Hasil</th>
        </tr>
    </thead>
    <tbody>
    <?php 
	$res = ListAllOrder::getLoadHasilList($no_register);
        foreach ($res as $item) { ?>
        <tr>
            <td><?php echo $item['nofoto']; ?></td>
            <td><?php echo $item['reques']; ?></td>
            <td><?php echo $item['mulai']; ?></td>
            <td><?php echo $item['akhir']; ?></td>
            <td><?php
		echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'print(\'PRINT\',\'\', \''.$item['nofoto'].'\');')); 
                echo CHtml::link(Yii::t('mds', '{icon} Lihat Foto', array('{icon}'=>'<i class="entypo-eye"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'printFoto("'.$modPendaftaran->pasien->no_rekam_medik.'","'.$item['nofoto'].'");')); 
	    ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php endif;?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogHasil',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Hasil Pemeriksaan</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => true
    ),
));
?>
<iframe name='iframeHasil' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
//$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/HasilPeriksaPrint', array("pendaftaran_id"=>$masukpenunjang->pe>
$urlPrint=  Yii::app()->createAbsoluteUrl('/radiologi/daftarPasien/printPemeriksaanRad');
$urlPrintFoto=  Yii::app()->createAbsoluteUrl('/radiologi/daftarPasien/viewFoto');
$js = <<< JSCRIPT
function print(caraPrint, pasienmasukpenunjang_id, nofoto)
{
    if(caraPrint == 'PRINT'){
    var jumlah = 0;
    jumlah++;
    var i = 0;
        for(var i=0;i < jumlah;i++){
            myConfirm("Apakah Anda Akan Mencetak Pemeriksaan Ini?","Perhatian!",function(r) {
                if(r){
                   // window.open("${urlPrint}&i="+i+"&caraPrint="+caraPrint+"&pemeriksaanrad_id="+pemeriksaanrad_id,"",'location=_new, width>
                                    window.open("${urlPrint}&i="+i+"&caraPrint="+caraPrint+"&pasienmasukpenunjang_id="+pasienmasukpenunjang_id+"&nofoto="+nofoto,"",'location=_new, width=1024px');
                }
            });
        }
    }
}

function printFoto(no_register, nofoto) {
    window.open("${urlPrintFoto}&no_register=" + no_register + "&nofoto="+nofoto,"",'location=_new, width=1024px');   
}



JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,  CClientScript::POS_HEAD);
?>
