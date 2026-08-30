<?php

class SADaftarTindakanM extends DaftartindakanM
{
	
	public $kategoritindakan_nama; //untuk pencarian / filter
	public $kelompoktindakan_nama; //untuk pencarian / filter
        public $jeniskegiatan_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DaftartindakanM the static model class
	 */
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
		$criteria->compare('LOWER(kategoritindakan.kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('LOWER(kelompoktindakan.kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->addCondition('daftartindakan_aktif is true');
		$criteria->addCondition('daftartindakan_karcis is false');
		$criteria->addCondition('daftartindakan_visite is false');
		$criteria->addCondition('daftartindakan_akomodasi is false');
		$criteria->addCondition('daftartindakan_konsul is false');
		$criteria->with=array('komponenunit','kelompoktindakan','kategoritindakan');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('komponenunit.komponenunit_id',$this->komponenunit_id);
		$criteria->compare('kelompoktindakan.kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('kategoritindakan.kategoritindakan_id',$this->kategoritindakan_id);
		// $criteria->compare('LOWER(komponenunit_nama)',strtolower($this->komponenunit_nama),true);
		// $criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		// $criteria->compare('LOWER(kelompoktindakan.kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
		$criteria->compare('LOWER(daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('LOWER(kategoritindakan.kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('LOWER(kelompoktindakan.kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('daftartindakan_karcis',$this->daftartindakan_karcis);
		$criteria->compare('daftartindakan_visite',$this->daftartindakan_visite);
		$criteria->compare('daftartindakan_konsul',$this->daftartindakan_konsul);
		$criteria->compare('daftartindakan_akomodasi',$this->daftartindakan_akomodasi);
		$criteria->compare('daftartindakan_aktif',isset($this->daftartindakan_aktif)?$this->daftartindakan_aktif:true);
//                $criteria->addCondition('daftartindakan_aktif is true');
                                $criteria->with=array('komponenunit','kelompoktindakan','kategoritindakan');

                  $dataprovider = new CActiveDataProvider(get_class($this));
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getUserData($id)
	{
		var_dump($id);

		$login =  LoginpemakaiK::model()->findByPk($id);
		return $login->nama_pemakai;
	}
}
