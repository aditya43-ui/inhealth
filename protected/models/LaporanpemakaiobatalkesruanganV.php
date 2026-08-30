<?php

/**
 * This is the model class for table "laporanpemakaiobatalkesruangan_v".
 *
 * The followings are the available columns in table 'laporanpemakaiobatalkesruangan_v':
 * @property integer $obatalkes_id
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_nama
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property string $generik_nama
 * @property integer $sumberdana_id
 * @property string $sumberdana_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pemakaianobat_id
 * @property string $tglpemakaianobat
 * @property string $nopemakaian_obat
 * @property string $untukkeperluan_obat
 * @property string $ket_pemakaianobat
 * @property integer $pemakaianobatdetail_id
 * @property string $qty_satuanpakai
 * @property double $harga_satuanpakai
 * @property double $harganetto_satuanpakai
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $loginpemakai_id
 * @property string $nama_pemakai
 * @property string $create_time
 * @property string $update_time
 */
class LaporanpemakaiobatalkesruanganV extends CActiveRecord
{       public $tgl_awal, $bln_awal, $thn_awal;
	public $tgl_akhir, $bln_akhir, $thn_akhir;
        public $jns_periode, $tick, $data, $jumlah;
        public $carabayar_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpemakaiobatalkesruanganV the static model class
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
		return 'laporanpemakaiobatalkesruangan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, jenisobatalkes_id, satuankecil_id, sumberdana_id, instalasi_id, ruangan_id, pemakaianobat_id, pemakaianobatdetail_id, pegawai_id, gelarbelakang_id, loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('harga_satuanpakai, harganetto_satuanpakai', 'numerical'),
			array('jenisobatalkes_nama, obatalkes_golongan, obatalkes_kategori, satuankecil_nama, sumberdana_nama, instalasi_nama, ruangan_nama, nama_pegawai', 'length', 'max'=>50),
			array('obatalkes_kode, obatalkes_nama, untukkeperluan_obat', 'length', 'max'=>200),
			array('generik_nama', 'length', 'max'=>100),
			array('nopemakaian_obat, nama_pemakai', 'length', 'max'=>20),
			array('gelardepan', 'length', 'max'=>10),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('tglpemakaianobat, ket_pemakaianobat, qty_satuanpakai, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatalkes_id, jenisobatalkes_id, jenisobatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kode, obatalkes_nama, satuankecil_id, satuankecil_nama, generik_nama, sumberdana_id, sumberdana_nama, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, pemakaianobat_id, tglpemakaianobat, nopemakaian_obat, untukkeperluan_obat, ket_pemakaianobat, pemakaianobatdetail_id, qty_satuanpakai, harga_satuanpakai, harganetto_satuanpakai, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, loginpemakai_id, nama_pemakai, create_time, update_time', 'safe', 'on'=>'search'),
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
			'obatalkes_id' => 'Obat Alkes',
			'jenisobatalkes_id' => 'Jenis Obat Alkes',
			'jenisobatalkes_nama' => 'Jenis Obat Alkes',
			'obatalkes_golongan' => 'Golongan',
			'obatalkes_kategori' => 'Kategori',
			'obatalkes_kode' => 'Obat Alkes Kode',
			'obatalkes_nama' => 'Obat Alkes',
			'satuankecil_id' => 'Satuan Kecil',
			'satuankecil_nama' => 'Satuan Kecil',
			'generik_nama' => 'Generik Nama',
			'sumberdana_id' => 'Sumber Dana',
			'sumberdana_nama' => 'Sumber Dana',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'pemakaianobat_id' => 'Pemakaian Obat',
			'tglpemakaianobat' => 'Tgl. Pemakaian Obat',
			'nopemakaian_obat' => 'No Pemakaian Obat',
			'untukkeperluan_obat' => 'Untuk Keperluan Obat',
			'ket_pemakaianobat' => 'Ket Pemakaian Obat',
			'pemakaianobatdetail_id' => 'Pemakaian Obat Detail',
			'qty_satuanpakai' => 'Qty',
			'harga_satuanpakai' => 'Harga',
			'harganetto_satuanpakai' => 'Harganetto',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelar Depan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelar Belakang',
			'gelarbelakang_nama' => 'Gelar Belakang',
			'loginpemakai_id' => 'Login Pemakai',
			'nama_pemakai' => 'Nama Pemakai',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
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

		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('jenisobatalkes_nama',$this->jenisobatalkes_nama,true);
		$criteria->compare('obatalkes_golongan',$this->obatalkes_golongan,true);
		$criteria->compare('obatalkes_kategori',$this->obatalkes_kategori,true);
		$criteria->compare('obatalkes_kode',$this->obatalkes_kode,true);
		$criteria->compare('obatalkes_nama',$this->obatalkes_nama,true);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('satuankecil_nama',$this->satuankecil_nama,true);
		$criteria->compare('generik_nama',$this->generik_nama,true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('sumberdana_nama',$this->sumberdana_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('pemakaianobat_id',$this->pemakaianobat_id);
		$criteria->compare('tglpemakaianobat',$this->tglpemakaianobat,true);
		$criteria->compare('nopemakaian_obat',$this->nopemakaian_obat,true);
		$criteria->compare('untukkeperluan_obat',$this->untukkeperluan_obat,true);
		$criteria->compare('ket_pemakaianobat',$this->ket_pemakaianobat,true);
		$criteria->compare('pemakaianobatdetail_id',$this->pemakaianobatdetail_id);
		$criteria->compare('qty_satuanpakai',$this->qty_satuanpakai,true);
		$criteria->compare('harga_satuanpakai',$this->harga_satuanpakai);
		$criteria->compare('harganetto_satuanpakai',$this->harganetto_satuanpakai);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('nama_pemakai',$this->nama_pemakai,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getJenisobatalkesItems()
        {
            return JenisobatalkesM::model()->findAll("jenisobatalkes_aktif = TRUE ORDER BY jenisobatalkes_nama ASC");
        }
}