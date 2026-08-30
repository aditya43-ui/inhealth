<?php

/**
 * This is the model class for table "informasiantrian_v".
 *
 * The followings are the available columns in table 'informasiantrian_v':
 * @property integer $antrian_id
 * @property string $tglantrian
 * @property string $barcode
 * @property string $noantrian
 * @property boolean $panggil_flaq
 * @property string $tglpanggil
 * @property integer $modelantrian_id
 * @property string $modelantrisingkatan
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $no_urutantri
 * @property string $waktuspanggilpasien
 * @property string $waktumulaiperiksa
 * @property integer $pasienpulang_id
 * @property string $tglpasienpulang
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $ruangan_singkatan
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 */
class InformasiantrianV extends CActiveRecord
{

	public $tgl_awal,$tgl_akhir,$statuspasien,$nama_pasien,$noantrian, $noantrian1,$noantrian2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasiantrian_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('antrian_id, modelantrian_id, pendaftaran_id, pasienpulang_id, ruangan_id, pasien_id, carabayar_id, penjamin_id', 'numerical', 'integerOnly'=>true),
			array('noantrian, no_urutantri', 'length', 'max'=>6),
			array('modelantrisingkatan, no_rekam_medik', 'length', 'max'=>10),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('ruangan_nama, penjamin_nama', 'length', 'max'=>100),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('nama_pasien, carabayar_nama', 'length', 'max'=>50),
			array('tglantrian, barcode, panggil_flaq, tglpanggil, tgl_pendaftaran, waktupanggilpasien, waktumulaiperiksa, tglpasienpulang', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('antrian_id, tglantrian, barcode, noantrian, panggil_flaq, tglpanggil, modelantrian_id, modelantrisingkatan, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, no_urutantri, waktupanggilpasien, waktumulaiperiksa, pasienpulang_id, tglpasienpulang, ruangan_id, ruangan_nama, ruangan_singkatan, pasien_id, no_rekam_medik, nama_pasien, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama', 'safe', 'on'=>'search'),
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
			'pendaftaran'=>array(self::HAS_MANY, 'PendaftaranT','pendaftaran_id'),
			'antrian'=>array(self::HAS_MANY, 'AntrianT','antrian_id'),
			'pasien'=>array(self::HAS_MANY, 'PasienM','pasien_id'),
			'ruangan'=>array(self::HAS_MANY, 'RuanganM','ruangan_id'),
			'carabayar'=>array(self::HAS_MANY, 'CarabayarM ','carabayar_id'),
			'penjamin'=>array(self::HAS_MANY, 'PenjaminpasienM ','penjaminpasien_id'),
			'pasienpulang'=>array(self::HAS_MANY, 'PasienpulangT ','pasienpulang_id'),			
);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'antrian_id' => 'Antrian',
			'tglantrian' => 'Tgl Antrian',
			'barcode' => 'Barcode',
			'noantrian' => 'No Antrian',
			'panggil_flaq' => 'Panggil Flaq',
			'tglpanggil' => 'Tgl Panggil',
			'modelantrian_id' => 'Model Antrian',
			'modelantrisingkatan' => 'Modelantri Singkatan',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'no_urutantri' => 'No Urut Antri',
			'waktupanggilpasien' => 'Waktu panggil Pasien',
			'waktumulaiperiksa' => 'Waktu Mulai Periksa',
			'pasienpulang_id' => 'Pasien Pulang',
			'tglpasienpulang' => 'Tgl Pasien Pulang',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_singkatan' => 'Ruangan Singkatan',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'carabayar_id' => 'Carabayar',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('antrian_id',$this->antrian_id);
//		$criteria->addBetweenCondition('DATE(t.tglantrian)', $this->tgl_awal, $this->tgl_akhir);

		$criteria->compare('barcode',$this->barcode,true);

		if (!empty($this->noantrian1)){

			$criteria->addCondition(" (LOWER(modelantrisingkatan) ilike  '%".$this->modelantrisingkatan."%') OR (LOWER(noantrian) ilike '%".$this->noantrian."%') ");
       
			//$criteria->addCondition(" t.modelantrisingkatan = '" . $this->noantrian .  "'  ");		
		}


		if (!empty($this->noantrian2)){
			$criteria->addCondition(" (LOWER(ruangan_singkatan) ilike  '%".$this->ruangan_singkatan."%') OR (LOWER(noantrian) ilike '%".$this->noantrian."%') ");
      
		}
		$criteria->compare('panggil_flaq',$this->panggil_flaq);
		$criteria->compare('tglpanggil',$this->tglpanggil,true);
		$criteria->compare('modelantrian_id',$this->modelantrian_id);
		$criteria->compare('modelantrisingkatan',$this->modelantrisingkatan,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('no_urutantri',$this->no_urutantri,true);
		$criteria->compare('waktupanggilpasien',$this->waktupanggilpasien,true);
		$criteria->compare('waktumulaiperiksa',$this->waktumulaiperiksa,true);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('tglpasienpulang',$this->tglpasienpulang,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('ruangan_singkatan',$this->ruangan_singkatan,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('statuspasien',$this->statuspasien,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasiantrianV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
