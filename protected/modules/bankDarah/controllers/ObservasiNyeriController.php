<?php
/**
 * controller utama untuk mengakses menu observasi nyeri
 * 
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */

class ObservasiNyeriController extends MyAuthController
{
	
	public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	public $path_view = 'bankDarah.views.observasiNyeri.';
        public $init = '';        

        /**
         * digunakan untuk mengakses menu observasi nyeri
         * @param type $daftardonasi_id
         */
	public function actionIndex($daftardonasi_id)
	{            
            $model = new BDPeriksanyeripendonorT;
            $model->score_skalanyeri = 0;
            $model->keteranganskala_nyeri = Params::SKALA_NYERI_0;
            $model->tglperiksanyeri = date('d M Y H:i:s');
            $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
            $cekPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
            $model->nama_pegawai = $cekPegawai->nama_pegawai;
            
            $modDaftarDonor = BDDaftardonasiT::model()->findByPk($daftardonasi_id);
                        
            $modGambarTubuh = new BDGambartubuhM();
            
            $modBagianTubuh = new BDBagiantubuhM();
            
            $cekNyeri = BDPeriksanyeripendonorT::model()->findByAttributes(array('daftardonasi_id'=>$daftardonasi_id));
            if (!empty($cekNyeri)){
                $model = $cekNyeri;
                $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
                $cekPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
                $model->nama_pegawai = $cekPegawai->nama_pegawai;
                $model->tglperiksanyeri = MyFormatter::formatDateTimeForUser($model->tglperiksanyeri);
                $modPeriksaGambar = BDGambarnyeriT::model()->findAllByAttributes(array('periksanyeripendonor_id'=>$model->periksanyeripendonor_id));
            }else{
                $modPeriksaGambar = BDGambarnyeriT::model()->findAll(" periksanyeripendonor_id is null ");
            }
                        
           
            if(isset($_POST['BDPeriksanyeripendonorT'])) {
                $ok = true;
                $transaction = Yii::app()->db->beginTransaction();
                try {                                        
                    $model->attributes = $_POST['BDPeriksanyeripendonorT'];    
                                       
                    if ($_POST['BDPeriksanyeripendonorT']['keluhannyeri'] == 0){
                        $model->keluhannyeri = false;
                    }else{
                        $model->keluhannyeri = true;
                    }
                    
                    if ($_POST['BDPeriksanyeripendonorT']['is_nyerimenjalar'] == 0){
                        $model->is_nyerimenjalar = false;
                    }else{
                        $model->is_nyerimenjalar = true;
                    }
                    $model->tglperiksanyeri = MyFormatter::formatDateTimeForDb($model->tglperiksanyeri);
                    $model->daftardonasi_id = $modDaftarDonor->daftardonasi_id;            
                    $model->pendonor_id = $modDaftarDonor->pendonor_id;        
                    $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
                    if (empty($model->periksanyeripendonor_id)){
                        $model->create_time = date("Y-m-d H:i:s");
                        $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');                                        
                    }else{
                        $model->update_time = date("Y-m-d H:i:s");
                        $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    }
                                        
                    $ok = $ok && $model->save();
                                                                               
                    if (isset($_POST['BDGambarnyeriT'])){
                        foreach($_POST['BDGambarnyeriT'] as $gbr => $dtGbr){
                            $skalanyeri = 0;
                           
                            if (empty($dtGbr['gambarnyeri_id'])){
                                $modLokasiNyeri = new BDGambarnyeriT;
                                $modLokasiNyeri->attributes = $_POST['BDGambarnyeriT'][$gbr];
                                $modLokasiNyeri->periksanyeripendonor_id = $model->periksanyeripendonor_id;                                                                
                                $modLokasiNyeri->create_time = date('Y-m-d H:i:s');
                                $modLokasiNyeri->create_loginpemakai_id = Yii::app()->user->id;
                                $modLokasiNyeri->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                
                               $ok = $ok &&  $modLokasiNyeri->save();       
                            }
                            
                        }
                                                
                    }
                    
                    $up = DaftardonasiT::model()->findByPk($model->daftardonasi_id);
                    $up->status = Params::STATUS_PENDONOR_OBSERVASI;
                    $ok = $ok && $up->save();
                   
                    
                    if($ok){
                        
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                        $this->redirect(array('index','daftardonasi_id'=>$model->daftardonasi_id,'sukses'=>1));       
                    }else{
                        //var_dump($modFisik->getErrors());die;
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                }
            }          
			
            
            
            $this->render($this->path_view.'index',array(                                
                'model'=>$model,
                'modGambarTubuh' => $modGambarTubuh,
                'modPeriksaGambar' => $modPeriksaGambar,                
                'modBagianTubuh' => $modBagianTubuh,
                'modDaftarDonasi' => $modDaftarDonor
            ));
	}
        
        /**
         * mengenerate posisi anggota tubuh secara otomatis
         */
        public function actionGetBagianTubuhId() {
            if(Yii::app()->request->isAjaxRequest) {
			$pesan = '';
			$data = array();
				$kordinat_x = $_POST['kordinat_x'];
				$kordinat_y = $_POST['kordinat_y'];
				$sql = "select bagiantubuh_id, namabagtubuh from bagiantubuh_m where (".$kordinat_x." >= kordinat_x2 AND ".$kordinat_x." <= kordinat_x) AND (".$kordinat_y." >= kordinat_y AND ".$kordinat_y." <= kordinat_y2) ORDER BY bagiantubuh_urutan ASC LIMIT 1";
				$result = Yii::app()->db->createCommand($sql)->queryRow();
				if($result){
					$data['pesan'] = '';
					$data['namabagtubuh'] = $result['namabagtubuh'];
					$data['bagiantubuh_id'] = $result['bagiantubuh_id'];
					echo json_encode($data);
									echo CJSON::encode(array('pesan'=>$pesan, 'namabagtubuh'=>$namabagtubuh));
				}else{
					$pesan = "Bagian tubuh belum disetting!";
					echo CJSON::encode(array('pesan'=>$pesan));
				}
            }
            Yii::app()->end();
	}

    /**
     * menambahkan keterangan dari anggota tubuh yang sudah dipilih
     */
    public function actionTambahBagianTubuh()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $pesan = '';
            $form = '';
            if(!empty($_POST['bagiantubuh_id'])){
                    $modPemeriksaanGbr = new BDGambarnyeriT;
                    $modPemeriksaanGbr->bagiantubuh_id			= $_POST['bagiantubuh_id'];
                    $modPemeriksaanGbr->namabagtubuh			= $modPemeriksaanGbr->bagiantubuh->namabagtubuh;
                    $modPemeriksaanGbr->ket_gambar		= $_POST['keterangan'];
                    $modPemeriksaanGbr->kordinat_tubuh_x		= $_POST['pic_x'];
                    $modPemeriksaanGbr->kordinat_tubuh_y		= $_POST['pic_y'];
                    $modPemeriksaanGbr->gambartubuh_id          = $_POST['gambartubuh_id'];
                    $form = $this->renderPartial($this->path_view.'form/_rowDetail', array('modPemeriksaanGbr'=>$modPemeriksaanGbr), true);
                    $axis['x']=$modPemeriksaanGbr->kordinat_tubuh_x;
                    $axis['y']=$modPemeriksaanGbr->kordinat_tubuh_y;
                    echo CJSON::encode(array('pesan'=>$pesan,'form'=>$form,'axis'=>$axis,'bagiantubuh_id'=>$modPemeriksaanGbr->bagiantubuh_id));
            }else{
                    $pesan = 'Bagian tubuh tidak boleh kosong!';
                    echo CJSON::encode(array('pesan'=>$pesan));
            }

            
        }
        Yii::app()->end();
    }
	
    /**
     * menghapus data keterangan anggota tubuh yang sudah diisi
     */
    public function actionHapusBagianTubuh()
    {
        if(Yii::app()->request->isAjaxRequest) {
    $pesan = '';
    $ok = 0;
            $del = true;                                  
            $ok = BDGambarnyeriT::model()->findByAttributes(
                    array(
                            'gambarnyeri_id' => $_POST['gambarnyeri_id'],
                            'gambartubuh_id' => $_POST['gambartubuh_id'],
                            'bagiantubuh_id' =>$_POST['bagiantubuh_id'],                            
                            'ket_gambar' => $_POST['keterangan_periksa_gbr'],
                    )
            );

            if (!empty($ok)){
                    $del = $del && $ok->delete();
            }
            
            

            if($del){
                    $pesan = 'Data Berhasil Dihapus dari database';
                    $ok = 1;
                    echo CJSON::encode(array('pesan'=>$pesan, 'ok'=>$ok));
            }else{
                    $ok = 0;
                    $pesan = "Bagian Tubuh gagal dihapus!";
                    echo CJSON::encode(array('pesan'=>$pesan, 'ok'=>$ok));
            }
        }
        Yii::app()->end();
    }
                    
}
