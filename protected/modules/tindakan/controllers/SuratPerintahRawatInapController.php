
<?php

class SuratPerintahRawatInapController extends MyAuthController
{
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = "rawatJalan.views.suratPerintahRawatInap.";
    public $tersimpan = false;

    public function actionIndex($pendaftaran_id, $suratperintahranap_id = null)
	{
        $this->layout='//layouts/iframe';
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        if (empty($modPendaftaran)) {
            throw new CHttpException(404,'The requested page does not exist.');
        }

        $model = SuratperintahranapT::model()->findByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
        ));

        $modAnamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'anamesa_id DESC'));
//        $modSuratPersetujuanUmum = SuratpersetujuanumumT::model()->findByAttributes(array(
//            'pendaftaran_id'=>$pendaftaran_id,
//        ));

        if(!isset($model)){
            $model = new SuratperintahranapT();
            $model->pendaftaran_id = $pendaftaran_id;
            $model->pasien_id = $modPendaftaran->pasien_id;
            $model->pasienpulang_id = $modPendaftaran->pasienpulang_id;
            $model->instalasi_id = $modPendaftaran->instalasi_id;
            $model->nomorsurat = MyGenerator::noSuratPerintahRI($model->instalasi_id, $model->isranap_perinatologi);
            $model->nourutsurat = MyGenerator::noSuratPerintahRIUrut($model->instalasi_id, $model->isranap_perinatologi);
            $model->tgl_suratperintahranap = date('d M Y H:i:s');
            $model->therapi_sementara = !empty($modAnamnesa->konsultasidokter) ? $modAnamnesa->konsultasidokter : "";
        }else{
            $model->tgl_suratperintahranap = MyFormatter::formatDateTimeForUser($model->tgl_suratperintahranap);
        }        
        $vclaim_msg = "";

        if(isset($_POST['SuratperintahranapT'])){
            $transaction = Yii::app()->db->beginTransaction();

            try {
                $model->attributes = $_POST['SuratperintahranapT'];
                if(!isset($model->suratperintahranap_id) || empty($model->suratperintahranap_id)){
                  $model->nomorsurat = MyGenerator::noSuratPerintahRI($model->instalasi_id, $model->isranap_perinatologi);
                  $model->nourutsurat = MyGenerator::noSuratPerintahRIUrut($model->instalasi_id, $model->isranap_perinatologi);
                }

                $model->tgl_suratperintahranap = MyFormatter::formatDateTimeForDB($model->tgl_suratperintahranap);
                $model->tgl_rencanaranap = MyFormatter::formatDateTimeForDB($model->tgl_rencanaranap);
                $model->profilrs_id = Params::getDefaultProfilRS();
                $model->ruangansurat_id = Yii::app()->user->getState("ruangan_id");

                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                $model->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");
                $model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");


                if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS && Yii::app()->user->getState('isbridging') == true) {
                
                    $kode_dokter = "";
                    if (!empty($model->dpjp_id)) {
                        $dok = PegawaiM::model()->findByPk($model->dpjp_id);
                        if (!empty($dok)) {
                            $kode_dokter = $dok->kodedokter_bpjs;
                        }
                    } else{
                        $dpjp = PasienpulangT::model()->findByAttributes(array('pasien_id' => $_POST['SuratperintahranapT']['pasien_id']));
                        if (!empty($dpjp->dokterpenerima_id)) {
                            $pegawaiPj = PegawaiM::model()->findByPk($dpjp->dokterpenerima_id);
                            $kode_dokter = $pegawaiPj->kodedokter_bpjs;
                        }
                    }
                    $no_kartu = $model->nokartubpjs;

                    $no_kartu = $_POST['SuratperintahranapT']['nokartubpjs'];
                    /*
                    if (isset($_POST['SepT']['nokartuasuransi'])) {
                        $no_kartu = $_POST['SepT']['nokartuasuransi'];
                    }*/
                    $poli = SpesialissubspesialisM::model()->findByPk($model->spesialissubspesialis_id);
                    $kontrol_poli = $poli->spesialissubspesialis_kode ?? $poli->spesialissubspesialis_kodebpjs;
                    $kontrol_tgl_rencana = date('Y-m-d', strtotime($model->tgl_rencanaranap));
                    $user = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                    $kontrol_user_res = empty($user) ? "" : trim($user->namaLengkap);

                    
                    // var_dump($no_kartu, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res);
                    // die; 
                    $bpjs = new Bpjs_Vklaim;

                    $model->nokartubpjs = $no_kartu;

                    // var_dump($modSurat->attributes); die;
                    if (!empty($model->nomorspri_bpjs)) {
                        $res_kontrol = $bpjs->update_spri($model->nomorspri_bpjs, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res);
                        
                    } else {
                        $res_kontrol = $bpjs->create_spri($no_kartu, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res);
                    }
                    $res_json = CJSON::decode($res_kontrol);
                    $vclaim_msg = "";
                    if (!$res_kontrol) {
                        $vclaim_msg = "Note : Ada kesalahan ketika membuat rencana kontrol";
                    } else {
                        $res_json = CJSON::decode($res_kontrol);

                        if ($res_json['metaData']['code'] != 200) {
                            
                            $vclaim_msg = "Note : ".$res_json['metaData']['message'];
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $vclaim_msg);
                        } else {
                            $model->nomorspri_bpjs = $res_json['response']['noSPRI'];
                        }
                        $model->responspri_bpjs = CJSON::encode($res_json['response']);
                    }




                    /*
                    $kontrol_no_sep = isset($_POST['SepT']['nosep']) ? $_POST['SepT']['nosep'] : null;
                    */
                    //var_dump();
                    if ($model->save() && $res_json['metaData']['code'] == 200) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan ! " . $vclaim_msg);
                        $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id, 'suratperintahranap_id' => $model->suratperintahranap_id, 'sukses' => 1));
                    } else {
                        //    $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $vclaim_msg);
                    }

                }else{
                    if ($model->save()) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan ! " . $vclaim_msg);
                        $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id, 'suratperintahranap_id' => $model->suratperintahranap_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $vclaim_msg);
                    } 
                }

                // var_dump($model->attributes, $_POST); die;

                // if($model->save() && $res_json['metaData']['code'] == 200){
                //     $transaction->commit();
                //     Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan ! ".$vclaim_msg);
                //     $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id,'suratperintahranap_id'=>$model->suratperintahranap_id,'sukses'=>1));
                // }else{
                // //    $transaction->rollback();
                //     Yii::app()->user->setFlash('error',"Data pasien gagal disimpan ! ".$vclaim_msg);
                // }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data pasien gagal disimpan ! ".MyExceptionMessage::getMessage($exc,true));
            }
        }
        $this->render($this->path_view.'index',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modAnamnesa' => $modAnamnesa,
		));
    }

    public function actionAutocompleteNamaDokter()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            //   var_dump($_GET);die;
            $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
            $criteria->distinct = true;
            $criteria->order = 'nama_pegawai';
            //   $criteria->addCondition('instalasi_id ='.Params::INSTALASI_ID_RI);
            // $criteria->addCondition('jabatan_id is not null');
            $criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_DOKTER_SPESIALIS, Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP));
            $criteria->limit = 5;

            $models = PegawairuanganV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

	/**
	 * Mencetak data
	 */
	public function actionPrint($pendaftaran_id, $suratperintahranap_id)
	{
            $model = SuratperintahranapT::model()->findByPk($suratperintahranap_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modSep = SepT::model()->findByPk($modPendaftaran->sep_id);

            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'caraPrint'=>$caraPrint, 'modSep'=>$modSep));
            }
	}
        
        /**
	 * Mencetak data
	 */
	public function actionPrintSuratRencanaInapBpjs($pendaftaran_id, $suratperintahranap_id)
	{
            $model = SuratperintahranapT::model()->findByPk($suratperintahranap_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modSep = SepT::model()->findByPk($modPendaftaran->sep_id);
            $modMorbiditas = PasienmorbiditasT::model()->findByAttributes([
                'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
                'kelompokdiagnosa_id'=>Params::KELOMPOKDIAGNOSA_UTAMA
            ]);

            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'printSuratRencanaInapBpjs',array(
                    'model'=>$model,
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'caraPrint'=>$caraPrint, 
                    'judul_print'=>'SURAT RENCANA INAP',
                    'modMorbiditas'=>$modMorbiditas,
                    'modSep'=>$modSep));
            }
	}
    
    public function actionGenerateNomor()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = $_POST['instalasi_id'];
            $isranap_perinatologi = (($_POST['isranap_perinatologi']=='true')?true:false);

            $data['nomorsurat'] = MyGenerator::noSuratPerintahRI($instalasi_id, $isranap_perinatologi);
            $data['nourut'] = MyGenerator::noSuratPerintahRIUrut($instalasi_id, $isranap_perinatologi);

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionCekVClaimSpesialis() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $html = '<option value="">-- Pilih --</option>';
        // $sep_id = $_POST['sep_id'];
        $no_kartu = $_POST['no_kartu'];
        $spesialis_id = $_POST['spesialis_id'];
        $tgl = MyFormatter::formatDateTimeForDB($_POST['tgl']);

        // $modSep = SepT::model()->findByPk($sep_id);
        $modSpesialis = SpesialissubspesialisM::model()->findByPk($spesialis_id);


        if (empty($modSpesialis)) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Data Spesialis tidak Ditemukan',
                'html'=>$html,
            ));
            Yii::app()->end();
        }

        // $no_kartu = $modSep->nokartuasuransi;

        $bpjs = new Bpjs_Vklaim;
        $res = $bpjs->search_spesialtik_kontrol(1, $no_kartu, $tgl);

        if (!$res) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Terjadi kesalahan dalam pengecekan Ruangan VClaim',
                'html'=>$html,
            ));
            Yii::app()->end();
        }


        $res_json = CJSON::decode($res);
        // vaR_dump($no_kartu, $tgl, $modSpesialis->attributes, $res_json); die;
        if ($res_json['metaData']['code'] != 200) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>$res_json['metaData']['message'],
                'html'=>$html,
            ));
            Yii::app()->end();
        }

        $is_ada = false;
        foreach ($res_json['response']['list'] as $item) {
            if ($modSpesialis->spesialissubspesialis_kode == $item['kodePoli'] 
            || $modSpesialis->spesialissubspesialis_kodebpjs == $item['kodePoli']) {
                $is_ada = true;


                break;
            }
        }

        if (!$is_ada) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Spesilis/Subspesialis tidak tersedia di BPJS',
                'html'=>$html,
            ));
            Yii::app()->end();
        }


        // DOKTER

        $peg = PegawaiM::model()->findAllByAttributes(array(
            'spesialissubspesialis_id'=>$modSpesialis->spesialissubspesialis_id
        ), array(
            'order'=>'nama_pegawai asc',
        ));

        $html = '<option value="">-- Pilih --</option>';

        foreach ($peg as $item) {
            if (empty($item->kodedokter_bpjs)) {
                continue;
            }
            $html .= '<option value="'.$item->pegawai_id.'">'.$item->namaLengkap.'</option>';
        }

        /*
        $bpjs = new Bpjs_Vklaim;
        $res = $bpjs->search_jadwal_dokter_kontrol(2, $modSpesialis->spesialissubspesialis_kode, $tgl);

        if (!$res) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Terjadi kesalahan dalam pengecekan Jadwal Dokter VClaim',
                'html'=>$html,
            ));
            Yii::app()->end();
        }



        $res_json = CJSON::decode($res);
        if ($res_json['metaData']['code'] != 200) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>$res_json['metaData']['message'],
                'html'=>$html,
            ));
            Yii::app()->end();
        }

        $is_ada = false;
        $html = '<option value="">-- Pilih --</option>';

        $peg_list = array();

        foreach ($res_json['response']['list'] as $item) {

            $peg = PegawaiM::model()->findByAttributes(array(
                'kodedokter_bpjs'=>$item['kodeDokter'],
            ));

            if (empty($peg)) {
                continue;
            }

            if (in_array($peg->pegawai_id, $peg_list)) {
                continue;
            }

            $peg_list[] = $peg->pegawai_id;

            $html .= '<option value="'.$peg->pegawai_id.'">'.$peg->namaLengkap.'</option>';

            //var_dump($item);
        }
        */






        echo CJSON::encode(array(
            'ok'=>1,
            'msg'=>'-',
            'html'=>$html,
        ));
    }
    
    /**
     * set antrian dokter
     */
    public function actionLoadDataDropdown()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $spesialis_id = $_POST['spesialis_id'];

            $modSpesialis = SpesialissubspesialisM::model()->findByPk($spesialis_id);

            $peg = PegawaiM::model()->findAllByAttributes(array(
                'spesialissubspesialis_id'=>$modSpesialis->spesialissubspesialis_id
            ), array(
                'order'=>'nama_pegawai asc',
            ));
    
            $html = '<option value="">-- Pilih --</option>';
    
            foreach ($peg as $item) {
                $html .= '<option value="'.$item->pegawai_id.'">'.$item->namaLengkap.'</option>';
            }


            echo CJSON::encode(array(
                'ok'=>1,
                'msg'=>'-',
                'html'=>$html,
            ));            
            Yii::app()->end();
        }
    }

    public function actionLoadNomorKartuDariNIK() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $nomor = $_POST['nomor'];
        $bpjs = new BpjsVklaim;
        $res = CJSON::decode($bpjs->search_nik($nomor));

        if (empty($res['response'])) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Data Kartu BPJS Pasien tidak Ditemukan',
            ));
            Yii::app()->end();
        }

        echo CJSON::encode(array(
            'ok'=>1,
            'peserta'=>$res['response']['peserta'],
        ));
    }
    
}
