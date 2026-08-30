<?php

/**
 * This is the model class for table "obatalkeskomponen_t".
 *
 * The followings are the available columns in table 'obatalkeskomponen_t':
 * @property integer $obatalkeskomponen_id
 * @property integer $obatalkespasien_id
 * @property integer $komponentarif_id
 * @property double $hargasatuankomponen
 * @property double $harganettokomponen
 * @property double $hargajualkomponen
 * @property double $tarifcytokomponen
 * @property double $subsidiasuransi
 * @property double $subsidipemerintah
 * @property double $subsidirs
 * @property double $iurbiaya
 */
class ObatalkeskomponenT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkeskomponenT the static model class
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
		return 'obatalkeskomponen_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkespasien_id, komponentarif_id, hargasatuankomponen, harganettokomponen, hargajualkomponen, tarifcytokomponen, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya', 'required'),
			array('obatalkespasien_id, komponentarif_id', 'numerical', 'integerOnly'=>true),
			array('hargasatuankomponen, harganettokomponen, hargajualkomponen, tarifcytokomponen, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatalkeskomponen_id, obatalkespasien_id, komponentarif_id, hargasatuankomponen, harganettokomponen, hargajualkomponen, tarifcytokomponen, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya', 'safe', 'on'=>'search'),
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
			'komponentarif'=>array(self::BELONGS_TO, 'KomponentarifM','komponentarif_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatalkeskomponen_id' => 'Obatalkeskomponen',
			'obatalkespasien_id' => 'Obatalkespasien',
			'komponentarif_id' => 'Komponentarif',
			'hargasatuankomponen' => 'Hargasatuankomponen',
			'harganettokomponen' => 'Harganettokomponen',
			'hargajualkomponen' => 'Hargajualkomponen',
			'tarifcytokomponen' => 'Tarifcytokomponen',
			'subsidiasuransi' => 'Subsidiasuransi',
			'subsidipemerintah' => 'Subsidipemerintah',
			'subsidirs' => 'Subsidirs',
			'iurbiaya' => 'Iurbiaya',
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

		$criteria->compare('obatalkeskomponen_id',$this->obatalkeskomponen_id);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('hargasatuankomponen',$this->hargasatuankomponen);
		$criteria->compare('harganettokomponen',$this->harganettokomponen);
		$criteria->compare('hargajualkomponen',$this->hargajualkomponen);
		$criteria->compare('tarifcytokomponen',$this->tarifcytokomponen);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('subsidirs',$this->subsidirs);
		$criteria->compare('iurbiaya',$this->iurbiaya);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('obatalkeskomponen_id',$this->obatalkeskomponen_id);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('hargasatuankomponen',$this->hargasatuankomponen);
		$criteria->compare('harganettokomponen',$this->harganettokomponen);
		$criteria->compare('hargajualkomponen',$this->hargajualkomponen);
		$criteria->compare('tarifcytokomponen',$this->tarifcytokomponen);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('subsidirs',$this->subsidirs);
		$criteria->compare('iurbiaya',$this->iurbiaya);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}