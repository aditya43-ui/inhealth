<?php
Yii::import('billingKasir.controllers.PembayaranTagihanPasienController');
Yii::import('billingKasir.models.*');
class PembayaranTagihanPasienPenjaminController extends PembayaranTagihanPasienController
{
    public function actionBayarPiutang($id) {

        $this->layout = "//layouts/iframe";

        $model = BKPembayaranpelayananT::model()->findByPk($id);
        $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $pasien = $pendaftaran->pasien;

        $jumlah_total = round($model->totalsubsidiasuransi / 100) * 100;

        $model->jumlah_total = MyFormatter::formatNumberForPrint($jumlah_total);
        $model->jumlah_bayarhutang = MyFormatter::formatNumberForPrint($model->jumlah_bayarhutang ?? 0);
        $model->jumlah_sisahutang = MyFormatter::formatNumberForPrint($model->jumlah_sisahutang ?? 0);


        if (isset($_POST['BKPembayaranpelayananT'])) {
            $model->attributes = $_POST['BKPembayaranpelayananT'];

            $model->jumlah_total = MyFormatter::formatRupiahForDB($model->jumlah_total);
            $model->jumlah_bayarhutang = MyFormatter::formatRupiahForDB($model->jumlah_bayarhutang);
            $model->jumlah_sisahutang = MyFormatter::formatRupiahForDB($model->jumlah_sisahutang);

            $model->tglmrs_krs = MyFormatter::formatDateTimeForDB($model->tglmrs_krs);
            $model->tanggal_akad = MyFormatter::formatDateTimeForDB($model->tanggal_akad);

            // var_dump($model->attributes);
            // die;

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data berhasil disimpan !');
                $this->redirect(array('bayarPiutang', 'id'=>$id, 'sukses'=>1));
            } else {
                Yii::app()->user->setFlash('error', 'Data gagal disimpan !');
            }

        }


        //var_dump($model->attributes); die;

        $this->render($this->path_view."_formPasienPiutang", array(
            'model'=>$model,
            'pendaftaran'=>$pendaftaran,
            'pasien'=>$pasien
        ));
    }


    public function actionPrintBayarPiutang($id, $caraPrint = "") {

        $this->layout = "//layouts/printWindows";

        if (empty($caraPrint)) {
            $this->layout = "//layouts/iframe";
        }

        $model = BKPembayaranpelayananT::model()->findByPk($id);
        $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $pasien = $pendaftaran->pasien;

        $model->jumlah_total = MyFormatter::formatNumberForPrint($model->jumlah_total, 2);
        $model->jumlah_bayarhutang = MyFormatter::formatNumberForPrint($model->jumlah_bayarhutang ?? 0, 2);
        $model->jumlah_sisahutang = MyFormatter::formatNumberForPrint($model->jumlah_sisahutang ?? 0, 2);


        // var_dump($model->attributes); die;

        $this->render($this->path_view."print.printPiutangMandiri", array(
            'model'=>$model,
            'pendaftaran'=>$pendaftaran,
            'pasien'=>$pasien,
            'caraPrint'=>$caraPrint,
        ));
    }
}
