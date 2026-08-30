<?php

/**
 * This is the model class for table "periodeposting_m".
 *
 * The followings are the available columns in table 'periodeposting_m':
 * @property integer $periodeposting_id
 * @property integer $konfiganggaran_id
 * @property string $periodeposting_nama
 * @property string $tglperiodeposting_awal
 * @property string $tglperiodeposting_akhir
 * @property string $deskripsiperiodeposting
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property boolean $periodeposting_aktif
 * @property integer $rekperiode_id
 *
 * The followings are the available model relations:
 * @property BukubesarT[] $bukubesarTs
 * @property KonfiganggaranK $konfiganggaran
 * @property LoginpemakaiK $createLoginpemakai
 * @property LoginpemakaiK $updateLoginpemakai
 * @property RekperiodM $rekperiode
 * @property JurnalpostingT[] $jurnalpostingTs
 */
class PeriodepostingM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeriodepostingM the static model class
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
		return 'periodeposting_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('periodeposting_nama, tglperiodeposting_awal, tglperiodeposting_akhir, create_time, create_loginpemakai_id, create_ruangan, rekperiode_id', 'required'),
			array('konfiganggaran_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, rekperiode_id', 'numerical', 'integerOnly'=>true),
			array('periodeposting_nama', 'length', 'max'=>100),
			array('deskripsiperiodeposting', 'length', 'max'=>200),
			array('update_time, periodeposting_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('periodeposting_id, konfiganggaran_id, periodeposting_nama, tglperiodeposting_awal, tglperiodeposting_akhir, deskripsiperiodeposting, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, periodeposting_aktif, rekperiode_id', 'safe', 'on'=>'search'),
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
			'bukubesarTs' => array(self::HAS_MANY, 'BukubesarT', 'periodeposting_id'),
			'konfiganggaran' => array(self::BELONGS_TO, 'KonfiganggaranK', 'konfiganggaran_id'),
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
			'rekperiode' => array(self::BELONGS_TO, 'RekperiodM', 'rekperiode_id'),
			'jurnalpostingTs' => array(self::HAS_MANY, 'JurnalpostingT', 'periodeposting_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'periodeposting_id' => 'Periode Posting',
			'konfiganggaran_id' => 'Periode Anggaran',
			'periodeposting_nama' => 'Nama Periode',
			'tglperiodeposting_awal' => 'Tgl. Awal Periode Posting',
			'tglperiodeposting_akhir' => 'Tgl. Akhir Periode Posting',
			'deskripsiperiodeposting' => 'Deskripsi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'periodeposting_aktif' => 'Aktif',
			'rekperiode_id' => 'Periode Akuntansi',
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

		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
		$criteria->compare('LOWER(tglperiodeposting_awal)',strtolower($this->tglperiodeposting_awal),true);
		$criteria->compare('LOWER(tglperiodeposting_akhir)',strtolower($this->tglperiodeposting_akhir),true);
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
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
		$criteria->compare('periodeposting_aktif',$this->periodeposting_aktif);
		if(!empty($this->rekperiode_id)){
			$criteria->addCondition('rekperiode_id = '.$this->rekperiode_id);
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
		
		public static function items() {
			return CHtml::listData(
				self::model()->findAllByAttributes(array(
					'periodeposting_aktif'=>true,
				), array(
					'order'=>'periodeposting_id asc',
				)), 'periodeposting_id', 'periodeposting_nama'
			);
		}
}