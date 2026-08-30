<?php

/**
 * This is the model class for table "kelrekening_m".
 *
 * The followings are the available columns in table 'kelrekening_m':
 * @property integer $kelrekening_id
 * @property string $koderekeningkel
 * @property string $namakelrekening
 * @property boolean $kelrekening_aktif
 *
 * The followings are the available model relations:
 * @property Rekening1M[] $rekening1Ms
 */
class KelrekeningM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelrekeningM the static model class
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
		return 'kelrekening_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('koderekeningkel, namakelrekening', 'required'),
			array('levelterakhir', 'numerical', 'integerOnly'=>true),
			array('koderekeningkel', 'length', 'max'=>50),
			array('namakelrekening', 'length', 'max'=>100),
			array('saldonormal', 'length', 'max'=>1),
			array('kelrekening_aktif, isaset, iskewajiban, ismodal, ispendapatan, ishpp, isbebanusaha, ispendapatanluar, isbebanluar', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelrekening_id, koderekeningkel, namakelrekening, kelrekening_aktif, isaset, iskewajiban, ismodal, ispendapatan, ishpp, isbebanusaha, ispendapatanluar, isbebanluar', 'safe', 'on'=>'search'),
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
			'rekening1Ms' => array(self::HAS_MANY, 'Rekening1M', 'kelrekening_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kelrekening_id' => 'ID',
			'koderekeningkel' => 'Kode Kel. Rekening',
			'namakelrekening' => 'Nama Kelompok Rekening',
			'kelrekening_aktif' => 'Kel. Rekening Aktif',
			'levelterakhir' => 'Level Maks Kelompok Rekening',
			'saldonormal'=>'Saldo Normal'
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

		if(!empty($this->kelrekening_id)){
			$criteria->addCondition('kelrekening_id = '.$this->kelrekening_id);
		}
		$criteria->compare('LOWER(koderekeningkel)',strtolower($this->koderekeningkel),true);
		$criteria->compare('LOWER(namakelrekening)',strtolower($this->namakelrekening),true);
		$criteria->compare('kelrekening_aktif',$this->kelrekening_aktif);

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