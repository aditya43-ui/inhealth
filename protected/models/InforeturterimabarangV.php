<?php

/**
 * This is the model class for table "inforeturterimabarang_v".
 *
 * The followings are the available columns in table 'inforeturterimabarang_v':
 * @property integer $returpenerimaan_id
 * @property string $noreturterima
 * @property string $tglreturterima
 * @property string $alasanreturterima
 * @property string $keterangan_retur
 * @property double $totalretur
 * @property integer $pegreturmengetahui_id
 * @property integer $pegretur_id
 * @property string $pegretur_nama
 * @property string $pegretur_gelardepan
 * @property string $pegretur_gelarbelakang
 * @property integer $terimapersediaan_id
 * @property string $tglterima
 * @property string $nopenerimaan
 * @property string $tglfaktur
 * @property string $nofaktur
 * @property string $tgljatuhtempo
 * @property integer $supplier_id
 * @property string $supplier_nama
 * @property string $supplier_kode
 * @property string $supplier_alamat
 * @property string $supplier_telp
 * @property string $supplier_fax
 * @property string $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 */
class InforeturterimabarangV extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InforeturterimabarangV the static model class
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
		return 'inforeturterimabarang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('returpenerimaan_id, pegreturmengetahui_id, pegretur_id, terimapersediaan_id, supplier_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('totalretur', 'numerical'),
			array('noreturterima, pegretur_nama, nopenerimaan, nofaktur, supplier_telp, supplier_fax, ruangan_nama, instalasi_nama', 'length', 'max'=>50),
			array('alasanreturterima, supplier_nama', 'length', 'max'=>100),
			array('pegretur_gelardepan, supplier_kode', 'length', 'max'=>10),
			array('pegretur_gelarbelakang', 'length', 'max'=>15),
			array('tglreturterima, keterangan_retur, tglterima, tglfaktur, tgljatuhtempo, supplier_alamat, ruangan_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('returpenerimaan_id, noreturterima, tglreturterima, alasanreturterima, keterangan_retur, totalretur, pegreturmengetahui_id, pegretur_id, pegretur_nama, pegretur_gelardepan, pegretur_gelarbelakang, terimapersediaan_id, tglterima, nopenerimaan, tglfaktur, nofaktur, tgljatuhtempo, supplier_id, supplier_nama, supplier_kode, supplier_alamat, supplier_telp, supplier_fax, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama', 'safe', 'on'=>'search'),
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
			'returpenerimaan_id' => 'Returpenerimaan',
			'noreturterima' => 'No. Retur',
			'tglreturterima' => 'Tgl. Retur',
			'alasanreturterima' => 'Alasan retur',
			'keterangan_retur' => 'Keterangan Retur',
			'totalretur' => 'Total Retur',
			'pegreturmengetahui_id' => 'Pegreturmengetahui',
			'pegretur_id' => 'Pegawai Retur',
			'pegretur_nama' => 'Pegretur Nama',
			'pegretur_gelardepan' => 'Pegretur Gelardepan',
			'pegretur_gelarbelakang' => 'Pegretur Gelarbelakang',
			'terimapersediaan_id' => 'Terima Persediaan',
			'tglterima' => 'Tglterima',
			'nopenerimaan' => 'No Penerimaan',
			'tglfaktur' => 'Tanggal Faktur',
			'nofaktur' => 'No. Faktur',
			'tgljatuhtempo' => 'Tgl. Jatuh Tempo',
			'supplier_id' => 'Supplier',
			'supplier_nama' => 'Nama Supplier',
			'supplier_kode' => 'Kode Supplier',
			'supplier_alamat' => 'Alamat Supplier',
			'supplier_telp' => 'Telepon Supplier',
			'supplier_fax' => 'Fax Supplier',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
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

		$criteria->compare('returpenerimaan_id',$this->returpenerimaan_id);
		$criteria->compare('noreturterima',$this->noreturterima,true);
		$criteria->compare('tglreturterima',$this->tglreturterima,true);
		$criteria->compare('alasanreturterima',$this->alasanreturterima,true);
		$criteria->compare('keterangan_retur',$this->keterangan_retur,true);
		$criteria->compare('totalretur',$this->totalretur);
		$criteria->compare('pegreturmengetahui_id',$this->pegreturmengetahui_id);
		$criteria->compare('pegretur_id',$this->pegretur_id);
		$criteria->compare('pegretur_nama',$this->pegretur_nama,true);
		$criteria->compare('pegretur_gelardepan',$this->pegretur_gelardepan,true);
		$criteria->compare('pegretur_gelarbelakang',$this->pegretur_gelarbelakang,true);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('tglterima',$this->tglterima,true);
		$criteria->compare('nopenerimaan',$this->nopenerimaan,true);
		$criteria->compare('tglfaktur',$this->tglfaktur,true);
		$criteria->compare('nofaktur',$this->nofaktur,true);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('supplier_kode',$this->supplier_kode,true);
		$criteria->compare('supplier_alamat',$this->supplier_alamat,true);
		$criteria->compare('supplier_telp',$this->supplier_telp,true);
		$criteria->compare('supplier_fax',$this->supplier_fax,true);
		$criteria->compare('ruangan_id',$this->ruangan_id,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}