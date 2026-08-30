<?php

/**
 * This is the model class for table "rl3_12_kegiatankeluargaberencana_v".
 *
 * The followings are the available columns in table 'rl3_12_kegiatankeluargaberencana_v':
 * @property string $tgl_laporan
 * @property string $propinsi
 * @property string $kabupaten
 * @property integer $profilrs_id
 * @property string $koders
 * @property string $namars
 * @property string $metoda
 * @property string $konseling_anc
 * @property string $konseling_pascapersalinan
 * @property string $kbbaru_bukanrujukan
 * @property string $kbbaru_rujukanri
 * @property string $kbbaru_rujukanrj
 * @property string $kunjunganulang
 * @property string $keluhanefeksamping_jumlah
 * @property string $keluhanefeksamping_dirujuk
 */
class Rl312KegiatankeluargaberencanaV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl312KegiatankeluargaberencanaV the static model class
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
		return 'rl3_12_kegiatankeluargaberencana_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id', 'numerical', 'integerOnly'=>true),
			array('propinsi, kabupaten, koders, namars', 'length', 'max'=>50),
			array('metoda', 'length', 'max'=>200),
			array('tgl_laporan, konseling_anc, konseling_pascapersalinan, kbbaru_bukanrujukan, kbbaru_rujukanri, kbbaru_rujukanrj, kunjunganulang, keluhanefeksamping_jumlah, keluhanefeksamping_dirujuk', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_laporan, propinsi, kabupaten, profilrs_id, koders, namars, metoda, konseling_anc, konseling_pascapersalinan, kbbaru_bukanrujukan, kbbaru_rujukanri, kbbaru_rujukanrj, kunjunganulang, keluhanefeksamping_jumlah, keluhanefeksamping_dirujuk', 'safe', 'on'=>'search'),
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
			'tgl_laporan' => 'Tgl. Laporan',
			'propinsi' => 'Provinsi',
			'kabupaten' => 'Kabupaten',
			'profilrs_id' => 'Profilrs',
			'koders' => 'Koders',
			'namars' => 'Namars',
			'metoda' => 'Metoda',
			'konseling_anc' => 'Konseling Anc',
			'konseling_pascapersalinan' => 'Konseling Pascapersalinan',
			'kbbaru_bukanrujukan' => 'Kbbaru Bukanrujukan',
			'kbbaru_rujukanri' => 'Kbbaru Rujukanri',
			'kbbaru_rujukanrj' => 'Kbbaru Rujukanrj',
			'kunjunganulang' => 'Kunjunganulang',
			'keluhanefeksamping_jumlah' => 'Keluhanefeksamping Jumlah',
			'keluhanefeksamping_dirujuk' => 'Keluhanefeksamping Dirujuk',
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

		$criteria->compare('LOWER(tgl_laporan)',strtolower($this->tgl_laporan),true);
		$criteria->compare('LOWER(propinsi)',strtolower($this->propinsi),true);
		$criteria->compare('LOWER(kabupaten)',strtolower($this->kabupaten),true);
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(koders)',strtolower($this->koders),true);
		$criteria->compare('LOWER(namars)',strtolower($this->namars),true);
		$criteria->compare('LOWER(metoda)',strtolower($this->metoda),true);
		$criteria->compare('LOWER(konseling_anc)',strtolower($this->konseling_anc),true);
		$criteria->compare('LOWER(konseling_pascapersalinan)',strtolower($this->konseling_pascapersalinan),true);
		$criteria->compare('LOWER(kbbaru_bukanrujukan)',strtolower($this->kbbaru_bukanrujukan),true);
		$criteria->compare('LOWER(kbbaru_rujukanri)',strtolower($this->kbbaru_rujukanri),true);
		$criteria->compare('LOWER(kbbaru_rujukanrj)',strtolower($this->kbbaru_rujukanrj),true);
		$criteria->compare('LOWER(kunjunganulang)',strtolower($this->kunjunganulang),true);
		$criteria->compare('LOWER(keluhanefeksamping_jumlah)',strtolower($this->keluhanefeksamping_jumlah),true);
		$criteria->compare('LOWER(keluhanefeksamping_dirujuk)',strtolower($this->keluhanefeksamping_dirujuk),true);

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