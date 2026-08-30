<?php

/**
 * This is the model class for table "penggajianpegawai_v".
 *
 * The followings are the available columns in table 'penggajianpegawai_v':
 * @property integer $penggajianpeg_id
 * @property string $periodegaji
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $nama_keluarga
 * @property string $tglpenggajian
 * @property string $nopenggajian
 * @property double $penerimaanbersih
 * @property double $totalpajak
 */
class PenggajianpegawaiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenggajianpegawaiV the static model class
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
		return 'penggajianpegawai_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penggajianpeg_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('penerimaanbersih, totalpajak', 'numerical'),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, nama_keluarga, nopenggajian', 'length', 'max'=>50),
			array('periodegaji, tglpenggajian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penggajianpeg_id, periodegaji, pegawai_id, gelardepan, nama_pegawai, nama_keluarga, tglpenggajian, nopenggajian, penerimaanbersih, totalpajak', 'safe', 'on'=>'search'),
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
			'penggajianpeg_id' => 'Penggajianpeg',
			'periodegaji' => 'Periodegaji',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'nama_keluarga' => 'Nama Keluarga',
			'tglpenggajian' => 'Tanggal Penggajian',
			'nopenggajian' => 'No. Penggajian',
			'penerimaanbersih' => 'Penerimaanbersih',
			'totalpajak' => 'Totalpajak',
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

		$criteria->compare('penggajianpeg_id',$this->penggajianpeg_id);
		$criteria->compare('LOWER(periodegaji)',strtolower($this->periodegaji),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tglpenggajian)',strtolower($this->tglpenggajian),true);
		$criteria->compare('LOWER(nopenggajian)',strtolower($this->nopenggajian),true);
		$criteria->compare('penerimaanbersih',$this->penerimaanbersih);
		$criteria->compare('totalpajak',$this->totalpajak);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('penggajianpeg_id',$this->penggajianpeg_id);
		$criteria->compare('LOWER(periodegaji)',strtolower($this->periodegaji),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tglpenggajian)',strtolower($this->tglpenggajian),true);
		$criteria->compare('LOWER(nopenggajian)',strtolower($this->nopenggajian),true);
		$criteria->compare('penerimaanbersih',$this->penerimaanbersih);
		$criteria->compare('totalpajak',$this->totalpajak);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}