<?php

/**
 * This is the model class for table "informasirencanakebutuhanfarmasi_v".
 *
 * The followings are the available columns in table 'informasirencanakebutuhanfarmasi_v':
 * @property integer $rencanakebfarmasi_id
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pegawai_id
 * @property string $pegawai_gelardepan
 * @property string $pegawai_nama
 * @property string $pegawai_gelarbelakang
 * @property integer $otorisasipimpinan_id
 * @property string $tglotorisasipimpinan
 * @property string $nootorisasipimpinan
 * @property string $otorisasiolehpimpinan
 * @property string $jabatanpimpinan
 * @property boolean $isverifikasipimpinan
 * @property integer $otorisasikeuangan_id
 * @property string $tglotorisasikeuangan
 * @property string $nootorisasikeuangan
 * @property string $otorisasiolehkeuangan
 * @property string $jabatankeuangan
 * @property boolean $isverifikasikeuangan
 * @property string $tglperencanaan
 * @property string $noperencnaan
 * @property integer $pegawaimengetahui_id
 * @property string $pegawaimengetahui_gelardepan
 * @property string $pegawaimengetahui_nama
 * @property string $pegawaimengetahui_gelarbelakang
 * @property integer $pegawaimenyetujui_id
 * @property string $pegawaimenyetujui_gelardepan
 * @property string $pegawaimenyetujui_nama
 * @property string $pegawaimenyetujui_gelarbelakang
 * @property string $statusrencana
 */
class InformasirencanakebutuhanfarmasiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasirencanakebutuhanfarmasiV the static model class
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
		return 'informasirencanakebutuhanfarmasi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rencanakebfarmasi_id, instalasi_id, ruangan_id, pegawai_id, otorisasipimpinan_id, otorisasikeuangan_id, pegawaimengetahui_id, pegawaimenyetujui_id, sumberdana_id', 'numerical', 'integerOnly'=>true),
			array('instalasi_nama, ruangan_nama, pegawai_nama, nootorisasipimpinan, nootorisasikeuangan, noperencnaan, pegawaimengetahui_nama, pegawaimenyetujui_nama', 'length', 'max'=>50),
			array('pegawai_gelardepan, pegawaimengetahui_gelardepan, pegawaimenyetujui_gelardepan', 'length', 'max'=>10),
			array('pegawai_gelarbelakang, pegawaimengetahui_gelarbelakang, pegawaimenyetujui_gelarbelakang', 'length', 'max'=>15),
			array('otorisasiolehpimpinan, jabatanpimpinan, otorisasiolehkeuangan, jabatankeuangan', 'length', 'max'=>100),
			array('statusrencana', 'length', 'max'=>20),
                        array('sumberdana_nama', 'length', 'max'=>50),
                    
			array('tglotorisasipimpinan, isverifikasipimpinan, tglotorisasikeuangan, isverifikasikeuangan, tglperencanaan, sumberdana_id, sumberdana_nama', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanakebfarmasi_id, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, pegawai_id, pegawai_gelardepan, pegawai_nama, pegawai_gelarbelakang, otorisasipimpinan_id, tglotorisasipimpinan, nootorisasipimpinan, otorisasiolehpimpinan, jabatanpimpinan, isverifikasipimpinan, otorisasikeuangan_id, tglotorisasikeuangan, nootorisasikeuangan, otorisasiolehkeuangan, jabatankeuangan, isverifikasikeuangan, tglperencanaan, noperencnaan, pegawaimengetahui_id, pegawaimengetahui_gelardepan, pegawaimengetahui_nama, pegawaimengetahui_gelarbelakang, pegawaimenyetujui_id, pegawaimenyetujui_gelardepan, pegawaimenyetujui_nama, pegawaimenyetujui_gelarbelakang, statusrencana, sumberdana_id, sumberdana_nama', 'safe', 'on'=>'search'),
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
			'rencanakebfarmasi' => array(self::BELONGS_TO, 'GFRencanaKebFarmasiT', 'rencanakebfarmasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanakebfarmasi_id' => 'Rencana Keb. Farmasi',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'pegawai_id' => 'Pegawai',
			'pegawai_gelardepan' => 'Gelar Depan',
			'pegawai_nama' => 'Nama Pegawai',
			'pegawai_gelarbelakang' => 'Gelar Belakang',
			'otorisasipimpinan_id' => 'Otorisasipimpinan',
			'tglotorisasipimpinan' => 'Tglotorisasipimpinan',
			'nootorisasipimpinan' => 'Nootorisasipimpinan',
			'otorisasiolehpimpinan' => 'Otorisasiolehpimpinan',
			'jabatanpimpinan' => 'Jabatanpimpinan',
			'isverifikasipimpinan' => 'Isverifikasipimpinan',
			'otorisasikeuangan_id' => 'Otorisasikeuangan',
			'tglotorisasikeuangan' => 'Tglotorisasikeuangan',
			'nootorisasikeuangan' => 'Nootorisasikeuangan',
			'otorisasiolehkeuangan' => 'Otorisasiolehkeuangan',
			'jabatankeuangan' => 'Jabatankeuangan',
			'isverifikasikeuangan' => 'Isverifikasikeuangan',
			'tglperencanaan' => 'Tanggal Rencana',
			'noperencnaan' => 'No. Rencana',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
			'pegawaimengetahui_gelardepan' => 'Pegawaimengetahui Gelardepan',
			'pegawaimengetahui_nama' => 'Pegawaimengetahui Nama',
			'pegawaimengetahui_gelarbelakang' => 'Pegawaimengetahui Gelarbelakang',
			'pegawaimenyetujui_id' => 'Pegawai Menyetujui',
			'pegawaimenyetujui_gelardepan' => 'Pegawaimenyetujui Gelardepan',
			'pegawaimenyetujui_nama' => 'Pegawaimenyetujui Nama',
			'pegawaimenyetujui_gelarbelakang' => 'Pegawaimenyetujui Gelarbelakang',
			'statusrencana' => 'Status Rencana',
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

		$criteria->compare('rencanakebfarmasi_id',$this->rencanakebfarmasi_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pegawai_gelardepan',$this->pegawai_gelardepan,true);
		$criteria->compare('pegawai_nama',$this->pegawai_nama,true);
		$criteria->compare('pegawai_gelarbelakang',$this->pegawai_gelarbelakang,true);
		$criteria->compare('otorisasipimpinan_id',$this->otorisasipimpinan_id);
		$criteria->compare('tglotorisasipimpinan',$this->tglotorisasipimpinan,true);
		$criteria->compare('nootorisasipimpinan',$this->nootorisasipimpinan,true);
		$criteria->compare('otorisasiolehpimpinan',$this->otorisasiolehpimpinan,true);
		$criteria->compare('jabatanpimpinan',$this->jabatanpimpinan,true);
		$criteria->compare('isverifikasipimpinan',$this->isverifikasipimpinan);
		$criteria->compare('otorisasikeuangan_id',$this->otorisasikeuangan_id);
		$criteria->compare('tglotorisasikeuangan',$this->tglotorisasikeuangan,true);
		$criteria->compare('nootorisasikeuangan',$this->nootorisasikeuangan,true);
		$criteria->compare('otorisasiolehkeuangan',$this->otorisasiolehkeuangan,true);
		$criteria->compare('jabatankeuangan',$this->jabatankeuangan,true);
		$criteria->compare('isverifikasikeuangan',$this->isverifikasikeuangan);
		$criteria->compare('tglperencanaan',$this->tglperencanaan,true);
		$criteria->compare('noperencnaan',$this->noperencnaan,true);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('pegawaimengetahui_gelardepan',$this->pegawaimengetahui_gelardepan,true);
		$criteria->compare('pegawaimengetahui_nama',$this->pegawaimengetahui_nama,true);
		$criteria->compare('pegawaimengetahui_gelarbelakang',$this->pegawaimengetahui_gelarbelakang,true);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('pegawaimenyetujui_gelardepan',$this->pegawaimenyetujui_gelardepan,true);
		$criteria->compare('pegawaimenyetujui_nama',$this->pegawaimenyetujui_nama,true);
		$criteria->compare('pegawaimenyetujui_gelarbelakang',$this->pegawaimenyetujui_gelarbelakang,true);
		$criteria->compare('statusrencana',$this->statusrencana,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}