<?php

/**
 * This is the model class for table "laporanspmgizi_v".
 *
 * The followings are the available columns in table 'laporanspmgizi_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $kamarruangan_id
 * @property string $kamarruangan_nobed
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $no_pendaftaran
 * @property string $nama_pasien
 * @property string $tanggal_lahir
 * @property string $jenisdiet_nama
 */
class LaporanspmgiziV extends CActiveRecord
{
	public $tglpesanmenu, $tgl_awal, $tgl_akhir;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanspmgizi_v';
	}

	public function getNamaModel()
    {
        return __CLASS__;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, kelaspelayanan_id, kamarruangan_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('instalasi_nama, ruangan_nama, nama_pasien', 'length', 'max'=>100),
			array('kelaspelayanan_nama', 'length', 'max'=>50),
			array('kamarruangan_nobed, no_rekam_medik', 'length', 'max'=>10),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('jenisdiet_nama', 'length', 'max'=>96),
			array('tanggal_lahir', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, kelaspelayanan_id, kelaspelayanan_nama, kamarruangan_id, kamarruangan_nobed, pasien_id, no_rekam_medik, no_pendaftaran, nama_pasien, tanggal_lahir, jenisdiet_nama', 'safe', 'on'=>'search'),
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
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'kamarruangan_id' => 'Kamarruangan',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'no_pendaftaran' => 'No Pendaftaran',
			'nama_pasien' => 'Nama Pasien',
			'tanggal_lahir' => 'Tanggal Lahir',
			'jenisdiet_nama' => 'Jenisdiet Nama',
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

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('jenisdiet_nama',$this->jenisdiet_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchTable()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('jenisdiet_nama',$this->jenisdiet_nama,true);
		$criteria->order = "CAST(SUBSTRING(kamarruangan_nobed FROM '\\d+') AS integer)";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	function getJumlahPasienPesan() {
		$criteria = new CDbCriteria();
		$criteria->join = 'LEFT JOIN pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id '
							. 'LEFT JOIN pasienadmisi_t pa on pa.pasienadmisi_id = p.pasienadmisi_id';
		if(!empty($this->ruangan_id)) {
			$criteria->addCondition('t.ruangan_id=' . $this->ruangan_id);
		}
		if(!empty($this->kelaspelayanan_id)) {
			$criteria->addCondition('pa.kelaspelayanan_id=' . $this->kelaspelayanan_id);
		}

		$criteria->addCondition("date(t.tglpesanmenu) = '" . $this->tglpesanmenu . "'");
		// var_dump($criteria);
		return $modPesan = PesanmenudietT::model()->findAll($criteria);
	}

	function getJumlahPasienPesanToday() {
		$criteria = new CDbCriteria();
		
		if(!empty($this->ruangan_id)) {
			$criteria->addCondition('t.ruangan_id=' . $this->ruangan_id);
		}
		if(!empty($this->kelaspelayanan_id)) {
			$criteria->addCondition('t.kelaspelayanan_id=' . $this->kelaspelayanan_id);
		}

		$criteria->addCondition("pasien_id is not null");
		// var_dump($criteria);
		return $modPesan = self::model()->findAll($criteria);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LaporanspmgiziV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
