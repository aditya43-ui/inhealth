<?php
/**
 * digunakan untuk transaksi evaluasi askep
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 * @category controller
 * */
class EvaluasiAskepController extends MyAuthController {

    protected $successSave = true;
    public $path_view = "asuhanKeperawatan.views.evaluasiAskep.";
    
    /**
     * Menampilkan transaksi evaluasi askep
     * @param type $evaluasiaskep_id
     */
    public function actionIndex($evaluasiaskep_id = null) {
        if (isset($_GET['frame'])) {
            $this->layout = "//layouts/iframe";
        }
        $model = new ASEvaluasiaskepT;
        $modDetail = new ASEvaluasiaskepdetT;
        $modImpl = new ASImplementasiaskepT;
        $modPasien = new ASInfoimplementasiaskepV;
        $model->evaluasiaskep_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->no_evaluasi = "- Otomatis -";
        
        $modRiwayatEval = new ASInfoevaluasiaskepV;
        
        $cekPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->pegawai_id = !empty($cekPegawai->pegawai_id) ? $cekPegawai->pegawai_id : '';
        $model->nama_pegawai = !empty($cekPegawai->nama_pegawai) ? $cekPegawai->nama_pegawai : '';

        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;

        $url_batal = Yii::app()->createAbsoluteUrl(
                Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
        );
        $successSave = false;
        
        if (isset($evaluasiaskep_id)) {
            $model = ASEvaluasiaskepT::model()->findByPk($evaluasiaskep_id);

            $modImpl = ASInfoimplementasiaskepV::model()->findByAttributes(array('implementasiaskep_id' => $model->implementasiaskep_id));
            
            $modPasien = ASInfoimplementasiaskepV::model()->findByAttributes(array('no_pendaftaran' => $modImpl->no_pendaftaran));

            if (empty($modPasien)) {
                $modPasien = ASInfoimplementasiaskepV::model()->findByAttributes(array('no_pendaftaran' => $modImpl->no_pendaftaran));
            }
        }
        
        if (isset($_GET['evaluasiaskep_id'])) {
            $model = ASEvaluasiaskepT::model()->findByPk($_GET['evaluasiaskep_id']);

            $modImpl = ASInfoimplementasiaskepV::model()->findByAttributes(array('implementasiaskep_id' => $model->implementasiaskep_id));

            $modPasien = ASInfoimplementasiaskepV::model()->findByAttributes(array('no_pendaftaran' => $modImpl->no_pendaftaran));

            if (empty($modPasien)) {
                $modPasien = ASInfoimplementasiaskepV::model()->findByAttributes(array('no_pendaftaran' => $modImpl->no_pendaftaran));
            }
        }

        if (isset($_POST['ASEvaluasiaskepT']) && !empty($_POST['ASImplementasiaskepT']['implementasiaskep_id'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model = $this->saveEvaluasi($_POST['ASEvaluasiaskepT'], $_POST['ASImplementasiaskepT']);
                if (isset($_POST['ASImplementasiaskepdetT'])) {

                    $modDetail = $this->saveEvaluasiDetail($_POST['ASImplementasiaskepdetT'], $model);
                }

                $successSave = $this->successSave;

                if ($successSave) {
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $transaction->commit();
                    $this->redirect(array('index', 'status' => 1, 'evaluasiaskep_id' => $model->evaluasiaskep_id));
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                    $transaction->rollback();
                }
            } catch (Exception $exc) {
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                $transaction->rollback();
            }
        }
        
        $modRiwayat = new ASInfoevaluasiaskepV();
        if (isset($_GET['ASInfoevaluasiaskepV'])){
            $modRiwayat->attributes = $_GET['ASInfoevaluasiaskepV'];
            $modRiwayat->rencanaaskep_id = $_GET['ASInfoevaluasiaskepV']['rencanaaskep_id'];
        }

        $this->render('index', array(
            'model' => $model,
            'modDetail' => $modDetail,
            'modImpl' => $modImpl,
            'modPasien' => $modPasien,
            'successSave' => $successSave,
            'url_batal' => $url_batal,
            'modRiwayat' => $modRiwayat
        ));
    }
    
    /**
     * Mengecek implementasi askep 
     * @param type $implementasiaskep_id
     */
    public function actionCekImplementasiId($implementasiaskep_id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data = '';
            $eval = [];
            if (isset($implementasiaskep_id)) {
                $data = ASEvaluasiaskepT::model()->findByAttributes(array('implementasiaskep_id' => $implementasiaskep_id));
                $imp = ASImplementasiaskepT::model()->findByPk($implementasiaskep_id);
                $eval['eval'] = null;//$data
                $eval['rencanaaskep_id'] = $imp->rencanaaskep_id;    
            }
            echo CJSON::encode($eval);
        }
        Yii::app()->end();
    }
    
    /**
     * Load data pasien
     * @param type $implementasiaskep_id
     */
    public function actionLoadPasien($implementasiaskep_id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data = '';
            if (isset($implementasiaskep_id)) {
                $data = ASInfoimplementasiaskepV::model()->findByAttributes(array('implementasiaskep_id' => $implementasiaskep_id));
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
    
    /**
     * Meload data gejala
     * @param type $diagnosakep_id
     */
    public function actionGetTandaGejala($diagnosakep_id) {
        if (Yii::app()->request->isAjaxRequest) {
//           $diagnosakep_id = $_POST["$namaModel"]['diagnosakep_id'];
            $namaModel = new ASRencanaaskepdetT;
            $data['form'] = "";
            if (empty($diagnosakep_id)) {
//                    $penjamin = PenjaminpasienM::model()->findAll();
                echo '<label>Data Tidak Ditemukan</label>';
            } else {
                $data['form'] .= CHtml::activeCheckBoxList($namaModel, '[0]tandagejala_id', CHtml::listData(TandagejalaM::model()->findAllByAttributes(array('tandagejala_aktif' => true, 'diagnosakep_id' => $diagnosakep_id)), 'tandagejala_id', 'tandagejala_indikator'), array('onkeyup' => "return $(this).focusNextInputField(event);"));
            }
        }
        echo CJSON::encode($data);
        Yii::app()->end();
    }
    
    /**
     * Load data tujuan
     * @param type $diagnosakep_id
     */
    public function actionGetTujuan($diagnosakep_id) {
        if (Yii::app()->request->isAjaxRequest) {
//           $diagnosakep_id = $_POST["$namaModel"]['diagnosakep_id'];
            $namaModel = new ASRencanaaskepdetT;
            $data['form'] = "";
            if (empty($diagnosakep_id)) {
//                    $penjamin = PenjaminpasienM::model()->findAll();
                echo '<label>Data Tidak Ditemukan</label>';
            } else {
                $tujuan = TujuanM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id));
                $data['form'] = CHtml::activeTextField($namaModel, '[0]rencanaaskepdet_hari', array('class' => 'span1')) . ' x 24 Jam <br>' . $tujuan['tujuan_nama'];
                $data['form'] .= CHtml::activeHiddenField($namaModel, '[0]tujuan_id', array('value' => $tujuan['tujuan_id']));
            }
        }
        echo CJSON::encode($data);
        Yii::app()->end();
    }
    
    /**
     * Meload data kriteria hasil
     * @param type $diagnosakep_id
     */
    public function actionGetKriteriaHasil($diagnosakep_id) {
        if (Yii::app()->request->isAjaxRequest) {
//           $diagnosakep_id = $_POST["$namaModel"]['diagnosakep_id'];
            $namaModel = new ASRencanaaskepdetT;
            $kriteria = new ASKriteriahasildetM;
            $data['form'] = "";
            if (empty($diagnosakep_id)) {
//                    $penjamin = PenjaminpasienM::model()->findAll();
                echo '<label>Data Tidak Ditemukan</label>';
            } else {
                $head = KriteriahasilM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id));
                $data['form'] = CHtml::activeHiddenField($namaModel, '[0]kriteriahasil_id', array('value' => $head['kriteriahasil_id']));
                $data['form'] .= CHtml::activeTextField($namaModel, '[0]kriteriahasil_nama', array('value' => $head['kriteriahasil_nama'], 'class' => 'span2', 'readonly' => true));
                $tail = ASKriteriahasildetM::model()->findAllByAttributes(array('kriteriahasil_id' => $head['kriteriahasil_id']));
                $data['table_id'] = 'table-kriteria-' . $head['kriteriahasil_id'];
                $data['form'] .= '<table class="items table table-striped table-bordered table-condensed kriteria" id="' . $data['table_id'] . '">
                <thead>
                    <tr>
                        <th> </th>
                        <th> Kriteria Hasil </th>
                        <th> IR </th>
                        <th>ER</th>
                </tr>
            </thead>
			<tbody>';
                foreach ($tail as $i => $row) {

                    $data['form'] .= '<tr class="criteria">
						<td>
							<span name="ASRencanaaskepdetT[0][kriteriahasildet_id]">
							' . CHtml::activeCheckBox($namaModel, '[0]kriteriahasildet_id', array('onkeyup' => "return $(this).focusNextInputField(event);", 'value' => $row['kriteriahasildet_id']))
                            . '</span>
						</td>
						<td>
						' . $row['kriteriahasildet_indikator'] . '
						</td>
						<td>
						' . CHtml::dropDownList(
                                    'ASRencanaaskepdetT[0][rencanaaskep_ir]', $namaModel->rencanaaskep_ir, array('1' => '1',
                                '2' => '2', '3' => '3', '4' => '4', '5' => '5',), array('class' => 'span1', 'empty' => '--Pilih--')) . '
						</td>
						<td>
						' . CHtml::dropDownList(
                                    'ASRencanaaskepdetT[0][rencanaaskep_er]', $namaModel->rencanaaskep_er, array('1' => '1',
                                '2' => '2', '3' => '3', '4' => '4', '5' => '5',), array('class' => 'span1', 'empty' => '--Pilih--')) . '
						</td>
						</tr>';
                }
//            <?php 
//                $trTindakan = $this->renderPartial($this->path_view.'_rowTindakanPasien',array('modTindakan'=>$modTindakan,'modTindakans'=>$modTindakans,'kelaspelayanan_id'=>$modPendaftaran->kelaspelayanan_id),true); 
//                echo $trTindakan;
                $data['form'] .= '</tbody></table>';
            }
        }
        echo CJSON::encode($data);
        Yii::app()->end();
    }
    
    /**
     * Meload data intervensi
     * @param type $diagnosakep_id
     */
    public function actionGetIntervensi($diagnosakep_id) {
        if (Yii::app()->request->isAjaxRequest) {
//           $diagnosakep_id = $_POST["$namaModel"]['diagnosakep_id'];
            $namaModel = new ASRencanaaskepdetT;
            $data['form'] = "";
            if (empty($diagnosakep_id)) {
//                    $penjamin = PenjaminpasienM::model()->findAll();
                echo '<label>Data Tidak Ditemukan</label>';
            } else {
                $head = IntervensiM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id));
                $data['form'] = CHtml::activeHiddenField($namaModel, '[0]intervensi_id', array('value' => $head['intervensi_id']));
                $data['form'] .= CHtml::activeTextField($namaModel, '[0]intervensi_nama', array('value' => $head['intervensi_nama'], 'class' => 'span2', 'readonly' => true));
                $data['form'] .= '<br>';
                $data['form'] .= CHtml::activeCheckBoxList($namaModel, '[0]intervensidet_id', CHtml::listData(IntervensidetM::model()->findAllByAttributes(array('intervensidet_aktif' => true, 'intervensi_id' => $head['intervensi_id'])), 'intervensidet_id', 'intervensidet_indikator'), (array('onkeyup' => "return $(this).focusNextInputField(event);")));
            }
        }
        echo CJSON::encode($data);
        Yii::app()->end();
    }
    
        /**
     * Get data implementasi detail
     * @param type $implementasiaskep_id
     */
    public function actionGetImplDet($implementasiaskep_id) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {

            $impldet = ASImplementasiaskepdetT::model()->findAllBySql(
                    'SELECT implementasiaskepdet_t.*,diagnosakep.*
					FROM implementasiaskepdet_t
					JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = implementasiaskepdet_t.diagnosakep_id
					WHERE implementasiaskepdet_t.implementasiaskep_id=' . $implementasiaskep_id);
            $data['form'] = "";
            $impldet_jml = count($impldet);
            if ($impldet_jml > 0) {
                foreach ($impldet AS $i => $modDetail) {
                    /**-- Rencana askep detail --**/
                    if(!empty($modDetail->rencanaaskepdet_id)){
                        $rencanaAskep = RencanaaskepdetT::model()->findByPk($modDetail->rencanaaskepdet_id);
                        $data_planning = ASPilihrencanaaskepT::model()->findAllBySql('
                                SELECT pilihrencanaaskep_t.*,intervensidet.*
                                FROM pilihrencanaaskep_t
                                JOIN intervensidet_m AS intervensidet ON intervensidet.intervensidet_id = pilihrencanaaskep_t.intervensidet_id
                                WHERE rencanaaskepdet_id =' . $modDetail->rencanaaskepdet_id . ' AND pilihrencanaaskep_t.intervensidet_id IS NOT NULL');
                        if(!empty($rencanaAskep)){
                            $detIntervensi ='';
                            $intervensi = IntervensiM::model()->findByPk($rencanaAskep->intervensi_id);
                            if(!empty($data_planning)){
                                foreach($data_planning as $detail){
                                    //$detail = $detail.'- '.$detail->intervensidet_indikator.'<br>';
                                    $detIntervensi= $detIntervensi.'- '.$detail->intervensidet_indikator.'<br>';
                                }
                                $planning = $detIntervensi;
                            }else{
                                $planning = $detIntervensi;
                            }
                        }else{
                            $planning = '';
                        }
                    }else{
                        $planning = '';
                    }
                    $modDetail->evaluasiaskepdet_planning = $planning;
                    /**-- End rencana askep detail --**/
                    
                    /**-- Implementasi askep detail --**/
                    $detImplementasi ='';
                    if(!empty($modDetail->implementasiaskepdet_id)){
                        $impl = ASPilihimplementasiaskepT::model()->findAllBySql('
                            SELECT pilihimplementasiaskep_t.*,indikatorimplkepdet.*
                            FROM pilihimplementasiaskep_t
                            JOIN indikatorimplkepdet_m AS indikatorimplkepdet ON indikatorimplkepdet.indikatorimplkepdet_id = pilihimplementasiaskep_t.indikatorimplkepdet_id
                            WHERE implementasiaskepdet_id =' . $modDetail->implementasiaskepdet_id . ' AND pilihimplementasiaskep_t.indikatorimplkepdet_id IS NOT NULL');
                        if(!empty($impl)){
                            $detImplementasi ='';
                            foreach ($impl as $i => $indikator) {
                                //$detail = $detail.'- '.$detail->intervensidet_indikator.'<br>';
                                $detImplementasi= $detImplementasi.'- '.$indikator->indikatorimplkepdet_indikator.'<br>';
                            }
                        }else{
                            $detImplementasi = '';
                        }
                    }else{
                        $detImplementasi = '';
                    }
                    $modDetail->evaluasiaskepdet_implementasi = $detImplementasi;
                    /**-- End implementasi askep detail --**/
                    
                    /**-- Tanda Gejala askep detail --**/
                    $subjektif = '';
                    $objektif = '';
                    if(!empty($modDetail->rencanaaskepdet_id)){
                        $rencanaAskep = RencanaaskepdetT::model()->findByPk($modDetail->rencanaaskepdet_id);
                        if(!empty($rencanaAskep)){
                            $cekDiagnosa = DiagnosisaskepdetT::model()->findByPk($rencanaAskep->diagnosisaskepdet_id);
                            if(!empty($cekDiagnosa)){
                                $pilihdiagnosa = PilihdiagnosisaskepT::model()->findAllByAttributes(array('diagnosisaskepdet_id'=>$cekDiagnosa->diagnosisaskepdet_id));
                                
                                $faktorrisiko_id = array();
                                $tandagejala_id = array();
                                foreach ($pilihdiagnosa as $value) {
                                    if (!empty($value->faktorrisiko_id)) {
                                        $faktorrisiko_id[] = $value->faktorrisiko_id;
                                    }else if (!empty($value->tandagejala_id)) {
                                        $tandagejala_id[] = $value->tandagejala_id;
                                    }
                                }
                                
                                if (!empty($faktorrisiko_id)) {
                                    $criteria = new CDbCriteria;
                                    $criteria->select = 'jenisfaktorrisiko.jenisfaktorrisiko_nama, det.faktorrisiko_daftar_id, t.faktorrisiko_daftar_nama, det.kelompokfaktorrisikodaftar_id, det.jenisfaktorrisiko_id, row_number() OVER (PARTITION BY jenisfaktorrisiko.jenisfaktorrisiko_urutan ORDER BY jenisfaktorrisiko.jenisfaktorrisiko_urutan) AS no';
                                    $criteria->join = 'JOIN kelompokfaktorrisikodaftar_m det ON det.faktorrisiko_daftar_id = t.faktorrisiko_daftar_id '
                                                    . 'JOIN jenisfaktorrisiko_m jenisfaktorrisiko ON jenisfaktorrisiko.jenisfaktorrisiko_id = det.jenisfaktorrisiko_id '
                                                    . 'JOIN faktorrisiko_m faktorrisiko ON faktorrisiko.kelompokfaktorrisikodaftar_id = det.kelompokfaktorrisikodaftar_id';
                                    $criteria->addCondition('t.faktorrisiko_daftar_aktif is true');
                                    $criteria->order = 'jenisfaktorrisiko.jenisfaktorrisiko_urutan';
                                    if (is_array($faktorrisiko_id)) {
                                        $criteria->addInCondition("faktorrisiko.faktorrisiko_id", $faktorrisiko_id);
                                    } else {
                                        $criteria->addCondition("faktorrisiko.faktorrisiko_id = " . $faktorrisiko_id);
                                    }
                                    $modFaktorRisiko = ASFaktorrisikoDaftarM::model()->findAll($criteria);
                                    
                                    foreach ($modFaktorRisiko as $d) {
                                        $subjektif .= '';
                                        $objektif .= '- '.$d->faktorrisiko_daftar_nama.'<br>';
                                    }
                                }
                                
                                if (!empty($tandagejala_id)) {
                                    $criteria = new CDbCriteria;
                                    $criteria->select = 'tandagejala.tandagejala_id, t.tandagejala_daftar_nama, det.kelompoktandagejaladaftar_id, jenistandagejala.jenistandagejala_nama, jenistandagejala.subjenistandagejala_nama';
                                    $criteria->join = 'JOIN kelompoktandagejaladaftar_m det ON det.tandagejala_daftar_id = t.tandagejala_daftar_id '
                                            . 'JOIN jenistandagejala_m jenistandagejala ON jenistandagejala.jenistandagejala_id = det.jenistandagejala_id '
                                            . 'JOIN tandagejala_m tandagejala ON tandagejala.kelompoktandagejaladaftar_id = det.kelompoktandagejaladaftar_id';
                                    if (is_array($tandagejala_id)) {
                                        $criteria->addInCondition("tandagejala.tandagejala_id", $tandagejala_id);
                                    } else {
                                        $criteria->addCondition("tandagejala.tandagejala_id = " . $tandagejala_id);
                                    }
                                    $criteria->addCondition('t.tandagejala_daftar_aktif is true');
                                    $criteria->order = 't.tandagejala_daftar_nama';

                                    $modTandaGejala = ASTandagejalaDaftarM::model()->findAll($criteria);
                                    
                                    foreach ($modTandaGejala as $d) {
                                        if($d->subjenistandagejala_nama == 'Subjektif'){
                                            $subjektif .= '- '.$d->tandagejala_daftar_nama.'<br>';
                                        } else if($d->subjenistandagejala_nama == 'Objektif'){
                                            $objektif .= '- '.$d->tandagejala_daftar_nama.'<br>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $modDetail->evaluasiaskepdet_subjektif = $subjektif;
                    $modDetail->evaluasiaskepdet_objektif = $objektif;
                    /**-- End Tanda Gejala askep detail --**/
                    
                    $data['form'] .= $this->renderPartial($this->path_view . '_rowEvaluasiDetail', array('modDetail' => $modDetail), true);
                }
            } else {
                $modDetail = new ASImplementasiaskepdetT;
                $data['form'] .= $this->renderPartial($this->path_view . '_rowEvaluasiDetail', array('modDetail' => $modDetail), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Meload data evaluasi detail
     * @param type $evaluasiaskep_id
     */
    public function actionGetEvaluasiDet($evaluasiaskep_id) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {

            $evdet = ASEvaluasiaskepdetT::model()->findAllBySql(
                    'SELECT evaluasiaskepdet_t.*,diagnosakep.*
                    FROM evaluasiaskepdet_t
                    JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = evaluasiaskepdet_t.diagnosakep_id
                    WHERE evaluasiaskepdet_t.evaluasiaskep_id=' . $evaluasiaskep_id);
            $data['form'] = "";
            $evdet_jml = count($evdet);
            if ($evdet_jml > 0) {
                foreach ($evdet AS $i => $modDetail) {
                    $data['form'] .= $this->renderPartial($this->path_view . '_rowEvaluasiDetail', array('modDetail' => $modDetail), true);
                }
            } else {
                $data['form'] .= $this->renderPartial($this->path_view . '_rowEvaluasiDetail', array('modDetail' => $modDetail), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Simpan data evaluasi askep
     * @param type $post
     * @param type $implementasiaskep
     */
    protected function saveEvaluasi($post, $implementasiaskep) {
        $modEvaluasi = new ASEvaluasiaskepT;
        $modEvaluasi->attributes = $post;
        $modEvaluasi->no_evaluasi = MyGenerator::noEvaluasiKeperawatan();
        $modEvaluasi->evaluasiaskep_tgl = MyFormatter::FormatDateTimeForDb($post['evaluasiaskep_tgl']);
        $modEvaluasi->implementasiaskep_id = $implementasiaskep['implementasiaskep_id'];
        $modEvaluasi->create_ruangan = Yii::app()->user->ruangan_id;
        $modEvaluasi->create_time = date('Y-m-d');
        $modEvaluasi->create_loginpemakai_id = Yii::app()->user->id;
        $modEvaluasi->ruangan_id = Yii::app()->user->ruangan_id;
        $modEvaluasi->pegawai_id = $post['pegawai_id'];
        if ($modEvaluasi->validate()) {
            $modEvaluasi->save();
            $this->successSave = $this->successSave && true;
        } else {
            $this->successSave = false;
        }

        return $modEvaluasi;
    }
    
    /**
     * Simpan data evaluasi askep detail
     * @param type $post
     * @param type $ev
     */
    public function saveEvaluasiDetail($post, $ev) {
        foreach ($post as $i => $row) {

            $modEvDetail = new ASEvaluasiaskepdetT;
            $modEvDetail->attributes = $row;
            $modEvDetail->diagnosakep_id = $row['diagnosakep_id'];
            $modEvDetail->evaluasiaskep_id = $ev->evaluasiaskep_id;
            $modEvDetail->evaluasiaskepdet_subjektif = isset($row['evaluasiaskepdet_subjektif']) ? $row['evaluasiaskepdet_subjektif'] : "";
            $modEvDetail->evaluasiaskepdet_objektif = isset($row['evaluasiaskepdet_objektif']) ? $row['evaluasiaskepdet_objektif'] : "";
            $modEvDetail->evaluasiaskepdet_assessment = isset($row['evaluasiaskepdet_assessment']) ? $row['evaluasiaskepdet_assessment'] : "";
            $modEvDetail->evaluasiaskepdet_planning = isset($row['evaluasiaskepdet_planning']) ? $row['evaluasiaskepdet_planning'] : "";
            $modEvDetail->evaluasiaskepdet_hasil = isset($row['evaluasiaskepdet_hasil']) ? $row['evaluasiaskepdet_hasil'] : "";
            $modEvDetail->implementasiaskepdet_id = $ev->implementasiaskep_id;
            
            if ($row['isdiagnosa'] == 1) {
                if ($modEvDetail->validate()) {
                    $modEvDetail->save();
                    $this->successSave = $this->successSave && true;
                } else {
                    $this->successSave = false;
                }
            }
        }
        
        return $modEvDetail;
    }
    
    /**
     * Mencetak data evaluasi askep
     */
        public function actionPrint() {
        $model = ASEvaluasiaskepT::model()->findByPk($_REQUEST['evaluasiaskep_id']);
        $model->attributes = $model;
        $modImplementasi = ASInfoimplementasiaskepV::model()->findByAttributes(array('implementasiaskep_id' => $model->implementasiaskep_id));
        $modPasien = ASInfopasienmasukkamarV::model()->findByAttributes(array('no_pendaftaran' => $modImplementasi->no_pendaftaran));
        if (empty($modPasien)) {
            $modPasien = ASPasienpulangrddanriV::model()->findByAttributes(array('no_pendaftaran' => $modImplementasi->no_pendaftaran));
        }

        $modDetail = new ASEvaluasiaskepdetT;
        $judulLaporan = 'Evaluasi Asuhan Keperawatan';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') { 
            $this->layout = '//layouts/printWindows3';
            $this->render($this->path_view . '_printEvaluasi', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . '_printEvaluasi', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {

            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
            $mpdf->WriteHTML($formatkonten, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
                $mpdf->WriteHTML($this->renderPartial($this->path_view . '_printEvaluasi', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
                $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
            
        }
    }

    /**
     * action ajax select tindakan ke form
     */
    public function actionGetDiagnosa() {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            $returnVal = array();

            $criteria = new CDbCriteria();
            if (isset($_GET['diagnosakep_id'])) {
                if (!empty($_GET['diagnosakep_id'])) {
                    $criteria->addCondition("diagnosakep_id = " . $_GET['diagnosakep_id']);
                }
            }
            $criteria->order = 'diagnosakep_nama';
            $models = ASDiagnosakepM::model()->findAll($criteria);
            if (isset($models)) {

                foreach ($models as $i => $model) {
                    $attributes = $model->attributeNames();

                    foreach ($attributes as $j => $attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }

                    $returnVal[$i]['label'] = $model->diagnosakep_nama;
                    $returnVal[$i]['value'] = $model->diagnosakep_id;
                }
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Meload detail implementasi askep
     * @param type $implementasiaskep_id
     */
    public function actionDetailImpl($implementasiaskep_id = null) {
        $this->layout = "//layouts/iframe";

        $model = ASInfoimplementasiaskepV::model()->findByAttributes(array('implementasiaskep_id' => $implementasiaskep_id));
        $model->attributes = $model;
        $modRencana = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id' => $model->rencanaaskep_id));
        $modPasien = ASInfopasienmasukkamarV::model()->findByAttributes(array('no_pendaftaran' => $model->no_pendaftaran));


        $this->render($this->path_view . '_detailImplementasi', array(
            'model' => $model,
            'modRencana' => $modRencana,
            'modPasien' => $modPasien,
        ));
    }
    
    /**
     * Autocomplete implementasi askep
     */
    public function actionAutocompleteImplementasi() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_implementasi)', strtolower($_GET['term']), true);
            $criteria->limit = 5;
            $models = ASInfoimplementasiaskepV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_implementasi . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
                $returnVal[$i]['value'] = $model->no_implementasi;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Load data pegawai
     */
    public function actionPegawairiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->limit = 5;
            $models = PegawaiM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai . ' - ' . $model->jeniskelamin;
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
                $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    public function actionCetakRiwayat($rencanaaskep_id){
        $this->layout = '//layouts/printWindows';

        $model = new ASInfoevaluasiaskepV;
        $model->rencanaaskep_id = $rencanaaskep_id;
        $judulLaporan = 'Evaluasi Asuhan Keperawatan';
        
        $rencana = InforencanaaskepV::model()->findByAttributes(['rencanaaskep_id'=>$rencanaaskep_id]);
        $pasien = PasienM::model()->findByPk($rencana->pasien_id);
        
        $this->render($this->path_view . '_print_riwayat', array('rencana'=>$rencana, 'pasien' => $pasien, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $_GET['caraPrint']));
        
    }

}
