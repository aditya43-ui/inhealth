<?php

/**
 * This is the model class for table "penlinenruangan_t".
 *
 * The followings are the available columns in table 'penlinenruangan_t':
 * @property integer $penlinenruangan_id
 * @property string $tglpenlinenruangan
 * @property string $nopenlinenruangan
 * @property integer $pegpenerima_id
 * @property integer $pegmengetahui_id
 * @property string $keterangan_penlinenruangan
 * @property integer $ruanganasal_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $pengirimanlinen_id
 *
 * The followings are the available model relations:
 * @property PengirimanlinenT $pengirimanlinen
 */
class PenlinenruanganT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenlinenruanganT the static model class
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
		return 'penlinenruangan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpenlinenruangan, nopenlinenruangan, ruanganasal_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegpenerima_id, pegmengetahui_id, ruanganasal_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pengirimanlinen_id', 'numerical', 'integerOnly'=>true),
			array('nopenlinenruangan', 'length', 'max'=>20),
			array('keterangan_penlinenruangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penlinenruangan_id, tglpenlinenruangan, nopenlinenruangan, pegpenerima_id, pegmengetahui_id, keterangan_penlinenruangan, ruanganasal_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pengirimanlinen_id', 'safe', 'on'=>'search'),
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
			'pengirimanlinen' => array(self::BELONGS_TO, 'PengirimanlinenT', 'pengirimanlinen_id'),
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruanganasal_id'),
			'pegpenerima'=>array(self::BELONGS_TO,'PegawaiM','pegpenerima_id'),
			'pegmengetahui'=>array(self::BELONGS_TO,'PegawaiM','pegmengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penlinenruangan_id' => 'Penlinenruangan',
			'tglpenlinenruangan' => 'Tanggal Penerimaan',
			'nopenlinenruangan' => 'No. Penerimaan',
			'pegpenerima_id' => 'Pegawai Penerima',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
			'keterangan_penlinenruangan' => 'Keterangan',
			'ruanganasal_id' => 'Ruangan Asal',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pengirimanlinen_id' => 'Pengirimanlinen',
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

		if(!empty($this->penlinenruangan_id)){
			$criteria->addCondition('penlinenruangan_id = '.$this->penlinenruangan_id);
		}
		$criteria->compare('LOWER(tglpenlinenruangan)',strtolower($this->tglpenlinenruangan),true);
		$criteria->compare('LOWER(nopenlinenruangan)',strtolower($this->nopenlinenruangan),true);
		if(!empty($this->pegpenerima_id)){
			$criteria->addCondition('pegpenerima_id = '.$this->pegpenerima_id);
		}
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		$criteria->compare('LOWER(keterangan_penlinenruangan)',strtolower($this->keterangan_penlinenruangan),true);
		if(!empty($this->ruanganasal_id)){
			$criteria->addCondition('ruanganasal_id = '.$this->ruanganasal_id);
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
		if(!empty($this->pengirimanlinen_id)){
			$criteria->addCondition('pengirimanlinen_id = '.$this->pengirimanlinen_id);
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