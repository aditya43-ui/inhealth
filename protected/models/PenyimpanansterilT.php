<?php

/**
 * This is the model class for table "penyimpanansteril_t".
 *
 * The followings are the available columns in table 'penyimpanansteril_t':
 * @property integer $penyimpanansteril_id
 * @property string $penyimpanansteril_no
 * @property string $penyimpanansteril_tgl
 * @property string $penyimpanansteril_ket
 * @property integer $pegmengetahui_id
 * @property integer $pegpenyimpanan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PenyimpanansterilT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyimpanansterilT the static model class
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
		return 'penyimpanansteril_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penyimpanansteril_no, penyimpanansteril_tgl, pegpenyimpanan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegmengetahui_id, pegpenyimpanan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('penyimpanansteril_no', 'length', 'max'=>20),
			array('penyimpanansteril_ket, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyimpanansteril_id, penyimpanansteril_no, penyimpanansteril_tgl, penyimpanansteril_ket, pegmengetahui_id, pegpenyimpanan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegmengetahui'=>array(self::BELONGS_TO,'PegawaiM','pegmengetahui_id'),
			'pegpenyimpanan'=>array(self::BELONGS_TO,'PegawaiM','pegpenyimpanan_id'),
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penyimpanansteril_id' => 'Penyimpanan Steril',
			'penyimpanansteril_no' => 'No. Penyimpanan',
			'penyimpanansteril_tgl' => 'Tanggal Penyimpanan',
			'penyimpanansteril_ket' => 'Keterangan',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
			'pegpenyimpanan_id' => 'Pegawai Penyimpan',
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

		if(!empty($this->penyimpanansteril_id)){
			$criteria->addCondition('penyimpanansteril_id = '.$this->penyimpanansteril_id);
		}
		$criteria->compare('LOWER(penyimpanansteril_no)',strtolower($this->penyimpanansteril_no),true);
		$criteria->compare('LOWER(penyimpanansteril_tgl)',strtolower($this->penyimpanansteril_tgl),true);
		$criteria->compare('LOWER(penyimpanansteril_ket)',strtolower($this->penyimpanansteril_ket),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegpenyimpanan_id)){
			$criteria->addCondition('pegpenyimpanan_id = '.$this->pegpenyimpanan_id);
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