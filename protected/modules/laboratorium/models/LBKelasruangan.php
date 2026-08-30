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
class LBKelasruangan extends KelasruanganM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabularlistM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
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
		$criteria->order = 'ruangan.ruangan_nama,kelaspelayanan.kelaspelayanan_nama';
		if (Yii::app()->controller->module->id =='sistemAdministrator') {
			$criteria->addInCondition('t.ruangan_id',array(Params::RUANGAN_ID_LAB, Params::RUANGAN_ID_LAB_KLINIK, Params::RUANGAN_ID_LAB_ANATOMI));
		}else{
			if(!empty($sessionruangan)){
				$criteria->addCondition('t.ruangan_id = '.$sessionruangan);
			}
		}          
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('t.kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(kelaspelayanan.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan.kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
	public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                $sessionruangan = Yii::app()->user->ruangan_id;
            
            
		$criteria=new CDbCriteria;
		$criteria->with=array('ruangan','kelaspelayanan');
		$criteria->order = 'ruangan.ruangan_nama,kelaspelayanan.kelaspelayanan_nama';
		if (Yii::app()->controller->module->id =='sistemAdministrator') {
			$criteria->addInCondition('t.ruangan_id',array(Params::RUANGAN_ID_LAB, Params::RUANGAN_ID_LAB_KLINIK, Params::RUANGAN_ID_LAB_ANATOMI));
		}else{
			if(!empty($sessionruangan)){
				$criteria->addCondition('t.ruangan_id = '.$sessionruangan);
			}
		}          
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('t.kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(kelaspelayanan.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan.kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'ruangan_nama'=>array(
                                    'asc'=>'ruangan.ruangan_nama',
                                    'desc'=>'ruangan.ruangan_nama DESC',
                                ),
                                'kelaspelayanan_nama'=>array(
                                    'asc'=>'kelaspelayanan.kelaspelayanan_nama',
                                    'desc'=>'kelaspelayanan.kelaspelayanan_nama DESC',
                                ),
                                'kelaspelayanan_namalainnya'=>array(
                                    'asc'=>'kelaspelayanan.kelaspelayanan_namalainnya',
                                    'desc'=>'kelaspelayanan.kelaspelayanan_namalainnya DESC',
                                ),
                                '*',
                            ),
                        ),
		));
	}
        
          public function getRuanganItems()
                {
                    return RuanganM::model()->findAll(array('order'=>'ruangan_nama'));
                }
                
           public function getKelasPelayananItems()
                {
                    return KelaspelayananM::model()->findAll(array('order'=>'kelaspelayanan_nama'));
                }

}