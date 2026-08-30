<?php
/**
 * Cotnroller untuk Informasi Daftar Spesimen
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @category controller
 */
class InformasiDaftarSpesimenController extends MyAuthController{
    
    /**
     * Load data informasi pengiriman spesimen
     */
    public function actionIndex(){
        $model = new MKSpesimenT();
        $model->tgl_awal= date("Y-m-d");
        $model->tgl_akhir= date("Y-m-d");        
        if (isset($_GET['MKSpesimenT'])){
            $model->attributes = $_GET['MKSpesimenT'];
            $model->samplelab_nama = $_GET['MKSpesimenT']['samplelab_nama'];
            $model->jenispemeriksaan_nama = $_GET['MKSpesimenT']['jenispemeriksaan_nama'];
            $model->status_pemeriksaan = $_GET['MKSpesimenT']['status_pemeriksaan'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MKSpesimenT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MKSpesimenT']['tgl_akhir']);

            
        }
        $this->render('index', array('model' => $model));
    }
    
    /**
     * Fungsi pembatalan pengiriman
     * Input data ke batalpengirimanspesimen_t dan update id pembatalan ke pengirimanspesimen_t
     */
    public function actionBatalKirim() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $ok = 1;
        $msg = "Pengiriman spesimen berhasil dibatalkan";
        $id = $_POST['id'];
        $model = PengirimanspesimenT::model()->findByPk($id);
                        
        if ($model->pengirimanspesimen_status == true) {
            $ok = 0;
            $msg = "Batal pengiriman spesimen tidak dapat dilakukan.<br/>"
                . "Spesimen sudah diterima.";
            echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
            Yii::app()->end();
        }
        $batal = new BatalpengirimanspesimenT();
        $batal->tglbatalpengiriman = date("d M Y H:i:s"); 
        $batal->petugas_id = Yii::app()->user->getState('pegawai_id');
        $batal->save();
        $update = PengirimanspesimenT::model()->updateByPk($id, array('batalpengiriman_id' => $batal->batalpengirimanspesimen_id));
        
        echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
        Yii::app()->end();
        
    }
    
    /**
     * digunakan untuk melihat detailhasil pemeriksaan
     * @param type integer $id spesimen id
     */
    public function actionDetail($id){
        $this->layout='//layouts/iframe';
        
        $spesimen_id=$id;
        $model = new IdastT;
        $model2 = new MKIdastT;
        $modelDetail2 = new MKIdastDetT;
        $modSpesimen = SpesimenT::model()->findByPk($spesimen_id);
        $modelDetail = new IdastDetT;
        if (!empty($modSpesimen)) {
            $modSpesimen->nama_pasien = $modSpesimen->penilaianKelayakanSpesimen->pasienmasukpenunjang->pasien->nama_pasien;
            $modSpesimen->no_rekam_medik = $modSpesimen->penilaianKelayakanSpesimen->pasienmasukpenunjang->pasien->no_rekam_medik;
            $modSpesimen->ruangan_asal = $modSpesimen->penilaianKelayakanSpesimen->pasienmasukpenunjang->ruanganasal->ruangan_nama;
            $modSpesimen->jenis_spesimen = $modSpesimen->samplelab->samplelab_nama;
            $modSpesimen->jenis_pemeriksaan = $modSpesimen->tindakanpelayanan->daftartindakan->daftartindakan_nama;
            $modSpesimen->waktu_pengambilan_spesimen = date('d ', strtotime($modSpesimen->waktu_pengambilan_spesimen)) . MyFormatter::getMonthId(date('m', strtotime($modSpesimen->waktu_pengambilan_spesimen))) . date(' Y H:i:s', strtotime($modSpesimen->waktu_pengambilan_spesimen));

            $cek = IdastT::model()->findAllByAttributes(array('spesimen_id' => $spesimen_id));
            if (!empty($cek)) {
                if(count($cek) == 2){
                    $model = IdastT::model()->findByAttributes(array('spesimen_id' => $spesimen_id),array('order'=>'idast_id ASC'));
                    $modelDetail = IdastDetT::model()->findAllByAttributes(array('idast_id' => $model->idast_id));
                    $model->analis_nama = $model->analis->namaLengkap;
                    $model->verifikator_nama = $model->verifikator->namaLengkap;
                    $model->analis_nim = $model->analis->nomorindukpegawai;
                    $model->verifikator_nim = $model->verifikator->nomorindukpegawai;
                    
                    $model2 = MKIdastT::model()->findByAttributes(array('spesimen_id' => $spesimen_id),array('order'=>'idast_id DESC'));
                    $modelDetail2 = MKIdastDetT::model()->findAllByAttributes(array('idast_id' => $model2->idast_id));
                }else if(count($cek) == 1){
                    $model = IdastT::model()->findByAttributes(array('spesimen_id' => $spesimen_id));
                    $modelDetail = IdastDetT::model()->findAllByAttributes(array('idast_id' => $model->idast_id));
                    $model->analis_nama = $model->analis->namaLengkap;
                    $model->verifikator_nama = $model->verifikator->namaLengkap;
                    $model->analis_nim = $model->analis->nomorindukpegawai;
                    $model->verifikator_nim = $model->verifikator->nomorindukpegawai;
                }
            }
        }

        if (!empty($idast_id) || !empty($model->idast_id) || !empty($idast_id2) || !empty($model2->idast_id)) {
            $cek = IdastT::model()->findAllByAttributes(array('spesimen_id' => $spesimen_id));
            if (!empty($cek)) {
                if(count($cek) == 2){
                    $model = IdastT::model()->findByAttributes(array('spesimen_id' => $spesimen_id),array('order'=>'idast_id ASC'));
                    $modelDetail = IdastDetT::model()->findAllByAttributes(array('idast_id' => $model->idast_id));
                    $model->analis_nama = $model->analis->namaLengkap;
                    $model->verifikator_nama = $model->verifikator->namaLengkap;
                    $model->analis_nim = $model->analis->nomorindukpegawai;
                    $model->verifikator_nim = $model->verifikator->nomorindukpegawai;
                    
                    $model2 = MKIdastT::model()->findByAttributes(array('spesimen_id' => $spesimen_id),array('order'=>'idast_id DESC'));
                    $modelDetail2 = MKIdastDetT::model()->findAllByAttributes(array('idast_id' => $model2->idast_id));
                }else if(count($cek) == 1){
                    $model = IdastT::model()->findByAttributes(array('spesimen_id' => $spesimen_id));
                    $modelDetail = IdastDetT::model()->findAllByAttributes(array('idast_id' => $model->idast_id));
                    $model->analis_nama = $model->analis->namaLengkap;
                    $model->verifikator_nama = $model->verifikator->namaLengkap;
                    $model->analis_nim = $model->analis->nomorindukpegawai;
                    $model->verifikator_nim = $model->verifikator->nomorindukpegawai;
                }
            }
        }
        if(isset($_GET['print'])){
            $judulLaporan="HASIL PEMERIKSAAN LABORATORIUM MIKROBIOLOGI KLINIK";
            if ($_GET['print'] == 'print') {
               $this->layout='//layouts/printWindows';
               $this->render('detail', array('caraprint'=>$_GET['print'],'model' => $model, 'modSpesimen' => $modSpesimen,'modDetail'=>$modelDetail, 'model2' => $model2, 'modelDetail2'=>$modelDetail2));
           } else if ($_GET['print'] == 'excel') {
               $this->layout = '//layouts/printExcel';
               $this->render('detail', array('caraprint'=>$_GET['print'],'model' => $model, 'modSpesimen' => $modSpesimen,'modDetail'=>$modelDetail, 'model2' => $model2, 'modelDetail2'=>$modelDetail2,'judulLaporan'=>$judulLaporan));
           } else if ($_GET['print'] == 'pdf') {
               $kertas = Params::getUkuranKertas();
               $mpdf = new MyPDF('', $kertas['F4']);
               $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait

               $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
               $mpdf->WriteHTML($stylesheet, 1);
               $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
               $mpdf->WriteHTML($stylesheet, 1);
               $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 20, 20, 20, 30, 20, 20);
               $mpdf->WriteHTML($this->renderPartial('detail_pdf', array('caraprint'=>$_GET['print'],'model' => $model, 'modSpesimen' => $modSpesimen,'modDetail'=>$modelDetail, 'model2' => $model2, 'modelDetail2'=>$modelDetail2), true));
               
               $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
           }
        }else{
            $this->render('detail', array('model' => $model,'modSpesimen' => $modSpesimen,'modDetail'=>$modelDetail, 'model2' => $model2, 'modelDetail2'=>$modelDetail2));
        }
        
        
        
    }
    
    /**
     * Pengambilan hasil lab Mikro
     * @param integer $spesimen_id
     * @param integer $pasien_id
     */
    public function actionPengambilanHasil($spesimen_id, $pasien_id) {
        $this->layout = '//layouts/iframe';
        $modPasien = PasienM::model()->findByPk($pasien_id);
        $modPengambilan = AmbilhasilSpesimenT::model()->findByAttributes(array('spesimen_id' => $spesimen_id));
        if(empty($modPengambilan->ambilhasil_spesimen_id)){
            $modPengambilan = new AmbilhasilSpesimenT;
        }
        $modPengambilan->tgl_pengambilanhasil = date('d M Y H:i:s');

        if (isset($_POST['AmbilhasilSpesimenT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $tanggal = MyFormatter::formatDateTimeForDb($_POST['AmbilhasilSpesimenT']['tgl_pengambilanhasil']);
                $hubungan = !empty($_POST['AmbilhasilSpesimenT']['hubungan_pengambilhasil']) ? $_POST['AmbilhasilSpesimenT']['hubungan_pengambilhasil'] : "";
                $no_identitas = !empty($_POST['AmbilhasilSpesimenT']['noidentitas_pengambilhasil']) ? $_POST['AmbilhasilSpesimenT']['noidentitas_pengambilhasil'] : "";
                
                $modPengambilan->nama_pengambilhasil = $_POST['AmbilhasilSpesimenT']['nama_pengambilhasil'];
                $modPengambilan->tgl_pengambilanhasil = $tanggal;
                $modPengambilan->hubungan_pengambilhasil = $hubungan;
                $modPengambilan->noidentitas_pengambilhasil = $no_identitas;
                $modPengambilan->alamat_pengambilhasil = $_POST['AmbilhasilSpesimenT']['alamat_pengambilhasil'];
                $modPengambilan->notelp_pengambilhasil = $_POST['AmbilhasilSpesimenT']['notelp_pengambilhasil'];
                $modPengambilan->spesimen_id = $spesimen_id;
                
                $ok = $ok && $modPengambilan->save();

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Sukses Disimpan");
                    $this->refresh();
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($modPengambilan));
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render('pengambilanHasil', array(
            'modPasien' => $modPasien,
            'modPengambilan' => $modPengambilan,
            'spesimen_id' => $spesimen_id
        ));
    }

    /**
     * Get data pasien pengambil hasil
     */
    public function actionGeneratePasien() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $returnVal['pesan'] = "";

            $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;

            $modPasien = PasienM::model()->findByPk($pasien_id);
            $attributes = $modPasien->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $modPasien->$attribute;
            }

            $returnVal["nama_pengambil"] = $modPasien->nama_pasien;
            $returnVal["noidentitas_pengambil"] = $modPasien->no_identitas_pasien;
            $returnVal["alamat_pengambil"] = $modPasien->alamat_pasien;
            $returnVal["nomobile_pengambil"] = $modPasien->no_mobile_pasien;
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}

