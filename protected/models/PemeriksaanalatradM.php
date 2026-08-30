<?php

/**
 * This is the model class for table "pemeriksaanalatrad_m".
 *
 * The followings are the available columns in table 'pemeriksaanalatrad_m':
 * @property integer $pemeriksaanalatrad_id
 * @property integer $alatmedis_id
 * @property string $pemeriksaanalatrad_kode
 * @property string $pemeriksaanalatrad_nama
 * @property string $pemeriksaanalatrad_namalain
 * @property string $pemeriksaanalatrad_aetitle
 * @property boolean $pemeriksaanalatrad_aktif
 * @property string $rumusdosis_radiasi
 */
class PemeriksaanalatradM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanalatradM the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pemeriksaanalatrad_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanalatrad_kode, pemeriksaanalatrad_nama, pemeriksaanalatrad_aktif', 'required'),
			array('alatmedis_id', 'numerical', 'integerOnly' => true),
			array('pemeriksaanalatrad_kode', 'length', 'max' => 20),
			array('rumusdosis_radiasi, pemeriksaanalatrad_nama, pemeriksaanalatrad_namalain, pemeriksaanalatrad_aetitle', 'length', 'max' => 100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanalatrad_id, pemeriksaanalatrad_kode, pemeriksaanalatrad_nama, pemeriksaanalatrad_namalain, pemeriksaanalatrad_aetitle, pemeriksaanalatrad_aktif', 'safe', 'on' => 'search'),
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
			'alatmedis' => array(self::BELONGS_TO, 'AlatmedisM', 'alatmedis_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanalatrad_id' => 'ID',
			'alatmedis_id' => 'Alat Medis',
			'pemeriksaanalatrad_kode' => 'Kode',
			'pemeriksaanalatrad_nama' => 'Nama Pemeriksaan',
			'pemeriksaanalatrad_namalain' => 'Nama Lain',
			'pemeriksaanalatrad_aetitle' => 'Title',
			'pemeriksaanalatrad_aktif' => 'Aktif',
			'alatmedis_nama' => 'Nama Alat Medis',
			'rumusdosis_radiasi' => 'Rumus Dosis Radiasi',
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

		$criteria = new CDbCriteria;

		if (!empty($this->pemeriksaanalatrad_id)) {
			$criteria->addCondition('pemeriksaanalatrad_id = ' . $this->pemeriksaanalatrad_id);
		}
		if (!empty($this->alatmedis_id)) {
			$criteria->addCondition('alatmedis_id = ' . $this->alatmedis_id);
		}
		//$criteria->compare('LOWER(alatmedis.alatmedis_nama)',strtolower($this->alatmedis_nama),true); 
		$criteria->compare('LOWER(pemeriksaanalatrad_kode)', strtolower($this->pemeriksaanalatrad_kode), true);
		$criteria->compare('LOWER(pemeriksaanalatrad_nama)', strtolower($this->pemeriksaanalatrad_nama), true);
		$criteria->compare('LOWER(pemeriksaanalatrad_namalain)', strtolower($this->pemeriksaanalatrad_namalain), true);
		$criteria->compare('LOWER(pemeriksaanalatrad_aetitle)', strtolower($this->pemeriksaanalatrad_aetitle), true);
		$criteria->compare('pemeriksaanalatrad_aktif', $this->pemeriksaanalatrad_aktif);

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

		$criteria = $this->criteriaSearch();
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}


	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
}
