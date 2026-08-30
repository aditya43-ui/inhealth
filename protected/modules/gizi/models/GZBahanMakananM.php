<?php

class GZBahanMakananM extends BahanmakananM {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public $kandunganbahan,$zatgizi_nama,$zatgizi_id,$namabahanmakanan;
    public function searchKomposisi()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria();
        
        
                $criteria->select = 't.namabahanmakanan, t.bahanmakanan_id,sum(zatbahanmakan_m.kandunganbahan) as kandunganbahan';
                $criteria->group = 'zatbahanmakan_m.bahanmakanan_id, t.namabahanmakanan, t.bahanmakanan_id';
                $criteria->order='t.namabahanmakanan';
                $criteria->join ='LEFT JOIN zatbahanmakan_m ON zatbahanmakan_m.bahanmakanan_id = t.bahanmakanan_id LEFT JOIN zatgizi_m ON zatgizi_m.zatgizi_id = zatbahanmakan_m.zatgizi_id';
                
		$criteria->compare('LOWER(t.namabahanmakanan)',strtolower($this->namabahanmakanan),true);
//		$criteria->compare('kabupaten_id',$this->kabupaten_id);
//		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
//		$criteria->compare('kecamatan_id',$this->kecamatan_id);
//		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
//		$criteria->compare('kelurahan_id',$this->kelurahan_id);
//		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
//		$criteria->compare('instalasi_id',$this->instalasi_id);
//		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
//		$criteria->compare('carabayar_id',$this->carabayar_id);
//		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
//		$criteria->compare('penjamin_id',$this->penjamin_id);
//		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
//		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
//		                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchDialog()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(kelbahanmakanan)',strtolower($this->kelbahanmakanan),true);
        $criteria->compare('LOWER(jenisbahanmakanan)',strtolower($this->jenisbahanmakanan),true);
        $criteria->compare('LOWER(namabahanmakanan)',strtolower($this->namabahanmakanan),true);
        $criteria->compare('LOWER(satuanbahan)',strtolower($this->satuanbahan),true);
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
}