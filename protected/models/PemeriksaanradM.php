<?php

/**
 * This is the model class for table "pemeriksaanrad_m".
 *
 * The followings are the available columns in table 'pemeriksaanrad_m':
 * @property integer $pemeriksaanrad_id
 * @property integer $daftartindakan_id
 * @property string $pemeriksaanrad_jenis
 * @property string $pemeriksaanrad_nama
 * @property string $pemeriksaanrad_namalainnya
 * @property boolean $pemeriksaanrad_aktif
 */
class PemeriksaanradM extends CActiveRecord
{
    public $daftartindakan_nama, $jenispemeriksaanrad_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanradM the static model class
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
		return 'pemeriksaanrad_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartindakan_id, pemeriksaanrad_nama, jenispemeriksaanrad_id', 'required'),
			array('daftartindakan_id', 'numerical', 'integerOnly'=>true),
			// array('pemeriksaanrad_jenis', 'length', 'max'=>100),
			array('pemeriksaanrad_nama, pemeriksaanrad_namalainnya', 'length', 'max'=>200),
			array('pemeriksaanrad_aktif,jenispemeriksaanrad_id, kode_dicom_modality', 'safe'),
			array('subjenis_pemeriksaanrad_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanrad_id, daftartindakan_id, daftartindakan_nama, jenispemeriksaanrad_nama,  pemeriksaanrad_nama, pemeriksaanrad_namalainnya, pemeriksaanrad_aktif,jenispemeriksaanrad_id,', 'safe', 'on'=>'search'),
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
                    'daftartindakan'=>array(self::BELONGS_TO,'DaftartindakanM','daftartindakan_id'),
                    'jenispemeriksaanrad'=>array(self::BELONGS_TO,'JenispemeriksaanradM','jenispemeriksaanrad_id'),
					'subjenis'=>array(self::BELONGS_TO,'SubjenisPemeriksaanradM','subjenis_pemeriksaanrad_id'),
                );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanrad_id' => 'ID',
			'daftartindakan_id' => 'Daftar Tindakan',
			'jenispemeriksaanrad_id' => 'Jenis Pemeriksaan',
			'pemeriksaanrad_nama' => 'Nama Pemeriksaan',
			'pemeriksaanrad_namalainnya' => 'Nama Lainnya',
			'pemeriksaanrad_aktif' => 'Aktif',
                        'daftartindakan_nama'=>'Daftar tindakan',
                        'jenispemeriksaanrad_nama'=>'Jenis Pemeriksaan',
            'kode_dicom_modality' => 'DICOM Modality',
			'subjenis_pemeriksaanrad_id' => 'Sub-jenis Pemeriksaan Radiologi',
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

		$criteria->with = array('daftartindakan','jenispemeriksaanrad');
		$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(jenispemeriksaanrad.jenispemeriksaanrad_nama)',strtolower($this->jenispemeriksaanrad_nama),true);
		$criteria->compare('t.pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('t.subjenis_pemeriksaanrad_id',$this->subjenis_pemeriksaanrad_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('t.jenispemeriksaanrad_id',$this->jenispemeriksaanrad_id);
		$criteria->compare('LOWER(t.pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
		$criteria->compare('LOWER(t.pemeriksaanrad_namalainnya)',strtolower($this->pemeriksaanrad_namalainnya),true);
		$criteria->compare('t.pemeriksaanrad_aktif',isset($this->pemeriksaanrad_aktif)?$this->pemeriksaanrad_aktif:true);
//                $criteria->addCondition('pemeriksaanrad_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('jenispemeriksaanrad_id',$this->jenispemeriksaanrad_id);
		$criteria->compare('t.subjenis_pemeriksaanrad_id',$this->subjenis_pemeriksaanrad_id);
		$criteria->compare('LOWER(pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
		$criteria->compare('LOWER(pemeriksaanrad_namalainnya)',strtolower($this->pemeriksaanrad_namalainnya),true);
		//$criteria->compare('pemeriksaanrad_aktif',$this->pemeriksaanrad_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit
                $criteria->limit=-1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }


}
