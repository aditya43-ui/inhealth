<style>
    .watermark
    {
       background-image: url(http://localhost/ehospitaljk/images/watermark_print.png);
       background-position: center 350px;
       background-size: 300px; /* CSS3 only, but not really necessary if you make a large enough image */
       position: absolute;
       background-repeat: no-repeat;
       width: 100%;
       margin: 0;
       z-index: 1000;
    }

</style>
<?php // if (isset($caraPrint)){ ?>
<style>
    th {
        border: 1px solid;
        background-color: transparent;
    }
    .grid td{
        border: 1px solid;
        background-color: transparent;
    }
    th{
        text-align: center;
        font-size: 11pt;
    }
    table{
        width: 100%;
    }
    .title td{
        font-size: 12pt;
        text-align: center;
        font-weight: bold;
        padding: 5px;
        background: #309C5C;
        color: #fff;
    }
</style>
<?php
    if(isset($modHasilPeriksa)){
        if($modHasilPeriksa->printhasillab == '1') {echo '<div class="watermark">';}
    }
?>
<?php /*
<div style="height:3cm;">
    &nbsp;
</div>
<table style="width:100%;font-family: arial;font-size: 10pt;">
    <tr ><?php $format=new MyFormatter();?>
        <td width="50%" style="border:none;"><p style="margin: 0; text-align: center;"><?php echo "Tasikmalaya, ".$format->formatDateTimeId(date('Y-m-d')); ?></p></td>
        <td width="15%" style="border:none;">Penanggungjawab</td>
        <td width="35%" style="border:none;">: <?php echo $pemeriksa->gelardepan." ".$pemeriksa->nama_pegawai.", ".$pemeriksa->gelarbelakang->gelarbelakang_nama; ?></td>
    </tr><br>
    <tr>
        <td style="border:none;"></td>
        <td style="border:none;">Izin</td>
        <td style="border:none;">: YM.01.05/8/455/IV.46/DKK/2008</td>
    </tr>
    <tr>
</table><br><br>
 *
 */ ?>
<?php
echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
?>
<table style="font-family: arial;font-size: 10pt;" class="grid">
    <tr>
        <td width="10%">No. Rad</td>
        <td width="40%">: <?php echo $masukpenunjang->no_masukpenunjang; ?></td>
        <td width="50%" colspan="2"></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: <?php echo $masukpenunjang->namadepan." ".$masukpenunjang->nama_pasien; ?></td>
        <td width="10%">Dokter</td>
        <td>: <?php echo $masukpenunjang->namaperujuk; ?></td>
    </tr>
    <tr>
        <td>Umur </td>
        <td>: <?php echo $masukpenunjang->umur."; ".$masukpenunjang->jeniskelamin; ?></td>
        <td>Alamat</td>
        <td>: <?php echo $masukpenunjang->alamatlengkapperujuk; ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>: <?php echo $masukpenunjang->alamat_pasien ?></td>
        <td>No. Telp</td>
        <td>: <?php echo $masukpenunjang->notelpperujuk; ?></td>
    </tr>
</table>
<div style="font-family:arial;font-size:10pt;">
    <b>
    <?php
        echo $masukpenunjang->no_rekam_medik . '/' . $masukpenunjang->ruanganasal_nama . '/' . $masukpenunjang->kelaspelayanan_nama;
    ?>
    </b>
</div>
<br>
<table border="1" width="100%" cellpadding="0" cellspacing="0" class="title">
    <tr>
        <td width="50%">BAGIAN RADIOLOGI</td>
        <td><?php echo !empty($pemeriksa->gelardepan) ? $pemeriksa->gelardepan: "" ." ".(!empty($pemeriksa->nama_pegawai) ? $pemeriksa->nama_pegawai : "").", ".(isset($pemeriksa->gelarbelakang_id) ? $pemeriksa->gelarbelakang->gelarbelakang_nama:""); ?></td>
    </tr>
</table>
<?php foreach($detailHasil as $i=>$detail):

    $studyID = $detail->study_uid;
    $accessionNumber = $masukpenunjang->no_masukpenunjang;
    $patientID = $detail->hasilpemeriksaanrad_id;

    $is_aktif = $detail->pacs_ok;


    ?>
    <table style="border:1px solid #000; margin:4px auto;"  width="100%">
        <tr style="border-bottom: 1px solid #000;">
            <td style="font-family: Arial; font-size: 11pt;font-weight: bold;">
                <?php echo $detail->pemeriksaanrad->pemeriksaanrad_nama;
                if (Yii::app()->user->getState('oviyam_aktif') == true) {
                    echo "&nbsp;&nbsp;".CHtml::link('<i class="far fa-eye"></i> Lihat Gambar', '#', array(
                        'class'=>'btn btn-info btn-xs',
                        'style' => 'color:#fff !important;',
                        'onclick'=>"lihatHasilPeriksa('".$studyID."', '".$accessionNumber."', '".$patientID."'); return false;",
                        'rel'=>'tooltip',
                        'title'=>'Klik untuk melihat Hasil dari PACS',
                        // 'disabled'=>!$is_aktif,
                    ));
                }
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info btn-xs', 'onclick'=>'print(\'PRINT\',"'.$detail->hasilpemeriksaanrad_id.'");')); 
                 ?>
            </td>
        </tr>
        <tr>
            <td class="isi_hasil">
                <?php echo (strlen($detail->hasilexpertise) > 0 ? $detail->hasilexpertise : ' - '); ?>
            </td>
        </tr>
        <tr>
            <td class="isi_hasil">
                <?php echo (strlen($detail->kesimpulan_hasilrad) > 0 ? $detail->kesimpulan_hasilrad : ' - '); ?>
            </td>
        </tr>
    </table>
<?php endforeach; ?>
<iframe id="frameWeasis" hidden></iframe>

<script>

function lihatHasilPeriksa(studyID, accessionNumber, patientID) {
    var server = "";
    <?php if (Yii::app()->user->getState('weasis_aktif') == true) {
         $modKonfig = KonfigsystemK::model()->find();
         $host_temp =  $modKonfig->weasis_host;
         $host_temp2 =  $modKonfig->weasis_port;
         $host_temp3 = $host_temp.":".$host_temp2;
         $host = "http://".$host_temp3;
    ?>

        $("#frameWeasis").attr("src", "<?php echo $host; ?>/weasis-pacs-connector/weasis?patientID=" + patientID + "&&studyUID=" + studyID);

    <?php } ?>

    <?php if (Yii::app()->user->getState('oviyam_aktif') == true) {
        $modKonfig = KonfigsystemK::model()->find();
        $host_temp =  $modKonfig->oviyam_host;
        $host_temp2 =  $modKonfig->oviyam_port;
        $host_temp3 = $host_temp.":".$host_temp2;
        $host = $host_temp3;
        $server = Yii::app()->user->getState('oviyam_server');


    ?>
        server = "<?php echo !empty($server) ? $server : "" ?>";
        window.open("<?php echo $host; ?>/oviyam2/oviyam?patientID=" + patientID + "&studyUID=" + studyID + "&serverName=" + server, "_blank", "location=_new, width=1024px");
        console.log("host temp "+'<?= $host_temp?>');
        console.log("host temp 2"+'<?= $host_temp2?>');
        console.log("host temp 3"+'<?= $host_temp3?>');
        console.log("host "+'<?= $host?>');
        // link-nya 
        // http://192.168.214.222:8080/oviyam2/viewer.html?patientID=1253&studyUID=1.2.840.86.755.8.3453.1.20769.100023007220202154343594031698&serverName=ServerUbuntu
        // link yang lama 
        // window.open("<?php // echo $host ?>/oviyam2/oviyam?patientID="+instalasi_id+"&pendaftaran_id="+pendaftaran_id,"",'location=_new, width=1024px');

        // $("#frameOviyam").attr("src", "<?php // echo $host; ?>/oviyam2/oviyam?serverName=<?php // echo $server; ?>&studyUID=" + studyID + "&accessionNumber=" + accessionNumber + "&patientID=" + patientID);
        // $("#dialogOviyam").dialog("open");
    <?php } ?>
}

</script>

<?php
//$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/HasilPeriksaPrint', array("pendaftaran_id"=>$masukpenunjang->pendaftaran_id,"pasien_id"=>$masukpenunjang->pasien_id,"pasienmasukpenunjang_id"=>$masukpenunjang->pasienmasukpenunjang_id));
$urlPrint=  Yii::app()->createAbsoluteUrl('radiologi/daftarPasien/printPemeriksaanRad');
$js = <<< JSCRIPT
function print(caraPrint,pemeriksaanrad_id)
{
    if(caraPrint == 'PRINT'){
    var jumlah = 0;
    jumlah++;
    var i = 0;
        for(var i=0;i < jumlah;i++){
            myConfirm("Apakah Anda Akan Mencetak Pemeriksaan Ini?","Perhatian!",function(r) {
                if(r){
                   // window.open("${urlPrint}&i="+i+"&caraPrint="+caraPrint+"&pemeriksaanrad_id="+pemeriksaanrad_id,"",'location=_new, width=1024px');
				    window.open("${urlPrint}&i="+i+"&caraPrint="+caraPrint+"&hasilpemeriksaan_id="+pemeriksaanrad_id,"",'location=_new, width=1024px');
                }
            });
        }
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,  CClientScript::POS_HEAD);
?>
