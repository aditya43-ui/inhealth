<?php

class EntryTarifTindakanController extends MyAuthController
{
    public $succesSave = false;

    function actionIndex($pendaftaran_id = null, $pasien_id = null) {
        $modPendaftaran = new FAPendaftaranT();
        $modPasien = new FAPasienM();
        $modTindakanPelayanan = new TindakanpelayananT();
        if(!empty($pendaftaran_id)) {
            $modPendaftaran = FAPendaftaranT::model()->findByPk($pendaftaran_id);
        }
        if(isset($_GET['ajax']) && $_GET['ajax'] == 'pendaftaran-t-grid') {
            $this->renderPartial('_dialogPasien');
            Yii::app()->end();
        }
        if(isset($_GET['ajax']) && $_GET['ajax'] == 'tindakan-grid') {
            $this->renderPartial('_dialogTindakan');
            Yii::app()->end();
        }

        if(isset($_POST['FATindakanPelayanan']) && count($_POST['FATindakanPelayanan']) > 0) {
            $modPendaftaran = PendaftaranT::model()->findByPk($_POST['FAPendaftaranT']['pendaftaran_id']);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

            $modTindakan = $this->saveTindakan($modPasien, $modPendaftaran);


            if ($this->succesSave) {
                $this->redirect(array('index', 'sukses' => 1, 'pendaftaran_id' => $modPendaftaran->pendaftaran_id));
            } else {
                Yii::app()->user->setFlash('error', "Data gagal disimpan <br>");
            }
        }


        $this->render('index', [
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modTindakanPelayanan' => $modTindakanPelayanan
        ]);
    }

    public function saveTindakan($modPasien, $modPendaftaran)
    {

        $post = (isset($_POST['FATindakanPelayanan'])) ? $_POST['FATindakanPelayanan'] : null;

        $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

        if(!empty($md_noawal)) {
            $noawal = intval($md_noawal->nopelayanan);
        } else {
            $noawal = 1;
        }


        // echo '<pre>';
        $valid = true; 
        foreach ($post as $i => $item) {

            if (!empty($item) && (!empty($item['daftartindakan_id']))) {
                $modTindakans[$i] = new FATindakanPelayanan();
                $modTindakans[$i]->attributes = $item;
                $modTindakans[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
                $modTindakans[$i]->pasien_id = $modPasien->pasien_id;
                $modTindakans[$i]->carabayar_id = $modPendaftaran->carabayar_id;
                $modTindakans[$i]->penjamin_id = $modPendaftaran->penjamin_id;
                $modTindakans[$i]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                $modTindakans[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modTindakans[$i]->keterangantindakan = empty($item['keterangantindakan']) ? null : $item['keterangantindakan'];
                $modTindakans[$i]->tgl_tindakan = $modTindakans[0]->tgl_tindakan;
                $modTindakans[$i]->shift_id = Yii::app()->user->getState('shift_id');
                $modTindakans[$i]->tgl_tindakan = date('Y-m-d H:i:s');
                $modTindakans[$i]->tarif_tindakan = $item['jumlahtarif'];
                $modTindakans[$i]->tarif_satuan = $item['jumlahtarif'];
                $modTindakans[$i]->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
                $modTindakans[$i]->subsidiasuransi_tindakan = 0;
                $modTindakans[$i]->subsidipemerintah_tindakan = 0;
                $modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
                $modTindakans[$i]->iurbiaya_tindakan = 0;

            
                $modTindakans[$i]->discount_tindakan = 0;
            
                $modTindakans[$i]->ruangan_id =  isset($item['ruangan_id']) ? $item['ruangan_id'] : Yii::app()->user->getState('ruangan_id'); // RND-6244
                $modTindakans[$i]->instalasi_id = $modTindakans[$i]->ruangan->instalasi_id;

                if (empty($modTindakans[$i]->kelaspelayanan_id)) {
                    $modTindakans[$i]->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                }

                $modTindakans[$i]->nopelayanan = str_pad($noawal+1,3,"0",STR_PAD_LEFT);
                
                // $valid = $modTindakans[$i]->validate() && $valid;
                var_dump($modTindakans[$i]->validate(), $modTindakans[$i]->getErrors());
            }
        }

        // die;


        $transaction = Yii::app()->db->beginTransaction();
        try {
        if ($valid && (count((array)$modTindakans) > 0)) {

            $statusSaveKomponen = false;
            foreach ($modTindakans as $i => $tindakan) {

                if ($tindakan->save()) {
                    
                    $statusSaveKomponen = true;

                }

          
            }

            // TindakanpelayananT::model()->updateAll(array('nopelayanan' => '001'), 'nopelayanan is null and masukkamar_id is null and pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);

            
            if ($statusSaveKomponen) {
            $p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
            $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_DIPERIKSA);

            /* ================================================ */
            /* Proses update status periksa KonsulPoli EHS-179  */
            /* ================================================ */
            $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'))); // RND-6244
            if (!empty($konsulPoli)) {
                $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
            }
            /* ================================================ */

            PendaftaranT::model()->updateByPk(
                $modPendaftaran->pendaftaran_id,
                array(
                'pembayaranpelayanan_id' => null
                )
            );

            $transaction->commit();
            $this->succesSave = true;
            Yii::app()->user->setFlash('success', "Data Tindakan Pasien berhasil disimpan");
            //Yii::app()->user->setFlash('error',"Data valid ".$this->traceObatAlkesPasien($modPemakainBahans));
            } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data tidak valid 1");
            //Yii::app()->user->setFlash('error',"Data tidak valid ".$this->traceObatAlkesPasien($modPemakainBahans));
            }
        } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data tidak valid 2");
            //Yii::app()->user->setFlash('error',"Data tidak valid ".$this->traceTindakan($modTindakans));
        }
        } catch (Exception $exc) {
            echo '<pre>'; var_dump($exc); die;
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data Tindakan Pasien Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
        }

        return $modTindakans;
    }

    function actionTambahDetail() {
        $daftartindakan_kode = $_POST['daftartindakan_kode'];
        $daftartindakan_nama = $_POST['daftartindakan_nama'];
        $daftartindakan_id = $_POST['daftartindakan_id'];
        $jumlahtarif = $_POST['jumlahtarif'];

        $modTindakanPelayanan = new FATindakanPelayanan();
        $modTindakanPelayanan->daftartindakan_kode = $daftartindakan_kode;
        $modTindakanPelayanan->daftartindakan_nama = $daftartindakan_nama;
        $modTindakanPelayanan->daftartindakan_id = $daftartindakan_id;
        $modTindakanPelayanan->jumlahtarif = $jumlahtarif;

        $data['html'] = $this->renderPartial('_rowDetail', [
            'modTindakanPelayanan' => $modTindakanPelayanan
        ], true);

        echo json_encode($data);
    }

    public function getJsonKunjungan($data)
    {
        $res = $data->attributes;
        $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
        $pj = PenanggungjawabM::model()->findByPk($pendaftaran->penanggungjawab_id);

        $dokterpenerima = "";
        $dpjp1 = "";
        $dpjp2 = "";
        $dpjp3 = "";

        if (!empty($data->pasienadmisi_id)) {
        $admisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);

        if (!empty($admisi->dokterpenerima_id)) {
            $peg = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
            $dokterpenerima = $peg->namaLengkap;
        }
        if (!empty($admisi->pegawai_id)) {
            $peg = PegawaiM::model()->findByPk($admisi->pegawai_id);
            $dpjp1 = $peg->namaLengkap;
        }
        if (!empty($admisi->dpjp2_id)) {
            $peg = PegawaiM::model()->findByPk($admisi->dpjp2_id);
            $dpjp2 = $peg->namaLengkap;
        }
        if (!empty($admisi->dpjp3_id)) {
            $peg = PegawaiM::model()->findByPk($admisi->dpjp3_id);
            $dpjp3 = $peg->namaLengkap;
        }
        }

        $res['dpjp1'] = $dpjp1;
        $res['dpjp2'] = $dpjp2;
        $res['dpjp3'] = $dpjp3;
        $res['dokterpenerima'] = $dokterpenerima;

        $res['jeniskasuspenyakit'] = $data->jeniskasuspenyakit_nama;
        $res['namainstalasi'] = $data->instalasi_nama;
        $res['namaruangan'] = $data->ruangan_nama;
        $res['penjamin_nama'] = $data->penjamin_nama;
        $res['carabayar_nama'] = $pendaftaran->carabayar->carabayar_nama;
        $res['jeniskelamin'] = $data->jeniskelamin;

        $res['namapasien'] = $data->nama_pasien;
        $res['tanggal_lahir'] = MyFormatter::formatDateTimeForUser($data->tanggal_lahir);

        $kelas = KelaspelayananM::model()->findByPk($data->kelaspelayanan_id);

        $res['kelaspelayanan_id'] = $kelas->kelaspelayanan_nama;
        $res['kelastanggungan'] = null;

        $res['tgl_pendaftaran'] = MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);

        if (!empty($data->no_rekam_medik)) {
        $res['norekammedik'] = $data->no_rekam_medik;
        }

        if (!empty($pendaftaran->asuransipasien_id)) {

        $asuransi = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);
        
        $kelaspelayanan = Params::KELASPELAYANAN_ID_TANPA_KELAS;
        if(isset($asuransi->kelastanggunganasuransi_id)) {
            $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
            $kelaspelayanan = $kelas->kelaspelayanan_nama;;

        }

        $res['kelastanggungan'] = $kelaspelayanan;
        }

        $res['nama_pj'] = null;
        if (!empty($pj)) {
        $res['nama_pj'] = $pj->nama_pj;
        }


      

        return $res;
    }

    public function actionPrintUlangTindakanDialog($pendaftaran_id)
    {
        Yii::import('rawatJalan.models.*');
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter;
        // echo '<pre>';var_dump($pendaftaran_id);die;
        $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modTindakan = new RJTindakanPelayananT;
        $modTindakan->tarifcyto_tindakan = 0;
        $modTindakan->dokterpemeriksa1_id = $modPendaftaran->pegawai_id;
        $modTindakan->dokterpemeriksa1Nama = $modPendaftaran->pegawai->NamaLengkap;
        
        $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id = ' . $modPendaftaran->penjamin_id);

        $this->render(
        'printUlang/printUlangDialog',
        array(
            'format' => $format,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modTindakan' => $modTindakan,
            'modJenisTarif' => $modJenisTarif,
        )
        );
    }
}