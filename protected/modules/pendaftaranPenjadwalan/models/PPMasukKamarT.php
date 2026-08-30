<?php

class PPMasukKamarT extends MasukkamarT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MasukkamarT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'masukkamar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carabayar_id, kelaspelayanan_id, ruangan_id, pasienadmisi_id, penjamin_id, shift_id, tglmasukkamar, nomasukkamar, jammasukkamar, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('carabayar_id, kamarruangan_id, kelaspelayanan_id, bookingkamar_id, ruangan_id, pasienadmisi_id, pegawai_id, penjamin_id, shift_id, lamadirawat_kamar', 'numerical', 'integerOnly'=>true),
			array('nomasukkamar', 'length', 'max'=>50),
			array('tglkeluarkamar, jamkeluarkamar, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('masukkamar_id, carabayar_id, kamarruangan_id, kelaspelayanan_id, bookingkamar_id, ruangan_id, pasienadmisi_id, pegawai_id, penjamin_id, shift_id, tglmasukkamar, nomasukkamar, jammasukkamar, tglkeluarkamar, jamkeluarkamar, lamadirawat_kamar, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'masukkamar_id' => 'Masukkamar',
			'carabayar_id' => 'Jenis Penjamin',
			'kamarruangan_id' => 'Kamarruangan',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'bookingkamar_id' => 'Bookingkamar',
			'ruangan_id' => 'Ruangan',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pegawai_id' => 'Pegawai',
			'penjamin_id' => 'Penjamin',
			'shift_id' => 'Shift',
			'tglmasukkamar' => 'Tglmasukkamar',
			'nomasukkamar' => 'Nomasukkamar',
			'jammasukkamar' => 'Jammasukkamar',
			'tglkeluarkamar' => 'Tglkeluarkamar',
			'jamkeluarkamar' => 'Jamkeluarkamar',
			'lamadirawat_kamar' => 'Lamadirawat Kamar',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
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

		if(!empty($this->kelompokumur_id)){
			$criteria->addCondition("kelompokumur_id = ".$this->kelompokumur_id); 			
		}
		if(!empty($this->masukkamar_id)){
			$criteria->addCondition("masukkamar_id = ".$this->masukkamar_id); 			
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
		}
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition("kamarruangan_id = ".$this->kamarruangan_id); 			
		}
		if(!empty($this->bookingkamar_id)){
			$criteria->addCondition("bookingkamar_id = ".$this->bookingkamar_id); 			
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 			
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id); 			
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id); 			
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id); 			
		}
		$criteria->compare('LOWER(tglmasukkamar)',strtolower($this->tglmasukkamar),true);
		$criteria->compare('LOWER(nomasukkamar)',strtolower($this->nomasukkamar),true);
		$criteria->compare('LOWER(jammasukkamar)',strtolower($this->jammasukkamar),true);
		$criteria->compare('LOWER(tglkeluarkamar)',strtolower($this->tglkeluarkamar),true);
		$criteria->compare('LOWER(jamkeluarkamar)',strtolower($this->jamkeluarkamar),true);
		$criteria->compare('lamadirawat_kamar',$this->lamadirawat_kamar);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
				if(!empty($this->kelompokumur_id)){
					$criteria->addCondition("kelompokumur_id = ".$this->kelompokumur_id); 			
				}
				if(!empty($this->masukkamar_id)){
					$criteria->addCondition("masukkamar_id = ".$this->masukkamar_id); 			
				}
				if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
				}
				if(!empty($this->kamarruangan_id)){
					$criteria->addCondition("kamarruangan_id = ".$this->kamarruangan_id); 			
				}
				if(!empty($this->bookingkamar_id)){
					$criteria->addCondition("bookingkamar_id = ".$this->bookingkamar_id); 			
				}
				if(!empty($this->ruangan_id)){
					$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 			
				}
				if(!empty($this->pasienadmisi_id)){
					$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id); 			
				}
				if(!empty($this->pegawai_id)){
					$criteria->addCondition("pegawai_id = ".$this->pegawai_id); 			
				}
				if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
				}
				if(!empty($this->shift_id)){
					$criteria->addCondition("shift_id = ".$this->shift_id); 			
				}
				$criteria->compare('LOWER(tglmasukkamar)',strtolower($this->tglmasukkamar),true);
				$criteria->compare('LOWER(nomasukkamar)',strtolower($this->nomasukkamar),true);
				$criteria->compare('LOWER(jammasukkamar)',strtolower($this->jammasukkamar),true);
				$criteria->compare('LOWER(tglkeluarkamar)',strtolower($this->tglkeluarkamar),true);
				$criteria->compare('LOWER(jamkeluarkamar)',strtolower($this->jamkeluarkamar),true);
				$criteria->compare('lamadirawat_kamar',$this->lamadirawat_kamar);
				$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
				$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
				$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
				$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
				$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}