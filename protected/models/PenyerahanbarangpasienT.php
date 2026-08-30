<?php

/**
 * This is the model class for table "penyerahanbarangpasien_t".
 *
 * The followings are the available columns in table 'penyerahanbarangpasien_t':
 * @property integer $penyerahanbarangpasien_id
 * @property integer $ambiljenazah_id
 * @property integer $no_urutbrg
 * @property string $jenisbarang_pasien
 * @property string $namabarang_pasien
 * @property string $keadaanbarang_pasien
 */
class PenyerahanbarangpasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyerahanbarangpasienT the static model class
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
		return 'penyerahanbarangpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ambiljenazah_id, no_urutbrg, namabarang_pasien', 'required'),
			array('ambiljenazah_id, no_urutbrg', 'numerical', 'integerOnly'=>true),
			array('jenisbarang_pasien, namabarang_pasien, keadaanbarang_pasien', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyerahanbarangpasien_id, ambiljenazah_id, no_urutbrg, jenisbarang_pasien, namabarang_pasien, keadaanbarang_pasien', 'safe', 'on'=>'search'),
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
			'penyerahanbarangpasien_id' => 'Penyerahanbarangpasien',
			'ambiljenazah_id' => 'Ambiljenazah',
			'no_urutbrg' => 'No. Urutbrg',
			'jenisbarang_pasien' => 'Jenisbarang Pasien',
			'namabarang_pasien' => 'Namabarang Pasien',
			'keadaanbarang_pasien' => 'Keadaanbarang Pasien',
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

		$criteria->compare('penyerahanbarangpasien_id',$this->penyerahanbarangpasien_id);
		$criteria->compare('ambiljenazah_id',$this->ambiljenazah_id);
		$criteria->compare('no_urutbrg',$this->no_urutbrg);
		$criteria->compare('LOWER(jenisbarang_pasien)',strtolower($this->jenisbarang_pasien),true);
		$criteria->compare('LOWER(namabarang_pasien)',strtolower($this->namabarang_pasien),true);
		$criteria->compare('LOWER(keadaanbarang_pasien)',strtolower($this->keadaanbarang_pasien),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('penyerahanbarangpasien_id',$this->penyerahanbarangpasien_id);
		$criteria->compare('ambiljenazah_id',$this->ambiljenazah_id);
		$criteria->compare('no_urutbrg',$this->no_urutbrg);
		$criteria->compare('LOWER(jenisbarang_pasien)',strtolower($this->jenisbarang_pasien),true);
		$criteria->compare('LOWER(namabarang_pasien)',strtolower($this->namabarang_pasien),true);
		$criteria->compare('LOWER(keadaanbarang_pasien)',strtolower($this->keadaanbarang_pasien),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}