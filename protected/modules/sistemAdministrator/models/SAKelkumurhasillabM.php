<?php

class SAKelkumurhasillabM extends KelkumurhasillabM {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelkumurhasillabM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/* manampilkan list lookup
	* @param type $lookup_type
	* @return array $data[$lookup_value] = $lookup_name
	*/
	public static function getLookupM($lookup_type=null)
	{
            
            $data = array();
            $criteria = new CDbCriteria();
            if(is_array($lookup_type))
                $criteria->addInCondition ('lookup_type', $lookup_type);
            else{
                $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
                $criteria->compare('lookup_type',$lookup_type);
            }
            $criteria->order = "lookup_urutan";
            $criteria->addCondition("lookup_aktif IS TRUE");
            $models =  LookupM::model()->findAll($criteria);
            if(count((array)$models) > 0){
                foreach($models as $model)
                    $data[$model->lookup_value]= ucwords(strtolower($model->lookup_name));
            }else{
                $data[""] = null;
            }
            
            return $data;
	}
	
	public function getKelompokUmur(){
		return self::model()->findAllByAttributes(array('kelkumurhasillab_aktif'=>true),array('order'=>'kelkumurhasillab_urutan'));
	}

	public function getStatus(){
		return self::model()->findAll('kelkumurhasillab_aktif=TRUE ORDER BY  kelkumurhasillab_aktif');
	}
}
