<?php

/**
 * This is the model class for table "penggajiankomp_t".
 *
 * The followings are the available columns in table 'penggajiankomp_t':
 * @property integer $penggajiankomp_id
 * @property integer $komponengaji_id
 * @property integer $penggajianpeg_id
 * @property double $jumlah
 */
class PenggajiankompT extends CActiveRecord
{
    public $ispotongan;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenggajiankompT the static model class
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
		return 'penggajiankomp_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('komponengaji_id, penggajianpeg_id, jumlah', 'required'),
			array('komponengaji_id, penggajianpeg_id', 'numerical', 'integerOnly'=>true),
			array('jumlah', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penggajiankomp_id, komponengaji_id, penggajianpeg_id, jumlah', 'safe', 'on'=>'search'),
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
			 'komponen'=>array(self::BELONGS_TO, 'KomponengajiM','komponengaji_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penggajiankomp_id' => 'Penggajian Komp',
			'komponengaji_id' => 'Komponen Gaji',
			'penggajianpeg_id' => 'Penggajian Peg',
			'jumlah' => 'Jumlah',
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

		$criteria->compare('penggajiankomp_id',$this->penggajiankomp_id);
		$criteria->compare('komponengaji_id',$this->komponengaji_id);
		$criteria->compare('penggajianpeg_id',$this->penggajianpeg_id);
		$criteria->compare('jumlah',$this->jumlah);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('penggajiankomp_id',$this->penggajiankomp_id);
		$criteria->compare('komponengaji_id',$this->komponengaji_id);
		$criteria->compare('penggajianpeg_id',$this->penggajianpeg_id);
		$criteria->compare('jumlah',$this->jumlah);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function setNilaiBonus() {
            return array(
                '0'=>'0',
                '1'=>'1',
                '2'=>'2',
                '3'=>'3',
                '4'=>'4',
                '5'=>'5',
                '6'=>'6',
                '7'=>'7',
                '8'=>'8',
                '9'=>'9',
            );
        }
}