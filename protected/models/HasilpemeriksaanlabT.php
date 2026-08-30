<?php

/**
 * This is the model class for table "hasilpemeriksaanlab_t".
 *
 * The followings are the available columns in table 'hasilpemeriksaanlab_t':
 * @property integer $hasilpemeriksaanlab_id
 * @property integer $pendaftaran_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property string $nohasilperiksalab
 * @property string $tglhasilpemeriksaanlab
 * @property string $tglpengambilanhasil
 * @property string $hasil_kelompokumur
 * @property string $hasil_jeniskelamin
 * @property string $statusperiksahasil
 * @property string $catatanlabklinik
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $kesimpulan
 */
class HasilpemeriksaanlabT extends CActiveRecord
{
    public $pemeriksaanlab_nama, $hasilpemeriksaan;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilpemeriksaanlabT the static model class
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
		return 'hasilpemeriksaanlab_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasienmasukpenunjang_id, pasien_id, nohasilperiksalab, tglhasilpemeriksaanlab, hasil_kelompokumur, hasil_jeniskelamin, statusperiksahasil', 'required'),
			array('pendaftaran_id, pasienmasukpenunjang_id, pasien_id, pasienadmisi_id', 'numerical', 'integerOnly'=>true),
			array('nohasilperiksalab', 'length', 'max'=>20),
			array('hasil_kelompokumur, hasil_jeniskelamin, statusperiksahasil', 'length', 'max'=>50),
			array('diagnosaket_klinik, tglpengambilanhasil, catatanlabklinik, update_time, update_loginpemakai_id, kesimpulan, namapenerimahasil, notelppenerimahasil, namaygmenyerahkan, ketpenyerahan, jenisidentitas, no_identitas, alamat, statushasilpemeriksaan', 'safe'),
                    
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			array('hasilpemeriksaanlab_id, pendaftaran_id, pasienmasukpenunjang_id, pasien_id, pasienadmisi_id, nohasilperiksalab, tglhasilpemeriksaanlab, tglpengambilanhasil, hasil_kelompokumur, hasil_jeniskelamin, statusperiksahasil, catatanlabklinik, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, kesimpulan, namapenerimahasil, notelppenerimahasil, namaygmenyerahkan, ketpenyerahan, jenisidentitas, no_identitas, alamat', 'safe', 'on'=>'search'),
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
                    'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
                    'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
                    'pasienmasukpenunjang'=>array(self::BELONGS_TO,'PasienmasukpenunjangT','pasienmasukpenunjang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hasilpemeriksaanlab_id' => 'Hasil Pemeriksaan Lab',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienmasukpenunjang_id' => 'Pasien Masuk Penunjang',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasien Admisi',
			'nohasilperiksalab' => 'No. Hasil Periksa Lab',
			'tglhasilpemeriksaanlab' => 'Tanggal Pemeriksaan',
			'tglpengambilanhasil' => 'Tanggal Pengambilan hasil',
			'hasil_kelompokumur' => 'Hasil Kelompok Umur',
			'hasil_jeniskelamin' => 'Hasil Jenis kelamin',
			'statusperiksahasil' => 'Status Periksa Hasil',
			'catatanlabklinik' => 'Keterangan',
			'kesimpulan' => 'Kesimpulan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'diagnosaket_klinik' => 'Diagnosa/Keterangan Klinik',
			'namapenerimahasil' => 'Nama Pengambil Hasil',
			'notelppenerimahasil' => 'No. Telp Pengambil Hasil',
			'ketpenyerahan' => 'Keterangan Pengambilan',
			'namaygmenyerahkan' => 'Nama yg menyerahkan',
			'alamat'=>'Alamat',
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

		$criteria->compare('hasilpemeriksaanlab_id',$this->hasilpemeriksaanlab_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(nohasilperiksalab)',strtolower($this->nohasilperiksalab),true);
		$criteria->compare('LOWER(tglhasilpemeriksaanlab)',strtolower($this->tglhasilpemeriksaanlab),true);
		$criteria->compare('LOWER(tglpengambilanhasil)',strtolower($this->tglpengambilanhasil),true);
		$criteria->compare('LOWER(hasil_kelompokumur)',strtolower($this->hasil_kelompokumur),true);
		$criteria->compare('LOWER(hasil_jeniskelamin)',strtolower($this->hasil_jeniskelamin),true);
		$criteria->compare('LOWER(statusperiksahasil)',strtolower($this->statusperiksahasil),true);
		$criteria->compare('LOWER(catatanlabklinik)',strtolower($this->catatanlabklinik),true);
		$criteria->compare('LOWER(kesimpulan)',strtolower($this->kesimpulan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('hasilpemeriksaanlab_id',$this->hasilpemeriksaanlab_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(nohasilperiksalab)',strtolower($this->nohasilperiksalab),true);
		$criteria->compare('LOWER(tglhasilpemeriksaanlab)',strtolower($this->tglhasilpemeriksaanlab),true);
		$criteria->compare('LOWER(tglpengambilanhasil)',strtolower($this->tglpengambilanhasil),true);
		$criteria->compare('LOWER(hasil_kelompokumur)',strtolower($this->hasil_kelompokumur),true);
		$criteria->compare('LOWER(hasil_jeniskelamin)',strtolower($this->hasil_jeniskelamin),true);
		$criteria->compare('LOWER(statusperiksahasil)',strtolower($this->statusperiksahasil),true);
		$criteria->compare('LOWER(catatanlabklinik)',strtolower($this->catatanlabklinik),true);
		$criteria->compare('LOWER(kesimpulan)',strtolower($this->kesimpulan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
      
        
    public function searchRiwayatPasien($pasien_id) {
        $criteria = new CDbCriteria;
        $criteria->select = 'p.pemeriksaanlab_kode, p.pemeriksaanlab_nama, t.tglhasilpemeriksaanlab, d.hasilpemeriksaan';
        $criteria->group = "p.pemeriksaanlab_kode, p.pemeriksaanlab_nama, t.tglhasilpemeriksaanlab, d.hasilpemeriksaan";
        $criteria->join = "JOIN detailhasilpemeriksaanlab_t AS d ON t.hasilpemeriksaanlab_id = d.hasilpemeriksaanlab_id"
                . " JOIN pemeriksaanlab_m AS p ON d.pemeriksaanlab_id = p.pemeriksaanlab_id";
        $criteria->addCondition('t.pasien_id = '.$pasien_id);
        $criteria->order = "p.pemeriksaanlab_kode, t.tglhasilpemeriksaanlab ASC";
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

}