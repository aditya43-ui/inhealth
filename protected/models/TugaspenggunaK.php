<?php

/**
 * This is the model class for table "tugaspengguna_k".
 *
 * The followings are the available columns in table 'tugaspengguna_k':
 * @property integer $tugaspengguna_id
 * @property integer $peranpengguna_id
 * @property string $tugas_nama
 * @property string $tugas_namalainnya
 * @property string $controller_nama
 * @property string $action_nama
 * @property string $keterangan_tugas
 * @property boolean $tugaspengguna_aktif
 * @property integer $modul_id
 *
 * The followings are the available model relations:
 * @property ModulK $modul
 */
class TugaspenggunaK extends CActiveRecord
{	
        public $modul_nama;
			
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TugaspenggunaK the static model class
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
		return 'tugaspengguna_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tugas_nama, controller_nama, action_nama', 'required'),
			array('peranpengguna_id, modul_id', 'numerical', 'integerOnly'=>true),
			array('tugas_nama, tugas_namalainnya', 'length', 'max'=>200),
			array('controller_nama, action_nama', 'length', 'max'=>100),
			array('keterangan_tugas, tugaspengguna_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tugaspengguna_id, peranpengguna_id, tugas_nama, tugas_namalainnya, controller_nama, action_nama, keterangan_tugas, tugaspengguna_aktif, modul_id', 'safe', 'on'=>'search'),
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
			'modul' => array(self::BELONGS_TO, 'ModulK', 'modul_id'),
			'peranpengguna' => array(self::BELONGS_TO, 'PeranpenggunaK', 'peranpengguna_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tugaspengguna_id' => 'ID ',
			'peranpengguna_id' => 'Peran Pengguna',
			'tugas_nama' => 'Nama Tugas',
			'tugas_namalainnya' => 'Nama Lainnya',
			'controller_nama' => 'Nama Controller',
			'action_nama' => 'Nama Action',
			'keterangan_tugas' => 'Keterangan Tugas',
			'tugaspengguna_aktif' => 'Aktif',
			'modul_id' => 'Modul',
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

		$criteria->compare('tugaspengguna_id',$this->tugaspengguna_id);
		$criteria->compare('peranpengguna_id',$this->peranpengguna_id);
		$criteria->compare('LOWER(tugas_nama)',strtolower($this->tugas_nama),true);
		$criteria->compare('LOWER(tugas_namalainnya)',strtolower($this->tugas_namalainnya),true);
		$criteria->compare('LOWER(controller_nama)',strtolower($this->controller_nama),true);
		$criteria->compare('LOWER(action_nama)',strtolower($this->action_nama),true);
		$criteria->compare('LOWER(keterangan_tugas)',strtolower($this->keterangan_tugas),true);
		$criteria->compare('tugaspengguna_aktif',$this->tugaspengguna_aktif);
		$criteria->compare('modul_id',$this->modul_id);
		if (!Params::cekAkses(Yii::app()->user->getState('peranpengguna_id'))){				
			$criteria->addNotInCondition("peranpengguna_id", Params::getAllVendor());
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
        
        public function getNamaModul()
        {
            return ModulK::model()->findAll('modul_aktif=TRUE ORDER BY modul_nama');
        }
        
}