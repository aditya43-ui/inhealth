<?php
/**
 * Controller untuk Perintah Pengiriman 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class PerintahPengirimanTController extends MyAuthController{
    
    /**
     * Halaman Index Perintah Pengiriman
     * @param type $id
     * @param type $perintahpengiriman_id
     */
    public function actionIndex($id = null, $perintahpengiriman_id = null){
        $this->layout = '//layouts/iframe';
        $cekPerintah = PerintahpengirimanT::model()->findByAttributes(array('perintahpengiriman_id' => $perintahpengiriman_id));
        $cekSPK = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
        $modRincianSPK = new SuratperjanjiankerjarincianT();
        $modelDetail = new PerintahpengirimandetT();
        if (empty($cekPerintah)) {
            $model = new PerintahpengirimanT();
            if (!empty($cekSPK)) {
                $modRincianSPK = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $cekSPK->suratperjanjiankerja_id)); 
                $model->cek_spk = true;
                $model->suratperjanjiankerja_id = $cekSPK->suratperjanjiankerja_id; 
                $model->nosuratperjanjiankerja = $cekSPK->nosuratperjanjiankerja; 
                $model->tglsuratperjanjian = MyFormatter::formatDateTimeForUser($cekSPK->tglsuratperjanjian); 
                $model->pegppk_id = $cekSPK->pejabatpembuatkomitmen->pegawai_id;
                $model->pegppk_nama = $cekSPK->pejabatpembuatkomitmen->namaLengkap;
                $model->pegppk_nip = $cekSPK->pejabatpembuatkomitmen->nomorindukpegawai;
                $model->pegppk_alamat = $cekSPK->pejabatpembuatkomitmen->alamat_pegawai;
                $model->jangka_pelaksanaan = CustomFunction::hitungHari($cekSPK->tglawal_pekerjaan, $cekSPK->tglakhir_pekerjaan); 
                $model->tanggal_awal = MyFormatter::formatDateTimeForUser(date("d M Y", strtotime($cekSPK->tglawal_pekerjaan)));
                $model->tanggal_akhir = MyFormatter::formatDateTimeForUser(date("d M Y", strtotime($cekSPK->tglakhir_pekerjaan)));
                $model->supplier_id = $cekSPK->supplier_id;
                $model->nama_supplier = $cekSPK->supplier->supplier_nama;
                $model->alamat_supplier = $cekSPK->supplier->supplier_alamat;
                $model->direktur_supplier = $cekSPK->supplier->direktursupplier;
                $model->nama_pekerjaan = $cekSPK->namapekerjaan;
                $model->jumlah_pajak = $cekSPK->jumlah_pajak;
                $model->jumlah_harga = $cekSPK->jumlah_harga;
                $model->pajak_persen = 0;
                $model->total_harga = $model->jumlah_harga + $model->jumlah_pajak;
                $model->total_dibulatkan = $cekSPK->total_pembulatan;
                $modSPK = SuratperjanjiankerjaT::model()->findByPK($model->suratperjanjiankerja_id);
                $modSyaratKhusus = SyaratkhususkontrakT::model()->findByAttributes(array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id));
                if(!empty($modSyaratKhusus)){
                    $model->denda_keterangan = !empty($modSyaratKhusus->ketentuan_denda) ? $modSyaratKhusus->ketentuan_denda : null;
                }
                $modTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $cekSPK->suratperjanjiankerja_id));
                $cekPerintah = PerintahpengirimanT::model()->findAllByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
                $jumlahpemeriksaan = count($cekPerintah)+1;

                $model->termin_jumlah = !empty($modTermin) ? count($modTermin) : 0;
                $model->termin_angka = !empty($cekPerintah) ? count($cekPerintah)+1 : 1;            
                $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id'=>$cekSPK->suratperjanjiankerja_id, 'urutan'=>$jumlahpemeriksaan));
                if(!empty($cekTermin)){
                    $model->terminke = $cekTermin->terminke;
                    $model->termin_persen = $cekTermin->jumlah_persen;
                    $model->total_pembayaran = $cekTermin->jumlah_harga; 
                }
            } else {
                $model->cek_spk = false;
            }
            $model->perintahpengiriman_nomor = '-- Otomatis --';
            $model->perintahpengiriman_tanggal = date("d M Y H:i:s");
        } else {
            $model = $cekPerintah;
            $model->perintahpengiriman_tanggal = MyFormatter::formatDateTimeForUser($model->perintahpengiriman_tanggal); 
            $model->nosuratperjanjiankerja = $cekSPK->nosuratperjanjiankerja; 
            $model->tglsuratperjanjian = MyFormatter::formatDateTimeForUser($cekSPK->tglsuratperjanjian); 
            $model->pegppk_id = $cekPerintah->pegppk->pegawai_id;
            $model->pegppk_nama = $cekPerintah->pegppk->namaLengkap;
            $model->pegppk_nip = $cekPerintah->pegppk->nomorindukpegawai;
            $model->pegppk_alamat = $cekPerintah->pegppk->alamat_pegawai;
            $model->tanggal_awal = MyFormatter::formatDateTimeForUser(date("d M Y", strtotime($cekPerintah->tanggal_awal)));
            $model->tanggal_akhir = MyFormatter::formatDateTimeForUser(date("d M Y", strtotime($cekPerintah->tanggal_akhir)));
            $model->supplier_id = $cekPerintah->supplier_id;
            $model->nama_supplier = $cekPerintah->supplier->supplier_nama;
            $model->alamat_supplier = $cekPerintah->supplier->supplier_alamat;
            $model->direktur_supplier = $cekPerintah->supplier->direktursupplier;
            
            $modTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $cekSPK->suratperjanjiankerja_id));
            $cekPerintah = PerintahpengirimanT::model()->findAllByAttributes(array('persiapanpengadaan_id' => $id));

            $model->termin_jumlah = !empty($modTermin) ? count($modTermin) : 0;
            if($model->terminke == 'I'){
                $model->termin_angka = 1;  
            }else if($model->terminke == 'II'){
                $model->termin_angka = 2;  
            }else if($model->terminke == 'III'){
                $model->termin_angka = 3;  
            }
        }
                
        if (isset($_POST['PerintahpengirimanT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $model->attributes = $_POST['PerintahpengirimanT'];
                $model->perintahpengiriman_tanggal = MyFormatter::formatDateTimeForDb($model->perintahpengiriman_tanggal);
                $model->total_dibulatkan = $model->total_harga;

                if (empty($_GET['perintahpengiriman_id'])) {
                    $model->persiapanpengadaan_id = $id; 
                    $model->perintahpengiriman_nomor = MyGenerator::noPerintahPengiriman(); 
                    $model->suratperjanjiankerja_id = $cekSPK->suratperjanjiankerja_id;
                    $model->tanggal_awal = MyFormatter::formatDateTimeForDb($cekSPK->tglawal_pekerjaan);
                    $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($cekSPK->tglakhir_pekerjaan);
                    $model->nama_pekerjaan = $cekSPK->namapekerjaan;
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date ('Y-m-d H:i:s');
                    $modTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'urutan' => $model->termin_angka));
                    $model->terminke = $modTermin->terminke; 
                    $model->termin_persen = $modTermin->jumlah_persen; 
                    $modRincian = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                    if ($model->save()) {
                        foreach($_POST['PerintahpengirimandetT'] as $key => $value){
                            $modelDetail = new PerintahpengirimandetT();
                            $modelDetail->perintahpengiriman_id = $model->perintahpengiriman_id;
                            $modelDetail->attributes = $value;
                            $ok = $ok && $modelDetail->save();
                        }
                    }
                } else {
                    $model->tanggal_awal = MyFormatter::formatDateTimeForDb($model->tanggal_awal);
                    $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($model->tanggal_akhir);
                    $model->update_time = date ('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $ok = $ok && $model->save();
                    if($ok){
                        foreach($_POST['PerintahpengirimandetT'] as $key => $value){
                            $modelDetail = PerintahpengirimandetT::model()->findByPk($value['perintahpengirimandet_id']);
                            $modelDetail->perintahpengiriman_id = $model->perintahpengiriman_id;
                            $modelDetail->attributes = $value;
                            $ok = $ok && $modelDetail->save();
                        }
                    }
                }
                
                $modSPK = SuratperjanjiankerjaT::model()->findByPK($model->suratperjanjiankerja_id);
                if(!empty($modSPK)){
                    $modSPK->suratperjanjiankerja_status = 'SP Pengiriman Diterbitkan';
                    $modSPK->update();
                }
                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('index', array('model' => $model, 'modRincianSPK' => $modRincianSPK, 'modelDetail' => $modelDetail));
    }
    
    /**
     * Detail Perintah Pengiriman
     * @param type $id
     */
    public function actionDetail($id){
        $this->layout = '//layouts/iframe';
        $model = PerintahpengirimanT::model()->findByPk($id);
        $cekSPK = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
        $modRincianSPK = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $cekSPK->suratperjanjiankerja_id)); 
        $modelDetail = new PerintahpengirimandetT();
        $model->perintahpengiriman_tanggal = MyFormatter::formatDateTimeForUser($model->perintahpengiriman_tanggal); 
        $model->nosuratperjanjiankerja = $cekSPK->nosuratperjanjiankerja; 
        $model->tglsuratperjanjian = MyFormatter::formatDateTimeForUser($cekSPK->tglsuratperjanjian); 
        $model->pegppk_id = $model->pegppk->pegawai_id;
        $model->pegppk_nama = $model->pegppk->namaLengkap;
        $model->pegppk_nip = $model->pegppk->nomorindukpegawai;
        $model->pegppk_alamat = $model->pegppk->alamat_pegawai;
        $model->tanggal_awal = MyFormatter::formatDateTimeForUser(date("d M Y", strtotime($model->tanggal_awal)));
        $model->tanggal_akhir = MyFormatter::formatDateTimeForUser(date("d M Y", strtotime($model->tanggal_akhir)));
        $model->supplier_id = $model->supplier_id;
        $model->nama_supplier = $model->supplier->supplier_nama;
        $model->alamat_supplier = $model->supplier->supplier_alamat;
        $model->direktur_supplier = $model->supplier->direktursupplier;

        $modTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $cekSPK->suratperjanjiankerja_id));

        $model->termin_jumlah = !empty($modTermin) ? count($modTermin) : 0;
        if($model->terminke == 'I'){
            $model->termin_angka = 1;  
        }else if($model->terminke == 'II'){
            $model->termin_angka = 2;  
        }else if($model->terminke == 'III'){
            $model->termin_angka = 3;  
        }
        
        $this->render('detail', array('cekSPK' => $cekSPK, 'model' => $model, 'modRincianSPK' => $modRincianSPK, 'modelDetail' => $modelDetail));
    }
    
    /**
     * Load riwayat
     */
    public function actionGetRiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $persiapanpengadaan_id = $_POST['persiapanpengadaan_id'];
            $modRiwayat = PerintahpengirimanT::model()->findAllByAttributes(array('persiapanpengadaan_id' => $persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true), array('order' => 'perintahpengiriman_id'));
            $i = 1;
            $tr = '';
            foreach ($modRiwayat as $row) {
                $modSurat = SuratperjanjiankerjaT::model()->findByPk($row->suratperjanjiankerja_id);
                if($modSurat->istermin == true){
                    $termin = "Termin ". $row->terminke . ' (' . $row->termin_persen . '%)';
                }else{
                    $termin = 'Non Termin';
                }
                $urlDetail = $this->createUrl('detail', array('id' => $row->perintahpengiriman_id));
                $urlEdit = $this->createUrl('index', array('id' => $row->persiapanpengadaan_id, 'perintahpengiriman_id' => $row->perintahpengiriman_id));
                $tr .= '<tr>';
                    $tr .= '<td>' . $i . ' </td>';
                    $tr .= '<td>' . CHtml::link($row->perintahpengiriman_nomor, $urlDetail, array('title' => 'Detail', 'rel' => 'tooltip',"target"=>"frame2", "onclick"=>"$('#dialog2').dialog('open');")).'</td>';
                    $tr .= '<td>' . $row->nomor_dokumen . '</td>';
                    $tr .= '<td>' . MyFormatter::formatDateTimeForUser($row->perintahpengiriman_tanggal). '</td>';
                    $tr .= '<td>' . $termin .'</td>';
                    $tr .= '<td>' . $row->supplier->supplier_nama. '</td>';
                    $tr .= '<td>' . $row->pegppk->namaLengkap . '</td>';
                    $tr .= '<td>' . CHtml::link('<i class="entypo-pencil"></i>', $urlEdit, array('title' => 'Ubah Data', 'rel' => 'tooltip')) . '</td>';
                    $tr .= '<td>' . CHtml::link('<i class="entypo-print"></i>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip','onclick'=>"window.open('" . $this->createUrl('print', array('id' => $row->perintahpengiriman_id)) ."', 'printwin', 'left=100,top=100,width=790,height=1120')")). '</td>';
                    
                $tr .= '</tr>';
                $i++;
            }

            $data['tr'] = $tr;

            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Cetak transaksi perintah pengiriman
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = PerintahpengirimanT::model()->findByPk($id);
        $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $modsurat = SuratperjanjiankerjaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
        $tanggal_awal  = strtotime($model->tanggal_awal);
        $tanggal_akhir   = strtotime($model->tanggal_akhir);
        $diff           = $tanggal_akhir - $tanggal_awal;
        $selisihwaktu=floor($diff / (60 * 60 * 24));
        $modsurat->waktuselesai = $selisihwaktu;
        
        if (!empty($model->perintahpengiriman_id)) {
            $modSPK = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
            $isiPesan = "-";
            $criteria = new CDbCriteria;
            $criteria->addCondition("konfigtemplatesurat_aktif=true");
            $criteria->addCondition("konfigtemplatesurat_id=" . $model->konfigtemplatesurat_id);
            $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

            foreach ($modTemplate as $i => $templateTugas) {
                $isiPesan = $templateTugas->konfigtemplatesurat_isi;
                $isiPesan = "${isiPesan}";
                $attributes = $model->getAttributes();
                
                //$attributes = $modSurat->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{tanggal_awal}}",date('d ', strtotime($model->tanggal_awal)) . MyFormatter::getMonthId(date('m', strtotime($model->tanggal_awal))) . date(' Y', strtotime($model->tanggal_awal)), $isiPesan);  
                    $isiPesan = str_replace("{{tanggal_akhir}}",date('d ', strtotime($model->tanggal_akhir)) . MyFormatter::getMonthId(date('m', strtotime($model->tanggal_akhir))) . date(' Y', strtotime($model->tanggal_akhir)), $isiPesan); 
                    $isiPesan = str_replace("{{nomorsuratperjanjian}}",$modsurat->nosuratperjanjiankerja , $isiPesan);
                    $isiPesan = str_replace("{{nama_direktur}}",$model->supplier->direktursupplier , $isiPesan);
                    $isiPesan = str_replace("{{supplier_alamat}}",$model->supplier->supplier_alamat , $isiPesan);
                    $isiPesan = str_replace("{{supplier_nama}}",$model->supplier->supplier_nama , $isiPesan);
                    $isiPesan = str_replace("{{nomor_dokumen_spk}}",$modsurat->nomor_dokumen , $isiPesan);
                    $isiPesan = str_replace("{{namapembuatkomitmen}}",$modsurat->namapembuatkomitmen , $isiPesan);
                    $isiPesan = str_replace("{{alamat}}",$modsurat->alamat , $isiPesan);
                    $isiPesan = str_replace("{{alamatlokasi_rumahsakit}}",$modProfilRs->alamatlokasi_rumahsakit , $isiPesan);
                    $isiPesan = str_replace("{{tglsuratperjanjian}}",date('d ', strtotime($modsurat->tglsuratperjanjian)) . MyFormatter::getMonthId(date('m', strtotime($modsurat->tglsuratperjanjian))) . date(' Y', strtotime($modsurat->tglsuratperjanjian)), $isiPesan);
                    $isiPesan = str_replace("{{hari}}",$modsurat->waktuselesai, $isiPesan);
                    $isiPesan = str_replace("{{hari_terbilang}}",trim(ucwords(MyFormatter::kataTerbilang($modsurat->waktuselesai))), $isiPesan);
                    $isiPesan = str_replace("{{terminke}}", $model->terminke, $isiPesan);   
                }
            }
            $modDetail = PerintahpengirimandetT::model()->findAllByAttributes(array('perintahpengiriman_id' => $model->perintahpengiriman_id));
            if ($modSPK->istermin == false) {
                $a = '<table border="1" width="105%" id="settable"> ';
                 } else {
                $a = '<table border="1" width="125%" id="settable"> ';
            }
            
            $no = 1;
            $jumlah_harga=0;
             $a.='<thead>
                        <tr>
                            <th> No. </th>
                            <th> Nama Barang </th>
                            <th> MERK </th>
                            <th> JML</th>
                            <th> SAT</th>
                            <th> HARGA SATUAN </th>
                            <th> JUMLAH HARGA </th>
                        </tr>
                    </thead>';
            foreach ($modDetail as $detail) {
               
                $modBarang = BarangM::model()->findByPk($detail->barang_id);
                $merk=!empty($modBarang->barang_merk)?$modBarang->barang_merk:"-";
                $a .= '<tbody><tr>
                            <td>' . $no++ . '. </td>
                            <td style="text-align: left">' . $detail->barang_nama . ' </td>
                            <td style="text-align: left"> ' . $merk . '</td>
                            <td style="text-align: right"> ' . $detail->barang_jumlah . '</td>
                            <td style="text-align: left"> ' . $detail->barang_satuan . '</td>
                            <td style="text-align: right"> ' . MyFormatter::formatNumberForPrint($detail->harga_satuan,2) . '</td>
                            <td style="text-align: right"> ' . MyFormatter::formatNumberForPrint($detail->jumlah_harga,2) . '</td>    
                        </tr></tbody>';
                $jumlah_harga+=$detail->jumlah_harga;
                
            }
            $a .= '<tfooter>
                        <tr>
                            <td colspan="5"></td>
                            <td >JUMLAH</td>
                            <td style="text-align: right"> ' . MyFormatter::formatNumberForPrint($jumlah_harga,2) . '</td>    
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                            <td >PPN 10%</td>
                            <td style="text-align: right"> ' . MyFormatter::formatNumberForPrint($detail->jumlah_pajak,2) . '</td>    
                        </tr>
                        <tr>
                            <td colspan="6"><b>TOTAL</b></td>
                            <td style="text-align: right"> ' . MyFormatter::formatNumberForPrint(($jumlah_harga+$detail->jumlah_pajak),2) . '</td>    
                        </tr>
                   </tfooter>';
            $a .= '</table>';
            $isiPesan = str_replace("{{tabelrincian_barang}}", $a, $isiPesan);
            $model->dasar = $isiPesan;
        }
        $this->render('print', array('model' => $model, 'modSurat' => $modsurat));
    }
}