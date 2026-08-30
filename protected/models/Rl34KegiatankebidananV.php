<?php

/**
 * This is the model class for table "rl3_4_kegiatankebidanan_v".
 *
 * The followings are the available columns in table 'rl3_4_kegiatankebidanan_v':
 * @property string $tgl_laporan
 * @property string $propinsi
 * @property string $koders
 * @property integer $profilrs_id
 * @property string $kabupaten
 * @property string $namars
 * @property integer $jeniskegiatan_id
 * @property string $jeniskegiatan_kode
 * @property string $jeniskegiatan_nama
 * @property string $rujukanmedis_rumah_sakit
 * @property string $rujukanmedis_bidan
 * @property string $rujukanmedis_puskesmas
 * @property string $rujukanmedis_faskes_lainnya
 * @property string $rujukanmedis_hidup
 * @property string $rujukanmedis_mati
 * @property string $rujukanmedis_total
 * @property string $rujukannonmedis_hidup
 * @property string $rujukannonmedis_mati
 * @property string $rujukannonmedis_total
 * @property string $nonrujukan_hidup
 * @property string $nonrujukan_mati
 * @property string $nonrujukan_total
 * @property string $dirujuk
 */
class Rl34KegiatankebidananV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl34KegiatankebidananV the static model class
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
		return 'rl3_4_kegiatankebidanan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, jeniskegiatan_id', 'numerical', 'integerOnly'=>true),
			array('propinsi, koders, kabupaten, namars', 'length', 'max'=>50),
			array('jeniskegiatan_kode, jeniskegiatan_nama', 'length', 'max'=>100),
			array('tgl_laporan, rujukanmedis_rumah_sakit, rujukanmedis_bidan, rujukanmedis_puskesmas, rujukanmedis_faskes_lainnya, rujukanmedis_hidup, rujukanmedis_mati, rujukanmedis_total, rujukannonmedis_hidup, rujukannonmedis_mati, rujukannonmedis_total, nonrujukan_hidup, nonrujukan_mati, nonrujukan_total, dirujuk', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_laporan, propinsi, koders, profilrs_id, kabupaten, namars, jeniskegiatan_id, jeniskegiatan_kode, jeniskegiatan_nama, rujukanmedis_rumah_sakit, rujukanmedis_bidan, rujukanmedis_puskesmas, rujukanmedis_faskes_lainnya, rujukanmedis_hidup, rujukanmedis_mati, rujukanmedis_total, rujukannonmedis_hidup, rujukannonmedis_mati, rujukannonmedis_total, nonrujukan_hidup, nonrujukan_mati, nonrujukan_total, dirujuk', 'safe', 'on'=>'search'),
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
			'jeniskegiatan_id' => 'Jeniskegiatan',
			'jeniskegiatan_kode' => 'Jeniskegiatan Kode',
			'jeniskegiatan_nama' => 'Jeniskegiatan Nama',
			'rujukanmedis_rumah_sakit' => 'Rujukanmedis Rumah Sakit',
			'rujukanmedis_bidan' => 'Rujukanmedis Bidan',
			'rujukanmedis_puskesmas' => 'Rujukanmedis Puskesmas',
			'rujukanmedis_faskes_lainnya' => 'Rujukanmedis Faskes Lainnya',
			'rujukanmedis_hidup' => 'Rujukanmedis Hidup',
			'rujukanmedis_mati' => 'Rujukanmedis Mati',
			'rujukanmedis_total' => 'Rujukanmedis Total',
			'rujukannonmedis_hidup' => 'Rujukannonmedis Hidup',
			'rujukannonmedis_mati' => 'Rujukannonmedis Mati',
			'rujukannonmedis_total' => 'Rujukannonmedis Total',
			'nonrujukan_hidup' => 'Nonrujukan Hidup',
			'nonrujukan_mati' => 'Nonrujukan Mati',
			'nonrujukan_total' => 'Nonrujukan Total',
			'dirujuk' => 'Dirujuk',
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
		if(!empty($this->jeniskegiatan_id)){
			$criteria->addCondition('jeniskegiatan_id = '.$this->jeniskegiatan_id);
		}
		$criteria->compare('LOWER(jeniskegiatan_kode)',strtolower($this->jeniskegiatan_kode),true);
		$criteria->compare('LOWER(jeniskegiatan_nama)',strtolower($this->jeniskegiatan_nama),true);
		$criteria->compare('LOWER(rujukanmedis_rumah_sakit)',strtolower($this->rujukanmedis_rumah_sakit),true);
		$criteria->compare('LOWER(rujukanmedis_bidan)',strtolower($this->rujukanmedis_bidan),true);
		$criteria->compare('LOWER(rujukanmedis_puskesmas)',strtolower($this->rujukanmedis_puskesmas),true);
		$criteria->compare('LOWER(rujukanmedis_faskes_lainnya)',strtolower($this->rujukanmedis_faskes_lainnya),true);
		$criteria->compare('LOWER(rujukanmedis_hidup)',strtolower($this->rujukanmedis_hidup),true);
		$criteria->compare('LOWER(rujukanmedis_mati)',strtolower($this->rujukanmedis_mati),true);
		$criteria->compare('LOWER(rujukanmedis_total)',strtolower($this->rujukanmedis_total),true);
		$criteria->compare('LOWER(rujukannonmedis_hidup)',strtolower($this->rujukannonmedis_hidup),true);
		$criteria->compare('LOWER(rujukannonmedis_mati)',strtolower($this->rujukannonmedis_mati),true);
		$criteria->compare('LOWER(rujukannonmedis_total)',strtolower($this->rujukannonmedis_total),true);
		$criteria->compare('LOWER(nonrujukan_hidup)',strtolower($this->nonrujukan_hidup),true);
		$criteria->compare('LOWER(nonrujukan_mati)',strtolower($this->nonrujukan_mati),true);
		$criteria->compare('LOWER(nonrujukan_total)',strtolower($this->nonrujukan_total),true);
		$criteria->compare('LOWER(dirujuk)',strtolower($this->dirujuk),true);

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