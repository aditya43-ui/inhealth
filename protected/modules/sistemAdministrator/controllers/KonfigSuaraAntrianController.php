<?php

class KonfigSuaraAntrianController extends MyAuthController
{		
    /**
     * 
     */
    public function actionIndex()
    {                                
        $this->render('index',array(                
        ));
    }
    
    
    public function actionRefreshFile(){
        
        if (Yii::app()->request->isAjaxRequest){
        
            $ext = isset($_POST['ext'])?$_POST['ext']:null;
            $nama = isset($_POST['nama'])?$_POST['nama']:null;
            
            $laki = array_diff(scandir(Yii::getPathOfAlias('webroot').'/data/sounds/antrian/mp3/'.Params::JENIS_KELAMIN_LAKI_LAKI), array('.', '..'));
            $perempuan = array_diff(scandir(Yii::getPathOfAlias('webroot').'/data/sounds/antrian/mp3/'.Params::JENIS_KELAMIN_PEREMPUAN), array('.', '..'));

            $res = array();
            $html = '';
            foreach ($laki as $file) {
                $file = explode(".", $file);            
                
                
                if (!empty($ext) && isset($file[1])){
                    if (strpos($file[1], $ext) !== false){
                        
                        if (!empty($nama) && isset($file[0])){
                            if (strpos($file[0], $nama) !== false){
                               $res[CustomFunction::pengelompokkanFile($file[0])][$file[0]][Params::JENIS_KELAMIN_LAKI_LAKI] = $file[0];
                            }
                        }else{
                            $res[CustomFunction::pengelompokkanFile($file[0])][$file[0]][Params::JENIS_KELAMIN_LAKI_LAKI] = $file[0];
                        }                       
                    }
                }
                
               
            }

            foreach ($perempuan as $file) {
                $file = explode(".", $file);
                
                if (!empty($ext) && isset($file[1])){
                    if (strpos($file[1], $ext) !== false){
                        
                        if (!empty($nama) && isset($file[0])){
                            if (strpos($file[0], $nama) !== false){
                               $res[CustomFunction::pengelompokkanFile($file[0])][$file[0]][Params::JENIS_KELAMIN_PEREMPUAN] = $file[0];
                            }
                        }else{
                            $res[CustomFunction::pengelompokkanFile($file[0])][$file[0]][Params::JENIS_KELAMIN_PEREMPUAN] = $file[0];
                        }                       
                    }
                }
            }                          
            
            foreach($res as $key => $val){
                
               $html .= $this->renderPartial('_formListKelompok',array('key'=>$key, 'val'=>$val, 'tipe'=>'.'.$ext.',audio/'.$ext), true);
            }
            
            $data['sukses'] = 1;
            $data['html'] = $html;
            
            echo json_encode($data);
            Yii::app()->end();
        }               
                        
    }
    
     /**
    * suara panggilan MULTI no antrian (array) dan loket (array)
    * akses dengan ajax
    */
   public function actionPanggilanSuara() {
       if (Yii::app()->request->isAjaxRequest) {
           $this->layout = "//layouts/iframe";
           $jeniskelamin = $_POST["jeniskelamin"];
           $nama = $_POST["nama"];
           $ext = $_POST['ext'];
                     
           $data["suarapanggilan"] = $this->renderPartial('suaraPanggilan', 
                   array(
                       'jeniskelamin' => $jeniskelamin, 
                       'nama' => $nama, 
                       'ext' => $ext
                ), true);
           echo CJSON::encode($data);
       }
       Yii::app()->end();
   }
   
   public function actionPanggilIframe(){
       $this->layout = "//layouts/iframe";
       $jeniskelamin = $_GET['jeniskelamin'];
       $nama = $_GET['panggil'];
       $ext = $_GET['ext'];
       
       $this->render('suaraPanggilan', 
                   array(
                       'jeniskelamin' => $jeniskelamin, 
                       'nama' => $nama, 
                       'ext' => $ext
                ));
   }
   
   /**
     * Menampilkan data hasil scan beserta fungsi detail dari hasil scan tersebut.
     */
    public function actionSimpanFile() {
        if (Yii::app()->request->isAjaxRequest){
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $ext = isset($_POST['ext'])?$_POST['ext']:null;
                $jeniskelamin = isset($_POST['jeniskelamin'])?$_POST['jeniskelamin']:null;
                $nama = isset($_POST['nama'])?$_POST['nama']:null;
                
                $file = $_FILES['file'];                          
                
                $target_dir = Params::pathSuaraAntrianDirectory();            
                $name_file = $nama.'.';
                    
                if ($ok){                                        
                    if (file_exists($target_dir.$jeniskelamin.'/'.$name_file.$ext)){
                        unlink($target_dir.$jeniskelamin.'/'.$name_file.$ext);
                    }                    
                    if (move_uploaded_file($file["tmp_name"], $target_dir.$jeniskelamin.'/'.$name_file.$ext)) {                        
                        $data['sukses'] = 1;
                        $data['pesan'] = 'File berhasil di upload';
                        $trans->commit();
                    } else {
                        $data['sukses'] = 0;
                        $data['pesan'] = 'File gagal di upload';
                        $trans->rollback();
                    }
                }else{
                    $data['sukses'] = 0;
                    $data['pesan'] = 'File gagal di upload';
                    $trans->rollback();
                }
            }catch(Exception $e){
                $data['sukses'] = 0;
                $data['pesan'] = 'File gagal di upload';
                $trans->rollback();
            }
                       
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    public function actionTambahSuaraBaru(){
        
    }
}
