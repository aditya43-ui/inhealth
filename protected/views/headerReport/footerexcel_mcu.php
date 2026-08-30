
<?php
    $modUser = LoginpemakaiK::model()->findByPK(Yii::app()->user->id);
    $modProfile = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    $cekPegawai = PegawaiM::model()->findByPk($modUser->pegawai_id);
//    echo $modUser->nama_pemakai.' '.date('Y-m-d H:i:s');
?>

<div>
<div>
    <?php echo $modProfile->kabupaten->kabupaten_nama." , ".date('d ').MyFormatter::getMonthId(date('m')).date(' Y')."<br/><br/>"; ?>
    <?php echo "Bagian Unit Kerja: ".InstalasiM::model()->findByPk(Yii::app()->user->getState('instalasi_id'))->instalasi_nama; ?> 
    <?php //echo Yii::app()->user->getState('kabupaten_nama')." , ".date("d M Y"); ?>
    <br/><br/><br/><br/>
    <?php
        if (empty($cekPegawai->namaLengkap)) { 
            echo "( .............................. )";
        } else {
            echo $cekPegawai->namaLengkap."<br/><br/>"."NIP.".$cekPegawai->nomorindukpegawai ;
        }
    ?>
</div>
</div>