
<?php
class MCPemanggilanmcuV extends PemanggilanmcuV
{
	public $tgl_awal_kontrol,$tgl_akhir_kontrol,
        $jns_periode,
        $tgl_awal,
        $tgl_akhir,
        $bln_awal,
        $bln_akhir,
        $thn_awal,
        $thn_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemanggilanmcuV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchPemanggilanMcu()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		if(!Yii::app()->request->isAjaxRequest){//data hanya muncul setelah melakukan pencarian
			$criteria->limit = 0;
		}

		$this->tgl_awal_kontrol = MyFormatter::formatDateTimeForDb($this->tgl_awal_kontrol);
		$this->tgl_akhir_kontrol = MyFormatter::formatDateTimeForDb($this->tgl_akhir_kontrol);

		$criteria->addBetweenCondition('DATE(tglrenkontrol)', $this->tgl_awal_kontrol, $this->tgl_akhir_kontrol,true);
		
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nopeserta)',strtolower($this->nopeserta),true);
		if(!empty($this->pemanggilanke)){
			$criteria->addCondition('pemanggilanke = '.$this->pemanggilanke);
		}
		$criteria->compare('LOWER(keterangan_pemanggilan)',strtolower($this->keterangan_pemanggilan),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->addCondition('status_hubungan IS NULL');
		if (!empty($this->status_hubungan)){
			$criteria->compare('LOWER(status_hubungan)',strtolower('pekerja'),true);
		}

		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('DATE(tglrenkontrol)', $this->tgl_awal_kontrol, $this->tgl_akhir_kontrol);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		if(!empty($this->pemanggilanke)){
			$criteria->addCondition('pemanggilanke = '.$this->pemanggilanke);
		}
		$criteria->compare('LOWER(keterangan_pemanggilan)',strtolower($this->keterangan_pemanggilan),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->asuransipasien_id)){
			$criteria->addCondition('asuransipasien_id = '.$this->asuransipasien_id);
		}
		$criteria->compare('LOWER(namaperusahaan)',strtolower($this->namaperusahaan),true);
		$criteria->compare('LOWER(nopeserta)',strtolower($this->nopeserta),true);
		$criteria->compare('LOWER(namapemilikasuransi)',strtolower($this->namapemilikasuransi),true);
		$criteria->compare('LOWER(status_hubungan)',strtolower($this->status_hubungan),true);
		
		$criteria->select = 'pendaftaran_id, tglrenkontrol, no_rekam_medik, nama_pasien, nopeserta, status_hubungan, pasien_id';
        $criteria->group = $criteria->select;
		$criteria->order = 'pendaftaran_id DESC';
        
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	/*public function getHeaderDetail()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id, true);
		$criteria->select = 'pendaftaran_id, no_rekam_medik, nama_pasien, nopeserta, status_hubungan';
		$criteria->group = $criteria->select;
		$criteria->order = 'pendaftaran_id DESC';
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	 * 
	 */

}