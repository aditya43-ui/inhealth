<?php

/**
 * Digunakan untuk mengakses transaksi OPPE Clinical Care
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @packag application.modules.asuhanKeperawatan
 * @subpackage controllers
 * @category controller
 */
class OppeclinicalcareTController extends MyAuthController {

    public $defaultAction = 'index';
    public $path_view = 'asuhanKeperawatan.views.oppeClinicalCareT.';
    public $init = '';
    public $simpan = false;

    /**
     * Digunakan untuk mengakses halaman transaksi OPPE Clinical Care
     */
    public function actionIndex() {
        $this->layout = '//layouts/iframe';
        $model = new ASOppeclinicalcareT;
        $modDet = new OppeclinicalcareT;

        //Cek Ka Unit
        $pegawailogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

        $criteria = new CDbCriteria;
        $criteria->addCondition("t.kepalaunitpeg_id IS NOT NULL");
        $criteria->addCondition("t.unitkerja_aktif IS TRUE");
        $cekKepalaUnit = UnitkerjaM::model()->findAll($criteria);
        $kepalaunit = array();

        foreach ($cekKepalaUnit as $value):
            $kepalaunit[] = $value->kepalaunitpeg_id;
        endforeach;

        $criteria2 = new CDbCriteria;
        $criteria2->addInCondition("t.pegawai_id", $kepalaunit);
        $criteria2->addCondition("t.pegawai_id = " . $pegawailogin->pegawai_id);
        $modPegawai = PegawaiM::model()->find($criteria2);

        if (!empty($modPegawai)) {
            $is_kepalaunit = 1;
            $unitkerja_id = $modPegawai->unitkerja_id;
            $pegawai_id = $modPegawai->pegawai_id;
        } else {
            $is_kepalaunit = 0;
            $unitkerja_id = "";
            $pegawai_id = "";
        }
        $model->ka_unitkerja_id = $pegawai_id;
        $model->unitkerja_id = $unitkerja_id;

        $crit = new CDbCriteria();
        $crit->addCondition("nama_indikator ilike '%Clinical Care%'");
        $crit->addCondition("is_aktif IS TRUE");
        $cekIndikator = IndikatoroppekeperawatanM::model()->find($crit);
        $model->indikatoroppekeperawatan_id = !empty($cekIndikator) ? $cekIndikator->indikatoroppekeperawatan_id : '';
        $model->indikatoroppekeperawatan_nama = !empty($cekIndikator) ? $cekIndikator->nama_indikator : '';

        // Uncomment the following line if AJAX validation is needed
        if (isset($_POST['OppeclinicalcareT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['OppeclinicalcareT'] as $p) {
                    $modDet = new OppeclinicalcareT;
                    $modDet->attributes = $p;
                    $modDet->ka_unitkerja_id = Yii::app()->user->getState('pegawai_id');
                    $modDet->unitkerja_id = Yii::app()->user->getState('unitkerja_id');
                    $modDet->indikatoroppekeperawatan_id = !empty($cekIndikator) ? $cekIndikator->indikatoroppekeperawatan_id : '';
                    $modDet->bulan_clinicalcare = MyFormatter::formatDateTimeForDb('01 ' . $p['bulan_clinicalcare']);
                    $modDet->prosentase_clinicalcare = str_replace(",", ".", $p['prosentase_clinicalcare']);
                    if (!empty($p['oppeclinicalcare_id'])) {
                        $modDet->update_time = date('Y-m-d H:i:s');
                        $modDet->update_loginpemakai_id = Yii::app()->user->id;
                    } else {
                        $modDet->create_time = date('Y-m-d H:i:s');
                        $modDet->create_loginpemakai_id = Yii::app()->user->id;
                    }
                    if ($modDet->save()) {
                        $this->simpan = true;
                    } else {
                        $this->simpan = false;
                    }
                }

                if ($this->simpan == true) {
                    $transaction->commit();
                    Yii::app()->user->setFlash("success", "Data berhasil Disimpan");
                    $this->redirect(array('index'));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash("error", "Data Gagal Disimpan");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modDet' => $modDet
        ));
    }

    /**
     * Digunakan untuk load data kehadiran da di append di tabel
     */
    public function actionGetClinicalCare() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post

            $bulan_clinicalcare = $_POST['bulan_clinicalcare'];
            $pegawai_id = $_POST['pegawai_id'];
            $nama_pegawai = $_POST['nama_pegawai'];
            $nip = $_POST['nip'];
            $unitkerja_id = $_POST['perawat_unitkerja_id'];
            $namaunitkerja = $_POST['namaunitkerja'];
            $prosentase_clinicalcare = $_POST['prosentase_clinicalcare'];

            //set new model
            $modDet = new OppeclinicalcareT();

            $modDet->bulan_clinicalcare = $bulan_clinicalcare;
            $modDet->pegawai_id = $pegawai_id;
            $modDet->nama_perawat = $nama_pegawai;
            $modDet->nip_perawat = $nip;
            $modDet->perawat_unitkerja_id = $unitkerja_id;
            $modDet->namaunitkerja = $namaunitkerja;
            $modDet->prosentase_clinicalcare = $prosentase_clinicalcare;

            $return = $this->renderPartial($this->path_view . "/_rowClinicalCare", array('model' => $modDet, 'i' => 1), true);

            $data['return'] = $return;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Autocomplete Perawat
     */
    public function actionAutoCompleteGetPerawat() {
        if (Yii::app()->request->isAjaxRequest) {

            $term = isset($_GET['term'])?$_GET['term']:null;

            $criteria = new CDbCriteria;
            $criteria->select = 't.*, jabatan_m.jabatan_nama, unitkerja_m.namaunitkerja';
            $criteria->join = 'LEFT JOIN jabatan_m ON jabatan_m.jabatan_id = t.jabatan_id '
                    . 'JOIN unitkerja_m ON unitkerja_m.unitkerja_id = t.unitkerja_id';

            if (!empty($term)){
                $criteria->compare('LOWER(t.nama_pegawai)', strtolower($_GET['term']), true);
            }
            $criteria->compare('LOWER(jabatan_m.jabatan_nama)', strtolower('perawat'), false);
            $criteria->addCondition('pegawai_aktif IS TRUE');
            $criteria->order = 'nama_pegawai ASC';
            $criteria->limit = 10;
            $modPegawai = ASPegawaiM::model()->findAll($criteria);

            foreach ($modPegawai as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['pegawai_id'] = $model['pegawai_id'];
                $returnVal[$i]['nama_pegawai'] = $model['nama_pegawai'];
                $returnVal[$i]['nomorindukpegawai'] = $model['nomorindukpegawai'];
                $returnVal[$i]['unitkerja_id'] = $model['unitkerja_id'];
                $returnVal[$i]['namaunitkerja'] = $model['namaunitkerja'];
                $returnVal[$i]['label'] = $model['nama_pegawai'];
                $returnVal[$i]['value'] = $model['pegawai_id'];
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Load Perawat jika ada perawat dengan bulan yang sama maka tidak bisa dimasukkan 
     */
    public function actionGetPerawat() {
        if (Yii::app()->request->isAjaxRequest) {
            $term = isset($_GET['term'])?$_GET['term']:null;
            $pegawai_id = isset($_POST['pegawai_id'])?$_POST['pegawai_id']:null;
            $bulan = isset($_POST['bulan'])?$_POST['bulan']:null;
            $bulan_pencatatan = date('m', strtotime(MyFormatter::formatMonthForDb($bulan)));
            $tahun_pencatatan = date('Y', strtotime(MyFormatter::formatMonthForDb($bulan)));
            
            if ($bulan_pencatatan >= 1 && $bulan_pencatatan <= 6) {
                $cari_bulan = array('01', '02', '03', '04', '05', '06');
            } else {
                $cari_bulan = array('07', '08', '09', '10', '11', '12');
            }
            
            $cri = new CDbCriteria();
            $cri->addCondition("pegawai_id = ".$pegawai_id);
            $cri->addInCondition("extract(month from bulan_clinicalcare)", $cari_bulan);
            $cri->addCondition("extract(year from bulan_clinicalcare) = ".$tahun_pencatatan);
            $modClinical  = OppeclinicalcareT::model()->findAll($cri); 
            $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
            $modUnit = UnitkerjaM::model()->findByPk($modPegawai->unitkerja_id);
            
            $tr = "";
            $tfoot = "";
            if (!empty($modClinical)) { 
                $i = 1;
                $hitung_skor = 0;
                foreach($modClinical as $det){
                    $tr .= "<tr>";
                    $tr .= "<td style='text-align: center'>".$i++."</td>";
                    $tr .= "<td>".date('M Y', strtotime($det['bulan_clinicalcare'])) ."</td>";
                    $tr .= "<td>".$det['nama_perawat']."</td>";
                    $tr .= "<td style='text-align: center'>".$det['prosentase_clinicalcare']." % </td>";
                    $tr .= "</tr>";
                    $hitung_skor += $det['prosentase_clinicalcare'];
                }
                
                if($hitung_skor > 100){
                    $rata = 100;
                } else {
                    $rata = $hitung_skor;
                }
                $tfoot .= "<tr>";
                $tfoot .= "<td colspan=3 style='text-align: center'> <b> Jumlah </b> </td>";
                $tfoot .= "<td style='text-align: center'>  <b> ". $rata." % </b> </td>";
                $tfoot .= "</tr>";
            }
            
            $data['tr'] = $tr;
            $data['tfoot'] = $tfoot;
            
            if (count($modClinical) >= 10) {
                $data['ada'] = 1;
                $data['pesan'] = "Data caring untuk pegawai <b> ".$modPegawai->namaLengkap."</b> sudah terpenuhi dalam 1 semester.";
            } else {
                $data['ada'] = 0; 
                $data['pegawai_id'] = $modPegawai->pegawai_id;
                $data['nama_pegawai'] = $modPegawai->namaLengkap;
                $data['nomorindukpegawai'] = $modPegawai->nomorindukpegawai;
                $data['unitkerja_id'] = $modUnit->unitkerja_id;
                $data['namaunitkerja'] = $modUnit->namaunitkerja;
            }
            
            $data['hitung'] = count($modClinical); 
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        Yii::app()->end();
    }

}
