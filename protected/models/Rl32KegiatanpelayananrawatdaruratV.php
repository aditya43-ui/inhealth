<?php

/**
 * This is the model class for table "rl3_2_kegiatanpelayananrawatdarurat_v".
 *
 * The followings are the available columns in table 'rl3_2_kegiatanpelayananrawatdarurat_v':
 * @property string $tgl_laporan
 * @property string $propinsi
 * @property string $koders
 * @property integer $profilrs_id
 * @property string $kabupaten
 * @property string $namars
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property string $rujukan
 * @property string $nonrujukan
 * @property string $tindaklanjut_dirawat
 * @property string $tindaklanjut_dirujuk
 * @property string $tindaklanjut_pulang
 * @property string $meninggal
 * @property string $doa
 */
class Rl32KegiatanpelayananrawatdaruratV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl32KegiatanpelayananrawatdaruratV the static model class
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
		return 'rl3_2_kegiatanpelayananrawatdarurat_v';
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
			array('propinsi, koders, kabupaten, namars', 'length', 'max'=>50),
			array('jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('tgl_laporan, rujukan, nonrujukan, tindaklanjut_dirawat, tindaklanjut_dirujuk, tindaklanjut_pulang, meninggal, doa', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_laporan, propinsi, koders, profilrs_id, kabupaten, namars, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, rujukan, nonrujukan, tindaklanjut_dirawat, tindaklanjut_dirujuk, tindaklanjut_pulang, meninggal, doa', 'safe', 'on'=>'search'),
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
			'koders' => 'Koders',
			'profilrs_id' => 'Profilrs',
			'kabupaten' => 'Kabupaten',
			'namars' => 'Namars',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'rujukan' => 'Rujukan',
			'nonrujukan' => 'Nonrujukan',
			'tindaklanjut_dirawat' => 'Tindaklanjut Dirawat',
			'tindaklanjut_dirujuk' => 'Tindaklanjut Dirujuk',
			'tindaklanjut_pulang' => 'Tindaklanjut Pulang',
			'meninggal' => 'Meninggal',
			'doa' => 'Doa',
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
		$criteria->compare('LOWER(koders)',strtolower($this->koders),true);
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(kabupaten)',strtolower($this->kabupaten),true);
		$criteria->compare('LOWER(namars)',strtolower($this->namars),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('LOWER(rujukan)',strtolower($this->rujukan),true);
		$criteria->compare('LOWER(nonrujukan)',strtolower($this->nonrujukan),true);
		$criteria->compare('LOWER(tindaklanjut_dirawat)',strtolower($this->tindaklanjut_dirawat),true);
		$criteria->compare('LOWER(tindaklanjut_dirujuk)',strtolower($this->tindaklanjut_dirujuk),true);
		$criteria->compare('LOWER(tindaklanjut_pulang)',strtolower($this->tindaklanjut_pulang),true);
		$criteria->compare('LOWER(meninggal)',strtolower($this->meninggal),true);
		$criteria->compare('LOWER(doa)',strtolower($this->doa),true);

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