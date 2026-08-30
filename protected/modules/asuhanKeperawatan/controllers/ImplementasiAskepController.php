<?php

/**
 * Transaksi implementasi askep 
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 */
class ImplementasiAskepController extends MyAuthController {

    protected $successSave = true;
    public $path_view = "asuhanKeperawatan.views.implementasiAskep.";

    /**
     * Fungsi utama load transaksi implementasi
     */
    public function actionIndex($rencanaaskep_id = null) {
        if (isset($_GET['frame'])) {
            $this->layout = "//layouts/iframe";
        }
        $model = new ASImplementasiaskepT;
        $modDetail = new ASImplementasiaskepdetT;
        $modPilih = new ASPilihimplementasiaskepT;
        $modRencana = new ASRencanaaskepT;
        $modPasien = new ASInforencanaaskepV;
        $model->implementasiaskep_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->no_implementasi = "- Otomatis -";

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
//		
        if (isset($_GET['implementasiaskep_id'])) {
            $model = ASImplementasiaskepT::model()->findByPk($_GET['implementasiaskep_id']);

            $modRencana = ASRencanaaskepT::model()->findBySql('SELECT rencanaaskep_t.*,pegawai.nama_pegawai 
			FROM rencanaaskep_t
			JOIN pegawai_m AS pegawai ON pegawai.pegawai_id = rencanaaskep_t.pegawai_id
			WHERE rencanaaskep_id =' . $model->rencanaaskep_id);

            $modPasien = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id' => $model->rencanaaskep_id));
        }

        if (isset($_POST['ASImplementasiaskepT']) && !empty($_POST['ASRencanaaskepT']['rencanaaskep_id'])) {
            
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model = $this->saveImplementasi($_POST['ASImplementasiaskepT'], $_POST['ASRencanaaskepT']);
                if (isset($_POST['ASRencanaaskepdetT'])) {
                    $modDetail = $this->saveImplementasiDetail($_POST['ASRencanaaskepdetT'], $model, $_POST['ASRencanaaskepT']);
                }

                $successSave = $this->successSave;

                if ($successSave) {
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $transaction->commit();
                    $this->redirect(array('index', 'status' => 1, 'implementasiaskep_id' => $model->implementasiaskep_id));
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                    $transaction->rollback();
                }
            } catch (Exception $exc) {
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                $transaction->rollback();
            }
        }
        
        $modRiwayat = new ASInfoimplementasiaskepV();
        if (isset($_GET['ASInfoimplementasiaskepV'])){
            $modRiwayat->attributes = $_GET['ASInfoimplementasiaskepV'];
        }

        $this->render('index', array(
            'model' => $model,
            'modDetail' => $modDetail,
            'modPilih' => $modPilih,
            'modRencana' => $modRencana,
            'modPasien' => $modPasien,
            'successSave' => $successSave,
            'url_batal' => $url_batal,
            'modRiwayat' => $modRiwayat
        )
        );
    }

    /**
     * Fungsi utama load transaksi implementasi
     * @param type $implementasiaskep_id
     */
    public function actionDetail($implementasiaskep_id = null) {
        $this->layout = "//layouts/iframe";
        $model = new ASImplementasiaskepT;
        $modDetail = new ASImplementasiaskepdetT;
        $modPilih = new ASPilihimplementasiaskepT;
        $modRencana = new ASRencanaaskepT;
        $modPasien = new ASInforencanaaskepV;
        $model->implementasiaskep_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->no_implementasi = "- Otomatis -";

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
		
        if (isset($_GET['implementasiaskep_id'])) {
            $model = ASImplementasiaskepT::model()->findByPk($_GET['implementasiaskep_id']);

            $modRencana = ASRencanaaskepT::model()->findBySql('SELECT rencanaaskep_t.*,pegawai.nama_pegawai 
			FROM rencanaaskep_t
			JOIN pegawai_m AS pegawai ON pegawai.pegawai_id = rencanaaskep_t.pegawai_id
			WHERE rencanaaskep_id =' . $model->rencanaaskep_id);

            $modPasien = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id' => $model->rencanaaskep_id));
        }
        
        if (!empty($implementasiaskep_id)) {
            $model = ASImplementasiaskepT::model()->findByPk($implementasiaskep_id);

            $modRencana = ASRencanaaskepT::model()->findBySql('SELECT rencanaaskep_t.*,pegawai.nama_pegawai 
			FROM rencanaaskep_t
			JOIN pegawai_m AS pegawai ON pegawai.pegawai_id = rencanaaskep_t.pegawai_id
			WHERE rencanaaskep_id =' . $model->rencanaaskep_id);

            $modPasien = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id' => $model->rencanaaskep_id));
        }

        $this->render('detail', array(
            'model' => $model,
            'modDetail' => $modDetail,
            'modPilih' => $modPilih,
            'modRencana' => $modRencana,
            'modPasien' => $modPasien,
            'successSave' => $successSave,
            'url_batal' => $url_batal
                )
        );
    }
    
    /**
     * Fungsi untuk cek rencanaaskep_id sudah ada di implementasiaskep_t atau belum
     * @param type $rencanaaskep_id
     */
    public function actionCekRencanaId($rencanaaskep_id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data = null;
            //$data = '';
//            if (isset($rencanaaskep_id)) {
//                $cri = new CDbCriteria();
//                $cri->join = " JOIN evaluasiaskep_t eval ON eval.implementasiaskep_id = t.implementasiaskep_id ";
//                $cri->addCondition(" rencanaaskep_id = ".$rencanaaskep_id." ");
//                $data = ASImplementasiaskepT::model()->find($cri);
//            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    /**
     * Get data pasien berdasarkan rencanaaskep_id
     * @param type $rencanaaskep_id
     */
    public function actionLoadPasien($rencanaaskep_id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data = '';
            if (isset($rencanaaskep_id)) {
                $data = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id' => $rencanaaskep_id));
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    /**
     * Digunakan untuk mendapatkan data tanda gejala
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
     * Digunakan untuk mendapatkan data tujuan
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
     * Digunakan untuk mendapatkan data kriteria hasil
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
					<th></th>
                    <th>Kriteria Hasil</th>
                    <th>IR</th>
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
     * Digunakan untuk mendapatkan data intervensi
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
     * Digunakan untuk mendapatkan data rencana askep
     * @param type $rencanaaskep_id
     */
    public function actionGetRencanaDet($rencanaaskep_id) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {

            $rencanadet = ASRencanaaskepdetT::model()->findAllBySql(
                   'SELECT rencanaaskepdet_t.*,diagnosakep.*
                    FROM rencanaaskepdet_t
                    JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = rencanaaskepdet_t.diagnosakep_id
                    WHERE rencanaaskepdet_t.rencanaaskep_id=' . $rencanaaskep_id);
            $data['form'] = "";
            $data['modPilih'] = "";
            
            $modDetail = new ASPilihrencanaaskepT;
            if (count($rencanadet) > 0) {
                foreach ($rencanadet AS $i => $modDetail) {
                    $pilih = ASPilihrencanaaskepT::model()->findAllBySql(
                            'SELECT pilihrencanaaskep_t.*
                                FROM pilihrencanaaskep_t
                                WHERE pilihrencanaaskep_t.rencanaaskepdet_id =' . $modDetail->rencanaaskepdet_id);
                    foreach ($pilih AS $x => $Pilih) {
                        $modPilih[$i][$x]['pilihrencanaaskep_id'] = $Pilih->pilihrencanaaskep_id;
                        $modPilih[$i][$x]['rencanaaskepdet_id'] = $Pilih->rencanaaskepdet_id;
                        $modPilih[$i][$x]['intervensidet_id'] = $Pilih->intervensidet_id;
                        $modPilih[$i][$x]['kriteriahasildet_id'] = $Pilih->kriteriahasildet_id;
                        $modPilih[$i][$x]['rencanaaskep_ir'] = $Pilih->rencanaaskep_ir;
                        $modPilih[$i][$x]['indikatorimplkepdet_id'] = '';
                        $cekimpldet = PilihrencanaaskepdetT::model()->findAllByAttributes(array('pilihrencanaaskep_id' => $Pilih->pilihrencanaaskep_id));
                        if (!empty($cekimpldet)) {
                            foreach ($cekimpldet as $value) {
                                $modPilih[$i][$x]['indikatorimplkepdet_id'] .= !empty($value->indikatorimplkepdet_id) ? $value->indikatorimplkepdet_id.',' : null;
                            }
                        }
                    }

                    $data['modPilih'] = $modPilih;
                    $data['form'] .= $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modDetail' => $modDetail), true);
                }
            } else {
                $data['form'] .= $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modDetail' => $modDetail), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk mendapatkan data implementasi askep
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
            $data['modPilih'] = "";
            $impldet_jml = count($impldet);
            if ($impldet_jml > 0) {
                foreach ($impldet AS $i => $modDetail) {
                    $pilih = ASPilihimplementasiaskepT::model()->findAllBySql(
                            'SELECT pilihimplementasiaskep_t.*
                            FROM pilihimplementasiaskep_t
                            WHERE pilihimplementasiaskep_t.implementasiaskepdet_id =' . $modDetail->implementasiaskepdet_id);
                    $modPilih = array();
                    foreach ($pilih AS $x => $Pilih) {
                        $modPilih[$i][$x]['pilihimplementasiaskep_id'] = $Pilih->pilihimplementasiaskep_id;
                        $modPilih[$i][$x]['implementasiaskepdet_id'] = $Pilih->implementasiaskepdet_id;
                        $modPilih[$i][$x]['indikatorimplkepdet_id'] = '';
                        $cekimpldet = PilihimplementasiaskepT::model()->findAllByAttributes(array('implementasiaskepdet_id' => $Pilih->implementasiaskepdet_id));
                        if (!empty($cekimpldet)) {
                            foreach ($cekimpldet as $value) {
                                $modPilih[$i][$x]['indikatorimplkepdet_id'] .= !empty($value->indikatorimplkepdet_id) ? $value->indikatorimplkepdet_id.',' : null;
                            }
                        }
                    }

                    $data['modPilih'] = $modPilih;
                    $data['form'] .= $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modDetail' => $modDetail), true);
                }
            } else {
                $modDetail = new ASImplementasiaskepdetT;
                $data['form'] .= $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modDetail' => $modDetail), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Fungsi simpan impementasi 
     * @param type $post
     * @param type $rencanaaskep
     * @return \ASImplementasiaskepT
     */
    protected function saveImplementasi($post, $rencanaaskep) {

        $modImplementasi = new ASImplementasiaskepT;
        $modImplementasi->attributes = $post;
        $modImplementasi->no_implementasi = MyGenerator::noImplementasiKeperawatan();
        $modImplementasi->implementasiaskep_tgl = MyFormatter::FormatDateTimeForDb($post['implementasiaskep_tgl']);
        $modImplementasi->rencanaaskep_id = $rencanaaskep['rencanaaskep_id'];
        $modImplementasi->create_ruangan = Yii::app()->user->ruangan_id;
        $modImplementasi->create_time = date('Y-m-d');
        $modImplementasi->create_loginpemakai_id = Yii::app()->user->id;
        $modImplementasi->ruangan_id = Yii::app()->user->ruangan_id;
        $modImplementasi->pegawai_id = $post['pegawai_id'];
        if ($modImplementasi->validate()) {
            $modImplementasi->save();
            $this->successSave = $this->successSave && true;
        } else {
            $this->successSave = false;
        }

        return $modImplementasi;
    }

    /**
     * Fungsi simpan detail impementasi 
     * @param type $post
     * @param type $impl
     * @return \ASImplementasiaskepdetT
     */
    public function saveImplementasiDetail($post, $impl) {
        foreach ($post as $i => $row) {
            //var_dump($row);
            $modImplDetail = new ASImplementasiaskepdetT;
            $modImplDetail->attributes = $row;
            $modImplDetail->implementasiaskep_id = $impl->implementasiaskep_id;
            $modImplDetail->diagnosakep_id = $row['diagnosakep_id'];
            $modImplDetail->implementasiaskepdet_iskolaborasi = isset($row['iskolaborasi']) ? $row['iskolaborasi'] : NULL;
            $modImplDetail->implementasiaskepdet_ketkolaborasi = isset($row['rencanaaskepdet_ketkolaborasi']) ? $row['rencanaaskepdet_ketkolaborasi'] : "";
            $modImplDetail->rencanaaskepdet_id = $row['rencanaaskepdet_id'];
            
            if ($modImplDetail->validate()) {
                $modImplDetail->save();
                if (!empty($row['alternatifdx_id'])) {
                    $this->savePilihDiagnosaAlternatif($modImplDetail, $row['alternatifdx_id']);
                }
                if (!empty($row['detail'])) {
                    $this->savePilihImplementasi($modImplDetail, $row['detail'], $row['diagnosa']);
                }

                $this->successSave = $this->successSave && true;
            } else {
                $this->successSave = false;
            }
            
        }
        return $modImplDetail;
    }

    /**
     * Fungsi simpan diagnosa alternatif 
     * @param type $impldetail
     * @param type $post
     * @return \ASPilihimplementasiaskepT
     */
    public function savePilihDiagnosaAlternatif($impldetail, $post) {
        foreach ($post as $i => $row) {
            $modImplPilih = new ASPilihimplementasiaskepT;
            $modImplPilih->implementasiaskepdet_id = $impldetail->implementasiaskepdet_id;
            $modImplPilih->alternatifdx_id = $row;
            if ($modImplPilih->validate()) {
                $modImplPilih->save();
                $this->successSave = $this->successSave && true;
            } else {
                $this->successSave = false;
            }
        }
        return $modImplPilih;
    }

    /**
     * Fungsi simpan detail indikatorimplkepdet_id
     * @param type $impldetail
     * @param type $modDetail
     * @param type $modDiagnosa
     * @return \ASPilihimplementasiaskepT
     */
    public function savePilihImplementasi($impldetail, $modDetail, $modDiagnosa) {
        $modImplPilih = array();
        if(!empty($modDiagnosa)){
            foreach ($modDiagnosa as $i => $rowke2) {
                if($rowke2['rencanaaskepdet_id'] == $impldetail->rencanaaskepdet_id){
                    if(!empty($rowke2['intervensidet_id'])){
                        foreach ($modDetail as $j => $row2){
                            if($j == $rowke2['intervensidet_id']){
                                foreach ($row2 as $k => $row3){
                                    foreach ($row3 as $l => $row4){
                                        if (!empty($row4['indikatorimplkepdet_id'])) {  
                                            $modImplPilih = new ASPilihimplementasiaskepT;
                                            $modImplPilih->indikatorimplkepdet_id = $row4['indikatorimplkepdet_id'];
                                            $modImplPilih->implementasiaskepdet_id = $impldetail->implementasiaskepdet_id;
                                            if ($modImplPilih->validate()) {
                                                $modImplPilih->save();
                                                $this->successSave = $this->successSave && true;
                                            } else {
                                                $this->successSave = false;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // die;
        return $modImplPilih;
    }

    /**
     * Fungsi cetak
     */
    public function actionPrint() {
        $model = ASImplementasiaskepT::model()->findByPk($_REQUEST['implementasiaskep_id']);
        $model->attributes = $model;
        $modRencana = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id' => $model->rencanaaskep_id));
        $modPasien = ASInfopasienmasukkamarV::model()->findByAttributes(array('no_pendaftaran' => $modRencana->no_pendaftaran));

        if (empty($modPasien)) {
            $modPasien = ASPasienpulangrddanriV::model()->findByAttributes(array('no_pendaftaran' => $modRencana->no_pendaftaran));
        }

        $modDetail = new ASImplementasiaskepdetT;
        $judulLaporan = 'Implementasi Keperawatan';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
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
     * Get data detail rencana askep
     * @param type $rencanaaskep_id
     * @param type $iskeperawatan
     */
    public function actionDetailRencana($rencanaaskep_id = null, $iskeperawatan = null) {
        $this->layout = "//layouts/iframe";

        $model = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id' => $rencanaaskep_id));
        $model->attributes = $model;


        if ($iskeperawatan == 1) {
            $modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
        } else {
            $modPasien = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
        }

        $this->render($this->path_view . '_detailRencana', array(
            'model' => $model,
            'modPasien' => $modPasien,
        ));
    }

    /**
     * Aksi autocomplete rencana askep
     */
    public function actionAutocompleteRencana() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_rencana)', strtolower($_GET['term']), true);
            $criteria->limit = 5;
            $models = ASInforencanaaskepV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_rencana . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
                $returnVal[$i]['value'] = $model->no_rencana;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Aksi autocomplete pegawai riwayat
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

        $model = new ASInfoimplementasiaskepV;
        $model->rencanaaskep_id = $rencanaaskep_id;
        $judulLaporan = 'Implementasi Asuhan Keperawatan';
        
        $rencana = InforencanaaskepV::model()->findByAttributes(['rencanaaskep_id'=>$rencanaaskep_id]);
        $pasien = PasienM::model()->findByPk($rencana->pasien_id);
        
        $this->render($this->path_view . '_print_riwayat', array('rencana'=>$rencana, 'pasien' => $pasien, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $_GET['caraPrint']));
        
    }
}
