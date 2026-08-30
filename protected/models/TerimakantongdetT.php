<?php
/**
 * This is the model class for table "terimakantongdet_t".
 *
 * The followings are the available columns in table 'terimakantongdet_t':  
 * 
 * @package models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
 * @property integer $terimakantongdet_id
 * @property integer $terimakantongdarah_id
 * @property string $nobarcodekantong
 * @property integer $jeniskantongdarah_id
 * @property integer $komponendarah_id
 * @property integer $jmlterima
 *
 * The followings are the available model relations:
 * @property TerimakantongdarahT $terimakantongdarah
 */
class TerimakantongdetT extends CActiveRecord
{
        public $jeniskantongdarah_nama;
        public $jenisterima_nama;
        public $nobarcode_sample;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimakantongdetT the static model class
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
		return 'terimakantongdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('terimakantongdarah_id, jeniskantongdarah_id, komponendarah_id, jmlterima', 'required'),
			array('terimakantongdarah_id, jeniskantongdarah_id, komponendarah_id, jmlterima', 'numerical', 'integerOnly'=>true),
			array('nobarcodekantong', 'length', 'max'=>255),
                        array('kantongdarah_id','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('terimakantongdet_id, terimakantongdarah_id, nobarcodekantong, jeniskantongdarah_id, komponendarah_id, jmlterima', 'safe', 'on'=>'search'),
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
			'terimakantongdarah' => array(self::BELONGS_TO, 'TerimakantongdarahT', 'terimakantongdarah_id'),
                        'jeniskantongdarah' => array(self::BELONGS_TO, 'JeniskantongdarahM', 'jeniskantongdarah_id'), 
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'terimakantongdet_id' => 'Terimakantongdet',
			'terimakantongdarah_id' => 'Terimakantongdarah',
			'nobarcodekantong' => 'No. Barcode Kantong',
			'jeniskantongdarah_id' => 'Jenis Kantong Darah',                        
			'komponendarah_id' => 'Komponendarah',
			'jmlterima' => 'Jmlterima',
                        //tambahan attribute agar generate otomatis namanya
                        'jeniskantongdarah_nama' => 'Jenis Kantong Darah',
                        'jenisterima_nama'=>'Jenis Kantong Darah',
                        'nobarcode_sample' => 'No. Barcode Sample'
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

		if(!empty($this->terimakantongdet_id)){
			$criteria->addCondition('terimakantongdet_id = '.$this->terimakantongdet_id);
		}
		if(!empty($this->terimakantongdarah_id)){
			$criteria->addCondition('terimakantongdarah_id = '.$this->terimakantongdarah_id);
		}
		$criteria->compare('LOWER(nobarcodekantong)',strtolower($this->nobarcodekantong),true);
		if(!empty($this->jeniskantongdarah_id)){
			$criteria->addCondition('jeniskantongdarah_id = '.$this->jeniskantongdarah_id);
		}
		if(!empty($this->komponendarah_id)){
			$criteria->addCondition('komponendarah_id = '.$this->komponendarah_id);
		}
		if(!empty($this->jmlterima)){
			$criteria->addCondition('jmlterima = '.$this->jmlterima);
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


        /**
         * fungsi untuk mencetak prinout
         * @return \CActiveDataProvider
         */
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