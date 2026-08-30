<?php

class LBPemeriksaanlabdetM extends PemeriksaanlabdetM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public $pemeriksaanlab_nama,$nilairujukan_keterangan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nilairujukan_id, pemeriksaanlab_id, pemeriksaanlabdet_nourut', 'required'),
			array('nilairujukan_id, pemeriksaanlab_id, pemeriksaanlabdet_nourut', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanlabdet_id, nilairujukan_id, pemeriksaanlab_id, pemeriksaanlabdet_nourut, pemeriksaanlab_nama', 'safe', 'on'=>'search'),
		);
	}
        
	public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		$criteria->with = array('nilairujukan','pemeriksaanlab');
		$criteria->order = 't.pemeriksaanlab_id, nilairujukan.kelompokdet, nilairujukan.nilairujukan_jeniskelamin';
		$criteria->compare('LOWER(pemeriksaanlab.pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
		if(!empty($this->nilairujukan_id)){
			$criteria->addCondition('t.nilairujukan_id = '.$this->nilairujukan_id);
		}
		if(!empty($this->pemeriksaanlab_id)){
			$criteria->addCondition('t.pemeriksaanlab_id = '.$this->pemeriksaanlab_id);
		}
		$criteria->compare('pemeriksaanlabdet_nourut',$this->pemeriksaanlabdet_nourut);
		$criteria->compare('pemeriksaanlab_nama',$this->pemeriksaanlab_nama, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'pemeriksaanlab_nama'=>array(
                                    'asc'=>'pemeriksaanlab.pemeriksaanlab_nama',
                                    'desc'=>'pemeriksaanlab.pemeriksaanlab_nama DESC',
                                ),
                                '*',
                            ),
                        ),
		));
	}
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

			$criteria=new CDbCriteria;
			if(!empty($this->pemeriksaanlabdet_id)){
				$criteria->addCondition('pemeriksaanlabdet_id = '.$this->pemeriksaanlabdet_id);
			}
			if(!empty($this->nilairujukan_id)){
				$criteria->addCondition('nilairujukan_id = '.$this->nilairujukan_id);
			}
			if(!empty($this->pemeriksaanlab_id)){
				$criteria->addCondition('pemeriksaanlab_id = '.$this->pemeriksaanlab_id);
			}
			$criteria->compare('pemeriksaanlabdet_nourut',$this->pemeriksaanlabdet_nourut);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getPemeriksaanlabItems()
        {
            return PemeriksaanlabM::model()->findAll('pemeriksaanlab_aktif=TRUE ORDER BY pemeriksaanlab_nama');
        }
        
        public function getNilairujukanItems()
        {
            return NilairujukanM::model()->findAll('nilairujukan_aktif=TRUE ORDER BY namapemeriksaandet');
        }
}