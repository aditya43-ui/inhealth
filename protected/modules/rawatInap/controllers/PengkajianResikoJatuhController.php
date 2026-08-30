
<?php

class PengkajianResikoJatuhController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatInap.views.pengkajianResikoJatuh.';
    public $path_view_anak = 'rawatInap.views.pengkajianResikoJatuh.Anak.';
    public $path_view_dewasa = 'rawatInap.views.pengkajianResikoJatuh.Dewasa.';
    public $tersimpan = false;
    

    public function actionIndex($pendaftaran_id, $pasienadmisi_id = null)
    {
        $modPendaftaran= RIPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);

        if(!empty($intervensicegahjatuhpasien_id)){
            $model = RIIntervensicegahjatuhpasienT::model()->findByPk($intervensicegahjatuhpasien_id);
            $modDetail = RIIntervensicegahjatuhpasiendetT::model()->findAllByAttributes(array('intervensicegahjatuhpasien_id'=>$intervensicegahjatuhpasien_id));

            if(!empty($model->kelompok_pasien)){
              if($model->kelompok_pasien == 'dewasa'){
                $model->is_jenicegah = 1;
                $model->resikojatuh_tingkat_dewasa = $model->resikojatuh_tingkat;
                $model->resikojatuh_tingkat = "";
              }else if($model->kelompok_pasien == 'anak'){
                  $model->is_jenicegah = 2;
                  $model->resikojatuh_tingkat_dewasa = "";
              }

            }
        }else{
            $model = new PengkajianresikojatuhT();
            // $modDetail = new RIIntervensicegahjatuhpasiendetT();

        }

        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;

        if(isset($_POST['RIIntervensicegahjatuhpasienT'])) {
            $transaction = Yii::app()->db->beginTransaction();

            try {
                $model->attributes = $_POST['RIIntervensicegahjatuhpasienT'];
                $model->tgl_intervensi = MyFormatter::formatDateTimeForDb($_POST['RIIntervensicegahjatuhpasienT']['tgl_intervensi']);
                if($model->kelompok_pasien == 'dewasa'){
                  $model->resikojatuh_tingkat = $_POST['RIIntervensicegahjatuhpasienT']['resikojatuh_tingkat_dewasa'];
                }

                if(!empty($model->intervensicegahjatuhpasien_id)){
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }else{
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }
                $model->ruangan_id = Yii::app()->user->getState("ruangan_id");
                $model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                $model->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");


                $tersimpandetail = true;

                if($model->save()){
                    $this->tersimpan = true;

                    if(isset($_POST['RIIntervensicegahjatuhpasiendetT'])){
                        RIIntervensicegahjatuhpasiendetT::model()->deleteAllByAttributes(array('intervensicegahjatuhpasien_id'=>$model->intervensicegahjatuhpasien_id));

                        foreach ($_POST['RIIntervensicegahjatuhpasiendetT'] as $dataDet){
                            if(isset($dataDet['intervensicegahjatuh_nama_r']) && !empty($dataDet['intervensicegahjatuh_nama_r'])){
                                $modelDet = new RIIntervensicegahjatuhpasiendetT();
                                $modelDet->intervensicegahjatuhpasien_id = $model->intervensicegahjatuhpasien_id;
                                $modelDet->intervensicegahjatuh_nama = $dataDet['intervensicegahjatuh_nama_r'];
                                $modelDet->intervensicegahjatuh_tingkat = $dataDet['intervensicegahjatuh_tingkat_r'];
                                $modelDet->intervensicegahjatuh_urutan = $dataDet['intervensicegahjatuh_urutan_r'];
                                $modelDet->isdilakukan = $dataDet['isdilakukan_r'];
                                $modelDet->kelompok_pasien = $model->kelompok_pasien;
                                
                                
                                if(!$modelDet->save()){
                                     $tersimpandetail = false;
                                 }
                            }

                            if(isset($dataDet['intervensicegahjatuh_nama_s']) && !empty($dataDet['intervensicegahjatuh_nama_s'])){
                                $modelDet = new RIIntervensicegahjatuhpasiendetT();
                                $modelDet->intervensicegahjatuhpasien_id = $model->intervensicegahjatuhpasien_id;
                                $modelDet->intervensicegahjatuh_nama = $dataDet['intervensicegahjatuh_nama_s'];
                                $modelDet->intervensicegahjatuh_tingkat = $dataDet['intervensicegahjatuh_tingkat_s'];
                                $modelDet->intervensicegahjatuh_urutan = $dataDet['intervensicegahjatuh_urutan_s'];
                                $modelDet->isdilakukan = $dataDet['isdilakukan_s'];
                                $modelDet->kelompok_pasien = $model->kelompok_pasien;

                                if(!$modelDet->save()){
                                     $tersimpandetail = false;
                                 }
                            }

                            if(isset($dataDet['intervensicegahjatuh_nama_t']) && !empty($dataDet['intervensicegahjatuh_nama_t'])){
                                $modelDet = new RIIntervensicegahjatuhpasiendetT();
                                $modelDet->intervensicegahjatuhpasien_id = $model->intervensicegahjatuhpasien_id;
                                $modelDet->intervensicegahjatuh_nama = $dataDet['intervensicegahjatuh_nama_t'];
                                $modelDet->intervensicegahjatuh_tingkat = $dataDet['intervensicegahjatuh_tingkat_t'];
                                $modelDet->intervensicegahjatuh_urutan = $dataDet['intervensicegahjatuh_urutan_t'];
                                $modelDet->isdilakukan = $dataDet['isdilakukan_t'];
                                $modelDet->kelompok_pasien = $model->kelompok_pasien;

                                if(!$modelDet->save()){
                                     $tersimpandetail = false;
                                 }
                            }
                        }
                    }

                }else{
                   $this->tersimpan = false;
                }


                if($this->tersimpan == true && $tersimpandetail == true){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id,'sukses'=>1));
                }else{
                    Yii::app()->user->setFlash('error',"Data gagal disimpan!");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }

        $this->render($this->path_view.'index',
            array('modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'model'=>$model
        ));
    }

    public function actionIndexAnak($pendaftaran_id, $pasienadmisi_id = null)
    {
        $modPendaftaran= RIPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $pengkajianresikojatuh_id = (isset($_GET['pengkajianresikojatuh_id'])?$_GET['pengkajianresikojatuh_id']:null);
        
        
        $modHasil = new HasilpengkajianresikojatuhT();
        $modIntervensi = new IntervensicegahjatuhpasienT();
        $modDetail = new IntervensicegahjatuhpasiendetT();

        if (!empty($pengkajianresikojatuh_id)){
            $model = PengkajianresikojatuhT::model()->findByPK($pengkajianresikojatuh_id);
            $model->pengkajianresikojatuh_id = $pengkajianresikojatuh_id;
        }else{
            $model = new PengkajianresikojatuhT();
        }

        // if(isset ($_REQUEST)){
        //     echo print_r($_REQUEST).exit();
        // }


        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;


        $this->render($this->path_view.'Anak/index',
            array('modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'model'=>$model,
                'modHasil'=>$modHasil,
                'modIntervensi'=>$modIntervensi,
                'modDetail'=>$modDetail
        ));
    }

    public function actionIndexDewasa($pendaftaran_id, $pasienadmisi_id = null)
    {
        $modPendaftaran= RIPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $pengkajianresikojatuh_id = (isset($_GET['pengkajianresikojatuh_id'])?$_GET['pengkajianresikojatuh_id']:null);
        
        
        $modHasil = new HasilpengkajianresikojatuhT();
        $modIntervensi = new IntervensicegahjatuhpasienT();
        $modDetail = new IntervensicegahjatuhpasiendetT();

        if (!empty($pengkajianresikojatuh_id)){
            $model = PengkajianresikojatuhT::model()->findByPK($pengkajianresikojatuh_id);
            $model->pengkajianresikojatuh_id = $pengkajianresikojatuh_id;
            $modIntervensi = IntervensicegahjatuhpasienT::model()->findByAttributes(array('pengkajianresikojatuh_id'=>$pengkajianresikojatuh_id));
            if(!empty($modIntervensi)){
                $modDetail = IntervensicegahjatuhpasiendetT::model()->findAllByAttributes(array('intervensicegahjatuhpasien_id'=>$modIntervensi->intervensicegahjatuhpasien_id));
                if(empty($modDetail)){
                    $modDetail = new IntervensicegahjatuhpasiendetT();
                }
                $modIntervensi->evaluasi_pencegahanjatuh = (($modIntervensi->evaluasi_pencegahanjatuh != null) ? (($modIntervensi->evaluasi_pencegahanjatuh ==1)?"ya":"tidak") : null);
            }
        }else{
            $model = new PengkajianresikojatuhT();
        }


        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;


        $this->render($this->path_view.'Dewasa/index',
            array('modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'model'=>$model,
                'modHasil'=>$modHasil,
                'modIntervensi'=>$modIntervensi,
                'modDetail'=>$modDetail
        ));
    }

    public function actionSimpanOrLoad(){
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $sukses = 0;
            $pesan = "Data Error Disimpan!!";
            
            if (isset($_POST['PengkajianresikojatuhT'])) {
                
                
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $pengkajian = false;
                    
                    if (!empty($_POST['PengkajianresikojatuhT']['pengkajianresikojatuh_id'])){
                        $model = PengkajianresikojatuhT::model()->findByPk($_POST['PengkajianresikojatuhT']['pengkajianresikojatuh_id']);

                    }else{
                        $model = new PengkajianresikojatuhT;
                    }
                    
                    $model->skalajatuh_jenis = $_POST['PengkajianresikojatuhT']['skalajatuh_jenis'];
                    $model->totalskor = $_POST['PengkajianresikojatuhT']['totalskor'];
                    $model->keteranganskor_resikojatuh = $_POST['PengkajianresikojatuhT']['keteranganskor_resikojatuh'];
                    $model->pendaftaran_id = $_POST['PengkajianresikojatuhT']['pendaftaran_id'];
                    $model->tanggal_pengkajian = MyFormatter::formatDateTimeFoRDb($_POST['PengkajianresikojatuhT']['tanggal_pengkajian']);
                    $model->jam_pengkajian = $_POST['PengkajianresikojatuhT']['jam_pengkajian'];
                    $model->pegawaipengkaji_id = $_POST['PengkajianresikojatuhT']['pegawaipengkaji_id'];
                    $model->waktupengkajian_resikojatuh = $_POST['PengkajianresikojatuhT']['waktupengkajian_resikojatuh'];

                    if(!empty($model->intervensicegahjatuhpasien_id)){
                        $model->update_time = date('Y-m-d H:i:s');
                        $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                    }else{
                        $model->create_time = date('Y-m-d H:i:s');
                        $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                        $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                    }
                    $model->ruangan_id = Yii::app()->user->getState("ruangan_id");
                    $model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                    $model->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");


                    if($model->save()){
                        $pengkajian = true;

                        if (isset($_POST['HasilpengkajianresikojatuhT'])) {
                            $hasi_pengkajian = false;
                            foreach ($_POST['HasilpengkajianresikojatuhT'] as $hasil){
                                $modHasil = new HasilpengkajianresikojatuhT;
                                $modHasil->skor = $hasil['skor'];
                                $modHasil->parameter = $hasil['parameter'];
                                $modHasil->penilaian = $hasil['penilaian'];
                                $modHasil->skor = $hasil['skor'];
                                $modHasil->pengkajianresikojatuh_id = $model->pengkajianresikojatuh_id;
                                $modHasil->create_time = date('Y-m-d H:i:s');
                                $modHasil->update_time = date('Y-m-d H:i:s');
                                $modHasil->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                $modHasil->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                $modHasil->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                                $modHasil->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");
                                
                                if($modHasil->save()){
                                    $hasi_pengkajian = true;
                                }
                            }
                            
                        }
                        $intervensi = true;
                        $tersimpandetail = true;
                        if($_POST['checksimpan']=='simpan'){
                            
                            
                            if (isset($_POST['IntervensicegahjatuhpasienT'])) {
                                
                                $modIntervensi = new IntervensicegahjatuhpasienT;
                                $modIntervensi->pendaftaran_id = $_POST['PengkajianresikojatuhT']['pendaftaran_id'];
                                $modPasien = PendaftaranT::model()->findByPk($modIntervensi->pendaftaran_id);
                                $modIntervensi->pasien_id = $modPasien->pasien_id;
                                $modIntervensi->tgl_intervensi = MyFormatter::formatdateTimeforDB($_POST['IntervensicegahjatuhpasienT']['tgl_intervensi']);
                                $modIntervensi->pengkajianresikojatuh_id = $model->pengkajianresikojatuh_id;
                                $modIntervensi->resikojatuh_tingkat = $_POST['IntervensicegahjatuhpasienT']['resikojatuh_tingkat'];
                                $modIntervensi->evaluasi_pencegahanjatuh = $_POST['IntervensicegahjatuhpasienT']['evaluasi_pencegahanjatuh'];
                                $modIntervensi->jam_intervensi = $_POST['IntervensicegahjatuhpasienT']['jam_intervensi'];
                                $modIntervensi->petugas_id = $_POST['IntervensicegahjatuhpasienT']['petugas_id'];
                                $modIntervensi->kelompok_pasien = $_POST['IntervensicegahjatuhpasienT']['kelompok_pasien'];
                                
                                if(!empty($modIntervensi->intervensicegahjatuhpasien_id)){
                                    $modIntervensi->update_time = date('Y-m-d H:i:s');
                                    $modIntervensi->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                }else{
                                    $modIntervensi->create_time = date('Y-m-d H:i:s');
                                    $modIntervensi->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                }
                                $modIntervensi->ruangan_id = Yii::app()->user->getState("ruangan_id");
                                $modIntervensi->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                                $modIntervensi->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");
                                
                                
                                if($modIntervensi->save()){
                                    $intervensi = true;

                                    if(isset($_POST['IntervensicegahjatuhpasiendetT'])){
                                        IntervensicegahjatuhpasiendetT::model()->deleteAllByAttributes(array('intervensicegahjatuhpasien_id'=>$modIntervensi->intervensicegahjatuhpasien_id));
                
                                        foreach ($_POST['IntervensicegahjatuhpasiendetT'] as $dataDet){
                                            if(isset($dataDet['intervensicegahjatuh_nama_r']) && !empty($dataDet['intervensicegahjatuh_nama_r'])){
                                                $modelDet = new IntervensicegahjatuhpasiendetT();
                                                $modelDet->intervensicegahjatuhpasien_id = $modIntervensi->intervensicegahjatuhpasien_id;
                                                $modelDet->intervensicegahjatuh_nama = $dataDet['intervensicegahjatuh_nama_r'];
                                                $modelDet->intervensicegahjatuh_tingkat = $dataDet['intervensicegahjatuh_tingkat_r'];
                                                $modelDet->intervensicegahjatuh_urutan = $dataDet['intervensicegahjatuh_urutan_r'];
                                                $modelDet->isdilakukan = $dataDet['isdilakukan_r'];
                                                $modelDet->kelompok_pasien = 'anak';
                                                
                                                
                                                if(!$modelDet->save()){
                                                    $tersimpandetail = false;
                                                }
                                            }
                
                                            if(isset($dataDet['intervensicegahjatuh_nama_s']) && !empty($dataDet['intervensicegahjatuh_nama_s'])){
                                                $modelDet = new IntervensicegahjatuhpasiendetT();
                                                $modelDet->intervensicegahjatuhpasien_id = $modIntervensi->intervensicegahjatuhpasien_id;
                                                $modelDet->intervensicegahjatuh_nama = $dataDet['intervensicegahjatuh_nama_s'];
                                                $modelDet->intervensicegahjatuh_tingkat = $dataDet['intervensicegahjatuh_tingkat_s'];
                                                $modelDet->intervensicegahjatuh_urutan = $dataDet['intervensicegahjatuh_urutan_s'];
                                                $modelDet->isdilakukan = $dataDet['isdilakukan_s'];
                                                $modelDet->kelompok_pasien = 'anak';
                
                                                if(!$modelDet->save()){
                                                    $tersimpandetail = false;
                                                }
                                            }
                
                                            if(isset($dataDet['intervensicegahjatuh_nama_t']) && !empty($dataDet['intervensicegahjatuh_nama_t'])){
                                                $modelDet = new IntervensicegahjatuhpasiendetT();
                                                $modelDet->intervensicegahjatuhpasien_id = $modIntervensi->intervensicegahjatuhpasien_id;
                                                $modelDet->intervensicegahjatuh_nama = $dataDet['intervensicegahjatuh_nama_t'];
                                                $modelDet->intervensicegahjatuh_tingkat = $dataDet['intervensicegahjatuh_tingkat_t'];
                                                $modelDet->intervensicegahjatuh_urutan = $dataDet['intervensicegahjatuh_urutan_t'];
                                                $modelDet->isdilakukan = $dataDet['isdilakukan_t'];
                                                $modelDet->kelompok_pasien = 'anak';
                
                                                if(!$modelDet->save()){
                                                    $tersimpandetail = false;
                                                }
                                            }
                                        }
                                    }
                                    
                                }else{
                                    $intervensi = false;
                                }
                            }
                                
                        }

                        if ($pengkajian == true && $hasi_pengkajian ==  true && $intervensi ==  true && $tersimpandetail == true){
                            $transaction->commit();
                            $sukses = 1;
                            $pesan = "Data Berhasil disimpan!!";
                        }else{
                            $transaction->rollback();
                            $sukses = 0;
                            $pesan = "Data gagal!! ";

                        }

                        
                    }
                    
                    
    
                } catch (Exception $ex) {
                    
                    $transaction->rollback();
                    $sukses = 0;
                    $pesan = "Data gagal Disimpan!! ".MyExceptionMessage::getMessage($ex,true);
                }
          }
          $data['sukses'] = $sukses;
          $data['pesan'] = $pesan;
          $data['pengkajianresikojatuh_id'] = $model->pengkajianresikojatuh_id;
          $data['resiko'] = $model->keteranganskor_resikojatuh;
          echo json_encode($data);
          Yii::app()->end();
        }
      }

    
    public function getUrlPasienAnak(){
        return $this->module->id.'/PengkajianResikoJatuh/indexAnak';
    }

    public function getUrlPasienDewasa(){
        return $this->module->id.'/PengkajianResikoJatuh/indexDewasa';
    }

    public function actionDetail($pengkajianresikojatuh_id) {
        $this->layout = '//layouts/iframe';

        $model = PengkajianresikojatuhT::model()->findByPk($pengkajianresikojatuh_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modHasil = HasilpengkajianresikojatuhT::model()->findAllByAttributes(array('pengkajianresikojatuh_id'=>$model->pengkajianresikojatuh_id));;
        $modIntervensi = IntervensicegahjatuhpasienT::model()->findByAttributes(array('pengkajianresikojatuh_id'=>$model->pengkajianresikojatuh_id));
        $modDetail = IntervensicegahjatuhpasiendetT::model()->findAllByAttributes(array('intervensicegahjatuhpasien_id'=>$modIntervensi->intervensicegahjatuhpasien_id));
        $this->render($this->path_view_anak.'_detailRiwayat',
        array(
            'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modHasil'=>$modHasil,
            'modIntervensi'=>$modIntervensi,
            'modDetail'=>$modDetail
        ));
    }

    public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
        {
            $id = $_POST['id'];
            
            HasilpengkajianresikojatuhT::model()->deleteAllByAttributes(array(
                'pengkajianresikojatuh_id'=>$id,
            ));
            
            
            
            $deleteData = PengkajianresikojatuhT::model()->deleteByPk($id);

            $message = "";
            $sukses = 0;

            if($deleteData){
                $message = "Data Berhasil Dihapus!";
                $sukses = 1;
            }else{
                $message = "Data gagal Dihapus!";
                $sukses = 0;
            }

            echo CJSON::encode(array(
                    'sukses'=> $sukses,
                    'msg'=>$message,
                    ));
            exit;
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

    public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
        $instalasi_id = null;
        if ($model_nama !== '' && $attr == '') {
            $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
        } else if ($model_nama == '' && $attr !== '') {
            $instalasi_id = $_POST["$attr"];
        } else if ($model_nama !== '' && $attr !== '') {
            $instalasi_id = $_POST["$model_nama"]["$attr"];
        }
        $models = null;
        $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

        if ($encode) {
            echo CJSON::encode($models);
        } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            if (count((array)$models) > 0) {
            foreach ($models as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
            }
        }
        }
        Yii::app()->end();
    }

    public function actionDetailResikoJatuh($pengkajianresikojatuh_id, $type) {
        $this->layout = '//layouts/iframe';

        $model = PengkajianresikojatuhT::model()->findByPk($pengkajianresikojatuh_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modHasil = HasilpengkajianresikojatuhT::model()->findAllByAttributes(array('pengkajianresikojatuh_id'=>$model->pengkajianresikojatuh_id));;
        $modIntervensi = IntervensicegahjatuhpasienT::model()->findByAttributes(array('pengkajianresikojatuh_id'=>$model->pengkajianresikojatuh_id));
        $modDetail = IntervensicegahjatuhpasiendetT::model()->findAllByAttributes(array('intervensicegahjatuhpasien_id'=>$modIntervensi->intervensicegahjatuhpasien_id));
        $this->render($this->path_view_dewasa.'_detailRiwayat',
        array(
            'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modHasil'=>$modHasil,
            'modIntervensi'=>$modIntervensi,
            'modDetail'=>$modDetail
        ));
    }

    public function actionHapusRiwayat()
	{
		if(Yii::app()->request->isPostRequest)
        {
            $id = $_POST['id'];
            
            HasilpengkajianresikojatuhT::model()->deleteAllByAttributes(array(
                'pengkajianresikojatuh_id'=>$id,
            ));
            $modIntervensi = IntervensicegahjatuhpasienT::model()->findByAttributes(array('pengkajianresikojatuh_id'=>$id));

            if(!empty($modIntervensi)){
                IntervensicegahjatuhpasiendetT::model()->deleteAllByAttributes(array(
                    'intervensicegahjatuhpasien_id'=>$modIntervensi->intervensicegahjatuhpasien_id,
                ));
                $modIntervensi->delete();
            }
            
            $deleteData = PengkajianresikojatuhT::model()->deleteByPk($id);

            $message = "";
            $sukses = 0;

            if($deleteData){
                $message = "Data Berhasil Dihapus!";
                $sukses = 1;
            }else{
                $message = "Data gagal Dihapus!";
                $sukses = 0;
            }

            echo CJSON::encode(array(
                    'sukses'=> $sukses,
                    'msg'=>$message,
                    ));
            exit;
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
}
