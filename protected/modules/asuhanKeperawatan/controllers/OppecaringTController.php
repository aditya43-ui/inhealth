<?php
/**
 * Controller untuk Penilaian OPPE Caring
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhankeperawatan
 * @subpackage controllers
 * @category controller
 */
class OppecaringTController extends MyAuthController {

    /**
     * Halaman Index
     */
    public function actionIndex() {
        $this->layout = '//layouts/iframe';
        $model = new ASOppecaringT();
        $model->indikatoroppekeperawatan_id = Params::INDIKATOR_OPPE_CARING_ID;
        $model->indikatoroppekeperawatan_nama = "Caring";
        $crit = new CDbCriteria();
        $crit->addCondition("nama_indikator ilike '%Caring%'");
        $crit->addCondition("is_aktif IS TRUE");
        $cekIndikator = IndikatoroppekeperawatanM::model()->find($crit);
        $model->nilai_pasien = number_format(0, 2, ",", ".");
        $model->nilai_keluarga = number_format(0, 2, ",", ".");
        $ok = true;
        if (isset($_POST['OppecaringT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['OppecaringT'] as $value) {
                    $model = new OppecaringT();
                    $model->attributes = $value;
                    $model->ka_unitkerja_id = Yii::app()->user->getState('pegawai_id');
                    $model->unitkerja_id = Yii::app()->user->getState('unitkerja_id');
                    $model->bulan_caring = MyFormatter::formatDateTimeForDb('01 ' . $value['bulan_caring']);
                    $model->tgl_kuisioner = MyFormatter::formatDateTimeForDb($value['tgl_kuisioner']);
                    $model->indikatoroppekeperawatan_id = !empty($cekIndikator) ? $cekIndikator->indikatoroppekeperawatan_id : '';
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->nilai_pasien  = MyFormatter::formatNumberForDb($model->nilai_keluarga);
                    $model->nilai_rata  = MyFormatter::formatNumberForDb($model->nilai_rata);
                    $model->nilai_keluarga  = MyFormatter::formatNumberForDb($model->nilai_keluarga);
                    $ok = $ok && $model->save();
                }
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('index', array('model' => $model));
    }

    /**
     * Generate tabel
     */
    public function actionGenerateTabel() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new OppecaringT();
            $model->bulan_caring = $_POST['bulan_caring'];
            $model->pegawai_id = $_POST['pegawai_id'];
            $model->nama_perawat = $_POST['nama_pegawai'];
            $model->nip_perawat = $_POST['nip'];
            $model->perawat_unitkerja_id = $_POST['perawat_unitkerja_id'];
            $model->namaunitkerja = $_POST['namaunitkerja'];
            $model->tgl_kuisioner = $_POST['tanggal_kuisioner'];
            $model->nilai_pasien = $_POST['nilai_pasien'];
            $model->nilai_keluarga = $_POST['nilai_keluarga'];
            $model->nilai_rata = $_POST['nilai_rata'];
            $return = $this->renderPartial("_rowCaring", array('model' => $model, 'i' => 1), true);
            $model['return'] = $return;
            echo json_encode($model);
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionHapusCaring($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $ok = true;
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modCaring = OppecaringT::model()->findByPk($id);
                $ok = $ok && $modCaring->delete();
                if ($ok) {
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                } else {
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data Gagal Dihapus";
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data Gagal Dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
            $cri->addInCondition("extract(month from bulan_caring)", $cari_bulan);
            $cri->addCondition("extract(year from bulan_caring) = ".$tahun_pencatatan);
            $modCaring = OppecaringT::model()->findAll($cri); 
            $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
            $modUnit = UnitkerjaM::model()->findByPk($modPegawai->unitkerja_id);
            
            $tr = "";
            $tfoot = "";
            if (!empty($modCaring)) { 
                $i = 1;
                $hitung_skor = 0;
                foreach($modCaring as $det){
                    $tr .= "<tr>";
                    $tr .= "<td style='text-align: center'>".$i++."</td>";
                    $tr .= "<td>".date('M Y', strtotime($det['bulan_caring']))."</td>";
                    $tr .= "<td>".$det['nama_perawat']."</td>";
                    $tr .= "<td style='text-align: center'>".MyFormatter::formatDateTimeForUser($det['tgl_kuisioner'])." </td>";
                    $tr .= "<td style='text-align: center'>".$det['nilai_pasien']."% </td>";
                    $tr .= "<td style='text-align: center'>".$det['nilai_keluarga']."% </td>";
                    $tr .= "<td style='text-align: center'>".$det['nilai_rata']."% </td>";
                    $tr .= "</tr>";
                    $hitung_skor += $det['nilai_rata'];
                }
                $rata = $hitung_skor / count($modCaring);
                $tfoot .= "<tr>";
                $tfoot .= "<td colspan=6 style='text-align: center'> <b> Jumlah </b> </td>";
                $tfoot .= "<td style='text-align: center'>  <b> ". number_format($rata, 2, ',', '.')."% </b> </td>";
                $tfoot .= "</tr>";
            }
            
            $data['tr'] = $tr;
            $data['tfoot'] = $tfoot;
            
            if (count($modCaring) >= 3) {
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
            
            $data['hitung'] = count($modCaring); 
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        Yii::app()->end();
    }
}