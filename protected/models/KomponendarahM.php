<?php

/**
 * @author   Deni Hamdani <denihamdani@piindonesia.co.id>
 * @version  2.0.0 
 *
 * This is the model class for table "komponendarah_m".
 *
 * The followings are the available columns in table 'komponendarah_m':
 * @property integer $komponendarah_id
 * @property integer $jeniskantongdarah_id
 * @property string $namakomponendrh
 * @property string $singkatan_komp
 * @property boolean $komponendarah_aktif
 *
 * The followings are the available model relations:
 * @property JeniskantongdarahM $jeniskantongdarah
 * @property KantongdarahdetT[] $kantongdarahdetTs
 */
class KomponendarahM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KomponendarahM the static model class
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
		return 'komponendarah_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskantongdarah_id, namakomponendrh, singkatan_komp', 'required'),
			array('jeniskantongdarah_id', 'numerical', 'integerOnly'=>true),
			array('namakomponendrh', 'length', 'max'=>100),
			array('singkatan_komp', 'length', 'max'=>5),
			array('komponendarah_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('komponendarah_id, jeniskantongdarah_id, namakomponendrh, singkatan_komp, komponendarah_aktif', 'safe', 'on'=>'search'),
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
			'jeniskantongdarah' => array(self::BELONGS_TO, 'JeniskantongdarahM', 'jeniskantongdarah_id'),
			'kantongdarahdetTs' => array(self::HAS_MANY, 'KantongdarahdetT', 'komponendarah_id'),
                        'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'komponendarah_id' => 'Komponen Darah',
			'jeniskantongdarah_id' => 'Jenis Kantong Darah',
			'namakomponendrh' => 'Nama Komponen Darah',
			'singkatan_komp' => 'Singkatan Komponen',
			'komponendarah_aktif' => 'Aktif',
                        'daftartindakan_id' => 'Daftar Tindakan',
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

		$criteria->compare('komponendarah_id',$this->komponendarah_id);
		$criteria->compare('jeniskantongdarah_id',$this->jeniskantongdarah_id);
		$criteria->compare('namakomponendrh',$this->namakomponendrh,true);
		$criteria->compare('singkatan_komp',$this->singkatan_komp,true);
                $criteria->compare('komponendarah_aktif',isset($this->komponendarah_aktif)?$this->komponendarah_aktif:true);
                $criteria->compare('daftartindakan_id',$this->daftartindakan_id);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchKomponenDarah()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('komponendarah_id',$this->komponendarah_id);
		$criteria->compare('jeniskantongdarah_id',$this->jeniskantongdarah_id);
		$criteria->compare('namakomponendrh',$this->namakomponendrh,true);
		$criteria->compare('singkatan_komp',$this->singkatan_komp,true);
                $criteria->compare('komponendarah_aktif',isset($this->komponendarah_aktif)?$this->komponendarah_aktif:true);
                $criteria->compare('daftartindakan_id',$this->daftartindakan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getNamaKomponenLengkap() {
        return $this->namakomponendrh." (".$this->singkatan_komp.")";
    }
}