<?php

/**
 * This is the model class for table "pasienkecelakaan_t".
 *
 * The followings are the available columns in table 'pasienkecelakaan_t':
 * @property integer $pasienkecelakaan_id
 * @property integer $pendaftaran_id
 * @property integer $jeniskecelakaan_id
 * @property string $tglkecelakaan
 * @property string $tempatkecelakaan
 * @property string $keterangankecelakaan
 */
class PasienkecelakaanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienkecelakaanT the static model class
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
		return 'pasienkecelakaan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, jeniskecelakaan_id, tglkecelakaan, tempatkecelakaan', 'required'),
			array('pendaftaran_id, jeniskecelakaan_id', 'numerical', 'integerOnly'=>true),
			array('tempatkecelakaan', 'length', 'max'=>100),
			array('keterangankecelakaan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienkecelakaan_id, pendaftaran_id, jeniskecelakaan_id, tglkecelakaan, tempatkecelakaan, keterangankecelakaan', 'safe', 'on'=>'search'),
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
                    'pendaftaranTs'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
                    'jeniskecelakaan'=>array(self::BELONGS_TO,'JeniskecelakaanM','jeniskecelakaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienkecelakaan_id' => 'Pasienkecelakaan',
			'pendaftaran_id' => 'Nomor Pendaftaran',
			'jeniskecelakaan_id' => 'Jenis Kecelakaan',
			'tglkecelakaan' => 'Tanggal Kecelakaan',
			'tempatkecelakaan' => 'Tempat Kecelakaan',
			'keterangankecelakaan' => 'Keterangan',
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

		$criteria->compare('pasienkecelakaan_id',$this->pasienkecelakaan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('jeniskecelakaan_id',$this->jeniskecelakaan_id);
		$criteria->compare('LOWER(tglkecelakaan)',strtolower($this->tglkecelakaan),true);
		$criteria->compare('LOWER(tempatkecelakaan)',strtolower($this->tempatkecelakaan),true);
		$criteria->compare('LOWER(keterangankecelakaan)',strtolower($this->keterangankecelakaan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasienkecelakaan_id',$this->pasienkecelakaan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('jeniskecelakaan_id',$this->jeniskecelakaan_id);
		$criteria->compare('LOWER(tglkecelakaan)',strtolower($this->tglkecelakaan),true);
		$criteria->compare('LOWER(tempatkecelakaan)',strtolower($this->tempatkecelakaan),true);
		$criteria->compare('LOWER(keterangankecelakaan)',strtolower($this->keterangankecelakaan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getJenisKecelakaanItems()
        {
            return JeniskecelakaanM::model()->findAllByAttributes(array('jeniskecelakaan_aktif'=>true));
        }
        
}