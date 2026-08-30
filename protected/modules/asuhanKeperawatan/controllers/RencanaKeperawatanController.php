<?php
/**
 * issue RSST-2549
 * controller utama rencana keperawatan
 * 
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Andyka Putra <andykaputra@.com>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 */
class RencanaKeperawatanController extends MyAuthController {

    protected $successSave = true;
    public $path_view = "asuhanKeperawatan.views.rencanaKeperawatan.";

    /**
     * Load halaman transaksi rencana keperawatan
     */
    public function actionIndex() {
        if (isset($_GET['frame'])) {
            $this->layout = "//layouts/iframe";
        }
        $model = new ASRencanaaskepT;
        $modDetail = new ASRencanaaskepdetT;
        $modPilih = new ASPilihrencanaaskepT;
        $modPengkajian = new ASPengkajianaskepT;
        $modPasien = new ASInfopengkajianaskepV;
        $modDiagnosis = new DiagnosisaskepT;
        $model->no_rencana = "- Otomatis -";
        $model->rencanaaskep_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
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
        if (isset($_GET['rencanaaskep_id'])) {
            $model = ASRencanaaskepT::model()->findByPk($_GET['rencanaaskep_id']);

            $modPengkajian = ASPengkajianaskepT::model()->findBySql('SELECT pengkajianaskep_t.*,pegawai.nama_pegawai 
			FROM pengkajianaskep_t
			JOIN pegawai_m AS pegawai ON pegawai.pegawai_id = pengkajianaskep_t.pegawai_id
			WHERE pengkajianaskep_id =' . $model->pengkajianaskep_id);
            if ($modPengkajian->iskeperawatan == 1) {
                $modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
            }
            if ($modPengkajian->iskeperawatan == 0) {
                $modPasien = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
            }
        }

        if (isset($_POST['ASRencanaaskepT']) && !empty($_POST['DiagnosisaskepT']['diagnosisaskep_id'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model = $this->saveRencana($_POST['ASRencanaaskepT'], $_POST['DiagnosisaskepT']['diagnosisaskep_id']);
                if (isset($_POST['ASRencanaaskepdetT'])) {
                    $modRencanaDetail = $this->saveRencanaDetail($_POST['ASRencanaaskepdetT'], $model);
                }

                $successSave = $this->successSave;
                
                if ($successSave) {
                    
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $transaction->commit();
                    $this->redirect(array('index', 'status' => 1, 'rencanaaskep_id' => $model->rencanaaskep_id, 'iskeperawatan' => $modPengkajian->iskeperawatan));
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                    $transaction->rollback();
                }
            } catch (Exception $exc) {
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                $transaction->rollback();
            }
        }

        $this->render('index', array(
            'model' => $model,
            'modDetail' => $modDetail,
            'modPilih' => $modPilih,
            'modPengkajian' => $modPengkajian,
            'modPasien' => $modPasien,
            'successSave' => $successSave,
            'url_batal' => $url_batal,
            'modDiagnosis' => $modDiagnosis
        ));
    }

    /**
     * Digunakan untuk mengecek pengkajian
     * @param type $pengkajianaskep_id
     */
    public function actionCekPengkajianId($pengkajianaskep_id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data = '';
            if (isset($pengkajianaskep_id)) {
                $data = ASRencanaaskepT::model()->findByAttributes(array('pengkajianaskep_id' => $pengkajianaskep_id));
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
    
    /**
     * Digunakan untuk mengecek diagnosis
     * @param type $diagnosisaskep_id
     */
    public function actionCekDiagnosis($diagnosisaskep_id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['sudahdipilih'] = "";
            $data['diagnosisaskep_id'] = "";
            if (isset($diagnosisaskep_id)) {
                $sudahada = RencanaaskepT::model()->findByAttributes(array('diagnosisaskep_id' => $diagnosisaskep_id));
                if(empty($sudahada)){
                    $criteria = new CDbCriteria();
                    $criteria->select = " t.*, pen.no_pendaftaran, p.nama_pasien, (CASE WHEN pen.pasienadmisi_id IS NULL THEN r_pa.ruangan_nama ELSE r_pen.ruangan_nama END) as ruangan_nama, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,' ',gelar.gelarbelakang_nama) as nama_lengkap";
                    $criteria->join = " LEFT JOIN pengkajianaskep_t peng ON peng.pengkajianaskep_id = t.pengkajianaskep_id "
                                    . " LEFT JOIN pendaftaran_t pen ON peng.pendaftaran_id = pen.pendaftaran_id "
                                    . " LEFT JOIN pasien_m p ON p.pasien_id = pen.pasien_id "
                                    . " LEFT JOIN pasienadmisi_t pa ON pa.pasienadmisi_id = pen.pasienadmisi_id "
                                    . " LEFT JOIN ruangan_m r_pen ON r_pen.ruangan_id = pen.ruangan_id "
                                    . " LEFT JOIN ruangan_m r_pa ON r_pa.ruangan_id = pa.ruangan_id "
                                    . " LEFT JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id "
                                    . " LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = peg.gelarbelakang_id ";
                    $criteria->addCondition(" t.diagnosisaskep_id = ".$diagnosisaskep_id." ");
                    $modDiagnosa = DiagnosisaskepT::model()->find($criteria);
                    $data['sudahdipilih'] = "belum";
                    $data['diagnosisaskep_id'] = $modDiagnosa->diagnosisaskep_id;
                }else{
                    $criteria = new CDbCriteria();
                    $criteria->select = " t.*, pen.no_pendaftaran, p.nama_pasien, (CASE WHEN pen.pasienadmisi_id IS NULL THEN r_pa.ruangan_nama ELSE r_pen.ruangan_nama END) as ruangan_nama, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,' ',gelar.gelarbelakang_nama) as nama_lengkap";
                    $criteria->join = " LEFT JOIN pengkajianaskep_t peng ON peng.pengkajianaskep_id = t.pengkajianaskep_id "
                                    . " LEFT JOIN pendaftaran_t pen ON peng.pendaftaran_id = pen.pendaftaran_id "
                                    . " LEFT JOIN pasien_m p ON p.pasien_id = pen.pasien_id "
                                    . " LEFT JOIN pasienadmisi_t pa ON pa.pasienadmisi_id = pen.pasienadmisi_id "
                                    . " LEFT JOIN ruangan_m r_pen ON r_pen.ruangan_id = pen.ruangan_id "
                                    . " LEFT JOIN ruangan_m r_pa ON r_pa.ruangan_id = pa.ruangan_id "
                                    . " LEFT JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id "
                                    . " LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = peg.gelarbelakang_id ";
                    $criteria->addCondition(" t.diagnosisaskep_id = ".$diagnosisaskep_id." ");
                    $modDiagnosa = DiagnosisaskepT::model()->find($criteria);
                    $data['sudahdipilih'] = "sudah";
                    $data['diagnosisaskep_id'] = $modDiagnosa->diagnosisaskep_id;
                }
            }
            
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
    
    /**
     * Digunakan untuk mendapatkan data detail diagnosis
     * @param type $diagnosisaskep_id
     */
    public function actionGetDiagnosisDet($diagnosisaskep_id) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {

            $diagnosisdet = ASRencanaaskepdetT::model()->findAllBySql(
                   'SELECT rencanaaskepdet_t.*,diagnosisaskepdet_t.*,diagnosisaskep_t.*
                    FROM rencanaaskepdet_t
                    JOIN diagnosisaskepdet_t ON diagnosisaskepdet_t.diagnosisaskepdet_id = rencanaaskepdet_t.diagnosisaskepdet_id
                    JOIN diagnosisaskep_t ON diagnosisaskepdet_t.diagnosisaskep_id = diagnosisaskep_t.diagnosisaskep_id
                    WHERE diagnosisaskep_t.diagnosisaskep_id=' . $diagnosisaskep_id);
            
            $data['form'] = "";
            $data['modPilih'] = "";

            $modDet = new ASRencanaaskepdetT;
            $modPilihrencana = new PilihrencanaaskepT;

            if (count($diagnosisdet) > 0) {
                $modPilih = [];
                $diagnosisdet = DiagnosisaskepdetT::model()->findAllByAttributes(array('diagnosisaskep_id' => $diagnosisaskep_id));
                foreach ($diagnosisdet AS $i => $modDetail) {
                    $pilih = ASPilihdiagnosisaskepT::model()->findAllBySql(
                            'SELECT pilihdiagnosisaskep_t.*, diagnosisaskepdet_t.*, diagnosisaskep_t.*,diagnosakep_m.diagnosakep_id
                                FROM pilihdiagnosisaskep_t
                                JOIN diagnosisaskepdet_t ON diagnosisaskepdet_t.diagnosisaskepdet_id = pilihdiagnosisaskep_t.diagnosisaskepdet_id
                                JOIN diagnosisaskep_t ON diagnosisaskep_t.diagnosisaskep_id = diagnosisaskepdet_t.diagnosisaskep_id
                                JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = diagnosisaskepdet_t.hasildiagnosa_id
                                WHERE pilihdiagnosisaskep_t.diagnosisaskepdet_id =' . $modDetail->diagnosisaskepdet_id);
                    foreach ($pilih AS $x => $Pilih) {
                        $modPilih[$i][$x]['pilihdiagnosisaskep_id'] = $Pilih->pilihdiagnosisaskep_id;
                        $modPilih[$i][$x]['diagnosisaskepdet_id'] = $Pilih->diagnosisaskepdet_id;
                        $modPilih[$i][$x]['tandagejala_id'] = $Pilih->tandagejala_id;
                        $modPilih[$i][$x]['faktorrisiko_id'] = $Pilih->faktorrisiko_id;
                        $modPilih[$i][$x]['diagnosisaskep_id'] = $Pilih->diagnosisaskep_id;
                        $modPilih[$i][$x]['diagnosakep_id'] = $Pilih->diagnosakep_id;
                    }
                    
                    $data['modPilih'] = $modPilih;
                    $data['form'] .= $this->renderPartial($this->path_view . '_rowDiagnosaDetail', array('modDet' => $modDet, 'modDetail' => $modDetail), true);
                }
            } else {
                $diagnosisdet = DiagnosisaskepdetT::model()->findAllByAttributes(array('diagnosisaskep_id' => $diagnosisaskep_id));
                $modPilih = [];
                if (count($diagnosisdet) > 0) {
                    foreach ($diagnosisdet AS $i => $modDetail) {
                        $pilih = ASPilihdiagnosisaskepT::model()->findAllBySql(
                                'SELECT pilihdiagnosisaskep_t.*, diagnosisaskepdet_t.*, diagnosisaskep_t.*,diagnosakep_m.diagnosakep_id
                                    FROM pilihdiagnosisaskep_t
                                    JOIN diagnosisaskepdet_t ON diagnosisaskepdet_t.diagnosisaskepdet_id = pilihdiagnosisaskep_t.diagnosisaskepdet_id
                                    JOIN diagnosisaskep_t ON diagnosisaskep_t.diagnosisaskep_id = diagnosisaskepdet_t.diagnosisaskep_id
                                    JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = diagnosisaskepdet_t.hasildiagnosa_id
                                    WHERE pilihdiagnosisaskep_t.diagnosisaskepdet_id =' . $modDetail->diagnosisaskepdet_id);
                        foreach ($pilih AS $x => $Pilih) {
                            $modPilih[$i][$x]['pilihdiagnosisaskep_id'] = $Pilih->pilihdiagnosisaskep_id;
                            $modPilih[$i][$x]['diagnosisaskepdet_id'] = $Pilih->diagnosisaskepdet_id;
                            $modPilih[$i][$x]['tandagejala_id'] = $Pilih->tandagejala_id;
                            $modPilih[$i][$x]['faktorrisiko_id'] = $Pilih->faktorrisiko_id;
                            $modPilih[$i][$x]['diagnosisaskep_id'] = $Pilih->diagnosisaskep_id;
                            $modPilih[$i][$x]['diagnosakep_id'] = $Pilih->diagnosakep_id;
                        }

                        $data['modPilih'] = $modPilih;
                        $data['form'] .= $this->renderPartial($this->path_view . '_rowDiagnosaDetail', array('modDet' => $modDet, 'modDetail' => $modDetail, 'modPilihrencana'=>$modPilihrencana), true);
                    }
                }
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
        
    /**
     * Generate baris tindakan berdasarkan intervensi yang dipilih
     */
    public function actionSetTindakan() {
        if (Yii::app()->request->isAjaxRequest) {
            $intervensidet_id = isset($_POST['intervensidet_id']) ? $_POST['intervensidet_id'] : null;
            $diagnosisaskepdet_id = isset($_POST['diagnosisaskepdet_id']) ? $_POST['diagnosisaskepdet_id'] : null;
            $array_id = explode (",", $intervensidet_id);
            $modDetail = new PilihrencanaaskepdetT;
            
            $data['tabel'] = '';
            
            if(!empty($intervensidet_id)){
                $cri = new CDbCriteria();
                if (is_array($array_id)) {
                    $cri->addInCondition("intervensidet_id", $array_id);
                } else {
                    $cri->addCondition("intervensidet_id = '" . $intervensidet_id . "' ");
                }
                $modIntervensi = IntervensidetM::model()->findAll($cri);

                foreach ($modIntervensi as $value){
                    $cekLuaran = IntervensidetM::model()->findByPk($value->intervensidet_id);
                    if (!empty($cekLuaran)) {
                        $cekMaster = IntervensiM::model()->findByPk($cekLuaran->intervensi_id);
                        $impl = ImplementasikepM::model()->findAllByAttributes(array('jenisintervensi_id' => $cekLuaran->jenisintervensi_id));
                        if(!empty($impl)){
                            $data['tabel'] .= "<div class='intervensidet_" . $intervensidet_id . " intervensidet-tr1'>";
                            $data['tabel'] .= CHtml::textField('', $cekLuaran->intervensidet_indikator, array('class' => 'span3 dt-indikator', 'readonly' => true));
                            $data['tabel'] .= '<table width="100%" style=" border: 2px solid #ededed !important;" class="tindakans">';

                            foreach($impl as $val){
                                $no = 0;
                                $data['tabel'] .= '<tr>
                                            <td width="25%" style="background-color:#fff; text-align: center; border: 2px solid #ededed !important;"><label>' . $val->jenistindakan . '</label></td>
                                            <td style="background-color:#fff; text-align: left; border: 2px solid #ededed !important;" class="tdtindakan">';
                                $data['tabel'] .= CHtml::activeHiddenField($modDetail, '[0]diagnosa[' . $value->intervensidet_id . ']diagnosisaskepdet_id[]', array('value' => $diagnosisaskepdet_id, 'class' => 'impls_id'));
                                $data['tabel'] .= CHtml::activeHiddenField($modDetail, '[0]diagnosa[' . $value->intervensidet_id . ']intervensidet_id[]', array('value' => $value->intervensidet_id, 'class' => 'impls'));
                                $semua = IndikatorimplkepdetM::model()->findAllByAttributes(array('indikatorimplkepdet_aktif' => true, 'implementasikep_id' => $val->implementasikep_id));
                                foreach ($semua as $val2){
                                    $data['tabel'] .= CHtml::activeCheckBox($modDetail, '[0][detail][' . $value->intervensidet_id . '][]indikatorimplkepdet_id', array('label'=>$val2->indikatorimplkepdet_indikator,'value'=>$val2->indikatorimplkepdet_id, 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'implsdet')).'<label>'.$val2->indikatorimplkepdet_indikator.'</label>';
                                    $no++;
                                }
                                $data['tabel'] .= '</td>';
                            }
                            $data['tabel'] .= '
                                        </tr>
                                      </table>';
                                $data['tabel'] .= '<br>';
                        }
                    }
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Digunakan untuk load data pasien
     * @param type $pengkajianaskep_id
     */
    public function actionLoadPasien($diagnosisaskep_id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
                    
            $model = DiagnosisaskepT::model()->findByPk($diagnosisaskep_id);
            
            $modaskepkajian=ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id'=>$model->pengkajianaskep_id));

            $data['data'] =$modaskepkajian;
            $data['diagnosa'] =isset($modaskepkajian->diagnosa)?$modaskepkajian->diagnosa:"";
                    
                    
                
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
            $namaModel = new ASRencanaaskepdetT;
            $data['form'] = "";
            if (empty($diagnosakep_id)) {
                echo '<label>Data Tidak Ditemukan</label>';
            } else {
                $data['form'] .= CHtml::activeCheckBoxList($namaModel, '[0]tandagejala_id', CHtml::listData(TandagejalaM::model()->findAllByAttributes(array('tandagejala_aktif' => true, 'diagnosakep_id' => $diagnosakep_id)), 'tandagejala_id', 'tandagejala_indikator'), array('inline' => true, 'style' => 'float: left','onkeyup' => "return $(this).focusNextInputField(event);"));
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
            $namaModel = new ASRencanaaskepdetT;
            $data['form'] = "";
            if (empty($diagnosakep_id)) {
                echo '<label>Data Tidak Ditemukan</label>';
            } else {
                $tujuan = TujuanM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id));
                $data['form'] = '<label>per</label> ' . CHtml::activeTextField($namaModel, '[0]rencanaaskepdet_hari', array('class' => 'span1 integer required')) . CHtml::activeDropDownList($namaModel, '[0]rencanaaskepdet_estimasiwaktu', LookupM::getItemsUrutan('estimasiwaktu'), array('style' => 'width:80px', 'class' => 'required')) . $tujuan['tujuan_nama'];
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
            $namaModel = new ASRencanaaskepdetT;
            $kriteria = new ASKriteriahasildetM;
            $data['form'] = "";
            if (empty($diagnosakep_id)) {
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
                                            <th style="text-align: center">Kriteria Hasil</th>
                                            <th style="text-align: center">IR</th>
                                            <th style="text-align: center">ER</th>
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
                                                '2' => '2', '3' => '3', '4' => '4', '5' => '5',), array('style' => 'width:80px', 'empty' => '--Pilih--')) . '
                                        </td>
                                        <td>
                                            ' . CHtml::dropDownList(
                                                'ASRencanaaskepdetT[0][rencanaaskep_er]', $namaModel->rencanaaskep_er, array('1' => '1',
                                                '2' => '2', '3' => '3', '4' => '4', '5' => '5',), array('style' => 'width:80px', 'empty' => '--Pilih--')) . '
                                        </td>
                                        </tr>';
                }
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
            $namaModel = new ASRencanaaskepdetT;
            $data['form'] = "";
            if (empty($diagnosakep_id)) {
                echo '<label>Data Tidak Ditemukan</label>';
            } else {
                $head = IntervensiM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id));
                $data['form'] = CHtml::activeHiddenField($namaModel, '[0]intervensi_id', array('value' => $head['intervensi_id']));
                $data['form'] .= CHtml::activeTextField($namaModel, '[0]intervensi_nama', array('value' => $head['intervensi_nama'], 'class' => 'span2', 'readonly' => true));
                $data['form'] .= '<br>';
                $data['form'] .= CHtml::activeCheckBoxList($namaModel, '[0]intervensidet_id', CHtml::listData(IntervensidetM::model()->findAllByAttributes(array('intervensidet_aktif' => true, 'intervensi_id' => $head['intervensi_id']), array('order' => 'intervensidet_indikator ASC')), 'intervensidet_id', 'intervensidet_indikator'), (array('inline' => true, 'style' => 'float: left','onkeyup' => "return $(this).focusNextInputField(event);")));
            }
        }
        echo CJSON::encode($data);
        Yii::app()->end();
    }

    /**
     * Digunakan untuk mendapatkan data detail rencana
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
            $modPilih = [];
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
                    $data['form'] .= $this->renderPartial($this->path_view . '_rowRencanaDetail', array('modDetail' => $modDetail), true);
                }
            } else {
                $data['form'] .= $this->renderPartial($this->path_view . '_rowRencanaDetail', array('modDetail' => $modDetail), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk menyimpan data rencana keperawatan
     * @param type $post
     * @param type $diagnosisaskep_id
     * @return \ASRencanaaskepT
     */
    protected function saveRencana($post, $diagnosisaskep_id) {

        $cekDiagnosis = DiagnosisaskepT::model()->findByPk($diagnosisaskep_id);
        $modRencana = new ASRencanaaskepT;
        $modRencana->attributes = $post;
        $modRencana->no_rencana = MyGenerator::noRencanaKeperawatan();
        $modRencana->rencanaaskep_tgl = MyFormatter::FormatDateTimeForDb($post['rencanaaskep_tgl']);
        $modRencana->diagnosisaskep_id = $diagnosisaskep_id;
        $modRencana->pengkajianaskep_id = $cekDiagnosis->pengkajianaskep_id;
        $modRencana->create_ruangan = Yii::app()->user->ruangan_id;
        $modRencana->create_time = date('Y-m-d');
        $modRencana->create_loginpemakai_id = Yii::app()->user->id;
        $modRencana->ruangan_id = Yii::app()->user->ruangan_id;
        $modRencana->pegawai_id = $post['pegawai_id'];
        if ($modRencana->validate()) {
            $modRencana->save();
            $this->successSave = $this->successSave && true;
        } else {
            $this->successSave = false;
        }
        return $modRencana;
    }

    /**
     * Digunakan untuk menyimpan data detail rencana keperawatan
     * @param type $post
     * @param type $rencanaaskep
     * @return \ASRencanaaskepdetT
     */
    public function saveRencanaDetail($post, $rencanaaskep) {
        foreach ($post as $i => $row) {
            //echo "<pre>";var_dump($row);die;
            $modRencanaDetail = new ASRencanaaskepdetT;
            $modRencanaDetail->attributes = $row;
            $modRencanaDetail->rencanaaskep_id = $rencanaaskep->rencanaaskep_id;
            $modRencanaDetail->iskolaborasi = true;
            $modRencanaDetail->diagnosakep_id = $row['diagnosakep_id'];
            $modRencanaDetail->diagnosisaskepdet_id = isset($row['diagnosisaskepdet_id']) ? $row['diagnosisaskepdet_id'] : NULL;
            $modRencanaDetail->tautansdki_slki_det_id = isset($row['tautansdki_slki_det_id']) ? $row['tautansdki_slki_det_id'] : NULL;
            $modRencanaDetail->tujuan_id = isset($row['tujuan_id']) ? $row['tujuan_id'] : NULL;
            $modRencanaDetail->kriteriahasil_id = isset($row['kriteriahasil_id']) ? $row['kriteriahasil_id'] : NULL;
            $modRencanaDetail->intervensi_id = isset($row['intervensi_id']) ? $row['intervensi_id'] : NULL;
            $modRencanaDetail->iskolaborasi = isset($row['iskolaborasi']) ? $row['iskolaborasi'] : NULL;
            $modRencanaDetail->rencanaaskepdet_ketkolaborasi = isset($row['rencanaaskepdet_ketkolaborasi']) ? $row['rencanaaskepdet_ketkolaborasi'] : "";
            $modRencanaDetail->rencanaaskepdet_hari = isset($row['rencanaaskepdet_hari']) ? $row['rencanaaskepdet_hari'] : NULL;
            if ($modRencanaDetail->validate()) {
                $modRencanaDetail->save();
                if (!empty($row['kriteriahasildet_id'])) {
                    $this->savePilihKriteria($modRencanaDetail, $row['kriteriahasildet_id'], $row['rencanaaskep_ir']);
                }

                if (isset($_POST['PilihrencanaaskepdetT']) && !empty($row['intervensidet_id'])) {
                    $this->savePilihIntervensi($modRencanaDetail, $row['intervensidet_id'],$_POST['PilihrencanaaskepdetT']);
                }

                $this->successSave = $this->successSave && true;
            } else {
                $this->successSave = false;
            }
        }
        return $modRencanaDetail;
    }

    /**
     * Digunakan untuk menyimpan data diagnosa alternatif
     * @param type $rencanadetail
     * @param type $post
     * @return \ASPilihrencanaaskepT
     */
    public function savePilihDiagnosaAlternatif($rencanadetail, $post) {
        foreach ($post as $i => $row) {
            $modRencanaDetail = new ASPilihrencanaaskepT;
            $modRencanaDetail->rencanaaskepdet_id = $rencanadetail->rencanaaskepdet_id;
            $modRencanaDetail->alternatifdx_id = $row;

            if ($modRencanaDetail->validate()) {
                $modRencanaDetail->save();
                $this->successSave = $this->successSave && true;
            } else {
                $this->successSave = false;
            }
        }
        return $modRencanaDetail;
    }

    /**
     * Digunakan untuk menyimpan tanda yang dipilih
     * @param type $rencanadetail
     * @param type $post
     * @return \ASPilihrencanaaskepT
     */
    public function savePilihTanda($rencanadetail, $post) {
        foreach ($post as $i => $row) {
            $modRencanaDetail = new ASPilihrencanaaskepT;
            $modRencanaDetail->rencanaaskepdet_id = $rencanadetail->rencanaaskepdet_id;
            $modRencanaDetail->tandagejala_id = $row;

            if ($modRencanaDetail->validate()) {
                $modRencanaDetail->save();
                $this->successSave = $this->successSave && true;
            } else {
                $this->successSave = false;
            }
        }
        return $modRencanaDetail;
    }

    /**
     * Digunakan untuk menyimpan kriteria yang dipilih
     * @param type $rencanadetail
     * @param type $kriteria
     * @param type $ir
     * @return \ASPilihrencanaaskepT
     */
    public function savePilihKriteria($rencanadetail, $kriteria, $ir) {
        $modRencanaDetail = array();
        foreach ($kriteria as $i => $row) {
            if ($row > 0) {
                $modRencanaDetail = new ASPilihrencanaaskepT;
                $modRencanaDetail->rencanaaskepdet_id = $rencanadetail->rencanaaskepdet_id;
                $modRencanaDetail->kriteriahasildet_id = $row;
                $modRencanaDetail->rencanaaskep_ir = isset($ir[$i]) ? $ir[$i] : NULL;
                $modRencanaDetail->rencanaaskep_er = NULL;
                
                if ($modRencanaDetail->validate()) {
                    $modRencanaDetail->save();
                    $this->successSave = $this->successSave && true;
                } else {
                    $this->successSave = false;
                }
            }
        }

        return $modRencanaDetail;
    }

    /**
     * Digunakan untuk menyimpan data intervensi yang dipilih
     * @param type $rencanadetail
     * @param type $post
     * @param type $pilihdet
     * @return \ASPilihrencanaaskepT
     */
    public function savePilihIntervensi($rencanadetail, $post, $pilihdet) {
        $modRencanaDetail = array();
        foreach ($pilihdet as $i => $row) {
            if(!empty($row['diagnosa'])){
                foreach ($row['diagnosa'] as $i => $rowke2) {
                    if($rowke2['diagnosisaskepdet_id'] == $rencanadetail->diagnosisaskepdet_id){
                        if(!empty($rowke2['intervensidet_id'])){
                            $modRencanaDetail = new ASPilihrencanaaskepT;
                            $modRencanaDetail->attributes = $row;
                            $modRencanaDetail->rencanaaskepdet_id = $rencanadetail->rencanaaskepdet_id;
                            $modRencanaDetail->intervensidet_id = $rowke2['intervensidet_id'];
                            
                            if ($modRencanaDetail->validate()) {
                                $modRencanaDetail->save();
                                foreach ($row['detail'] as $j => $row2){
                                    if($j == $rowke2['intervensidet_id']){
                                        foreach ($row2 as $k => $row3){    
                                            foreach ($row3 as $l => $row4){      
                                                if (!empty($row4['indikatorimplkepdet_id'])) {                  
                                                    $modPilihDetail = new PilihrencanaaskepdetT;
                                                    $modPilihDetail->pilihrencanaaskep_id = $modRencanaDetail->pilihrencanaaskep_id;
                                                    $modPilihDetail->intervensidet_id = $modRencanaDetail->intervensidet_id;
                                                    $modPilihDetail->indikatorimplkepdet_id = $row4['indikatorimplkepdet_id'];
                                                    if ($modPilihDetail->validate()) {
                                                        $modPilihDetail->save();
                                                        $this->successSave = $this->successSave && true;
                                                    }else{
                                                        $this->successSave = false;
                                                    }
                                                }
                                            }    
                                        }
                                    }
                                }
                            } else {
                                $this->successSave = false;
                            }
                        }
                    }
                }
            }
        }
        return $modRencanaDetail;
    }

    /**
     * Digunakan untuk menyimpan rencana yang dipilih
     * @param type $row
     * @param type $rencanaaskepdet
     * @param type $kriteria
     * @return \ASPilihrencanaaskepT
     */
    protected function savePilihRencana($row, $rencanaaskepdet, $kriteria) {

        $modPilihRencana = new ASPilihrencanaaskepT;
        $modPilihRencana->attributes = $row;
        $modPilihRencana->rencanaaskepdet_id = $rencanaaskepdet['rencanaaskepdet_id'];
        $modPilihRencana->tandagejala_id = $row['tandagejala_id'];
        $modPilihRencana->intervensidet_id = $row['intervensidet_id'];
        $modPilihRencana->kriteriahasildet_id = $row['kriteriadet_id'];
        $modPilihRencana->rencanaaskep_ir = isset($kriteria['rencanaaskep_ir']) ? $kriteria['rencanaaskep_ir'] : NULL;
        $modPilihRencana->rencanaaskep_er = isset($kriteria['rencanaaskep_er']) ? $kriteria['rencanaaskep_er'] : NULL;
        if ($modPilihRencana->validate()) {
            $modPilihRencana->save();
            $this->successSave = $this->successSave && true;
        } else {
            $this->successSave = false;
        }

        return $modPilihRencana;
    }

    /**
     * Digunakan untuk mencetak data
     */
    public function actionPrint() {
        $model = ASRencanaaskepT::model()->findByPk($_REQUEST['rencanaaskep_id']);
        $model->attributes = $model;
        $modPengkajian = ASPengkajianaskepT::model()->findByPk($model->pengkajianaskep_id);

        if ($modPengkajian->iskeperawatan == 1) {
            $modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
        }
        if ($modPengkajian->iskeperawatan == 0) {
            $modPasien = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
        }

        $modDetail = new ASRencanaaskepdetT;
        $judulLaporan = 'Rencana Keperawatan';
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
     * Digunakan untuk mendapatkan data penunjang
     * @param type $pengkajianaskep_id
     */
    public function actionGetPenunjang($pengkajianaskep_id) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $penunjang = ASDatapenunjangT::model()->findAllByAttributes(array('pengkajianaskep_id' => $pengkajianaskep_id));
            $data['form'] = "";

            if (count($penunjang) > 0) {
                foreach ($penunjang AS $i => $modPenunjang) {
                    $data['form'] .= $this->renderPartial($this->path_view . '_rowPenunjang', array('modPenunjang' => $modPenunjang), true);
                }
            } else {
                $data['form'] .= $this->renderPartial($this->path_view . '_rowPenunjang', array('modPenunjang' => $modPenunjang), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
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
     * Digunakan untuk mendapatkan data diagnosa
     * @param type $diagnosakep_id
     */
    public function actionGetDiagnosaRow($diagnosakep_id = null) {
        if (Yii::app()->request->isAjaxRequest) {
            $modRencanaDet = new ASRencanaaskepdetT;
            $data['form'] = "";
            $diagnosa = ASDiagnosakepM::model()->findByPk($diagnosakep_id);
            $data['form'] .= "<div class='diagdetail'>";
            $data['form'] .= "<br>";
            $data['form'] .= '<strong>Batasan Karakteristik</strong>';
            $data['form'] .= "<br>";
            $bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
            if (count($bk_head)) {
                foreach ($bk_head as $i => $bk) {
                    $data['form'] .= "<ul class='spasi1'>";
                    $data['form'] .= '<li >' . $bk->bataskarakteristik_nama . '</li>';
                    $bk_tail = BataskarakteristikdetM::model()->findAllByAttributes(array('bataskarakteristikdet_aktif' => true, 'bataskarakteristik_id' => $bk->bataskarakteristik_id));
                    if (count($bk_tail)) {
                        foreach ($bk_tail as $i => $bkd) {
                            $data['form'] .= '<li >' . $bkd->bataskarakteristikdet_indikator . '</li>';
                        }
                    } else {
                        $data['form'] .= "<ul class='spasi1'>";
                        $data['form'] .= '<li> Data tidak ditemukan. </li>';
                        $data['form'] .= "</ul>";
                    }
                    $data['form'] .= "</ul>";
                }
            } else {
                $data['form'] .= "<ul class='spasi1'>";
                $data['form'] .= '<li> Data tidak ditemukan. </li>';
                $data['form'] .= "</ul>";
            }

            $data['form'] .= "<br>";

            $data['form'] .= '<strong>Faktor Risiko</strong>';
            $data['form'] .= "<br>";
            $bk_head = FaktorrisikoM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
            if (count($bk_head)) {
                foreach ($bk_head as $i => $bk) {
                    $data['form'] .= "<ul class='spasi1'>";
                    $data['form'] .= '<li >' . $bk->faktorrisiko_nama . '</li>';
                    $bk_tail = FaktorrisikodetM::model()->findAllByAttributes(array('faktorrisikodet_aktif' => true, 'faktorrisiko_id' => $bk->faktorrisiko_id));
                    if (count($bk_tail)) {
                        foreach ($bk_tail as $i => $bkd) {
                            $data['form'] .= '<li >' . $bkd->faktorrisikodet_indikator . '</li>';
                        }
                    } else {
                        $data['form'] .= "<ul class='spasi1'>";
                        $data['form'] .= '<li> Data tidak ditemukan. </li>';
                        $data['form'] .= "</ul>";
                    }
                    $data['form'] .= "</ul>";
                }
            } else {
                $data['form'] .= "<ul class='spasi1'>";
                $data['form'] .= '<li> Data tidak ditemukan. </li>';
                $data['form'] .= "</ul>";
            }

            $data['form'] .= "<br>";

            $data['form'] .= '<strong>Faktor Yang Berhubungan</strong>';
            $data['form'] .= "<br>";
            $bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
            if (count($bk_head)) {
                foreach ($bk_head as $i => $bk) {
                    $data['form'] .= "<ul class='spasi1'>";
                    $data['form'] .= '<li >' . $bk->faktorhub_nama . '</li>';
                    $bk_tail = FaktorhubdetM::model()->findAllByAttributes(array('faktorhubdet_aktif' => true, 'faktorhub_id' => $bk->faktorhub_id));
                    if (count($bk_tail)) {
                        foreach ($bk_tail as $i => $bkd) {
                            $data['form'] .= '<li >' . $bkd->faktorhubdet_indikator . '</li>';
                        }
                    } else {
                        $data['form'] .= "<ul class='spasi1'>";
                        $data['form'] .= '<li> Data tidak ditemukan. </li>';
                        $data['form'] .= "</ul>";
                    }
                    $data['form'] .= "</ul>";
                }
            } else {
                $data['form'] .= "<ul class='spasi1'>";
                $data['form'] .= '<li> Data tidak ditemukan. </li>';
                $data['form'] .= "</ul>";
            }
            $data['form'] .= "<br>";

            $data['form'] .= '<strong>Diagnosa Alternatif</strong>';
            $data['form'] .= "<br>";
            $data['form'] .= CHtml::activeCheckBoxList($modRencanaDet, '[0]alternatifdx_id', CHtml::listData(AlternatifdxM::model()->findAllByAttributes(array('alternatifdx_aktif' => true, 'diagnosakep_id' => $diagnosakep_id)), 'alternatifdx_id', 'alternatifdx_nama'));

            $data['form'] .= "</div>";
        }
        echo CJSON::encode($data);
        Yii::app()->end();
    }

    /**
     * Digunakan untuk menampilkan data detail pengkajian
     * @param type $pengkajianaskep_id
     */
    public function actionDetailPengkajian($pengkajianaskep_id = null) {
        $this->layout = "//layouts/iframe";

        $modPengkajian = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $pengkajianaskep_id));

        $modAwalKritis = null;
        $modAwalKeperawatan = null;
        $modAwalKebidanan = null;
        $modAwalMedis = null;
        if (!empty($modPengkajian->asesmen_awal_medis_id)) {
            $modAwalMedis = AsesmenAwalMedisT::model()->findByPk($modPengkajian->asesmen_awal_medis_id);
        }
        if ($modPengkajian->instalasi_id == Params::INSTALASI_ID_ICU) {
            if (!empty($modPengkajian->asesmenawalkritis_id)) {
                $modAwalKritis = AsesmenawalkritisT::model()->findByPk($modPengkajian->asesmenawalkritis_id);
            }
        } else if ($modPengkajian->ruangan_id == Params::RUANGAN_ID_VK) {
            if (!empty($modPengkajian->asesmenawalkebidanan_bidan_id)) {
                $modAwalKebidanan = AsesmenawalkebidananBidanT::model()->findByPk($modPengkajian->asesmenawalkebidanan_bidan_id);
            }
        } else {
            if (!empty($modPengkajian->asesmen_awal_keperawatan_id)) {
                $modAwalKeperawatan = AsesmenAwalKeperawatanT::model()->findByPk($modPengkajian->asesmen_awal_keperawatan_id);
            }
        }
        $penunjang = new ASDatapenunjangT;
        $criteria = new CDbCriteria();
        $criteria->addCondition('pengkajianaskep_id =' . $modPengkajian->pengkajianaskep_id);
        $modPenunjang = new CActiveDataProvider($penunjang, array(
            'criteria' => $criteria,
        ));

        if ((!empty($modPemeriksaanFisik->gcs_eye)) && (!empty($modPemeriksaanFisik->gcs_verbal)) && (!empty($modPemeriksaanFisik->gcs_motorik))) {
            $modPemeriksaanFisik->namaGCS = $modPemeriksaanFisik->gcs_eye + $modPemeriksaanFisik->gcs_verbal + $modPemeriksaanFisik->gcs_motorik;
        }

        $this->render($this->path_view . '_detail', array(
            'modPengkajian' => $modPengkajian,
            'modAwalMedis' => $modAwalMedis,
            'modAwalKeperawatan' => $modAwalKeperawatan,
            'modAwalKritis' => $modAwalKritis,
            'modAwalKebidanan' => $modAwalKebidanan,
            'modPenunjang' => $modPenunjang
        ));
    }
    
    /**
     * Digunakan untuk menampilkan data detail diagnosis
     * @param type $diagnosisaskep_id
     */
    public function actionDetailDiagnosisKep($diagnosisaskep_id = null) {
        $this->layout = "//layouts/iframe";

        $model = DiagnosisaskepT::model()->findByAttributes(array('diagnosisaskep_id' => $diagnosisaskep_id));
        $modDet = DiagnosisaskepdetT::model()->findByAttributes(array('diagnosisaskep_id' => $diagnosisaskep_id));
        
       

        $this->render($this->path_view . '_detail', array(
            'model' => $model,
            'modDet' => $modDet
        ));
    }

    /**
     * Digunakan untuk menampilkan data detail pengkajian kebidanan
     */
    public function actionDetailPengkajianKeb() {
        $this->layout = "//layouts/iframe";
        $modPengkajian = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $_GET['pengkajianaskep_id']));
        $modPengkajian->attributes = $modPengkajian;

        $anamnesa = new ASAnamnesaT;
        $criteria = new CDbCriteria();
        $criteria->addCondition('anamesa_id =' . $modPengkajian->anamesa_id);
        $modAnamnesa = ASAnamnesaT::model()->find($criteria);

        $periksafisik = new ASPemeriksaanfisikT;
        $criteria = new CDbCriteria();
        $criteria->addCondition('pemeriksaanfisik_id =' . $modPengkajian->pemeriksaanfisik_id);
        $modPemeriksaanFisik = ASPemeriksaanfisikT::model()->find($criteria);
        $modPemeriksaanGambar = ASPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $modPemeriksaanFisik->pendaftaran_id));
        $modGambarTubuh = new ASGambartubuhM();
        $modBagianTubuh = new ASBagiantubuhM();

        if ((!empty($modPemeriksaanFisik->gcs_eye)) && (!empty($modPemeriksaanFisik->gcs_verbal)) && (!empty($modPemeriksaanFisik->gcs_motorik))) {
            $modPemeriksaanFisik->namaGCS = $modPemeriksaanFisik->gcs_eye + $modPemeriksaanFisik->gcs_verbal + $modPemeriksaanFisik->gcs_motorik;
        }

        $penunjang = new ASDatapenunjangT;
        $criteria = new CDbCriteria();
        $criteria->addCondition('pengkajianaskep_id =' . $modPengkajian->pengkajianaskep_id);
        $modPenunjang = new CActiveDataProvider($penunjang, array(
            'criteria' => $criteria,
        ));

        $perkawinan = new ASRiwayatperkawinanR;
        $persalinan = new ASRiwayatpersalinanR;
        $criteria = new CDbCriteria();
        $criteria->addCondition('anamesa_id =' . $modPengkajian->anamesa_id);

        $modPerkawinan = new CActiveDataProvider($perkawinan, array(
            'criteria' => $criteria,
        ));
        $modPersalinan = new CActiveDataProvider($persalinan, array(
            'criteria' => $criteria,
        ));


        $this->render($this->path_view . '_detailPengkajianKeb', array(
            'modPengkajian' => $modPengkajian,
            'modAnamnesa' => $modAnamnesa,
            'modPemeriksaanFisik' => $modPemeriksaanFisik,
            'modPemeriksaanGambar' => $modPemeriksaanGambar,
            'modGambarTubuh' => $modGambarTubuh,
            'modBagianTubuh' => $modBagianTubuh,
            'modPenunjang' => $modPenunjang,
            'modPerkawinan' => $modPerkawinan,
            'modPersalinan' => $modPersalinan,
        ));
    }

    /**
     * Autocomplete pengkajian keperawatan
     */
    public function actionAutocompletepengkajiankep() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_pengkajian)', strtolower($_GET['term']), true);
            $criteria->limit = 5;
            $models = ASInfopengkajianaskepV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pengkajian . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
                $returnVal[$i]['value'] = $model->no_pengkajian;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete pengkajian kebidanan
     */
    public function actionAutocompletepengkajiankeb() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_pengkajian)', strtolower($_GET['term']), true);
            $criteria->limit = 5;
            $models = ASInfopengkajiankebidananV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pengkajian . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
                $returnVal[$i]['value'] = $model->no_pengkajian;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Pegawai Riwayat
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

    /**
     * Autocomplete Diagnosa
     */
    public function actionAutocompleteDiagnosisPerawat() {
        if (Yii::app()->request->isAjaxRequest) {
            $term = strtolower(trim($_GET['term']));
            
            $criteria = new CDbCriteria();
            $condition = "LOWER(no_diagnosisaskep) LIKE '%" . $term . "%' ";
            $criteria->addCondition($condition);
            $criteria->limit = 5;
            $models = DiagnosisaskepT::model()->findAll($criteria);
            $returnVal = array();

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_diagnosisaskep;
                $returnVal[$i]['value'] = $model->diagnosisaskep_id;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Autocomplete Diagnosa
     */
    public function actionAutocompleteDiagnosa() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $term = strtolower(trim($_GET['term']));
            $condition = "LOWER(diagnosakep_kode) LIKE '%" . $term . "%' OR LOWER(diagnosakep_nama) LIKE '%" . $term . "%' ";
            $criteria->addCondition($condition);
            $criteria->limit = 5;
            $models = ASDiagnosakepM::model()->findAll($criteria);
            $returnVal = array();

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->diagnosakep_kode . ' - ' . $model->diagnosakep_nama;
                $returnVal[$i]['value'] = $model->diagnosakep_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Digunakan untuk load diagnosa medis
     * @param type $pasien_id
     * @param type $pendaftaran_id
     */
    public function actionLoadDiagnosaMedis($pasien_id, $pendaftaran_id) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['diagnosa_id'] = "";
            $data['diagnosa_nama'] = "";

            $modPasienMorb = ASPasienmorbiditasT::model()->findAllByAttributes(array('pasien_id' => $pasien_id, 'pendaftaran_id' => $pendaftaran_id, 'kelompokdiagnosa_id' => 2));
//			if (!empty($modPasienMorb->diagnosa_id)) {
//				$modDiagnosa = ASDiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modPasienMorb->diagnosa_id));
//			} else {
//				$modDiagnosa = array();
//			}

            foreach ($modPasienMorb as $i => $detail) {

                $modDiagnosa = ASDiagnosaM::model()->findByAttributes(array('diagnosa_id' => $detail->diagnosa_id));

                if ($i == 0) {
                    $data['diagnosa_id'] = $modDiagnosa->diagnosa_id;
                    $data['diagnosa_nama'] = $modDiagnosa->diagnosa_nama;
                } else {
                    $data['diagnosa_id'] .= ',' . $modDiagnosa->diagnosa_id;
                    $data['diagnosa_nama'] .= ',' . $modDiagnosa->diagnosa_nama;
                }
            }
//			if (count($modDiagnosa) > 0) {
//				$data['diagnosa_id'] .= $modDiagnosa->diagnosa_id;
//				$data['diagnosa_nama'] .= $modDiagnosa->diagnosa_nama;
//			}

            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    
    /**
     * Load halaman transaksi rencana keperawatan
     */
    public function actionDetail() {
        $this->layout = "//layouts/iframe";
        
        $model = new ASRencanaaskepT;
        $modDetail = new ASRencanaaskepdetT;
        $modPilih = new ASPilihrencanaaskepT;
        $modPengkajian = new ASPengkajianaskepT;
        $modPasien = new ASInfopengkajianaskepV;
        $modDiagnosis = new DiagnosisaskepT;
        $model->no_rencana = "- Otomatis -";
        $model->rencanaaskep_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
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
		
        if (isset($_GET['rencanaaskep_id'])) {
            $model = ASRencanaaskepT::model()->findByPk($_GET['rencanaaskep_id']);

            $modPengkajian = ASPengkajianaskepT::model()->findBySql('SELECT pengkajianaskep_t.*,pegawai.nama_pegawai 
			FROM pengkajianaskep_t
			JOIN pegawai_m AS pegawai ON pegawai.pegawai_id = pengkajianaskep_t.pegawai_id
			WHERE pengkajianaskep_id =' . $model->pengkajianaskep_id);
            if ($modPengkajian->iskeperawatan == 1) {
                $modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
            }
            if ($modPengkajian->iskeperawatan == 0) {
                $modPasien = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
            }
        }

        $this->render('detail', array(
            'model' => $model,
            'modDetail' => $modDetail,
            'modPilih' => $modPilih,
            'modPengkajian' => $modPengkajian,
            'modPasien' => $modPasien,
            'successSave' => $successSave,
            'url_batal' => $url_batal,
            'modDiagnosis' => $modDiagnosis
        ));
    }

}
