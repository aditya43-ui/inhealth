<?php

/**
 * This is the model class for table "laporanperbekalanmedik_v".
 *
 * The followings are the available columns in table 'laporanperbekalanmedik_v':
 * @property integer $invperalatan_id
 * @property string $nama_aset
 * @property string $invperalatan_kode
 * @property integer $lokasi_id
 * @property string $lokasiaset_namalokasi
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $gedung_id
 * @property string $gedung_nama
 * @property integer $barang_id
 * @property string $nama_perbekalan
 * @property string $invpersparepart_jenis
 * @property integer $invpersparepart_jml
 * @property string $invpersparepart_satuan
 * @property string $invpersparepart_fungsi
 */
class LaporanperbekalanmedikV extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanperbekalanmedikV the static model class
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
		return 'laporanperbekalanmedik_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invperalatan_id, lokasi_id, ruangan_id, gedung_id, barang_id, invpersparepart_jml', 'numerical', 'integerOnly'=>true),
			array('nama_aset, lokasiaset_namalokasi, gedung_nama, nama_perbekalan', 'length', 'max'=>100),
			array('invperalatan_kode, ruangan_nama, invpersparepart_jenis, invpersparepart_satuan', 'length', 'max'=>50),
			array('invpersparepart_fungsi', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invperalatan_id, nama_aset, invperalatan_kode, lokasi_id, lokasiaset_namalokasi, ruangan_id, ruangan_nama, gedung_id, gedung_nama, barang_id, nama_perbekalan, invpersparepart_jenis, invpersparepart_jml, invpersparepart_satuan, invpersparepart_fungsi', 'safe', 'on'=>'search'),
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
			'invperalatan_id' => 'Invperalatan',
			'nama_aset' => 'Nama Aset',
			'invperalatan_kode' => 'Kode Aset',
			'lokasi_id' => 'Lokasi Aset',
			'lokasiaset_namalokasi' => 'Lokasi Aset',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'gedung_id' => 'Gedung',
			'gedung_nama' => 'Gedung Nama',
			'barang_id' => 'Barang',
			'nama_perbekalan' => 'Perbekalan',
			'invpersparepart_jenis' => 'Jenis Perbekalan',
			'invpersparepart_jml' => 'Jumlah',
			'invpersparepart_satuan' => 'Satuan',
			'invpersparepart_fungsi' => 'Fungsi',
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

		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('LOWER(nama_aset)', strtolower($this->nama_aset),true);
		$criteria->compare('LOWER(invperalatan_kode)', strtolower($this->invperalatan_kode),true);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('LOWER(lokasiaset_namalokasi)', strtolower($this->lokasiaset_namalokasi),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama),true);
		$criteria->compare('gedung_id',$this->gedung_id);
		$criteria->compare('LOWER(gedung_nama)', strtolower($this->gedung_nama),true);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('LOWER(nama_perbekalan)', strtolower($this->nama_perbekalan),true);
		$criteria->compare('LOWER(invpersparepart_jenis)', strtolower($this->invpersparepart_jenis),true);
		$criteria->compare('invpersparepart_jml',$this->invpersparepart_jml);
		$criteria->compare('LOWER(invpersparepart_satuan)', strtolower($this->invpersparepart_satuan),true);
		$criteria->compare('LOWER(invpersparepart_fungsi)', strtolower($this->invpersparepart_fungsi),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}