<?php

/**
 * Digunakan untuk mengakses transaksi OPPE Perilaku
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 * @category controller
 */
class OppeperilakuTController extends MyAuthController {

    public $defaultAction = 'index';
    public $path_view = 'asuhanKeperawatan.views.oppeperilakuT.';
    public $init = '';
    public $simpan = false;

    /**
     * Digunakan untuk mengakses halaman transaksi OPPE Perilaku
     */
    public function actionIndex() {
        $this->layout = '//layouts/iframe';
        $model = new ASOppeperilakuT;
        $model->nilai_dokter = number_format(0, 2, ",", ".");
        $model->nilai_keluarga = number_format(0, 2, ",", ".");
        $model->nilai_pasien = number_format(0, 2, ",", ".");
        $model->nilai_sejawat = number_format(0, 2, ",", ".");
        $modDet = new OppeperilakuT;

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
        $crit->addCondition("nama_indikator ilike '%Perilaku%'");
        $crit->addCondition("is_aktif IS TRUE");
        $cekIndikator = IndikatoroppekeperawatanM::model()->find($crit);
        $model->indikatoroppekeperawatan_id = !empty($cekIndikator) ? $cekIndikator->indikatoroppekeperawatan_id : '';
        $model->indikatoroppekeperawatan_nama = !empty($cekIndikator) ? $cekIndikator->nama_indikator : '';

        // Uncomment the following line if AJAX validation is needed
        if (isset($_POST['OppeperilakuT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['OppeperilakuT'] as $p) {
                    $modDet = new OppeperilakuT;
                    $modDet->attributes = $p;
                    $modDet->ka_unitkerja_id = Yii::app()->user->getState('pegawai_id');
                    $modDet->unitkerja_id = Yii::app()->user->getState('unitkerja_id');
                    $modDet->indikatoroppekeperawatan_id = !empty($cekIndikator) ? $cekIndikator->indikatoroppekeperawatan_id : '';
                    $modDet->bulan_pencatatan = MyFormatter::formatDateTimeForDb('01 ' . $p['bulan_pencatatan']);
                    $modDet->nilai_keluarga = MyFormatter::formatNumberForDb($modDet->nilai_keluarga);
                    $modDet->nilai_sejawat = MyFormatter::formatNumberForDb($modDet->nilai_sejawat);
                    $modDet->nilai_pasien = MyFormatter::formatNumberForDb($modDet->nilai_pasien);
                    $modDet->nilai_dokter = MyFormatter::formatNumberForDb($modDet->nilai_dokter);
                    if (!empty($p['oppeperilaku_id'])) {
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
     * Digunakan untuk load data perilaku da di append di tabel
     */
    public function actionGetPerilaku() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post

            $bulan_pencatatan = $_POST['bulan_pencatatan'];
            $pegawai_id = $_POST['pegawai_id'];
            $nama_pegawai = $_POST['nama_pegawai'];
            $nip = $_POST['nip'];
            $unitkerja_id = $_POST['perawat_unitkerja_id'];
            $namaunitkerja = $_POST['namaunitkerja'];
            $nilai_sejawat = str_replace(",", ".",$_POST['nilai_sejawat']);
            $nilai_pasien = str_replace(",", ".",$_POST['nilai_pasien']);
            $nilai_dokter = str_replace(",", ".",$_POST['nilai_dokter']);
            $nilai_keluarga = str_replace(",", ".",$_POST['nilai_keluarga']);

            //set new model
            $modDet = new OppeperilakuT();

            $modDet->bulan_pencatatan = $bulan_pencatatan;
            $modDet->pegawai_id = $pegawai_id;
            $modDet->nama_perawat = $nama_pegawai;
            $modDet->nip_perawat = $nip;
            $modDet->perawat_unitkerja_id = $unitkerja_id;
            $modDet->namaunitkerja = $namaunitkerja;
            $modDet->nilai_sejawat = number_format($nilai_sejawat, 2, ',', '.');
            $modDet->nilai_pasien = number_format($nilai_pasien, 2, ',', '.');
            $modDet->nilai_dokter = number_format($nilai_dokter, 2, ',', '.');
            $modDet->nilai_keluarga = number_format($nilai_keluarga, 2, ',', '.');
                        
            $array = array($nilai_sejawat, $nilai_pasien, $nilai_dokter, $nilai_keluarga);
            $i = 0;
            foreach($array as $j){
                if ($j > 0) {
                    $i++;
                }
            }
            $jumlah = $i; 
            $nilai = array_sum($array);
            $modDet->nilai_rata = $nilai / $jumlah;

            $return = $this->renderPartial($this->path_view . "/_rowPerilaku", array('model' => $modDet, 'i' => 1), true);

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
            
            $semester = 0; 
            if ($bulan_pencatatan >= 1 && $bulan_pencatatan <= 6) {
                $cari_bulan = array('01', '02', '03', '04', '05', '06');
                $semester = 1;
            } else {
                $cari_bulan = array('07', '08', '09', '10', '11', '12');
                $semester = 2;
            }
            
            $cri = new CDbCriteria();
            $cri->addCondition("pegawai_id = ".$pegawai_id);
            $cri->addInCondition("extract(month from bulan_pencatatan)", $cari_bulan);
            $cri->addCondition("extract(year from bulan_pencatatan) = ".$tahun_pencatatan);
            $modPerilaku = OppeperilakuT::model()->findAll($cri); 
            $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
            $modUnit = UnitkerjaM::model()->findByPk($modPegawai->unitkerja_id);
            
            $tr = "";
            $tfoot = "";
            $hitung_skor = 0;
            $hitung_sejawat = 0;
            $hitung_keluarga = 0;
            $hitung_dokter = 0;
            if (!empty($modPerilaku)) { 
                $i = 1;
                $data['disable_sejawat'] = false; 
                 
                foreach($modPerilaku as $det){
                    $nilai_keluarga = !empty($det['nilai_keluarga']) ? $det['nilai_keluarga'] : $det['nilai_pasien']; 
                    $tr .= "<tr>";
                    $tr .= "<td style='text-align: center'>".$i++."</td>";
                    $tr .= "<td>".date('M Y', strtotime($det['bulan_pencatatan']))."</td>";
                    $tr .= "<td>".$det['nama_perawat']."</td>";
                    $tr .= "<td style='text-align: center'>".CHtml::hiddenField('riwayat_nilai_sejawat', $det['nilai_sejawat'], array('class' => 'span2 riwayat_nilai_sejawat'))
                                                            . number_format($det['nilai_sejawat'], 2, ',', '.')."% </td>";
                    $tr .= "<td style='text-align: center'>".CHtml::hiddenField('riwayat_nilai_keluarga', $det['nilai_keluarga'], array('class' => 'span2 riwayat_nilai_keluarga'))
                                                            .CHtml::hiddenField('riwayat_nilai_pasien', $det['nilai_pasien'], array('class' => 'span2 riwayat_nilai_pasien'))
                                                            . number_format($nilai_keluarga, 2, ',', '.')."% </td>";
                    $tr .= "<td style='text-align: center'>".CHtml::hiddenField('riwayat_nilai_dokter', $det['nilai_dokter'], array('class' => 'span2 riwayat_nilai_dokter'))
                                                            . number_format($det['nilai_dokter'], 2, ',', '.')."% </td>";
                    $tr .= "<td style='text-align: center'>". number_format($det['nilai_rata'], 2, ',', '.')."% </td>";
                    $tr .= "</tr>";
                    $hitung_skor += $det['nilai_rata'];
                    $hitung_sejawat += $det['nilai_sejawat'];
                    $hitung_keluarga += $nilai_keluarga;
                    $hitung_dokter += $det['nilai_dokter'];
                }
                
                $rata = $hitung_skor / count($modPerilaku);
                $tfoot .= "<tr>";
                $tfoot .= "<td colspan=6 style='text-align: center'> <b> Jumlah </b> </td>";
                $tfoot .= "<td style='text-align: center'>  <b> ". number_format($rata, 2, ',', '.')."% </b> </td>";
                $tfoot .= "</tr>";
            }
            
            $data['tr'] = $tr;
            $data['tfoot'] = $tfoot;
            
            if ($hitung_sejawat !== 0 && $hitung_keluarga !== 0 && $hitung_dokter !== 0) {
                $data['ada'] = 1;
                $data['pesan'] = "Sudah ada data perilaku untuk <b> ".$modPegawai->namaLengkap."</b> di <b> semester ".$semester." tahun ".$tahun_pencatatan." </b>";
            } else {
                $data['ada'] = 0; 
                $data['pegawai_id'] = $modPegawai->pegawai_id;
                $data['nama_pegawai'] = $modPegawai->namaLengkap;
                $data['nomorindukpegawai'] = $modPegawai->nomorindukpegawai;
                $data['unitkerja_id'] = $modUnit->unitkerja_id;
                $data['namaunitkerja'] = $modUnit->namaunitkerja;
            }
            
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        Yii::app()->end();
    }

}
