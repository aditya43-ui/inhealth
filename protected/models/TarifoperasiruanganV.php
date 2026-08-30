<?php

/**
 * This is the model class for table "tarifoperasiruangan_v".
 *
 * The followings are the available columns in table 'tarifoperasiruangan_v':
 * @property integer $kegiatanoperasi_id
 * @property string $kegiatanoperasi_kode
 * @property string $kegiatanoperasi_nama
 * @property integer $operasi_id
 * @property string $operasi_kode
 * @property string $operasi_nama
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property integer $komponenunit_id
 * @property string $komponenunit_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $tindakanmedis_nama
 * @property string $daftartindakan_katakunci
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $jenistarif_id
 * @property string $jenistarif_nama
 * @property integer $perdatarif_id
 * @property string $perdanama_sk
 * @property string $noperda
 * @property string $tglperda
 * @property string $perdatentang
 * @property string $ditetapkanoleh
 * @property string $tempatditetapkan
 * @property double $hargaoperasi
 * @property double $hargaoperasidenganpenyulit
 */
class TarifoperasiruanganV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarifoperasiruanganV the static model class
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
		return 'tarifoperasiruangan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kegiatanoperasi_id, operasi_id, kategoritindakan_id, kelompoktindakan_id, komponenunit_id, daftartindakan_id, instalasi_id, ruangan_id, kelaspelayanan_id, carabayar_id, penjamin_id, jenistarif_id, perdatarif_id', 'numerical', 'integerOnly'=>true),
			array('hargaoperasi, hargaoperasidenganpenyulit', 'numerical'),
			array('kegiatanoperasi_kode, operasi_kode, daftartindakan_kode, noperda', 'length', 'max'=>20),
			array('kegiatanoperasi_nama', 'length', 'max'=>100),
			array('operasi_nama, daftartindakan_nama, tindakanmedis_nama, perdanama_sk', 'length', 'max'=>200),
			array('kategoritindakan_nama', 'length', 'max'=>150),
			array('kelompoktindakan_nama, instalasi_nama, ruangan_nama, kelaspelayanan_nama, carabayar_nama, penjamin_nama', 'length', 'max'=>50),
			array('komponenunit_nama, daftartindakan_katakunci, ditetapkanoleh, tempatditetapkan', 'length', 'max'=>30),
			array('jenistarif_nama', 'length', 'max'=>25),
			array('tglperda, perdatentang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kegiatanoperasi_id, kegiatanoperasi_kode, kegiatanoperasi_nama, operasi_id, operasi_kode, operasi_nama, kategoritindakan_id, kategoritindakan_nama, kelompoktindakan_id, kelompoktindakan_nama, komponenunit_id, komponenunit_nama, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, tindakanmedis_nama, daftartindakan_katakunci, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, kelaspelayanan_id, kelaspelayanan_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, jenistarif_id, jenistarif_nama, perdatarif_id, perdanama_sk, noperda, tglperda, perdatentang, ditetapkanoleh, tempatditetapkan, hargaoperasi, hargaoperasidenganpenyulit', 'safe', 'on'=>'search'),
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
			'kegiatanoperasi_id' => 'Kegiatan Operasi',
			'kegiatanoperasi_kode' => 'Kegiatan Operasi Kode',
			'kegiatanoperasi_nama' => 'Kegiatan Operasi',
			'operasi_id' => 'Operasi',
			'operasi_kode' => 'Operasi Kode',
			'operasi_nama' => 'Operasi Nama',
			'kategoritindakan_id' => 'Kategori Tindakan',
			'kategoritindakan_nama' => 'Kategoritindakan Nama',
			'kelompoktindakan_id' => 'Kelompoktindakan',
			'kelompoktindakan_nama' => 'Kelompoktindakan Nama',
			'komponenunit_id' => 'Komponenunit',
			'komponenunit_nama' => 'Komponenunit Nama',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'tindakanmedis_nama' => 'Tindakanmedis Nama',
			'daftartindakan_katakunci' => 'Daftartindakan Katakunci',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'jenistarif_id' => 'Jenistarif',
			'jenistarif_nama' => 'Jenistarif Nama',
			'perdatarif_id' => 'Perdatarif',
			'perdanama_sk' => 'Perdanama Sk',
			'noperda' => 'Noperda',
			'tglperda' => 'Tglperda',
			'perdatentang' => 'Perdatentang',
			'ditetapkanoleh' => 'Ditetapkanoleh',
			'tempatditetapkan' => 'Tempatditetapkan',
			'hargaoperasi' => 'Hargaoperasi',
			'hargaoperasidenganpenyulit' => 'Hargaoperasidenganpenyulit',
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

		$criteria->compare('kegiatanoperasi_id',$this->kegiatanoperasi_id);
		$criteria->compare('kegiatanoperasi_kode',$this->kegiatanoperasi_kode,true);
		$criteria->compare('kegiatanoperasi_nama',$this->kegiatanoperasi_nama,true);
		$criteria->compare('operasi_id',$this->operasi_id);
		$criteria->compare('operasi_kode',$this->operasi_kode,true);
		$criteria->compare('operasi_nama',$this->operasi_nama,true);
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('kategoritindakan_nama',$this->kategoritindakan_nama,true);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('kelompoktindakan_nama',$this->kelompoktindakan_nama,true);
		$criteria->compare('komponenunit_id',$this->komponenunit_id);
		$criteria->compare('komponenunit_nama',$this->komponenunit_nama,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('tindakanmedis_nama',$this->tindakanmedis_nama,true);
		$criteria->compare('daftartindakan_katakunci',$this->daftartindakan_katakunci,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('jenistarif_nama',$this->jenistarif_nama,true);
		$criteria->compare('perdatarif_id',$this->perdatarif_id);
		$criteria->compare('perdanama_sk',$this->perdanama_sk,true);
		$criteria->compare('noperda',$this->noperda,true);
		$criteria->compare('tglperda',$this->tglperda,true);
		$criteria->compare('perdatentang',$this->perdatentang,true);
		$criteria->compare('ditetapkanoleh',$this->ditetapkanoleh,true);
		$criteria->compare('tempatditetapkan',$this->tempatditetapkan,true);
		$criteria->compare('hargaoperasi',$this->hargaoperasi);
		$criteria->compare('hargaoperasidenganpenyulit',$this->hargaoperasidenganpenyulit);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}