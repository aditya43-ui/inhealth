<?php

/**
 * This is the model class for table "golonganpegawai_m".
 *
 * The followings are the available columns in table 'golonganpegawai_m':
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property string $golonganpegawai_namalainnya
 * @property boolean $golonganpegawai_aktif
 */
class GolonganpegawaiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GolonganpegawaiM the static model class
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
		return 'golonganpegawai_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('golonganpegawai_nama, kopjmlmininalplafon, kopjmlmaksimalplafon', 'required'),
			array('golonganpegawai_nama, golonganpegawai_namalainnya', 'length', 'max'=>50),
			array('golonganpegawai_aktif, kopsimpananpokok, kopsimpananwajib', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('golonganpegawai_id, golonganpegawai_nama, golonganpegawai_namalainnya, golonganpegawai_aktif', 'safe', 'on'=>'search'),
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
			'golonganpegawai_id' => 'ID',
			'golonganpegawai_nama' => 'Golongan',
			'golonganpegawai_namalainnya' => 'Nama Lain',
			'golonganpegawai_aktif' => 'Aktif',
			'kopjmlmininalplafon' => 'Jumlah Minimal Pinjaman',
			'kopjmlmaksimalplafon' => 'Jumlah Maksimal Pinjaman',
			'kopsimpananpokok' => 'Simpanan Pokok',
			'kopsimpananwajib' => 'Simpanan Wajib',
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

		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('LOWER(golonganpegawai_nama)',strtolower($this->golonganpegawai_nama),true);
		$criteria->compare('LOWER(golonganpegawai_namalainnya)',strtolower($this->golonganpegawai_namalainnya),true);
		$criteria->compare('golonganpegawai_aktif',isset($this->golonganpegawai_aktif)?$this->golonganpegawai_aktif:true);
//                $criteria->addCondition('golonganpegawai_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('LOWER(golonganpegawai_nama)',strtolower($this->golonganpegawai_nama),true);
		$criteria->compare('LOWER(golonganpegawai_namalainnya)',strtolower($this->golonganpegawai_namalainnya),true);
		//$criteria->compare('golonganpegawai_aktif',$this->golonganpegawai_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}