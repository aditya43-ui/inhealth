<?php

/**
 *   - Untuk menampilkan informasi tab perizinan pada detail peralatan
 *   @author Andyka <andykaputra@.com>
 */
class InfoPerizinanTController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'manajemenAset.views.infoPerizinanT.';
    public $init = '';

    public function actionIndex($id) {
        $format = new MyFormatter();
        $model = new MAInvperizinanT();
        $modShow = InvperizinanT::model()->findAllByAttributes(array('invperalatan_id' => $id));
        $modLoad = InvperalatanT::model()->findByPk($id);

        $model->invperizinan_tgl = date('Y-m-d');
        $model->invperizinan_sdtgl = date('Y-m-d');

        if (isset($_POST['MAInvperizinanT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $model->attributes = $_POST['MAInvperizinanT'];
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $model->invperalatan_id = $id;
            $model->invperizinan_tgl = $format->formatDateTimeForDb($_POST['MAInvperizinanT']['invperizinan_tgl']);
            $model->invperizinan_sdtgl = $format->formatDateTimeForDb($_POST['MAInvperizinanT']['invperizinan_sdtgl']);
            $model->lampiranfile_1 = CUploadedFile::getInstance($model, 'lampiranfile_1');
            $model->lampiranfile_2 = CUploadedFile::getInstance($model, 'lampiranfile_2');
            $model->lampiranfile_3 = CUploadedFile::getInstance($model, 'lampiranfile_3');
            $model->lokasi_id = $modLoad->lokasi_id;

            if ($model->validate()) {
                try {
                    $lampiran_1 = $model->lampiranfile_1;
                    $lampiran_2 = $model->lampiranfile_2;
                    $lampiran_3 = $model->lampiranfile_3;
                    if (!empty($model->lampiranfile_1 || $model->lampiranfile_2 || $model->lampiranfile_3)) {
                        $fullImgName1 = str_replace(' ', '_', strtolower(date('dmY_s') . $lampiran_1));
                        $fullImgSource1 = ParamsUrl::pathInvperizinanDirectory() . $fullImgName1;
                        $fullImgName2 = str_replace(' ', '_', strtolower(date('dmY_s') . $lampiran_2));
                        $fullImgSource2 = ParamsUrl::pathInvperizinanDirectory() . $fullImgName2;
                        $fullImgName3 = str_replace(' ', '_', strtolower(date('dmY_s') . $lampiran_3));
                        $fullImgSource3 = ParamsUrl::pathInvperizinanDirectory() . $fullImgName3;
                        if ($model->lampiranfile_1 == null) {
                            $model->lampiranfile_1 = '';
                            $model->lampiranfile_2 = '';
                            $model->lampiranfile_3 = '';
                        } elseif ($model->lampiranfile_1 != null && $model->lampiranfile_2 == null && $model->lampiranfile_3 == null) {
                            $model->lampiranfile_1 = str_replace(' ', '_', strtolower(date('dmY_s') . $lampiran_1));
                            $model->lampiranfile_2 = '';
                            $model->lampiranfile_3 = '';
                        } elseif ($model->lampiranfile_1 != null && $model->lampiranfile_2 != null && $model->lampiranfile_3 == null) {
                            $model->lampiranfile_1 = str_replace(' ', '_', strtolower(date('dmY_s') . $lampiran_1));
                            $model->lampiranfile_2 = str_replace(' ', '_', strtolower(date('dmY_s') . $lampiran_2));
                            $model->lampiranfile_3 = '';
                        } elseif ($model->lampiranfile_1 != null && $model->lampiranfile_2 != null && $model->lampiranfile_3 != null) {
                            $model->lampiranfile_1 = str_replace(' ', '_', strtolower(date('dmY_s') . $lampiran_1));
                            $model->lampiranfile_2 = str_replace(' ', '_', strtolower(date('dmY_s') . $lampiran_2));
                            $model->lampiranfile_3 = str_replace(' ', '_', strtolower(date('dmY_s') . $lampiran_3));
                        }

                        if ($model->save()) {
                            
                            if (!file_exists(ParamsUrl::pathInvperizinanDirectory())){
                                mkdir(ParamsUrl::pathInvperizinanDirectory(),0775,true);
                            }
                            
                            if ($model->lampiranfile_1 == null) {
                                
                            } elseif ($model->lampiranfile_1 != null && $model->lampiranfile_2 == null && $model->lampiranfile_3 == null) {
                                $lampiran_1->saveAs($fullImgSource1);
                            } elseif ($model->lampiranfile_1 != null && $model->lampiranfile_2 != null && $model->lampiranfile_3 == null) {
                                $lampiran_1->saveAs($fullImgSource1);
                                $lampiran_2->saveAs($fullImgSource2);
                            } elseif ($model->lampiranfile_1 != null && $model->lampiranfile_2 != null && $model->lampiranfile_3 != null) {
                                $lampiran_1->saveAs($fullImgSource1);
                                $lampiran_2->saveAs($fullImgSource2);
                                $lampiran_3->saveAs($fullImgSource3);
                            }
                        }
                    } else {
                        $model->save();
                    }
                    
                    $up = InvperizinanT::model()->updateAll([
                        'is_aktif' => false
                    ]," is_aktif = TRUE AND invperalatan_id = ".$model->invperalatan_id." AND invperizinan_id != ".$model->invperizinan_id." ");
                    
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('index', 'id' => $id));
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($e, true));
                }
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modShow' => $modShow,
            'format' => $format,
        ));
    }

    public function actionUnduh($id) {

        $filename = MAInvperizinanT::model()->findByPk($id);

        $path = ParamsUrl::pathInvperizinanDirectory() . $filename->lampiranfile_1;

        if (!empty($filename->lampiranfile_1)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->lampiranfile_1, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(ParamsUrl::pathInvperizinanDirectory() . 'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(ParamsUrl::pathInvperizinanDirectory() . 'file_tidak_ditemukan.txt'));
        }
    }

    public function actionUnduh2($id) {

        $filename = MAInvperizinanT::model()->findByPk($id);

        $path = ParamsUrl::pathInvperizinanDirectory() . $filename->lampiranfile_2;

        if (!empty($filename->lampiranfile_2)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->lampiranfile_2, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(ParamsUrl::pathInvperizinanDirectory() . 'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(ParamsUrl::pathInvperizinanDirectory() . 'file_tidak_ditemukan.txt'));
        }
    }

    public function actionUnduh3($id) {

        $filename = MAInvperizinanT::model()->findByPk($id);

        $path = ParamsUrl::pathInvperizinanDirectory() . $filename->lampiranfile_3;

        if (!empty($filename->lampiranfile_3)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->lampiranfile_3, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(ParamsUrl::pathInvperizinanDirectory() . 'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(ParamsUrl::pathInvperizinanDirectory() . 'file_tidak_ditemukan.txt'));
        }
    }

    public function actionDelete() {
        if (Yii::app()->request->isAjaxRequest) {

            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $id = $_POST['id'];
                $model = MAInvperizinanT::model()->findByPk($id);

                $inv_id = $model->invperalatan_id;

                $ok &= $model->delete();

                $cri = new CDbCriteria();
                $cri->addCondition(" invperalatan_id = '".$inv_id."' AND invperizinan_id != ".$id." ");
                $cri->order = " invperizinan_id DESC ";
                $load = MAInvperizinanT::model()->find($cri);
                if (!empty($load)){
                    $load->is_aktif = true;                    
                    $load->update_time = date('Y-m-d H:i:s');
                    $load->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $load->save();
                }

                if (!$ok) {
                    $trans->rollback();
                    $data['status'] = 'gagal';
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal dihapus.');
                } else {
                    $trans->commit();
                    $data['status'] = 'sukses';
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus.');
                }
            }catch(Exeption $e){
                $trans->rollback();
                $data['status'] = 'gagal';
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal dihapus.');
            }


            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionAutoCompletePegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nama_pegawai = isset($_GET['$nama_pegawai']) ? $_GET['$nama_pegawai'] : null;

            if (empty($nama_pegawai)) {

                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
                $criteria->order = 'nama_pegawai';
                $criteria->limit = 5;
                $models = PegawaiM::model()->findAll($criteria);
                foreach ($models as $i => $model) {
                    $attributes = $model->attributeNames();
                    foreach ($attributes as $j => $attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->$nama_pegawai;
                    $returnVal[$i]['value'] = $model->$nama_pegawai;
                }
            } else {

                $criteria = new CDbCriteria();
//                        $criteria->compare('LOWER(pegawai_m.pegawai_id)', strtolower($nama_pegawai), true);
//                        $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
                $criteria->order = 'pegawai_m.pegawai_id, t.nama_pegawai';
                $criteria->limit = 50;
                $models = PegawaiM::model()->findAll($criteria);
                foreach ($models as $i => $model) {
                    $attributes = $model->attributeNames();
                    foreach ($attributes as $j => $attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->pegawai->pegawai_id .
                            ' - ' . $model->$nama_pegawai;
                    $returnVal[$i]['value'] = $model->$nama_pegawai;
                }
            }

            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

}
