<?php
class RMTariftindakanperdaruanganV  extends TariftindakanperdaruanganV
{
    public $is_pilih = 0;
    public $penjamin_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanperdaruanganV the static model class
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

               // if ((!empty($this->kelaspelayanan_id)) || (!empty($this->daftartindakan_id)) || (!empty($this->kategoritindakan_id))){
                    if (!empty($this->kelaspelayanan_id)){
						$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
					}
                    $criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_id),true);
                    if (!empty($this->kategoritindakan_id)){
						$criteria->addCondition('kategoritindakan_id ='.$this->kategoritindakan_id);
					}
					$ruangan_id = Yii::app()->user->getState('ruangan_id');
					if (!empty($ruangan_id)){
						$criteria->addCondition('ruangan_id ='.$ruangan_id);
					}
//                }
//                else{
//                    $criteria->compare('ruangan_id', 0);
//                }
		
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        

	
}

