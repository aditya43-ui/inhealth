<?php

class PenyebaranPasienController extends MyAuthController
{
	public function actionIndex()
	{
		
		
        $this->render('index');
	}
	
	public function actionGetContent() {
		$this->layout= '//layouts/iframePolos';
		$this->render('iframeContent');
	}
	
	/**
     * menampilkan data kecamatan berdasarkan diagnosa_id dari ajax
     * @throws CHttpException
     */
    public function actionGetPenyebaranPasien(){
        if(Yii::app()->request->isAjaxRequest)
        {
            $data = array();
            $dataMap = array();
            $kecamatan_id = (isset($_POST['kecamatan_id']) ? $_POST['kecamatan_id'] : null);
            if(!empty($kecamatan_id)){
				//=== start map ===
				$sql = "SELECT pasien_m.garis_latitude, pasien_m.garis_longitude, pasien_m.namadepan, "
						. "pasien_m.nama_pasien, pasien_m.alamat_pasien FROM pasien_m "
						. "JOIN pasienmorbiditas_t ON pasien_m.pasien_id=pasienmorbiditas_t.pasien_id "
						. "WHERE pasien_m.kecamatan_id=".$_POST['kecamatan_id'];
				$result = Yii::app()->db->createCommand($sql)->queryAll();
				$dataMap = $result;
				//=== end map ===
            }else{
            }			
			if(count((array)$dataMap) > 0){
				foreach($dataMap as $i=>$map){
					$data[$i]['latitude'] = $map['garis_latitude'];
					$data[$i]['longitude'] = $map['garis_longitude'];
					$data[$i]['nama_pasien'] = $map['nama_pasien'];
					$data[$i]['nama_depan'] = $map['namadepan'];
					$data[$i]['alamat'] = $map['alamat_pasien'];
				}
			}
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
	/**
	 * menampilkan halaman dashboard (iframe)
	 * beberapa menggunakan DAO (createCommand) agar lebih cepat
	 */
    public function actionSetIFrameContent(){
		$this->layout= '//layouts/iframePolos';
		$sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
				FROM pasienmorbiditas_t
				JOIN pasien_m ON pasienmorbiditas_t.pasien_id = pasien_m.pasien_id
				JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
				JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
				WHERE date_part('year',tglmorbiditas) = '".date('Y')."'
				GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama
				ORDER BY jumlah DESC
				LIMIT 10";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;
		$modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
		$latitude = $modPropinsi->latitude;
		$longitude = $modPropinsi->longitude;
		$modelMordibias = new PasienmorbiditasT();
		 $format = new MyFormatter();
		$this->render('iframeContent',array('dataMap'=>$dataMap, 'modelMordibitas'=>$modelMordibias, 'format'=>$format));
    }
}
