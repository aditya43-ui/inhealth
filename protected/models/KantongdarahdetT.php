<?php

/**
 * @author   Deni Hamdani <denihamdani@piindonesia.co.id>
 * @version  2.0.0
 * 
 * This is the model class for table "kantongdarahdet_t".
 *
 * The followings are the available columns in table 'kantongdarahdet_t':
 * @property integer $kantongdarahdet_id
 * @property integer $kantongdarah_id
 * @property integer $jeniskantongdarah_id
 * @property integer $komponendarah_id
 * @property string $nomorbarcode
 * @property integer $jmlprint_barcode
 *
 * The followings are the available model relations:
 * @property KantongdarahT $kantongdarah
 * @property JeniskantongdarahM $jeniskantongdarah
 * @property KomponendarahM $komponendarah
 */
class KantongdarahdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KantongdarahdetT the static model class
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
		return 'kantongdarahdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kantongdarah_id, jeniskantongdarah_id, komponendarah_id, nomorbarcode, jmlprint_barcode', 'required'),
			array('kantongdarah_id, jeniskantongdarah_id, komponendarah_id, jmlprint_barcode', 'numerical', 'integerOnly'=>true),
			array('nomorbarcode', 'length', 'max'=>100),
                        array('nomorbarcode_utama, nomorbarcode_sample','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kantongdarahdet_id, kantongdarah_id, jeniskantongdarah_id, komponendarah_id, nomorbarcode, jmlprint_barcode', 'safe', 'on'=>'search'),
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
			'kantongdarah' => array(self::BELONGS_TO, 'KantongdarahT', 'kantongdarah_id'),
			'jeniskantongdarah' => array(self::BELONGS_TO, 'JeniskantongdarahM', 'jeniskantongdarah_id'),
			'komponendarah' => array(self::BELONGS_TO, 'KomponendarahM', 'komponendarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kantongdarahdet_id' => 'Kantongdarahdet',
			'kantongdarah_id' => 'Kantongdarah',
			'jeniskantongdarah_id' => 'Jeniskantongdarah',
			'komponendarah_id' => 'Komponendarah',
			'nomorbarcode' => 'Nomorbarcode',
			'jmlprint_barcode' => 'Jmlprint Barcode',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kantongdarahdet_id',$this->kantongdarahdet_id);
		$criteria->compare('kantongdarah_id',$this->kantongdarah_id);
		$criteria->compare('jeniskantongdarah_id',$this->jeniskantongdarah_id);
		$criteria->compare('komponendarah_id',$this->komponendarah_id);
		$criteria->compare('nomorbarcode',$this->nomorbarcode,true);
		$criteria->compare('jmlprint_barcode',$this->jmlprint_barcode);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
}