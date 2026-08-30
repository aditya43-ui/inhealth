<?php

/**
 * Transaksi Berita Acara - Nota Dinas KPA
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class BANotaDinasKpaController extends MyAuthController {
    
    /**
     * Default menu transaksi
     * @param integer $suratperjanjiankerja_id
     * @param integer $notadinaskpa_id
     */
    public function actionIndex($suratperjanjiankerja_id, $notadinaskpa_id = null){
        $this->layout = '//layouts/iframe';
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        if($modSPK->istermin == true){
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $cekNotaDinasKPA = ADNotadinaskpaT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $jumlahpemeriksaan = count($cekNotaDinasKPA) + 1;
        }
        
        if (empty($notadinaskpa_id)) {
            $model = new ADNotadinaskpaT;
            $model->notadinaskpa_nomor = "-Otomatis-";
            $model->notadinaskpa_tanggal = date('d M Y H:i:s');

            if (!empty($modSPK->kuasapenggunaanggaran_id)) {
                $modPegawai = PegawaiM::model()->findByPk($modSPK->kuasapenggunaanggaran_id);
                $model->pegkpa_id = $modSPK->kuasapenggunaanggaran_id;
                $model->pegkpa_nama = $modPegawai->namaLengkap;
                $model->supplier_id = $modSPK->supplier_id;
            }
            if($modSPK->istermin == true){
                $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
                $model->termin_ke = !empty($cekNotaDinasKPA) ? count($cekNotaDinasKPA) + 1 : 1;
                $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'urutan' => $jumlahpemeriksaan));
                if (!empty($cekTermin)) {
                    $model->terminke = $cekTermin->terminke;
                    $model->termin_persen = $cekTermin->jumlah_persen;
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
                $model->terminke = 'I';
                $model->termin_persen = 100;
            }
        } else {
            $model = ADNotadinaskpaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'notadinaskpa_id' => $notadinaskpa_id));
            $modPegawai = PegawaiM::model()->findByPk($model->pegkpa_id);
            $model->pegkpa_nama = $modPegawai->namaLengkap;
            $model->notadinaskpa_tanggal = !empty($model->notadinaskpa_tanggal) ? date('d M Y H:i:s', strtotime($model->notadinaskpa_tanggal)) : '';
            $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
            if($modSPK->istermin == true){
                if ($model->terminke === 'I') {
                    $model->termin_ke = 1;
                } else if ($model->terminke === 'II') {
                    $model->termin_ke = 2;
                } else if ($model->terminke === 'III') {
                    $model->termin_ke = 3;
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
            }
        }
        
        if(isset($_POST['ADNotadinaskpaT'])){
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                
                $model->attributes = $_POST['ADNotadinaskpaT'];
                $model->suratperjanjiankerja_id = $modSPK->suratperjanjiankerja_id;
                $model->supplier_id = $modSPK->supplier_id;
                $model->notadinaskpa_tanggal = MyFormatter::formatDateTimeForDb($model->notadinaskpa_tanggal);
                if(empty($model->notadinaskpa_id)){
                    $model->notadinaskpa_nomor = MyGenerator::noBANotaDinasKpa();
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date ('Y-m-d H:i:s');
                }else{
                    $model->update_time = date ('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }
                
                $ok = $ok && $model->save();
                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'notadinaskpa_id' => $model->notadinaskpa_id ,'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
                
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render('index', array(
            'model' => $model,
            'modSPK' => $modSPK,
        ));
    }
    
    /**
     * Detail Nota Dinas KPA
     * @param integer $suratperjanjiankerja_id
     * @param integer $notadinaskpa_id
     */
    public function actionDetail($suratperjanjiankerja_id, $notadinaskpa_id = null){
        $this->layout = '//layouts/iframe';
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        if($modSPK->istermin == true){
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $cekNotaDinasKPA = ADNotadinaskpaT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $jumlahpemeriksaan = count($cekNotaDinasKPA) + 1;
        }
        
        if (empty($notadinaskpa_id)) {
            $model = new ADNotadinaskpaT;
            $model->notadinaskpa_nomor = "-Otomatis-";
            $model->notadinaskpa_tanggal = date('d M Y H:i:s');

            if (!empty($modSPK->kuasapenggunaanggaran_id)) {
                $modPegawai = PegawaiM::model()->findByPk($modSPK->kuasapenggunaanggaran_id);
                $model->pegkpa_id = $modSPK->kuasapenggunaanggaran_id;
                $model->pegkpa_nama = $modPegawai->namaLengkap;
                $model->supplier_id = $modSPK->supplier_id;
            }
            if($modSPK->istermin == true){
                $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
                $model->termin_ke = !empty($cekNotaDinasKPA) ? count($cekNotaDinasKPA) + 1 : 1;
                $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'urutan' => $jumlahpemeriksaan));
                if (!empty($cekTermin)) {
                    $model->terminke = $cekTermin->terminke;
                    $model->termin_persen = $cekTermin->jumlah_persen;
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
                $model->terminke = 'I';
                $model->termin_persen = 100;
            }
        } else {
            $model = ADNotadinaskpaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'notadinaskpa_id' => $notadinaskpa_id));
            $modPegawai = PegawaiM::model()->findByPk($model->pegkpa_id);
            $model->pegkpa_nama = $modPegawai->namaLengkap;
            $model->notadinaskpa_tanggal = !empty($model->notadinaskpa_tanggal) ? date('d M Y H:i:s', strtotime($model->notadinaskpa_tanggal)) : '';
            $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
            if($modSPK->istermin == true){
                if ($model->terminke === 'I') {
                    $model->termin_ke = 1;
                } else if ($model->terminke === 'II') {
                    $model->termin_ke = 2;
                } else if ($model->terminke === 'III') {
                    $model->termin_ke = 3;
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
            }
        }
        
        $this->render('detail', array(
            'model' => $model,
            'modSPK' => $modSPK,
        ));
    }
    
    /**
     * Menampilkan tabel riwayat
     */
    public function actionGetRiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $suratperjanjiankerja_id = $_POST['suratperjanjiankerja_id'];
            $modRiwayat = ADNotadinaskpaT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id), array('order' => 'notadinaskpa_id'));
            $i = 1;
            $tr = '';
            foreach ($modRiwayat as $row) {
                $modPegawai = PegawaiM::model()->findByPk($row->pegkpa_id);
                $row->pegkpa_nama = $modPegawai->namaLengkap;
                
                $modSurat = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
                if($modSurat->istermin == true){
                    $termin = $row->terminke . ' (' . $row->termin_persen . '%)';
                    $cetak = CHtml::link('<i class="entypo-print"></i>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip', 'onclick' => "window.open('" . $this->createUrl('printTermin', array('id' => $row->notadinaskpa_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')"));
                }else{
                    $termin = 'Non Termin';
                    $cetak = CHtml::link('<i class="entypo-print"></i>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip', 'onclick' => "window.open('" . $this->createUrl('print', array('id' => $row->notadinaskpa_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')"));
                }
                
                $urlDetail = $this->createUrl('Detail', array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'notadinaskpa_id' => $row->notadinaskpa_id));
                $urlEdit = $this->createUrl('Index', array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'notadinaskpa_id' => $row->notadinaskpa_id));
                $tr .= '<tr>';
                $tr .= '<td>' . $i . ' </td>';
                $tr .= '<td>' . Chtml::link($row->notadinaskpa_nomor, $urlDetail, array('title' => 'Detail', 'rel' => 'tooltip',"target"=>"iframe1", "onclick"=>"$('#dialogRiwayat').dialog('open');")).'</td>';
                $tr .= '<td>' . $row->nomor_notadinas . '</td>';
                $tr .= '<td>' . date("d M Y H:i:s", strtotime($row->notadinaskpa_tanggal)) . '</td>';
                $tr .= '<td>' . $termin .'</td>';
                $tr .= '<td>' . $row->pegkpa_nama . '</td>';
                $tr .= '<td>' . $row->notadinaskpa_kepada . '</td>';
                $tr .= '<td>' . CHtml::link('<i class="entypo-pencil"></i>', $urlEdit, array('title' => 'Ubah Data', 'rel' => 'tooltip', 'onclick' => 'setUbahForm(' . $row->notadinaskpa_id, $row->suratperjanjiankerja_id . '); return false')) . '</td>';
                $tr .= '<td>' . $cetak . '</td>';

                $tr .= '</tr>';
                $i++;
            }

            $data['tr'] = $tr;

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    
    /**
     * Cetak Transaksi Nota Dinas KPA
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = ADNotadinaskpaT::model()->findByPk($id);
        
        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_nama = 'Nota Dinas KPA'");
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $cekKPA = PegawaiM::model()->findByPk($model->pegkpa_id);
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{pegkpa_nama}}", !empty($cekKPA) ? $cekKPA->namaLengkap : '', $isiPesan);
                $isiPesan = str_replace("{{notadinaskpa_tanggal}}", date('d ', strtotime($model->notadinaskpa_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->notadinaskpa_tanggal))) . date(' Y', strtotime($model->notadinaskpa_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{terminke}}", $model->terminke, $isiPesan);
            }

            $cekSuratPerjanjian = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
            $attributes = $cekSuratPerjanjian->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{tglsuratperjanjian}}", date('d ', strtotime($cekSuratPerjanjian['tglsuratperjanjian'])) . MyFormatter::getMonthId(date('m', strtotime($cekSuratPerjanjian['tglsuratperjanjian']))) . date(' Y', strtotime($cekSuratPerjanjian['tglsuratperjanjian'])), $isiPesan);
                $ceksupplier = !empty($cekSuratPerjanjian->supplier_id) ? $cekSuratPerjanjian->supplier->supplier_nama : '-';
                $isiPesan = str_replace("{{supplier_nama}}", $ceksupplier, $isiPesan);
                $isiPesan = str_replace("{{nomor_dokumen_spk}}", $cekSuratPerjanjian->nomor_dokumen, $isiPesan);
            }
        }
        $model->isi_surat = $isiPesan;

        $this->render('print', array('model' => $model, 'cekSuratPerjanjian' => $cekSuratPerjanjian));
    }
    
    /**
     * Cetak Transaksi Nota Dinas KPA - Termin
     * @param type $id
     */
    public function actionPrintTermin($id) {
        $this->layout = '//layouts/printWindows';
        $model = ADNotadinaskpaT::model()->findByPk($id);

        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_nama = 'Nota Dinas KPA - Termin'");
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $cekKPA = PegawaiM::model()->findByPk($model->pegkpa_id);
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{pegkpa_nama}}", !empty($cekKPA) ? $cekKPA->namaLengkap : '', $isiPesan);
                $isiPesan = str_replace("{{notadinaskpa_tanggal}}", date('d ', strtotime($model->notadinaskpa_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->notadinaskpa_tanggal))) . date(' Y', strtotime($model->notadinaskpa_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{terminke}}", $model->terminke, $isiPesan);
            }

            $cekSuratPerjanjian = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
            $attributes = $cekSuratPerjanjian->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{tglsuratperjanjian}}", date('d ', strtotime($cekSuratPerjanjian['tglsuratperjanjian'])) . MyFormatter::getMonthId(date('m', strtotime($cekSuratPerjanjian['tglsuratperjanjian']))) . date(' Y', strtotime($cekSuratPerjanjian['tglsuratperjanjian'])), $isiPesan);
                $ceksupplier = !empty($cekSuratPerjanjian->supplier_id) ? $cekSuratPerjanjian->supplier->supplier_nama : '-';
                $isiPesan = str_replace("{{supplier_nama}}", $ceksupplier, $isiPesan);
                $isiPesan = str_replace("{{nomor_dokumen_spk}}", $cekSuratPerjanjian->nomor_dokumen, $isiPesan);
            }
        }
        $model->isi_surat = $isiPesan;

        $this->render('print', array('model' => $model, 'cekSuratPerjanjian' => $cekSuratPerjanjian));
    }

}