<?php

/**
 * This is the model class for table "rujukandari_m".
 *
 * The followings are the available columns in table 'rujukandari_m':
 * @property integer $rujukandari_id
 * @property integer $asalrujukan_id
 * @property string $namaperujuk
 * @property string $spesialis
 * @property string $alamatlengkap
 * @property string $notelp
 */
class RujukandariM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RujukandariM the static model class
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
		return 'rujukandari_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asalrujukan_id, namaperujuk', 'required'),
			array('asalrujukan_id', 'numerical', 'integerOnly'=>true),
			array('namaperujuk, notelp', 'length', 'max'=>100),
			array('spesialis', 'length', 'max'=>50),
			array('alamatlengkap, ppkrujukan, kodeppk', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rujukandari_id, asalrujukan_id, namaperujuk, spesialis, alamatlengkap, notelp, ppkrujukan, kodeppk', 'safe', 'on'=>'search'),
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
                    'asalrujukan' => array(self::BELONGS_TO, 'AsalrujukanM', 'asalrujukan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rujukandari_id' => 'ID ',
			'asalrujukan_id' => 'Asal Rujukan',
			'namaperujuk' => 'Nama Perujuk',
			'spesialis' => 'Spesialis',
			'alamatlengkap' => 'Alamat Lengkap',
			'notelp' => 'No. Telepon',
                        'ppkrujukan'=>'PPK Rujukan',
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

		$criteria->compare('rujukandari_id',$this->rujukandari_id);
		$criteria->compare('asalrujukan_id',$this->asalrujukan_id);
		$criteria->compare('LOWER(namaperujuk)',strtolower($this->namaperujuk),true);
		$criteria->compare('LOWER(spesialis)',strtolower($this->spesialis),true);
		$criteria->compare('LOWER(alamatlengkap)',strtolower($this->alamatlengkap),true);
		$criteria->compare('LOWER(notelp)',strtolower($this->notelp),true);
                $criteria->compare('LOWER(ppkrujukan)',strtolower($this->ppkrujukan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('rujukandari_id',$this->rujukandari_id);
		$criteria->compare('asalrujukan_id',$this->asalrujukan_id);
		$criteria->compare('LOWER(namaperujuk)',strtolower($this->namaperujuk),true);
		$criteria->compare('LOWER(spesialis)',strtolower($this->spesialis),true);
		$criteria->compare('LOWER(alamatlengkap)',strtolower($this->alamatlengkap),true);
		$criteria->compare('LOWER(notelp)',strtolower($this->notelp),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

        public function getAsalRujukanItems()
        {
            return AsalrujukanM::model()->findAll('asalrujukan_aktif=true ORDER BY asalrujukan_nama');
        }
}