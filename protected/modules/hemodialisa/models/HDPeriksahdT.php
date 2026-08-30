<?php

class HDPeriksahdT extends PeriksahdT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeriksahdT the static model class
	 */
	public $perawat;
	public $is_heparin_dosisawal, $is_heparin_dosissirkulasi;
	public $is_heparin_continyu, $is_iso_uf_ml, $is_lama_uso_uf;
	public $is_heparin_intermiten;
	public $is_tanpaheparin_nama;
	public $is_heparin_lmwh, $periksahd_penyulitLainnya, $penyulit_teknisLainnya;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'periksahd_t';
	}

	public static function getAksesVaskular()
	{
		$data = array();
//		$criteria = new CDbCriteria();
		$models = AksesvaskularM::model()->findAll();
		if(count($models) > 0){
			foreach($models as $model)
				$data[$model->aksesvaskular_id] = strtoupper($model->aksesvaskular_nama).'&nbsp; &nbsp;';
		}else{
			$data[""] = null;
		}

		return $data;
	}
	
	public static function getJenisDialisat()
	{
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->addCondition("jenisdialisat_aktif IS TRUE");
		$models = JenisdialisatM::model()->findAll($criteria);
		if(count($models) > 0){
			foreach($models as $model)
				$data[$model->jenisdialisat_id] = strtoupper($model->jenisdialisat_nama).'&nbsp; &nbsp;';
		}else{
			$data[""] = null;
		}

		return $data;
	}
	
	public static function getPenyulit()
	{
		$data = array(
			'Hipotensi' => 'Hipotensi',
			'Hipertensi' => 'Hipertensi',
			'Menggigil' => 'Menggigil',
			'Kram' => 'Kram',
			'Akses Sulit' => 'Akses Sulit',
			'Mual/Muntah' => 'Mual/Muntah',
			'Meninggal' => 'Meninggal',
		);
		return $data;
	}
	
	public static function getPenyulitTeknis()
	{
		$data = array(
			'Klinis' => 'Klinis',
			'Teknis' => 'Teknis',
		);
		return $data;
	}
	
}