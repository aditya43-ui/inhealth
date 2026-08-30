
<?php

class InvasetlainTController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $penjurnalan = false;
    public $penjurnalanDetail = true;

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id = null) {
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        $model = new MAInvasetlainT;
        $model->invasetlain_tglguna = date('d M Y');
        $modBarang = new MABarangM;

        // Uncomment the following line if AJAX validation is needed

        if (!empty($id)) {
            $model = MAInvasetlainT::model()->findByPk($id);
            $modBarang = BarangM::model()->findByPk($model->barang_id);
        }


        if (isset($_POST['MAInvasetlainT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $ok = true;
                $model->attributes = $_POST['MAInvasetlainT'];
                $model->invasetlain_noregister = MyGenerator::Kodenoregister($_POST['MAInvasetlainT']['barang_id']);
                $model->create_time = date('Y-m-d H:i:s');
                $model->update_time = null;
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->invasetlain_tglguna = !empty($_POST['MAInvasetlainT']['invasetlain_tglguna']) ? $_POST['MAInvasetlainT']['invasetlain_tglguna'] : null;
                $model->terimapersdetail_id = !empty($_POST['MAInvasetlainT']['terimapersdetail_id']) ? $_POST['MAInvasetlainT']['terimapersdetail_id'] : null;


                if (isset($_POST['MAInvasetlainT']['detail'])) {
                    foreach ($_POST['MAInvasetlainT']['detail'] as $item) {
                        $modelDetail = new MAInvasetlainT();
                        $modelDetail->attributes = $model->attributes;
                        $modelDetail->attributes = $item;
                        $modelDetail->invasetlain_kode = MyGenerator::kodeAsetLain($modelDetail->barang_id);

                        if ($modelDetail->validate()) {
                            $ok = $ok && $modelDetail->save();
                            var_dump($modelDetail->getErrors());
                        } else {
                            $ok = false;
                        }
                    }
                }

                if ($ok) {
                    $transaction->commit();
                    BarangM::model()->updateByPk($model->barang_id, array('barang_statusregister' => true));
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $modBarang = BarangM::model()->findByPk($model->barang_id);
                    $this->redirect(array('create', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render('create', array(
            'model' => $model, 'modBarang' => $modBarang,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        $model = $this->loadModel($id);
        $modBarang = $this->loadModelBarang($model->barang_id);
        $data['pemilikbarang_nama'] = !empty($model->pemilikbarang_id) ? $model->pemilik->pemilikbarang_nama : '';
        $dataAsalAset['asalaset_nama'] = !empty($model->asalaset_id) ? $model->asal->asalaset_nama : '';
        $dataLokasi['lokasiaset_namalokasi'] = !empty($model->lokasi_id) ? $model->lokasi->lokasiaset_namalokasi : '';
        // Uncomment the following line if AJAX validation is needed


        if (isset($_POST['MAInvasetlainT'])) {
            $model->attributes = $_POST['MAInvasetlainT'];
            if ($model->save()) {
                BarangM::model()->updateByPk($model->barang_id, array('barang_statusregister' => true));
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                //$this->redirect(array('admin','id'=>$model->invasetlain_id));
                $this->redirect(array('update', 'id' => $id, 'sukses' => 1));
            }
        }

        $this->render('update', array(
            'model' => $model, 'modBarang' => $modBarang, 'data' => $data, 'dataAsalAset' => $dataAsalAset, 'dataLokasi' => $dataLokasi
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
            $model = $this->loadModel($id);
            BarangM::model()->updateByPk($model->barang_id, array('barang_statusregister' => false));
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('MAInvasetlainT');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {

        $model = new MAInvasetlainT('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MAInvasetlainT']))
            $model->attributes = $_GET['MAInvasetlainT'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = MAInvasetlainT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelBarang($id) {
        $model = BarangM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'guinvasetlain-t-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mengubah status aktif
     * @param type $id 
     */
    public function actionRemoveTemporary($id) {
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionPrint() {
        $model = new MAInvasetlainT;
        $model->attributes = $_REQUEST['MAInvasetlainT'];
        $judulLaporan = 'Data Inventarisasi Aset Tetap Lainnya';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    /* Digunakan di Modul Akuntansi
     * 
     */

    public function actionRekeningAkuntansi() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
//                $criteria->compare('LOWER(nmrincianobyek)', strtolower($_GET['term']), true);
            $term = strtolower(trim($_GET['term']));

            $condition = "LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%'";
            if (isset($_GET['id_jenis_rek'])) {
                $condition = "(LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekening5_nb = 'D' OR rekening4_nb = 'D' OR rekening3_nb = 'D')";
                if ($_GET['id_jenis_rek'] == 'Kredit') {
                    $condition = "(LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekening5_nb = 'K' OR rekening4_nb = 'K' OR rekening3_nb = 'K')";
                }
            }

            $criteria->addCondition($condition);
            $criteria->order = 'nmrekening5';
            $models = RekeningakuntansiV::model()->findAll($criteria);
            $returnVal = array();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                if (isset($model->rincianobyek_id)) {
                    $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4 . "-" . $model->kdrekening5;
                    $nama_rekening = $model->nmrekening5;
                } else {
                    if (isset($model->obyek_id)) {
                        $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4;
                        $nama_rekening = $model->nmrekening4;
                    } else {
                        $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3;
                        $nama_rekening = $model->nmrekening3;
                    }
                }
                $returnVal[$i]['label'] = $kode_rekening . '-' . $nama_rekening;
                $returnVal[$i]['value'] = $nama_rekening;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    // fungsi untuk penjurnalan di transaksi penyusutan aset
    public function actionAmbilDataRekening() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $rekening1_id = isset($_POST['rekening1_id']) ? $_POST['rekening1_id'] : null;
            $rekening2_id = isset($_POST['rekening2_id']) ? $_POST['rekening2_id'] : null;
            $rekening3_id = isset($_POST['rekening3_id']) ? $_POST['rekening3_id'] : null;
            $rekening4_id = isset($_POST['rekening4_id']) ? $_POST['rekening4_id'] : null;
            $rekening5_id = isset($_POST['rekening5_id']) ? $_POST['rekening5_id'] : null;
            $status = isset($_POST['status']) ? $_POST['status'] : null;

            $criteria = new CDbCriteria;
            if (!empty($rekening5_id)) {
                $criteria->addCondition("rekening5_id = " . $rekening5_id);
            }
            if (!empty($rekening4_id)) {
                $criteria->addCondition("rekening4_id = " . $rekening4_id);
            }
            if (!empty($rekening3_id)) {
                $criteria->addCondition("rekening3_id = " . $rekening3_id);
            }
            if (!empty($rekening2_id)) {
                $criteria->addCondition("rekening2_id = " . $rekening2_id);
            }
            if (!empty($rekening1_id)) {
                $criteria->addCondition("rekening1_id = " . $rekening1_id);
            }

            $model = MARekeningakuntansiV::model()->findAll($criteria);
            if ($model) {
                echo CJSON::encode(
                        $this->renderPartial('__formKodeRekening', array('model' => $model, 'status' => $status), true)
                );
            }
            Yii::app()->end();
        }
    }

    public function actionGetkodeRegister() {
        if (Yii::app()->request->isAjaxRequest) {
            $barang_id = isset($_POST['barang_id']) ? $_POST['barang_id'] : null;

            $returnVal = array();
            $kode_register = MyGenerator::Kodenoregister($barang_id);
            $returnVal['value'] = isset($kode_register) ? $kode_register : "";

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * @author Tantowy <tantowijaya@.com>
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     * 
     * [Penyesuaian dari InvperalatanTController untuk digunakan pada Inventarisi Aset Lain]
     * Proses untuk cek banyak jumlah inv peerimaan agar mendapatkan selihsih banyaknya yg belum inventarisasi
     */
    public function actionCekSelisihInv() {
        if (Yii::app()->request->isAjaxRequest) {

            $terimapersdetail_id = $_GET['terimapersdetail_id'];
            $barang_id = $_GET['barang_id'];
            $jml = $_GET['jml'];

            $modBarang = BarangM::model()->findByPk($_GET['barang_id']);
            $subsubkelompok = SubsubkelompokM::model()->findByPk($modBarang->subsubkelompok_id);

            $criteria = new CDbCriteria;
            $criteria->select = "count (*) AS invasetlain_jumlah";
            $criteria->addCondition("terimapersdetail_id = " . $terimapersdetail_id);
            $criteria->addCondition("barang_id = " . $barang_id);
            $modelDetail = InvasetlainT::model()->find($criteria);

            $default = '00001';
            $prefix = $subsubkelompok->subsubkelompok_kode;
            $criteriaNoUrut = new CDbCriteria;
            $criteriaNoUrut->select = "CAST(MAX(SUBSTR(invasetlain_kode," . (strlen($prefix) + 2) . "," . (strlen($default)) . ")) AS integer) kode_urut";
            $criteriaNoUrut->addCondition("invasetlain_kode ILIKE ('" . $subsubkelompok->subsubkelompok_kode . "%')");
            $modelNoUrut = InvasetlainT::model()->find($criteriaNoUrut);
            /* end */
            if ($modelDetail->invasetlain_jumlah == 0) {
                $jumlah_noUrut = ($modelNoUrut->kode_urut != 0) ? $modelNoUrut->kode_urut + 1 : 1;
                $awal = (str_pad($jumlah_noUrut, strlen($default), 0, STR_PAD_LEFT));
                $jumlah = $jml;
                $akhir = ($jumlah_noUrut == 1) ? (str_pad($jumlah, strlen($default), 0, STR_PAD_LEFT)) : (str_pad($modelNoUrut->kode_urut + $jml, strlen($default), 0, STR_PAD_LEFT));
            } else {
                $jumlah = ($jml - $modelDetail->invasetlain_jumlah);
                $jumlah_noUrut = ($modelNoUrut->kode_urut != 0) ? $modelNoUrut->kode_urut + 1 : 1;
                $awal = (str_pad($jumlah_noUrut, strlen($default), 0, STR_PAD_LEFT));
                $akhir = ($jumlah_noUrut == 1) ? (str_pad($jml, strlen($default), 0, STR_PAD_LEFT)) : (str_pad(($modelNoUrut->kode_urut + $jml), strlen($default), 0, STR_PAD_LEFT));
            }

            echo CJSON::encode(
                    array(
                        'jumlah' => $jumlah,
                        'awal' => $awal,
                        'akhir' => $akhir,
                    )
            );
        }
        Yii::app()->end();
    }

    /**
     * @author Tantowy <tantowijaya@.com>
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     * 
     * [Penyesuaian dari InvperalatanTController untuk digunakan pada Inventarisi Aset Lain]
     * Proses untuk load data barang berdasarkan jumlah penerimaan
     */
    public function actionLoadDetailInvAlat() {
        if (Yii::app()->request->isAjaxRequest) {

            $modelDetail = new MAInvasetlainT;
            $jumlah = $_GET['jumlah'];
            $barang_id = $_GET['barang_id'];
            $terimapersdetail_id = $_GET['terimapersdetail_id'];

            $barangM = BarangM::model()->findByPk($barang_id);
            $persediaanDet = TerimapersdetailT::model()->findByPk($terimapersdetail_id);

            $modelDetail->invasetlain_namabrg = $barangM->barang_nama;
            // $modelDetail->invsetlain_keadaan = $persediaanDet->kondisibarang;
            $modelDetail->invasetlain_kode = $barangM->subsubkelompok->subsubkelompok_kode;

            $default = "00001";
            $prefix = $modelDetail->invasetlain_kode;
            $sql = "SELECT CAST(MAX(SUBSTR(invasetlain_kode," . (strlen($prefix) + 2) . "," . (strlen($default)) . ")) AS integer) nomaksimal
                    FROM invasetlain_t 
                    WHERE invasetlain_kode LIKE ('" . $prefix . "%')";
            $nourut = Yii::app()->db->createCommand($sql)->queryRow();
            $nourutBaru = (isset($nourut['nomaksimal']) ? $nourut['nomaksimal'] + 1 : 1);

            $rows = "";
            for ($i = 0; $i < $jumlah; $i++) {
                $kode = (str_pad($nourutBaru, strlen($default), 0, STR_PAD_LEFT));
                $modelDetail->invasetlain_kode = $barangM->subsubkelompok->subsubkelompok_kode . '.' . $kode;
                $rows .= $this->renderPartial('_invDetailAset', array('form' => '', 'modelDetail' => $modelDetail, 'i' => $i), true);
                $nourutBaru++;
            }

            echo CJSON::encode(array('rows' => $rows));
        }
        Yii::app()->end();
    }

}
