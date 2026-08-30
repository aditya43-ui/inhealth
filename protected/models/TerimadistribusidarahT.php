<?php

/**
 * This is the model class for table "terimadistribusidarah_t".
 * @author Rusdiyanto <rusdiyanto@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 * The followings are the available columns in table 'terimadistribusidarah_t':
 * @property integer $terimadistribusidarah_id
 * @property integer $ruanganterima_id
 * @property integer $petugasdistribusi_pelayanandarah
 * @property string $tgl_terima
 * @property string $nomor_terima
 * @property string $keterangan_terima
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_ruangan
 */
class TerimadistribusidarahT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimadistribusidarahT the static model class
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
		return 'terimadistribusidarah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_loginpemakai_id, create_time, create_ruangan', 'required'),
			array('ruanganterima_id, petugasdistribusi_pelayanandarah, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nomor_terima', 'length', 'max'=>100),
			array('tgl_terima, keterangan_terima, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('terimadistribusidarah_id, ruanganterima_id, petugasdistribusi_pelayanandarah, tgl_terima, nomor_terima, keterangan_terima, create_loginpemakai_id, update_loginpemakai_id, create_time, update_time, create_ruangan', 'safe', 'on'=>'search'),
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
			'terimadistribusidarah_id' => 'Terimadistribusidarah',
			'ruanganterima_id' => 'Ruanganterima',
			'petugasdistribusi_pelayanandarah' => 'Petugasdistribusi Pelayanandarah',
			'tgl_terima' => 'Tgl. Terima',
			'nomor_terima' => 'Nomor Terima',
			'keterangan_terima' => 'Keterangan Terima',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->terimadistribusidarah_id)){
			$criteria->addCondition('terimadistribusidarah_id = '.$this->terimadistribusidarah_id);
		}
		if(!empty($this->ruanganterima_id)){
			$criteria->addCondition('ruanganterima_id = '.$this->ruanganterima_id);
		}
		if(!empty($this->petugasdistribusi_pelayanandarah)){
			$criteria->addCondition('petugasdistribusi_pelayanandarah = '.$this->petugasdistribusi_pelayanandarah);
		}
		$criteria->compare('LOWER(tgl_terima)',strtolower($this->tgl_terima),true);
		$criteria->compare('LOWER(nomor_terima)',strtolower($this->nomor_terima),true);
		$criteria->compare('LOWER(keterangan_terima)',strtolower($this->keterangan_terima),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}