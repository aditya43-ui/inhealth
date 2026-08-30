<?php 
    $profil = ProfilrumahsakitM::model()->find(array(
        'order'=>'profilrs_id'
    ));

    $isdetail = false;
    if(isset($isDetail) && $isDetail == 1){
        $isdetail = true;
    }
?>

<h4 style="text-align: center">Hak & Kewajiban Pasien</h4>

<p>Hak Pasien dan Keluarga di <?php echo $profil->nama_rumahsakit; ?>: </p>

<?php echo CHtml::hiddenField('hak_pasien_pendaftaran_id', $model->pendaftaran_id); ?>

<ul>
    <?php 

    $hak = HakpasienM::model()->findAllByAttributes(array(
        'hakpasien_aktif'=>true,
        'kelompok' => "Hak"
    ), array(
        'order'=>'hakpasien_urutan'
    ));

    /*
    Yii::app()->user->setState('hak_pasien_sudah_baca', null);
    Yii::app()->user->setState('ceklis_hak_pasien_'.$this->id, null);
    Yii::app()->user->setState('hak_pasien_sudah_baca_'.$this->id, null);
    */

    $session_ceklis_hak_pasien = Yii::app()->user->getState('ceklis_hak_pasien_'.$this->id);
    $session_sudah_baca = Yii::app()->user->getState('hak_pasien_sudah_baca_'.$this->id);

    $if_sudah_baca = (!empty($session_sudah_baca) && $session_sudah_baca == 1) || $model->isbacahakpasien == true;

    // var_dump((!empty($session_sudah_baca) && $session_sudah_baca == 1), $model->isbacahakpasien); die;
        
    foreach ($hak as $item) { ?>

        <li>
            <?php echo $item->hakpasien_nama; ?>
        </li>

    <?php } ?>
</ul>

<div id="tampil">
    <p>Kewajiban Pasien dan Keluarga di <?php echo $profil->nama_rumahsakit; ?>: </p>
    <ul>
        
        <?php 

        $hak = HakpasienM::model()->findAllByAttributes(array(
            'hakpasien_aktif'=>true,
            'kelompok' => "Kewajiban"
        ), array(
            'order'=>'hakpasien_urutan'
        ));

        $session_ceklis_kewajiban_pasien = Yii::app()->user->getState('ceklis_kewajiban_pasien_'.$this->id);
        $session_sudah_baca_kewajiban = Yii::app()->user->getState('kewajiban_pasien_sudah_baca_'.$this->id);

        $if_sudah_baca = (!empty($session_sudah_baca_kewajiban) && $session_sudah_baca_kewajiban == 1) || $model->isbacahakpasien == true;

        // var_dump((!empty($session_sudah_baca) && $session_sudah_baca == 1), $model->isbacahakpasien); die;
            
        foreach ($hak as $item) { ?>

            <li>
                <?php echo $item->hakpasien_nama; ?>
            </li>

        <?php } ?>
    </ul>
    <?php echo $form->checkBox($model, 'isbacahakpasien'); ?><label>Saya telah membaca Hal & Kewajiban sebagai Pasien
        dan dengan menyatakan bersedia menjalankan senua kewajiban sebagai pasien.
    </label>
</div>


