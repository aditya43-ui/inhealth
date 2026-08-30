<?php

/**
 * This is the model class for table "rl3_1_kegiatanpelayananrawatinap_v".
 *
 * The followings are the available columns in table 'rl3_1_kegiatanpelayananrawatinap_v':
 * @property integer $profilrs_id
 * @property string $propinsi
 * @property string $kabupaten
 * @property string $koders
 * @property string $namars
 * @property string $tgl_laporan
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property string $pasienawaltahun
 * @property string $pasienmasuk
 * @property string $pasienkeluarhidup
 * @property string $pasienmatikurang48jam
 * @property string $pasienmatilebih48jam
 * @property string $lamadirawat
 * @property string $hariperawatan
 * @property string $kelasvvip
 * @property string $kelasvip
 * @property string $kelasi
 * @property string $kelasii
 * @property string $kelasiii
 * @property string $kelaskhusus
 * @property string $pasienakhirtahun
 */
class Rl31KegiatanpelayananrawatinapV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl31KegiatanpelayananrawatinapV the static model class
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
		return 'rl3_1_kegiatanpelayananrawatinap_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, jeniskasuspenyakit_id', 'numerical', 'integerOnly'=>true),
			array('propinsi, kabupaten', 'length', 'max'=>50),
			array('jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('koders, namars, tgl_laporan, pasienawaltahun, pasienmasuk, pasienkeluarhidup, pasienmatikurang48jam, pasienmatilebih48jam, lamadirawat, hariperawatan, kelasvvip, kelasvip, kelasi, kelasii, kelasiii, kelaskhusus, pasienakhirtahun', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('profilrs_id, propinsi, kabupaten, koders, namars, tgl_laporan, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, pasienawaltahun, pasienmasuk, pasienkeluarhidup, pasienmatikurang48jam, pasienmatilebih48jam, lamadirawat, hariperawatan, kelasvvip, kelasvip, kelasi, kelasii, kelasiii, kelaskhusus, pasienakhirtahun', 'safe', 'on'=>'search'),
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
			'profilrs_id' => 'Profilrs',
			'propinsi' => 'Provinsi',
			'kabupaten' => 'Kabupaten',
			'koders' => 'Koders',
			'namars' => 'Namars',
			'tgl_laporan' => 'Tgl. Laporan',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'pasienawaltahun' => 'Pasienawaltahun',
			'pasienmasuk' => 'Pasienmasuk',
			'pasienkeluarhidup' => 'Pasienkeluarhidup',
			'pasienmatikurang48jam' => 'Pasienmatikurang48jam',
			'pasienmatilebih48jam' => 'Pasienmatilebih48jam',
			'lamadirawat' => 'Lamadirawat',
			'hariperawatan' => 'Hariperawatan',
			'kelasvvip' => 'Kelasvvip',
			'kelasvip' => 'Kelasvip',
			'kelasi' => 'Kelasi',
			'kelasii' => 'Kelasii',
			'kelasiii' => 'Kelasiii',
			'kelaskhusus' => 'Kelaskhusus',
			'pasienakhirtahun' => 'Pasienakhirtahun',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(propinsi)',strtolower($this->propinsi),true);
		$criteria->compare('LOWER(kabupaten)',strtolower($this->kabupaten),true);
		$criteria->compare('LOWER(koders)',strtolower($this->koders),true);
		$criteria->compare('LOWER(namars)',strtolower($this->namars),true);
		$criteria->compare('LOWER(tgl_laporan)',strtolower($this->tgl_laporan),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('LOWER(pasienawaltahun)',strtolower($this->pasienawaltahun),true);
		$criteria->compare('LOWER(pasienmasuk)',strtolower($this->pasienmasuk),true);
		$criteria->compare('LOWER(pasienkeluarhidup)',strtolower($this->pasienkeluarhidup),true);
		$criteria->compare('LOWER(pasienmatikurang48jam)',strtolower($this->pasienmatikurang48jam),true);
		$criteria->compare('LOWER(pasienmatilebih48jam)',strtolower($this->pasienmatilebih48jam),true);
		$criteria->compare('LOWER(lamadirawat)',strtolower($this->lamadirawat),true);
		$criteria->compare('LOWER(hariperawatan)',strtolower($this->hariperawatan),true);
		$criteria->compare('LOWER(kelasvvip)',strtolower($this->kelasvvip),true);
		$criteria->compare('LOWER(kelasvip)',strtolower($this->kelasvip),true);
		$criteria->compare('LOWER(kelasi)',strtolower($this->kelasi),true);
		$criteria->compare('LOWER(kelasii)',strtolower($this->kelasii),true);
		$criteria->compare('LOWER(kelasiii)',strtolower($this->kelasiii),true);
		$criteria->compare('LOWER(kelaskhusus)',strtolower($this->kelaskhusus),true);
		$criteria->compare('LOWER(pasienakhirtahun)',strtolower($this->pasienakhirtahun),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}