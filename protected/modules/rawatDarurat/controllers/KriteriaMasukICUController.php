<?php
class KriteriaMasukICUController extends MyAuthController
{
    // public $layout='//layouts/column1';
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatDarurat.views.kriteriaMasukICU.';
    public $tersimpan = false;

    public function actionIndex($pendaftaran_id, $kriteriamasukicu_id = null)
    {
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modAdmisi = new PasienadmisiT();
        if(!empty($modPendaftaran->pasienadmisi_id) && Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RI){
          $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        }
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modDetail = array();

        if(!empty($kriteriamasukicu_id)){
          $model = KriteriamasukicuT::model()->findByPk($kriteriamasukicu_id);
          $modDetail = KriteriamasukicudetT::model()->findAllByAttributes(array('kriteriamasukicu_id'=>$model->kriteriamasukicu_id));
          if(!empty($model)){
            $model->tanggal_pemeriksaan = MyFormatter::formatDateTimeForUser($model->tanggal_pemeriksaan);
          }else{
            $model = new KriteriamasukicuT();
            $model->tanggal_pemeriksaan = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
          }
        }else{
          $model = new KriteriamasukicuT();
          $model->tanggal_pemeriksaan = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
        }

        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasienadmisi_id = $modAdmisi->pasienadmisi_id;


        if(isset($_POST['KriteriamasukicuT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['KriteriamasukicuT'];
                $model->tanggal_pemeriksaan = (!empty($_POST['KriteriamasukicuT']['tanggal_pemeriksaan'])? MyFormatter::formatDateTimeForDb($_POST['KriteriamasukicuT']['tanggal_pemeriksaan']) : null);
                $model->statuskriteria = (!empty($_POST['KriteriamasukicuT']['statuskriteria'])? $_POST['KriteriamasukicuT']['statuskriteria'] : null);
                $model->kardiovaskular_ismiokardinfark = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_ismiokardinfark']) ? 1 : 0);
                $model->kardiovaskular_iskardiogenik = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_iskardiogenik']) ? 1 : 0);
                $model->kardiovaskular_isaritmiakompleks = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_isaritmiakompleks']) ? 1 : 0);
                $model->kardiovaskular_ischfakut = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_ischfakut']) ? 1 : 0);
                $model->kardiovaskular_ishipertensi = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_ishipertensi']) ? 1 : 0);
                $model->kardiovaskular_isanginapektoris = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_isanginapektoris']) ? 1 : 0);
                $model->kardiovaskular_ispemulihan = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_ispemulihan']) ? 1 : 0);
                $model->kardiovaskular_istamponadejantung = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_istamponadejantung']) ? 1 : 0);
                $model->kardiovaskular_isdiseksi = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_isdiseksi']) ? 1 : 0);
                $model->kardiovaskular_isblokjantung = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_isblokjantung']) ? 1 : 0);
                $model->kardiovaskular_issindromcoroner = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_issindromcoroner']) ? 1 : 0);
                $model->kardiovaskular_isintraaorta = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_isintraaorta']) ? 1 : 0);
                $model->kardiovaskular_iskateter = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_iskateter']) ? 1 : 0);
                $model->kardiovaskular_isgagaljantung = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_isgagaljantung']) ? 1 : 0);
                $model->kardiovaskular_islajujantung = (!empty($_POST['KriteriamasukicuT']['kardiovaskular_islajujantung']) ? 1 : 0);
                $model->respirasi_isgagalpernafasan = (!empty($_POST['KriteriamasukicuT']['respirasi_isgagalpernafasan']) ? 1 : 0);
                $model->respirasi_isemboliparu = (!empty($_POST['KriteriamasukicuT']['respirasi_isemboliparu']) ? 1 : 0);
                $model->respirasi_isburukpernapasan = (!empty($_POST['KriteriamasukicuT']['respirasi_isburukpernapasan']) ? 1 : 0);
                $model->respirasi_ishemoptisis = (!empty($_POST['KriteriamasukicuT']['respirasi_ishemoptisis']) ? 1 : 0);
                $model->respirasi_isgagalnapas = (!empty($_POST['KriteriamasukicuT']['respirasi_isgagalnapas']) ? 1 : 0);
                $model->respirasi_isventilasi = (!empty($_POST['KriteriamasukicuT']['respirasi_isventilasi']) ? 1 : 0);
                $model->respirasi_isobstruksi = (!empty($_POST['KriteriamasukicuT']['respirasi_isobstruksi']) ? 1 : 0);
                $model->respirasi_islajupernapasan = (!empty($_POST['KriteriamasukicuT']['respirasi_islajupernapasan']) ? 1 : 0);
                $model->respirasi_isterapioksigen = (!empty($_POST['KriteriamasukicuT']['respirasi_isterapioksigen']) ? 1 : 0);
                $model->respirasi_isinstabilitas = (!empty($_POST['KriteriamasukicuT']['respirasi_isinstabilitas']) ? 1 : 0);
                $model->respirasi_isintubasi = (!empty($_POST['KriteriamasukicuT']['respirasi_isintubasi']) ? 1 : 0);
                $model->gastrointestinal_ispendarahan = (!empty($_POST['KriteriamasukicuT']['gastrointestinal_iskegagalanhati']) ? 1 : 0);
                $model->gastrointestinal_iskegagalanhati = (!empty($_POST['KriteriamasukicuT']['gastrointestinal_iskegagalanhati']) ? 1 : 0);
                $model->gastrointestinal_ispankreatitis = (!empty($_POST['KriteriamasukicuT']['gastrointestinal_ispankreatitis']) ? 1 : 0);
                $model->gastrointestinal_isperforasi = (!empty($_POST['KriteriamasukicuT']['gastrointestinal_isperforasi']) ? 1 : 0);
                $model->gastrointestinal_isobstruksi = (!empty($_POST['KriteriamasukicuT']['gastrointestinal_isobstruksi']) ? 1 : 0);
                $model->gastrointestinal_isabdomen = (!empty($_POST['KriteriamasukicuT']['gastrointestinal_isabdomen']) ? 1 : 0);
                $model->renal_isterapi = (!empty($_POST['KriteriamasukicuT']['renal_isterapi']) ? 1 : 0);
                $model->renal_isgagalginjal = (!empty($_POST['KriteriamasukicuT']['renal_isgagalginjal']) ? 1 : 0);
                $model->renal_isproduksiurine = (!empty($_POST['KriteriamasukicuT']['renal_isproduksiurine']) ? 1 : 0);
                $model->renal_isbersihankeratin = (!empty($_POST['KriteriamasukicuT']['renal_isbersihankeratin']) ? 1 : 0);
                $model->endokri_isketoasisdosis = (!empty($_POST['KriteriamasukicuT']['endokri_isketoasisdosis']) ? 1 : 0);
                $model->endokri_isthyroidstorm = (!empty($_POST['KriteriamasukicuT']['endokri_isthyroidstorm']) ? 1 : 0);
                $model->endokri_ishyperosmolar = (!empty($_POST['KriteriamasukicuT']['endokri_ishyperosmolar']) ? 1 : 0);
                $model->endokri_ispermasalahanendokrin = (!empty($_POST['KriteriamasukicuT']['endokri_ispermasalahanendokrin']) ? 1 : 0);
                $model->endokri_ishipofosfatemia = (!empty($_POST['KriteriamasukicuT']['endokri_ishipofosfatemia']) ? 1 : 0);
                $model->endokri_ishipermagnesemia = (!empty($_POST['KriteriamasukicuT']['endokri_ishipermagnesemia']) ? 1 : 0);
                $model->endokri_iskalsiumserum = (!empty($_POST['KriteriamasukicuT']['endokri_iskalsiumserum']) ? 1 : 0);
                $model->endokri_isnatriumserum = (!empty($_POST['KriteriamasukicuT']['endokri_isnatriumserum']) ? 1 : 0);
                $model->endokri_iskaliumserum = (!empty($_POST['KriteriamasukicuT']['endokri_iskaliumserum']) ? 1 : 0);
                $model->endokri_isglukosaserum = (!empty($_POST['KriteriamasukicuT']['endokri_isglukosaserum']) ? 1 : 0);
                $model->hematologi_ishemolisis = (!empty($_POST['KriteriamasukicuT']['hematologi_ishemolisis']) ? 1 : 0);
                $model->hematologi_istrombositopenia = (!empty($_POST['KriteriamasukicuT']['hematologi_istrombositopenia']) ? 1 : 0);
                $model->hematologi_iskoagulopati = (!empty($_POST['KriteriamasukicuT']['hematologi_iskoagulopati']) ? 1 : 0);
                $model->hematologi_isleukosit = (!empty($_POST['KriteriamasukicuT']['hematologi_isleukosit']) ? 1 : 0);
                $model->sarafpusat_isstrokeakut = (!empty($_POST['KriteriamasukicuT']['sarafpusat_isstrokeakut']) ? 1 : 0);
                $model->sarafpusat_iskoma = (!empty($_POST['KriteriamasukicuT']['sarafpusat_iskoma']) ? 1 : 0);
                $model->sarafpusat_ispendarahan = (!empty($_POST['KriteriamasukicuT']['sarafpusat_ispendarahan']) ? 1 : 0);
                $model->sarafpusat_isminingitis = (!empty($_POST['KriteriamasukicuT']['sarafpusat_isminingitis']) ? 1 : 0);
                $model->sarafpusat_isgangguansistem = (!empty($_POST['KriteriamasukicuT']['sarafpusat_isgangguansistem']) ? 1 : 0);
                $model->sarafpusat_isepileptikus = (!empty($_POST['KriteriamasukicuT']['sarafpusat_isepileptikus']) ? 1 : 0);
                $model->sarafpusat_iskematianotak = (!empty($_POST['KriteriamasukicuT']['sarafpusat_iskematianotak']) ? 1 : 0);
                $model->sarafpusat_isciderakepala = (!empty($_POST['KriteriamasukicuT']['sarafpusat_isciderakepala']) ? 1 : 0);
                $model->sarafpusat_iskejang = (!empty($_POST['KriteriamasukicuT']['sarafpusat_iskejang']) ? 1 : 0);
                $model->sarafpusat_iskelemahanotot = (!empty($_POST['KriteriamasukicuT']['sarafpusat_iskelemahanotot']) ? 1 : 0);
                $model->sarafpusat_isdelirium = (!empty($_POST['KriteriamasukicuT']['sarafpusat_isdelirium']) ? 1 : 0);
                $model->sarafpusat_ismedullaspinalis = (!empty($_POST['KriteriamasukicuT']['sarafpusat_ismedullaspinalis']) ? 1 : 0);
                $model->sarafpusat_iskraniotomi = (!empty($_POST['KriteriamasukicuT']['sarafpusat_iskraniotomi']) ? 1 : 0);
                $model->sarafpusat_ispemantauan = (!empty($_POST['KriteriamasukicuT']['sarafpusat_ispemantauan']) ? 1 : 0);
                $model->sarafpusat_istekananintakranial = (!empty($_POST['KriteriamasukicuT']['sarafpusat_istekananintakranial']) ? 1 : 0);
                $model->sarafpusat_isgcs = (!empty($_POST['KriteriamasukicuT']['sarafpusat_isgcs']) ? 1 : 0);
                $model->sepsis_isshock = (!empty($_POST['KriteriamasukicuT']['sepsis_isshock']) ? 1 : 0);
                $model->sepsis_isshockseptik = (!empty($_POST['KriteriamasukicuT']['sepsis_isshockseptik']) ? 1 : 0);
                $model->sepsis_istekanandarah = (!empty($_POST['KriteriamasukicuT']['sepsis_istekanandarah']) ? 1 : 0);
                $model->sepsis_isasidosislaktat = (!empty($_POST['KriteriamasukicuT']['sepsis_isasidosislaktat']) ? 1 : 0);
                $model->pembedahan_ismonitoring = (!empty($_POST['KriteriamasukicuT']['pembedahan_ismonitoring']) ? 1 : 0);
                $model->pembedahan_isperioperative = (!empty($_POST['KriteriamasukicuT']['pembedahan_isperioperative']) ? 1 : 0);
                $model->lukabakar_istrauma = (!empty($_POST['KriteriamasukicuT']['lukabakar_istrauma']) ? 1 : 0);
                $model->lukabakar_istanpatraumakurang = (!empty($_POST['KriteriamasukicuT']['lukabakar_istanpatraumakurang']) ? 1 : 0);
                $model->lukabakar_istanpatraumalebih = (!empty($_POST['KriteriamasukicuT']['lukabakar_istanpatraumalebih']) ? 1 : 0);
                $model->lukabakar_ispascatraumabesar = (!empty($_POST['KriteriamasukicuT']['lukabakar_ispascatraumabesar']) ? 1 : 0);
                $model->lukabakar_ispascatraumakecil = (!empty($_POST['KriteriamasukicuT']['lukabakar_ispascatraumakecil']) ? 1 : 0);
                
                $model->kondisilain_iscidera = (!empty($_POST['KriteriamasukicuT']['kondisilain_iscidera']) ? 1 : 0);
                $model->kondisilain_istrauma = (!empty($_POST['KriteriamasukicuT']['kondisilain_istrauma']) ? 1 : 0);
                $model->kondisilain_ispengobatan = (!empty($_POST['KriteriamasukicuT']['kondisilain_ispengobatan']) ? 1 : 0);
                $model->kondisilain_isgangguanreflek = (!empty($_POST['KriteriamasukicuT']['kondisilain_isgangguanreflek']) ? 1 : 0);
                $model->kondisilain_isobatinfus = (!empty($_POST['KriteriamasukicuT']['kondisilain_isobatinfus']) ? 1 : 0);
                $model->kondisilain_isdialisis = (!empty($_POST['KriteriamasukicuT']['kondisilain_isdialisis']) ? 1 : 0);
                $model->kondisilain_ismetabolik = (!empty($_POST['KriteriamasukicuT']['kondisilain_ismetabolik']) ? 1 : 0);
                $model->kondisilain_iskehamilan = (!empty($_POST['KriteriamasukicuT']['kondisilain_iskehamilan']) ? 1 : 0);
                $model->kondisilain_isgangguanmultiorgan = (!empty($_POST['KriteriamasukicuT']['kondisilain_isgangguanmultiorgan']) ? 1 : 0);
                $model->kondisilain_iseklampsia = (!empty($_POST['KriteriamasukicuT']['kondisilain_iseklampsia']) ? 1 : 0);
                $model->kondisilain_isemboli = (!empty($_POST['KriteriamasukicuT']['kondisilain_isemboli']) ? 1 : 0);
               

                
                if(!empty($model->kriteriamasukicu_id)){
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("loginpemakai_id");
                }else{
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("loginpemakai_id");
                }
                $model->create_ruangan = Yii::app()->user->getState("ruangan_id");


                if($model->save()){
                    $terseimpanDetail = true;
                    if(isset($_POST['KriteriamasukicudetT']) && count($_POST['KriteriamasukicudetT']) > 0){
                      $terseimpanDetail = $this->simpanDataDetail($_POST['KriteriamasukicudetT'], $model);
                    }

                    if($terseimpanDetail == true){
                        $this->tersimpan = true;
                    }else{
                      $this->tersimpan = false;
                    }
                }else{
                    $this->tersimpan = false;
                }

                 if($this->tersimpan == true){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
                    $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id,'type'=>(!empty($_GET['type'])?$_GET['type']:""),'frame'=>(!empty($_GET['frame'])?$_GET['frame']:""),'sukses'=>1));
                }else{
                    Yii::app()->user->setFlash('error',"Data gagal disimpan!");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
            }
        }

        $this->render($this->path_view.'index',array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'model'=>$model,
            'modDetail'=>$modDetail
        ));
    }

    public function simpanDataDetail($post, $model){
    $valid = true;

    $modDetail = KriteriamasukicudetT::model()->findAllByAttributes(array('kriteriamasukicu_id'=>$model->kriteriamasukicu_id));

    $oriSize = count($modDetail);
    $modSize = count($_POST['KriteriamasukicudetT']);
    $index = 0;

    if($modSize > 0){
        foreach($_POST['KriteriamasukicudetT'] as $detailI){
          if(isset($detailI['is_kriteria']) && !empty($detailI['is_kriteria'])){
            $index = 0;

            if($oriSize > 0){
              foreach($modDetail as $detailJ){
                if($detailI['kriteriaicu_id'] == $detailJ->kriteriaicu_id){
                  $index = 1;
                  $modUpdate = KriteriamasukicudetT::model()->findByPk($detailJ->kriteriamasukicudet_id);
                  $modUpdate->attributes = $detailI;
                  $modUpdate->update_time = date('Y-m-d H:i:s');
                  $modUpdate->update_loginpemakai = Yii::app()->user->getState("loginpemakai_id");

                  if($detailI['is_kriteria']==1){
                    $modUpdate->is_kriteria = true;
                  }else if($detailI['is_kriteria']==2){
                    $modUpdate->is_kriteria = 0;
                  }


                  if(!$modUpdate->save()){
                    $valid = false;
                  }
                  break;
                }
              }
            }

            if($index == 0){
              $modCreate = new KriteriamasukicudetT();
              $modCreate->attributes = $detailI;
              $modCreate->kriteriamasukicu_id = $model->kriteriamasukicu_id;
              $modCreate->jenis_kriteri = "Masuk ICU";
              $modCreate->create_time = date('Y-m-d H:i:s');
              $modCreate->create_loginpemakai = Yii::app()->user->getState("loginpemakai_id");
              $modCreate->create_ruangan = Yii::app()->user->getState("ruangan_id");
              if($detailI['is_kriteria']==1){
                $modCreate->is_kriteria = true;
              }else if($detailI['is_kriteria']==2){
                $modCreate->is_kriteria = 0;
              }

              if(!$modCreate->save()){
                $valid = false;
              }
            }
          }
        }
    }

    if($oriSize > 0){
      foreach($modDetail as $detailI){
        $index = 0;

        if($modSize > 0){
          foreach($_POST['KriteriamasukicudetT'] as $detailJ){
            if(isset($detailJ['is_kriteria']) && !empty($detailJ['is_kriteria'])){
              if($detailI->kriteriaicu_id == $detailJ['kriteriaicu_id']){
                $index = 1;
                $modUpdate = KriteriamasukicudetT::model()->findByPk($detailI->kriteriamasukicudet_id);
                $modUpdate->attributes = $detailJ;
                $modUpdate->update_time = date('Y-m-d H:i:s');
                $modUpdate->update_loginpemakai = Yii::app()->user->getState("loginpemakai_id");
                if($detailJ['is_kriteria']==1){
                  $modUpdate->is_kriteria = true;
                }else if($detailJ['is_kriteria']==2){
                  $modUpdate->is_kriteria = 0;
                }

                if(!$modUpdate->save()){
                  $valid = false;
                }
                break;
              }
            }
          }
        }

        if($index == 0){
          $modDelete = KriteriamasukicudetT::model()->deleteByPk($detailI->kriteriamasukicudet_id);

          if(!$modDelete->save()){
            $valid = false;
          }
        }
      }
    }
    return $valid;
  }

    public function actionAutocompletePetugasRuangan() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            $term = $_GET['term'];
            $tipe = $_GET['tipe'];

            $cr = new CDbCriteria();
            $cr->compare('lower(nama_pegawai)', strtolower($term), true);
            $cr->compare('ruangan_id', Yii::app()->user->getState("ruangan_id"));
            $cr->order = "nama_pegawai";

            $peg = PegawairuanganV::model()->findAll($cr);

            $returnVal = array();

            foreach ($peg as $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $i => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }


    public function actionPrint($kriteriamasukicu_id)
    {
      $model = KriteriamasukicuT::model()->findByPk($kriteriamasukicu_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modDetail = KriteriamasukicudetT::model()->findAllByAttributes(array('kriteriamasukicu_id'=>$model->kriteriamasukicu_id));

      $this->layout='//layouts/printWindows';
      $this->render($this->path_view.'print',array(
          'model'=>$model,
          'modPendaftaran'=>$modPendaftaran,
          'modPasien'=>$modPasien,
          'modDetail'=>$modDetail
      ));
    }

    public function actionHapusRiwayat(){
        if(Yii::app()->request->isPostRequest)
        {
            $id = $_POST['id'];
            $message = "";
            $sukses = 0;

            $model = KriteriamasukicuT::model()->findByAttributes(array('kriteriamasukicu_id'=>$id));

            if(!empty($model)){
              $deleteDetail = KriteriamasukicudetT::model()->deleteAllByAttributes(array('kriteriamasukicu_id'=>$id));
              $deleteData = $model->delete();

              if($deleteDetail && $deleteData){
                  $message = "Data Berhasil Dihapus!";
                  $sukses = 1;
              }else{
                  $message = "Data gagal Dihapus!";
                  $sukses = 0;
              }
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

    public function actionDetail()
    {
      $kriteriamasukicu_id = $_GET['kriteriamasukicu_id'];
      $model = KriteriamasukicuT::model()->findByPk($kriteriamasukicu_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modDetail = KriteriamasukicudetT::model()->findAllByAttributes(array('kriteriamasukicu_id'=>$model->kriteriamasukicu_id));

      $this->layout='//layouts/iframe';
      $this->render($this->path_view.'detailNew',array(
          'model'=>$model,
          'modPendaftaran'=>$modPendaftaran,
          'modPasien'=>$modPasien,
          'modDetail'=>$modDetail
      ));
    }

}
