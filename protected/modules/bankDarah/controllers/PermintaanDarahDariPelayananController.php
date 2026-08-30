<?php

/**
 * transaksi untuk permintaan darah dari pelayanan 
 * @author Rusdiyanto <rusdiyanto@.com>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package    application.modules.bankDarah
 * @subpackage controllers
 */
class PermintaanDarahDariPelayananController extends MyAuthController {

    public $path_view = 'bankDarah.views.permintaandarahdaripelayanan.';
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $tindakanpelayanantersimpan = true;
    public $komponentindakantersimpan = true; //di looping
    public $init = '';

    /**
     * fungsi untuk menampilkan halaman awal dan proses insert
     * @param type $pendaftaran_id
     * @param type $permintaandarah_id
     */
    public function actionIndex($pasienkirimkeunitlain_id = null, $pendaftaran_id = null, $permintaankepenunjang_id = null, $permintaankirimkeunitlain_id = null, $permintaandarah_id = null) {

        if(isset($_GET['frame']) && $_GET['frame']) {
            $this->layout = '//layouts/iframe';
        }
       
        $modPendaftaran = new BDPendaftaranT();
        $modPermintaanDarah = new BDPermintaandarahT();
        $modPermintaanDarah->tglpermintaan = date('Y-m-d H:i:s');
        $modPermintaanDarah->no_permintaandarah = '--Otomatis--';
        $loginpemakai = Yii::app()->user->getState('loginpemakai_id');
        $modLoginPemakai = LoginpemakaiK::model()->findByPk($loginpemakai);
        $modPermintaanDarah->pegpemesan_id = $modLoginPemakai->pegawai_id;
        $pegawai = PegawaiM::model()->findByPk($modLoginPemakai->pegawai_id);
        $modPermintaanDarah->pegpemesan_nama = isset($pegawai->namaLengkap) ? $pegawai->namaLengkap : '-';
        $modPermintaanDarah->no_hp_pegpemesan = isset($pegawai->nomobile_pegawai) ? $pegawai->nomobile_pegawai : '-' ;
      
        $modPermintaanDarahDet = new BDPermintaandarahdetT();
        $modRiwayat = new BDPermintaandarahT();
        $format = new MyFormatter();
        $modPasien = new BDPasienM();
        $modPermintaanPenunjang = new PermintaankepenunjangT();
        $modkirimkeunitlain = new BDPasienKirimKeUnitLainT();

        if(isset($_GET['pendaftaran_id'])) {
            // mengambil diagnosa utama
            $criteria = new CDbCriteria;
            if (!empty($pendaftaran_id)) {
                $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
            }
            $criteria->addCondition("ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
            $criteria->addCondition("pegawai_id = " . Yii::app()->user->getState('pegawai_id'));
            $criteria->addCondition('diagnosaicdix_id IS NULL and kelompokdiagnosa_id=' . Params::KELOMPOKDIAGNOSA_UTAMA);
            $criteria->order = 'kelompokdiagnosa_id asc';
            $modDiagnosa = PasienmorbiditasT::model()->find($criteria);
            if(!empty($modDiagnosa)) {
                $modkirimkeunitlain->diagnosa_id = $modDiagnosa->diagnosa_id;
                $modkirimkeunitlain->diagnosa_nama = $modDiagnosa->diagnosa->diagnosa_nama;
            }    
        }
    
        $kelompokpeg = Yii::app()->user->getState('kelompokpegawai_id');
        $pegawaiid = Yii::app()->user->getState('pegawai_id');

        if($kelompokpeg == 1) {
            $modkirimkeunitlain->pegawai_id = $pegawaiid;
            $modkirimkeunitlain->pegawai_nama = $modkirimkeunitlain->pegawai->namaLengkap;
        }

        $modPermintaanPenunjang->tglpermintaankepenunjang = date('Y-m-d H:i:s');
        if(isset($_GET['pendaftaran_id'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = BDPendaftaranT::model()->findByPk($pendaftaran_id);
        }
        if(!empty($pegawai)) {
            $modkirimkeunitlain->pegpemesan_nama = $pegawai->namaLengkap;
            $modkirimkeunitlain->pegpemesan_id = $pegawai->pegawai_id;
            $modkirimkeunitlain->pegawai_nama = $pegawai->namaLengkap;
            $modkirimkeunitlain->pegawai_id = Yii::app()->user->getState('pegawai_id');
        }

        if(!empty($permintaankepenunjang_id)) {
            $modPermintaanPenunjang = PermintaankepenunjangT::model()->findByPk($permintaankepenunjang_id);
        }
        if(!empty($permintaankirimkeunitlain_id)) {
            $modPermintaanPenunjang = BDPasienKirimKeUnitLainT::model()->findByPk($permintaankirimkeunitlain_id);
        }

        if (!empty($pendaftaran_id)) {
            $cekPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPermintaanDarah->pendaftaran_id = !empty($cekPendaftaran) ? $cekPendaftaran->pendaftaran_id : null;
            $modPermintaanDarah->pasien_id = !empty($cekPendaftaran) ? $cekPendaftaran->pasien_id : null;
            $modPermintaanDarah->dpjp_id = !empty($cekPendaftaran) ? $cekPendaftaran->pegawai_id : null;
            $modPermintaanDarah->dpjp_nama = !empty($cekPendaftaran) ? $cekPendaftaran->pegawai->namaLengkap : null;
            $modPermintaanDarah->no_hp_dokter = !empty($cekPendaftaran) ? $cekPendaftaran->pegawai->nomobile_pegawai : null;
            $modRiwayat->pendaftaran_id = $pendaftaran_id;
        }
        if (!empty($permintaandarah_id)) {
            $modPermintaanDarah = BDPermintaandarahT::model()->findByPk($permintaandarah_id);
            $modPermintaanDarah->pegpemesan_nama = !empty($modPermintaanDarah->pegpemesan_id) ? $modPermintaanDarah->pegpemesan->namaLengkap : "";
            $modPermintaanDarah->no_hp_pegpemesan = !empty($modPermintaanDarah->pegpemesan_id) ? $modPermintaanDarah->pegpemesan->nomobile_pegawai : "";
            $modPermintaanDarah->pengambilsampel_nama = !empty($modPermintaanDarah->peg_pengambilsampel_id) ? $modPermintaanDarah->pengambilsampel->namaLengkap : "";
            $modPermintaanDarah->dpjp_nama = !empty($modPermintaanDarah->dpjp_id) ? $modPermintaanDarah->dpjp->namaLengkap : "";
            $modRiwayat->pendaftaran_id = $modPermintaanDarah->pendaftaran_id;
        }

        if(!empty($pasienkirimkeunitlain_id)) {
            $modkirimkeunitlain = BDPasienKirimKeUnitLainT::model()->findByPk($pasienkirimkeunitlain_id);
            $diagnosa = DiagnosaM::model()->findByPk($modkirimkeunitlain->diagnosa_id);
            $modkirimkeunitlain->diagnosa_nama = $diagnosa->diagnosa_nama;
            $modkirimkeunitlain->pegawai_nama = $modkirimkeunitlain->pegawai->namaLengkap;

            $modPermintaanKepenunjang = PermintaankepenunjangT::model()->find("pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id");
        }

        


        if(isset($_POST['PermintaankepenunjangT'])) {
            
            // echo '<pre>';
            // var_dump($_POST);
            // die;

            $transaction = Yii::app()->db->beginTransaction();

            $postPenunjang = $_POST['PermintaankepenunjangT']["data"];
            $postUnitLain = $_POST['BDPasienKirimKeUnitLainT'];
            $modPendaftaran = PendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
            $modkirimkeunitlain = new BDPasienKirimKeUnitLainT();
            if(!empty($postUnitLain['pasienkirimkeunitlain_id'])) {
                $modkirimkeunitlain = BDPasienKirimKeUnitLainT::model()->findByPk($postUnitLain['pasienkirimkeunitlain_id']);
            }
            if(empty($modkirimkeunitlain)) {
                $modkirimkeunitlain = new BDPasienKirimKeUnitLainT();
            }

            $modkirimkeunitlain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
            $modkirimkeunitlain->diagnosa_id = $postUnitLain['diagnosa_id'];
            $modkirimkeunitlain->ppds_id = $postUnitLain['ppds_id'];
            $modkirimkeunitlain->diagnosis = $postUnitLain['diagnosis'];
            $modkirimkeunitlain->catatandokterpengirim = $postUnitLain['catatandokterpengirim'];
            $modkirimkeunitlain->instalasi_id = $modPendaftaran->instalasi_id;
            $modkirimkeunitlain->pasien_id = $modPendaftaran->pasien_id;
            $modkirimkeunitlain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modkirimkeunitlain->ruangan_id = Params::RUANGAN_ID_BANK_DARAH;
            $modkirimkeunitlain->pegawai_id = $postUnitLain['pegawai_id'];
            $modkirimkeunitlain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain(Params::RUANGAN_ID_BANK_DARAH);
            $modkirimkeunitlain->no_permintaan = MyGenerator::noPermintaanPasienKirimKeunitlain('BD');
            $modkirimkeunitlain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($_POST['PermintaankepenunjangT']['tglpermintaankepenunjang']);
            if (!empty($modLoginPemakai->ppds_id)){
                $modkirimkeunitlain->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            }else{
                $modkirimkeunitlain->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            }
            $modkirimkeunitlain->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $modkirimkeunitlain->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modkirimkeunitlain->macam_transfusi = $_POST['macam_transfusi'];

            // echo '<pre>'; var_dump($postPenunjang); die;
            // echo '<pre>'; var_dump($modPendaftaran->attributes); die;
            try {
                $ok = false;
                if(count($postPenunjang) > 0) {
                    if($modkirimkeunitlain->save()) {
                   
                        foreach($postPenunjang as $i => $post) {
                        
                            $modPermintaanPenunjang = new PermintaankepenunjangT();

                            if(!empty($postPenunjang['permintaankepenunjang_id'])) {
                                $modPermintaanPenunjang = PermintaankepenunjangT::model()->findByPk($postPenunjang['permintaankepenunjang_id']);
                            }
                            
                            $modPermintaanPenunjang->pernah_transfusi = $_POST['PermintaankepenunjangT']['pernah_transfusi'];
                            $modPermintaanPenunjang->rekasi_transfusi = $_POST['PermintaankepenunjangT']['rekasi_transfusi'];
                            $modPermintaanPenunjang->gejala_transfusi = $_POST['PermintaankepenunjangT']['gejala_transfusi'];
                            if($_POST['PermintaankepenunjangT']['is_tidak'] == 1) {
                                $modPermintaanPenunjang->gejala_transfusi = 'Tidak Tahu';
                            }
                            $modPermintaanPenunjang->pasienkirimkeunitlain_id = $modkirimkeunitlain->pasienkirimkeunitlain_id;
                            $modPermintaanPenunjang->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('BD');
                            $modPermintaanPenunjang->tglpermintaankepenunjang =  $modkirimkeunitlain->tgl_kirimpasien;
                            $modPermintaanPenunjang->jenispermintaan =  !empty($post['jenispermintaan']) ? $post['jenispermintaan'] : 'Biasa';
                            $modPermintaanPenunjang->jeniskomponendarah_id = $_POST['JeniskomponendarahM'][$i]['jeniskomponendarah_id'];
                            $modPermintaanPenunjang->kadarhb =  $post['kadarhb'];
                            $modPermintaanPenunjang->plt =  $post['plt'];
                            $modPermintaanPenunjang->jenis_volume =  $post['jenis_volume'];
                            $modPermintaanPenunjang->diambil =  $post['diambil'];
                            $modPermintaanPenunjang->dititip =  $post['dititip'];
                            $modPermintaanPenunjang->qtypermintaan =  $post['qtypermintaan'];
                            $modPermintaanPenunjang->indikasi_darah =  $post['indikasi_darah'];
                            $modPermintaanPenunjang->tglren_transfusi =  MyFormatter::formatDateTimeForDb($post['tglren_transfusi']);
                            $modPermintaanPenunjang->tgl_transfusisebelumnya =  MyFormatter::formatDateTimeForDb($_POST['PermintaankepenunjangT']['tgl_transfusisebelumnya']);
                            $modPermintaanPenunjang->jumlah_kantong =  $post['qtypermintaan'];

                            if($modPermintaanPenunjang->save()) {
                                // echo '<pre>'; var_dump($modPermintaanPenunjang->attributes); die;
                                $ok = true;
                            } else {
                                $ok = false;
                            }
                            
                        }
                    } else {
                        $ok = false;
                    }
                    // echo '<pre>';var_dump($ok);die;

                    if($ok) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $this->notifPermintaanDarah($modkirimkeunitlain);
                        if(isset($_GET['frame']) && $_GET['frame']) {
                            $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id,'sukses' => 1, 'frame'=>1));
                        } else {
                            $this->redirect(array('index', 'sukses' => 1));
                        }
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data Gagal Disimpan.[1]');
                    }
                }

            } catch (Exception $ex) {
                var_dump($ex);die;
                $transaction->rollback(); //var_dump($ex->getMessage(), $ex->getTraceAsString()); die;
                Yii::app()->user->setFlash('error', "Data gagal disimpan [2]" . MyExceptionMessage::getMessage($ex, true));
            }

        }

        if(isset($_GET['pendaftaran_id'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
        }
        $modRiwayatPermintaanDarah = new PasienkirimkeunitlainT('search');
        $modRiwayatPermintaanDarah->pendaftaran_id = $pendaftaran_id;
        $modRiwayatPermintaanDarah->ruangan_id = Params::RUANGAN_ID_BANK_DARAH;

        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'grid-statusterima') {
                $this->renderPartial($this->path_view . '_tabelStatusPermintaanDarah',[
                    'modRiwayatPermintaanDarah' => $modRiwayatPermintaanDarah
                ]);
                Yii::app()->end();
            }
        }
        // echo '<pre>';
        // var_dump($modRiwayatPermintaanDarah);die;
        $this->render($this->path_view . 'index', array(
            'modPendaftaran' => $modPendaftaran,
            'modPermintaanDarah' => $modPermintaanDarah,
            'modPermintaanDarahDet' => $modPermintaanDarahDet,
            'format' => $format,
            'modRiwayat' => $modRiwayat,
            'modRiwayatPermintaanDarah' => $modRiwayatPermintaanDarah,
            'modPasien' => $modPasien,
            'modPermintaanPenunjang' => $modPermintaanPenunjang,
            'modkirimkeunitlain' => $modkirimkeunitlain
        ));
    }

    public function notifPermintaanDarah($modPasienKirimKeUnitLain)
    {


        $penunjang = PasienkirimkeunitlainV::model()->findByAttributes(array(
        'pasienkirimkeunitlain_id' => $modPasienKirimKeUnitLain->pasienkirimkeunitlain_id
        ));
        $judul = "Permintaan Darah Pasien - " . $modPasienKirimKeUnitLain->no_permintaan;

        $asal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
        $tujuan = RuanganM::model()->findByPk($modPasienKirimKeUnitLain->ruangan_id);

        $isi = "Tgl. Periksa : " . MyFormatter::formatDateTimeForUser($modPasienKirimKeUnitLain->tgl_kirimpasien) . "<br/>";
        $isi .= "No. Periksa : " . $modPasienKirimKeUnitLain->no_permintaan . "<br/>";
        $isi .= "No. Pendaftaran : " . $penunjang->no_pendaftaran . "<br/>";
        $isi .= "Pasien : " . $penunjang->no_rekam_medik . " - " . $penunjang->nama_pasien;

        $link = $this->createUrl('/bankDarah/verifikasiPermintaanDarahPasien/index', array(
            'pasienkirimkeunitlain_id' => $modPasienKirimKeUnitLain->pasienkirimkeunitlain_id,
            'pendaftaran_id' => $modPasienKirimKeUnitLain->pendaftaran_id
        ));

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
        array('instalasi_id' => $asal->instalasi_id, 'ruangan_id' => $asal->ruangan_id, 'modul_id' => $asal->modul_id),
        array('instalasi_id' => $tujuan->instalasi_id, 'ruangan_id' => $tujuan->ruangan_id, 'modul_id' => $tujuan->modul_id, 'link_proses' => $link),
        ));
    }

    function actionCekPenyiapanDarah() {
        $pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];

        $modPenyiapan = PenyiapandarahT::model()->findByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);

        if(!empty($modPenyiapan)) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        echo json_encode($data);
    }

    function actionTerimaDarah() {
        $this->layout = '//layouts/iframe';
        $pasienkirimkeunitlain_id = $_GET['pasienkirimkeunitlain_id'];
        $modPenyiapanDarah = PenyiapandarahT::model()->findByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);
        $modPendaftaran = $modPenyiapanDarah->pendaftaran;
        
        if(empty($modPenyiapanDarah)) {
            $modPenyiapanDarah = new PenyiapandarahT();
        }

        $modPenyiapanDarah->tgl_terimadarah = date('Y-m-d H:i:s');
        try {
            $transaction = Yii::app()->db->beginTransaction();
            $save = false;
            if(isset($_POST['PenyiapandarahT'])) {
                $modPenyiapanDarah->tgl_terimadarah = $_POST['PenyiapandarahT']['tgl_terimadarah'];
                $modPenyiapanDarah->peg_penerimapermintaan_id = $_POST['PenyiapandarahT']['peg_penerimapermintaan_id'];
                if($modPenyiapanDarah->update()) {
                    $save = true;
                }
            }
            if($save) {
                $modPegawai = PegawaiM::model()->findByPk($_POST['PenyiapandarahT']['peg_penerimapermintaan_id']);
                $judul = 'Darah Diterima';
                $isi = $modPendaftaran->no_pendaftaran . ' - ' . $modPendaftaran->pasien->no_rekam_medik . ' - ' . $modPendaftaran->pasien->nama_pasien . '<br>';
                $isi .= 'Status : <b>Darah Telah Diterima</b><br>';
                if(!empty($modPegawai)) {
                    $isi .= 'Petugas Penerima : ' . $modPegawai->namaLengkap;
                }
                $transaction->commit();
                $tujuan = RuanganM::model()->findByPk(Params::RUANGAN_ID_BANK_DARAH);
                if(!empty($tujuan)) {
                    CustomFunction::broadcastNotif($judul, $isi, array(
                        array(
                            'instalasi_id' => $tujuan->instalasi_id, 
                            'ruangan_id' => $tujuan->ruangan_id, 
                            'modul_id' => $tujuan->modul_id, 
                            'pegawai_id' => $modPenyiapanDarah->peg_penerimapermintaan_id
                        ),
                    ));
                }
                
                Yii::app()->user->setFlash('success', 'Darah Berhasil Diterima');
                $this->redirect(['TerimaDarah', 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'sukses' => 1]);
            }
        } catch (Exception $exc) {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', 'Data Gagal Disimpan');
        }

        $this->render($this->path_view . 'terimaDarah', ['modPenyiapanDarah' => $modPenyiapanDarah]);
    }

    function actionReaksiTransfusi() {
        $this->layout = '//layouts/iframe';
        $pasienkirimkeunitlain_id = $_GET['pasienkirimkeunitlain_id'];

        $modPenyiapanDarah = PenyiapandarahT::model()->findByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);

        if(!empty($modPenyiapanDarah->gejala_reaksitransfusi)) {
            $exGejala = explode(',', $modPenyiapanDarah->gejala_reaksitransfusi);
            if($modPenyiapanDarah->kategori_gejalatransfusi == 'Kategori I') {
                $modPenyiapanDarah->gejala_reaksitransfusi1 = $exGejala;
            }
            if($modPenyiapanDarah->kategori_gejalatransfusi == 'Kategori II') {
                $modPenyiapanDarah->gejala_reaksitransfusi2 = $exGejala;
            }
            if($modPenyiapanDarah->kategori_gejalatransfusi == 'Kategori III') {
                $modPenyiapanDarah->gejala_reaksitransfusi3 = $exGejala;
            }

        }

        // echo '<pre>';var_dump($modPenyiapanDarah->reaksi_transfusi);die;
        if(empty($modPenyiapanDarah)) {
            $modPenyiapanDarah = new PenyiapandarahT();
        }

        try {
            $transaction = Yii::app()->db->beginTransaction();
            $save = false;
            if(isset($_POST['PenyiapandarahT'])) {
                // echo '<pre>';var_dump($_POST);die;
                $modPenyiapanDarah->reaksi_transfusi = $_POST['PenyiapandarahT']['reaksi_transfusi'];
                $modPenyiapanDarah->kategori_gejalatransfusi = isset($_POST['PenyiapandarahT']['kategori_gejalatransfusi']) ? $_POST['PenyiapandarahT']['kategori_gejalatransfusi'] : '';
                $gejala = '';
                if(isset($_POST['PenyiapandarahT']['gejala_reaksitransfusi1']) && $_POST['PenyiapandarahT']['gejala_reaksitransfusi1'] != '') {
                    $gejala = implode(',', $_POST['PenyiapandarahT']['gejala_reaksitransfusi1']);
                }
                if(isset($_POST['PenyiapandarahT']['gejala_reaksitransfusi2']) && $_POST['PenyiapandarahT']['gejala_reaksitransfusi2'] != '') {
                    $gejala = implode(',', $_POST['PenyiapandarahT']['gejala_reaksitransfusi2']);
                }
                if(isset($_POST['PenyiapandarahT']['gejala_reaksitransfusi3']) && $_POST['PenyiapandarahT']['gejala_reaksitransfusi3'] != '') {
                    $gejala = implode(',', $_POST['PenyiapandarahT']['gejala_reaksitransfusi3']);
                }
                $modPenyiapanDarah->gejala_reaksitransfusi = $gejala;
                // echo '<pre>';var_dump($modPenyiapanDarah->gejala_reaksitransfusi);die;
                if($modPenyiapanDarah->update()) {
                    $save = true;
                }
            }
            if($save) {
                $transaction->commit();
                Yii::app()->user->setFlash('success', 'Data berhasil disimpan');
                $this->redirect(['ReaksiTransfusi', 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id,'sukses' => 1]);
            }
        } catch (Exception $exc) {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', 'Data Gagal Disimpan');
        }

        $this->render($this->path_view . 'reaksiTransfusi', ['modPenyiapanDarah' => $modPenyiapanDarah]);
    }

    public function actionDeleteriwayatPermintaan()
    {
        $pasienkirimkeunitlain_id = $_POST['id'];

        $data['sukses'] = 0;
        $data['pesan'] = 'Gagal membatalkan Pasien';
        $pasienmasukpenunjang = PasienmasukpenunjangT::model()->findByPk(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);
        if(!empty($pasienmasukpenunjang)) {
            $data['pesan'] = 'Tidak Dapat Melakukan Pembatalan. pasien sudah masuk penunjang';
        } else {
            $modKirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
    
            $modPermintaanPenunjang = PermintaankepenunjangT::model()->findByAttributes(['pasienkirimkeunitlain_id' => $modKirim->pasienkirimkeunitlain_id]);

            // echo '<pre>'; var_dump($modPermintaanPenunjang, $modKirim->attributes); die;
    
            if(!empty($modPermintaanPenunjang)) {
                if($modPermintaanPenunjang->delete()) {
                    if($modKirim->delete()) {
                        $data['sukses'] = 1;
                    }
                }
            } else {
                if($modKirim->delete()) {
                    $data['sukses'] = 1;
                }                
            }
        }


        echo json_encode($data);
    }

    public function actionGetAlamat() {

        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            
            $id = $_POST['id'];
            $returnVal['alamat'] = PasienM::model()->findByPk($id)->alamat_pasien;

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * fungsi untuk multipel insert
     * @param type $model
     * @param type $data
     * @return \BDPermintaandarahdetT
     */
    protected function validasiTabular($model, $data) {
        $valid = true;
        foreach ($data as $i => $row) {

            if(!empty($row['permintaandarahdet_id'])){
                $modDetails[$i] = BDPermintaandarahdetT::model()->findByPk($row['permintaandarahdet_id']);
            }else{
                $modDetails[$i] = new BDPermintaandarahdetT;
            }
            $modDetails[$i]->attributes = $row;
            $modDetails[$i]->permintaandarah_id = $model->permintaandarah_id;
            $modDetails[$i]->tglren_transfusi = MyFormatter::formatDateTimeForDb($row['tglren_transfusi']);

            $valid = $modDetails[$i]->validate() && $valid;
        }
        return $modDetails;
    }
    

    /**
     * proses simpan TindakanPelayananT
     * @param type $modPermintaanDarah
     * @param type $data
     * @return \BDTindakanPelayananT
     */
    public function simpanTindakanPelayanan($modPermintaanDarah, $data) {
        $modTarifTindakan = TariftindakanperdatotalV::model()->findByAttributes(array('kelaspelayanan_id' => 5, 'daftartindakan_id' => $data->daftartindakan_id));
        $modTindakan = new BDTindakanPelayananT;

        $modTindakan->create_time = date("Y-m-d H:i:s");
        $ruangan = RuanganM::model()->findByPk($modPermintaanDarah->ruanganpemesan_id);
        $modTindakan->instalasi_id = $ruangan->instalasi_id;
        $pendaftaran = PendaftaranT::model()->findByPk($modPermintaanDarah->pendaftaran_id);
        $modTindakan->kelaspelayanan_id = $pendaftaran->kelaspelayanan_id;
        $modTindakan->pasien_id = $modPermintaanDarah->pasien_id;
        $modTindakan->daftartindakan_id = $data->daftartindakan_id;
        $modTindakan->carabayar_id = $pendaftaran->carabayar_id;
        $modTindakan->pendaftaran_id = $pendaftaran->pendaftaran_id;
        $modTindakan->jeniskasuspenyakit_id = $pendaftaran->jeniskasuspenyakit_id;
        $modTindakan->ruangan_id = $modPermintaanDarah->ruanganpemesan_id;
        $modTindakan->penjamin_id = $pendaftaran->penjamin_id;
        $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_DARAH;
        $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
        $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
        $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
        $modTindakan->tarif_satuan = isset($modTarifTindakan->harga_tariftindakan) ? $modTarifTindakan->harga_tariftindakan : 0;
        $modTindakan->tarif_tindakan = isset($modTarifTindakan->harga_tariftindakan) ? $modTarifTindakan->harga_tariftindakan * $modTindakan->qty_tindakan : 0;
        $modTindakan->cyto_tindakan = 0;
        $modTindakan->tarifcyto_tindakan = 0;
        $modTindakan->discount_tindakan = 0;
        $modTindakan->subsidiasuransi_tindakan = 0;
        $modTindakan->subsidipemerintah_tindakan = 0;
        $modTindakan->subsisidirumahsakit_tindakan = 0;
        $modTindakan->iurbiaya_tindakan = 0;
        $modTindakan->tarif_rsakomodasi = 0;
        $modTindakan->tarif_medis = 0;
        $modTindakan->tarif_paramedis = 0;
        $modTindakan->tarif_bhp = 0;
        if ($modTindakan->validate()) {
            if ($modTindakan->save()) {
                $this->saveTindakanKomponen($modTindakan);
            }
        } else {
            $this->tindakanpelayanantersimpan &= false;
        }

        return $modTindakan;
    }

    /**
     * simpan komponen tarif
     * @param type $modTindakan
     * @return \TindakankomponenT
     */
    public function saveTindakanKomponen($modTindakan) {
        $modTarifTindakan = TariftindakanperdatotalV::model()->findByAttributes(array('kelaspelayanan_id' => 5, 'daftartindakan_id' => $modTindakan->daftartindakan_id));

        $modTindakanKomponen = new TindakankomponenT();
        $modTindakanKomponen->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
        $modTindakanKomponen->komponentarif_id = isset($modTarifTindakan->komponentarif_id) ? $modTarifTindakan->komponentarif_id : 1;
        $modTindakanKomponen->tarif_kompsatuan = isset($modTarifTindakan->harga_tariftindakan) ? $modTarifTindakan->harga_tariftindakan : 0;
        $modTindakanKomponen->tarif_tindakankomp = isset($modTarifTindakan->harga_tariftindakan) ? $modTarifTindakan->harga_tariftindakan : 0;
        $modTindakanKomponen->tarifcyto_tindakankomp = 0;
        $modTindakanKomponen->subsidiasuransikomp = 0;
        $modTindakanKomponen->subsidipemerintahkomp = 0;
        $modTindakanKomponen->subsidirumahsakitkomp = 0;
        $modTindakanKomponen->iurbiayakomp = 0;
        if ($modTindakanKomponen->validate()) {
            if ($modTindakanKomponen->save()) {
                $this->komponentindakantersimpan &= true;
            }
        } else {
            $this->komponentindakantersimpan &= false;
        }
        return $modTindakanKomponen;
    }

    /**
     * fungsi untuk proses multipel insert
     */
    public function actionGetPermintaanDarahDetail() {
        if (Yii::app()->request->isAjaxRequest) {
           
            $tipepaket_id = '';
            $data = [];
            $data['sukses'] = 0;
            $data['pesan'] = 'Tipe Paket Kosong';
            $data['tr'] = '';
          
            if(($_POST['jeniskomponendarah_id'] != "")) {
                $jeniskomponendarah_id = $_POST['jeniskomponendarah_id'];
                $modJenisKomponenDarah = JeniskomponendarahM::model()->findByPk($jeniskomponendarah_id);
                if(!empty($modJenisKomponenDarah)) {
            
                    $pasien_id = $_POST['pasien_id'];
                    if (isset($pasien_id)) {
                        $modPasien = PasienM::model()->findByPk($pasien_id);
                    }
                    
                    $jumlahkantong_detail = $_POST['jumlahkantong_detail'];
                    $indikasi_detail = $_POST['indikasi_detail'];

                    $modPermintaanKepenunjang = new PermintaankepenunjangT();
                    $modPermintaanKepenunjang->jenispermintaan = $_POST['jenispermintaan'];
                    $modPermintaanKepenunjang->kadarhb = $_POST ["kadarhb"];
                    $modPermintaanKepenunjang->plt = $_POST ["plt"];
                    $modPermintaanKepenunjang->jenis_volume = $_POST ["jenis_volume"];
                    $modPermintaanKepenunjang->diambil = $_POST["diambil"] . " " . $_POST["jenis_volume_diambil"];
                    $modPermintaanKepenunjang->dititip = $_POST["dititip"] . " " . $_POST["jenis_volume_dititip"];
                    $modPermintaanKepenunjang->indikasi_darah = $indikasi_detail;
                    $modPermintaanKepenunjang->qtypermintaan = $jumlahkantong_detail;


                
                    $tr = '';
                   
                    $tr .= $this->renderPartial($this->path_view . '_detailPermintaanDarah', array(
                        'modPasien' => $modPasien,
                        'modPermintaanKepenunjang' => $modPermintaanKepenunjang,
                        'modJenisKomponenDarah' => $modJenisKomponenDarah
                    ), true);
                    
                    $data['sukses'] = 1;
                    $data['tr'] = $tr;
                    
                } else {
                    $data['pesan'] = 'Tidak Ditemukan Jeniskomponendarah';
                }
            } else {

                $modPermintaanKepenunjang = new PermintaankepenunjangT();


                if($_POST['pasienkirimkeunitlain_id'] != '') {
                    $modPermintaanKepenunjang = PermintaankepenunjangT::model()->find("pasienkirimkeunitlain_id = " . $_POST['pasienkirimkeunitlain_id']);
                    $modkirimkeunitlain = PasienkirimkeunitlainT::model()->findByPk($_POST['pasienkirimkeunitlain_id']);
                    $modJenisKomponenDarah = JeniskomponendarahM::model()->findByPk($modkirimkeunitlain->jeniskomponendarah_id);
                    $modPasien = $modkirimkeunitlain->pasien;

                    $tr = '';
                   
                    $tr .= $this->renderPartial($this->path_view . '_detailPermintaanDarah', array(
                        'modPasien' => $modPasien,
                        'modPermintaanKepenunjang' => $modPermintaanKepenunjang,
                        'modJenisKomponenDarah' => $modJenisKomponenDarah
                    ), true);
                    
                    $data['sukses'] = 1;
                    $data['tr'] = $tr;
                }
            }

            echo json_encode($data);
            Yii::app()->end();
            
        }
    }

    /**
     * digunakan untuk autocomplete pegawai
     */
    public function actionAutocompletePetugas() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nama = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(ppds_nama)', strtolower($nama), true);
            $criteria->limit = 5;
            $models = PpdsM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->ppds_nim . " - " . $model->ppds_nama;
                $returnVal[$i]['value'] = $model->ppds_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

       /**
     * digunakan untuk autocomplete pegawai
     */
    public function actionAutocompleteRuangan() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nama = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(ruangan_nama)', strtolower($nama), true);
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->limit = 5;
            $models = RuanganM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->ruangan_nama;
                $returnVal[$i]['value'] = $model->ruangan_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Digunakan untuk mencetak dokumen
     * @author Andyka Putra <andykaputra@.com>
     * @param type $permintaandarah_id
     * @param type $caraPrint
     */
    public function actionPrint($permintaandarah_id,$caraPrint) {
        $jumlah = 0;
        $model = BDPermintaandarahT::model()->findByPk($permintaandarah_id);
        $modDetail = BDPermintaandarahdetT::model()->findAll(array('group' => 'permintaandarah_id, permintaandarahdet_id', 'condition' => 'permintaandarah_id =' . $permintaandarah_id));
        $modPasien = BDPasienM::model()->findByPk($model->pasien_id);
        $modPendaftaran = BDPendaftaranT::model()->findByPk($model->pendaftaran_id);

        $judulLaporan = 'INSTALASI TRANSFUSI DARAH RSUD DR. SOETOMO SURABAYA <br> BUKTI TERIMA PERMINTAAN DARAH';
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'modDetail' => $modDetail, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran));
        } else if ($caraPrint == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 20, 20, 20, 20, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintPDF', array('model' => $model, 'judulLaporan' => $judulLaporan, 'modDetail' => $modDetail, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran), true));
            $mpdf->Output();
        }
    }

    /**
     * Fungsi hapus detail
     * @param type $id
     * @throws CHttpException
     */
    public function actionDeletedet($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $hapustransaksi = PermintaandarahdetT::model()->findByPk($id);
                if ($hapustransaksi->delete()) {
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                } else {
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data tidak dapat dihapus!";
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data tidak dapat dihapus!";
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    /**
     * Hapus data riwayat
     */
    function actionDeleteRiwayat() {
        if (Yii::app()->request->isAjaxRequest) {

            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $id = isset($_POST['id']) ? $_POST['id'] : null;
                $ok = true;
                $cekData = PermintaandarahT::model()->findByPk($id);
                if (!empty($cekData)) {
                    $modDet = PermintaandarahdetT::model()->deleteAllByAttributes(array('permintaandarah_id' => $id));
                }
                $del = PermintaandarahT::model()->findByPk($id);
                if ($del->delete()) {
                    $trans->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Data berhasil Dihapus';
                } else {
                    $trans->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data gagal dihapus';
                }
            } catch (Exception $e) {
                $trans->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Data gagal dihapus';
            }

            echo json_encode($data);

            Yii::app()->end();
        }
    }
    
}
