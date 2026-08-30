<?php

/**
 * This is the model class for table "obatalkesdetail_m".
 *
 * The followings are the available columns in table 'obatalkesdetail_m':
 * @property integer $obatalkesdetail_id
 * @property integer $obatalkes_id
 * @property string $indikasi
 * @property string $kontraindikasi
 * @property string $komposisi
 * @property string $efeksamping
 * @property string $interaksiobat
 * @property string $carapenyimpanan
 * @property string $peringatan
 */
class ObatalkesdetailM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesdetailM the static model class
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
		return 'obatalkesdetail_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id', 'required'),
			array('obatalkes_id', 'numerical', 'integerOnly'=>true),
			array('indikasi, kontraindikasi, komposisi, efeksamping, interaksiobat, carapenyimpanan, peringatan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatalkesdetail_id, obatalkes_id, indikasi, kontraindikasi, komposisi, efeksamping, interaksiobat, carapenyimpanan, peringatan', 'safe', 'on'=>'search'),
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
                    'obatalkes'=>array(self::BELONGS_TO, 'ObatalkesM','obatalkes_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatalkesdetail_id' => 'Obat Alkes Detail ID',
			'obatalkes_id' => 'Obat Alkes ID',
			'indikasi' => 'Indikasi',
			'kontraindikasi' => 'Kontra Indikasi',
			'komposisi' => 'Komposisi',
			'efeksamping' => 'Efek Samping',
			'interaksiobat' => 'Interaksi Obat',
			'carapenyimpanan' => 'Cara Penyimpanan',
			'peringatan' => 'Peringatan',
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

		$criteria->compare('obatalkesdetail_id',$this->obatalkesdetail_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(indikasi)',strtolower($this->indikasi),true);
		$criteria->compare('LOWER(kontraindikasi)',strtolower($this->kontraindikasi),true);
		$criteria->compare('LOWER(komposisi)',strtolower($this->komposisi),true);
		$criteria->compare('LOWER(efeksamping)',strtolower($this->efeksamping),true);
		$criteria->compare('LOWER(interaksiobat)',strtolower($this->interaksiobat),true);
		$criteria->compare('LOWER(carapenyimpanan)',strtolower($this->carapenyimpanan),true);
		$criteria->compare('LOWER(peringatan)',strtolower($this->peringatan),true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('obatalkesdetail_id',$this->obatalkesdetail_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(indikasi)',strtolower($this->indikasi),true);
		$criteria->compare('LOWER(kontraindikasi)',strtolower($this->kontraindikasi),true);
		$criteria->compare('LOWER(komposisi)',strtolower($this->komposisi),true);
		$criteria->compare('LOWER(efeksamping)',strtolower($this->efeksamping),true);
		$criteria->compare('LOWER(interaksiobat)',strtolower($this->interaksiobat),true);
		$criteria->compare('LOWER(carapenyimpanan)',strtolower($this->carapenyimpanan),true);
		$criteria->compare('LOWER(peringatan)',strtolower($this->peringatan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}