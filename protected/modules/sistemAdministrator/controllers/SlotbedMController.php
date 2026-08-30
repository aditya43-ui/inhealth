<?php

class SlotbedMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'penjadwalan';
    public $path_view = 'sistemAdministrator.views.slotbedM.';
    public $path_view_tips = 'sistemAdministrator.views.tips.';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render($this->path_view . 'view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        $model = new SlotbedM;
        $listHari = array('Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
            'Minggu' => 'Minggu',
        );

        // Uncomment the following line if AJAX validation is needed


        if (isset($_POST['SlotbedM'])) {
            $model->attributes = $_POST['SlotbedM'];
            $model->jadwal_buka = $model->jadwal_mulai . ' s/d ' . $model->jadwal_tutup;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'id' => $model->slotbed_id, 'sukses' => 1));
            }
            // var_dump($model->getErrors());die;
        }

        $this->render($this->path_view . 'create', array(
            'model' => $model,
            'listHari' => $listHari
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
        $listHari = array('Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
            'Minggu' => 'Minggu',
        );

        // Uncomment the following line if AJAX validation is needed


        if (isset($_POST['SlotbedM'])) {
            $model->attributes = $_POST['SlotbedM'];
            $model->jadwal_buka = $model->jadwal_mulai . ' s/d ' . $model->jadwal_tutup;
            $model->jadwal_tgl = MyFormatter::formatDateTimeForDB($model->jadwal_tgl);
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'id' => $model->slotbed_id, 'sukses' => 1));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model' => $model,
            'listHari' => $listHari
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
        $dataProvider = new CActiveDataProvider('SlotbedM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin($sukses = '') {
        if ($sukses == 1) {
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        }

        $model = new SlotbedM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SlotbedM'])) {
            $model->attributes = $_GET['SlotbedM'];
            $model->bulan = $_GET['SlotbedM']['bulan'];
            $model->nama_pegawai = $_GET['SlotbedM']['nama_pegawai'] ?? null;
        }

        $this->render($this->path_view . 'admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = SlotbedM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'slotbed-m-form') {
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
        //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
        //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionPrint() {
        // $model= new SlotbedM;
        // $model->attributes=$_REQUEST['SlotbedM'];
        $model = new SlotbedM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SlotbedM'])) {
            var_dump($_GET); die;
            $model->attributes = $_GET['SlotbedM'];
            $model->nama_pegawai = $_GET['SlotbedM']['nama_pegawai'] ?? null;
        }
        $judulLaporan = 'Data SlotbedM';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    public function actionPenjadwalan() {
        $model = new SlotbedM();
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $jadwal = $_POST['jadwalSlot'];
            $error = array();
            $error2 = array();
            $data = array();
            $allError = true;
            $error2[0] = '';
            $jumlahDokter = 0;
            foreach ($jadwal as $key => $value) {
                if (empty($jadwal[$key])) {
                    $error2[] = 'jadwalSlot[' . $key . ']';
                    $allError = false;
                }
            }
            if (count($jadwal['jadwal']) > 0) {
                unset($error2[0]);
                foreach ($jadwal['jadwal'] as $key => $row) {
                        if (isset($row['cek']) && $row['cek'] == 1) {
                            if (isset($row['jadwal']) && count($row['jadwal']) > 0) {
                                foreach ($row['jadwal'] as $j => $row2) {
                                    $jadwalSlot = new SlotbedM();
                                    $jadwalSlot->attributes = $row2;
                                    $jadwalSlot->instalasi_id = (isset($_POST['jadwalSlot']['instalasi_id']) ? $_POST['jadwalSlot']['instalasi_id'] : null);
                                    $jadwalSlot->jadwal_hari = $row['jadwal_hari'];
                                    $jadwalSlot->jadwal_buka = $row2['jadwal_mulai'] . ' s/d ' . $row2['jadwal_tutup'];
                                    $jadwalSlot->instalasi_id = $jadwal['instalasi'];
                                    if (!$jadwalSlot->validate()) {
                                        $allError = false;
                                        foreach ($jadwalSlot->getErrors() as $x => $y) {
                                            $error['jadwalSlot[jadwal][' . $key . '][dokter][' . $jadwalSlot->ruangan_id . '][dokter][' . $j . '][' . $x . ']'] = $y;
                                        }
                                    } else {
                                        $jumlahDokter += count($row['jadwal']);
                                    }
                                }
                            }
                        }
                }
            }
            if (count($jadwal['jadwal']) == 0 || $jumlahDokter == 0) {
                $error2[0] = 'Jadwal Detail Tidak Boleh Kosong.';
                $allError = false;
            }
            $data['error'] = ($allError) ? 'no' : $error;
            $data['error2'] = $error2;
            echo json_encode($data);
            Yii::app()->end();
        }
        // exit(json_encode($_POST));

        if (isset($_POST['jadwalSlot'])) {
            $jadwal = $_POST['jadwalSlot'];
            // var_dump($_POST);

            $detail = isset($_POST['detail']) ? $_POST['detail'] : [];

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $ok = true;


                foreach ($detail as $det) {

                    if (!isset($det['ceklis'])) {
                        continue;
                    }

                    /*
                    $slotbed_id = $det['slotbed_id'];
                    if (!empty($slotbed_id)) {
                        $model = SlotbedM::model()->findByPk($slotbed_id);

                        if (empty($model)) {
                            $model = new SlotbedM;
                        }
                    } else {
                        */
                        $model = new SlotbedM;
                        /*
                    }
                    */

                    // var_dump($model->isNewRecord);

                    $model->attributes = $jadwal;
                    $model->attributes = $det;
                    $model->kelaspelayanan_id = $_POST['SlotbedM']['kelaspelayanan_id'];
                    $model->slotbed_noslot = $_POST['SlotbedM']['slotbed_noslot'];
                    $model->jadwal_tgl = $det['jadwal_tgl'];
                    // $model->estimasipelayanan = $det['estimasipelayanan'];
                    $model->jadwal_buka = $model->jadwal_mulai." s/d ".$model->jadwal_tutup;
                    $model->jadwal_hari = MyFormatter::getDayUser($det['hari']);

                    // var_dump($model->attributes, $det);
                    
                    if ($model->validate()) {
                        $ok = $ok && $model->save();
                    } else {
                        $ok = false;
                    }

                    // var_dump($model->attributes, $det);
                }
                // var_dump($ok); die;
                // die;
                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin', 'sukses' => 1));
                    //$this->refresh();
                } else {
                    var_dump($model->getErrors());die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                }
            } catch (Exception $exc) {
                    var_dump($exc);die;
//
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.', MyExceptionMessage::getMessage($exc));
            }
        }
        $this->render($this->path_view . 'penjadwalan', array('model' => $model));
    }

    public function actionAjaxListPoli() {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi = $_POST['id'];
            $criteria = new CDbCriteria;
            if (!empty($instalasi)) {
                $criteria->addCondition("instalasi_id = " . $instalasi);
            }
            $criteria->addCondition('ruangan_aktif = TRUE');
            $criteria->order = 'ruangan_nama';

            $polis = RuanganM::model()->findAll($criteria);

            $str = '<option value="">-- Pilih --</option>';

            foreach ($polis as $ruangan) {
                $str .= '<option value="' . $ruangan->ruangan_id . '">' . $ruangan->ruangan_nama . '</option>';
            }

            echo CJSON::encode(array('list' => $str));

//                echo CHtml::checkBoxList($name, $select, $data);
            //echo CHtml::checkBox('pilih_semua_poli',true,array('onclick'=>'pilihSemua(this);'))."<label class='checkbox'>Pilih Semua</label><br/>";
            //echo CHtml::checkBoxList('jadwalSlot[poliklinik]', CHtml::listData($polis, 'ruangan_id', 'ruangan_id'), CHtml::listData($polis, 'ruangan_id', 'ruangan_nama'), array('template'=>'<label class="checkbox">{input} {label}</label>','separator'=>''));
        }
    }

    public function actionAjaxGenerateInputForm() {
        if (Yii::app()->request->isAjaxRequest) {
            $periodeAwal = MyFormatter::formatDateTimeForDb($_POST['SlotbedM']['jadwal_awal']);
            $periodeAkhir = MyFormatter::formatDateTimeForDb($_POST['SlotbedM']['jadwal_akhir']);
            $instalasi_id = $_POST['jadwalSlot']['instalasi'];

            
            $tgl_awal = new DateTime($periodeAwal);
            $tgl_akhir = new DateTime(date('Y-m-d', strtotime('+1 day', strtotime($periodeAkhir))));

            $interval = DateInterval::createFromDateString('1 day');
            $periode = new DatePeriod($tgl_awal, $interval, $tgl_akhir);

            $hari_lama = 0;
            $hari_list = array();
            $baris = 0;

            $gen = isset($_POST['gen']) ? $_POST['gen'] : null;

            foreach ($periode as $item) {

                $nilai_hari = $item->format('w');
                $nilai_tanggal = $item->format('Y-m-d');

                if ($item->format('w') < $hari_lama) {
                    $baris++;
                }

                if (empty($hari_list[$baris])) {
                    $hari_list[$baris] = array(
                        0 => null, // minggu
                        1 => null,
                        2 => null,
                        3 => null,
                        4 => null,
                        5 => null,
                        6 => null, // sabtu
                    );
                }

                $hari_list[$baris][$nilai_hari] = array(
                    'tanggal'=>$nilai_tanggal,
                    'id'=>null,
                    'jam_awal'=>'00:00:00',
                    'jam_akhir'=>'00:00:00',
                    'max_antrian'=>0,
                    'max_janji'=>0
                );

                $jadwal = SlotbedM::model()->findByAttributes(array(
                    'jadwal_tgl'=>$nilai_tanggal,
                ));


                if (!empty($jadwal)) {
                    $hari_list[$baris][$nilai_hari]['id'] = $jadwal->slotbed_id;
                    $hari_list[$baris][$nilai_hari]['jam_awal'] = $jadwal->jadwal_mulai;
                    $hari_list[$baris][$nilai_hari]['jam_akhir'] = $jadwal->jadwal_tutup;
                    $hari_list[$baris][$nilai_hari]['max_antrian'] = $jadwal->maximumantrian;
                    $hari_list[$baris][$nilai_hari]['max_janji'] = $jadwal->maksbuatjanji;
                }


                $hari_lama = $nilai_hari;
            }

            // var_dump($hari_list);

            // die;


            // var_dump($periodeAwal, $periodeAkhir); die;


            $instalasi = InstalasiM::model()->findAllByAttributes(array('instalasi_id' => $instalasi_id));
            $form = $this->renderPartial($this->path_view."formJadwalHari2", array(
                'hari_list'=>$hari_list, 'instalasi_id'=>$instalasi_id,
                'gen'=>$gen,
            ), true);

            $submit = '';
            $data = array();
            
            /*
            for ($i = 0; $i < $jumlahHari; $i++) {
                $form .= $this->renderPartial($this->path_view . 'formJadwalHari', array('i' => $i,
                    'startTimeStamp' => $startTimeStamp,
                    'endTimeStamp' => $endTimeStamp,
                    'instalasi_id' => $instalasi_id,
                    'instalasi' => $instalasi), true);
            }
            */
            
            $submit = CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onClick' => 'clientValidationFunc(this);'));
            $batal = CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/slotbedM/penjadwalan'), array('class' => 'btn btn-danger'));
            $data['form'] = $form;
            $data['submit'] = $submit;
            $data['batal'] = $batal;
            echo json_encode($data);
        }
    }

    public function actionAjaxListDokter() {
        if (Yii::app()->request->isAjaxRequest) {
            $ruangan_id = (isset($_POST['idRuangan']) ? $_POST['idRuangan'] : null);
            $criteria = new CDbCriteria;
            if (!empty($ruangan_id)) {
                $criteria->addCondition("ruangan_id = " . $ruangan_id);
            }

            $dokters = DokterV::model()->findAll($criteria);
            $data = array();
            $data['options'] = null;
            foreach ($dokters as $dokter) {
                $dokter_id = (isset($dokter->pegawai_id) ? $dokter->pegawai_id : null);
                $dokter_nama = (isset($dokter->nama_pegawai) ? $dokter->namaLengkap : null);
                $data['options'] .= CHtml::tag('option', array('value' => $dokter_id), CHtml::encode($dokter_nama), true);
            }

            $data['ruangan_id'] = $ruangan_id;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionAjaxListDokterRuangan () {
        if (Yii::app()->request->isAjaxRequest) {
            $ruangan_id = $_POST['ruangan_id'];
            $criteria = new CDbCriteria;
            if (!empty($ruangan_id)) {
                $criteria->addCondition("ruangan_id = " . $ruangan_id);
            }
            $criteria->addCondition('pegawai_aktif = TRUE');
            $criteria->order = 'nama_pegawai';

            $dokters = DokterV::model()->findAll($criteria);

            $str = '<option value="">-- Pilih --</option>';

            foreach ($dokters as $dokter) {
                $str .= '<option value="' . $dokter->pegawai_id . '">' . $dokter->namaLengkap . '</option>';
            }

            echo CJSON::encode(array('list' => $str));

//                echo CHtml::checkBoxList($name, $select, $data);
            //echo CHtml::checkBox('pilih_semua_poli',true,array('onclick'=>'pilihSemua(this);'))."<label class='checkbox'>Pilih Semua</label><br/>";
            //echo CHtml::checkBoxList('jadwalSlot[poliklinik]', CHtml::listData($polis, 'ruangan_id', 'ruangan_id'), CHtml::listData($polis, 'ruangan_id', 'ruangan_nama'), array('template'=>'<label class="checkbox">{input} {label}</label>','separator'=>''));
        }
    }

}
