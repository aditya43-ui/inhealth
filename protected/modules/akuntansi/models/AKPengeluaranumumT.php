<?php

/**
 * This is the model class for table "pengeluaranumum_t".
 *
 * The followings are the available columns in table 'pengeluaranumum_t':
 * @property integer $pengeluaranumum_id
 * @property integer $tandabuktikeluar_id
 * @property integer $jenispengeluaran_id
 * @property string $kelompoktransaksi
 * @property string $nopengeluaran
 * @property string $tglpengeluaran
 * @property double $volume
 * @property string $satuanvol
 * @property double $hargasatuan
 * @property double $totalharga
 * @property double $biayaadministrasi
 * @property string $keterangankeluar
 * @property boolean $isurainkeluarumum
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class AKPengeluaranumumT extends PengeluaranumumT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengeluaranumumT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('tglpengeluaran', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pengeluaranumum_id)){
			$criteria->addCondition("pengeluaranumum_id = ".$this->pengeluaranumum_id);			
		}
		if(!empty($this->tandabuktikeluar_id)){
			$criteria->addCondition("tandabuktikeluar_id = ".$this->tandabuktikeluar_id);			
		}
		if(!empty($this->jenispengeluaran_id)){
			$criteria->addCondition("jenispengeluaran_id = ".$this->jenispengeluaran_id);			
		}
		$criteria->compare('LOWER(kelompoktransaksi)',strtolower($this->kelompoktransaksi),true);
		$criteria->compare('LOWER(nopengeluaran)',strtolower($this->nopengeluaran),true);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('LOWER(satuanvol)',strtolower($this->satuanvol),true);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('LOWER(keterangankeluar)',strtolower($this->keterangankeluar),true);
		$criteria->compare('isurainkeluarumum',$this->isurainkeluarumum);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}