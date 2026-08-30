<?php

/**
 * This is the model class for table "uraiankeluarumum_t".
 *
 * The followings are the available columns in table 'uraiankeluarumum_t':
 * @property integer $uraiankeluarumum_id
 * @property integer $pengeluaranumum_id
 * @property string $uraiantransaksi
 * @property double $volume
 * @property string $satuanvol
 * @property double $hargasatuan
 * @property double $totalharga
 */
class UraiankeluarumumT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UraiankeluarumumT the static model class
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
		return 'uraiankeluarumum_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengeluaranumum_id, uraiantransaksi, volume, satuanvol, hargasatuan, totalharga', 'required'),
			array('pengeluaranumum_id, pesangonpeg_id, pembayaranjasa_id', 'numerical', 'integerOnly'=>true),
			array('volume, hargasatuan, totalharga', 'numerical'),
			array('uraiantransaksi', 'length', 'max'=>100),
			array('satuanvol', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uraiankeluarumum_id, pengeluaranumum_id, uraiantransaksi, volume, satuanvol, hargasatuan, totalharga, pesangonpeg_id, pembayaranjasa_id', 'safe', 'on'=>'search'),
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
			'uraiankeluarumum_id' => 'Uraiankeluarumum',
			'pengeluaranumum_id' => 'Pengeluaranumum',
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

		$criteria->compare('uraiankeluarumum_id',$this->uraiankeluarumum_id);
		$criteria->compare('pengeluaranumum_id',$this->pengeluaranumum_id);
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
		$criteria->compare('uraiankeluarumum_id',$this->uraiankeluarumum_id);
		$criteria->compare('pengeluaranumum_id',$this->pengeluaranumum_id);
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