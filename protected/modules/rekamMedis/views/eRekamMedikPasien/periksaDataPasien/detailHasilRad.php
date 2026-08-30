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
        <td><?php echo $pemeriksa->gelardepan." ".$pemeriksa->nama_pegawai.", ".(isset($pemeriksa->gelarbelakang_id) ? $pemeriksa->gelarbelakang->gelarbelakang_nama:""); ?></td>
    </tr>
</table>
<?php foreach($detailHasil as $i=>$detail):

    $studyID = $detail->hasilpemeriksaanrad_id;
    $accessionNumber = $masukpenunjang->no_masukpenunjang;
    $patientID = $masukpenunjang->no_rekam_medik;

    $is_aktif = $detail->pacs_ok && !empty($detail->hasilexpertise) && trim($detail->hasilexpertise) != "";


    ?>
    <table style="border:1px solid #000; margin:4px auto;"  width="100%">
        <tr style="border-bottom: 1px solid #000;">
            <td style="font-family: Arial; font-size: 11pt;font-weight: bold;">
                <?php echo $detail->pemeriksaanrad->pemeriksaanrad_nama;
                if (Yii::app()->user->getState('weasis_aktif') == true) {
                    echo "&nbsp;&nbsp;".CHtml::link('<i class="far fa-eye"></i> Lihat Gambar', '#', array(
                        'class'=>'btn btn-info btn-xs',
                        'style' => 'color:#fff !important;',
                        'onclick'=>"lihatHasilPeriksa('".$studyID."', '".$accessionNumber."', '".$patientID."'); return false;",
                        'rel'=>'tooltip',
                        'title'=>'Klik untuk melihat Hasil dari PACS',
                        'disabled'=>!$is_aktif,
                    ));
                }

                 ?>
            </td>
        </tr>
        <tr>
            <td class="isi_hasil">
                <?php echo (strlen($detail->hasilexpertise) > 0 ? $detail->hasilexpertise : ' - '); ?>
            </td>
        </tr>
    </table>
<?php endforeach; ?>
<iframe id="frameWeasis" hidden></iframe>

<script>

function lihatHasilPeriksa(studyID, accessionNumber, patientID) {
    <?php if (Yii::app()->user->getState('weasis_aktif') == true) {
        $host = Yii::app()->user->getState('weasis_host').":".Yii::app()->user->getState('weasis_port');
    ?>

    $("#frameWeasis").attr("src", "<?php echo $host; ?>/weasis-pacs-connector/weasis?studyUID=" + studyID + "&&accessionNumber=" + accessionNumber + "&&patientID=" + patientID);

    <?php } ?>
}

</script>
