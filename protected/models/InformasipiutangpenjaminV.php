<?php

/**
 * This is the model class for table "informasipiutangpenjamin_v".
 *
 * The followings are the available columns in table 'informasipiutangpenjamin_v':
 * @property integer $pembayaranpelayanan_id
 * @property string $nopembayaran
 * @property string $tglpembayaran
 * @property double $totalbiayaoa
 * @property double $totalbiayatindakan
 * @property double $totalbiayapelayanan
 * @property double $totaliurbiaya
 * @property double $totaldiscount
 * @property double $totalpiutang
 * @property integer $tandabuktibayar_id
 * @property string $nobuktibayar
 * @property string $tglbuktibayar
 * @property string $dengankartu
 * @property string $bankkartu
 * @property string $nokartu
 * @property string $nostrukkartu
 * @property string $darinama_bkm
 * @property integer $bank_id
 * @property string $bank_namapengirim
 * @property string $namabank
 * @property string $norekening
 * @property double $bank_nominal
 * @property integer $closingkasir_id
 * @property double $biayaadministrasi
 * @property double $biayamaterai
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $kelastanggungan_id
 * @property string $kelastanggungan_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property double $totalbayar_nontunai
 * @property double $totalbayar_tunai
 * @property string $tglpengajuanklaimanklaim
 * @property string $nopengajuanklaimanklaim
 * @property double $totalbayar
 * @property double $telahbayar
 */
class InformasipiutangpenjaminV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipiutangpenjaminV the static model class
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
		return 'informasipiutangpenjamin_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembayaranpelayanan_id, tandabuktibayar_id, bank_id, closingkasir_id, pendaftaran_id, pasien_id, ruangan_id, instalasi_id, penjamin_id, carabayar_id, kelastanggungan_id, kelaspelayanan_id, pengajuanklaimpiutang_id', 'numerical', 'integerOnly'=>true),
			array('totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, totaliurbiaya, totaldiscount, totalpiutang, bank_nominal, biayaadministrasi, biayamaterai, totalbayar_nontunai, totalbayar_tunai, totalbayar, telahbayar', 'numerical'),
			array('nopembayaran, nobuktibayar, dengankartu, nama_pasien, ruangan_nama, instalasi_nama, penjamin_nama, carabayar_nama, kelastanggungan_nama, kelaspelayanan_nama, nopengajuanklaimanklaim', 'length', 'max'=>50),
			array('bankkartu, nokartu, nostrukkartu, darinama_bkm, namabank, norekening', 'length', 'max'=>100),
			array('bank_namapengirim', 'length', 'max'=>200),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('tglpembayaran, tglbuktibayar, tgl_pendaftaran, tglpengajuanklaimanklaim, tgljatuhtempo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembayaranpelayanan_id, nopembayaran, tglpembayaran, totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, totaliurbiaya, totaldiscount, totalpiutang, tandabuktibayar_id, nobuktibayar, tglbuktibayar, dengankartu, bankkartu, nokartu, nostrukkartu, darinama_bkm, bank_id, bank_namapengirim, namabank, norekening, bank_nominal, closingkasir_id, biayaadministrasi, biayamaterai, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, pasien_id, no_rekam_medik, nama_pasien, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, penjamin_id, penjamin_nama, carabayar_id, carabayar_nama, kelastanggungan_id, kelastanggungan_nama, kelaspelayanan_id, kelaspelayanan_nama, totalbayar_nontunai, totalbayar_tunai, tglpengajuanklaimanklaim, nopengajuanklaimanklaim, totalbayar, telahbayar, tgljatuhtempo, pengajuanklaimpiutang_id', 'safe', 'on'=>'search'),
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
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'nopembayaran' => 'No. Pembayaran',
			'tglpembayaran' => 'Tgl. Pembayaran',
			'totalbiayaoa' => 'Totalbiayaoa',
			'totalbiayatindakan' => 'Totalbiayatindakan',
			'totalbiayapelayanan' => 'Totalbiayapelayanan',
			'totaliurbiaya' => 'Totaliurbiaya',
			'totaldiscount' => 'Total Keringanan',
			'totalpiutang' => 'Totalpiutang',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'nobuktibayar' => 'Nobuktibayar',
			'tglbuktibayar' => 'Tglbuktibayar',
			'dengankartu' => 'Dengankartu',
			'bankkartu' => 'Bankkartu',
			'nokartu' => 'Nokartu',
			'nostrukkartu' => 'Nostrukkartu',
			'darinama_bkm' => 'Darinama Bkm',
			'bank_id' => 'Bank',
			'bank_namapengirim' => 'Bank Namapengirim',
			'namabank' => 'Namabank',
			'norekening' => 'Norekening',
			'bank_nominal' => 'Bank Nominal',
			'closingkasir_id' => 'Closingkasir',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayamaterai' => 'Biayamaterai',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'kelastanggungan_id' => 'Kelastanggungan',
			'kelastanggungan_nama' => 'Kelastanggungan Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'totalbayar_nontunai' => 'Totalbayar Nontunai',
			'totalbayar_tunai' => 'Totalbayar Tunai',
			'tglpengajuanklaimanklaim' => 'Tglpengajuanklaimanklaim',
			'nopengajuanklaimanklaim' => 'Nopengajuanklaimanklaim',
			'totalbayar' => 'Totalbayar',
			'telahbayar' => 'Telahbayar',
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

		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('nopembayaran',$this->nopembayaran,true);
		$criteria->compare('tglpembayaran',$this->tglpembayaran,true);
		$criteria->compare('totalbiayaoa',$this->totalbiayaoa);
		$criteria->compare('totalbiayatindakan',$this->totalbiayatindakan);
		$criteria->compare('totalbiayapelayanan',$this->totalbiayapelayanan);
		$criteria->compare('totaliurbiaya',$this->totaliurbiaya);
		$criteria->compare('totaldiscount',$this->totaldiscount);
		$criteria->compare('totalpiutang',$this->totalpiutang);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('nobuktibayar',$this->nobuktibayar,true);
		$criteria->compare('tglbuktibayar',$this->tglbuktibayar,true);
		$criteria->compare('dengankartu',$this->dengankartu,true);
		$criteria->compare('bankkartu',$this->bankkartu,true);
		$criteria->compare('nokartu',$this->nokartu,true);
		$criteria->compare('nostrukkartu',$this->nostrukkartu,true);
		$criteria->compare('darinama_bkm',$this->darinama_bkm,true);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('bank_namapengirim',$this->bank_namapengirim,true);
		$criteria->compare('namabank',$this->namabank,true);
		$criteria->compare('norekening',$this->norekening,true);
		$criteria->compare('bank_nominal',$this->bank_nominal);
		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('biayamaterai',$this->biayamaterai);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('kelastanggungan_id',$this->kelastanggungan_id);
		$criteria->compare('kelastanggungan_nama',$this->kelastanggungan_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('totalbayar_nontunai',$this->totalbayar_nontunai);
		$criteria->compare('totalbayar_tunai',$this->totalbayar_tunai);
		$criteria->compare('tglpengajuanklaimanklaim',$this->tglpengajuanklaimanklaim,true);
		$criteria->compare('nopengajuanklaimanklaim',$this->nopengajuanklaimanklaim,true);
		$criteria->compare('totalbayar',$this->totalbayar);
		$criteria->compare('telahbayar',$this->telahbayar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}