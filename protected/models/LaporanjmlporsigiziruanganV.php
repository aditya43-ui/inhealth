<?php

/**
 * This is the model class for table "laporanjmlporsigiziruangan_v".
 *
 * The followings are the available columns in table 'laporanjmlporsigiziruangan_v':
 * @property string $tglkirimmenu
 * @property integer $jenisdiet_id
 * @property string $jenisdiet_nama
 * @property string $jml_kirim
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $kirimmenudiet_id
 */
class LaporanjmlporsigiziruanganV extends CActiveRecord
{
	 public $tgl_awal;
     public $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanjmlporsigiziruanganV the static model class
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
		return 'laporanjmlporsigiziruangan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisdiet_id, ruangan_id, kelaspelayanan_id, kirimmenudiet_id', 'numerical', 'integerOnly'=>true),
			array('jenisdiet_nama, ruangan_nama, kelaspelayanan_nama', 'length', 'max'=>50),
			array('tglkirimmenu, jml_kirim', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, tglkirimmenu, jenisdiet_id, jenisdiet_nama, jml_kirim, ruangan_id, ruangan_nama, kelaspelayanan_id, kelaspelayanan_nama, kirimmenudiet_id', 'safe', 'on'=>'search'),
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
			'tglkirimmenu' => 'Tglkirimmenu',
			'jenisdiet_id' => 'Jenisdiet',
			'jenisdiet_nama' => 'Jenisdiet Nama',
			'jml_kirim' => 'Jml Kirim',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'kirimmenudiet_id' => 'Kirimmenudiet',
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

		$criteria->compare('LOWER(tglkirimmenu)',strtolower($this->tglkirimmenu),true);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('LOWER(jml_kirim)',strtolower($this->jml_kirim),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('LOWER(tglkirimmenu)',strtolower($this->tglkirimmenu),true);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('LOWER(jml_kirim)',strtolower($this->jml_kirim),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}