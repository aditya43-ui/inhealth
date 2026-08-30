<?php

class InformasiJadwalDokterController extends MyAuthController
{
        public $_lastHari = null;
        public $path_view = 'hemodialisa.views.informasiJadwalDokter.';
	public function actionIndex()
	{
            $this->pageTitle = Yii::app()->name." - Informasi Jadwal Dokter";
            $model=new HDJadwaldokterM;
            $listHari = array( 'Senin'=> 'Senin',
                                   'Selasa'=> 'Selasa',
                                   'Rabu'=> 'Rabu',
                                   'Kamis'=> 'Kamis',
                                   'Jumat'=> 'Jumat',
                                   'Sabtu'=> 'Sabtu',
                                   'Minggu'=> 'Minggu',
                                );
            if(isset($_REQUEST['HDJadwaldokterM'])){
                $model->attributes = $_REQUEST['HDJadwaldokterM'];

            }

             if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial($this->path_view.'_tableJadwalDokter', array('model'=>$model));
                }else{
                     $this->render($this->path_view.'index',
                    array('model'=>$model,'listHari'=>$listHari)
                    );
                }
           
	}
        
        protected function gridHari($data,$row)
        {
           if($this->_lastHari != $data->jadwaldokter_hari)
           {
               return $data->jadwaldokter_hari;
           }
           else{
               return '';
           }
        }
        
        protected function gridDokter($data,$row)
        {
           $this->_lastHari = $data->jadwaldokter_hari;
           return $data->pegawai->nama_pegawai;  
        }

	
}