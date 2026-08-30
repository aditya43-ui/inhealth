<?php

/**
 * This is the model class for table "uraianpenumum_t".
 *
 * The followings are the available columns in table 'uraianpenumum_t':
 * @property integer $uraianpenumum_id
 * @property integer $penerimaanumum_id
 * @property string $uraiantransaksi
 * @property double $volume
 * @property string $satuanvol
 * @property double $hargasatuan
 * @property double $totalharga
 */
class UraianpenumumT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UraianpenumumT the static model class
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
		return 'uraianpenumum_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penerimaanumum_id, uraiantransaksi, volume, satuanvol, hargasatuan, totalharga', 'required'),
			array('penerimaanumum_id', 'numerical', 'integerOnly'=>true),
			array('volume, hargasatuan, totalharga', 'numerical'),
			array('uraiantransaksi', 'length', 'max'=>100),
			array('satuanvol', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uraianpenumum_id, penerimaanumum_id, uraiantransaksi, volume, satuanvol, hargasatuan, totalharga', 'safe', 'on'=>'search'),
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
                    'peneluaran'=>array(self::BELONGS_TO, 'PengeluaranumumT', 'pengeluaranumum_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uraianpenumum_id' => 'Uraianpenumum',
			'penerimaanumum_id' => 'Penerimaanumum',
			'uraiantransaksi' => 'Uraiantransaksi',
			'volume' => 'Volume',
			'satuanvol' => 'Satuanvol',
			'hargasatuan' => 'Hargasatuan',
			'totalharga' => 'Totalharga',
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

		$criteria->compare('uraianpenumum_id',$this->uraianpenumum_id);
		$criteria->compare('penerimaanumum_id',$this->penerimaanumum_id);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('LOWER(satuanvol)',strtolower($this->satuanvol),true);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('totalharga',$this->totalharga);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('uraianpenumum_id',$this->uraianpenumum_id);
		$criteria->compare('penerimaanumum_id',$this->penerimaanumum_id);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('LOWER(satuanvol)',strtolower($this->satuanvol),true);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('totalharga',$this->totalharga);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}