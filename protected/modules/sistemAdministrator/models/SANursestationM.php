<?php

/**
 * This is the model class for table "nursestation_m".
 *
 * The followings are the available columns in table 'nursestation_m':
 * @property integer $nursestation_id
 * @property string $nursestation_nama
 * @property string $nursestation_namalain
 * @property string $nursestation_lokasi
 * @property string $nursestation_telp
 * @property integer $nursestation_pj_id
 * @property boolean $nursestation_akitf
 */
class SANursestationM extends NursestationM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NursestationM the static model class
	 */
	public $nama_pj;
			
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
		
		$criteria->compare('nursestation_id',$this->nursestation_id);
		$criteria->compare('nursestation_nama',$this->nursestation_nama,true);
		$criteria->compare('nursestation_namalain',$this->nursestation_namalain,true);
		$criteria->compare('nursestation_lokasi',$this->nursestation_lokasi,true);
		$criteria->compare('nursestation_telp',$this->nursestation_telp,true);
		$criteria->compare('nursestation_pj_id',$this->nursestation_pj_id);
		$criteria->compare('nursestation_akitf',$this->nursestation_akitf);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('nursestation_id',$this->nursestation_id);
		$criteria->compare('nursestation_nama',$this->nursestation_nama,true);
		$criteria->compare('nursestation_namalain',$this->nursestation_namalain,true);
		$criteria->compare('nursestation_lokasi',$this->nursestation_lokasi,true);
		$criteria->compare('nursestation_telp',$this->nursestation_telp,true);
		$criteria->compare('nursestation_pj_id',$this->nursestation_pj_id);
		$criteria->compare('nursestation_akitf',$this->nursestation_akitf);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
	
	public function getRuangan(){
		$ruangan = "<ul>";
		$modNurseruangan = SANursestationruanganM::model()->findAll('nursestation_id='.$this->nursestation_id);
		if(count($modNurseruangan)){
			foreach($modNurseruangan as $value){
				$modRuangan = RuanganM::model()->findByPk($value->ruangan_id);
				$ruangan .= "<li>".$modRuangan->ruangan_nama."</li>";
			}
		}
		$ruangan .= "</ul>";
		return $ruangan;
	}
}