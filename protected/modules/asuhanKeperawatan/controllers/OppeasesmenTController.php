<?php

/**
 * Digunakan untuk mengakses transaksi OPPE Asesmen
 * @author Andyka Putra <andykaputra@.com>
 * @packag application.modules.asuhanKeperawatan
 * @subpackage controllers
 * @category controller
 */
class OppeasesmenTController extends MyAuthController {

    public $defaultAction = 'index';
    public $path_view = 'asuhanKeperawatan.views.oppeasesmenT.';
    public $init = '';
    public $simpan = false;

    /**
     * Digunakan untuk mengakses halaman transaksi OPPE asesmen
     */
    public function actionIndex() {
        $this->layout = '//layouts/iframe';
        $model = new ASOppeasesmenT;
        $modDet = new OppeasesmenT;

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
        $crit->addCondition("nama_indikator ilike '%Asesmen%'");
        $crit->addCondition("is_aktif IS TRUE");
        $cekIndikator = IndikatoroppekeperawatanM::model()->find($crit);
        $model->indikatoroppekeperawatan_id = !empty($cekIndikator) ? $cekIndikator->indikatoroppekeperawatan_id : '';
        $model->indikatoroppekeperawatan_nama = !empty($cekIndikator) ? $cekIndikator->nama_indikator : '';

        // Uncomment the following line if AJAX validation is needed
        if (isset($_POST['OppeasesmenT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['OppeasesmenT'] as $p) {
                    $modDet = new OppeasesmenT;
                    $modDet->attributes = $p;
                    
                    $modDet->ka_unitkerja_id = Yii::app()->user->getState('pegawai_id');
                    $modDet->unitkerja_id = Yii::app()->user->getState('unitkerja_id');
                    $modDet->indikatoroppekeperawatan_id = !empty($cekIndikator) ? $cekIndikator->indikatoroppekeperawatan_id : '';
                    $modDet->bulan_asesmen = MyFormatter::formatDateTimeForDb('01 ' . $p['bulan_asesmen']);
                    $modDet->prosentase_asesmen = str_replace(",", ".", $p['prosentase_asesmen']);
                    if (!empty($p['oppeasesmen_id'])) {
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
     * Digunakan untuk load data asesmen da di append di tabel
     */
    public function actionGetAsesmen() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post

            $bulan_asesmen = $_POST['bulan_asesmen'];
            $pegawai_id = $_POST['pegawai_id'];
            $nama_pegawai = $_POST['nama_pegawai'];
            $nip = $_POST['nip'];
            $unitkerja_id = $_POST['perawat_unitkerja_id'];
            $namaunitkerja = $_POST['namaunitkerja'];
            $prosentase_asesmen = $_POST['prosentase_asesmen'];

            //set new model
            $modDet = new OppeasesmenT();

            $modDet->bulan_asesmen = $bulan_asesmen;
            $modDet->pegawai_id = $pegawai_id;
            $modDet->nama_perawat = $nama_pegawai;
            $modDet->nip_perawat = $nip;
            $modDet->perawat_unitkerja_id = $unitkerja_id;
            $modDet->namaunitkerja = $namaunitkerja;
            $modDet->prosentase_asesmen = $prosentase_asesmen;

            $return = $this->renderPartial($this->path_view . "/_rowAsesmen", array('model' => $modDet, 'i' => 1), true);

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
     * Riwayat asesmen
     */
    public function actionGetDataAsesmen() {
        if (Yii::app()->request->isAjaxRequest) {
            $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
            $bulan = isset($_POST['bulan'])?$_POST['bulan']:null;
            $bulan_pencatatan = date('Y-m-01', strtotime(MyFormatter::formatMonthForDb($bulan)));
            $bulan_kehadiran = date('m', strtotime(MyFormatter::formatMonthForDb($bulan)));
            $tahun_pencatatan = date('Y', strtotime(MyFormatter::formatMonthForDb($bulan)));
            
            $cari_bulan = ""; 
            $semester = "";
            if ($bulan_kehadiran >= 1 && $bulan_kehadiran <= 6) {
                $cari_bulan = array('01', '02', '03', '04', '05', '06');
                $semester = 1;
            } else {
                $cari_bulan = array('07', '08', '09', '10', '11', '12');
                $semester = 2;
            }
            
            $cekAsesmen = OppeasesmenT::model()->findByAttributes(array('pegawai_id' => $pegawai_id, 'bulan_asesmen' => $bulan_pencatatan));

            $cri = new CDbCriteria();
            $cri->addCondition("pegawai_id = ".$pegawai_id);
            $cri->addInCondition("extract(month from bulan_asesmen)", $cari_bulan);
            $cri->addCondition("extract(year from bulan_asesmen) = ".$tahun_pencatatan);
            $modAsesmen = OppeasesmenT::model()->findAll($cri);
            
            $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
            $tr = "";
            $tfoot = "";
            
            if (!empty($modAsesmen)) {
                $i = 1; 
                $hitung_skor = 0; 
                foreach($modAsesmen as $det){
                    $tr .= "<tr>";
                    $tr .= "<td style='text-align: center'>".$i++."</td>";
                    $tr .= "<td>".date('M Y', strtotime($det['bulan_asesmen'])) 
                                .CHtml::hiddenField('pegawai_id', $det['pegawai_id'], array('class' => 'span2 pegawai_id'))
                                .CHtml::hiddenField('bulan_asesmen', $det['bulan_asesmen'], array('class' => 'span2 bulan_asesmen'))."</td>";
                    $tr .= "<td>".$modPegawai->namaLengkap."</td>";
                    $tr .= "<td style='text-align: center'>". number_format($det['prosentase_asesmen'], 2, ',', '.')."% </td>";
                    $tr .= "</tr>";
                    $hitung_skor += $det['prosentase_asesmen'];
                    
                }
                $rata = $hitung_skor / count($modAsesmen);
                $tfoot .= "<tr>";
                $tfoot .= "<td colspan=3 style='text-align: center'> <b> Rata-rata Asesmen </b> </td>";
                $tfoot .= "<td style='text-align: center'>  <b> ".$rata."% </b> </td>";
                $tfoot .= "</tr>";
            }
            
            $data['tr'] = $tr;
            $data['tfoot'] = $tfoot;
            
            if (!empty($cekAsesmen)) {
                $data['ada'] = 1;
                $data['pesan'] = "Nilai Kepatuhan Asesmen pada <b> Semester ".$semester." ".$tahun_pencatatan." </b> sudah terpenuhi";
            } else {
                $data['ada'] = 0; 
            }
            
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        Yii::app()->end();
    }

}
