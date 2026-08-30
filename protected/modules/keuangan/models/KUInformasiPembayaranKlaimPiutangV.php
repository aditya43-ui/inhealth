<?php
class KUInformasiPembayaranKlaimPiutangV extends InformasiPembayaranKlaimPiutangV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiPembayaranKlaimPiutangV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->addBetweenCondition('date(tglpembayaranklaim)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function searchInformasiPengajuan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->addBetweenCondition('date(tglpengajuanklaimanklaim)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pembayarklaim_id)){
			$criteria->addCondition('pembayarklaim_id = '.$this->pembayarklaim_id);
		}
//		$criteria->compare('LOWER(tglpembayaranklaim)',strtolower($this->tglpembayaranklaim),true);
		$criteria->addBetweenCondition('date(tglpembayaranklaim)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->compare('LOWER(nopembayaranklaim)',strtolower($this->nopembayaranklaim),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('totalpiutang',$this->totalpiutang);
		$criteria->compare('totalbayar',$this->totalbayar);
		$criteria->compare('telahbayar',$this->telahbayar);
		$criteria->compare('totalsisapiutang',$this->totalsisapiutang);
		if(!empty($this->bayarke)){
			$criteria->addCondition('bayarke = '.$this->bayarke);
		}
		$criteria->compare('LOWER(pembayaranmelalui)',strtolower($this->pembayaranmelalui),true);
		$criteria->compare('LOWER(nobuktisetor)',strtolower($this->nobuktisetor),true);
		$criteria->compare('LOWER(alamatpenyetor)',strtolower($this->alamatpenyetor),true);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(norekbank)',strtolower($this->norekbank),true);
		if(!empty($this->pengajuanklaimpiutang_id)){
			$criteria->addCondition('pengajuanklaimpiutang_id = '.$this->pengajuanklaimpiutang_id);
		}
		$criteria->compare('LOWER(tglpengajuanklaimanklaim)',strtolower($this->tglpengajuanklaimanklaim),true);
		$criteria->compare('LOWER(nopengajuanklaimanklaim)',strtolower($this->nopengajuanklaimanklaim),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}