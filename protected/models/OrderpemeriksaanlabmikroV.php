<?php

/**
 * This is the model class for table "orderpemeriksaanlabmikro_v".
 *
 * The followings are the available columns in table 'orderpemeriksaanlabmikro_v':
 * @property integer $jenispemeriksaanlab_id
 * @property string $jenispemeriksaanlab_kode
 * @property integer $jenispemeriksaanlab_urutan
 * @property string $jenispemeriksaanlab_nama
 * @property integer $pemeriksaanlab_id
 * @property string $pemeriksaanlab_kode
 * @property integer $pemeriksaanlab_urutan
 * @property string $pemeriksaanlab_nama
 * @property boolean $is_programtbc
 * @property boolean $is_programhiv
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property integer $komponenunit_id
 * @property string $komponenunit_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $daftartindakan_namalainnya
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
 * @property integer $komponentarif_id
 * @property string $komponentarif_nama
 * @property double $harga_tariftindakan
 * @property double $totaltarifakhir_cyto
 * @property string $jeniswaktukerja
 * @property string $jenispemeriksaanlab_kelompok
 * @property boolean $isdouble
 * @property string $kode_unik
 * @property integer $samplelab_id
 * @property string $samplelab_nama
 */
class OrderpemeriksaanlabmikroV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orderpemeriksaanlabmikro_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispemeriksaanlab_id, jenispemeriksaanlab_urutan, pemeriksaanlab_id, pemeriksaanlab_urutan, kategoritindakan_id, kelompoktindakan_id, komponenunit_id, daftartindakan_id, instalasi_id, ruangan_id, kelaspelayanan_id, carabayar_id, penjamin_id, jenistarif_id, perdatarif_id, komponentarif_id, samplelab_id', 'numerical', 'integerOnly'=>true),
			array('harga_tariftindakan, totaltarifakhir_cyto', 'numerical'),
			array('jenispemeriksaanlab_kode, pemeriksaanlab_kode', 'length', 'max'=>10),
			array('jenispemeriksaanlab_nama', 'length', 'max'=>92),
			array('pemeriksaanlab_nama', 'length', 'max'=>500),
			array('kategoritindakan_nama', 'length', 'max'=>150),
			array('kelompoktindakan_nama, kelaspelayanan_nama, carabayar_nama, samplelab_nama', 'length', 'max'=>50),
			array('komponenunit_nama, daftartindakan_katakunci, ditetapkanoleh, tempatditetapkan', 'length', 'max'=>30),
			array('daftartindakan_kode, noperda', 'length', 'max'=>20),
			array('daftartindakan_nama, daftartindakan_namalainnya', 'length', 'max'=>400),
			array('instalasi_nama, ruangan_nama, penjamin_nama, jenispemeriksaanlab_kelompok', 'length', 'max'=>100),
			array('jenistarif_nama, komponentarif_nama', 'length', 'max'=>25),
			array('perdanama_sk', 'length', 'max'=>200),
			array('kode_unik', 'length', 'max'=>255),
			array('is_programtbc, is_programhiv, tglperda, perdatentang, jeniswaktukerja, isdouble', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('jenispemeriksaanlab_id, jenispemeriksaanlab_kode, jenispemeriksaanlab_urutan, jenispemeriksaanlab_nama, pemeriksaanlab_id, pemeriksaanlab_kode, pemeriksaanlab_urutan, pemeriksaanlab_nama, is_programtbc, is_programhiv, kategoritindakan_id, kategoritindakan_nama, kelompoktindakan_id, kelompoktindakan_nama, komponenunit_id, komponenunit_nama, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, daftartindakan_namalainnya, daftartindakan_katakunci, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, kelaspelayanan_id, kelaspelayanan_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, jenistarif_id, jenistarif_nama, perdatarif_id, perdanama_sk, noperda, tglperda, perdatentang, ditetapkanoleh, tempatditetapkan, komponentarif_id, komponentarif_nama, harga_tariftindakan, totaltarifakhir_cyto, jeniswaktukerja, jenispemeriksaanlab_kelompok, isdouble, kode_unik, samplelab_id, samplelab_nama', 'safe', 'on'=>'search'),
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
			'jenispemeriksaanlab_id' => 'Jenispemeriksaanlab',
			'jenispemeriksaanlab_kode' => 'Jenispemeriksaanlab Kode',
			'jenispemeriksaanlab_urutan' => 'Jenispemeriksaanlab Urutan',
			'jenispemeriksaanlab_nama' => 'Jenispemeriksaanlab Nama',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'pemeriksaanlab_kode' => 'Pemeriksaanlab Kode',
			'pemeriksaanlab_urutan' => 'Pemeriksaanlab Urutan',
			'pemeriksaanlab_nama' => 'Pemeriksaanlab Nama',
			'is_programtbc' => 'Is Programtbc',
			'is_programhiv' => 'Is Programhiv',
			'kategoritindakan_id' => 'Kategoritindakan',
			'kategoritindakan_nama' => 'Kategoritindakan Nama',
			'kelompoktindakan_id' => 'Kelompoktindakan',
			'kelompoktindakan_nama' => 'Kelompoktindakan Nama',
			'komponenunit_id' => 'Komponenunit',
			'komponenunit_nama' => 'Komponenunit Nama',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'daftartindakan_namalainnya' => 'Daftartindakan Namalainnya',
			'daftartindakan_katakunci' => 'Daftartindakan Katakunci',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'carabayar_id' => 'Carabayar',
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
			'komponentarif_id' => 'Komponentarif',
			'komponentarif_nama' => 'Komponentarif Nama',
			'harga_tariftindakan' => 'Harga Tariftindakan',
			'totaltarifakhir_cyto' => 'Totaltarifakhir Cyto',
			'jeniswaktukerja' => 'Jeniswaktukerja',
			'jenispemeriksaanlab_kelompok' => 'Jenispemeriksaanlab Kelompok',
			'isdouble' => 'Isdouble',
			'kode_unik' => 'Kode Unik',
			'samplelab_id' => 'Samplelab',
			'samplelab_nama' => 'Samplelab Nama',
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

		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('jenispemeriksaanlab_kode',$this->jenispemeriksaanlab_kode,true);
		$criteria->compare('jenispemeriksaanlab_urutan',$this->jenispemeriksaanlab_urutan);
		$criteria->compare('jenispemeriksaanlab_nama',$this->jenispemeriksaanlab_nama,true);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('pemeriksaanlab_kode',$this->pemeriksaanlab_kode,true);
		$criteria->compare('pemeriksaanlab_urutan',$this->pemeriksaanlab_urutan);
		$criteria->compare('pemeriksaanlab_nama',$this->pemeriksaanlab_nama,true);
		$criteria->compare('is_programtbc',$this->is_programtbc);
		$criteria->compare('is_programhiv',$this->is_programhiv);
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('kategoritindakan_nama',$this->kategoritindakan_nama,true);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('kelompoktindakan_nama',$this->kelompoktindakan_nama,true);
		$criteria->compare('komponenunit_id',$this->komponenunit_id);
		$criteria->compare('komponenunit_nama',$this->komponenunit_nama,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('daftartindakan_namalainnya',$this->daftartindakan_namalainnya,true);
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
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('komponentarif_nama',$this->komponentarif_nama,true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('totaltarifakhir_cyto',$this->totaltarifakhir_cyto);
		$criteria->compare('jeniswaktukerja',$this->jeniswaktukerja,true);
		$criteria->compare('jenispemeriksaanlab_kelompok',$this->jenispemeriksaanlab_kelompok,true);
		$criteria->compare('isdouble',$this->isdouble);
		$criteria->compare('kode_unik',$this->kode_unik,true);
		$criteria->compare('samplelab_id',$this->samplelab_id);
		$criteria->compare('samplelab_nama',$this->samplelab_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderpemeriksaanlabmikroV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
