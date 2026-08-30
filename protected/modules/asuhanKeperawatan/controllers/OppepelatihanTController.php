<?php

/**
 * Digunakan untuk mengakses transaksi OPPE Pelatihan
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 * @category controller
 */
class OppepelatihanTController extends MyAuthController {

    public $defaultAction = 'index';
    public $path_view = 'asuhanKeperawatan.views.oppepelatihanT.';
    public $init = '';
    public $simpan = false;

    /**
     * Digunakan untuk mengakses halaman transaksi OPPE Pelatihan
     */
    public function actionIndex() {
        $this->layout = '//layouts/iframe';
        $model = new ASOppepelatihanT;
        $modDet = new OppepelatihanT;

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
        $crit->addCondition("nama_indikator ilike '%Pelatihan%'");
        $crit->addCondition("is_aktif IS TRUE");
        $cekIndikator = IndikatoroppekeperawatanM::model()->find($crit);
        $model->indikatoroppekeperawatan_id = !empty($cekIndikator) ? $cekIndikator->indikatoroppekeperawatan_id : '';
        $model->indikatoroppekeperawatan_nama = !empty($cekIndikator) ? $cekIndikator->nama_indikator : '';

        // Uncomment the following line if AJAX validation is needed
        if (isset($_POST['OppepelatihanT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['OppepelatihanT'] as $p) {
                    $modDet = new OppepelatihanT;
                    $modDet->attributes = $p;
                    $modDet->ka_unitkerja_id = Yii::app()->user->getState('pegawai_id');
                    $modDet->unitkerja_id = Yii::app()->user->getState('unitkerja_id');
                    $modDet->indikatoroppekeperawatan_id = !empty($cekIndikator) ? $cekIndikator->indikatoroppekeperawatan_id : '';
                    $modDet->bulan_pelatihan = MyFormatter::formatDateTimeForDb('01 ' . $p['bulan_pelatihan']);
                    if (!empty($p['oppepelatihan_id'])) {
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
     * Digunakan untuk load data pelatihan da di append di tabel
     */
    public function actionGetPelatihan() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post

            $bulan_pelatihan = $_POST['bulan_pelatihan'];
            $pegawai_id = $_POST['pegawai_id'];
            $nama_pegawai = $_POST['nama_pegawai'];
            $nip = $_POST['nip'];
            $unitkerja_id = $_POST['perawat_unitkerja_id'];
            $namaunitkerja = $_POST['namaunitkerja'];
            $nama_pelatihan = $_POST['nama_pelatihan'];
            $no_sertifikat = $_POST['no_sertifikat'];
            $penyelenggara = $_POST['penyelenggara'];
            $jml_skp = $_POST['jml_skp'];
            $skor = $_POST['skor'];

            //set new model
            $modDet = new OppepelatihanT();

            $modDet->bulan_pelatihan = $bulan_pelatihan;
            $modDet->pegawai_id = $pegawai_id;
            $modDet->nama_perawat = $nama_pegawai;
            $modDet->nip_perawat = $nip;
            $modDet->perawat_unitkerja_id = $unitkerja_id;
            $modDet->namaunitkerja = $namaunitkerja;
            $modDet->nama_pelatihan = $nama_pelatihan;
            $modDet->no_sertifikat = $no_sertifikat;
            $modDet->penyelenggara = $penyelenggara;
            $modDet->jml_skp = $jml_skp;
            $modDet->skor = $skor;

            $return = $this->renderPartial($this->path_view . "/_rowPelatihan", array('model' => $modDet, 'i' => 1), true);

            $data['return'] = $return;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk menghitung skor
     */
    public function actionGetSkor() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post

            $jml_skp = !empty($_POST['jml_skp']) ? $_POST['jml_skp'] : 0;
            $indikator_id = $_POST['indikator_id'];

            $cekIndikator = IndikatoroppekeperawatanM::model()->findByPk($indikator_id);
            $standarnilai = !empty($cekIndikator) ? $cekIndikator->standar_nilai : 0;

            $data['skor'] = round((($jml_skp / $standarnilai) * 100),2);
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
     * Load data Pelatihan
     */
    public function actionGetDataPelatihan() { 
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
            $cri->addInCondition("extract(month from bulan_pelatihan)", $cari_bulan);
            $cri->addCondition("extract(year from bulan_pelatihan) = ".$tahun_pencatatan);
            $modPelatihan = OppepelatihanT::model()->findAll($cri); 
            
            $tr = "";
            $tfoot = "";
            if (!empty($modPelatihan)) {
                $i = 1;
                $hitung_skp = 0;
                $hitung_skor = 0;
                foreach($modPelatihan as $det){
                    $tr .= "<tr>";
                    $tr .= "<td style='text-align: center'>".$i++."</td>";
                    $tr .= "<td>".date('M Y', strtotime($det['bulan_pelatihan']))."</td>";
                    $tr .= "<td>".$det['nama_pelatihan']."</td>";
                    $tr .= "<td>".$det['no_sertifikat']."</td>";
                    $tr .= "<td>".$det['penyelenggara']."</td>";
                    $tr .= "<td style='text-align: center'>".$det['jml_skp']."</td>";
                    $tr .= "<td style='text-align: center'>".$det['skor']."% </td>";
                    $tr .= "</tr>";
                    $hitung_skp += $det['jml_skp'];
                    $hitung_skor += $det['skor'];
                    if ($hitung_skor > 100) {
                        $hitung_skor = 100; 
                    }
                }
                $tfoot .= "<tr>";
                $tfoot .= "<td colspan=5 style='text-align: center'> <b> Jumlah </b> </td>";
                $tfoot .= "<td style='text-align: center'>  <b> ".$hitung_skp."</b> </td>";
                $tfoot .= "<td style='text-align: center'>  <b> ".$hitung_skor." % </b> </td>";
                $tfoot .= "</tr>";
            }
            
            $data['tr'] = $tr;
            $data['tfoot'] = $tfoot;
            
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        Yii::app()->end();
    }
}
