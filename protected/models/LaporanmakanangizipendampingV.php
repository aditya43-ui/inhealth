<?php

/**
 * This is the model class for table "laporanmakanangizipendamping_v".
 *
 * The followings are the available columns in table 'laporanmakanangizipendamping_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $jeniskelamin
 * @property string $alamat_pegawai
 * @property integer $kirimmenudiet_id
 * @property string $tglkirimmenu
 * @property string $jenispesanmenu
 * @property string $keterangan_kirim
 * @property integer $jenisdiet_id
 * @property string $jenisdiet_nama
 * @property integer $menudiet_id
 * @property double $jml_kirim
 * @property string $satuanjml_urt
 * @property integer $jeniswaktu_id
 * @property string $jeniswaktu_nama
 * @property string $menudiet_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $ruangan_lokasi
 * @property string $jeniswaktu_jam
 */
class LaporanmakanangizipendampingV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanmakanangizipendampingV the static model class
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
		return 'laporanmakanangizipendamping_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, kirimmenudiet_id, jenisdiet_id, menudiet_id, jeniswaktu_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('jml_kirim', 'numerical'),
			array('nomorindukpegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, jenispesanmenu, jenisdiet_nama, satuanjml_urt, jeniswaktu_nama, ruangan_nama, ruangan_lokasi', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskelamin, jeniswaktu_jam', 'length', 'max'=>20),
			array('menudiet_nama', 'length', 'max'=>200),
			array('alamat_pegawai, tglkirimmenu, keterangan_kirim', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_nama, jeniskelamin, alamat_pegawai, kirimmenudiet_id, tglkirimmenu, jenispesanmenu, keterangan_kirim, jenisdiet_id, jenisdiet_nama, menudiet_id, jml_kirim, satuanjml_urt, jeniswaktu_id, jeniswaktu_nama, menudiet_nama, ruangan_id, ruangan_nama, ruangan_lokasi, jeniswaktu_jam', 'safe', 'on'=>'search'),
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
			'pegawai_id' => 'Pegawai',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kirimmenudiet_id' => 'Kirimmenudiet',
			'tglkirimmenu' => 'Tglkirimmenu',
			'jenispesanmenu' => 'Jenispesanmenu',
			'keterangan_kirim' => 'Keterangan Kirim',
			'jenisdiet_id' => 'Jenisdiet',
			'jenisdiet_nama' => 'Jenisdiet Nama',
			'menudiet_id' => 'Menudiet',
			'jml_kirim' => 'Jml Kirim',
			'satuanjml_urt' => 'Satuanjml Urt',
			'jeniswaktu_id' => 'Jeniswaktu',
			'jeniswaktu_nama' => 'Jeniswaktu Nama',
			'menudiet_nama' => 'Menudiet Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_lokasi' => 'Ruangan Lokasi',
			'jeniswaktu_jam' => 'Jeniswaktu Jam',
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

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('tglkirimmenu',$this->tglkirimmenu,true);
		$criteria->compare('jenispesanmenu',$this->jenispesanmenu,true);
		$criteria->compare('keterangan_kirim',$this->keterangan_kirim,true);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('jenisdiet_nama',$this->jenisdiet_nama,true);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('jml_kirim',$this->jml_kirim);
		$criteria->compare('satuanjml_urt',$this->satuanjml_urt,true);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('jeniswaktu_nama',$this->jeniswaktu_nama,true);
		$criteria->compare('menudiet_nama',$this->menudiet_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('ruangan_lokasi',$this->ruangan_lokasi,true);
		$criteria->compare('jeniswaktu_jam',$this->jeniswaktu_jam,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}