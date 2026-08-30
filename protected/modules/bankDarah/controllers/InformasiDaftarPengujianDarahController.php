<?php

/**
 * Digunakan untuk menampilkan Informasi Permintaan Darah Pasien di modul Bank Darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class InformasiDaftarPengujianDarahController extends MyAuthController
{
    function actionIndex() {
        $this->pageTitle = Yii::app()->name . " - Daftar Pengujian Darah Pasien";
        $model = new BDPasienmasukpenunjangT();
        $model->unsetAttributes();  // clear any default values
        $format = new MyFormatter();
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");
        $model->ruangan_id = Params::RUANGAN_ID_BANK_DARAH;
        if (isset($_GET['BDPasienmasukpenunjangT'])) {
            $model->attributes = $_GET['BDPasienmasukpenunjangT'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDPasienmasukpenunjangT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDPasienmasukpenunjangT']['tgl_akhir']);
            $model->no_masukpenunjang = $_GET['BDPasienmasukpenunjangT']['no_masukpenunjang'];
            $model->ruangan_id = $_GET['BDPasienmasukpenunjangT']['ruangan_id'];
            $model->instalasi_id = $_GET['BDPasienmasukpenunjangT']['instalasi_id'];
            $model->carabayar_id = $_GET['BDPasienmasukpenunjangT']['carabayar_id'];
            $model->penjamin_id =$_GET['BDPasienmasukpenunjangT']['penjamin_id'];
            $model->no_rekam_medik = $_GET['BDPasienmasukpenunjangT']['no_rekam_medik'];
            $model->nama_pasien = $_GET['BDPasienmasukpenunjangT']['nama_pasien'];

        }
        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'permintaandarah-r-grid') {
                $this->renderPartial('_table', [
                    'model' => $model
                ]);
                Yii::app()->end();
            }
        }

        $this->render('index', [
            'model' => $model
        ]);
    }

    function actionUpdateProgres(){
        $pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];
        $find = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id, ['condition' => ' is_progressgoldarah is null']);
        if(!empty($find)) {
            $update = PasienkirimkeunitlainT::model()->updateByPk($pasienkirimkeunitlain_id, ['is_progressgoldarah' => true]);
    
            if($update) {
                $data['sukses'] = 1;
            } else {
                $data['sukses'] = 0;
            }
        }

        echo json_encode($data);
    }

    function actionCekStatus(){
        $pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];

        $find = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id, ['condition' => 'is_progressgoldarah is true or is_progressgoldarah is null']);

        if(!empty($find)) {
            $data['sukses'] = 1;
        } else {
            $data['sukses'] = 0;
        }

        echo json_encode($data);
    }
}