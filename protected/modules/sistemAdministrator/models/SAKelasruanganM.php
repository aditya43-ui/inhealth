<?php

/**
 * This is the model class for table "tabularlist_m".
 *
 * The followings are the available columns in table 'tabularlist_m':
 * @property integer $tabularlist_id
 * @property string $tabularlist_chapter
 * @property string $tabularlist_block
 * @property string $tabularlist_title
 * @property string $tabularlist_revisi
 * @property string $tabularlist_versi
 * @property boolean $tabularlist_aktif
 */
class SAKelasruanganM extends KelasruanganM
{
	public $ruangan_nama; //untuk pencarian
	public $instalasi_nama; //untuk pencarian
	public $kelaspelayanan_nama; //untuk pencarian
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabularlistM the static model class
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
		$criteria->with = array('ruangan','ruangan.instalasi','kelaspelayanan');
		if(Yii::app()->session['modul_id'] == Params::MODUL_ID_SISADMIN){
			$criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
			$criteria->compare('LOWER(ruangan.instalasi.instalasi_nama)',$this->instalasi_nama,true);
		}else{
			$this->ruangan_id = Yii::app()->user->getState('ruangan_id');
			$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('t.kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                                $sessionruangan = Yii::app()->user->ruangan_id;
            
            
		$criteria=new CDbCriteria;
                $criteria->with=array('ruangan','kelaspelayanan');
//                                $criteria->distinct = true;
//                                $criteria->select = array('ruangan_id','kelaspelayanan_id');
                                $criteria->order = 'ruangan.ruangan_nama,kelaspelayanan.kelaspelayanan_nama';
                if (Yii::app()->controller->module->id =='sistemAdministrator') {
                    $criteria->compare('t.ruangan_id',Params::RUANGAN_ID_RAD);
                }else{
                        $criteria->compare('t.ruangan_id',$sessionruangan);
                }          
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan.kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                                                'pagination'=>false,
		));
	}

}