<?php

/**
 * Transaksi ID / AST
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @category controller
 */
class IdastTController extends MyAuthController {

    /**
     * Halaman Transaksi ID / AST
     * @param type $spesimen_id
     * @param type $idast_id
     * @param type $idast_id2
     */
    public function actionIndex($spesimen_id, $idast_id = null, $idast_id2 = null) {

        $model = new IdastT;
        $modelDetail = new IdastDetT;
        $model2 = new MKIdastT;
        $modelDetail2 = new MKIdastDetT;
        $modSpesimen = SpesimenT::model()->findByPk($spesimen_id);

        if (!empty($modSpesimen)) {
            $modSpesimen->nama_pasien = $modSpesimen->penilaianKelayakanSpesimen->pasienmasukpenunjang->pasien->nama_pasien;
            $modSpesimen->no_rekam_medik = $modSpesimen->penilaianKelayakanSpesimen->pasienmasukpenunjang->pasien->no_rekam_medik;
            $modSpesimen->ruangan_asal = $modSpesimen->penilaianKelayakanSpesimen->pasienmasukpenunjang->ruanganasal->ruangan_nama;
            $modSpesimen->jenis_spesimen = $modSpesimen->samplelab->samplelab_nama;
            $modSpesimen->jenis_pemeriksaan = $modSpesimen->tindakanpelayanan->daftartindakan->daftartindakan_nama;
            $modSpesimen->waktu_pengambilan_spesimen = date('d ', strtotime($modSpesimen->waktu_pengambilan_spesimen)) . MyFormatter::getMonthId(date('m', strtotime($modSpesimen->waktu_pengambilan_spesimen))) . date(' Y H:i:s', strtotime($modSpesimen->waktu_pengambilan_spesimen));

            $cek = IdastT::model()->findAllByAttributes(array('spesimen_id' => $spesimen_id));
            if (!empty($cek)) {
                if(count($cek) == 2){
                    $model = IdastT::model()->findByAttributes(array('spesimen_id' => $spesimen_id),array('order'=>'idast_id ASC'));
                    $modelDetail = IdastDetT::model()->findAllByAttributes(array('idast_id' => $model->idast_id));
                    $model->analis_nama = $model->analis->namaLengkap;
                    $model->verifikator_nama = $model->verifikator->namaLengkap;
                    $model->analis_nim = $model->analis->nomorindukpegawai;
                    $model->verifikator_nim = $model->verifikator->nomorindukpegawai;
                    
                    $model2 = MKIdastT::model()->findByAttributes(array('spesimen_id' => $spesimen_id),array('order'=>'idast_id DESC'));
                    $modelDetail2 = MKIdastDetT::model()->findAllByAttributes(array('idast_id' => $model2->idast_id));
                }else if(count($cek) == 1){
                    $model = IdastT::model()->findByAttributes(array('spesimen_id' => $spesimen_id));
                    $modelDetail = IdastDetT::model()->findAllByAttributes(array('idast_id' => $model->idast_id));
                    $model->analis_nama = $model->analis->namaLengkap;
                    $model->verifikator_nama = $model->verifikator->namaLengkap;
                    $model->analis_nim = $model->analis->nomorindukpegawai;
                    $model->verifikator_nim = $model->verifikator->nomorindukpegawai;
                }
            }
        }

        if (!empty($idast_id) || !empty($model->idast_id) || !empty($idast_id2) || !empty($model2->idast_id)) {
            $cek = IdastT::model()->findAllByAttributes(array('spesimen_id' => $spesimen_id));
            if (!empty($cek)) {
                if(count($cek) == 2){
                    $model = IdastT::model()->findByAttributes(array('spesimen_id' => $spesimen_id),array('order'=>'idast_id ASC'));
                    $modelDetail = IdastDetT::model()->findAllByAttributes(array('idast_id' => $model->idast_id));
                    $model->analis_nama = $model->analis->namaLengkap;
                    $model->verifikator_nama = $model->verifikator->namaLengkap;
                    $model->analis_nim = $model->analis->nomorindukpegawai;
                    $model->verifikator_nim = $model->verifikator->nomorindukpegawai;
                    
                    $model2 = MKIdastT::model()->findByAttributes(array('spesimen_id' => $spesimen_id),array('order'=>'idast_id DESC'));
                    $modelDetail2 = MKIdastDetT::model()->findAllByAttributes(array('idast_id' => $model2->idast_id));
                }else if(count($cek) == 1){
                    $model = IdastT::model()->findByAttributes(array('spesimen_id' => $spesimen_id));
                    $modelDetail = IdastDetT::model()->findAllByAttributes(array('idast_id' => $model->idast_id));
                    $model->analis_nama = $model->analis->namaLengkap;
                    $model->verifikator_nama = $model->verifikator->namaLengkap;
                    $model->analis_nim = $model->analis->nomorindukpegawai;
                    $model->verifikator_nim = $model->verifikator->nomorindukpegawai;
                }
            }
        }

        if (isset($_POST['IdastT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $model->attributes = $_POST['IdastT'];
                $model->spesimen_id = $spesimen_id;
                if (!empty($model->idast_id)) {
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->update_time = date('Y-m-d H:i:s');
                } else {
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                }
                $ok = $ok && $model->save();

                $cekDetail = IdastDetT::model()->findAllByAttributes(array('idast_id' => $model->idast_id));
                if (isset($_POST['IdastDetT']) && $ok) {
                    foreach ($_POST['IdastDetT'] as $key => $value) {
                        if (!empty($cekDetail)) {
                            foreach ($cekDetail as $val) {
                                if ($val->idast_det_id == $key) {
                                    $modUpdate = IdastDetT::model()->findByPk($key);
                                    $modUpdate->attributes = $value;
                                    $modUpdate->is_ceklis = !empty($value['is_ceklis']) ? $value['is_ceklis'] : false;
                                    $ok = $ok && $modUpdate->save();
                                }
                            }
                        } else {
                            $modelDetail = new IdastDetT;
                            $modelDetail->attributes = $value;
                            $modelDetail->idast_id = $model->idast_id;
                            $modelDetail->is_ceklis = !empty($value['is_ceklis']) ? $value['is_ceklis'] : false;
                            $ok = $ok && $modelDetail->save();
                        }
                    }
                }
                $cekSpesimen = SpesimenT::model()->findByPk($model->spesimen_id);
                $cekSpesimen->status_pemeriksaan = 'ID / AST';
                $cekSpesimen->update();
                
                if(!empty($_POST['MKIdastT'])){
                    $model2->attributes = $_POST['MKIdastT'];
                    $model2->spesimen_id = $spesimen_id;
                    if (!empty($model2->idast_id)) {
                        $model2->update_loginpemakai_id = Yii::app()->user->id;
                        $model2->update_time = date('Y-m-d H:i:s');
                    } else {
                        $model2->create_loginpemakai_id = Yii::app()->user->id;
                        $model2->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $model2->create_time = date('Y-m-d H:i:s');
                    }
                    $model2->analis_id = $model->analis_id;
                    $model2->verifikator_id = $model->verifikator_id;
                    $model2->status_verifikasi = $model->status_verifikasi;
                    $model2->tgl_verifikasi = $model->tgl_verifikasi;
                    $ok = $ok && $model2->save();

                    $cekDetail2 = MKIdastDetT::model()->findAllByAttributes(array('idast_id' => $model2->idast_id));
                    if (isset($_POST['MKIdastDetT']) && $ok) {
                        foreach ($_POST['MKIdastDetT'] as $key => $value) {
                            if (!empty($cekDetail2)) {
                                foreach ($cekDetail2 as $val) {
                                    if ($val->idast_det_id == $key) {
                                        $modUpdate2 = MKIdastDetT::model()->findByPk($key);
                                        $modUpdate2->attributes = $value;
                                        $modUpdate2->is_ceklis = !empty($value['is_ceklis']) ? $value['is_ceklis'] : false;
                                        $ok = $ok && $modUpdate2->save();
                                    }
                                }
                            } else {
                                $modelDetail2 = new MKIdastDetT;
                                $modelDetail2->attributes = $value;
                                $modelDetail2->idast_id = $model2->idast_id;
                                $modelDetail2->is_ceklis = !empty($value['is_ceklis']) ? $value['is_ceklis'] : false;
                                $ok = $ok && $modelDetail2->save();
                            }
                        }
                    }
                }

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    if(!empty($model2->idast_id)){
                        $this->redirect(array('index', 'spesimen_id' => $model->spesimen_id, 'idast_id' => $model->idast_id, 'idast_id2' => $model2->idast_id, 'sukses' => 1));
                    }else{
                        $this->redirect(array('index', 'spesimen_id' => $model->spesimen_id, 'idast_id' => $model->idast_id, 'sukses' => 1));
                    }
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render('index', array(
            'model' => $model,
            'modelDetail' => $modelDetail,
            'modSpesimen' => $modSpesimen,
            'model2' => $model2,
            'modelDetail2' => $modelDetail2,
        ));
    }

    /**
     * Digunakan untuk mengenerate AST
     */
    public function actionGenerateAST() {
        if (Yii::app()->request->isAjaxRequest) {
            $panel = isset($_POST['panel']) ? $_POST['panel'] : null;
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $value = "";
            if ($panel == 'Positif') {
                $panel_nama = 'Positif';
            } else {
                $panel_nama = 'Negative';
            }
            $cek = IdastT::model()->findByAttributes(array('idast_id' => $id, 'panel_nama' => $panel_nama));
            if (!empty($cek)) {
                $modDet = IdastDetT::model()->findAllByAttributes(array('idast_id' => $id));
                $i = 0;
                $value .= '<tr>';
                foreach ($modDet as $item) {
                    $i++;
                    $value .= '<td>'.CHtml::checkBox('IdastDetT[' . $item->idast_det_id . '][is_ceklis]', $item->is_ceklis, array('class' => 'pilihcheck_'.$item->ast_id)).' &nbsp; <label>' . $item->ast->ast_nama . '</label></td>';
                    $value .= '<td style="padding:2px;">' .
                            CHtml::hiddenField('IdastDetT[' . $item->idast_det_id . '][ast_id]', $item->ast_id, array('class' => 'span1')) .
                            CHtml::dropDownList('IdastDetT[' . $item->idast_det_id . '][hasil]', $item->hasil, CHtml::listData(LookupM::model()->findAll(array("condition" => "lookup_type = 'hasil_antibiotik'", 'order' => 'lookup_urutan ASC')), 'lookup_value', 'lookup_name'), array('class' => 'span1')) .
                            '</td>';
                    if ($i == 3) {
                        $value .= '</tr><tr>';
                        $i = 0;
                    }
                }
                $value .= '</tr>';
            } else {
                if ($panel == 'Positif') {
                    $modPertanyaan = AstM::model()->findAll("panel = 'Positive'");
                } else {
                    $modPertanyaan = AstM::model()->findAll("panel = 'Negative'");
                }
                $modDet = new IdastDetT;
                $i = 0;
                $value .= '<tr>';
                foreach ($modPertanyaan as $item) {
                    $i++;
                    $value .= '<td>'.CHtml::checkBox('IdastDetT[' . $item->ast_id . '][is_ceklis]', true, array('class' => 'pilihcheck_'.$item->ast_id)).' &nbsp; <label>' . $item->ast_nama . '</label></td>';
                    $value .= '<td style="padding:2px;">' .
                            CHtml::hiddenField('IdastDetT[' . $item->ast_id . '][ast_id]', $item->ast_id, array('class' => 'span1')) .
                            CHtml::activeDropDownList($modDet, '[' . $item->ast_id . ']hasil', LookupM::getItemsUrutan('hasil_antibiotik'), array('class' => 'span1')) .
                            '</td>';
                    if ($i == 3) {
                        $value .= '</tr><tr>';
                        $i = 0;
                    }
                }
                $value .= '</tr>';
            }
            $data['sukses'] = 1;
            $data['html'] = $value;

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Load blood agar
     */
    public function actionLoadBarisKedua() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
                
            if(!empty($id)){
                $model2 = MKIdastT::model()->findByPk($id);
                $modelDetail2 = new MKIdastDetT;
            }else{
                $model2 = new MKIdastT;
                $modelDetail2 = new MKIdastDetT;
            }
            $html = $this->renderPartial('_formRow2', array('model2' => $model2, 'modelDetail2' => $modelDetail2), true);
            
            $data['sukses'] = 1;
            $data['html'] = $html;

            echo json_encode($data);
        }
        Yii::app()->end();
    }
    
    /**
     * Digunakan untuk mengenerate AST baris kedua
     */
    public function actionGenerateAST2() {
        if (Yii::app()->request->isAjaxRequest) {
            $panel = isset($_POST['panel']) ? $_POST['panel'] : null;
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $value = "";
            if ($panel == 'Positif') {
                $panel_nama = 'Positif';
            } else {
                $panel_nama = 'Negative';
            }
            $cek = MKIdastT::model()->findByAttributes(array('idast_id' => $id, 'panel_nama' => $panel_nama));
            if (!empty($cek)) {
                $modDet = MKIdastDetT::model()->findAllByAttributes(array('idast_id' => $id));
                $i = 0;
                $value .= '<tr>';
                foreach ($modDet as $item) {
                    $i++;
                    $value .= '<td>'.CHtml::checkBox('MKIdastDetT[' . $item->idast_det_id . '][is_ceklis]', $item->is_ceklis, array('class' => 'pilihcheck_'.$item->ast_id)).' &nbsp; <label>' . $item->ast->ast_nama . '</label></td>';
                    $value .= '<td style="padding:2px;">' .
                            CHtml::hiddenField('MKIdastDetT[' . $item->idast_det_id . '][ast_id]', $item->ast_id, array('class' => 'span1')) .
                            CHtml::dropDownList('MKIdastDetT[' . $item->idast_det_id . '][hasil]', $item->hasil, CHtml::listData(LookupM::model()->findAll(array("condition" => "lookup_type = 'hasil_antibiotik'", 'order' => 'lookup_urutan ASC')), 'lookup_value', 'lookup_name'), array('class' => 'span1')) .
                            '</td>';
                    if ($i == 3) {
                        $value .= '</tr><tr>';
                        $i = 0;
                    }
                }
                $value .= '</tr>';
            } else {
                if ($panel == 'Positif') {
                    $modPertanyaan = AstM::model()->findAll("panel = 'Positive'");
                } else {
                    $modPertanyaan = AstM::model()->findAll("panel = 'Negative'");
                }
                $modDet = new MKIdastDetT;
                $i = 0;
                $value .= '<tr>';
                foreach ($modPertanyaan as $item) {
                    $i++;
                    $value .= '<td>'.CHtml::checkBox('MKIdastDetT[' . $item->ast_id . '][is_ceklis]', true, array('class' => 'pilihcheck_'.$item->ast_id)).' &nbsp; <label>' . $item->ast_nama . '</label></td>';
                    $value .= '<td style="padding:2px;">' .
                            CHtml::hiddenField('MKIdastDetT[' . $item->ast_id . '][ast_id]', $item->ast_id, array('class' => 'span1')) .
                            CHtml::activeDropDownList($modDet, '[' . $item->ast_id . ']hasil', LookupM::getItemsUrutan('hasil_antibiotik'), array('class' => 'span1')) .
                            '</td>';
                    if ($i == 3) {
                        $value .= '</tr><tr>';
                        $i = 0;
                    }
                }
                $value .= '</tr>';
            }
            $data['sukses'] = 1;
            $data['html'] = $value;

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk mengenerate detail AST
     */
    public function actionGenerateDetailAST() {
        if (Yii::app()->request->isAjaxRequest) {
            $panel = isset($_POST['panel']) ? $_POST['panel'] : null;
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $value = "";
            $modDet = IdastDetT::model()->findAllByAttributes(array('idast_id' => $id));
            $i = 0;
            $value .= '<tr>';
            foreach ($modDet as $item) {
                $i++;
                $value .= '<td>'.CHtml::checkBox('IdastDetT[' . $item->idast_det_id . '][is_ceklis]', $item->is_ceklis, array('class' => 'pilihcheck_'.$item->ast_id, 'disabled' => true)).' &nbsp; <label>' . $item->ast->ast_nama . '</label></td>';
                $value .= '<td style="padding:2px;">' .
                        CHtml::hiddenField('IdastDetT[' . $item->idast_det_id . '][ast_id]', $item->ast_id, array('class' => 'span1')) .
                        CHtml::dropDownList('IdastDetT[' . $item->idast_det_id . '][hasil]', $item->hasil, CHtml::listData(LookupM::model()->findAll(array("condition" => "lookup_type = 'hasil_antibiotik'", 'order' => 'lookup_urutan ASC')), 'lookup_value', 'lookup_name'), array('class' => 'span1', 'disabled' => true)) .
                        '</td>';
                if ($i == 3) {
                    $value .= '</tr><tr>';
                    $i = 0;
                }
            }
            $value .= '</tr>';

            $data['sukses'] = 1;
            $data['html'] = $value;

            echo json_encode($data);

            Yii::app()->end();
        }
    }
    
    /**
     * Digunakan untuk mengenerate detail AST
     */
    public function actionGenerateDetailAST2() {
        if (Yii::app()->request->isAjaxRequest) {
            $panel = isset($_POST['panel']) ? $_POST['panel'] : null;
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $value = "";
            $modDet = MKIdastDetT::model()->findAllByAttributes(array('idast_id' => $id));
            $i = 0;
            $value .= '<tr>';
            foreach ($modDet as $item) {
                $i++;
                $value .= '<td>'.CHtml::checkBox('MKIdastDetT[' . $item->idast_det_id . '][is_ceklis]', $item->is_ceklis, array('class' => 'pilihcheck_'.$item->ast_id, 'disabled' => true)).' &nbsp; <label>' . $item->ast->ast_nama . '</label></td>';
                $value .= '<td style="padding:2px;">' .
                        CHtml::hiddenField('MKIdastDetT[' . $item->idast_det_id . '][ast_id]', $item->ast_id, array('class' => 'span1')) .
                        CHtml::dropDownList('MKIdastDetT[' . $item->idast_det_id . '][hasil]', $item->hasil, CHtml::listData(LookupM::model()->findAll(array("condition" => "lookup_type = 'hasil_antibiotik'", 'order' => 'lookup_urutan ASC')), 'lookup_value', 'lookup_name'), array('class' => 'span1', 'disabled' => true)) .
                        '</td>';
                if ($i == 3) {
                    $value .= '</tr><tr>';
                    $i = 0;
                }
            }
            $value .= '</tr>';

            $data['sukses'] = 1;
            $data['html'] = $value;

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk verifikasi 
     */
    public function actionSetVerifikasi() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            
            $model = IdastT::model()->findByAttributes(array('idast_id' => $id));
            $model->status_verifikasi = 'Terverifikasi';
            $model->tgl_verifikasi = date('Y-m-d H:i:s');
            $model->update();
            
            $data['sukses'] = 1;

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk Batal verifikasi 
     */
    public function actionSetBatalVerifikasi() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            
            $model = IdastT::model()->findByAttributes(array('idast_id' => $id));
            $model->status_verifikasi = null;
            $model->tgl_verifikasi = null;
            $model->update();
            
            $data['sukses'] = 1;

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Autocomplete Analis
     */
    public function actionAutocompleteAnalis() {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->select = " t.nama_pegawai, t.pegawai_id,t.gelarbelakang_nama,t.gelardepan,j.jabatan_nama,t.nomorindukpegawai, u.namaunitkerja,t.kelompokpegawai_id, t.nomobile_pegawai";
            $criteria->join = " LEFT JOIN jabatan_m j ON j.jabatan_id = t.jabatan_id "
                            . " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id "
                            . " LEFT JOIN unitkerja_m u ON u.unitkerja_id = p.unitkerja_id ";
            $criteria->addCondition(" ruangan_id = ".Yii::app()->user->getState('ruangan_id')); 

            if (!empty($this->jabatan_id)){
                $criteria->addCondition("t.jabatan_id =".$this->jabatan_id);
            }
            if (!empty($this->unitkerja_id)){
                $criteria->addCondition("u.unitkerja_id =".$this->unitkerja_id);
            }
            $criteria->compare('LOWER(t.nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = " t.nama_pegawai ASC ";
            $criteria->limit = 10;
            $models = PegawairuanganV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
                $returnVal[$i]['analis_nim'] = $model->nomorindukpegawai;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Autocomplete Analis
     */
    public function actionAutocompleteVerifikator() {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->select = " t.nama_pegawai, t.pegawai_id,t.gelarbelakang_nama,t.gelardepan,j.jabatan_nama,t.nomorindukpegawai, u.namaunitkerja,t.kelompokpegawai_id, t.nomobile_pegawai";
            $criteria->join = " LEFT JOIN jabatan_m j ON j.jabatan_id = t.jabatan_id "
                            . " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id "
                            . " LEFT JOIN unitkerja_m u ON u.unitkerja_id = p.unitkerja_id ";
            $criteria->addCondition(" ruangan_id = ".Yii::app()->user->getState('ruangan_id')); 

            if (!empty($this->jabatan_id)){
                $criteria->addCondition("t.jabatan_id =".$this->jabatan_id);
            }
            if (!empty($this->unitkerja_id)){
                $criteria->addCondition("u.unitkerja_id =".$this->unitkerja_id);
            }
            $criteria->addCondition("t.kelompokpegawai_id = 1");
            $criteria->compare('LOWER(t.nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = " t.nama_pegawai ASC ";
            $criteria->limit = 10;
            $models = PegawairuanganV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
                $returnVal[$i]['verifikator_nim'] = $model->nomorindukpegawai;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Batal Penerimaan Spesimen
     * Update ke penerimaanspesimen_t dan insert ke batalpenerimaanspesimen_t
     */
    public function actionHapusData() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $ok = 1;
        $msg = "Data berhasil dihapus";
        $id = $_POST['id'];

        $cekData = IdastT::model()->findByPk($id);
        if (!empty($cekData)) {
            $cekDet = IdastDetT::model()->findAllByAttributes(array('idast_id' => $cekData->idast_id));
            if (!empty($cekDet)) {
                $modDet = IdastDetT::model()->deleteAllByAttributes(array('idast_id' => $cekData->idast_id));
            }
            $model = IdastT::model()->deleteByPk($cekData->idast_id);
        }

        echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
        Yii::app()->end();
    }

}
