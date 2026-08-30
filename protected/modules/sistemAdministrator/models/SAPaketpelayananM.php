<?php
class SAPaketpelayananM extends PaketpelayananM { 
    
    public $tipepaket_nama,$kategori_nama,$kategoritindakan_nama,$daftartindakan_kode,$daftartindakan_nama,$harga_tariftindakan;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchData()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->with = array('daftartindakan', 'tipepaket', 'ruangan');
		if (!empty($this->paketpelayanan_id)){
			$criteria->addCondition('paketpelayanan_id ='.$this->paketpelayanan_id);
		}
		if (!empty($this->daftartindakan_id)){
			$criteria->addCondition('t.daftartindakan_id ='.$this->daftartindakan_id);
		}
		if (!empty($this->tipepaket_id)){
			$criteria->addCondition('t.tipepaket_id ='.$this->tipepaket_id);
		}
		$criteria->compare('t.tipepaket_nama',$this->tipepaket_nama);
		if (!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id ='.$this->ruangan_id);
		}
		$criteria->compare('LOWER(t.namatindakan)',  strtolower($this->namatindakan), true);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',  strtolower($this->daftartindakanNama), true);
		$criteria->compare('LOWER(tipepaket.tipepaket_nama)',  strtolower($this->tipepaketNama), true);
		$criteria->compare('LOWER(ruangan.ruangan_nama)',  strtolower($this->ruanganNama), true);
		$criteria->compare('LOWER(t.subsidiasuransi)',  strtolower($this->subsidiasuransi), true);                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
        }
