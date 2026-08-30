<?php

/**
 * This is the model class for table "informasimutasioaruangan_v".
 *
 * The followings are the available columns in table 'informasimutasioaruangan_v':
 * @property integer $mutasioaruangan_id
 * @property string $tglmutasioa
 * @property string $nomutasioa
 * @property integer $pesanobatalkes_id
 * @property string $tglpemesanan
 * @property string $nopemesanan
 * @property string $tglmintadikirim
 * @property string $statuspesan
 * @property string $keterangan_pesan
 * @property integer $terimamutasi_id
 * @property string $tglterima
 * @property string $noterimamutasi
 * @property double $totalharganetto_mutasi
 * @property double $totalhargajual_mutasi
 * @property string $keteranganmutasi
 * @property double $totalharganetto_terima
 * @property double $totalhargajual_terima
 * @property string $keterangan_terima
 * @property integer $instalasipemesan_id
 * @property string $instalasipemesan_nama
 * @property integer $ruanganpemesan_id
 * @property string $ruanganpemesan_nama
 * @property integer $instalasiasalmutasi_id
 * @property string $instalasiasalmutasi_nama
 * @property integer $ruanganasalmutasi_id
 * @property string $ruanganasalmutasi_nama
 * @property integer $instalasitujuanmutasi_id
 * @property string $instalasitujuanmutasi_nama
 * @property integer $ruangantujuanmutasi_id
 * @property string $ruangantujuanmutasi_nama
 * @property integer $instalasipenerima_id
 * @property string $instalasipenerima_nama
 * @property integer $ruanganpenerima_id
 * @property string $ruanganpenerima_nama
 * @property integer $pegawaipemesan_id
 * @property string $pegawaipemesan_gelardepan
 * @property string $pegawaipemesan_nama
 * @property string $pegawaipemesan_gelarbelakang
 * @property integer $pegawaimengetahuipesanan_id
 * @property string $pegawaimengetahuipesanan_gelardepan
 * @property string $pegawaimengetahuipesanan_nama
 * @property string $pegawaimengetahuipesanan_gelarbelakang
 * @property integer $pegawaimutasi_id
 * @property string $pegawaimutasi_gelardepan
 * @property string $pegawaimutasi_nama
 * @property string $pegawaimutasi_gelarbelakang
 * @property integer $pegawaimengetahuimutasi_id
 * @property string $pegawaimengetahuimutasi_gelardepan
 * @property string $pegawaimengetahuimutasi_nama
 * @property string $pegawaimengetahuimutasi_gelarbelakang
 * @property integer $pegawaipenerima_id
 * @property string $pegawaipenerima_gelardepan
 * @property string $pegawaipenerima_nama
 * @property string $pegawaipenerima_gelarbelakang
 * @property integer $pegawaimengetahuipenerimaan_id
 * @property string $pegawaimengetahuipenerimaan_gelardepan
 * @property string $pegawaimengetahuipenerimaan_nama
 * @property string $pegawaimengetahuipenerimaan_gelarbelakang
 */
class InformasimutasioaruanganV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasimutasioaruanganV the static model class
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
		return 'informasimutasioaruangan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mutasioaruangan_id, pesanobatalkes_id, terimamutasi_id, instalasipemesan_id, ruanganpemesan_id, instalasiasalmutasi_id, ruanganasalmutasi_id, instalasitujuanmutasi_id, ruangantujuanmutasi_id, instalasipenerima_id, ruanganpenerima_id, pegawaipemesan_id, pegawaimengetahuipesanan_id, pegawaimutasi_id, pegawaimengetahuimutasi_id, pegawaipenerima_id, pegawaimengetahuipenerimaan_id', 'numerical', 'integerOnly'=>true),
			array('totalharganetto_mutasi, totalhargajual_mutasi, totalharganetto_terima, totalhargajual_terima', 'numerical'),
			array('nomutasioa, noterimamutasi', 'length', 'max'=>20),
			array('nopemesanan, instalasipemesan_nama, ruanganpemesan_nama, instalasiasalmutasi_nama, ruanganasalmutasi_nama, instalasitujuanmutasi_nama, ruangantujuanmutasi_nama, instalasipenerima_nama, ruanganpenerima_nama, pegawaipemesan_nama, pegawaimengetahuipesanan_nama, pegawaimutasi_nama, pegawaimengetahuimutasi_nama, pegawaipenerima_nama, pegawaimengetahuipenerimaan_nama', 'length', 'max'=>50),
			array('statuspesan', 'length', 'max'=>30),
			array('pegawaipemesan_gelardepan, pegawaimengetahuipesanan_gelardepan, pegawaimutasi_gelardepan, pegawaimengetahuimutasi_gelardepan, pegawaipenerima_gelardepan, pegawaimengetahuipenerimaan_gelardepan', 'length', 'max'=>10),
			array('pegawaipemesan_gelarbelakang, pegawaimengetahuipesanan_gelarbelakang, pegawaimutasi_gelarbelakang, pegawaimengetahuimutasi_gelarbelakang, pegawaipenerima_gelarbelakang, pegawaimengetahuipenerimaan_gelarbelakang', 'length', 'max'=>15),
			array('tglmutasioa, tglpemesanan, tglmintadikirim, keterangan_pesan, tglterima, keteranganmutasi, keterangan_terima', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mutasioaruangan_id, tglmutasioa, nomutasioa, pesanobatalkes_id, tglpemesanan, nopemesanan, tglmintadikirim, statuspesan, keterangan_pesan, terimamutasi_id, tglterima, noterimamutasi, totalharganetto_mutasi, totalhargajual_mutasi, keteranganmutasi, totalharganetto_terima, totalhargajual_terima, keterangan_terima, instalasipemesan_id, instalasipemesan_nama, ruanganpemesan_id, ruanganpemesan_nama, instalasiasalmutasi_id, instalasiasalmutasi_nama, ruanganasalmutasi_id, ruanganasalmutasi_nama, instalasitujuanmutasi_id, instalasitujuanmutasi_nama, ruangantujuanmutasi_id, ruangantujuanmutasi_nama, instalasipenerima_id, instalasipenerima_nama, ruanganpenerima_id, ruanganpenerima_nama, pegawaipemesan_id, pegawaipemesan_gelardepan, pegawaipemesan_nama, pegawaipemesan_gelarbelakang, pegawaimengetahuipesanan_id, pegawaimengetahuipesanan_gelardepan, pegawaimengetahuipesanan_nama, pegawaimengetahuipesanan_gelarbelakang, pegawaimutasi_id, pegawaimutasi_gelardepan, pegawaimutasi_nama, pegawaimutasi_gelarbelakang, pegawaimengetahuimutasi_id, pegawaimengetahuimutasi_gelardepan, pegawaimengetahuimutasi_nama, pegawaimengetahuimutasi_gelarbelakang, pegawaipenerima_id, pegawaipenerima_gelardepan, pegawaipenerima_nama, pegawaipenerima_gelarbelakang, pegawaimengetahuipenerimaan_id, pegawaimengetahuipenerimaan_gelardepan, pegawaimengetahuipenerimaan_nama, pegawaimengetahuipenerimaan_gelarbelakang', 'safe', 'on'=>'search'),
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
			'mutasioaruangan_id' => 'Mutasioaruangan',
			'tglmutasioa' => 'Tanggal Mutasi',
			'nomutasioa' => 'No. Mutasi',
			'pesanobatalkes_id' => 'Pesanobatalkes',
			'tglpemesanan' => 'Tanggal Pemesanan',
			'nopemesanan' => 'No. Pemesanan',
			'tglmintadikirim' => 'Tanggal Permintaan Dikirim',
			'statuspesan' => 'Status Pemesanan',
			'keterangan_pesan' => 'Keterangan Pesan',
			'terimamutasi_id' => 'Terima Mutasi',
			'tglterima' => 'Tanggal Terima',
			'noterimamutasi' => 'No. Terima Mutasi',
			'totalharganetto_mutasi' => 'Total Harga Netto Mutasi',
			'totalhargajual_mutasi' => 'Total Harga Jual Mutasi',
			'keteranganmutasi' => 'Keterangan Mutasi',
			'totalharganetto_terima' => 'Total Harga Netto Terima',
			'totalhargajual_terima' => 'Total Harga Jual Terima',
			'keterangan_terima' => 'Keterangan Terima',
			'instalasipemesan_id' => 'Instalasi Pemesan',
			'instalasipemesan_nama' => 'Instalasi Pemesan',
			'ruanganpemesan_id' => 'Ruangan Pemesan',
			'ruanganpemesan_nama' => 'Ruangan Pemesan',
			'instalasiasalmutasi_id' => 'Instalasi Asal Mutasi',
			'instalasiasalmutasi_nama' => 'Instalasi Asal Mutasi',
			'ruanganasalmutasi_id' => 'Ruangan Asal Mutasi',
			'ruanganasalmutasi_nama' => 'Ruangan Asal Mutasi',
			'instalasitujuanmutasi_id' => 'Instalasi Tujuan Mutasi',
			'instalasitujuanmutasi_nama' => 'Instalasi Tujuan Mutasi',
			'ruangantujuanmutasi_id' => 'Ruangan Tujuan Mutasi',
			'ruangantujuanmutasi_nama' => 'Ruangan Tujuan Mutasi',
			'instalasipenerima_id' => 'Instalasi Penerima',
			'instalasipenerima_nama' => 'Instalasi Penerima',
			'ruanganpenerima_id' => 'Ruangan Penerima',
			'ruanganpenerima_nama' => 'Ruangan Penerima',
			'pegawaipemesan_id' => 'Pegawai Pemesan',
			'pegawaipemesan_gelardepan' => 'Pegawaipemesan Gelardepan',
			'pegawaipemesan_nama' => 'Pegawaipemesan Nama',
			'pegawaipemesan_gelarbelakang' => 'Pegawaipemesan Gelarbelakang',
			'pegawaimengetahuipesanan_id' => 'Pegawai Mengetahui',
			'pegawaimengetahuipesanan_gelardepan' => 'Pegawaimengetahuipesanan Gelardepan',
			'pegawaimengetahuipesanan_nama' => 'Pegawaimengetahuipesanan Nama',
			'pegawaimengetahuipesanan_gelarbelakang' => 'Pegawaimengetahuipesanan Gelarbelakang',
			'pegawaimutasi_id' => 'Pegawai Mutasi',
			'pegawaimutasi_gelardepan' => 'Pegawaimutasi Gelardepan',
			'pegawaimutasi_nama' => 'Pegawaimutasi Nama',
			'pegawaimutasi_gelarbelakang' => 'Pegawaimutasi Gelarbelakang',
			'pegawaimengetahuimutasi_id' => 'Pegawai Mengetahui',
			'pegawaimengetahuimutasi_gelardepan' => 'Pegawaimengetahuimutasi Gelardepan',
			'pegawaimengetahuimutasi_nama' => 'Pegawaimengetahuimutasi Nama',
			'pegawaimengetahuimutasi_gelarbelakang' => 'Pegawaimengetahuimutasi Gelarbelakang',
			'pegawaipenerima_id' => 'Pegawai Penerima',
			'pegawaipenerima_gelardepan' => 'Pegawaipenerima Gelardepan',
			'pegawaipenerima_nama' => 'Pegawaipenerima Nama',
			'pegawaipenerima_gelarbelakang' => 'Pegawaipenerima Gelarbelakang',
			'pegawaimengetahuipenerimaan_id' => 'Pegawai Mengetahui',
			'pegawaimengetahuipenerimaan_gelardepan' => 'Pegawaimengetahuipenerimaan Gelardepan',
			'pegawaimengetahuipenerimaan_nama' => 'Pegawaimengetahuipenerimaan Nama',
			'pegawaimengetahuipenerimaan_gelarbelakang' => 'Pegawaimengetahuipenerimaan Gelarbelakang',
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

		$criteria->compare('mutasioaruangan_id',$this->mutasioaruangan_id);
		$criteria->compare('LOWER(tglmutasioa)',strtolower($this->tglmutasioa),true);
		$criteria->compare('LOWER(nomutasioa)',strtolower($this->nomutasioa),true);
		$criteria->compare('pesanobatalkes_id',$this->pesanobatalkes_id);
		$criteria->compare('LOWER(tglpemesanan)',strtolower($this->tglpemesanan),true);
		$criteria->compare('LOWER(nopemesanan)',strtolower($this->nopemesanan),true);
		$criteria->compare('LOWER(tglmintadikirim)',strtolower($this->tglmintadikirim),true);
		$criteria->compare('LOWER(statuspesan)',strtolower($this->statuspesan),true);
		$criteria->compare('LOWER(keterangan_pesan)',strtolower($this->keterangan_pesan),true);
		$criteria->compare('terimamutasi_id',$this->terimamutasi_id);
		$criteria->compare('LOWER(tglterima)',strtolower($this->tglterima),true);
		$criteria->compare('LOWER(noterimamutasi)',strtolower($this->noterimamutasi),true);
		$criteria->compare('totalharganetto_mutasi',$this->totalharganetto_mutasi);
		$criteria->compare('totalhargajual_mutasi',$this->totalhargajual_mutasi);
		$criteria->compare('LOWER(keteranganmutasi)',strtolower($this->keteranganmutasi),true);
		$criteria->compare('totalharganetto_terima',$this->totalharganetto_terima);
		$criteria->compare('totalhargajual_terima',$this->totalhargajual_terima);
		$criteria->compare('LOWER(keterangan_terima)',strtolower($this->keterangan_terima),true);
		$criteria->compare('instalasipemesan_id',$this->instalasipemesan_id);
		$criteria->compare('LOWER(instalasipemesan_nama)',strtolower($this->instalasipemesan_nama),true);
		$criteria->compare('ruanganpemesan_id',$this->ruanganpemesan_id);
		$criteria->compare('LOWER(ruanganpemesan_nama)',strtolower($this->ruanganpemesan_nama),true);
		$criteria->compare('instalasiasalmutasi_id',$this->instalasiasalmutasi_id);
		$criteria->compare('LOWER(instalasiasalmutasi_nama)',strtolower($this->instalasiasalmutasi_nama),true);
		$criteria->compare('ruanganasalmutasi_id',$this->ruanganasalmutasi_id);
		$criteria->compare('LOWER(ruanganasalmutasi_nama)',strtolower($this->ruanganasalmutasi_nama),true);
		$criteria->compare('instalasitujuanmutasi_id',$this->instalasitujuanmutasi_id);
		$criteria->compare('LOWER(instalasitujuanmutasi_nama)',strtolower($this->instalasitujuanmutasi_nama),true);
		$criteria->compare('ruangantujuanmutasi_id',$this->ruangantujuanmutasi_id);
		$criteria->compare('LOWER(ruangantujuanmutasi_nama)',strtolower($this->ruangantujuanmutasi_nama),true);
		$criteria->compare('instalasipenerima_id',$this->instalasipenerima_id);
		$criteria->compare('LOWER(instalasipenerima_nama)',strtolower($this->instalasipenerima_nama),true);
		$criteria->compare('ruanganpenerima_id',$this->ruanganpenerima_id);
		$criteria->compare('LOWER(ruanganpenerima_nama)',strtolower($this->ruanganpenerima_nama),true);
		$criteria->compare('pegawaipemesan_id',$this->pegawaipemesan_id);
		$criteria->compare('LOWER(pegawaipemesan_gelardepan)',strtolower($this->pegawaipemesan_gelardepan),true);
		$criteria->compare('LOWER(pegawaipemesan_nama)',strtolower($this->pegawaipemesan_nama),true);
		$criteria->compare('LOWER(pegawaipemesan_gelarbelakang)',strtolower($this->pegawaipemesan_gelarbelakang),true);
		$criteria->compare('pegawaimengetahuipesanan_id',$this->pegawaimengetahuipesanan_id);
		$criteria->compare('LOWER(pegawaimengetahuipesanan_gelardepan)',strtolower($this->pegawaimengetahuipesanan_gelardepan),true);
		$criteria->compare('LOWER(pegawaimengetahuipesanan_nama)',strtolower($this->pegawaimengetahuipesanan_nama),true);
		$criteria->compare('LOWER(pegawaimengetahuipesanan_gelarbelakang)',strtolower($this->pegawaimengetahuipesanan_gelarbelakang),true);
		$criteria->compare('pegawaimutasi_id',$this->pegawaimutasi_id);
		$criteria->compare('LOWER(pegawaimutasi_gelardepan)',strtolower($this->pegawaimutasi_gelardepan),true);
		$criteria->compare('LOWER(pegawaimutasi_nama)',strtolower($this->pegawaimutasi_nama),true);
		$criteria->compare('LOWER(pegawaimutasi_gelarbelakang)',strtolower($this->pegawaimutasi_gelarbelakang),true);
		$criteria->compare('pegawaimengetahuimutasi_id',$this->pegawaimengetahuimutasi_id);
		$criteria->compare('LOWER(pegawaimengetahuimutasi_gelardepan)',strtolower($this->pegawaimengetahuimutasi_gelardepan),true);
		$criteria->compare('LOWER(pegawaimengetahuimutasi_nama)',strtolower($this->pegawaimengetahuimutasi_nama),true);
		$criteria->compare('LOWER(pegawaimengetahuimutasi_gelarbelakang)',strtolower($this->pegawaimengetahuimutasi_gelarbelakang),true);
		$criteria->compare('pegawaipenerima_id',$this->pegawaipenerima_id);
		$criteria->compare('LOWER(pegawaipenerima_gelardepan)',strtolower($this->pegawaipenerima_gelardepan),true);
		$criteria->compare('LOWER(pegawaipenerima_nama)',strtolower($this->pegawaipenerima_nama),true);
		$criteria->compare('LOWER(pegawaipenerima_gelarbelakang)',strtolower($this->pegawaipenerima_gelarbelakang),true);
		$criteria->compare('pegawaimengetahuipenerimaan_id',$this->pegawaimengetahuipenerimaan_id);
		$criteria->compare('LOWER(pegawaimengetahuipenerimaan_gelardepan)',strtolower($this->pegawaimengetahuipenerimaan_gelardepan),true);
		$criteria->compare('LOWER(pegawaimengetahuipenerimaan_nama)',strtolower($this->pegawaimengetahuipenerimaan_nama),true);
		$criteria->compare('LOWER(pegawaimengetahuipenerimaan_gelarbelakang)',strtolower($this->pegawaimengetahuipenerimaan_gelarbelakang),true);

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