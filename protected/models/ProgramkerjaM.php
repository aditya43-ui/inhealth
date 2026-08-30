<?php

/**
 * This is the model class for table "programkerja_m".
 *
 * The followings are the available columns in table 'programkerja_m':
 * @property integer $programkerja_id
 * @property string $programkerja_kode
 * @property string $programkerja_nama
 * @property string $programkerja_namalain
 * @property string $programkerja_ket
 * @property integer $programkerja_nourut
 * @property boolean $programkerja_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class ProgramkerjaM extends CActiveRecord
{
        public $default;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProgramkerjaM the static model class
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
		return 'programkerja_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('programkerja_kode, programkerja_nama, programkerja_namalain, programkerja_nourut, create_time, create_loginpemakai_id, create_ruangan', 'required'),
                array('programkerja_nourut, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
                array('programkerja_kode', 'length', 'max'=>5),
                array('programkerja_nama, programkerja_namalain', 'length', 'max'=>500),
                array('sumberbiaya', 'length', 'max'=>255),
                array('programkerja_ket, programkerja_aktif, update_time', 'safe'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('programkerja_id, programkerja_kode, programkerja_nama, programkerja_namalain, programkerja_ket, programkerja_nourut, programkerja_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, sumberbiaya', 'safe', 'on'=>'search'),
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
			'programkerja_id' => 'ID Program Kerja',
			'programkerja_kode' => 'Kode',
			'programkerja_nama' => 'Nama Program',
			'programkerja_namalain' => ' Nama Lain',
			'programkerja_ket' => 'Keterangan',
			'programkerja_nourut' => 'Nourut',
			'programkerja_aktif' => 'Aktif',
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

		if(!empty($this->programkerja_id)){
			$criteria->addCondition('programkerja_id = '.$this->programkerja_id);
		}
		$criteria->compare('LOWER(programkerja_kode)',strtolower($this->programkerja_kode),true);
		$criteria->compare('LOWER(programkerja_nama)',strtolower($this->programkerja_nama),true);
		$criteria->compare('LOWER(programkerja_namalain)',strtolower($this->programkerja_namalain),true);
		$criteria->compare('LOWER(programkerja_ket)',strtolower($this->programkerja_ket),true);
		if(!empty($this->programkerja_nourut)){
			$criteria->addCondition('programkerja_nourut = '.$this->programkerja_nourut);
		}
		$criteria->compare('programkerja_aktif',$this->programkerja_aktif);
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
            if (!empty($this->default)){
                $criteria->addCondition(" programkerja_id is NULL ");
            }
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