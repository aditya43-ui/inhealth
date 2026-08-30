    <?php
/**
 * Tab Evaluasi Pra Anestesi / Pra Sedasi di halaman Transaksi Evaluasi Pra Anestesi 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.anestesi
 * @subpackage controllers
 */
class EvaluasianestesiPraTController extends MyAuthController{
   public $layout='//layouts/iframe';
   public $path_view = 'anestesi.views.evaluasianestesipraT.';
   public $path_form = 'anestesi.views.evaluasianestesipraT.form.';
   
   /**
    * Fungsi untuk menampilkan halaman dan menyimpan data evaluasi pra anestesi 
    * @param type $pendaftaran_id
    * @param type $praevaluasianestesi_id
    */
   public function actionIndex($pendaftaran_id = null, $praevaluasianestesi_id = null){
       if (!empty($pendaftaran_id)) {
           $cekEvaluasi = EvaluasianestesiPraT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
           if (!empty($cekEvaluasi)) {
               $model = EvaluasianestesiPraT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
               $model->tanggalpemeriksaan = MyFormatter::formatDateTimeForUser($model->tanggalpemeriksaan);
               $model->pegawai_nama = $model->pegawai->namaLengkap;
               if ($model->anamnesadari_pasien == true) {
                   $model->anamnesadari_pasien = 'Pasien';
               } else if ($model->anamnesadari_keluarga == true) {
                   $model->anamnesadari_pasien = 'Keluarga';
               } else if ($model->anamnesadari_lainnya == true) {
                   $model->anamnesadari_pasien = 'Lainnya';
               }
               if ($model->riwayatanestesi_ada == true) {
                   $model->riwayatanestesi_ada = 'Ada';
               } else {
                   $model->riwayatanestesi_ada = 'Tidak Ada';
               }  
               
               if ($model->komplikasi_ada == true) {
                   $model->komplikasi_ada = 'Ada';
               } else {
                   $model->komplikasi_ada = 'Tidak Ada';
               }  
               
               if ($model->riwayatalergi_ada == true) {
                   $model->riwayatalergi_ada = 'Ada';
               } else {
                   $model->riwayatalergi_ada = 'Tidak Ada';
               }   
               
               if ($model->merokok_ya == true) {
                   $model->merokok_ya = 'Ya';
               } else {
                   $model->merokok_ya = 'Tidak';
               }
               
               if ($model->alkohol_ya == true) {
                   $model->alkohol_ya = 'Ya';
               } else {
                   $model->alkohol_ya = 'Tidak';
               }
               
               if ($model->evaluasijalannafas_bebas_ya == true) {
                   $model->evaluasijalannafas_bebas_ya = 'Ya';
               } else {
                   $model->evaluasijalannafas_bebas_ya = 'Tidak';
               }
               
               if ($model->evaluasijalannafas_potrusimandibula_ya == true) {
                   $model->evaluasijalannafas_potrusimandibula_ya = 'Ya';
               } else {
                   $model->evaluasijalannafas_potrusimandibula_ya = 'Tidak';
               }
               
               if ($model->evaluasijalannafas_bukamulut3jari_ya == true) {
                   $model->evaluasijalannafas_bukamulut3jari_ya = 'Ya';
               } else {
                   $model->evaluasijalannafas_bukamulut3jari_ya = 'Tidak';
               }
               
               if ($model->evaluasijalannafas_bukamulut2jari_ya == true) {
                   $model->evaluasijalannafas_bukamulut2jari_ya = 'Ya';
               } else {
                   $model->evaluasijalannafas_bukamulut2jari_ya = 'Tidak';
               }
               
               if ($model->evaluasijalannafas_obesitas_ya == true) {
                   $model->evaluasijalannafas_obesitas_ya = 'Ya';
               } else {
                   $model->evaluasijalannafas_obesitas_ya = 'Tidak';
               }
               
               if ($model->evaluasijalannafas_massa_ya == true) {
                   $model->evaluasijalannafas_massa_ya = 'Ya';
               } else {
                   $model->evaluasijalannafas_massa_ya = 'Tidak';
               }
               
               if ($model->evaluasijalannafas_jalannafassulit_ya == true) {
                   $model->evaluasijalannafas_jalannafassulit_ya = 'Ya';
               } else {
                   $model->evaluasijalannafas_jalannafassulit_ya = 'Tidak';
               }
               
               if ($model->evaluasijalannafas_ventilasisulit_ya == true) {
                   $model->evaluasijalannafas_ventilasisulit_ya = 'Ya';
               } else {
                   $model->evaluasijalannafas_ventilasisulit_ya = 'Tidak';
               }
               
               if ($model->evaluasijalannafas_leherpendek_ya == true) {
                   $model->evaluasijalannafas_leherpendek_ya = 'Ya';
               } else {
                   $model->evaluasijalannafas_leherpendek_ya = 'Tidak';
               }
               
               if ($model->evaluasijalannafas_gerakleher_bebas == true) {
                   $model->evaluasijalannafas_gerakleher_bebas = 'Tidak';
               } else {
                   $model->evaluasijalannafas_gerakleher_bebas = 'Ya';
               }
                   
           } else{
               $model = new EvaluasianestesiPraT;
               $model->tanggalpemeriksaan = date('d M Y H:i:s');
           }
               $model->evaluasijalannafas_bebas_tidak = true;
               $model->evaluasijalannafas_potrusimandibula_tidak = true;
               $model->evaluasijalannafas_bukamulut3jari_tidak = true;
       }
       $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
       if (!empty($praevaluasianestesi_id)) {
           $model = EvaluasianestesiPraT::model()->findByPk($praevaluasianestesi_id);
       }
       
       if (isset($_POST['EvaluasianestesiPraT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
           try{
                $model->attributes = $_POST['EvaluasianestesiPraT'];
                $model->pasien_id = $modPendaftaran->pasien_id;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->tanggalpemeriksaan = MyFormatter::formatDateTimeForDb($model->tanggalpemeriksaan);
                if (empty($cekEvaluasi)) {
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date ('Y-m-d H:i:s');
                } else {
                    $model->update_time = date ('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }
                
                if($model->anamnesadari_pasien == "Pasien"){
                    $model->anamnesadari_pasien = true;
                    $model->anamnesadari_keluarga = false;
                    $model->anamnesadari_lainnya = false;
                } else if ($model->anamnesadari_pasien == "Keluarga") {
                    $model->anamnesadari_pasien = false;
                    $model->anamnesadari_keluarga = true;
                    $model->anamnesadari_lainnya = false;
                } else if ($model->anamnesadari_pasien == "Lainnya") {
                    $model->anamnesadari_pasien = false;
                    $model->anamnesadari_keluarga = false;
                    $model->anamnesadari_lainnya = true;
                } else {
                    $model->anamnesadari_pasien = false;
                    $model->anamnesadari_keluarga = false;
                    $model->anamnesadari_lainnya = false;
                }
                
                if ($model->riwayatanestesi_ada == "Ada") {
                    $model->riwayatanestesi_ada = true;
                    $model->riwayatanestesi_tidakada = false;
                } else if ($model->riwayatanestesi_ada == "Tidak Ada") {
                    $model->riwayatanestesi_ada = false;
                    $model->riwayatanestesi_tidakada = true;
                } else{
                    $model->riwayatanestesi_ada = false;
                    $model->riwayatanestesi_tidakada = false;
                }
                    
                if ($model->komplikasi_ada == "Ada") {
                    $model->komplikasi_ada = true;
                    $model->komplikasi_tidakada = false;
                } else if ($model->komplikasi_ada == "Tidak Ada") {
                    $model->komplikasi_ada = false;
                    $model->komplikasi_tidakada = true;
                } else {
                    $model->komplikasi_ada = false;
                    $model->komplikasi_tidakada = false;
                }
                
                if ($model->riwayatalergi_ada == "Ada") {
                    $model->riwayatalergi_ada = true;
                    $model->riwayatalergi_tidakada = false;
                } else if  ($model->riwayatalergi_ada == "Tidak Ada") {
                    $model->riwayatalergi_ada = false;
                    $model->riwayatalergi_tidakada = true;
                } else {
                    $model->riwayatalergi_ada = false;
                    $model->riwayatalergi_tidakada = false;
                }
                
                if ($model->merokok_ya == "Ya") {
                    $model->merokok_ya = true;
                    $model->merokok_tidak = false;
                } else if ($model->merokok_ya == "Tidak") {
                    $model->merokok_ya = false;
                    $model->merokok_tidak = true;
                } else {
                    $model->merokok_ya = false;
                    $model->merokok_tidak = false;
                }
                
                if ($model->evaluasijalannafas_bebas_ya == "Ya") {
                    $model->evaluasijalannafas_bebas_ya = true;
                    $model->evaluasijalannafas_bebas_tidak = false;
                } else if ($model->evaluasijalannafas_bebas_ya == "Tidak") {
                    $model->evaluasijalannafas_bebas_ya = false;
                    $model->evaluasijalannafas_bebas_tidak = true;
                } else {
                    $model->evaluasijalannafas_bebas_ya = false;
                    $model->evaluasijalannafas_bebas_tidak = false;
                }
                
                if ($model->evaluasijalannafas_potrusimandibula_ya == "Ya") {
                    $model->evaluasijalannafas_potrusimandibula_ya = true;
                    $model->evaluasijalannafas_potrusimandibula_tidak = false;
                } else if ($model->evaluasijalannafas_potrusimandibula_ya == "Tidak") {
                    $model->evaluasijalannafas_potrusimandibula_ya = false;
                    $model->evaluasijalannafas_potrusimandibula_tidak = true;
                } else {
                    $model->evaluasijalannafas_potrusimandibula_ya = false;
                    $model->evaluasijalannafas_potrusimandibula_tidak = false;
                }
                
                if ($model->evaluasijalannafas_bukamulut3jari_ya == "Ya") {
                    $model->evaluasijalannafas_bukamulut3jari_ya = true;
                    $model->evaluasijalannafas_bukamulut3jari_tidak = false;
                } else if ($model->evaluasijalannafas_bukamulut3jari_ya == "Tidak") {
                    $model->evaluasijalannafas_bukamulut3jari_ya = false;
                    $model->evaluasijalannafas_bukamulut3jari_tidak = true;
                } else {
                    $model->evaluasijalannafas_bukamulut3jari_ya = false;
                    $model->evaluasijalannafas_bukamulut3jari_tidak = false;
                }
                
                if ($model->evaluasijalannafas_bukamulut2jari_ya == "Ya") {
                    $model->evaluasijalannafas_bukamulut2jari_ya = true;
                    $model->evaluasijalannafas_bukamulut2jari_tidak = false;
                } else if ($model->evaluasijalannafas_bukamulut2jari_ya == "Tidak") {
                    $model->evaluasijalannafas_bukamulut2jari_ya = false;
                    $model->evaluasijalannafas_bukamulut2jari_tidak = true;
                } else {
                    $model->evaluasijalannafas_bukamulut2jari_ya = false;
                    $model->evaluasijalannafas_bukamulut2jari_tidak = false;
                }
                
                if ($model->evaluasijalannafas_leherpendek_ya == "Ya") {
                    $model->evaluasijalannafas_leherpendek_ya = TRUE;
                    $model->evaluasijalannafas_leherpendek_tidak = FALSE;
                } else if ($model->evaluasijalannafas_leherpendek_ya == "Tidak") {
                    $model->evaluasijalannafas_leherpendek_ya = FALSE;
                    $model->evaluasijalannafas_leherpendek_tidak = TRUE;
                } else {
                    $model->evaluasijalannafas_leherpendek_ya = FALSE;
                    $model->evaluasijalannafas_leherpendek_tidak = FALSE;
                }
                
                if ($model->evaluasijalannafas_malaphaty_satu == 1) {
                    $model->evaluasijalannafas_malaphaty_satu = true;
                    $model->evaluasijalannafas_malaphaty_dua = false;
                    $model->evaluasijalannafas_malaphaty_tiga = false;
                    $model->evaluasijalannafas_malaphaty_empat = false;
                } else if ($model->evaluasijalannafas_malaphaty_satu == 2) {
                    $model->evaluasijalannafas_malaphaty_satu = false;
                    $model->evaluasijalannafas_malaphaty_dua = true;
                    $model->evaluasijalannafas_malaphaty_tiga = false;
                    $model->evaluasijalannafas_malaphaty_empat = false;
                } else if ($model->evaluasijalannafas_malaphaty_satu == 3) {
                    $model->evaluasijalannafas_malaphaty_satu = false;
                    $model->evaluasijalannafas_malaphaty_dua = false;
                    $model->evaluasijalannafas_malaphaty_tiga = true;
                    $model->evaluasijalannafas_malaphaty_empat = false;
                } else if ($model->evaluasijalannafas_malaphaty_satu == 4) {
                    $model->evaluasijalannafas_malaphaty_satu = false;
                    $model->evaluasijalannafas_malaphaty_dua = false;
                    $model->evaluasijalannafas_malaphaty_tiga = false;
                    $model->evaluasijalannafas_malaphaty_empat = true;
                } else {
                    $model->evaluasijalannafas_malaphaty_satu = false;
                    $model->evaluasijalannafas_malaphaty_dua = false;
                    $model->evaluasijalannafas_malaphaty_tiga = false;
                    $model->evaluasijalannafas_malaphaty_empat = false;
                }
                                    
                if ($model->evaluasijalannafas_gerakleher_bebas == "Ya") {
                    $model->evaluasijalannafas_gerakleher_bebas = true;
                    $model->evaluasijalannafas_gerakleher_terbata = false;
                } else if ($model->evaluasijalannafas_gerakleher_bebas == "Tidak") {
                    $model->evaluasijalannafas_gerakleher_bebas = false;
                    $model->evaluasijalannafas_gerakleher_terbata = true;
                } else {
                    $model->evaluasijalannafas_gerakleher_bebas = false;
                    $model->evaluasijalannafas_gerakleher_terbata = false;
                }
                
                if ($model->evaluasijalannafas_obesitas_ya == "Ya") {
                    $model->evaluasijalannafas_obesitas_ya = true;
                    $model->evaluasijalannafas_obesitas_tidak = false;
                } else if ($model->evaluasijalannafas_obesitas_ya == "Tidak") {
                    $model->evaluasijalannafas_obesitas_ya = false;
                    $model->evaluasijalannafas_obesitas_tidak = true;
                } else {
                    $model->evaluasijalannafas_obesitas_ya = false;
                    $model->evaluasijalannafas_obesitas_tidak = false;
                }
                
                if ($model->evaluasijalannafas_massa_ya == "Ya") {
                    $model->evaluasijalannafas_massa_ya = true;
                    $model->evaluasijalannafas_massa_tidak = false;
                } else if ($model->evaluasijalannafas_massa_ya == "Tidak") {
                    $model->evaluasijalannafas_massa_ya = false;
                    $model->evaluasijalannafas_massa_tidak = true;
                } else {
                    $model->evaluasijalannafas_massa_ya = false;
                    $model->evaluasijalannafas_massa_tidak = false;
                }
                
                if ($model->evaluasijalannafas_jalannafassulit_ya == "Ya") {
                    $model->evaluasijalannafas_jalannafassulit_ya = true;
                    $model->evaluasijalannafas_jalannafassulit_tidak = false;
                } else if ($model->evaluasijalannafas_jalannafassulit_ya == "Tidak") {
                    $model->evaluasijalannafas_jalannafassulit_ya = false;
                    $model->evaluasijalannafas_jalannafassulit_tidak = true;
                } else {
                    $model->evaluasijalannafas_jalannafassulit_ya = false;
                    $model->evaluasijalannafas_jalannafassulit_tidak = false;
                }
                
                if ($model->evaluasijalannafas_ventilasisulit_ya == "Ya") {
                    $model->evaluasijalannafas_ventilasisulit_ya = true;
                    $model->evaluasijalannafas_ventilasiaulit_tidak = false;
                } else if ($model->evaluasijalannafas_ventilasisulit_ya == "Tidak") {
                    $model->evaluasijalannafas_ventilasisulit_ya = false;
                    $model->evaluasijalannafas_ventilasiaulit_tidak = true;
                } else {
                    $model->evaluasijalannafas_ventilasisulit_ya = false;
                    $model->evaluasijalannafas_ventilasiaulit_tidak = false;
                }
                $ok = $ok && $model->save();
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'pendaftaran_id' => $_GET['pendaftaran_id'], 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
       }
       $this->render($this->path_view.'index',
               array('model' => $model));
   }
}