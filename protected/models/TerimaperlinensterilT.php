<?php

/**
 * This is the model class for table "terimaperlinensteril_t".
 *
 * The followings are the available columns in table 'terimaperlinensteril_t':
 * @property integer $terimaperlinensteril_id
 * @property integer $ruangan_id
 * @property integer $kirimperlinensteril_id
 * @property string $terimaperlinensteril_no
 * @property string $terimaperlinensteril_tgl
 * @property string $terimaperlinensteril_ket
 * @property integer $pegpenerima_id
 * @property integer $pegmengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class TerimaperlinensterilT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimaperlinensterilT the static model class
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
		return 'terimaperlinensteril_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, terimaperlinensteril_no, terimaperlinensteril_tgl, pegpenerima_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, kirimperlinensteril_id, pegpenerima_id, pegmengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('terimaperlinensteril_no', 'length', 'max'=>20),
			array('terimaperlinensteril_ket', 'length', 'max'=>500),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('terimaperlinensteril_id, ruangan_id, kirimperlinensteril_id, terimaperlinensteril_no, terimaperlinensteril_tgl, terimaperlinensteril_ket, pegpenerima_id, pegmengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'linen' => array(self::BELONGS_TO, 'LinenM', 'linen_id'),
			'pegawaiMenerima'=>array(self::BELONGS_TO,'PegawaiM','pegpenerima_id'),
			'pegawaiMengetahui'=>array(self::BELONGS_TO,'PegawaiM','pegmengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'terimaperlinensteril_id' => 'Terimaperlinensteril',
			'ruangan_id' => 'Ruangan',
			'kirimperlinensteril_id' => 'Kirimperlinensteril',
			'terimaperlinensteril_no' => 'No. Penerimaan',
			'terimaperlinensteril_tgl' => 'Tanggal Penerimaan',
			'terimaperlinensteril_ket' => 'Keterangan',
			'pegpenerima_id' => 'Pegawai Penerima',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
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

		if(!empty($this->terimaperlinensteril_id)){
			$criteria->addCondition('terimaperlinensteril_id = '.$this->terimaperlinensteril_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->kirimperlinensteril_id)){
			$criteria->addCondition('kirimperlinensteril_id = '.$this->kirimperlinensteril_id);
		}
		$criteria->compare('LOWER(terimaperlinensteril_no)',strtolower($this->terimaperlinensteril_no),true);
		$criteria->compare('LOWER(terimaperlinensteril_tgl)',strtolower($this->terimaperlinensteril_tgl),true);
		$criteria->compare('LOWER(terimaperlinensteril_ket)',strtolower($this->terimaperlinensteril_ket),true);
		if(!empty($this->pegpenerima_id)){
			$criteria->addCondition('pegpenerima_id = '.$this->pegpenerima_id);
		}
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
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