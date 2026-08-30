<?php

/**
 * This is the model class for table "laporantindakanruangan_v".
 *
 * The followings are the available columns in table 'laporantindakanruangan_v':
 * @property integer $tindakanpelayanan_id
 * @property integer $daftartindakan_id
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property string $tgl_tindakan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $tindakansudahbayar_id
 * @property double $tarif_satuan
 * @property string $qty_tindakan
 */

class LaporanjasatindakanradV extends CActiveRecord
{
	public $tgl_awal, $bln_awal, $thn_awal;
	public $tgl_akhir, $bln_akhir, $thn_akhir;
	public $jns_periode;
	public $tick, $jumlah, $data;
	public $tindakanpelayanan_id;
	public $daftartindakan_id, $daftartindakan_kode, $daftartindakan_nama, $daftartindakan_karcis, $daftartindakan_visite;
	public $daftartindakan_konsul, $satuantindakan, $cyto_tindakan;
	public $tglpembayaran, $nopembayaran;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporantindakanruanganV the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanjasatindakanrad_v';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		
			array('pendaftaran_id, tindakanpelayanan_id,jenispemeriksaanrad_id,pemeriksaanrad_kode,pemeriksaanrad_nama, instalasi_id,ruangan_id, daftartindakan_id, tgl_tindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, qty_tindakan, tarif_satuan, tindakansudahbayar_id, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama,jns_periode,bln_awal,bln_akhir,thn_awal,thn_akhir,tgl_awal,tgl_akhir', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendaftaran_id, tindakanpelayanan_id,jenispemeriksaanrad_id,pemeriksaanrad_kode,pemeriksaanrad_nama, instalasi_id,ruangan_id, daftartindakan_id, tgl_tindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, qty_tindakan, tarif_satuan, tindakansudahbayar_id, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama,jns_periode,bln_awal,bln_akhir,thn_awal,thn_akhir,tgl_awal,tgl_akhir', 'safe', 'on' => 'searchTable'),
			
		);
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pendaftaran_id' => 'Pendaftaran',
			'tindakanpelayanan_id' => 'Pelayanan',
			'jenispemeriksaanrad_id' => 'Jenis Pemeriksaan',
			'pemeriksaanrad_kode' => 'Kode Pemeriksaan',
			'pemeriksaanrad_nama' => 'Nama Pemeriksaan',
			'instalasi_id' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'daftartindakan_id' => 'Tindakan',
            'tarif_satuan' => 'Tarif Satuan',
			'qty_tindakan' => 'Jumlah',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tindakansudahbayar_id' => 'Tindakan Sudah Bayar',
			'tgl_tindakan' => 'Tanggal Tindakan',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Nama Penjamin',
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
		$criteria = new CDbCriteria;
		$criteria->compare('instalasi_id', $this->instalasi_id);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		$criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		$criteria->compare('tarif_satuan', $this->tarif_satuan);
		$criteria->compare('LOWER(qty_tindakan)', strtolower($this->qty_tindakan), true);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria = new CDbCriteria;
		$criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
		$criteria->compare('instalasi_id', $this->instalasi_id);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)', strtolower($this->daftartindakan_kode), true);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		$criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		$criteria->compare('tindakansudahbayar_id', $this->tindakansudahbayar_id);
		$criteria->compare('tarif_satuan', $this->tarif_satuan);
		$criteria->compare('qty_tindakan', $this->qty_tindakan, true);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
	
	public function getCaraBayarItems()
	{
		return CarabayarM::model()->findAll('carabayar_aktif=TRUE ORDER BY carabayar_nama ASC');
	}

	public function getDaftarTindakanItems()
	{
		return DaftartindakanM::model()->findAll('daftartindakan_aktif=TRUE ORDER BY daftartindakan_nama ASC');
	}

	public function getCaraBayarPenjamin()
	{
		return $this->carabayar_nama . ' / <br/> ' . $this->penjamin_nama;
	}
	
	public function getPenjaminItems()
	{
		return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE ORDER BY penjamin_nama ASC');
	}
	
	public function getTotalTarif()
	{
		return $this->tarif_satuan * $this->qty_tindakan;
	}

	
	
}
