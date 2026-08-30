<?php
class PPPenjaminpasienM extends PenjaminpasienM {
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    
		
	}
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with=array('carabayar');
		$criteria->compare('t.penjamin_id',$this->penjamin_id);
		$criteria->compare('t.carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(t.penjamin_namalainnya)',strtolower($this->penjamin_namalainnya),true);
		$criteria->compare('penjamin_aktif',isset($this->penjamin_aktif)?$this->penjamin_aktif:true);
		$criteria->limit=-1;
		$criteria->order='penjamin_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>false,
		));
	}
	

}