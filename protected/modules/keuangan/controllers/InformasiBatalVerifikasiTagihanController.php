<?php

class InformasiBatalVerifikasiTagihanController extends MyAuthController
{
    public function actionIndex()
    {
        $model = new KUInformasibatalverifikasitagihanV;
        $model->unsetAttributes();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        if (isset($_GET['KUInformasibatalverifikasitagihanV'])) {
            $model->attributes = $_GET['KUInformasibatalverifikasitagihanV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDB($_GET['KUInformasibatalverifikasitagihanV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDB($_GET['KUInformasibatalverifikasitagihanV']['tgl_akhir']);
        }

        $this->render('index', array(
            'model'=>$model,
        ));
    }

    public function actionDetail($pendaftaran_id, $petugasbatal_id) {
        $this->layout = "//layouts/iframe";

        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);
        $petugas = PegawaiM::model()->findByPk($petugasbatal_id);

        $model = KUInformasibatalverifikasitagihanV::model()->findAllByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
            'petugasbatal_id'=>$petugasbatal_id,
        ), array(
            'order'=>'tgl_tindakan asc',
        ));

        $this->render('detail', array(
            'pendaftaran'=>$pendaftaran,
            'pasien'=>$pasien,
            'petugas'=>$petugas,
            'model'=>$model,
        ));
    }
}