<?php

//Yii::import('informasi.controllers.InformasikamarinapVController');

/**
 * Digunakan controller ekios 
 * @author  Akhmad Hasan Arofid <hasanarofid@.com>
 * @package application.modules.ekios
 * @subpackage controllers
 * @category controller
 */
class DaftarMandiriController extends Controller {
    
    
    public function actionPasien(){
        
        $model = new PasienM;
        
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['cari'])){
                $cari = $_GET['cari'];
                if ($cari == 'pasien'){
                    $cri = new CDbcriteria;
                    $cri->select = [
                        'per.pekerjaan_nama',
                        'pen.pendidikan_nama',
                        't.pasien_id',
                        't.nama_pasien',
                        't.jenisidentitas',
                        't.no_identitas_pasien',
                        't.jeniskelamin',
                        't.tempat_lahir',
                        't.tanggal_lahir',
                        't.alamat_pasien',
                        't.rt',
                        't.rw',
                        't.statusperkawinan',
                        't.golongandarah',
                        't.rhesus',
                        't.nama_ibu',
                        't.nama_ayah',
                        't.anakke',
                        't.jumlah_bersaudara',
                        't.agama', 
                        't.warga_negara',
                        't.no_mobile_pasien',
                        'pro.propinsi_nama',
                        'kab.kabupaten_nama',
                        'kec.kecamatan_nama',
                        'kel.kelurahan_nama',
                    ];
                    $cri->join =  " LEFT JOIN pekerjaan_m per ON per.pekerjaan_id = t.pekerjaan_id "
                                . " LEFT JOIN pendidikan_m pen ON pen.pendidikan_id = t.pendidikan_id "
                                . " JOIN propinsi_m pro ON pro.propinsi_id = t.propinsi_id "
                                . " JOIN kabupaten_m kab ON kab.kabupaten_id = t.kabupaten_id "
                                . " JOIN kecamatan_m kec ON kec.kecamatan_id = t.kecamatan_id "
                                . " JOIN kelurahan_m kel ON kel.kelurahan_id = t.kelurahan_id ";
                    $cri->addCondition("no_rekam_medik = :no_rekam_medik");
                    $cri->params[':no_rekam_medik'] = $_GET['norm'];
                    $modPas = PasienM::model()->find($cri);

                    if (empty($modPas)){
                        $data['pesan'] = 'Data tidak ditemukan';                    
                    }else{
                        
                        $modPas->umur = CustomFunction::getUmur($modPas->tanggal_lahir);
                        $modPas->tanggal_lahir = MyFormatter::formatDateTimeForUser($modPas->tanggal_lahir);
                        
                        $data['html'] = $this->renderPartial("pasien/index",['model'=>$modPas], true);
                        $data['pas_id'] = $modPas->pasien_id;
                    }

                    
                }else if($cari == 'polik'){
                    $cri = new CDbCriteria();
                    $cri->group = $cri->select = " ruangan_nama, ruangan_id ";    
                    $cri->addCondition(" jadwaldokter_tgl = '".date('Y-m-d')."' ");
                    $cri->order = "ruangan_nama ASC";
                    $model = JadwaldokterV::model()->findAll($cri);
                            
                    if (empty($model)){
                        $data['pesan'] = 'Jadwal polik untuk hari ini, tidak ditemukan';                    
                    }else{
                        $data = $this->renderPartial("poliklinik/index",['model'=>$model], true);                    
                    }                    
                }else if($cari == 'dokter'){
                    $r_id = $_GET['id'];
                    
                    $cri = new CDbCriteria();
                    $cri->join = "  JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id "
                                . " LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = peg.gelarbelakang_id ";
                    $cri->select = $cri->group = " peg.photopegawai, gelardepan, nama_pegawai, gelarbelakang_nama, t.pegawai_id ";    
                    $cri->addCondition(" t.ruangan_id = ".$r_id." AND jadwaldokter_tgl = '".date('Y-m-d')."' ");// 
                    $cri->order = "peg.nama_pegawai ASC";
                    $model = JadwaldokterM::model()->findAll($cri);
                          
                    
                    if (empty($model)){
                        $data['pesan'] = 'tidak ada dokter yang ditemukan, bekerja pada hari ini';                    
                    }else{
                        $data = $this->renderPartial("dokter/index",['model'=>$model], true);                    
                    }                     
                }else if($cari == 'jadwal'){
                    $r_id = $_GET['id'];
                    $p_id = $_GET['peg_id'];
                    
                    $cri = new CDbCriteria();
                    $cri->join = "  JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id "
                                . " LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = peg.gelarbelakang_id "
                                . " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id ";
                    $cri->select = $cri->group = " t.jadwaldokter_tgl, r.ruangan_id, r.ruangan_nama, peg.photopegawai, gelardepan, nama_pegawai, gelarbelakang_nama, t.pegawai_id ";    
                    $cri->addCondition(" t.ruangan_id = ".$r_id." AND t.pegawai_id = ".$p_id." AND jadwaldokter_tgl = '".date('Y-m-d')."' ");// 
                    $cri->order = "peg.nama_pegawai ASC";
                    $model = JadwaldokterM::model()->find($cri);

                    $jadwal = JadwaldokterM::model()->findAll(" pegawai_id =  ".$model->pegawai_id." AND ruangan_id = ".$model->ruangan_id."  ");//AND jadwaldokter_tgl = '".$model->jadwaldokter_tgl."'
                          
                   
                    if (empty($model)){
                        $data['pesan'] = 'dokter tidak memiliki jadwal pada hari ini';                    
                    }else{
                        $data = $this->renderPartial("jadwal-dokter/index",['model'=>$model, 'jadwal'=>$jadwal], true);                    
                    }                     
                }else if($cari == 'daftar'){
                    $r_id = $_GET['r_id'];
                    $p_id = $_GET['peg_id'];
                    $pas_id = $_GET['pas_id'];
                    
                    $r = RuanganM::model()->findByPk($r_id);
                    $peg = PegawaiM::model()->findByPk($p_id);
                    
                    $model = PasienM::model()->findByPk($pas_id);
                    $model->tgl_pendaftaran = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
                    $model->tanggal_lahir = date('d/m/Y', strtotime($model->tanggal_lahir));
                    $model->politujuan = $r->ruangan_nama;
                    $model->dpjp = $peg->namaLengkap;
                    
                    $data = $this->renderPartial("verifikasi/index",['model'=>$model], true);                                                             
                }else if($cari == 'simpan'){
                    $r_id = $_GET['r_id'];
                    $p_id = $_GET['peg_id'];
                    $pas_id = $_GET['pas_id'];
                    
                    $r = RuanganM::model()->findByPk($r_id);
                    $peg = PegawaiM::model()->findByPk($p_id);
                    
                    $model = PasienM::model()->findByPk($pas_id);
                    
                    $ok = true;
                    $trans = Yii::app()->db->beginTransaction();
                    try{
                        
                        $modDaftar = new PendaftaranT;
                        $modDaftar->pasien_id = $model->pasien_id;
                        $modDaftar->instalasi_id = $r->instalasi_id;
                        $modDaftar->ruangan_id = $r->ruangan_id;
                        $modDaftar->pegawai_id = $peg->pegawai_id;
                        $modDaftar->penjamin_id = Params::PENJAMIN_ID_UMUM;
                        $modDaftar->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
                        $modDaftar->jeniskasuspenyakit_id = Params::JENIS_KASUSPENYAKIT_ID_UMUM;
                        
                        $arr = [
                            'tgl_pendaftaran' => date('Y-m-d H:i:s')
                        ];
                        
                        $proses = PendaftaranT::simpanData($modDaftar, $arr);                        
                        $ok &= $proses['sukses'];
                        $modDaftar = $proses['model'];
                                                
                        if ($ok){
                            $trans->commit();
                            $data['sukses'] = '1';
                            $data['pesan'] = 'Data Pasien '.$model->nama_pasien.' berhasil disimpan'.' &lt;span style=\"display: inline-block; margin-top: 10px; font-style: italic; font-size: .9em; color: #666;\"&gt;Pesan ini akan hilang otomatis dalam 15 detik.&lt;/span&gt;';
                            
                            $model->no_pendaftaran = $modDaftar->no_pendaftaran;
                            $model->nourutpoli = $modDaftar->no_urutantri;
                            $model->pendaftaran_id = $modDaftar->pendaftaran_id;
                            
                            $model->tgl_pendaftaran = $modDaftar->tgl_pendaftaran;                            
                            $model->politujuan = $r->ruangan_nama;
                            $model->dpjp = $peg->namaLengkap;
                            
                        }else{
                            $trans->rollback();
                            $data['sukses'] = '0';
                            $data['pesan'] = 'Data gagal disimpan';
                        }
                    }catch(Exception $e){                        
                        $trans->rollback();     
                        $data['sukses'] = '0';
                        $data['pesan'] = 'Data gagal disimpan';
                    }
                    
                    
                    $data['html'] = $this->renderPartial("verifikasi/index",['model'=>$model], true);                                                             
                }
                
                echo json_encode($data);
            }
            exit;
        }
                       
        $this->render('index',[
            'model'=>$model,            
        ]);
    }    
    
    /**
    * @param type $pendaftaran_id
    */
    public function actionPrintStruk($id)
    {
        $this->layout='//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran = PendaftaranT::model()->findByPk($id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $lp = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);

        if (!empty($lp)) $modPegawai = PegawaiM::model()->findByPk($lp->pegawai_id);
        else $modPegawai = new PegawaiM;

        $karcis_id = null;
        $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
        $judul_print = 'Kunjungan '.$modPendaftaran->ruangan->instalasi->instalasi_nama;

            $posisi ='P'; //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',array(140,180));
            // $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/STRUCK.css');
            $mpdf->WriteHTML($formatkonten, 1);
            $mpdf->AddPage($posisi,'','','','',0,0,0,0,0,0);
            $mpdf->WriteHTML(
                    $this->renderPartial('printKarcis', array(
                           'format'=>$format,
                            'modPendaftaran'=>$modPendaftaran,
                            'judul_print'=>$judul_print,
                            'modPasien'=>$modPasien,
                            'modTindakan'=>$modTindakan,
                            'modPegawai'=>$modPegawai,
                            ),true)
                        );
            $mpdf->Output();
    }
}