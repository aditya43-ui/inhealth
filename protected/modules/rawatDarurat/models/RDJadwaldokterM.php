<?php

/**
 * This is the model class for table "jadwaldokter_m".
 *
 * The followings are the available columns in table 'jadwaldokter_m':
 * @property integer $jadwaldokter_id
 * @property integer $instalasi_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property string $jadwaldokter_hari
 * @property string $jadwaldokter_buka
 * @property string $jadwaldokter_mulai
 * @property string $jadwaldokter_tutup
 * @property integer $maximumantrian
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class RDJadwaldokterM extends JadwaldokterM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JadwaldokterM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchJadwalIGD()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria(array(
                    'distinct' => true,
                    'select' => array('pegawai_id')
                    ));

            $criteria->addCondition('t.instalasi_id = '.Params::INSTALASI_ID_RD);
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
			}
			if(!empty($this->pegawai_id)){
				$criteria->addCondition("pegawai_id = ".$this->pegawai_id);				
			}
            $criteria->compare('jadwaldokter_tutup',strtolower($this->jadwaldokter_tutup));
            $criteria->compare('jadwaldokter_mulai',strtolower($this->jadwaldokter_mulai));
            $criteria->compare('maximumantrian',$this->maximumantrian);


            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    public function searchJadwalRJ()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria(array(
                    'distinct' => true,
                    'select' => array('pegawai_id'),
                    ));

			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
			}
			if(!empty($this->pegawai_id)){
				$criteria->addCondition("pegawai_id = ".$this->pegawai_id);				
			}
            $criteria->compare('jadwaldokter_tutup',strtolower($this->jadwaldokter_tutup));
            $criteria->compare('jadwaldokter_mulai',strtolower($this->jadwaldokter_mulai));
            $criteria->compare('maximumantrian',$this->maximumantrian);


            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		if(!empty($this->jadwaldokter_id)){
			$criteria->addCondition("jadwaldokter_id = ".$this->jadwaldokter_id);				
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id);				
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("t.instalasi_id = ".$this->ruangan_id);				
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);				
		}		
		$criteria->compare('LOWER(jadwaldokter_hari)',strtolower($this->jadwaldokter_hari),true);
		$criteria->compare('LOWER(jadwaldokter_buka)',strtolower($this->jadwaldokter_buka),true);
//		$criteria->addBetweenCondition('jadwaldokter_mulai', $this->jadwaldokter_mulai, $this->jadwaldokter_tutup);
		$criteria->compare('jadwaldokter_tutup',strtolower($this->jadwaldokter_tutup));
		$criteria->compare('jadwaldokter_mulai',strtolower($this->jadwaldokter_mulai));
		$criteria->compare('maximumantrian',$this->maximumantrian);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
?>
