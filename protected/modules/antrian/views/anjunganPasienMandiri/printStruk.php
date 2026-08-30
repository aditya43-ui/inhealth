<?php
$profil = ProfilrumahsakitM::model()->find();
$ruangan = RuanganM::model()->findByPk($model->ruangan_id);


// var_dump($profil->attributes); die;
?>

<style>
    .struk_base {
        border: 1px solid black;
        border-radius: 10px;
        text-align: center;
    }

    .struk_profil {
        color: white;
        background-color: black;
        font-weight: bold;
        padding: 10px;
        font-size: 20px;
    }

    .struk_body {
        padding: 5px;
    }

    #no_antri {
        padding-top: 15px;
        padding-bottom: 10px;
        font-size: 70px;
        font-weight: bold;
    }

    #ruangan_poli {
        font-weight: bold;
        font-size: 20px;
    }

    #alamat {
        font-size: 10px;
        padding-top: 10px;
        padding-bottom: 15px;
    }
</style>


<div class="struk_base">
    <div class="struk_profil">
        <?php echo trim(strtoupper($profil->nama_rumahsakit)); ?>
    </div>
    <div class="struk_body">
        <?php
        $tgl = date('Y-m-d', strtotime($model->tgl_pendaftaran));
        $waktu = date('H:i:s', strtotime($model->tgl_pendaftaran));
        ?>
        <div id="tgl"><?php echo MyFormatter::formatDateTimeForUser($tgl)." / ".$waktu; ?></div>
        <div id="no_antri">
            <?php echo $ruangan->ruangan_singkatan."-".((int)$model->no_urutantri); ?>
        </div>
        <div id="ruangan_poli">
            <?php echo $ruangan->ruangan_nama; ?>
        </div>
        <div id="ruangan_poli">
            <?php echo $model->pegawai->namaLengkap; ?>
        </div>

        <div id="alamat">
            <?php 
            
            echo $profil->alamatlokasi_rumahsakit; 
            
            echo ", Kec. ".ucwords(strtolower($profil->kecamatan->kecamatan_nama ?? "-"));
            echo ", ".ucwords(strtolower($profil->kabupaten->kabupaten_nama ?? "-"));
            echo ", ".ucwords(strtolower($profil->propinsi->propinsi_nama ?? "-"));
            echo " ".($profil->kodepos ?? "-");

            ?>
        </div>
    </div>
</div>