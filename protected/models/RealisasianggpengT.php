<?php

/**
 * This is the model class for table "realisasianggpeng_t".
 *
 * The followings are the available columns in table 'realisasianggpeng_t':
 * @property integer $realisasianggpeng_id
 * @property integer $alokasianggaran_id
 * @property integer $tandabuktikeluar_id
 * @property integer $konfiganggaran_id
 * @property integer $unitkerja_id
 * @property integer $sumberanggaran_id
 * @property integer $subkegiatanprogram_id
 * @property string $no_realisasi_peng
 * @property string $tglrealisasianggaran
 * @property double $nilaialokasi_pengeluaran
 * @property double $nilairealisasi_pengeluaran
 * @property string $persentase_realisasi
 * @property integer $realisasimengetahui_id
 * @property integer $realisasimenyetujui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class RealisasianggpengT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RealisasianggpengT the static model class
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
		return 'realisasianggpeng_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('konfiganggaran_id, unitkerja_id, sumberanggaran_id, subkegiatanprogram_id, no_realisasi_peng, tglrealisasianggaran, nilairealisasi_pengeluaran, persentase_realisasi, realisasimengetahui_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('alokasianggaran_id, tandabuktikeluar_id, konfiganggaran_id, unitkerja_id, sumberanggaran_id, subkegiatanprogram_id, realisasimengetahui_id, realisasimenyetujui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nilaialokasi_pengeluaran, nilairealisasi_pengeluaran', 'numerical'),
			array('no_realisasi_peng', 'length', 'max'=>50),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('realisasianggpeng_id, alokasianggaran_id, tandabuktikeluar_id, konfiganggaran_id, unitkerja_id, sumberanggaran_id, subkegiatanprogram_id, no_realisasi_peng, tglrealisasianggaran, nilaialokasi_pengeluaran, nilairealisasi_pengeluaran, persentase_realisasi, realisasimengetahui_id, realisasimenyetujui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'konfiganggaran' => array(self::BELONGS_TO, 'KonfiganggaranK', 'konfiganggaran_id'),
			'unitkerja' => array(self::BELONGS_TO, 'UnitkerjaM', 'unitkerja_id'),
			'mengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'realisasimengetahui_id'),
			'menyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'realisasimenyetujui_id'),
			'subkegiatanprogram' => array(self::BELONGS_TO, 'SubkegiatanprogramM', 'subkegiatanprogram_id'),
			'sumberanggaran' => array(self::BELONGS_TO, 'SumberanggaranM', 'sumberanggaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'realisasianggpeng_id' => 'Realisasianggpeng',
			'alokasianggaran_id' => 'Alokasianggaran',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'konfiganggaran_id' => 'Konfiganggaran',
			'unitkerja_id' => 'Unit Kerja',
			'sumberanggaran_id' => 'Sumberanggaran',
			'subkegiatanprogram_id' => 'Subkegiatanprogram',
			'no_realisasi_peng' => 'No. Realisasi',
			'tglrealisasianggaran' => 'Tanggal',
			'nilaialokasi_pengeluaran' => 'Nilaialokasi Pengeluaran',
			'nilairealisasi_pengeluaran' => 'Nilairealisasi Pengeluaran',
			'persentase_realisasi' => 'Persentase Realisasi',
			'realisasimengetahui_id' => 'Pegawai Mengetahui',
			'realisasimenyetujui_id' => 'Pegawai Menyetujui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->realisasianggpeng_id)){
			$criteria->addCondition('realisasianggpeng_id = '.$this->realisasianggpeng_id);
		}
		if(!empty($this->alokasianggaran_id)){
			$criteria->addCondition('alokasianggaran_id = '.$this->alokasianggaran_id);
		}
		if(!empty($this->tandabuktikeluar_id)){
			$criteria->addCondition('tandabuktikeluar_id = '.$this->tandabuktikeluar_id);
		}
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		if(!empty($this->sumberanggaran_id)){
			$criteria->addCondition('sumberanggaran_id = '.$this->sumberanggaran_id);
		}
		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		$criteria->compare('LOWER(no_realisasi_peng)',strtolower($this->no_realisasi_peng),true);
		$criteria->compare('LOWER(tglrealisasianggaran)',strtolower($this->tglrealisasianggaran),true);
		$criteria->compare('nilaialokasi_pengeluaran',$this->nilaialokasi_pengeluaran);
		$criteria->compare('nilairealisasi_pengeluaran',$this->nilairealisasi_pengeluaran);
		$criteria->compare('LOWER(persentase_realisasi)',strtolower($this->persentase_realisasi),true);
		if(!empty($this->realisasimengetahui_id)){
			$criteria->addCondition('realisasimengetahui_id = '.$this->realisasimengetahui_id);
		}
		if(!empty($this->realisasimenyetujui_id)){
			$criteria->addCondition('realisasimenyetujui_id = '.$this->realisasimenyetujui_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
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