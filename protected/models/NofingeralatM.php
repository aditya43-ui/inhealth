<?php

/**
 * This is the model class for table "nofingeralat_m".
 *
 * The followings are the available columns in table 'nofingeralat_m':
 * @property integer $nofingeralat_id
 * @property integer $pegawai_id
 * @property integer $alatfinger_id
 * @property string $tglregistrasifinger
 * @property integer $nofinger
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class NofingeralatM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NofingeralatM the static model class
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
		return 'nofingeralat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, alatfinger_id, tglregistrasifinger, nofinger, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, alatfinger_id, nofinger', 'numerical', 'integerOnly'=>true),
			array('update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nofingeralat_id, pegawai_id, alatfinger_id, tglregistrasifinger, nofinger, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'nofingeralat_id' => 'Nofingeralat',
			'pegawai_id' => 'Pegawai',
			'alatfinger_id' => 'Alatfinger',
			'tglregistrasifinger' => 'Tglregistrasifinger',
			'nofinger' => 'Nofinger',
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

		$criteria->compare('nofingeralat_id',$this->nofingeralat_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('alatfinger_id',$this->alatfinger_id);
		$criteria->compare('LOWER(tglregistrasifinger)',strtolower($this->tglregistrasifinger),true);
		$criteria->compare('nofinger',$this->nofinger);
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
		$criteria->compare('nofingeralat_id',$this->nofingeralat_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('alatfinger_id',$this->alatfinger_id);
		$criteria->compare('LOWER(tglregistrasifinger)',strtolower($this->tglregistrasifinger),true);
		$criteria->compare('nofinger',$this->nofinger);
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