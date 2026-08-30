<?php

/**
 * This is the model class for table "rl3_5_kegiatanperinatologi".
 *
 * The followings are the available columns in table 'rl3_5_kegiatanperinatologi':
 * @property integer $rl3_5_kegiatanperinatologi_id
 * @property string $tgl_laporan
 * @property string $propinsi
 * @property string $koders
 * @property integer $profilrs_id
 * @property string $kabupaten
 * @property string $namars
 * @property integer $jeniskegiatan_id
 * @property string $jeniskegiatan_kode
 * @property string $jeniskegiatan_nama
 * @property integer $tindakanpelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $rujukanmedis_rumah_sakit
 * @property integer $rujukanmedis_bidan
 * @property integer $rujukanmedis_puskesmas
 * @property integer $rujukanmedis_faskes_lainnya
 * @property integer $rujukanmedis_hidup
 * @property integer $rujukanmedis_mati
 * @property integer $rujukanmedis_total
 * @property integer $rujukannonmedis_hidup
 * @property integer $rujukannonmedis_mati
 * @property integer $rujukannonmedis_total
 * @property integer $nonrujukan_hidup
 * @property integer $nonrujukan_mati
 * @property integer $nonrujukan_total
 * @property integer $dirujuk
 */
class Rl35Kegiatanperinatologi extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl35Kegiatanperinatologi the static model class
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
		return 'rl3_5_kegiatanperinatologi';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tgl_laporan, propinsi, koders, kabupaten, namars, jeniskegiatan_id, jeniskegiatan_kode, jeniskegiatan_nama, tindakanpelayanan_id, pendaftaran_id', 'required'),
			array('profilrs_id, jeniskegiatan_id, tindakanpelayanan_id, pendaftaran_id, rujukanmedis_rumah_sakit, rujukanmedis_bidan, rujukanmedis_puskesmas, rujukanmedis_faskes_lainnya, rujukanmedis_hidup, rujukanmedis_mati, rujukanmedis_total, rujukannonmedis_hidup, rujukannonmedis_mati, rujukannonmedis_total, nonrujukan_hidup, nonrujukan_mati, nonrujukan_total, dirujuk', 'numerical', 'integerOnly'=>true),
			array('propinsi, koders, kabupaten, namars', 'length', 'max'=>50),
			array('jeniskegiatan_kode, jeniskegiatan_nama', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rl3_5_kegiatanperinatologi_id, tgl_laporan, propinsi, koders, profilrs_id, kabupaten, namars, jeniskegiatan_id, jeniskegiatan_kode, jeniskegiatan_nama, tindakanpelayanan_id, pendaftaran_id, rujukanmedis_rumah_sakit, rujukanmedis_bidan, rujukanmedis_puskesmas, rujukanmedis_faskes_lainnya, rujukanmedis_hidup, rujukanmedis_mati, rujukanmedis_total, rujukannonmedis_hidup, rujukannonmedis_mati, rujukannonmedis_total, nonrujukan_hidup, nonrujukan_mati, nonrujukan_total, dirujuk', 'safe', 'on'=>'search'),
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
			'rl3_5_kegiatanperinatologi_id' => 'Rl3 5 Kegiatanperinatologi',
			'tgl_laporan' => 'Tgl. Laporan',
			'propinsi' => 'Provinsi',
			'koders' => 'Koders',
			'profilrs_id' => 'Profilrs',
			'kabupaten' => 'Kabupaten',
			'namars' => 'Namars',
			'jeniskegiatan_id' => 'Jeniskegiatan',
			'jeniskegiatan_kode' => 'Jeniskegiatan Kode',
			'jeniskegiatan_nama' => 'Jeniskegiatan Nama',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pendaftaran_id' => 'Pendaftaran',
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

		if(!empty($this->rl3_5_kegiatanperinatologi_id)){
			$criteria->addCondition('rl3_5_kegiatanperinatologi_id = '.$this->rl3_5_kegiatanperinatologi_id);
		}
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
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->rujukanmedis_rumah_sakit)){
			$criteria->addCondition('rujukanmedis_rumah_sakit = '.$this->rujukanmedis_rumah_sakit);
		}
		if(!empty($this->rujukanmedis_bidan)){
			$criteria->addCondition('rujukanmedis_bidan = '.$this->rujukanmedis_bidan);
		}
		if(!empty($this->rujukanmedis_puskesmas)){
			$criteria->addCondition('rujukanmedis_puskesmas = '.$this->rujukanmedis_puskesmas);
		}
		if(!empty($this->rujukanmedis_faskes_lainnya)){
			$criteria->addCondition('rujukanmedis_faskes_lainnya = '.$this->rujukanmedis_faskes_lainnya);
		}
		if(!empty($this->rujukanmedis_hidup)){
			$criteria->addCondition('rujukanmedis_hidup = '.$this->rujukanmedis_hidup);
		}
		if(!empty($this->rujukanmedis_mati)){
			$criteria->addCondition('rujukanmedis_mati = '.$this->rujukanmedis_mati);
		}
		if(!empty($this->rujukanmedis_total)){
			$criteria->addCondition('rujukanmedis_total = '.$this->rujukanmedis_total);
		}
		if(!empty($this->rujukannonmedis_hidup)){
			$criteria->addCondition('rujukannonmedis_hidup = '.$this->rujukannonmedis_hidup);
		}
		if(!empty($this->rujukannonmedis_mati)){
			$criteria->addCondition('rujukannonmedis_mati = '.$this->rujukannonmedis_mati);
		}
		if(!empty($this->rujukannonmedis_total)){
			$criteria->addCondition('rujukannonmedis_total = '.$this->rujukannonmedis_total);
		}
		if(!empty($this->nonrujukan_hidup)){
			$criteria->addCondition('nonrujukan_hidup = '.$this->nonrujukan_hidup);
		}
		if(!empty($this->nonrujukan_mati)){
			$criteria->addCondition('nonrujukan_mati = '.$this->nonrujukan_mati);
		}
		if(!empty($this->nonrujukan_total)){
			$criteria->addCondition('nonrujukan_total = '.$this->nonrujukan_total);
		}
		if(!empty($this->dirujuk)){
			$criteria->addCondition('dirujuk = '.$this->dirujuk);
		}

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