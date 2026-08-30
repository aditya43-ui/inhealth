<?php

class KUPembjasadetailT extends PembjasadetailT
{
	public $pilihDetail; //checkbox transaksi pembayaran jasa
	public $penjaminId; 
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembjasadetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pembjasadetail_id)){
			$criteria->addCondition("pembjasadetail_id = ".$this->pembjasadetail_id);					
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);					
		}
		if(!empty($this->pembayaranjasa_id)){
			$criteria->addCondition("pembayaranjasa_id = ".$this->pembayaranjasa_id);					
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition("pasienmasukpenunjang_id = ".$this->pasienmasukpenunjang_id);					
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id);					
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);					
		}
		$criteria->compare('jumahtarif',$this->jumahtarif);
		$criteria->compare('jumlahjasa',$this->jumlahjasa);
		$criteria->compare('jumlahbayar',$this->jumlahbayar);
		$criteria->compare('sisajasa',$this->sisajasa);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
	public function searchPrint()
	{
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;
		
		if(!empty($this->pembjasadetail_id)){
			$criteria->addCondition("pembjasadetail_id = ".$this->pembjasadetail_id);					
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);					
		}
		if(!empty($this->pembayaranjasa_id)){
			$criteria->addCondition("pembayaranjasa_id = ".$this->pembayaranjasa_id);					
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition("pasienmasukpenunjang_id = ".$this->pasienmasukpenunjang_id);					
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id);					
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);					
		}
		$criteria->compare('jumahtarif',$this->jumahtarif);
		$criteria->compare('jumlahjasa',$this->jumlahjasa);
		$criteria->compare('jumlahbayar',$this->jumlahbayar);
		$criteria->compare('sisajasa',$this->sisajasa);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}