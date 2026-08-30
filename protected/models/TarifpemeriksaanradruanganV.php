<?php

/**
 * This is the model class for table "tarifpemeriksaanradruangan_v".
 *
 * The followings are the available columns in table 'tarifpemeriksaanradruangan_v':
 * @property integer $jenispemeriksaanrad_id
 * @property string $jenispemeriksaanrad_kode
 * @property integer $jenispemeriksaanrad_urutan
 * @property string $jenispemeriksaanrad_nama
 * @property integer $pemeriksaanrad_id
 * @property string $pemeriksaanrad_kode
 * @property integer $pemeriksaanrad_urutan
 * @property string $pemeriksaanrad_nama
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
 */
class TarifpemeriksaanradruanganV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarifpemeriksaanradruanganV the static model class
	 */

	public $is_paket;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tarifpemeriksaanradruangan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispemeriksaanrad_id, jenispemeriksaanrad_urutan, pemeriksaanrad_id, pemeriksaanrad_urutan, kategoritindakan_id, kelompoktindakan_id, komponenunit_id, daftartindakan_id, instalasi_id, ruangan_id, kelaspelayanan_id, carabayar_id, penjamin_id, jenistarif_id, perdatarif_id, komponentarif_id', 'numerical', 'integerOnly'=>true),
			array('harga_tariftindakan', 'numerical'),
			array('jenispemeriksaanrad_kode, pemeriksaanrad_kode', 'length', 'max'=>10),
			array('jenispemeriksaanrad_nama, pemeriksaanrad_nama', 'length', 'max'=>100),
			array('kategoritindakan_nama', 'length', 'max'=>150),
			array('kelompoktindakan_nama, instalasi_nama, ruangan_nama, kelaspelayanan_nama, carabayar_nama, penjamin_nama', 'length', 'max'=>50),
			array('komponenunit_nama, daftartindakan_katakunci, ditetapkanoleh, tempatditetapkan', 'length', 'max'=>30),
			array('daftartindakan_kode, noperda', 'length', 'max'=>20),
			array('daftartindakan_nama, daftartindakan_namalainnya, perdanama_sk', 'length', 'max'=>200),
			array('jenistarif_nama, komponentarif_nama', 'length', 'max'=>25),
			array('tglperda, perdatentang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispemeriksaanrad_id, jenispemeriksaanrad_kode, jenispemeriksaanrad_urutan, jenispemeriksaanrad_nama, pemeriksaanrad_id, pemeriksaanrad_kode, pemeriksaanrad_urutan, pemeriksaanrad_nama, kategoritindakan_id, kategoritindakan_nama, kelompoktindakan_id, kelompoktindakan_nama, komponenunit_id, komponenunit_nama, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, daftartindakan_namalainnya, daftartindakan_katakunci, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, kelaspelayanan_id, kelaspelayanan_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, jenistarif_id, jenistarif_nama, perdatarif_id, perdanama_sk, noperda, tglperda, perdatentang, ditetapkanoleh, tempatditetapkan, komponentarif_id, komponentarif_nama, harga_tariftindakan', 'safe', 'on'=>'search'),
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
			'jenispemeriksaanrad_id' => 'Jenis Pemeriksaan',
			'jenispemeriksaanrad_kode' => 'Kode Pemeriksaan',
			'jenispemeriksaanrad_urutan' => 'Urutan Jenis Pemeriksaan',
			'jenispemeriksaanrad_nama' => 'Jenis Pemeriksaan',
			'pemeriksaanrad_id' => 'Pemeriksaan',
			'pemeriksaanrad_kode' => 'Kode Pemeriksaan',
			'pemeriksaanrad_urutan' => 'Urutan Pemeriksaan',
			'pemeriksaanrad_nama' => 'Nama Pemeriksaan',
			'kategoritindakan_id' => 'Kategori Tindakan',
			'kategoritindakan_nama' => 'Kategoritindakan Nama',
			'kelompoktindakan_id' => 'Kelompok Tindakan',
			'kelompoktindakan_nama' => 'Kelompoktindakan Nama',
			'komponenunit_id' => 'Komponen Unit',
			'komponenunit_nama' => 'Nama Komponen Unit',
			'daftartindakan_id' => 'Daftar Tindakan',
			'daftartindakan_kode' => 'Kode Daftar Tindakan',
			'daftartindakan_nama' => 'Daftar Tindakan',
			'daftartindakan_namalainnya' => 'Daftartindakan Namalainnya',
			'daftartindakan_katakunci' => 'Daftartindakan Katakunci',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kelaspelayanan_nama' => 'Kelas Pelayanan',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'jenistarif_id' => 'Jenis Tarif',
			'jenistarif_nama' => 'Jenis Tarif',
			'perdatarif_id' => 'Perda Tarif',
			'perdanama_sk' => 'Perdanama Sk',
			'noperda' => 'No. Perda',
			'tglperda' => 'Tgl. Perda',
			'perdatentang' => 'Perdatentang',
			'ditetapkanoleh' => 'Ditetapkanoleh',
			'tempatditetapkan' => 'Tempatditetapkan',
			'komponentarif_id' => 'Komponentarif',
			'komponentarif_nama' => 'Komponentarif Nama',
			'harga_tariftindakan' => 'Harga Tariftindakan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenispemeriksaanrad_id',$this->jenispemeriksaanrad_id);
		$criteria->compare('LOWER(jenispemeriksaanrad_kode)',strtolower($this->jenispemeriksaanrad_kode),true);
		$criteria->compare('jenispemeriksaanrad_urutan',$this->jenispemeriksaanrad_urutan);
		$criteria->compare('LOWER(jenispemeriksaanrad_nama)',strtolower($this->jenispemeriksaanrad_nama),true);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('LOWER(pemeriksaanrad_kode)',strtolower($this->pemeriksaanrad_kode),true);
		$criteria->compare('pemeriksaanrad_urutan',$this->pemeriksaanrad_urutan);
		$criteria->compare('LOWER(pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('komponenunit_id',$this->komponenunit_id);
		$criteria->compare('LOWER(komponenunit_nama)',strtolower($this->komponenunit_nama),true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
		$criteria->compare('perdatarif_id',$this->perdatarif_id);
		$criteria->compare('LOWER(perdanama_sk)',strtolower($this->perdanama_sk),true);
		$criteria->compare('LOWER(noperda)',strtolower($this->noperda),true);
		$criteria->compare('LOWER(tglperda)',strtolower($this->tglperda),true);
		$criteria->compare('LOWER(perdatentang)',strtolower($this->perdatentang),true);
		$criteria->compare('LOWER(ditetapkanoleh)',strtolower($this->ditetapkanoleh),true);
		$criteria->compare('LOWER(tempatditetapkan)',strtolower($this->tempatditetapkan),true);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}