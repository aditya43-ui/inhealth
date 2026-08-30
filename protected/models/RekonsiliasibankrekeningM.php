<?php

/**
 * This is the model class for table "rekonsiliasibankrekening_m".
 *
 * The followings are the available columns in table 'rekonsiliasibankrekening_m':
 * @property integer $rekonsiliasibankrekening_id
 * @property integer $kelrekening_id
 * @property integer $rekening3_id
 * @property integer $rekening4_id
 * @property integer $rekening5_id
 * @property string $saldonormal
 * @property integer $jenisrekonsiliasibank_id
 *
 * The followings are the available model relations:
 * @property KelrekeningM $kelrekening
 * @property Rekening1M $rekening1
 * @property Rekening2M $rekening2
 * @property Rekening3M $rekening3
 * @property Rekening4M $rekening4
 * @property Rekening5M $rekening5
 * @property JenisrekonsiliasibankM $jenisrekonsiliasibank
 */
class RekonsiliasibankrekeningM extends CActiveRecord {
	
	public $rekening5_nb;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekonsiliasibankrekeningM the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'rekonsiliasibankrekening_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisrekonsiliasibank_id', 'required'),
			array('rekening5_id, jenisrekonsiliasibank_id', 'numerical', 'integerOnly' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekonsiliasibankrekening_id, rekening5_id, jenisrekonsiliasibank_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'rekeningdebit' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
			'rekeningkredit' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
			'jenisrekonsiliasibank' => array(self::BELONGS_TO, 'JenisrekonsiliasibankM', 'jenisrekonsiliasibank_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'rekonsiliasibankrekening_id' => 'ID Rekonsiliasi Bank Rekening',
			'rekening5_id' => 'Nama Rek. 5',
			'jenisrekonsiliasibank_id' => 'Jenis Rekonsiliasi Bank',
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

		if (!empty($this->rekonsiliasibankrekening_id)) {
			$criteria->addCondition('rekonsiliasibankrekening_id = ' . $this->rekonsiliasibankrekening_id);
		}
		if (!empty($this->rekening5_id)) {
			$criteria->addCondition('rekening5_id = ' . $this->rekening5_id);
		}
		if (!empty($this->jenisrekonsiliasibank_id)) {
			$criteria->addCondition('jenisrekonsiliasibank_id = ' . $this->jenisrekonsiliasibank_id);
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
