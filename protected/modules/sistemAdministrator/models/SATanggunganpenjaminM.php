<?php
class SATanggunganpenjaminM extends TanggunganpenjaminM {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//                $criteria->select = 'carabayar_id, kelaspelayanan_id';
//                $criteria->group = 'carabayar_id, kelaspelayanan_id';
		$criteria->order = 'carabayar_id, kelaspelayanan_id';
		
		if (!empty($this->tanggunganpenjamin_id)){
			$criteria->addCondition('tanggunganpenjamin_id ='.$this->tanggunganpenjamin_id);
		}
		if (!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
		}
		if (!empty($this->penjamin)){
			$criteria->addCondition('penjamin_id ='.$this->penjamin);
		}
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
		if (!empty($this->tipenonpaket_id)){
			$criteria->addCondition('tipenonpaket_id ='.$this->tipenonpaket_id);
		}
		$criteria->compare('subsidiasuransitind',$this->subsidiasuransitind);
		$criteria->compare('subsidipemerintahtind',$this->subsidipemerintahtind);
		$criteria->compare('subsidirumahsakittind',$this->subsidirumahsakittind);
		$criteria->compare('iurbiayatind',$this->iurbiayatind);
		$criteria->compare('subsidiasuransioa',$this->subsidiasuransioa);
		$criteria->compare('subsidipemerintahoa',$this->subsidipemerintahoa);
		$criteria->compare('subsidirumahsakitoa',$this->subsidirumahsakitoa);
		$criteria->compare('iurbiayaoa',$this->iurbiayaoa);
		$criteria->compare('persentanggcytopel',$this->persentanggcytopel);
		$criteria->compare('makstanggpel',$this->makstanggpel);
		$criteria->compare('tanggunganpenjamin_aktif',isset($this->tanggunganpenjamin_aktif)?$this->tanggunganpenjamin_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}