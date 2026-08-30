<?php

/**
 * This is the model class for table "pelayananrek_m".
 *
 * The followings are the available columns in table 'pelayananrek_m':
 * @property integer $pelayananrek_id
 * @property integer $rekening4_id
 * @property integer $rekening5_id
 * @property integer $ruangan_id
 * @property integer $rekening3_id
 * @property integer $rekening1_id
 * @property integer $daftartindakan_id
 * @property integer $rekening2_id
 * @property string $saldonormal
 * @property string $jnspelayanan
 * @property integer $komponentarif_id
 *
 * The followings are the available model relations:
 * @property DaftartindakanM $daftartindakan
 * @property Rekening1M $rekening1
 * @property Rekening2M $rekening2
 * @property Rekening3M $rekening3
 * @property Rekening4M $rekening4
 * @property Rekening5M $rekening5
 * @property RuanganM $ruangan
 */
class SAPelayananrekM extends PelayananrekM {

	public $instalasi_id, $instalasi_nama, $ruangan_nama, $kelompoktindakan_nama, $kategoritindakan_nama, $daftartindakan_kode, $daftartindakan_nama, $rekening5_id_d, $nmrekening5_d, $rekening5_id_k, $nmrekening5_k;
	public $nmrekening5, $komponentarif_nama;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PelayananrekM the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'pelayananrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartindakan_id, jnspelayanan, komponentarif_id', 'required'),
			array('rekening5_id, ruangan_id, daftartindakan_id, komponentarif_id', 'numerical', 'integerOnly' => true),
			array('jnspelayanan', 'length', 'max' => 20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pelayananrek_id, rekening5_id, ruangan_id, daftartindakan_id, jnspelayanan, komponentarif_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'komponentarif' => array(self::BELONGS_TO, 'KomponentarifM', 'komponentarif_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'pelayananrek_id' => 'Pelayananrek',
			'rekening5_id' => 'Rekening5',
			'ruangan_id' => 'Ruangan',
			'daftartindakan_id' => 'Daftar Tindakan',
			'jnspelayanan' => 'Jenis Pelayanan',
			'komponentarif_id' => 'Komponentarif',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		if (!empty($this->pelayananrek_id)) {
			$criteria->addCondition('pelayananrek_id = ' . $this->pelayananrek_id);
		}

		if (!empty($this->rekening5_id)) {
			$criteria->addCondition('rekening5_id = ' . $this->rekening5_id);
		}
		if (!empty($this->ruangan_id)) {
			$criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
		}

		if (!empty($this->daftartindakan_id)) {
			$criteria->addCondition('daftartindakan_id = ' . $this->daftartindakan_id);
		}

		$criteria->compare('LOWER(jnspelayanan)', strtolower($this->jnspelayanan), true);
		if (!empty($this->komponentarif_id)) {
			$criteria->addCondition('komponentarif_id = ' . $this->komponentarif_id);
		}

		return $criteria;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = $this->criteriaSearch();
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,                        
		));
	}

	public function searchPrint() {
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
