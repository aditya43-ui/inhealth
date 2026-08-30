<?php
class DataAwalController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'persalinan.views.dataAwal.';
    
    public function actionIndex($pendaftaran_id)
    {
        $modPendaftaran = PSPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);    
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $model = PartografpasienT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        if (empty($model)){
            $model = new PartografpasienT;
        }else{
            $model->tglawal_pelayanan = (!empty($model->tglawal_pelayanan)? MyFormatter::formatDateTimeForUser($model->tglawal_pelayanan): null);
            $model->ketubahpecahsejak_jam = (!empty($model->ketubahpecahsejak_jam)? MyFormatter::formatDateTimeForUser($model->ketubahpecahsejak_jam): null);
            $model->mulessejak_jam = (!empty($model->mulessejak_jam)? MyFormatter::formatDateTimeForUser($model->mulessejak_jam): null);

            $model->perkiraanlahir_tgl = (!empty($model->perkiraanlahir_tgl)? MyFormatter::formatDateTimeForUser($model->perkiraanlahir_tgl): null);
            $model->haripertamahaidterakhir = (!empty($model->haripertamahaidterakhir)? MyFormatter::formatDateTimeForUser($model->haripertamahaidterakhir): null);
        }
        
        if(isset($_POST['PartografpasienT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {     
                $model->attributes=$_POST['PartografpasienT']; 
                $model->tglawal_pelayanan = (!empty($model->tglawal_pelayanan)? MyFormatter::formatDateTimeForDb($model->tglawal_pelayanan): null);
                $model->ketubahpecahsejak_jam = (!empty($model->ketubahpecahsejak_jam)? MyFormatter::formatDateTimeForDb($model->ketubahpecahsejak_jam): null);
                $model->mulessejak_jam = (!empty($model->mulessejak_jam)? MyFormatter::formatDateTimeForDb($model->mulessejak_jam): null);
                $model->jamawal_pelayanan = (!empty($model->jamawal_pelayanan)? $model->jamawal_pelayanan: null);

                $model->perkiraanlahir_tgl = (!empty($model->perkiraanlahir_tgl)? MyFormatter::formatDateTimeForDb($model->perkiraanlahir_tgl): null);
                $model->haripertamahaidterakhir = (!empty($model->haripertamahaidterakhir)? MyFormatter::formatDateTimeForDb($model->haripertamahaidterakhir): null);
                
                if ($model->isNewRecord) {
                    $model->create_time = date('Y-m-d');
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                
                }
                $model->pendaftaran_id = $pendaftaran_id;
                $model->update_time = date('Y-m-d');
                $model->update_loginpemakai_id = Yii::app()->user->id;
                if (empty($model->ketubahpecahsejak_jam)){
                    $model->ketubahpecahsejak_jam = null;
                }
                if (empty($model->mulessejak_jam)){
                    $model->mulessejak_jam = null;
                }



                if($model->save()){
                    $transaction->commit();   
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                }
            }catch(Exception $exc){
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }  
              
        }
            
        $this->render($this->path_view.'index',array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'model'=>$model
        ));
    }
    
    public function actionDetailDataAwal($pendaftaran_id)
    {
        $modPendaftaran = PSPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);    
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $model = PartografpasienT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        
            
        $this->render($this->path_view.'detailDataAwal',array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'model'=>$model
        ));
    }
    
}
