<?php

class RDGcsM extends GcsM {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KegiatanOperasiM the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function keterangan($gcs_nilai) {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
//		echo $gcs_nilai;
//		exit();
		$keterangan = '';
		$model = self::model()->findAll('gcs_aktif = true');
		
		foreach ($model as $item) {
//			echo $gcs_nilai;
//									exit();
			if ($gcs_nilai >= $item->gcs_nilaimin && $gcs_nilai <= $item->gcs_nilaimax) {
							$keterangan	= $item->gcs_nama;
//									echo $keterangan;
//									exit();
							}
		}
//		$criteria = new CDbCriteria;
//
//		$criteria->addCondition('gcs_nilaimin <=' . $gcs_nilai);
//		$criteria->addCondition('gcs_nilaimax >=' . $gcs_nilai);
//		$modgcs = GcsM::model()->findAll($criteria);
//		echo '<pre>';
//		print_r($modgcs);
//		exit();
//		if (count((array)$modgcs) > 0)
//			return $modgcs['gcs_nama'];
//		else
//			return '';
		return $keterangan;
	}
	
	public function listGCS() {
		$res = array();
		$model = self::model()->findAll('gcs_aktif = true');
		
		foreach ($model as $item) {
			$res[] = $item->attributes;
		}
		
		return CJSON::encode($res);
	}

}

?>
