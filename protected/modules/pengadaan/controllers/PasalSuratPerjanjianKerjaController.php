<?php

/**
 * Menyusun Pasal Perjanjian Kerja untuk Surat Perjanjian Kerja
 * 
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author     Aida Rahmawati <aidarahmawati@.com>
 * @package    application.modules.pengadaan
 * @subpackage controllers
 * @category   controller
 */
class PasalSuratPerjanjianKerjaController extends MyAuthController {

    public $path_view = "application.modules.pengadaan.views.pasalSuratPerjanjianKerja.";

    /**
     * Form Input Pasal untuk Surat Perjanjian Kerja.
     * 
     * @param integer $id ID Surat Perjanjian Kerja.
     */
    public function actionIndex($id) {
        $this->layout = '//layouts/iframe';

        $model = SuratperjanjiankerjaT::model()->findByPk($id);

        if (isset($_POST['detail'])) {
            $trans = Yii::app()->db->beginTransaction();

            try {
                SuratperjanjiankerjadetT::model()->deleteAllByAttributes(array(
                    'suratperjanjiankerja_id' => $model->suratperjanjiankerja_id,
                ));
                if ($model->savePasalPerjanjian($_POST['detail'])) {
                    if (!empty($_POST['SuratperjanjiankerjaT']['dasarpengerjaan'])) {
                        SuratperjanjiankerjaT::model()->updateByPk($id, array('dasarpengerjaan' => $_POST['SuratperjanjiankerjaT']['dasarpengerjaan']));
                    }
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $model->suratperjanjiankerja_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
                }
            } catch (CException $e) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal Disimpan " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
        ));
    }

    /**
     * Cetak 
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows3';
        $model = SuratperjanjiankerjaT::model()->findByPk($id);
        $modPPK = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $model->pejabatpembuatkomitmen_id));
        $modPenawaran = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
        $cri = new CDbCriteria();
        $cri->addCondition('suratperjanjiankerja_id = ' . $model->suratperjanjiankerja_id);
        $cri->join = 'left join pasalperjanjian_m p on t.pasalperjanjian_id = p.pasalperjanjian_id';
        $cri->order = 'p.urutan asc';
        $cri->select = 'p.pasalperjanjian_nama, p.pasalperjanjian_uraian, t.pasalperjanjian_isi ';
        $modDetail = SuratperjanjiankerjadetT::model()->findAll($cri);
        $isiPesan = '';
        $isiPesan .= '<table width="100%">';
        if (!empty($modDetail)) {
            foreach ($modDetail as $modDet) {
                // value yang akan diganti harus ada di atas 
                $isiPesan .= '
                                <tr>
                                    <td style="text-align: center"> <b>' . $modDet->pasalperjanjian_nama . '</b> </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center"> <b>' . $modDet->pasalperjanjian_uraian . '</b> </td>
                                </tr>
                                <tr>
                                    <td style="text-align: justify"> ' . $modDet->pasalperjanjian_isi . ' </td>
                                </tr>';
                $attributes = $modDet->getAttributes();
                foreach ($attributes as $attributes => $values) {
                    $modMapping = MappingrekeninganggaranM::model()->findByPk($model->mappingrekeninganggaran_id);
                    $isiPesan = str_replace("{{" . $attributes . "}}", $values, $isiPesan);
                }
                
                $nomor_rekening4 = $modMapping->rekeninganggaran5->rekeninganggaran4->rekeninganggaran4_kode;
                $nomor_rekening3 = $modMapping->rekeninganggaran5->rekeninganggaran3->rekeninganggaran3_kode;
                $nomor_rekening2 = $modMapping->rekeninganggaran5->rekeninganggaran2->rekeninganggaran2_kode;
                $nomor_rekening1 = $modMapping->rekeninganggaran5->rekeninganggaran1->rekeninganggaran1_kode;
                $isiPesan = str_replace("{{jangka_waktu}}", $model->jangka_waktu, $isiPesan);
                $isiPesan = str_replace("{{tahunanggaran}}", $model->tahunanggaran, $isiPesan);
                $isiPesan = str_replace("{{no_dpa}}", $model->no_dpa, $isiPesan);
                $isiPesan = str_replace("{{kode_program}}", $modMapping->kegiatanprogram->subprogramkerja->programkerja->programkerja_kode, $isiPesan);
                $isiPesan = str_replace("{{kode_kegiatan}}", $modMapping->kegiatanprogram->kegiatanprogram_kode, $isiPesan);
                $isiPesan = str_replace("{{kode_rekening}}", $nomor_rekening1 . " ".$nomor_rekening2." ".$nomor_rekening3." ".$nomor_rekening4." ".$modMapping->rekeninganggaran5_kode, $isiPesan);
                $isiPesan = str_replace("{{nama_rekening}}", $modMapping->nama_rekeninganggaran5, $isiPesan);
                $isiPesan = str_replace("{{supplier_nama}}", $model->supplier->supplier_nama, $isiPesan);
                $isiPesan = str_replace("{{nomor_rekening}}", !empty($model->supplier->supplier_norekening) ? $model->supplier->supplier_norekening : "-", $isiPesan);
                $isiPesan = str_replace("{{jangka_waktu_huruf}}", MyFormatter::kataTerbilang($model->jangka_waktu), $isiPesan);
                $isiPesan = str_replace("{{nilai_kontrak}}", MyFormatter::formatUang($model->nilaikontrak, "Rp", 2), $isiPesan);
                $isiPesan = str_replace("{{tglawal_pekerjaan}}", MyFormatter::formatDateTimeId(date('d M Y', strtotime($model->tglawal_pekerjaan))), $isiPesan);
                $isiPesan = str_replace("{{tglakhir_pekerjaan}}", MyFormatter::formatDateTimeId(date('d M Y', strtotime($model->tglakhir_pekerjaan))), $isiPesan);
                $isiPesan = str_replace("{{tgl_dpa}}", MyFormatter::formatDateTimeId(date('d M Y', strtotime($model->tgl_dpa))), $isiPesan);
            }
        }
        $isiPesan .= '</table>';
        $model->dasar = $isiPesan;
        $this->render('print', array('model' => $model, 'modPPK' => $modPPK, 'modPenawaran' => $modPenawaran));
    }

}
