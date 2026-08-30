<?php

/**
 * This is the model class for table "rup_subkegiatanprogram_v".
 * Model yang digunakan untuk mengambil data view rup_paket_v
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @version     2.0.0
 * @package models 
 * @category model
 * RSST-6702
 * The followings are the available columns in table 'rup_subkegiatanprogram_v':
 * @property integer $mappingrekeninganggaran_id
 * @property integer $periodeanggaran_id
 * @property string $tahunanggaran
 * @property string $anggaran_nama
 * @property integer $unitkerja_id
 * @property string $namaunitkerja
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $programkerja_id
 * @property string $programkerja_nama
 * @property integer $subprogramkerja_id
 * @property string $subprogramkerja_nama
 * @property integer $kegiatanprogram_id
 * @property string $kegiatanprogram_nama
 * @property integer $subkegiatanprogram_id
 * @property string $subkegiatanprogram_nama
 * @property integer $rekeninganggaran5_id
 * @property string $kodeanggaran
 * @property string $nama_rekeninganggaran5
 * @property string $kategori_pengadaan
 * @property string $metode_pengadaan
 */
class RupSubkegiatanprogramV extends CActiveRecord
{
        public $default;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RupSubkegiatanprogramV the static model class
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
		return 'rup_subkegiatanprogram_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mappingrekeninganggaran_id, periodeanggaran_id, unitkerja_id, instalasi_id, programkerja_id, subprogramkerja_id, kegiatanprogram_id, subkegiatanprogram_id, rekeninganggaran5_id', 'numerical', 'integerOnly'=>true),
			array('tahunanggaran', 'length', 'max'=>4),
			array('anggaran_nama, nama_rekeninganggaran5', 'length', 'max'=>100),
			array('namaunitkerja, kegiatanprogram_nama, subkegiatanprogram_nama', 'length', 'max'=>200),
			array('instalasi_nama, kodeanggaran', 'length', 'max'=>50),
			array('programkerja_nama, subprogramkerja_nama', 'length', 'max'=>500),
			array('kategori_pengadaan, metode_pengadaan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mappingrekeninganggaran_id, periodeanggaran_id, tahunanggaran, anggaran_nama, unitkerja_id, namaunitkerja, instalasi_id, instalasi_nama, programkerja_id, programkerja_nama, subprogramkerja_id, subprogramkerja_nama, kegiatanprogram_id, kegiatanprogram_nama, subkegiatanprogram_id, subkegiatanprogram_nama, rekeninganggaran5_id, kodeanggaran, nama_rekeninganggaran5, kategori_pengadaan, metode_pengadaan', 'safe', 'on'=>'search'),
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
			'mappingrekeninganggaran_id' => 'Mappingrekeninganggaran',
			'periodeanggaran_id' => 'Periodeanggaran',
			'tahunanggaran' => 'Tahunanggaran',
			'anggaran_nama' => 'Anggaran Nama',
			'unitkerja_id' => 'Unitkerja',
			'namaunitkerja' => 'Namaunitkerja',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'programkerja_id' => 'Programkerja',
			'programkerja_nama' => 'Programkerja Nama',
			'subprogramkerja_id' => 'Subprogramkerja',
			'subprogramkerja_nama' => 'Subprogramkerja Nama',
			'kegiatanprogram_id' => 'Kegiatanprogram',
			'kegiatanprogram_nama' => 'Kegiatanprogram Nama',
			'subkegiatanprogram_id' => 'Subkegiatanprogram',
			'subkegiatanprogram_nama' => 'Subkegiatanprogram Nama',
			'rekeninganggaran5_id' => 'Rekeninganggaran5',
			'kodeanggaran' => 'Kodeanggaran',
			'nama_rekeninganggaran5' => 'Nama Rekeninganggaran5',
			'kategori_pengadaan' => 'Kategori Pengadaan',
			'metode_pengadaan' => 'Metode Pengadaan',
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

		$criteria->compare('mappingrekeninganggaran_id',$this->mappingrekeninganggaran_id);
		$criteria->compare('periodeanggaran_id',$this->periodeanggaran_id);
		$criteria->compare('tahunanggaran',$this->tahunanggaran,true);
		$criteria->compare('anggaran_nama',$this->anggaran_nama,true);
		$criteria->compare('unitkerja_id',$this->unitkerja_id);
		$criteria->compare('namaunitkerja',$this->namaunitkerja,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('programkerja_id',$this->programkerja_id);
		$criteria->compare('programkerja_nama',$this->programkerja_nama,true);
		$criteria->compare('subprogramkerja_id',$this->subprogramkerja_id);
		$criteria->compare('subprogramkerja_nama',$this->subprogramkerja_nama,true);
		$criteria->compare('kegiatanprogram_id',$this->kegiatanprogram_id);
		$criteria->compare('kegiatanprogram_nama',$this->kegiatanprogram_nama,true);
		$criteria->compare('subkegiatanprogram_id',$this->subkegiatanprogram_id);
		$criteria->compare('subkegiatanprogram_nama',$this->subkegiatanprogram_nama,true);
		$criteria->compare('rekeninganggaran5_id',$this->rekeninganggaran5_id);
		$criteria->compare('kodeanggaran',$this->kodeanggaran,true);
		$criteria->compare('nama_rekeninganggaran5',$this->nama_rekeninganggaran5,true);
		$criteria->compare('kategori_pengadaan',$this->kategori_pengadaan,true);
		$criteria->compare('metode_pengadaan',$this->metode_pengadaan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Pencarian sub kegiatan program berdasarkan mappingrekeninganggaran_id
         * @return \CActiveDataProvider
         */
        public function searchDokAnggaran(){
            $cri = new CDbCriteria();
            
            if (!empty($this->default)){
                $cri->addCondition(" mappingrekeninganggaran_id IS NULL ");
            }            
            if (!empty($this->instalasi_id)){
                $cri->addCondition(" instalasi_id = ".$this->instalasi_id." ");
            }            
            if (!empty($this->unitkerja_id)){
                $cri->addCondition(" unitkerja_id = ".$this->unitkerja_id." ");
            }
            if (!empty($this->periodeanggaran_id)){
                $cri->addCondition(" periodeanggaran_id = ".$this->periodeanggaran_id." ");
            }
            
            $cri->compare("LOWER(programkerja_nama)", strtolower($this->programkerja_nama), true);
            $cri->compare("LOWER(subprogramkerja_nama)", strtolower($this->subprogramkerja_nama), true);            
            if (!empty($this->kodeanggaran)){
                $cri->addCondition(" kodeanggaran ilike '%".$this->kodeanggaran."%' OR   nama_rekeninganggaran5 ilike '%".$this->kodeanggaran."%' ");
            }
            $cri->compare("LOWER(subkegiatanprogram_nama)", strtolower($this->subkegiatanprogram_nama), true);            
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$cri,
            ));
        }
}