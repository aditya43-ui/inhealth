<?php

class AMPasienpulangrddanriV extends PasienpulangrddanriV
{
         public $ceklis = false;
         public $tgl_awal,$tgl_akhir,$kepadayth;
         public $tglselesaiperiksa, $kelaspelayanan_id, $kelaspelayanan_nama; //HARUSNYA DITAMBAHKAN DI VIEW DB NYA
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganrdV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPasienPulang()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

//                $criteria->with=array('pendaftaran','pasien');
                if($this->ceklis){
                    $criteria->addBetweenCondition ('DATE(tglpasienpulang)', $this->tgl_awal, $this->tgl_akhir);
                }
                $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
                $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
                $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}