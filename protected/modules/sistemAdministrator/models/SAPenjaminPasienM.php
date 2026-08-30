<?php
class SAPenjaminPasienM extends PenjaminpasienM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenjaminpasienM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchPenjaminMCU()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                
		$criteria->with=array('carabayar');
		if (!empty($this->penjamin_id)){
			$criteria->addCondition('t.penjamin_id ='.$this->penjamin_id);
		}
		if (!empty($this->carabayar_id)){
			$criteria->addCondition('t.carabayar_id ='.$this->carabayar_id);
		}
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(t.penjamin_namalainnya)',strtolower($this->penjamin_namalainnya),true);
		$criteria->compare('penjamin_aktif',isset($this->penjamin_aktif)?$this->penjamin_aktif:true);
		$criteria->addCondition('t.carabayar_id = '.Params::CARABAYAR_ID_PERUSAHAAN);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPrintMCU()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                
		$criteria->with=array('carabayar');
		if (!empty($this->penjamin_id)){
			$criteria->addCondition('t.penjamin_id ='.$this->penjamin_id);
		}
		if (!empty($this->carabayar_id)){
			$criteria->addCondition('t.carabayar_id ='.$this->carabayar_id);
		}
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(t.penjamin_namalainnya)',strtolower($this->penjamin_namalainnya),true);
		$criteria->compare('penjamin_aktif',isset($this->penjamin_aktif)?$this->penjamin_aktif:true);
		$criteria->addCondition('t.carabayar_id = '.Params::CARABAYAR_ID_PERUSAHAAN);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

}