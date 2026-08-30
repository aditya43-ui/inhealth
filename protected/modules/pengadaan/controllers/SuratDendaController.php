<?php
/**
 * 
 * controller surat perjanjian sskk
 *
 * @package      application.modules.pengadaan
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @author      Aida Rahmawati <aidarahmawati@.com> 
 * @author      Andyka Putra <andykaputra@.com>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class SuratDendaController extends MyAuthController
{	        
    public $defaultAction = 'index';
    public $path_view = 'pengadaan.views.suratDenda.';
    public $init = '';        
    public $layout = '//layouts/iframe';
    
    /**
     * Controller Transaksi Surat Denda
     * @param type $suratperjanjiankerja_id
     * @param type $suratdenda_id
     */
    public function actionIndex($suratperjanjiankerja_id, $suratdenda_id=null)
    {   
        $modSPK = SuratperjanjiankerjaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        if (empty($modSPK)){
            echo "Surat Perjanjian Kerja tidak ditemukan";die;                        
        }
        
        $modSPKTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id));
        if (empty($modSPKTermin)){
            echo "Surat Perjanjian Kerja Termin tidak ditemukan";die;                        
        }
                        
        $profilRS = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        
        $modSup = ADSupplierM::model()->findByPk($modSPK->supplier_id);
        
        $cekDenda = ADSuratdendaT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$modSPK->suratperjanjiankerja_id));
        $jumlahSurat = count($cekDenda)+1;
        
        $loadTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id'=>$modSPK->suratperjanjiankerja_id, 'terminke'=> CustomFunction::Romawi($jumlahSurat)));
        
                        
        $model = new ADSuratdendaT;
        $model->suratperjanjiankerja_id = $modSPK->suratperjanjiankerja_id;           
        $model->suratdenda_nomor = '-- Otomatis --';
        $model->nomor_dokumen = '-- Otomatis --';
        $model->suratdenda_tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));                                       
        $model->supplier_id = $modSup->supplier_id;
        $model->supplier_nama = $modSup->supplier_nama;
        $model->supplier_alamat = $modSup->supplier_alamat;
        $model->tanggal_awal = !empty($loadTermin->termintanggal_awal)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($loadTermin->termintanggal_awal))):null;
        $model->tanggal_akhir = !empty($loadTermin->termintanggal_akhir)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($loadTermin->termintanggal_akhir))):null;        
        /*
        if (!empty($loadTermin)){
            if ($loadTermin->terminke == 'I') {
                $model->terminke = 1;
            } else if ($loadTermin->terminke == 'II') {
                $model->terminke = 2;
            } else if ($loadTermin->terminke == 'III') {
                $model->terminke = 3;
            }
            $model->termindari = count($modSPKTermin);
            $model->termin_persen = $loadTermin->jumlah_persen;
        }
         */
        if($modSPK->istermin == true){
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $cekpemeriksaanpekerjaan = ADSuratdendaT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan) + 1;
        }
                
        if (!empty($suratdenda_id)){
            $model = ADSuratdendaT::model()->findByPk($suratdenda_id);            
            $model->suratdenda_tanggal = MyFormatter::formatDateTimeForUser($model->suratdenda_tanggal);  
            $loadTermin1 = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id, 'terminke'=> $model->terminke));
            $model->tanggal_awal = !empty($loadTermin1->termintanggal_awal)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($loadTermin1->termintanggal_awal))):null;
            $model->tanggal_akhir = !empty($loadTermin1->termintanggal_akhir)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($loadTermin1->termintanggal_akhir))):null;        
            $model->supplier_nama = $model->supplier->supplier_nama;            
            $model->supplier_alamat = $model->supplier->supplier_alamat;
            if (!empty($model->ketuapphp_id)){
                $model->ketuapphp_nama = $model->ketuapphp->namaLengkap;
            }
            $model->termindari = count($modSPKTermin);
            
            $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
            if($modSPK->istermin == true){
                if ($model->terminke == 'I') {
                    $model->termin_ke = 1;
                } else if ($model->terminke == 'II') {
                    $model->termin_ke = 2;
                } else if ($model->terminke == 'III') {
                    $model->termin_ke = 3;
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
            }
        }else{
            if($modSPK->istermin == true){
                $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
                $model->termin_ke = !empty($cekpemeriksaanpekerjaan) ? count($cekpemeriksaanpekerjaan) + 1 : 1;
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
        }
                     
        if (isset($_POST['ADSuratdendaT'])){   
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();                        
            try{
                $model->attributes = $_POST['ADSuratdendaT'];     
                $model->suratdenda_tanggal = MyFormatter::formatDateTimeForDb($model->suratdenda_tanggal);  
//                $model->termindari = CustomFunction::Romawi($_POST['ADSuratdendaT']['termindari']);        
                
                if($modSPK->istermin == true){
                    $model->terminke = $_POST['ADSuratdendaT']['terminke'];
                    $model->termin_persen = $_POST['ADSuratdendaT']['termin_persen'];
                }else{
                    $model->terminke = 'I';
                    $model->termin_persen = 100;
                }
                if (empty($model->suratdenda_id)){
                    $model->suratdenda_nomor = MyGenerator::NoSuratDenda();
                    $model->nomor_dokumen = MyGenerator::NoDokSuratDenda();
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                }else{
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                }
                $ok = $ok && $model->save();
                      
                if (isset($_POST['ADSuratdendadetT'])){
                    foreach($_POST['ADSuratdendadetT'] as $det){                    
                        $modDet = new ADSuratdendadetT;
                        $cekDet = ADSuratdendadetT::model()->findByPk($det['suratdendadet_id']);
                        if (!empty($cekDet)){
                            $modDet = $cekDet;                        
                        }
                        $modDet->attributes = $det;
                        $modDet->tanggal_pengiriman = MyFormatter::formatDateTimeForDb($det['tanggal_pengiriman']);
                        $modDet->suratdenda_id = $model->suratdenda_id;

                        $ok = $ok && $modDet->save();                    
                    }
                }
                
                if (isset($_POST['delete'])){
                    $criDel = new CDbCriteria();
                    $criDel->addInCondition('suratdendadet_id',$_POST['delete']);
                    $ok = $ok && SuratdendadetT::model()->deleteAll($criDel);
                }
                
                if($ok){                                                                                               
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('index','suratperjanjiankerja_id'=>$suratperjanjiankerja_id,'sukses'=>1));       
                }else{                             
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {                
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }       
                                  
        }
                  
        $this->render($this->path_view.'index',array(
            'model' => $model,                        
            'modSPK' => $modSPK,            
            'profilRS' => $profilRS,
            'modSup' => $modSup,
            'modSPKTermin' => $modSPKTermin
        ));
    }
    
    /**
     * Cetak Transaksi Surat Denda
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = ADSuratdendaT::model()->findByPk($id);
        $modelDetail = ADSuratdendadetT::model()->findAllByAttributes(array('suratdenda_id' => $id));
        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_nama = 'Surat Denda'");
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);
        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{ba_hari}}", ucwords(MyFormatter::getDayName(date('D', strtotime($model->suratdenda_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->suratdenda_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_bulan_terbilang}}", MyFormatter::getMonthId(date('m', strtotime($model->suratdenda_tanggal))), $isiPesan);
                $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->suratdenda_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_tgl_bulan_tahun}}", date('d-', strtotime($model->suratdenda_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->suratdenda_tanggal))) . date('-Y', strtotime($model->suratdenda_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{suratdenda_tanggal}}", date('d ', strtotime($model->suratdenda_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->suratdenda_tanggal))) . date(' Y', strtotime($model->suratdenda_tanggal)), $isiPesan);
                $terlambat = '';
                $tanggal = explode(",", $model->tanggal_keterlambatan);
                foreach($tanggal as $tgl) {
                    $tgl = list($day, $month, $year) = explode('/', trim($tgl));
                    $terlambat .= $day." ".MyFormatter::getMonthId($month)." ".$year . ", ";
                }
                $isiPesan = str_replace("{{tanggal_keterlambatan}}",$terlambat, $isiPesan);
            }
            $cekSuratPerjanjian = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
            $attributes = $cekSuratPerjanjian->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{tglsuratperjanjian}}", date('d ', strtotime($cekSuratPerjanjian['tglsuratperjanjian'])) . MyFormatter::getMonthId(date('m', strtotime($cekSuratPerjanjian['tglsuratperjanjian']))) . date(' Y', strtotime($cekSuratPerjanjian['tglsuratperjanjian'])), $isiPesan);
                $isiPesan = str_replace("{{tglawal_pekerjaan}}", date('d ', strtotime($cekSuratPerjanjian['tglawal_pekerjaan'])) . MyFormatter::getMonthId(date('m', strtotime($cekSuratPerjanjian['tglawal_pekerjaan']))) . date(' Y', strtotime($cekSuratPerjanjian['tglawal_pekerjaan'])), $isiPesan);
                $isiPesan = str_replace("{{tglakhir_pekerjaan}}", date('d ', strtotime($cekSuratPerjanjian['tglakhir_pekerjaan'])) . MyFormatter::getMonthId(date('m', strtotime($cekSuratPerjanjian['tglakhir_pekerjaan']))) . date(' Y', strtotime($cekSuratPerjanjian['tglakhir_pekerjaan'])), $isiPesan);
                $ceksupplier = !empty($cekSuratPerjanjian->supplier_id) ? $cekSuratPerjanjian->supplier->supplier_nama : '-';
                $isiPesan = str_replace("{{supplier_nama}}", $ceksupplier, $isiPesan);
                $isiPesan = str_replace("{{jangka_waktu_terbilang}}", ucwords(MyFormatter::kataTerbilang($cekSuratPerjanjian->jangka_waktu)), $isiPesan);
                $isiPesan = str_replace("{{nomor_dokumen_spk}}", $cekSuratPerjanjian->nomor_dokumen, $isiPesan);
            }
            $cekSuratPerjanjiantermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id'=>$model->suratperjanjiankerja_id));
            $attributes = $cekSuratPerjanjiantermin->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{termintanggal_awal}}", date('d ', strtotime($cekSuratPerjanjiantermin['termintanggal_awal'])) . MyFormatter::getMonthId(date('m', strtotime($cekSuratPerjanjiantermin['termintanggal_awal']))) . date(' Y', strtotime($cekSuratPerjanjiantermin['termintanggal_awal'])), $isiPesan);
                $isiPesan = str_replace("{{termintanggal_akhir}}", date('d ', strtotime($cekSuratPerjanjiantermin['termintanggal_akhir'])) . MyFormatter::getMonthId(date('m', strtotime($cekSuratPerjanjiantermin['termintanggal_akhir']))) . date(' Y', strtotime($cekSuratPerjanjiantermin['termintanggal_akhir'])), $isiPesan);
            }
            $a = '<table border="1" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align: center">No.</th>
                            <th style="text-align: center">Jenis Barang</th>
                            <th style="text-align: center">Satuan / Ukuran</th>
                            <th style="text-align: center">Jumlah Barang</th>
                            <th style="text-align: center">Harga Satuan</th>
                            <th style="text-align: center">Jumlah Harga</th>
                            <th style="text-align: center">Tanggal Pengiriman</th>
                            <th style="text-align: center">Keterlambatan</th>
                        </tr>
                    </thead>
                    <tbody>';
            $no = 1;
            foreach ($modelDetail as $val) {
                $a .= '<tr>
                            <td style="text-align: center"> ' . $no++ . '. </td>
                            <td style="text-align: left"> ' . $val->nama_barang. ' </td>
                            <td style="text-align: center"> ' . $val->satuan_barang . ' </td>
                            <td style="text-align: center"> ' . $val->jumlah_barang . ' </td>
                            <td style="text-align: right"> ' . number_format($val->harga_satuan,2) . ' </td>
                            <td style="text-align: right"> ' . number_format($val->jumlah_harga,2) . ' </td>
                            <td style="text-align: center"> ' . MyFormatter::formatDateTimeForUser($val->tanggal_pengiriman) . ' </td>
                            <td style="text-align: center"> ' . $val->keterlambatan . ' hari </td>
                        </tr>';
            }
            $a .= '</tbody></table>';
            $isiPesan = str_replace("{{tabel_barang}}", $a, $isiPesan);
        }
        $model->isi_surat = $isiPesan;

        $this->render('print', array('model' => $model, 'modelDetail' => $modelDetail, 'cekSuratPerjanjian' => $cekSuratPerjanjian));
    }

    /**
     * Load data rincian
     */
    public function actionLoadRincian(){
        if (Yii::app()->request->isAjaxRequest){
            $suratperjanjiankerja_id = isset($_POST['suratperjanjiankerja_id'])?$_POST['suratperjanjiankerja_id']:null;
            $suratdenda_id = isset($_POST['suratdenda_id'])?$_POST['suratdenda_id']:null;

            $tr = '';
            
            $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
            
            $model = new ADSuratdendadetT;
            if (!empty($suratdenda_id)){
                $modDet = ADSuratdendadetT::model()->findAllByAttributes(array(                    
                    'suratdenda_id' => $suratdenda_id,
                    ));
                
                foreach($modDet as $i => $mod){
                    $mod->tanggal_pengiriman = date('d/m/Y', strtotime($mod->tanggal_pengiriman));
                    $tr .= $this->renderPartial($this->path_view.'row/_rowBarangJasa', array('model'=>$mod, 'i'=>$i), true);                   
                }
            }else{
                $rincian = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id));
                
                foreach($rincian as $i => $r){
                    
                    $keterlambatan = CustomFunction::hitungHariRawat($modSPK->tglakhir_pekerjaan, date('Y-m-d'))-1;
                    
                    $model->barang_id = $r->barang_id;
                    $model->jenis_barang = $r->jenis_barang;
                    $model->nama_barang = $r->barang_nama;
                    $model->satuan_barang = $r->barang_satuan;
                    $model->jumlah_barang = $r->barang_jumlah;                     
                    $model->harga_satuan = $r->barang_harga;
                    $model->jumlah_harga = $r->barang_total;
                    $model->jumlah_pajak = $r->pajak_jumlah;
                    $model->pajak_persen = $r->pajak_persen;
                    $model->total_harga = 0;
                    $model->tanggal_pengiriman = date('d/m/Y');
                    $model->keterlambatan = ($keterlambatan<0)?null:$keterlambatan;
                    $tr .= $this->renderPartial($this->path_view.'row/_rowBarangJasa', array('model'=>$model, 'i'=>$i), true);                   
                }
            }
                        
            
            $data['tr'] = $tr;
            $data['sukses'] = 1;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Load detail rincian
     */
    public function actionLoadDetailRincian(){
        if (Yii::app()->request->isAjaxRequest){
            $suratperjanjiankerja_id = isset($_POST['suratperjanjiankerja_id'])?$_POST['suratperjanjiankerja_id']:null;
            $suratdenda_id = isset($_POST['suratdenda_id'])?$_POST['suratdenda_id']:null;

            $tr = '';
            
            $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
            
            $model = new ADSuratdendadetT;
            if (!empty($suratdenda_id)){
                $modDet = ADSuratdendadetT::model()->findAllByAttributes(array(                    
                    'suratdenda_id' => $suratdenda_id,
                    ));
                
                foreach($modDet as $i => $mod){
                    $mod->tanggal_pengiriman = date('d/m/Y', strtotime($mod->tanggal_pengiriman));
                    $tr .= $this->renderPartial($this->path_view.'row/_rowDetailBarangJasa', array('model'=>$mod, 'i'=>$i), true);                   
                }
            }else{
                $rincian = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id));
                
                foreach($rincian as $i => $r){
                    
                    $keterlambatan = CustomFunction::hitungHariRawat($modSPK->tglakhir_pekerjaan, date('Y-m-d'))-1;
                    
                    $model->barang_id = $r->barang_id;
                    $model->jenis_barang = $r->jenis_barang;
                    $model->nama_barang = $r->barang_nama;
                    $model->satuan_barang = $r->barang_satuan;
                    $model->jumlah_barang = $r->barang_jumlah;                     
                    $model->harga_satuan = $r->barang_harga;
                    $model->jumlah_harga = $r->barang_total;
                    $model->jumlah_pajak = $r->pajak_jumlah;
                    $model->pajak_persen = $r->pajak_persen;
                    $model->total_harga = 0;
                    $model->tanggal_pengiriman = date('d/m/Y');
                    $model->keterlambatan = ($keterlambatan<0)?null:$keterlambatan;
                    $tr .= $this->renderPartial($this->path_view.'row/_rowDetailBarangJasa', array('model'=>$model, 'i'=>$i), true);                   
                }
            }
                        
            
            $data['tr'] = $tr;
            $data['sukses'] = 1;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Set data keterlambatan
     */
    public function actionSetKeterlambatan(){
        if (Yii::app()->request->isAjaxRequest){
            $tgl_kirim = isset($_POST['tgl_kirim'])?MyFormatter::formatDateTimeForDb($_POST['tgl_kirim']):null;
            $tgl_akhir = isset($_POST['tgl_akhir'])?MyFormatter::formatDateTimeForDb($_POST['tgl_akhir']):null;
                                    
            
            $keterlambatan = CustomFunction::hitungHariRawat($tgl_akhir, $tgl_kirim)-1;
            
            if ($keterlambatan < 0){
                $keterlambatan = '';
            }
            
            $data['keterlambatan'] = $keterlambatan;
            $data['sukses'] = 1;
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Melihat dan detail surat denda
     * @param integer $suratperjanjiankerja_id
     * @param integer $suratdenda_id
     */
    public function actionDetail($suratperjanjiankerja_id, $suratdenda_id) {
        $modSPK = SuratperjanjiankerjaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        if (empty($modSPK)){
            echo "Surat Perjanjian Kerja tidak ditemukan";die;                        
        }
        
        $modSPKTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id));
        if (empty($modSPKTermin)){
            echo "Surat Perjanjian Kerja Termin tidak ditemukan";die;                        
        }
                        
        $profilRS = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        
        $modSup = ADSupplierM::model()->findByPk($modSPK->supplier_id);
        
        $cekDenda = ADSuratdendaT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$modSPK->suratperjanjiankerja_id));
        $jumlahSurat = count($cekDenda)+1;
        
        $loadTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id'=>$modSPK->suratperjanjiankerja_id, 'terminke'=> CustomFunction::Romawi($jumlahSurat)));
        
                        
        $model = new ADSuratdendaT;
        $model->suratperjanjiankerja_id = $modSPK->suratperjanjiankerja_id;           
        $model->suratdenda_nomor = '-- Otomatis --';
        $model->nomor_dokumen = '-- Otomatis --';
        $model->suratdenda_tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));                                       
        $model->supplier_id = $modSup->supplier_id;
        $model->supplier_nama = $modSup->supplier_nama;
        $model->supplier_alamat = $modSup->supplier_alamat;
        $model->tanggal_awal = !empty($loadTermin->termintanggal_awal)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($loadTermin->termintanggal_awal))):null;
        $model->tanggal_akhir = !empty($loadTermin->termintanggal_akhir)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($loadTermin->termintanggal_akhir))):null;        
        /*
        if (!empty($loadTermin)){
            if ($loadTermin->terminke == 'I') {
                $model->terminke = 1;
            } else if ($loadTermin->terminke == 'II') {
                $model->terminke = 2;
            } else if ($loadTermin->terminke == 'III') {
                $model->terminke = 3;
            }
            $model->termindari = count($modSPKTermin);
            $model->termin_persen = $loadTermin->jumlah_persen;
        }
         */
        if($modSPK->istermin == true){
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $cekpemeriksaanpekerjaan = ADSuratdendaT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan) + 1;
        }
                
        if (!empty($suratdenda_id)){
            $model = ADSuratdendaT::model()->findByPk($suratdenda_id);   
            $loadTermin1 = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id, 'terminke'=> $model->terminke));
            $model->suratdenda_tanggal = MyFormatter::formatDateTimeForUser($model->suratdenda_tanggal);                        
            $model->tanggal_awal = !empty($loadTermin1->termintanggal_awal)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($loadTermin1->termintanggal_awal))):null;
            $model->tanggal_akhir = !empty($loadTermin1->termintanggal_akhir)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($loadTermin1->termintanggal_akhir))):null;        
            $model->supplier_nama = $model->supplier->supplier_nama;            
            $model->supplier_alamat = $model->supplier->supplier_alamat;
            if (!empty($model->ketuapphp_id)){
                $model->ketuapphp_nama = $model->ketuapphp->namaLengkap;
            }
            $model->termindari = count($modSPKTermin);
            
            $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
            if($modSPK->istermin == true){
                if ($model->terminke == 'I') {
                    $model->termin_ke = 1;
                } else if ($model->terminke == 'II') {
                    $model->termin_ke = 2;
                } else if ($model->terminke == 'III') {
                    $model->termin_ke = 3;
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
            }
        }else{
            if($modSPK->istermin == true){
                $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
                $model->termin_ke = !empty($cekpemeriksaanpekerjaan) ? count($cekpemeriksaanpekerjaan) + 1 : 1;
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
        }
                  
        $this->render('detail',array(
            'model' => $model,                        
            'modSPK' => $modSPK,            
            'profilRS' => $profilRS,
            'modSup' => $modSup,
            'modSPKTermin' => $modSPKTermin
        ));
    }
}