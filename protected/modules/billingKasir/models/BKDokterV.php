<?php

class BKDokterV extends DokterV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DokterV the static model class
	 */
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
         * untuk dialog pemilihan dokter pemeriksa 1
         * @return \CActiveDataProvider
         */
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
        $criteria->compare('jabatan_id', $this->jabatan_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->addCondition('pegawai_aktif = true');
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
                $criteria->limit = 5;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>5),
		));
	}
	/**
         * untuk dialog pemilihan dokter pemeriksa 2
         * @return \CActiveDataProvider
         */
	public function searchDialog2()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->addCondition('pegawai_aktif = true');
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
                $criteria->limit = 5;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>5),
		));
	}
        
       
}