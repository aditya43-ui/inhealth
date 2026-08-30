<?php

/**
 * This is the model class for table "laporanpemusnahanoa_v".
 *
 * The followings are the available columns in table 'laporanpemusnahanoa_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pemusnahanobatalkes_id
 * @property string $tglpemusnahan
 * @property string $nopemusnahan
 * @property string $keterangan
 * @property integer $pemusnahanoadetail_id
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_kode
 * @property string $jenisobatalkes_nama
 * @property integer $obatalkes_id
 * @property string $obatalkes_barcode
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $kemasanbesar
 * @property integer $kekuatan
 * @property string $satuankekuatan
 * @property integer $stokobatalkes_id
 * @property double $jmlbarang
 * @property string $tglkadaluarsa
 * @property string $nobatch
 * @property double $harganetto
 * @property double $persendiscount
 * @property double $jmldiscount
 * @property double $persenppn
 * @property double $persenpph
 * @property double $persenmargin
 * @property double $jmlmargin
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property string $kondisibarang
 * @property integer $pegawai_id
 * @property string $pegawai_nip
 * @property string $pegawai_jenisidentitas
 * @property string $pegawai_noidentitas
 * @property string $pegawai_gelardepan
 * @property string $pegawai_nama
 * @property string $pegawai_gelarbelakang
 * @property integer $pegawaimengetahui_id
 * @property string $pegawaimengetahui_nip
 * @property string $pegawaimengetahui_jenisidentitas
 * @property string $pegawaimengetahui_noidentitas
 * @property string $pegawaimengetahui_gelardepan
 * @property string $pegawaimengetahui_nama
 * @property string $pegawaimengetahui_gelarbelakang
 * @property integer $pegawaimenyetujui_id
 * @property string $pegawaimenyetujui_nip
 * @property string $pegawaimenyetujui_jenisidentitas
 * @property string $pegawaimenyetujui_noidentitas
 * @property string $pegawaimenyetujui_gelardepan
 * @property string $pegawaimenyetujui_nama
 * @property string $pegawaimenyetujui_gelarbelakang
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class LaporanpemusnahanoaV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpemusnahanoaV the static model class
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
		return 'laporanpemusnahanoa_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, pemusnahanobatalkes_id, pemusnahanoadetail_id, jenisobatalkes_id, obatalkes_id, kemasanbesar, kekuatan, stokobatalkes_id, satuankecil_id, pegawai_id, pegawaimengetahui_id, pegawaimenyetujui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jmlbarang, harganetto, persendiscount, jmldiscount, persenppn, persenpph, persenmargin, jmlmargin', 'numerical'),
			array('instalasi_nama, ruangan_nama, jenisobatalkes_nama, obatalkes_golongan, obatalkes_kategori, satuankecil_nama, pegawai_nama, pegawaimengetahui_nama, pegawaimenyetujui_nama', 'length', 'max'=>50),
			array('nopemusnahan, obatalkes_barcode, obatalkes_kode, obatalkes_nama, nobatch', 'length', 'max'=>200),
			array('jenisobatalkes_kode, pegawai_gelardepan, pegawaimengetahui_gelardepan, pegawaimenyetujui_gelardepan', 'length', 'max'=>10),
			array('obatalkes_kadarobat, satuankekuatan, pegawai_jenisidentitas, pegawaimengetahui_jenisidentitas, pegawaimenyetujui_jenisidentitas', 'length', 'max'=>20),
			array('pegawai_nip, pegawaimengetahui_nip, pegawaimenyetujui_nip', 'length', 'max'=>30),
			array('pegawai_noidentitas, pegawaimengetahui_noidentitas, pegawaimenyetujui_noidentitas', 'length', 'max'=>100),
			array('pegawai_gelarbelakang, pegawaimengetahui_gelarbelakang, pegawaimenyetujui_gelarbelakang', 'length', 'max'=>15),
			array('tglpemusnahan, keterangan, tglkadaluarsa, kondisibarang, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, pemusnahanobatalkes_id, tglpemusnahan, nopemusnahan, keterangan, pemusnahanoadetail_id, jenisobatalkes_id, jenisobatalkes_kode, jenisobatalkes_nama, obatalkes_id, obatalkes_barcode, obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, kemasanbesar, kekuatan, satuankekuatan, stokobatalkes_id, jmlbarang, tglkadaluarsa, nobatch, harganetto, persendiscount, jmldiscount, persenppn, persenpph, persenmargin, jmlmargin, satuankecil_id, satuankecil_nama, kondisibarang, pegawai_id, pegawai_nip, pegawai_jenisidentitas, pegawai_noidentitas, pegawai_gelardepan, pegawai_nama, pegawai_gelarbelakang, pegawaimengetahui_id, pegawaimengetahui_nip, pegawaimengetahui_jenisidentitas, pegawaimengetahui_noidentitas, pegawaimengetahui_gelardepan, pegawaimengetahui_nama, pegawaimengetahui_gelarbelakang, pegawaimenyetujui_id, pegawaimenyetujui_nip, pegawaimenyetujui_jenisidentitas, pegawaimenyetujui_noidentitas, pegawaimenyetujui_gelardepan, pegawaimenyetujui_nama, pegawaimenyetujui_gelarbelakang, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'instalasi_nama' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'pemusnahanobatalkes_id' => 'Pemusnahanobatalkes',
			'tglpemusnahan' => 'Tanggal Pemusnahan',
			'nopemusnahan' => 'No. Pemusnahan',
			'keterangan' => 'Keterangan',
			'pemusnahanoadetail_id' => 'Pemusnahanoadetail',
			'jenisobatalkes_id' => 'Jenisobatalkes',
			'jenisobatalkes_kode' => 'Jenisobatalkes Kode',
			'jenisobatalkes_nama' => 'Jenisobatalkes Nama',
			'obatalkes_id' => 'Obatalkes',
			'obatalkes_barcode' => 'Obatalkes Barcode',
			'obatalkes_kode' => 'Kode Obat Alkes',
			'obatalkes_nama' => 'Nama Obat Alkes',
			'obatalkes_golongan' => 'Obatalkes Golongan',
			'obatalkes_kategori' => 'Obatalkes Kategori',
			'obatalkes_kadarobat' => 'Obatalkes Kadarobat',
			'kemasanbesar' => 'Kemasanbesar',
			'kekuatan' => 'Kekuatan',
			'satuankekuatan' => 'Satuankekuatan',
			'stokobatalkes_id' => 'Stokobatalkes',
			'jmlbarang' => 'Jumlah',
			'tglkadaluarsa' => 'Tglkadaluarsa',
			'nobatch' => 'Nobatch',
			'harganetto' => 'Harganetto',
			'persendiscount' => 'Persen Keringanan',
			'jmldiscount' => 'Jumlah Keringanan',
			'persenppn' => 'Persenppn',
			'persenpph' => 'Persenpph',
			'persenmargin' => 'Persenmargin',
			'jmlmargin' => 'Jmlmargin',
			'satuankecil_id' => 'Satuankecil',
			'satuankecil_nama' => 'Satuankecil Nama',
			'kondisibarang' => 'Kondisibarang',
			'pegawai_id' => 'Pegawai',
			'pegawai_nip' => 'Pegawai Nip',
			'pegawai_jenisidentitas' => 'Pegawai Jenisidentitas',
			'pegawai_noidentitas' => 'Pegawai Noidentitas',
			'pegawai_gelardepan' => 'Pegawai Gelardepan',
			'pegawai_nama' => 'Pegawai Nama',
			'pegawai_gelarbelakang' => 'Pegawai Gelarbelakang',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
			'pegawaimengetahui_nip' => 'Pegawaimengetahui Nip',
			'pegawaimengetahui_jenisidentitas' => 'Pegawaimengetahui Jenisidentitas',
			'pegawaimengetahui_noidentitas' => 'Pegawaimengetahui Noidentitas',
			'pegawaimengetahui_gelardepan' => 'Pegawaimengetahui Gelardepan',
			'pegawaimengetahui_nama' => 'Pegawaimengetahui Nama',
			'pegawaimengetahui_gelarbelakang' => 'Pegawaimengetahui Gelarbelakang',
			'pegawaimenyetujui_id' => 'Pegawai Menyetujui',
			'pegawaimenyetujui_nip' => 'Pegawaimenyetujui Nip',
			'pegawaimenyetujui_jenisidentitas' => 'Pegawaimenyetujui Jenisidentitas',
			'pegawaimenyetujui_noidentitas' => 'Pegawaimenyetujui Noidentitas',
			'pegawaimenyetujui_gelardepan' => 'Pegawaimenyetujui Gelardepan',
			'pegawaimenyetujui_nama' => 'Pegawaimenyetujui Nama',
			'pegawaimenyetujui_gelarbelakang' => 'Pegawaimenyetujui Gelarbelakang',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pemusnahanobatalkes_id)){
			$criteria->addCondition('pemusnahanobatalkes_id = '.$this->pemusnahanobatalkes_id);
		}
		$criteria->compare('LOWER(tglpemusnahan)',strtolower($this->tglpemusnahan),true);
		$criteria->compare('LOWER(nopemusnahan)',strtolower($this->nopemusnahan),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		if(!empty($this->pemusnahanoadetail_id)){
			$criteria->addCondition('pemusnahanoadetail_id = '.$this->pemusnahanoadetail_id);
		}
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(jenisobatalkes_kode)',strtolower($this->jenisobatalkes_kode),true);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->kemasanbesar)){
			$criteria->addCondition('kemasanbesar = '.$this->kemasanbesar);
		}
		if(!empty($this->kekuatan)){
			$criteria->addCondition('kekuatan = '.$this->kekuatan);
		}
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		if(!empty($this->stokobatalkes_id)){
			$criteria->addCondition('stokobatalkes_id = '.$this->stokobatalkes_id);
		}
		$criteria->compare('jmlbarang',$this->jmlbarang);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('persendiscount',$this->persendiscount);
		$criteria->compare('jmldiscount',$this->jmldiscount);
		$criteria->compare('persenppn',$this->persenppn);
		$criteria->compare('persenpph',$this->persenpph);
		$criteria->compare('persenmargin',$this->persenmargin);
		$criteria->compare('jmlmargin',$this->jmlmargin);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(pegawai_nip)',strtolower($this->pegawai_nip),true);
		$criteria->compare('LOWER(pegawai_jenisidentitas)',strtolower($this->pegawai_jenisidentitas),true);
		$criteria->compare('LOWER(pegawai_noidentitas)',strtolower($this->pegawai_noidentitas),true);
		$criteria->compare('LOWER(pegawai_gelardepan)',strtolower($this->pegawai_gelardepan),true);
		$criteria->compare('LOWER(pegawai_nama)',strtolower($this->pegawai_nama),true);
		$criteria->compare('LOWER(pegawai_gelarbelakang)',strtolower($this->pegawai_gelarbelakang),true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		$criteria->compare('LOWER(pegawaimengetahui_nip)',strtolower($this->pegawaimengetahui_nip),true);
		$criteria->compare('LOWER(pegawaimengetahui_jenisidentitas)',strtolower($this->pegawaimengetahui_jenisidentitas),true);
		$criteria->compare('LOWER(pegawaimengetahui_noidentitas)',strtolower($this->pegawaimengetahui_noidentitas),true);
		$criteria->compare('LOWER(pegawaimengetahui_gelardepan)',strtolower($this->pegawaimengetahui_gelardepan),true);
		$criteria->compare('LOWER(pegawaimengetahui_nama)',strtolower($this->pegawaimengetahui_nama),true);
		$criteria->compare('LOWER(pegawaimengetahui_gelarbelakang)',strtolower($this->pegawaimengetahui_gelarbelakang),true);
		if(!empty($this->pegawaimenyetujui_id)){
			$criteria->addCondition('pegawaimenyetujui_id = '.$this->pegawaimenyetujui_id);
		}
		$criteria->compare('LOWER(pegawaimenyetujui_nip)',strtolower($this->pegawaimenyetujui_nip),true);
		$criteria->compare('LOWER(pegawaimenyetujui_jenisidentitas)',strtolower($this->pegawaimenyetujui_jenisidentitas),true);
		$criteria->compare('LOWER(pegawaimenyetujui_noidentitas)',strtolower($this->pegawaimenyetujui_noidentitas),true);
		$criteria->compare('LOWER(pegawaimenyetujui_gelardepan)',strtolower($this->pegawaimenyetujui_gelardepan),true);
		$criteria->compare('LOWER(pegawaimenyetujui_nama)',strtolower($this->pegawaimenyetujui_nama),true);
		$criteria->compare('LOWER(pegawaimenyetujui_gelarbelakang)',strtolower($this->pegawaimenyetujui_gelarbelakang),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

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