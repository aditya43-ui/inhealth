<?php

/**
 * This is the model class for table "kondisipasienanestesi_t".
 *
 * The followings are the available columns in table 'kondisipasienanestesi_t':
 * @property integer $kondisipasienanestesi_id
 * @property integer $intraanestesi_id
 * @property integer $pascaanestesi_id
 * @property string $tglpemantauan
 * @property string $jammulai
 * @property string $jamselesai
 * @property integer $menitke
 * @property double $oksigen_liter
 * @property double $ventilasi_mmhg
 * @property string $sirkulasi
 * @property string $suhu
 * @property string $perfusijaringan
 *
 * The followings are the available model relations:
 * @property IntraanestesiT $intraanestesi
 * @property PascaanestesiT $pascaanestesi
 */
class KondisipasienanestesiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KondisipasienanestesiT the static model class
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
		return 'kondisipasienanestesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpemantauan, jammulai, jamselesai, menitke', 'required'),
			array('intraanestesi_id, pascaanestesi_id, menitke', 'numerical', 'integerOnly'=>true),
			array('oksigen_liter, ventilasi_mmhg', 'numerical'),
			array('sirkulasi, perfusijaringan', 'length', 'max'=>20),
			array('suhu', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kondisipasienanestesi_id, intraanestesi_id, pascaanestesi_id, tglpemantauan, jammulai, jamselesai, menitke, oksigen_liter, ventilasi_mmhg, sirkulasi, suhu, perfusijaringan', 'safe', 'on'=>'search'),
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
			'intraanestesi' => array(self::BELONGS_TO, 'IntraanestesiT', 'intraanestesi_id'),
			'pascaanestesi' => array(self::BELONGS_TO, 'PascaanestesiT', 'pascaanestesi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kondisipasienanestesi_id' => 'Kondisi Pasien Anestesia',
			'intraanestesi_id' => 'Intra Anestesia',
			'pascaanestesi_id' => 'Pasca Anestesia',
			'tglpemantauan' => 'Tanggal Pemantauan',
			'jammulai' => 'Jam Mulai',
			'jamselesai' => 'Jam Selesai',
			'menitke' => 'Menit Ke-',
			'oksigen_liter' => 'Oksigen Liter',
			'ventilasi_mmhg' => 'Ventilasi /MmHg',
			'sirkulasi' => 'Sirkulasi',
			'suhu' => 'Suhu',
			'perfusijaringan' => 'Perfusi Jaringan',
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

		if(!empty($this->kondisipasienanestesi_id)){
			$criteria->addCondition('kondisipasienanestesi_id = '.$this->kondisipasienanestesi_id);
		}
		if(!empty($this->intraanestesi_id)){
			$criteria->addCondition('intraanestesi_id = '.$this->intraanestesi_id);
		}
		if(!empty($this->pascaanestesi_id)){
			$criteria->addCondition('pascaanestesi_id = '.$this->pascaanestesi_id);
		}
		$criteria->compare('LOWER(tglpemantauan)',strtolower($this->tglpemantauan),true);
		$criteria->compare('LOWER(jammulai)',strtolower($this->jammulai),true);
		$criteria->compare('LOWER(jamselesai)',strtolower($this->jamselesai),true);
		if(!empty($this->menitke)){
			$criteria->addCondition('menitke = '.$this->menitke);
		}
		$criteria->compare('oksigen_liter',$this->oksigen_liter);
		$criteria->compare('ventilasi_mmhg',$this->ventilasi_mmhg);
		$criteria->compare('LOWER(sirkulasi)',strtolower($this->sirkulasi),true);
		$criteria->compare('LOWER(suhu)',strtolower($this->suhu),true);
		$criteria->compare('LOWER(perfusijaringan)',strtolower($this->perfusijaringan),true);

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