<?php

class ARAsuransipasienM extends AsuransipasienM
{
	public $nomorindukpegawai,$namapemilikasuransi_ptb;
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
		$criteria=$this->criteriaSearch();
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id); 			
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
		}
		$criteria->limit=10;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

}