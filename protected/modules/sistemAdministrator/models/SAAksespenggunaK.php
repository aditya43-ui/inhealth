<?php

class SAAksespenggunaK extends AksespenggunaK
{
	public $nama_pemakai;
	public $nama_pegawai;
	 //untuk form pencarian & filter
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->join = " LEFT JOIN loginpemakai_k ap ON ap.loginpemakai_id = t.loginpemakai_id 
		LEFT JOIN pegawai_m x ON x.pegawai_id = ap.pegawai_id";
		$criteria->compare('LOWER(ap.nama_pemakai)',strtolower($this->nama_pemakai),true);
		$criteria->compare('LOWER(x.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->addCondition('peranpengguna_id <> 1');
		if(!empty($this->peranpengguna_id)){
			$criteria->addCondition('peranpengguna_id = '.$this->peranpengguna_id);
		}
		if(!empty($this->modul_id)){
			$criteria->addCondition('modul_id = '.$this->modul_id);
		}
		if (!Params::cekAkses(Yii::app()->user->getState('peranpengguna_id'))){				
			$criteria->addNotInCondition("peranpengguna_id", Params::getAllVendor());
		}

		return $criteria;
	}
        
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}