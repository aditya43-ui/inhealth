<?php

/**
 * This is the model class for table "kesimpulanmcu_t".
 *
 * The followings are the available columns in table 'kesimpulanmcu_t':
 * @property integer $kesimpulanmcu_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $permintaanmcu_id
 * @property integer $ruangan_id
 * @property string $tgl_kesimpulanmcu
 * @property string $keterangan_kesimpulanmcu
 * @property boolean $kesimpulan1_status
 * @property string $kesimpulan1_desc
 * @property boolean $kesimpulan2_status
 * @property string $kesimpulan2_desc
 * @property boolean $kesimpulan3_status
 * @property string $kesimpulan3_desc
 * @property string $kesimpulanperorangan
 * @property boolean $saran1_status
 * @property string $saran1_desc
 * @property boolean $saran1_1_status
 * @property string $saran1_1_desc
 * @property boolean $saran1_2_status
 * @property string $saran1_2_desc
 * @property boolean $saran1_3_status
 * @property string $saran1_3_desc
 * @property boolean $saran2_status
 * @property string $saran2_desc
 * @property boolean $saran3_status
 * @property string $saran3_desc
 * @property string $saran3_1_desc
 * @property string $saran3_2_desc
 * @property string $saran3_3_desc
 * @property boolean $saran3_3_1_status
 * @property string $saran3_3_1_desc
 * @property boolean $saran3_3_2_status
 * @property string $saran3_3_2_desc
 * @property boolean $saran3_3_3_status
 * @property string $saran3_3_3_desc
 * @property boolean $saran3_3_4_status
 * @property string $saran3_3_4_desc
 * @property string $saran3_4_desc
 * @property string $saranperorangan
 * @property string $nama_pemeriksa_kes
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class KesimpulanmcuT extends CActiveRecord
{
    public $is_sendiri;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KesimpulanmcuT the static model class
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
		return 'kesimpulanmcu_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, ruangan_id, tgl_kesimpulanmcu, saran1_desc, saran1_1_desc, saran1_2_desc, saran1_3_desc, saran2_desc, saran3_desc, saran3_1_desc, saran3_2_desc, saran3_3_desc, saran3_3_1_desc, saran3_3_2_desc, saran3_3_3_desc, saran3_3_4_desc, saran3_4_desc, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pasien_id, permintaanmcu_id, ruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nama_pemeriksa_kes', 'length', 'max'=>150),
//			array('telinga_kiri, telinga_kanan', 'length', 'max'=>50),
			array('keterangan_kesimpulanmcu, kesimpulan1_status, kesimpulan2_status, kesimpulan3_status, kesimpulanperorangan, saran1_status, saran1_1_status, saran1_2_status, saran1_3_status, saran2_status, saran3_status, saran3_3_1_status, saran3_3_2_status, saran3_3_3_status, saran3_3_4_status, saranperorangan, update_time, , tglpengambilanhasil, namapenerimahasil, notelppenerimahasil, namaygmenyerahkan, ketpenyerahan, jenisidentitas, no_identitas, alamat', 'safe'),
            array('pemeriksaan_laboratorium, pemeriksaan_radiologi', 'safe'),
            array('periksaumum_nadi, bodymassindex_id, periksaumum_sistolic, periksaumum_diastolic, periksaumum_nilaibmi, periksaumum_bmikategori, periksaumum_tinggibadan, periksaumum_beratbadan, periksaumum_tekanandarah, periksaumum_suhu', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kesimpulanmcu_id, pendaftaran_id, pasien_id, permintaanmcu_id, ruangan_id, tgl_kesimpulanmcu, keterangan_kesimpulanmcu, kesimpulan1_status, kesimpulan1_desc, kesimpulan2_status, kesimpulan2_desc, kesimpulan3_status, kesimpulan3_desc, kesimpulanperorangan, saran1_status, saran1_desc, saran1_1_status, saran1_1_desc, saran1_2_status, saran1_2_desc, saran1_3_status, saran1_3_desc, saran2_status, saran2_desc, saran3_status, saran3_desc, saran3_1_desc, saran3_2_desc, saran3_3_desc, saran3_3_1_status, saran3_3_1_desc, saran3_3_2_status, saran3_3_2_desc, saran3_3_3_status, saran3_3_3_desc, saran3_3_4_status, saran3_3_4_desc, saran3_4_desc, saranperorangan, nama_pemeriksa_kes, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, periksaumum_suhu, telinga_kiri, telinga_kanan', 'safe', 'on'=>'search'),
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
			'kesimpulanmcu_id' => 'Kesimpulanmcu',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'permintaanmcu_id' => 'Permintaanmcu',
			'ruangan_id' => 'Ruangan',
			'tgl_kesimpulanmcu' => 'Tgl. Kesimpulanmcu',
			'kesimpulan1_status' => 'Kesimpulan1 Status',
			'kesimpulan1_desc' => 'Kesimpulan1 Desc',
			'kesimpulan2_status' => 'Kesimpulan2 Status',
			'kesimpulan2_desc' => 'Kesimpulan2 Desc',
			'kesimpulan3_status' => 'Kesimpulan3 Status',
			'kesimpulan3_desc' => 'Kesimpulan3 Desc',
			'kesimpulanperorangan' => 'Kesimpulanperorangan',
			'saran1_status' => 'Saran1 Status',
			'saran1_desc' => 'Saran1 Desc',
			'saran1_1_status' => 'Saran1 1 Status',
			'saran1_1_desc' => 'Saran1 1 Desc',
			'saran1_2_status' => 'Saran1 2 Status',
			'saran1_2_desc' => 'Saran1 2 Desc',
			'saran1_3_status' => 'Saran1 3 Status',
			'saran1_3_desc' => 'Saran1 3 Desc',
			'saran2_status' => 'Saran2 Status',
			'saran2_desc' => 'Saran2 Desc',
			'saran3_status' => 'Saran3 Status',
			'saran3_desc' => 'Saran3 Desc',
			'saran3_1_desc' => 'Saran3 1 Desc',
			'saran3_2_desc' => 'Saran3 2 Desc',
			'saran3_3_desc' => 'Saran3 3 Desc',
			'saran3_3_1_status' => 'Saran3 3 1 Status',
			'saran3_3_1_desc' => 'Saran3 3 1 Desc',
			'saran3_3_2_status' => 'Saran3 3 2 Status',
			'saran3_3_2_desc' => 'Saran3 3 2 Desc',
			'saran3_3_3_status' => 'Saran3 3 3 Status',
			'saran3_3_3_desc' => 'Saran3 3 3 Desc',
			'saran3_3_4_status' => 'Saran3 3 4 Status',
			'saran3_3_4_desc' => 'Saran3 3 4 Desc',
			'saran3_4_desc' => 'Saran3 4 Desc',
			'saranperorangan' => 'Saranperorangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'keterangan_kesimpulanmcu' => 'Keterangan Kesimpulan Mcu',
			'nama_pemeriksa_kes' => 'Nama Dokter Saat di Rujuk',
                    'tglpengambilanhasil' => 'Tgl. Penyerahan',
                    'namapenerimahasil' => 'Nama Pengambil Hasil',
                    'notelppenerimahasil' => 'No. Telp Pengambil Hasil',
                    'namaygmenyerahkan' => 'Nama yang menyerahkan',
                    'ketpenyerahan' => 'Keterangan Pengambilan',
                    'alamat' => 'Alamat',
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

		if(!empty($this->kesimpulanmcu_id)){
			$criteria->addCondition('kesimpulanmcu_id = '.$this->kesimpulanmcu_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->permintaanmcu_id)){
			$criteria->addCondition('permintaanmcu_id = '.$this->permintaanmcu_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(tgl_kesimpulanmcu)',strtolower($this->tgl_kesimpulanmcu),true);
		$criteria->compare('LOWER(keterangan_kesimpulanmcu)',strtolower($this->keterangan_kesimpulanmcu),true);
		$criteria->compare('kesimpulan1_status',$this->kesimpulan1_status);
		$criteria->compare('LOWER(kesimpulan1_desc)',strtolower($this->kesimpulan1_desc),true);
		$criteria->compare('kesimpulan2_status',$this->kesimpulan2_status);
		$criteria->compare('LOWER(kesimpulan2_desc)',strtolower($this->kesimpulan2_desc),true);
		$criteria->compare('kesimpulan3_status',$this->kesimpulan3_status);
		$criteria->compare('LOWER(kesimpulan3_desc)',strtolower($this->kesimpulan3_desc),true);
		$criteria->compare('LOWER(kesimpulanperorangan)',strtolower($this->kesimpulanperorangan),true);
		$criteria->compare('saran1_status',$this->saran1_status);
		$criteria->compare('LOWER(saran1_desc)',strtolower($this->saran1_desc),true);
		$criteria->compare('saran1_1_status',$this->saran1_1_status);
		$criteria->compare('LOWER(saran1_1_desc)',strtolower($this->saran1_1_desc),true);
		$criteria->compare('saran1_2_status',$this->saran1_2_status);
		$criteria->compare('LOWER(saran1_2_desc)',strtolower($this->saran1_2_desc),true);
		$criteria->compare('saran1_3_status',$this->saran1_3_status);
		$criteria->compare('LOWER(saran1_3_desc)',strtolower($this->saran1_3_desc),true);
		$criteria->compare('saran2_status',$this->saran2_status);
		$criteria->compare('LOWER(saran2_desc)',strtolower($this->saran2_desc),true);
		$criteria->compare('saran3_status',$this->saran3_status);
		$criteria->compare('LOWER(saran3_desc)',strtolower($this->saran3_desc),true);
		$criteria->compare('LOWER(saran3_1_desc)',strtolower($this->saran3_1_desc),true);
		$criteria->compare('LOWER(saran3_2_desc)',strtolower($this->saran3_2_desc),true);
		$criteria->compare('LOWER(saran3_3_desc)',strtolower($this->saran3_3_desc),true);
		$criteria->compare('saran3_3_1_status',$this->saran3_3_1_status);
		$criteria->compare('LOWER(saran3_3_1_desc)',strtolower($this->saran3_3_1_desc),true);
		$criteria->compare('saran3_3_2_status',$this->saran3_3_2_status);
		$criteria->compare('LOWER(saran3_3_2_desc)',strtolower($this->saran3_3_2_desc),true);
		$criteria->compare('saran3_3_3_status',$this->saran3_3_3_status);
		$criteria->compare('LOWER(saran3_3_3_desc)',strtolower($this->saran3_3_3_desc),true);
		$criteria->compare('saran3_3_4_status',$this->saran3_3_4_status);
		$criteria->compare('LOWER(saran3_3_4_desc)',strtolower($this->saran3_3_4_desc),true);
		$criteria->compare('LOWER(saran3_4_desc)',strtolower($this->saran3_4_desc),true);
		$criteria->compare('LOWER(saranperorangan)',strtolower($this->saranperorangan),true);
		$criteria->compare('LOWER(nama_pemeriksa_kes)',strtolower($this->nama_pemeriksa_kes),true);
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