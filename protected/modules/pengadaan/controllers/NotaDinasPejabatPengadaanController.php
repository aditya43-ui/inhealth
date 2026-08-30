<?php

/**
 * Controller untuk halaman Transaksi Nota Dinas Pejabat Pengadaan
 * @author Andyka Putra <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class NotaDinasPejabatPengadaanController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $path_view = 'pengadaan.views.notaDinasPejabatPengadaan.';
    public $penyediaTersimpan = true;

    /**
     * Digunakan untuk menampilkan halaman transaksi Nota Dinas Pejabat Pengadaan
     * @param type integer $id menampung persiapanpengadaan_id
     */
    public function actionIndex($id) {
        $this->layout = '//layouts/iframe';
        $model = new NotadinaspengadaanT();
        $model->notadinaspengadaan_nomor = '-- Otomatis --';
        $model->persiapanpengadaan_id = $id; 
        $cekNotaDinas = NotadinaspengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
        $cekJabatanPengadaan = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
        if (!empty($cekNotaDinas)) {
            $model = NotadinaspengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            $model->nomor_notadinas = $model->nomor_notadinas;
            $model->notadinaspengadaan_tanggal = MyFormatter::formatDateTimeForUser($model->notadinaspengadaan_tanggal);
            $model->supplier_id = $model->supplier_id;
            $model->supplier_nama = !empty($model->supplier->supplier_nama) ? $model->supplier->supplier_nama : "";
            $model->supplier_alamat = !empty($model->supplier->supplier_alamat) ? $model->supplier->supplier_alamat : "";
            $model->supplier_npwp = !empty($model->supplier->supplier_npwp) ? $model->supplier->supplier_npwp : "";
            $model->harga_negosiasi = !empty($model->harga_negosiasi) ? MyFormatter::formatNumberForPrint($model->harga_negosiasi, 2) : "";
            $model->pengumumanpemenang_id = !empty($model->pengumumanpemenang_id) ? $model->pengumumanpemenang_id : "";
            $model->pengumuman_nomor = !empty($model->pengumumanpemenang_id) ? $model->pengumumanpemenang->pengumumanpemenang_nomor : $model->pengumuman_nomor;
            $model->pengumuman_tanggal = !empty($model->pengumumanpemenang_id) ? MyFormatter::formatDateTimeForUser($model->pengumumanpemenang->pengumumanpemenang_tanggal) : MyFormatter::formatDateTimeForUser($model->pengumuman_tanggal);
            $model->pegawai_id = !empty($model->pegawai_id) ? $model->pegawai_id : '';
            $model->nama_pegawai = !empty($model->pegawai_id) ? $model->pegawai->namaLengkap : '-';
            $model->noindukpegawai = !empty($model->pegawai_id) ? $model->pegawai->nomorindukpegawai : '-';
            $model->peg_jabatan = !empty($cekJabatanPengadaan->jabatan_pengadaan) ? $cekJabatanPengadaan->jabatan_pengadaan : '';
        } else {
            $cekPenetapan = PenetapanpemenangT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            if (!empty($cekPenetapan)) {
                $cekPengumumanPemenang = PengumumanpemenangT::model()->findByAttributes(array('penetapanpemenang_id' => $cekPenetapan->penetapanpemenang_id, 'isbatal' => false, 'isaddendum' => true));
                if (!empty($cekPengumumanPemenang)) {
                    $model = new NotadinaspengadaanT();
                    $model->persiapanpengadaan_id = $id;
                    $model->notadinaspengadaan_nomor = '-- Otomatis --';
                    $model->notadinaspengadaan_tanggal = date('d M Y H:i:s');
                    $model->supplier_id = $cekPengumumanPemenang->supplier_id;
                    $model->supplier_nama = !empty($cekPengumumanPemenang->supplier->supplier_nama) ? $cekPengumumanPemenang->supplier->supplier_nama : "";
                    $model->supplier_alamat = !empty($cekPengumumanPemenang->supplier->supplier_alamat) ? $cekPengumumanPemenang->supplier->supplier_alamat : "";
                    $model->supplier_npwp = !empty($cekPengumumanPemenang->supplier->supplier_npwp) ? $cekPengumumanPemenang->supplier->supplier_npwp : "";
                    $model->harga_negosiasi = !empty($cekPenetapan->harga_negosiasi) ? MyFormatter::formatNumberForPrint($cekPenetapan->harga_negosiasi, 2) : MyFormatter::formatNumberForPrint($model->harga_negosiasi, 2);
                    $model->pengumumanpemenang_id = !empty($cekPengumumanPemenang) ? $cekPengumumanPemenang->pengumumanpemenang_t : "";
                    $model->pengumuman_nomor = !empty($cekPengumumanPemenang) ? $cekPengumumanPemenang->pengumumanpemenang_nomor : '';
                    $model->pengumuman_tanggal = !empty($cekPengumumanPemenang) ? MyFormatter::formatDateTimeForUser($cekPengumumanPemenang->pengumumanpemenang_tanggal) : MyFormatter::formatDateTimeForUser($model->pengumuman_tanggal);
                    $model->pegawai_id = !empty($cekPenetapan->pegawai_id) ? $cekPenetapan->pegawai_id : '';
                    $model->nama_pegawai = !empty($cekPenetapan->pegawai_id) ? $cekPenetapan->pegawai->namaLengkap : '';
                    $model->noindukpegawai = !empty($cekPenetapan->pegawai_id) ? $cekPenetapan->pegawai->nomorindukpegawai : '';
                    $model->peg_jabatan = !empty($cekJabatanPengadaan->jabatan_pengadaan) ? $cekJabatanPengadaan->jabatan_pengadaan : '';
                }
            } else {
                if (!empty($cekJabatanPengadaan)) {
                    $model->pegawai_id = !empty($cekJabatanPengadaan->pegpengadaan_id) ? $cekJabatanPengadaan->pegpengadaan_id : '';
                    $model->nama_pegawai = !empty($cekJabatanPengadaan->pegpengadaan_id) ? $cekJabatanPengadaan->pegpengadaan->namaLengkap : '';
                    $model->noindukpegawai = !empty($cekJabatanPengadaan->pegpengadaan_id) ? $cekJabatanPengadaan->pegpengadaan->nomorindukpegawai : '';
                    $model->peg_jabatan = !empty($cekJabatanPengadaan->jabatan_pengadaan) ? $cekJabatanPengadaan->jabatan_pengadaan : '';
                    $model->supplier_id = $cekJabatanPengadaan->supplier_id;
                    $model->supplier_nama = !empty($cekJabatanPengadaan->supplier->supplier_nama) ? $cekJabatanPengadaan->supplier->supplier_nama : "";
                    $model->supplier_alamat = !empty($cekJabatanPengadaan->supplier->supplier_alamat) ? $cekJabatanPengadaan->supplier->supplier_alamat : "";
                    $model->supplier_npwp = !empty($cekJabatanPengadaan->supplier->supplier_npwp) ? $cekJabatanPengadaan->supplier->supplier_npwp : "";
                }
            }
        }

        if (isset($_POST['NotadinaspengadaanT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;

            try {
                $model->attributes = $_POST['NotadinaspengadaanT'];
                if (empty($cekNotaDinas)) {
                    $model->notadinaspengadaan_tanggal = MyFormatter::formatDateTimeForDB($_POST['NotadinaspengadaanT']['notadinaspengadaan_tanggal']);
                    $model->pengumuman_tanggal = !empty($_POST['NotadinaspengadaanT']['pengumuman_tanggal']) ? MyFormatter::formatDateTimeForDB($_POST['NotadinaspengadaanT']['pengumuman_tanggal']) : null;
                    $model->notadinaspengadaan_nomor = MyGenerator::NoNotaDinasPengadaan();
                    $model->persiapanpengadaan_id = $id;
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->harga_negosiasi = MyFormatter::formatNumberForDb($_POST['NotadinaspengadaanT']['harga_negosiasi']);

                    $modSmsgateway = SmsgatewayM::model()->findByPk(191);

                    if (!empty($modSmsgateway)) {
                        $template = $modSmsgateway->templatesms;
                    } else {
                        $template = "Penyedia {{supplier_nama}} dipilih untuk menjadi pemenang pekerjaan {{nama_pekerjaan}}. Mohon segera menyampaikan hasil pemilihan kepada PPKom. Catatan: Nomor {{persiapanpengadaan_nomor}}.";
                    }

                    $modUnitKerja = UnitkerjaM::model()->findByPk(Params::UNITKERJA_ID_PENGADAAN_DAN_JASA);
                    if (!empty($modUnitKerja->kepalaunitpeg_id)) {
                        $modPegawai = PegawaiM::model()->findByPk($modUnitKerja->kepalaunitpeg_id);
                        $modPersiapan = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
                        if (!empty($modPegawai)) {
                            $isiPesan = $template;
                            $attributes = $model->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                $isiPesan = str_replace("{{supplier_nama}}", $model->supplier->supplier_nama, $isiPesan);
                                $isiPesan = str_replace("{{nama_pekerjaan}}", $modPersiapan->nama_pekerjaan, $isiPesan);
                                $isiPesan = str_replace("{{persiapanpengadaan_nomor}}", $modPersiapan->persiapanpengadaan_nomor, $isiPesan);
                            }

                            $api = new MyAPI();
                            if (!empty($modPegawai->nomobile_pegawai)) {
                                $res = $api->smsBlastSend(array($modPegawai->nomobile_pegawai), 'RSDrSoetomo', $isiPesan);
                                CustomFunction::addSentItem($res, 'RSDrSoetomo', $isiPesan);
                            }
                        }
                    }
                } else {
                    if (isset($_POST['verifikasi'])) {
                        if ($_POST['verifikasi'] == 'verifikasi') {
                            $model->isverifikasi = true;
                            $this->smsVerifikasi($model->persiapanpengadaan_id, $model->notadinaspengadaan_id);
                        }
                    }
                    $model->notadinaspengadaan_tanggal = MyFormatter::formatDateTimeForDB($_POST['NotadinaspengadaanT']['notadinaspengadaan_tanggal']);
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->pengumuman_tanggal = !empty($_POST['NotadinaspengadaanT']['pengumuman_tanggal']) ? MyFormatter::formatDateTimeForDB($_POST['NotadinaspengadaanT']['pengumuman_tanggal']) : null;
                    $model->harga_negosiasi = MyFormatter::formatNumberForDb($_POST['NotadinaspengadaanT']['harga_negosiasi']);
                }
                $ok = $ok && $model->save();

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $model->persiapanpengadaan_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (CException $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('index', array('model' => $model));
    }

    /**
     * Cetak Nota Dinas
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = NotadinaspengadaanT::model()->findByPk($id);

        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_id=".$model->konfigtemplatesurat_id);
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{notadinaspengadaan_tanggal}}", date('d ', strtotime($model->notadinaspengadaan_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->notadinaspengadaan_tanggal))) . date(' Y', strtotime($model->notadinaspengadaan_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{supplier_nama}}", !empty($model->supplier->supplier_nama) ? $model->supplier->supplier_nama : "", $isiPesan);
                $isiPesan = str_replace("{{supplier_alamat}}", !empty($model->supplier->supplier_alamat) ? $model->supplier->supplier_alamat : "", $isiPesan);
                $isiPesan = str_replace("{{supplier_npwp}}", !empty($model->supplier->supplier_npwp) ? $model->supplier->supplier_npwp : "", $isiPesan);
                $isiPesan = str_replace("{{supplier_kabupaten}}", !empty($model->supplier->supplier_kabupaten) ? $model->supplier->supplier_kabupaten : "", $isiPesan);
                $isiPesan = str_replace("{{harga_terbilang}}", ucwords(MyFormatter::kataTerbilang($model->harga_negosiasi)) . " rupiah", $isiPesan);
                $isiPesan = str_replace("{{harga_negosiasi}}", "Rp " . number_format($model->harga_negosiasi, 2, ',', '.'), $isiPesan);
                $isiPesan = str_replace("{{nomor_dokumen}}", !empty($model->pengumumanpemenang_id) ? $model->pengumumanpemenang->nomor_dokumen : $model->pengumuman_nomor, $isiPesan);
                $isiPesan = str_replace("{{pengumumanpemenang_tanggal}}", !empty($model->pengumumanpemenang_id) ? date('d ', strtotime($model->pengumumanpemenang->pengumumanpemenang_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->pengumumanpemenang->pengumumanpemenang_tanggal))) . date(' Y', strtotime($model->pengumumanpemenang->pengumumanpemenang_tanggal)) : date('d ', strtotime($model->pengumuman_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->pengumuman_tanggal))) . date(' Y', strtotime($model->pengumuman_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{pengumuman_tanggal}}", MyFormatter::formatDateTimeId($model->pengumuman_tanggal) , $isiPesan);
                
            }

            $modInfo = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
            $attributes = $modInfo->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
        }
        $model->isi_surat = $isiPesan;

        $this->render('print', array('model' => $model));
    }

    /**
     * Kirim SMS Verifikasi 
     * @param type $persiapanpengadaan_id
     * @param type $notadinaspengadaan_id
     */
    public function smsVerifikasi($persiapanpengadaan_id, $notadinaspengadaan_id) {
        $model = NotadinaspengadaanT::model()->findByPk($notadinaspengadaan_id); 
        $modPersiapan = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
        $modInfo = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
        $modSmsgateway = SmsgatewayM::model()->findByPk(192);

        if (!empty($modSmsgateway)) {
            $template = $modSmsgateway->templatesms;
        } else {
            $template = "Penyedia {{supplier_nama}} dipilih untuk menjadi pemenang pekerjaan {{nama_pekerjaan}}. Mohon segera melakukan tindak lanjut terhadap pengadaan. Catatan: Nomor {{persiapanpengadaan_nomor}}.";
        }

        $modPegawai = PegawaiM::model()->findByPk($modInfo->pegppk_id);
        if (!empty($modPegawai)) {
            $isiPesan = $template;
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{supplier_nama}}", $model->supplier->supplier_nama, $isiPesan);
                $isiPesan = str_replace("{{nama_pekerjaan}}", $modPersiapan->nama_pekerjaan, $isiPesan);
                $isiPesan = str_replace("{{persiapanpengadaan_nomor}}", $modPersiapan->persiapanpengadaan_nomor, $isiPesan);
            }

            $api = new MyAPI();
            if (!empty($modPegawai->nomobile_pegawai)) {
                $res = $api->smsBlastSend(array($modPegawai->nomobile_pegawai), 'RSDrSoetomo', $isiPesan);
                CustomFunction::addSentItem($res, 'RSDrSoetomo', $isiPesan);
            }
        }
    }

}
