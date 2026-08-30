<?php

/**
 * This is the model class for table "informasipesanobatalkes_v".
 *
 * The followings are the available columns in table 'informasipesanobatalkes_v':
 * @property integer $pesanobatalkes_id
 * @property string $tglpemesanan
 * @property string $nopemesanan
 * @property integer $mutasioaruangan_id
 * @property string $tglmutasioa
 * @property string $nomutasioa
 * @property string $statuspesan
 * @property string $tglmintadikirim
 * @property string $keterangan_pesan
 * @property integer $instalasipemesan_id
 * @property string $instalasipemesan_nama
 * @property integer $ruanganpemesan_id
 * @property string $ruanganpemesan_nama
 * @property integer $instalasitujuan_id
 * @property string $instalasitujuan_nama
 * @property integer $ruangantujuan_id
 * @property string $ruangantujuan_nama
 * @property integer $pegawaipemesan_id
 * @property string $pegawaipemesan_gelardepan
 * @property string $pegawaipemesan_nama
 * @property string $pegawaipemesan_gelarbelakang
 * @property integer $pegawaimengetahui_id
 * @property string $pegawaimengetahui_gelardepan
 * @property string $pegawaimengetahui_nama
 * @property string $pegawaimengetahui_gelarbelakang
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $terimamutasi_id
 * @property string $tglterima
 * @property string $noterimamutasi
 */
class InformasipesanobatalkesV extends CActiveRecord
{
        public $statusmutasi;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipesanobatalkesV the static model class
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
		return 'informasipesanobatalkes_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pesanobatalkes_id, mutasioaruangan_id, instalasipemesan_id, ruanganpemesan_id, instalasitujuan_id, ruangantujuan_id, pegawaipemesan_id, pegawaimengetahui_id,terimamutasi_id', 'numerical', 'integerOnly'=>true),
			array('nopemesanan, instalasipemesan_nama, ruanganpemesan_nama, instalasitujuan_nama, ruangantujuan_nama, pegawaipemesan_nama, pegawaimengetahui_nama', 'length', 'max'=>50),
			array('nomutasioa,noterimamutasi', 'length', 'max'=>20),
			array('statuspesan', 'length', 'max'=>30),
			array('pegawaipemesan_gelardepan, pegawaimengetahui_gelardepan', 'length', 'max'=>10),
			array('pegawaipemesan_gelarbelakang, pegawaimengetahui_gelarbelakang', 'length', 'max'=>15),
			array('tglpemesanan, tglmutasioa, tglmintadikirim, keterangan_pesan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan,tglterima', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesanobatalkes_id, tglpemesanan, nopemesanan, mutasioaruangan_id, tglmutasioa, nomutasioa, statuspesan, tglmintadikirim, keterangan_pesan, instalasipemesan_id, instalasipemesan_nama, ruanganpemesan_id, ruanganpemesan_nama, instalasitujuan_id, instalasitujuan_nama, ruangantujuan_id, ruangantujuan_nama, pegawaipemesan_id, pegawaipemesan_gelardepan, pegawaipemesan_nama, pegawaipemesan_gelarbelakang, pegawaimengetahui_id, pegawaimengetahui_gelardepan, pegawaimengetahui_nama, pegawaimengetahui_gelarbelakang, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan,terimamutasi_id,tglterima,noterimamutasi', 'safe', 'on'=>'search'),
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
			'pesanobatalkes_id' => 'Pesan Obat Alkes',
			'tglpemesanan' => 'Tanggal Pemesanan',
			'nopemesanan' => 'No. Pemesanan',
			'mutasioaruangan_id' => 'Mutasi Ruangan',
			'tglmutasioa' => 'Tanggal Mutasi',
			'nomutasioa' => 'No. Mutasi',
			'statuspesan' => 'Status Pesan',
			'tglmintadikirim' => 'Tanggal Minta Dikirim',
			'keterangan_pesan' => 'Keterangan Pesan',
			'instalasipemesan_id' => 'Instalasi Pemesanan',
			'instalasipemesan_nama' => 'Instalasi Pemesanan',
			'ruanganpemesan_id' => 'Ruangan Pemesanan',
			'ruanganpemesan_nama' => 'Ruangan Pemesanan',
			'instalasitujuan_id' => 'Instalasi Tujuan',
			'instalasitujuan_nama' => 'Instalasi Tujuan',
			'ruangantujuan_id' => 'Ruangan Tujuan',
			'ruangantujuan_nama' => 'Ruangan Tujuan',
			'pegawaipemesan_id' => 'Pegawai Pemesan',
			'pegawaipemesan_gelardepan' => 'Gelar Depan',
			'pegawaipemesan_nama' => 'Nama Pegawai Pemesan',
			'pegawaipemesan_gelarbelakang' => 'Gelar Belakang',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
			'pegawaimengetahui_gelardepan' => 'Gelar Depan',
			'pegawaimengetahui_nama' => 'Nama Pegawai Mengetahui',
			'pegawaimengetahui_gelarbelakang' => 'Gelar Belakang',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'statusmutasi' => 'Status Mutasi',
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

		$criteria->compare('pesanobatalkes_id',$this->pesanobatalkes_id);
		$criteria->compare('tglpemesanan',$this->tglpemesanan,true);
		$criteria->compare('nopemesanan',$this->nopemesanan,true);
		$criteria->compare('mutasioaruangan_id',$this->mutasioaruangan_id);
		$criteria->compare('tglmutasioa',$this->tglmutasioa,true);
		$criteria->compare('nomutasioa',$this->nomutasioa,true);
		$criteria->compare('statuspesan',$this->statuspesan,true);
		$criteria->compare('tglmintadikirim',$this->tglmintadikirim,true);
		$criteria->compare('keterangan_pesan',$this->keterangan_pesan,true);
		$criteria->compare('instalasipemesan_id',$this->instalasipemesan_id);
		$criteria->compare('instalasipemesan_nama',$this->instalasipemesan_nama,true);
		$criteria->compare('ruanganpemesan_id',$this->ruanganpemesan_id);
		$criteria->compare('ruanganpemesan_nama',$this->ruanganpemesan_nama,true);
		$criteria->compare('instalasitujuan_id',$this->instalasitujuan_id);
		$criteria->compare('instalasitujuan_nama',$this->instalasitujuan_nama,true);
		$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
		$criteria->compare('ruangantujuan_nama',$this->ruangantujuan_nama,true);
		$criteria->compare('pegawaipemesan_id',$this->pegawaipemesan_id);
		$criteria->compare('pegawaipemesan_gelardepan',$this->pegawaipemesan_gelardepan,true);
		$criteria->compare('pegawaipemesan_nama',$this->pegawaipemesan_nama,true);
		$criteria->compare('pegawaipemesan_gelarbelakang',$this->pegawaipemesan_gelarbelakang,true);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('pegawaimengetahui_gelardepan',$this->pegawaimengetahui_gelardepan,true);
		$criteria->compare('pegawaimengetahui_nama',$this->pegawaimengetahui_nama,true);
		$criteria->compare('pegawaimengetahui_gelarbelakang',$this->pegawaimengetahui_gelarbelakang,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
                $criteria->compare('terimamutasi_id',$this->terimamutasi_id);
		$criteria->compare('tglterima',$this->tglterima,true);
		$criteria->compare('noterimamutasi',$this->noterimamutasi,true);
                $criteria->order = "tglpemesanan DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}