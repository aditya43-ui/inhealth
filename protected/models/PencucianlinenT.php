<?php

/**
 * This is the model class for table "pencucianlinen_t".
 *
 * The followings are the available columns in table 'pencucianlinen_t':
 * @property integer $pencucianlinen_id
 * @property integer $perawatanlinen_id
 * @property integer $penerimaanlinen_id
 * @property string $tglpencucianlinen
 * @property string $nopencucianlinen
 * @property string $keterangan_pencucianlinen
 * @property integer $petugas_id
 * @property integer $pegpenerima_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PencucianlinenT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PencucianlinenT the static model class
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
		return 'pencucianlinen_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpencucianlinen, nopencucianlinen, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('petugas_id, pegpenerima_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nopencucianlinen', 'length', 'max'=>20),
			array('keterangan_pencucianlinen', 'length', 'max'=>200),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pencucianlinen_id, tglpencucianlinen, nopencucianlinen, keterangan_pencucianlinen, petugas_id, pegpenerima_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegpenerima'=>array(self::BELONGS_TO,'PegawaiM','pegpenerima_id'),
			'petugas'=>array(self::BELONGS_TO,'PegawaiM','petugas_id'),
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','create_ruangan'),                        
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pencucianlinen_id' => 'Pencucian Linen',
			'tglpencucianlinen' => 'Tanggal Pencucian',
			'nopencucianlinen' => 'No. Pencucian',
			'keterangan_pencucianlinen' => 'Keterangan',
			'petugas_id' => 'Petugas',
			'pegpenerima_id' => 'Pegawai',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		if(!empty($this->pencucianlinen_id)){
			$criteria->addCondition('pencucianlinen_id = '.$this->pencucianlinen_id);
		}
		if(!empty($this->perawatanlinen_id)){
			$criteria->addCondition('perawatanlinen_id = '.$this->perawatanlinen_id);
		}
		if(!empty($this->penerimaanlinen_id)){
			$criteria->addCondition('penerimaanlinen_id = '.$this->penerimaanlinen_id);
		}
		$criteria->compare('LOWER(tglpencucianlinen)',strtolower($this->tglpencucianlinen),true);
		$criteria->compare('LOWER(nopencucianlinen)',strtolower($this->nopencucianlinen),true);
		$criteria->compare('LOWER(keterangan_pencucianlinen)',strtolower($this->keterangan_pencucianlinen),true);
		if(!empty($this->petugas_id)){
			$criteria->addCondition('petugas_id = '.$this->petugas_id);
		}
		if(!empty($this->pegpenerima_id)){
			$criteria->addCondition('pegpenerima_id = '.$this->pegpenerima_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
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