<?php

class DosisRadiasiController extends MyAuthController {

    public function actionIndex($id) {

        $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $id));
        $periksa = HasilpemeriksaanradT::model()->findAllByAttributes(array(
            'pasienmasukpenunjang_id'=>$id,
        ));

        if (empty($penunjang)) {
            throw new CHttpException(404, "Pasien tidak ditemukan");
        }

        $model = DosisradiasiT::model()->findByAttributes(array(
            'pasienmasukpenunjang_id'=>$id,
        ));

        if (empty($model)) {
            $model = new DosisradiasiT;
            $model->pasienmasukpenunjang_id = $id;
        } else {
            $model->petugas_nama = $model->petugas->namaLengkap ?? null;
        }

        $model->tanggal_pencatatatan = date('Y-m-d H:i:s');
        $model->tanggal_pencatatatan = MyFormatter::formatDateTimeForUser($model->tanggal_pencatatatan);


        if (isset($_POST['DosisradiasiT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            try {
                $model->attributes = $_POST['DosisradiasiT'];
                $model->tanggal_pencatatatan = empty($model->tanggal_pencatatatan) ? date('Y-m-d H:i:s') : MyFormatter::formatDateTimeForDB($model->tanggal_pencatatatan);

                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                // $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;

                if ($model->validate()) {
                    $ok = $ok && $model->save();
                }

                if (isset($_POST['DosisradiasidetT'])) {
                    foreach ($_POST['DosisradiasidetT'] as $id => $item) {

                        $det = DosisradiasidetT::model()->findByAttributes(array(
                            'dosisradiasi_id'=>$model->dosisradiasi_id,
                            'pemeriksaanrad_id'=>$id,
                        ));
                        if (empty($det)) {
                            $det = new DosisradiasidetT();

                        }
                        

                        $det->attributes = $model->attributes;
                        $det->pemeriksaanrad_id = $id;
                        $det->attributes = $item;

                        $ok = $ok && $det->save();

                        // var_dump($det->attributes);
                    }
                }

                // var_dump($ok, $model->attributes, $_POST); die;

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
                    $this->redirect(array('index', 'id' => $model->pasienmasukpenunjang_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('success', "Data gagal disimpan !");
                }
            } catch (CException $e) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan. ' . $e->getMessage());
            }

            
        }


        $this->render('index', array(
            'penunjang'=>$penunjang,
            'periksa'=>$periksa,
            'model'=>$model,
        ));

    }

}