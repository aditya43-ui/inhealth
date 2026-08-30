<?php

/**
 * This is the model class for table "ukurankacamata_t".
 *
 * The followings are the available columns in table 'ukurankacamata_t':
 * @property integer $ukurankacamata_id
 * @property integer $periksakacamata_id
 * @property string $jenis_ukuran
 * @property string $vitrum_spher_right
 * @property string $vitrum_cylindr_right
 * @property string $axis_right
 * @property string $prisma_basis_right
 * @property string $vitrum_spher_left
 * @property string $vitrum_cylindr_left
 * @property string $axis_left
 * @property string $prisma_basis_left
 * @property string $forma_vitror
 * @property string $color_vitror
 * @property string $distant_vitror
 * @property string $forma_jugi
 */
class UkurankacamataT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UkurankacamataT the static model class
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
		return 'ukurankacamata_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('periksakacamata_id, jenis_ukuran', 'required'),
			array('periksakacamata_id', 'numerical', 'integerOnly'=>true),
			array('jenis_ukuran', 'length', 'max'=>50),
			array('vitrum_spher_right, vitrum_cylindr_right, axis_right, prisma_basis_right, vitrum_spher_left, vitrum_cylindr_left, axis_left, prisma_basis_left, forma_vitror, color_vitror, distant_vitror, forma_jugi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ukurankacamata_id, periksakacamata_id, jenis_ukuran, vitrum_spher_right, vitrum_cylindr_right, axis_right, prisma_basis_right, vitrum_spher_left, vitrum_cylindr_left, axis_left, prisma_basis_left, forma_vitror, color_vitror, distant_vitror, forma_jugi', 'safe', 'on'=>'search'),
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
			'ukurankacamata_id' => 'Ukurankacamata',
			'periksakacamata_id' => 'Periksakacamata',
			'jenis_ukuran' => 'Jenis Ukuran',
			'vitrum_spher_right' => 'Vitrum Spher Right',
			'vitrum_cylindr_right' => 'Vitrum Cylindr Right',
			'axis_right' => 'Axis Right',
			'prisma_basis_right' => 'Prisma Basis Right',
			'vitrum_spher_left' => 'Vitrum Spher Left',
			'vitrum_cylindr_left' => 'Vitrum Cylindr Left',
			'axis_left' => 'Axis Left',
			'prisma_basis_left' => 'Prisma Basis Left',
			'forma_vitror' => 'Forma Vitror',
			'color_vitror' => 'Color Vitror',
			'distant_vitror' => 'Distant Vitror',
			'forma_jugi' => 'Forma Jugi',
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

		if(!empty($this->ukurankacamata_id)){
			$criteria->addCondition('ukurankacamata_id = '.$this->ukurankacamata_id);
		}
		if(!empty($this->periksakacamata_id)){
			$criteria->addCondition('periksakacamata_id = '.$this->periksakacamata_id);
		}
		$criteria->compare('LOWER(jenis_ukuran)',strtolower($this->jenis_ukuran),true);
		$criteria->compare('LOWER(vitrum_spher_right)',strtolower($this->vitrum_spher_right),true);
		$criteria->compare('LOWER(vitrum_cylindr_right)',strtolower($this->vitrum_cylindr_right),true);
		$criteria->compare('LOWER(axis_right)',strtolower($this->axis_right),true);
		$criteria->compare('LOWER(prisma_basis_right)',strtolower($this->prisma_basis_right),true);
		$criteria->compare('LOWER(vitrum_spher_left)',strtolower($this->vitrum_spher_left),true);
		$criteria->compare('LOWER(vitrum_cylindr_left)',strtolower($this->vitrum_cylindr_left),true);
		$criteria->compare('LOWER(axis_left)',strtolower($this->axis_left),true);
		$criteria->compare('LOWER(prisma_basis_left)',strtolower($this->prisma_basis_left),true);
		$criteria->compare('LOWER(forma_vitror)',strtolower($this->forma_vitror),true);
		$criteria->compare('LOWER(color_vitror)',strtolower($this->color_vitror),true);
		$criteria->compare('LOWER(distant_vitror)',strtolower($this->distant_vitror),true);
		$criteria->compare('LOWER(forma_jugi)',strtolower($this->forma_jugi),true);

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