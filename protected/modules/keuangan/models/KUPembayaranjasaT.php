<?php

class KUPembayaranjasaT extends PembayaranjasaT
{
        public $pilihDokter, $tgl_awalPenunjang, $tgl_akhirPenunjang, $tgl_awalPendaftaran, $tgl_akhirPendaftaran, $rujukandariNama, $pegawaiNama; 
        //untuk pencarian
        public $noKasKeluar, $namaPerujuk, $namaDokter, $tgl_awal, $tgl_akhir, $komponentarifId;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayaranjasaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                
		$criteria=new CDbCriteria;
		$criteria->with = array('rujukandari', 'pegawai', 'tandabuktikeluar');
		if(!empty($this->pembayaranjasa_id)){
			$criteria->addCondition("pembayaranjasa_id = ".$this->pembayaranjasa_id);					
		}
		if(!empty($this->tandabuktikeluar_id)){
			$criteria->addCondition("tandabuktikeluar_id = ".$this->tandabuktikeluar_id);					
		}
		if(!empty($this->rujukandari_id)){
			$criteria->addCondition("rujukandari_id = ".$this->rujukandari_id);					
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);					
		}
		$criteria->compare('LOWER(nobayarjasa)',strtolower($this->nobayarjasa),true);
		$criteria->compare('LOWER(periodejasa)',strtolower($this->periodejasa),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		
		$criteria->compare('LOWER(tandabuktikeluar.nokaskeluar)',strtolower($this->noKasKeluar),true);
		$criteria->compare('LOWER(rujukandari.namaperujuk)',strtolower($this->namaPerujuk),true);
		$criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->namaDokter),true);
                
                
		return $criteria;
	}
        
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                
		$criteria=$this->criteriaSearch();
                $criteria->addBetweenCondition('tglbayarjasa', $this->tgl_awal, $this->tgl_akhir);
                $criteria->order = "tglbayarjasa";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchTableLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                
		$criteria=$this->criteriaSearch();
                $criteria->addBetweenCondition('tglbayarjasa', $this->tgl_awal, $this->tgl_akhir);
                $criteria->order = "tglbayarjasa";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchPrint()
	{
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;
		
		if(!empty($this->pembayaranjasa_id)){
			$criteria->addCondition("pembayaranjasa_id = ".$this->pembayaranjasa_id);					
		}
		if(!empty($this->tandabuktikeluar_id)){
			$criteria->addCondition("tandabuktikeluar_id = ".$this->tandabuktikeluar_id);					
		}
		if(!empty($this->rujukandari_id)){
			$criteria->addCondition("rujukandari_id = ".$this->rujukandari_id);					
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);					
		}
		$criteria->compare('LOWER(tglbayarjasa)',strtolower($this->tglbayarjasa),true);
		$criteria->compare('LOWER(nobayarjasa)',strtolower($this->nobayarjasa),true);
		$criteria->compare('LOWER(periodejasa)',strtolower($this->periodejasa),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('totaltarif',$this->totaltarif);
		$criteria->compare('totaljasa',$this->totaljasa);
		$criteria->compare('totalbayarjasa',$this->totalbayarjasa);
		$criteria->compare('totalsisajasa',$this->totalsisajasa);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}