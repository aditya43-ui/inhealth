<?php

class PPAsuransipasienM extends AsuransipasienM
{
    public $nomorindukpegawai,$namapemilikasuransi_ptb, $create_ruangan, $jenispeserta_nama, $kelastanggunganasuransi_nama,$tgl_konfirmasi2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsuransipasienM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getJenisPesertaItems(){
		return JenisPesertaM::model()->findAllByAttributes(array('jenispeserta_aktif'=>true));
	}
	
	public function searchDialog()
	{
		// $criteria=$this->criteriaSearch();
		$criteria = new CDbCriteria;

		$criteria->compare('LOWER(nokartuasuransi)', strtolower($this->nokartuasuransi), true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id); 			
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
		}
		$criteria->limit= 1;
		$criteria->distinct = true;
		$criteria->order = 'asuransipasien_id desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination' => false,
		));
	}

	
}