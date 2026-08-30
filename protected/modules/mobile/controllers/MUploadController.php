<?php
ini_set('memory_limit', '128M');
class MUploadController extends Controller
{
    public $layout = "//layouts/iframe";
    public $path_view = 'mobile.views.mUpload.';

    public function actionIndexKartu($id)
    {
        $model = $this->loadModel($id);
        $this->render($this->path_view . 'indexKartu', array(
            'model' => $model,
        ));
    }
    
    public function actionIndexBukti($id)
    {
        $model = $this->loadModel($id);
        $this->render($this->path_view . 'indexBukti', array(
            'model' => $model,
        ));
    }
    
    /**
     * Digunakan untuk Upload bukti pembayaran
     * @param type $id
     */
    public function actionUploadKartu($buatjanjipoli_id) {
        $this->layout = '//layouts/iframe';
        $profilrs = ProfilrumahsakitM::model()->find();
        $model = BuatjanjipoliT::model()->findByPk($buatjanjipoli_id);
        if (isset($_POST['BuatjanjipoliT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $length = 6;
                $model->attributes = $_POST['BuatjanjipoliT'];
                $model->bukti_pembayaran = CUploadedFile::getInstance($model, 'bukti_pembayaran');
                $model->code_booking = strtoupper(GenerateTokenPass::generateRandomBase62String($length));
                $sql2 = " SELECT * from karcis_v
                    WHERE komponentarif_id = 6 AND pasienbaru_karcis = False 
                    AND ruangan_id = ".$model->ruangan_id." AND kelaspelayanan_id = ".$model->kelaspelayanan_id."
                    AND penjamin_id = ".$model->penjamin_id." ";
                $loadData = Yii::app()->db->createCommand($sql2)->queryAll();
                if (!empty($model->bukti_pembayaran)) {
                    $file = $model->bukti_pembayaran;
                    if(!empty($model->bukti_pembayaran)) {
                        $fullDocName = $model->no_buatjanji . '.' .  $model->bukti_pembayaran->getExtensionName();
                        $fullDocSource = Params::pathBuktiPembayaranDirectory() . $fullDocName;
                        $model->bukti_pembayaran = $fullDocName;
                    }
                    $file->saveAs($fullDocSource);
                }
                $tglpendaftaran = date('Y-m-d 00:00:00', strtotime('+1 day'));
                $tglbooking = date('Y-m-d', strtotime('+1 day'));
                $modInstalasi = RuanganM::model()->findByAttributes(array('ruangan_id'=>$model->ruangan_id));
                $modPasien = PasienM::model()->findByAttributes(array('pasien_id'=>$model->pasien_id));
                $modPendaftaran = new PendaftaranT;
                $modPendaftaran->penjamin_id = $model->penjamin_id;
                $modPendaftaran->pasien_id = $model->pasien_id;
                $modPendaftaran->pegawai_id = $model->pegawai_id;
                $modPendaftaran->instalasi_id = $modInstalasi->instalasi_id;
                $modPendaftaran->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
                $modPendaftaran->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                $modPendaftaran->ruangan_id = $model->ruangan_id;
                $modPendaftaran->no_pendaftaran = MyGenerator::noPendaftaran($modInstalasi->instalasi_id, $tglbooking);
                $modPendaftaran->tgl_pendaftaran = $tglpendaftaran;
                $modPendaftaran->no_urutantri = MyGenerator::noAntrianJanjiPoliKsSakit($model->ruangan_id, $model->pegawai_id);
                $sql = " SELECT * from jadwalbukapoli_m
                    WHERE ruangan_id = ".$model->ruangan_id." AND dokter_id = ".$model->pegawai_id." AND jadwalbukapoli_id = ".$model->jadwalbukapoli_id." ";
                $loadAntrian = JadwalbukapoliM::model()->findBySql($sql);
                if($modPendaftaran->no_urutantri <= '008'){
                    $model->estimasiperiksa = date("H:i", strtotime($model->tgljadwal));
                }else if($modPendaftaran->no_urutantri == '009'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+1 hours'));
                }else if($modPendaftaran->no_urutantri > '009'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+1 hours'));
                }else if($modPendaftaran->no_urutantri == '017'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+2 hours'));
                }else if($modPendaftaran->no_urutantri > '017'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+2 hours'));
                }else if($modPendaftaran->no_urutantri == '025'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+3 hours'));
                }else if($modPendaftaran->no_urutantri > '025'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+3 hours'));
                }else if($modPendaftaran->no_urutantri == '033'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+4 hours'));
                }else if($modPendaftaran->no_urutantri > '033'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+4 hours'));
                }else if($modPendaftaran->no_urutantri == '041'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+5 hours'));
                }else if($modPendaftaran->no_urutantri > '041'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+5 hours'));
                }else if($modPendaftaran->no_urutantri == '049'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+6 hours'));
                }else if($modPendaftaran->no_urutantri > '049'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+6 hours'));
                }else if($modPendaftaran->no_urutantri == '057'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+7 hours'));
                }else if($modPendaftaran->no_urutantri > '057'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+7 hours'));
                }else if($modPendaftaran->no_urutantri == '065'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+8 hours'));
                }else if($modPendaftaran->no_urutantri > '065'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+8 hours'));
                }
                $modPendaftaran->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
                $modPendaftaran->statuspasien = Params::STATUSPASIEN_LAMA;
                $modPendaftaran->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
                $modPendaftaran->alihstatus = FALSE;
                $modPendaftaran->byphone = FALSE;
                $modPendaftaran->kunjunganrumah = FALSE;
                $modPendaftaran->statusmasuk = Params::STATUSMASUK_NONRUJUKAN;
                $modPendaftaran->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
                $modPendaftaran->create_time = $tglpendaftaran;
                $modPendaftaran->create_loginpemakai_id = $model->create_loginpemakai_id;
                $modPendaftaran->create_ruangan = $model->ruangan_id;
                $modPendaftaran->nopendaftaran_aktif = TRUE;
                $modPendaftaran->statusfarmasi = FALSE;
                $modPendaftaran->panggilantrian = FALSE;
                $modPendaftaran->asuransipasien_id = $model->asuransipasienjanjipoli_id;
                $modPendaftaran->tglperiksa = $model->tgljadwal;
                $modPendaftaran->tglakandilayani = $model->tgljadwal;
                $modPendaftaran->is_hadir = FALSE;
                $modPendaftaran->carabayar_id = $model->carabayar_id;
                $modPendaftaran->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
                $modPendaftaran->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
                $modPendaftaran->shift_id = 1;
                $modPendaftaran->save();
                foreach($loadData as $i => $karcis) {
                    $modPelayanan = new TindakanpelayananT;
                    $modPelayanan->shift_id = 1;
                    $modPelayanan->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                    $modPelayanan->pasien_id = $model->pasien_id;
                    $modPelayanan->instalasi_id = $modInstalasi->instalasi_id;
                    $modPelayanan->daftartindakan_id = $karcis['daftartindakan_id'];
                    $modPelayanan->karcis_id = $karcis['karcis_id'];
                    $modPelayanan->carabayar_id = $model->carabayar_id;
                    $modPelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                    $modPelayanan->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
                    $modPelayanan->ruangan_id = $model->ruangan_id;
                    $modPelayanan->satuantindakan = "KALI";
                    $modPelayanan->penjamin_id = $model->penjamin_id;
                    $modPelayanan->tgl_tindakan = $tglpendaftaran;
                    $modPelayanan->tarif_rsakomodasi = $karcis['harga_tariftindakan'];
                    $modPelayanan->tarif_medis = 0;
                    $modPelayanan->tarif_paramedis = 0;
                    $modPelayanan->tarif_bhp = 0;
                    $modPelayanan->tarif_satuan = $karcis['harga_tariftindakan'];
                    $modPelayanan->tarif_tindakan = $karcis['harga_tariftindakan'];
                    $modPelayanan->qty_tindakan = 1;
                    $modPelayanan->cyto_tindakan = 0;
                    $modPelayanan->tarifcyto_tindakan = 0;
                    $modPelayanan->dokterpemeriksa1_id = $model->pegawai_id;
                    $modPelayanan->discount_tindakan = 0;
                    $modPelayanan->pembebasan_tindakan = 0;
                    $modPelayanan->subsidiasuransi_tindakan = 0;
                    $modPelayanan->subsidipemerintah_tindakan = 0;
                    $modPelayanan->subsisidirumahsakit_tindakan = 0;
                    $modPelayanan->iurbiaya_tindakan = $karcis['harga_tariftindakan'];
                    $modPelayanan->tm = "TM";
                    $modPelayanan->create_time = $tglpendaftaran;
                    $modPelayanan->create_loginpemakai_id = $model->create_loginpemakai_id;
                    $modPelayanan->create_ruangan = $model->ruangan_id;
                    $modPelayanan->save();
                }
                $ok = $ok && $model->save();
                if ($ok) {
                    BuatjanjipoliT::model()->updateByPk($model->buatjanjipoli_id, array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'no_antrianjanji' =>$modPendaftaran->no_urutantri));
                    MOPendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('karcis_id'=>$modPelayanan->karcis_id));
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('indexKartu', 'id' => $model->buatjanjipoli_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . '_formUploadKartu', array(
            'model' => $model,
        ));
    }
    
    /**
     * Digunakan untuk Upload bukti pembayaran
     * @param type $id
     */
    public function actionUploadBukti($buatjanjipoli_id) {
        $this->layout = '//layouts/iframe';
        $model = BuatjanjipoliT::model()->findByPk($buatjanjipoli_id);
        if (isset($_POST['BuatjanjipoliT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $length = 6;
                $model->attributes = $_POST['BuatjanjipoliT'];
                $model->bukti_pembayaran = CUploadedFile::getInstance($model, 'bukti_pembayaran');
                $model->code_booking = strtoupper(GenerateTokenPass::generateRandomBase62String($length));
                $sql2 = " SELECT * from karcis_v
                    WHERE komponentarif_id = 6 AND pasienbaru_karcis = False 
                    AND ruangan_id = ".$model->ruangan_id." AND kelaspelayanan_id = ".$model->kelaspelayanan_id."
                    AND penjamin_id = ".$model->penjamin_id." ";
                $loadData = Yii::app()->db->createCommand($sql2)->queryAll();
                if (!empty($model->bukti_pembayaran)) {
                    $file = $model->bukti_pembayaran;
                    if(!empty($model->bukti_pembayaran)) {
                        $fullDocName = $model->no_buatjanji . '.' .  $model->bukti_pembayaran->getExtensionName();
                        $fullDocSource = Params::pathBuktiPembayaranDirectory() . $fullDocName;
                        $model->bukti_pembayaran = $fullDocName;
                    }
                    $file->saveAs($fullDocSource);
                }
                $tglpendaftaran = date('Y-m-d 00:00:00', strtotime('+1 day'));
                $tglbooking = date('Y-m-d', strtotime('+1 day'));
                $modInstalasi = RuanganM::model()->findByAttributes(array('ruangan_id'=>$model->ruangan_id));
                $modPasien = PasienM::model()->findByAttributes(array('pasien_id'=>$model->pasien_id));
                $modPendaftaran = new PendaftaranT;
                $modPendaftaran->penjamin_id = $model->penjamin_id;
                $modPendaftaran->pasien_id = $model->pasien_id;
                $modPendaftaran->pegawai_id = $model->pegawai_id;
                $modPendaftaran->instalasi_id = $modInstalasi->instalasi_id;
                $modPendaftaran->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
                $modPendaftaran->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                $modPendaftaran->ruangan_id = $model->ruangan_id;
                $modPendaftaran->no_pendaftaran = MyGenerator::noPendaftaran($modInstalasi->instalasi_id, $tglbooking);
                $modPendaftaran->tgl_pendaftaran = $tglpendaftaran;
                $modPendaftaran->no_urutantri = MyGenerator::noAntrianJanjiPoliKsSakit($model->ruangan_id, $model->pegawai_id);
                $sql = " SELECT * from jadwalbukapoli_m
                    WHERE ruangan_id = ".$model->ruangan_id." AND dokter_id = ".$model->pegawai_id." AND jadwalbukapoli_id = ".$model->jadwalbukapoli_id." ";
                $loadAntrian = JadwalbukapoliM::model()->findBySql($sql);
                if($modPendaftaran->no_urutantri <= '008'){
                    $model->estimasiperiksa = date("H:i", strtotime($model->tgljadwal));
                }else if($modPendaftaran->no_urutantri == '009'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+1 hours'));
                }else if($modPendaftaran->no_urutantri > '009'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+1 hours'));
                }else if($modPendaftaran->no_urutantri == '017'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+2 hours'));
                }else if($modPendaftaran->no_urutantri > '017'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+2 hours'));
                }else if($modPendaftaran->no_urutantri == '025'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+3 hours'));
                }else if($modPendaftaran->no_urutantri > '025'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+3 hours'));
                }else if($modPendaftaran->no_urutantri == '033'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+4 hours'));
                }else if($modPendaftaran->no_urutantri > '033'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+4 hours'));
                }else if($modPendaftaran->no_urutantri == '041'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+5 hours'));
                }else if($modPendaftaran->no_urutantri > '041'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+5 hours'));
                }else if($modPendaftaran->no_urutantri == '049'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+6 hours'));
                }else if($modPendaftaran->no_urutantri > '049'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+6 hours'));
                }else if($modPendaftaran->no_urutantri == '057'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+7 hours'));
                }else if($modPendaftaran->no_urutantri > '057'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+7 hours'));
                }else if($modPendaftaran->no_urutantri == '065'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+8 hours'));
                }else if($modPendaftaran->no_urutantri > '065'){
                    $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+8 hours'));
                }
                $modPendaftaran->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
                $modPendaftaran->statuspasien = Params::STATUSPASIEN_LAMA;
                $modPendaftaran->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
                $modPendaftaran->alihstatus = FALSE;
                $modPendaftaran->byphone = FALSE;
                $modPendaftaran->kunjunganrumah = FALSE;
                $modPendaftaran->statusmasuk = Params::STATUSMASUK_NONRUJUKAN;
                $modPendaftaran->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
                $modPendaftaran->create_time = $tglpendaftaran;
                $modPendaftaran->create_loginpemakai_id = $model->create_loginpemakai_id;
                $modPendaftaran->create_ruangan = $model->ruangan_id;
                $modPendaftaran->nopendaftaran_aktif = TRUE;
                $modPendaftaran->statusfarmasi = FALSE;
                $modPendaftaran->panggilantrian = FALSE;
                $modPendaftaran->asuransipasien_id = $model->asuransipasienjanjipoli_id;
                $modPendaftaran->tglperiksa = $model->tgljadwal;
                $modPendaftaran->tglakandilayani = $model->tgljadwal;
                $modPendaftaran->is_hadir = FALSE;
                $modPendaftaran->carabayar_id = $model->carabayar_id;
                $modPendaftaran->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
                $modPendaftaran->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
                $modPendaftaran->shift_id = 1;
                $modPendaftaran->save();
                foreach($loadData as $i => $karcis) {
                    $modPelayanan = new TindakanpelayananT;
                    $modPelayanan->shift_id = 1;
                    $modPelayanan->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                    $modPelayanan->pasien_id = $model->pasien_id;
                    $modPelayanan->instalasi_id = $modInstalasi->instalasi_id;
                    $modPelayanan->daftartindakan_id = $karcis['daftartindakan_id'];
                    $modPelayanan->karcis_id = $karcis['karcis_id'];
                    $modPelayanan->carabayar_id = $model->carabayar_id;
                    $modPelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                    $modPelayanan->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
                    $modPelayanan->ruangan_id = $model->ruangan_id;
                    $modPelayanan->satuantindakan = "KALI";
                    $modPelayanan->penjamin_id = $model->penjamin_id;
                    $modPelayanan->tgl_tindakan = $tglpendaftaran;
                    $modPelayanan->tarif_rsakomodasi = $karcis['harga_tariftindakan'];
                    $modPelayanan->tarif_medis = 0;
                    $modPelayanan->tarif_paramedis = 0;
                    $modPelayanan->tarif_bhp = 0;
                    $modPelayanan->tarif_satuan = $karcis['harga_tariftindakan'];
                    $modPelayanan->tarif_tindakan = $karcis['harga_tariftindakan'];
                    $modPelayanan->qty_tindakan = 1;
                    $modPelayanan->cyto_tindakan = 0;
                    $modPelayanan->tarifcyto_tindakan = 0;
                    $modPelayanan->dokterpemeriksa1_id = $model->pegawai_id;
                    $modPelayanan->discount_tindakan = 0;
                    $modPelayanan->pembebasan_tindakan = 0;
                    $modPelayanan->subsidiasuransi_tindakan = 0;
                    $modPelayanan->subsidipemerintah_tindakan = 0;
                    $modPelayanan->subsisidirumahsakit_tindakan = 0;
                    $modPelayanan->iurbiaya_tindakan = $karcis['harga_tariftindakan'];
                    $modPelayanan->tm = "TM";
                    $modPelayanan->create_time = $tglpendaftaran;
                    $modPelayanan->create_loginpemakai_id = $model->create_loginpemakai_id;
                    $modPelayanan->create_ruangan = $model->ruangan_id;
                    $modPelayanan->save();
                }
                $ok = $ok && $model->save();
                if ($ok) {
                    BuatjanjipoliT::model()->updateByPk($model->buatjanjipoli_id, array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'no_antrianjanji' =>$modPendaftaran->no_urutantri));
                    MOPendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('karcis_id'=>$modPelayanan->karcis_id));
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('indexBukti', 'id' => $model->buatjanjipoli_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . '_formUploadBukti', array(
            'model' => $model,
        ));
    }
    /**
	 * Memanggil data dari model.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=BuatjanjipoliT::model()->findByPk($id);
		if($model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}