
<?php

class CatatanPerawatController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = "rawatJalan.views.catatanPerawat.";

    public function actionIndex($pendaftaran_id) {
        $this->layout = '//layouts/iframe';
        
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $model = new CatatanperawatT;
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $model->tglobservasi = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

        $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=> $model->pendaftaran_id, 'ruangan_id'=>Yii::app()->user->getState('ruangan_id')));

        if(!empty($pasienMorbid)){
            $mordStr = "";
            foreach($pasienMorbid as $i => $mord){
                if($i > 0){
                    $mordStr .= ", "; 
                }
                $mordStr .= (!empty($mord->diagnosa)?$mord->diagnosa->diagnosa_nama:"");
            }
            $model->diagnosa_nama = $mordStr;
        }
        

        if (isset($_POST['CatatanperawatT'])) {
            $trans = Yii::app()->db->beginTransaction();

            try {
                $model->attributes = $_POST['CatatanperawatT'];
                $model->tglobservasi = MyFormatter::formatDateTimeForDB($model->tglobservasi);

                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->save()) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id, 'sukses'=>1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model, 'modPendaftaran' => $modPendaftaran
        ));
    }

    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionDetail($catatanperawat_id) {

        $this->layout = '//layouts/iframe';

        $model = CatatanperawatT::model()->findByPk($catatanperawat_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modCatatan = CatatanperawatT::model()->findAllByAttributes(array('pendaftaran_id'=> $modPendaftaran->pendaftaran_id, 'pasienadmisi_id'=> $modPendaftaran->pasienadmisi_id,'create_ruangan'=>$model->create_ruangan));

        $this->render($this->path_view . '_detail', array(
            'model' => $model,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modCatatan' => $modCatatan
        ));
    }

    public function actionAutocompletePetugasRuangan($term) {
        $cr = new CDbCriteria;
        $cr->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $cr->compare('lower(nama_pegawai)', strtolower($term), true);
        $cr->addCondition('pegawai_aktif = true');

        $model = PegawairuanganV::model()->findAll($cr);
        $res = array();

        foreach ($model as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->pegawai_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

}
