<?php

/**
 * This is the model class for table "laporantransaksipetugas_v".
 *
 * The followings are the available columns in table 'laporantransaksipetugas_v':
 * @property string $create_time
 * @property string $nama_pasien
 * @property integer $pendaftaran_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property integer $qty_tindakan
 * @property string $nama_pegawai
 */
class LaporantransaksipetugasV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $tgl_awal, $tgl_akhir, $ruangan_nama;

	public function tableName()
	{
		return 'laporantransaksipetugas_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, qty_tindakan, carabayar_id', 'numerical', 'integerOnly'=>true),
			array('nama_pasien', 'length', 'max'=>100),
			array('daftartindakan_kode', 'length', 'max'=>20),
			array('daftartindakan_nama', 'length', 'max'=>400),
			array('nama_pegawai', 'length', 'max'=>50),
			array('create_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('create_time, nama_pasien, pendaftaran_id, daftartindakan_kode, daftartindakan_nama, qty_tindakan, nama_pegawai', 'safe', 'on'=>'search'),
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
			'create_time' => 'Create Time',
			'nama_pasien' => 'Nama Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'qty_tindakan' => 'Qty Tindakan',
			'nama_pegawai' => 'Petugas',
			'carabayar_id' => 'Jenis Penjamin',
			'pegawai_id' => 'Petugas',
			'create_ruangan' => 'UPF'
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

		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function crit() {

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(t.create_time)', $this->tgl_awal, $this->tgl_akhir);

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('lower(nama_pegawai)', strtolower($this->nama_pegawai),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->addCondition('isverifbatal is false');

		return $criteria;

	}

	// pencarian dengan tanggal date time
	public function crit2() {

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('t.create_time', $this->tgl_awal, $this->tgl_akhir);

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('lower(nama_pegawai)', strtolower($this->nama_pegawai),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);


		return $criteria;

	}

	public function searchLaporan()
	{
		$criteria=$this->crit();

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchLaporanFarmasi()
	{
		$criteria=$this->crit();
		$criteria->compare('daftartindakan_kode', 'OBT', true) ;
		$criteria->addCondition('isverifbatal = false');
		$criteria->addCondition('pegawai_id =' . Yii::app()->user->getState('pegawai_id'));
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchLaporanPrint()
	{
		$criteria=$this->crit();

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

	public function searchLaporanPrintFarmasi()
	{
		$criteria=$this->crit();
		$criteria->compare('daftartindakan_kode', 'OBT', true) ;
		$criteria->addCondition('isverifbatal = false');
		$criteria->addCondition('pegawai_id =' . Yii::app()->user->getState('pegawai_id'));
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

	// per UPF
	public function searchLaporanFarmasiPerUPF()
	{
		$criteria=$this->crit2();
		$criteria->compare('daftartindakan_kode', 'OBT', true) ;
		$criteria->addCondition('verifbataltindakan_id is null');
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->addCondition('create_ruangan =' . Yii::app()->user->getState('ruangan_id'));
		if(!empty($this->pegawai_id)) {
			$criteria->addCondition('pegawai_id =' . $this->pegawai_id);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchLaporanPrintFarmasiPerUPF()
	{
		$prov = $this->searchLaporanFarmasiPerUPF();
		$prov->pagination = false;

		return $prov;
	}


	// seluruh UPF
	// per UPF
	public function searchLaporanFarmasiSeluruhUPF()
	{
		$criteria=$this->crit2();
		$criteria->compare('daftartindakan_kode', 'OBT', true) ;
		$criteria->addCondition('verifbataltindakan_id is null');
		$criteria->compare('carabayar_id', $this->carabayar_id);
		if(!empty($this->pegawai_id)) {
			$criteria->addCondition('pegawai_id =' . $this->pegawai_id);
		}
		if(!empty($this->create_ruangan)) {
			$criteria->addCondition('create_ruangan =' . $this->create_ruangan);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchLaporanPrintFarmasiSeluruhUPF()
	{
		$prov = $this->searchLaporanFarmasiSeluruhUPF();
		$prov->pagination = false;

		return $prov;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LaporantransaksipetugasV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	function getPegawaiFarmasi() {
		$criteria = new CDbCriteria();
		$criteria->addCondition('pegawai_aktif is true');
		$criteria->addInCondition('kelompokpegawai_id', [Params::KELOMPOKPEGAWAI_ID_TENAGA_NONKEPERAWATAN]);
		return PegawaiM::model()->findAll($criteria);
	}
}
