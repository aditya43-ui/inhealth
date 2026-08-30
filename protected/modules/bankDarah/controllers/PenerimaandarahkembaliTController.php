<?php

/**
 * @author      Elham Budianto <elhambudianto1@.com>
 * @version     2.0.0
 * @digunakan   controller penerimaan darah kembali
 * @website      <http://>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class PenerimaandarahkembaliTController extends MyAuthController
{

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'bankDarah.views.penerimaandarahkembaliT.';
    public $init = '';
    public $simpandetailkantong = false;

    /**
     * Menampilkan transaksi penerimaan darah kembali
     * @param type $returdarah_id
     */
    public function actionIndex($returdarah_id = null)
    {
        $model = new BDReturdarahT();
        $model->tgl_retur_darah = MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s"));
        $model->no_retur_darah = '--Otomatis--';
        if (!empty(Yii::app()->user->getState('pegawai_id'))) {
            $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $model->petugas_penerima_id = $pegawai->pegawai_id;
            $model->petugas_penerima_nama = $pegawai->namaLengkap;
        }
        if (isset($_POST['BDReturdarahT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $no_returdarah = MyGenerator::noReturDarah();
                $petugas_penerima_id = $_POST['BDReturdarahT']['petugas_penerima_id'];
                $keterangan = $_POST['BDReturdarahT']['keterangan'];
                $tgl_retur_darah = MyFormatter::formatDateTimeForDb($_POST['BDReturdarahT']['tgl_retur_darah']);
                if (isset($_POST['BDReturdarahT']['ruangan_tgl_penyerahan'])) {
                    $ruangan_tgl_penyerahan = MyFormatter::formatDateTimeForDb($_POST['BDReturdarahT']['ruangan_tgl_penyerahan']);
                }
                if (isset($_POST['BDReturdarahT']['pilih1'])) {
                    $pilih1 = true;
                } else {
                    $pilih1 = false;
                }
                if (isset($_POST['BDReturdarahT']['pilih2'])) {
                    $pilih2 = true;
                } else {
                    $pilih2 = false;
                }
                if (isset($_POST['BDReturdarahT']['pilih3'])) {
                    $pilih3 = true;
                } else {
                    $pilih3 = false;
                }
                foreach ($_POST['det'] as $i => $row) {
                    $modDetails = new BDReturdarahT;
                    $modDetails->ujikompatibilitas_id = $row['ujikompatibilitas_id'];
                    $modDetails->no_retur_darah = $no_returdarah;
                    $modDetails->keterangan = $keterangan;
                    $modDetails->tgl_retur_darah = $tgl_retur_darah;
                    $modDetails->petugas_penerima_id = $petugas_penerima_id;
                    $modDetails->ruangan_tgl_penyerahan = $ruangan_tgl_penyerahan;
                    if (!empty($ruangan_tgl_penyerahan)) {
                        $modDetails->ruangan_tgl_penyerahan = $ruangan_tgl_penyerahan;
                    }
                    if ($pilih1) {
                        $modDetails->is_ruangan = true;
                    }
                    if ($pilih2) {
                        $modDetails->is_bdt = true;
                    }
                    if ($pilih3) {
                        $modDetails->is_itd = true;
                    }
                    if ($modDetails->save()) {
                        $this->simpandetailkantong = true;
                    }
                }
                if ($this->simpandetailkantong) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'returdarah_id' => $model->returdarah_id, 'sukses' => 1));
                } else {

                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
        ));
    }

    /**
     * Auto complete kantong darah
     */
    public function actionAutocompleteKantongDarah()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $attribute = array();
            $criteria = new CDbCriteria();
            $term = strtolower(trim($_GET['term']));
            $criteria->select = 't.*,t.penyerahandarah_id,'
                . 'pasien.nama_pasien,pasien.no_rekam_medik,pasien.golongandarah,'
                . 'kantong.no_kantongdarah,'
                . 'pendonor.gol_darah,pendonor.rhesus,'
                . 'komponen.singkatan_komp,'
                . 'uji.ujikompatibilitas_id,'
                . 'ruangan.ruangan_nama';
            $criteria->join = ' LEFT JOIN penyiapandarah_t as penyiapan ON t.penyiapandarah_id=penyiapan.penyiapandarah_id '
                . ' LEFT JOIN ujikompatibilitas_t as uji ON penyiapan.ujikompatibilitas_id=uji.ujikompatibilitas_id '
                . ' LEFT JOIN permintaandarahdet_t as permintaandet ON uji.permintaandarahdet_id=permintaandet.permintaandarahdet_id '
                . ' LEFT JOIN permintaandarah_t as permintaan ON permintaandet.permintaandarah_id=permintaan.permintaandarah_id '
                . ' LEFT JOIN stokkantongdarah_t as stok ON uji.stokkantongdarah_id=stok.stokkantongdarah_id '
                . ' LEFT JOIN kantongdarah_t as kantong ON stok.kantongdarah_id=kantong.kantongdarah_id '
                . ' LEFT JOIN komponendarah_m as komponen ON kantong.komponendarah_id=komponen.komponendarah_id '
                . ' LEFT JOIN pendonor_m as pendonor ON kantong.pendonor_id=pendonor.pendonor_id '
                . ' LEFT JOIN pasien_m as pasien ON uji.pasien_id = pasien.pasien_id '
                . ' LEFT JOIN pendaftaran_t as pendaftaran ON uji.pendaftaran_id = pendaftaran.pendaftaran_id '
                . ' LEFT JOIN ruangan_m as ruangan ON permintaan.ruanganpemesan_id = ruangan.ruangan_id '
                . ' LEFT JOIN returdarah_t as retur on uji.ujikompatibilitas_id = retur.ujikompatibilitas_id ';
            $criteria->group = $criteria->select;
            $criteria->addCondition("uji.rilis = 'Release'");
            $criteria->addCondition("retur.returdarah_id IS NULL");
            $criteria->compare("LOWER(no_kantongdarah)", strtolower($_GET['term']), true);
            $models = BDPenyerahandarahT::model()->findAll($criteria);
            $returnVal = array();
            foreach ($models as $i => $model) {
                $returnVal[$i]['label'] = $model->no_kantongdarah;
                $returnVal[$i]['value'] = $model->ujikompatibilitas_id;
                $returnVal[$i]['no_kantongdarah'] = $model->no_kantongdarah;
                $returnVal[$i]['ruangan_nama'] = $model->ruangan_nama;
                $returnVal[$i]['nama_pasien'] = $model->nama_pasien;
                $returnVal[$i]['no_rekam_medik'] = $model->no_rekam_medik;
                $returnVal[$i]['jenis_komponen_darah'] = $model->singkatan_komp;
                $returnVal[$i]['golongan_darah'] = $model->gol_darah;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * menegenerate kantong darah
     */
    public function actionGetKantong()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $kantongdarah_id = isset($_POST['kantongdarah_id']) ? $_POST['kantongdarah_id'] : null;
            $no_kantongdarah = isset($_POST['no_kantongdarah']) ? $_POST['no_kantongdarah'] : null;

            $criteria = new CDbCriteria;
            $criteria->select = 't.*,'
                . 't.penyerahandarah_id,'
                . 'pasien.nama_pasien,'
                . 'pasien.no_rekam_medik,'
                . 'pasien.golongandarah,'
                . 'kantong.no_kantongdarah,'
                . 'komponen.singkatan_komp,'
                . 'uji.ujikompatibilitas_id,uji.rilis,'
                . 'ruangan.ruangan_nama,'
                . 'CASE WHEN kantong.penerimaandarahpmidet_id IS NULL THEN pendonor.gol_darah ELSE stok.golongan_darah END AS gol_darah ,
                       CASE WHEN kantong.penerimaandarahpmidet_id IS NULL THEN pendonor.rhesus ELSE stok.rhesus END AS rhesus_darah ';
            $criteria->join = ' LEFT JOIN penyiapandarah_t as penyiapan ON t.penyiapandarah_id=penyiapan.penyiapandarah_id '
                . ' LEFT JOIN ujikompatibilitas_t as uji ON penyiapan.ujikompatibilitas_id=uji.ujikompatibilitas_id '
                . ' LEFT JOIN permintaandarahdet_t as permintaandet ON uji.permintaandarahdet_id=permintaandet.permintaandarahdet_id '
                . ' LEFT JOIN permintaandarah_t as permintaan ON permintaandet.permintaandarah_id=permintaan.permintaandarah_id '
                . ' LEFT JOIN stokkantongdarah_t as stok ON uji.stokkantongdarah_id=stok.stokkantongdarah_id '
                . ' LEFT JOIN kantongdarah_t as kantong ON stok.kantongdarah_id=kantong.kantongdarah_id '
                . ' LEFT JOIN komponendarah_m as komponen ON kantong.komponendarah_id=komponen.komponendarah_id '
                . ' LEFT JOIN pendonor_m as pendonor ON kantong.pendonor_id=pendonor.pendonor_id '
                . ' LEFT JOIN pasien_m as pasien ON uji.pasien_id = pasien.pasien_id '
                . ' LEFT JOIN pendaftaran_t as pendaftaran ON uji.pendaftaran_id = pendaftaran.pendaftaran_id '
                . ' LEFT JOIN ruangan_m as ruangan ON permintaan.ruanganpemesan_id = ruangan.ruangan_id '
                . ' LEFT JOIN returdarah_t as retur on uji.ujikompatibilitas_id = retur.ujikompatibilitas_id ';
            $criteria->group = 't.*,'
                . 't.penyerahandarah_id,'
                . 'pasien.nama_pasien,'
                . 'pasien.no_rekam_medik,'
                . 'pasien.golongandarah,'
                . 'kantong.no_kantongdarah,'
                . 'komponen.singkatan_komp,'
                . 'uji.ujikompatibilitas_id,uji.rilis,'
                . 'ruangan.ruangan_nama,'
                . 'pendonor.gol_darah, '
                . 'stok.golongan_darah,'
                . 'rhesus_darah,'
                . 'penerimaandarahpmidet_id, stok.golongan_darah';
            $criteria->addCondition("uji.rilis = 'Release'");
            $criteria->addCondition("retur.returdarah_id IS NULL");
            if (is_array($no_kantongdarah)) {
                $criteria->addInCondition("no_kantongdarah", $no_kantongdarah);
            } else {
                $criteria->addCondition("no_kantongdarah = '" . $no_kantongdarah . "' ");
            }
            $modKantong = BDPenyerahandarahT::model()->findAll($criteria);
            $kantong = array();

            foreach ($modKantong as $d) {
                $kantong[$d->no_kantongdarah]['no_kantongdarah'] = $d->no_kantongdarah;
                $kantong[$d->no_kantongdarah]['ujikompatibilitas_id'] = $d->ujikompatibilitas_id;
                $kantong[$d->no_kantongdarah]['no_rekam_medik'] = $d->no_rekam_medik;
                $kantong[$d->no_kantongdarah]['nama_pasien'] = $d->nama_pasien;
                $kantong[$d->no_kantongdarah]['golongan_darah'] = $d->gol_darah . '/' . $d->rhesus_darah;
                $kantong[$d->no_kantongdarah]['jenis_komponen_darah'] = $d->singkatan_komp;
                $kantong[$d->no_kantongdarah]['ruangan_nama'] = $d->ruangan_nama;
            }

            $tr = '';
            $no = 0;
            foreach ($kantong as $det) {
                $tr .= $this->renderPartial($this->path_view . '_detailKantongDarah', array(
                    'no' => $no + 1,
                    'det' => $det
                ), true);
                $no++;
            }
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
}
