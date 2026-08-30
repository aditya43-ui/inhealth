<?php

class KULaporanpembayaranjasadokterV extends LaporanpembayaranjasadokterV
{
        public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpembayaranjasadokterV the static model class
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

		if(!empty($this->pembayaranjasa_id)){
			$criteria->addCondition('pembayaranjasa_id = '.$this->pembayaranjasa_id);
		}
		if(!empty($this->tandabuktikeluar_id)){
			$criteria->addCondition('tandabuktikeluar_id = '.$this->tandabuktikeluar_id);
		}
		if(!empty($this->rujukandari_id)){
			$criteria->addCondition('rujukandari_id = '.$this->rujukandari_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->addBetweenCondition('tglbayarjasa',$this->tgl_awal, $this->tgl_akhir);
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
		if(!empty($this->asalrujukan_id)){
			$criteria->addCondition('asalrujukan_id = '.$this->asalrujukan_id);
		}
		$criteria->compare('LOWER(namaperujuk)',strtolower($this->namaperujuk),true);
		$criteria->compare('LOWER(spesialis)',strtolower($this->spesialis),true);
		$criteria->compare('LOWER(alamatlengkap)',strtolower($this->alamatlengkap),true);
		$criteria->compare('LOWER(notelp)',strtolower($this->notelp),true);
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		$criteria->compare('ruangan_tandabukti',$this->ruangan_tandabukti);
		$criteria->compare('LOWER(tahun)',strtolower($this->tahun),true);
		$criteria->compare('LOWER(tglkaskeluar)',strtolower($this->tglkaskeluar),true);
		$criteria->compare('LOWER(nokaskeluar)',strtolower($this->nokaskeluar),true);
		$criteria->compare('LOWER(carabayarkeluar)',strtolower($this->carabayarkeluar),true);
		$criteria->compare('LOWER(melalubank)',strtolower($this->melalubank),true);
		$criteria->compare('LOWER(denganrekening)',strtolower($this->denganrekening),true);
		$criteria->compare('LOWER(atasnamarekening)',strtolower($this->atasnamarekening),true);
		$criteria->compare('LOWER(namapenerima)',strtolower($this->namapenerima),true);
		$criteria->compare('LOWER(alamatpenerima)',strtolower($this->alamatpenerima),true);
		$criteria->compare('LOWER(untukpembayaran)',strtolower($this->untukpembayaran),true);
		$criteria->compare('jmlkaskeluar',$this->jmlkaskeluar);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('LOWER(keterangan_pengeluaran)',strtolower($this->keterangan_pengeluaran),true);
                return $criteria;
		
	}
        
        public function searchLaporan(){
            $criteria = $this->criteriaSearch();
            $criteria->compare('create_ruangan',Yii::app()->user->getState('ruangan_id'));
            $criteria->order = 'nama_pegawai, namaperujuk ASC';
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
}