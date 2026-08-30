<?php

/**
 * Transaksi Berita Acara Negosiasi/Klarifikasi
 * 
 * @author  Andyka Putra <andykaputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class BANegosiasiController extends MyAuthController {

    /**
     * Default menu Transaksi Berita Acara Negosiasi/Klarifikasi
     * @param integer $id
     */
    public function actionIndex($id) {
        $this->layout = '//layouts/iframe';
        $modelDetail = new PenawaranpenyediadetT;
        $modPersiapanPengadaan = PersiapanpengadaanT::model()->findByPk($id);
        $cekmodel = BanegosiasiT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
        $cekNamaPekerjaan = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $id));

        if (empty($cekmodel)) {
            $model = new BanegosiasiT;
            $model->banegosiasi_nomor = "-Otomatis-";
            $model->banegosiasi_tanggal = date('d M Y H:i:s');
            
            $cekPenawaran = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            $model->penawaranpenyedia_id = !empty($cekPenawaran) ? $cekPenawaran->penawaranpenyedia_id : null;
            $model->penawaranpenyedia_nomor = !empty($cekPenawaran) ? $cekPenawaran->penawaranpenyedia_nomor : '';
            $model->supplier_id = !empty($cekPenawaran) ? $cekPenawaran->supplier_id : null;
            $model->supplier_nama = !empty($cekPenawaran) ? $cekPenawaran->supplier->supplier_nama : '';
            $model->alamat_supplier = !empty($cekPenawaran) ? $cekPenawaran->supplier->supplier_alamat : '';
            $model->nama_direktur = !empty($cekPenawaran) ? $cekPenawaran->supplier->direktursupplier : '';

            $cekInformasiUmum = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            if (!empty($cekInformasiUmum->pegpengadaan_id)) {
                $model->pegpengadaan_id = !empty($cekInformasiUmum) ? $cekInformasiUmum->pegpengadaan_id : null;
                $model->pejabat_pengadaan = !empty($cekInformasiUmum) ? $cekInformasiUmum->pegpengadaan->namaLengkap : '';
                $model->pejabat_pengadaan_nip = !empty($cekInformasiUmum) ? $cekInformasiUmum->pegpengadaan->nomorindukpegawai : '';
                $model->jabatan_pengadaan = !empty($cekInformasiUmum) ? $cekInformasiUmum->jabatan_pengadaan : '';
                $model->nomor_sk = !empty($cekInformasiUmum) ? $cekInformasiUmum->no_sk : '';
                $model->tanggal_sk = !empty($cekInformasiUmum) ? date('d M Y', strtotime($cekInformasiUmum->tgl_sk)) : '';
            }
            $modPersiapan = PersiapanpengadaanT::model()->findByPk($id); 
            $model->harga_setelah_negosiasi = number_format($modPersiapan->total_hargaseluruhnya, 2, ",", "."); 
            $model->selisih_harga = number_format(0, 2, ",", "."); 
            
            $modDet = PersiapanpengadaandetT::model()->findAllByAttributes(array('persiapanpengadaan_id' => $id));
        } else {
            $model = BanegosiasiT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            $model->banegosiasi_tanggal = date('d M Y H:i:s', strtotime($model->banegosiasi_tanggal));
            $model->penawaranpenyedia_nomor = $model->penawaranpenyedia->penawaranpenyedia_nomor;
            $model->supplier_nama = $model->supplier->supplier_nama;
            $model->alamat_supplier = $model->supplier->supplier_alamat;
            $model->nama_direktur = $model->direktur_supplier;
            $model->harga_setelah_negosiasi = number_format($model->pembulatan_negosiasi, 2, ",", "."); 
            $model->selisih_harga = number_format($model->selisih_harga, 2, ",", "."); 
            if (!empty($model->pegpengadaan_id)) {
                $model->pejabat_pengadaan = $model->pegpengadaan->namaLengkap;
                $model->pejabat_pengadaan_nip = $model->pegpengadaan->nomorindukpegawai;
                $model->tanggal_sk = date('d M Y', strtotime($model->tanggal_sk));
            }
            $model->dokumen_pendukung = $model->dokumen_pendukung;

            $cekPenawaran = PenawaranpenyediaT::model()->findByAttributes(array('penawaranpenyedia_id' => $model->penawaranpenyedia_id, 'isbatal' => false, 'isaddendum' => true));
            if(!empty($cekPenawaran)){
                $model->penawaranpenyedia_id = $cekPenawaran->penawaranpenyedia_id;
                $modDet = PenawaranpenyediadetT::model()->findAllByAttributes(array('penawaranpenyedia_id' => $cekPenawaran->penawaranpenyedia_id, 'banegosiasi_id' =>$model->banegosiasi_id));
            }else{
                $modDet = PersiapanpengadaandetT::model()->findAllByAttributes(array('persiapanpengadaan_id' => $id));
            }
        }

        if (isset($_POST['BanegosiasiT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $model->attributes = $_POST['BanegosiasiT'];
                $model->persiapanpengadaan_id = $id;
                $model->banegosiasi_tanggal = MyFormatter::formatDateTimeForDb($_POST['BanegosiasiT']['banegosiasi_tanggal']);
                $model->direktur_supplier = $_POST['BanegosiasiT']['nama_direktur'];
                $model->tanggal_sk = !empty($_POST['BanegosiasiT']['tanggal_sk']) ? MyFormatter::formatDateTimeForDb($_POST['BanegosiasiT']['tanggal_sk']) : null;
                $model->nama_pekerjaan = $cekNamaPekerjaan->nama_pekerjaan;

                if (empty($model->banegosiasi_id)) {
                    $model->banegosiasi_nomor = MyGenerator::NoBANegosiasi();
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                } else {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }
                
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                
                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if(!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->banegosiasi_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathBaNegosiasiDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathBaNegosiasiDirectory())){
                        mkdir(Params::pathBaNegosiasiDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = BanegosiasiT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                $ok = $ok && $model->save();
                if (isset($_POST['PenawaranpenyediadetT']) && $ok) {
                    foreach ($_POST['PenawaranpenyediadetT'] as $key => $value) {
                        if (empty($value['penawaranpenyediadet_id'])) {
                            $modelDetail = new PenawaranpenyediadetT;
                            
                            $cekDet = PersiapanpengadaandetT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'dokumenpelaksanaananggarandet_id' => $value['dokumenpelaksanaananggarandet_id']));
                            $modDpadet = DokumenpelaksanaananggarandetT::model()->findByPk($value['dokumenpelaksanaananggarandet_id']);

                            if((MyFormatter::formatNumberForDb($value['jumlah_negosiasi'])) > (MyFormatter::formatNumberForDb($cekDet->jumlah_harga))){

                                $selisih_pagu = $value['jumlah_negosiasi'] - $cekDet->jumlah_harga;
                                $modDpadet->sisapagu_pengadaan = $modDpadet->sisapagu_pengadaan - $selisih_pagu;

                            }else if((MyFormatter::formatNumberForDb($value['jumlah_negosiasi'])) < (MyFormatter::formatNumberForDb($cekDet->jumlah_harga))){

                                $selisih_pagu = $cekDet->jumlah_harga - $value['jumlah_negosiasi'];

                                $modDpadet->sisapagu_pengadaan = $modDpadet->sisapagu_pengadaan + $selisih_pagu;   
                            }

                            if($modDpadet->sisapagu_pengadaan == 0){
                                $modDpadet->pengadaan_status = true;
                            }else if($modDpadet->sisapagu_pengadaan > 0){
                                $modDpadet->pengadaan_status = false;
                            }
                            $modDpadet->save();
                            
                            $modelDetail->attributes = $value;
                            $modelDetail->banegosiasi_id = $model->banegosiasi_id;
                            $modelDetail->penawaranpenyedia_id = $model->penawaranpenyedia_id;
                            $modelDetail->dokumenpelaksanaananggarandet_id = $value['dokumenpelaksanaananggarandet_id'];
                            $ok = $ok && $modelDetail->save();
                        } else {
                            $modelDetail = PenawaranpenyediadetT::model()->findByPk($value['penawaranpenyediadet_id']);
                            
                            $cekDet = PenawaranpenyediadetT::model()->findByPk($value['penawaranpenyediadet_id']);
                            $modDpadet = DokumenpelaksanaananggarandetT::model()->findByPk($value['dokumenpelaksanaananggarandet_id']);

                            if((MyFormatter::formatNumberForDb($value['jumlah_negosiasi'])) > (MyFormatter::formatNumberForDb($cekDet->jumlah_negosiasi))){

                                $selisih_pagu = $value['jumlah_negosiasi'] - $cekDet->jumlah_negosiasi;
                                $modDpadet->sisapagu_pengadaan = $modDpadet->sisapagu_pengadaan - $selisih_pagu;

                            }else if((MyFormatter::formatNumberForDb($value['jumlah_negosiasi'])) < (MyFormatter::formatNumberForDb($cekDet->jumlah_negosiasi))){

                                $selisih_pagu = $cekDet->jumlah_negosiasi - $value['jumlah_negosiasi'];

                                $modDpadet->sisapagu_pengadaan = $modDpadet->sisapagu_pengadaan + $selisih_pagu;   
                            }

                            if($modDpadet->sisapagu_pengadaan == 0){
                                $modDpadet->pengadaan_status = true;
                            }else if($modDpadet->sisapagu_pengadaan > 0){
                                $modDpadet->pengadaan_status = false;
                            }
                            $modDpadet->save();
                            
                            $modelDetail->attributes = $value;
                            $modelDetail->banegosiasi_id = $model->banegosiasi_id;
                            $modelDetail->penawaranpenyedia_id = $model->penawaranpenyedia_id;
                            $modelDetail->dokumenpelaksanaananggarandet_id = $value['dokumenpelaksanaananggarandet_id'];
                            $ok = $ok && $modelDetail->save();
                        }
                    }
                }

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $model->persiapanpengadaan_id, 'banegosiasi_id' => $model->banegosiasi_id, 'sukses' => 1));
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
            'modelDetail' => $modelDetail,
            'modPersiapanPengadaan' => $modPersiapanPengadaan,
            'modDet' => $modDet,
        ));
    }

    /**
     * Cetak Berita Acara Transaksi Negosiasi/Klarifikasi
     * @param integer $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = BanegosiasiT::model()->findByPk($id);

        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_id = " . $model->konfigtemplatesurat_id);
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{ba_hari}}", ucwords(MyFormatter::getDayName(date('D', strtotime($model->banegosiasi_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->banegosiasi_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_bulan_terbilang}}", MyFormatter::getMonthId(date('m', strtotime($model->banegosiasi_tanggal))), $isiPesan);
                $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->banegosiasi_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{tanggal_sk}}", date('d ', strtotime($model->tanggal_sk)) . MyFormatter::getMonthId(date('m', strtotime($model->tanggal_sk))) . date(' Y', strtotime($model->tanggal_sk)), $isiPesan);
                $isiPesan = str_replace("{{pembulatan_negosiasi_terbilang}}", ucwords(MyFormatter::kataTerbilang($model->pembulatan_negosiasi)) . ' Rupiah ', $isiPesan);
                $isiPesan = str_replace("{{pembulatan_negosiasi}}", number_format($model->pembulatan_negosiasi), $isiPesan);
            }

            $cekSupplier = SupplierM::model()->findByPk($model->supplier_id);
            $attributes = $cekSupplier->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }

            $cekpersiapanpengadaan = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
            $attributes = $cekpersiapanpengadaan->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $cekpengadaansumberdana = PengadaansumberdanaT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $cekpersiapanpengadaan->rencanaumumpengadaan_id));
                if (!empty($cekpengadaansumberdana)) {
                    //Kode Rekening
                    $koderekening = array();
                    foreach ($cekpengadaansumberdana as $values) {
                        $cekRekening = Rekening5M::model()->findByPk($values->rekening5_id);
                        $koderekening[] = !empty($cekRekening) ? $cekRekening->kdrekening5 : ' ';
                    }
                    $isiPesan = str_replace("{{kode_rekening}}", implode(' , ', $koderekening), $isiPesan);
                } else {
                    $isiPesan = str_replace("{{kode_rekening}}", '-', $isiPesan);
                }
            }

            $cekdet = PenawaranpenyediadetT::model()->findAllByAttributes(array('banegosiasi_id' => $model->banegosiasi_id));
            $a = '<table border="1" width="100%" style="color: #303641 !important;">
                    <thead>
                        <tr>
                            <th rowspan="2" style="text-align: center">No.</th>
                            <th rowspan="2" style="text-align: center">NAMA BARANG</th>
                            <th rowspan="2" style="text-align: center">JML</th>
                            <th rowspan="2" style="text-align: center">SAT</th>
                            <td colspan="2" style="color: #303641 !important; font-size: 12px; font-weight: bold; text-align: center">HARGA PENAWARAN</td>
                            <td colspan="2" style="color: #303641 !important; font-size: 12px; font-weight: bold; text-align: center">HARGA NEGOSIASI</td>
                        </tr>
                        <tr>
                            <th style="text-align: center">HARGA SATUAN</th>
                            <th style="text-align: center">JUMLAH HARGA</th>
                            <th style="text-align: center">HARGA SATUAN</th>
                            <th style="text-align: center">JUMLAH HARGA</th>
                        </tr>
                    </thead>
                    <tbody>';
            $no = 1;
            foreach ($cekdet as $value) {
                $a .= '<tr>
                            <td style="text-align: center">' . $no++ . '. </td>
                            <td style="text-align: left">' . $value->nama_barang . '</td>
                            <td style="text-align: center">' . $value->jumlah_barang . '</td>
                            <td style="text-align: center">' . $value->satuan_barang . '</td>
                            <td style="text-align: right">' . number_format($value->harga_penawaran,2, ',', '.') . '</td>
                            <td style="text-align: right">' . number_format($value->jumlah_penawaran,2, ',', '.') . '</td>
                            <td style="text-align: right">' . number_format($value->harga_negosiasi,2, ',', '.') . '</td>
                            <td style="text-align: right">' . number_format($value->jumlah_negosiasi,2, ',', '.') . '</td>
                        </tr>';
            }
            $a .= ' </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" style="text-align: right">
                                JUMLAH &nbsp;&nbsp;&nbsp;<br>
                                PPN 10% &nbsp;&nbsp;&nbsp;<br>
                                TOTAL &nbsp;&nbsp;&nbsp;
                            </th>
                            <th style="text-align: right">
                                ' . number_format($model->jumlah_penawaran,2, ',', '.') . '&nbsp;<br>
                                ' . number_format($model->pajak_penawaran,2, ',', '.') . '&nbsp;<br>
                                ' . number_format($model->total_penawaran,2, ',', '.') . '&nbsp;
                            </th>
                            <th></th>
                            <th style="text-align: right">
                                ' . number_format($model->jumlah_negosiasi,2, ',', '.') . '&nbsp;<br>
                                ' . number_format($model->pajak_negosiasi,2, ',', '.') . '&nbsp;<br>
                                ' . number_format($model->total_negosiasi,2, ',', '.') . '&nbsp;
                            </th>
                        </tr>
                    </tfoot>
                  </table>';
            $isiPesan = str_replace("{{lampiran}}", $a, $isiPesan);
        }
        $model->isi_surat = $isiPesan;

        $this->render('print', array('model' => $model));
    }
    
    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = BanegosiasiT::model()->findByPk($id);
        $path = Params::pathBaNegosiasiDirectory()."/".$filename->dokumen_pendukung;
        if (!empty($filename->dokumen_pendukung)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->dokumen_pendukung, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));   
        }
    }

}
