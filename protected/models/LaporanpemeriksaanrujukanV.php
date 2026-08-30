<?php

/**
 * This is the model class for table "laporanpemeriksaanrujukan_v".
 *
 * The followings are the available columns in table 'laporanpemeriksaanrujukan_v':
 * @property integer $tindakanpelayanan_id
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $daftartindakan_katakunci
 * @property integer $pasienmasukpenunjang_id
 * @property string $no_masukpenunjang
 * @property double $tarif_satuan
 * @property integer $qty_tindakan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $tindakansudahbayar_id
 * @property string $tgl_tindakan
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property integer $rujukan_id
 * @property integer $asalrujukan_id
 * @property string $asalrujukan_nama
 * @property string $asalrujukan_institusi
 * @property string $no_rujukan
 * @property string $nama_perujuk
 * @property string $tglmasukpenunjang
 */
class LaporanpemeriksaanrujukanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpemeriksaanrujukanV the static model class
	 */
        public $tgl_awal, $tgl_akhir, $bulan, $hari, $tahun;
        public $jumlah, $data, $tick;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanpemeriksaanrujukan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tindakanpelayanan_id, daftartindakan_id, pasienmasukpenunjang_id, qty_tindakan, tindakansudahbayar_id, pendaftaran_id, rujukan_id, asalrujukan_id', 'numerical', 'integerOnly'=>true),
			array('tarif_satuan', 'numerical'),
			array('daftartindakan_kode, no_masukpenunjang, no_pendaftaran', 'length', 'max'=>20),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('daftartindakan_katakunci', 'length', 'max'=>30),
			array('asalrujukan_nama, asalrujukan_institusi, nama_perujuk', 'length', 'max'=>50),
			array('no_rujukan', 'length', 'max'=>10),
			array('create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_tindakan, tglmasukpenunjang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakanpelayanan_id, jumlah, data, tick, daftartindakan_id, tgl_awal, tgl_akhir, bulan, hari, tahun, daftartindakan_kode, daftartindakan_nama, daftartindakan_katakunci, pasienmasukpenunjang_id, no_masukpenunjang, tarif_satuan, qty_tindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tindakansudahbayar_id, tgl_tindakan, pendaftaran_id, no_pendaftaran, rujukan_id, asalrujukan_id, asalrujukan_nama, asalrujukan_institusi, no_rujukan, nama_perujuk, tglmasukpenunjang', 'safe', 'on'=>'search'),
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
                    'pendaftaran'=>array(self::HAS_MANY,'PendaftaranT','pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'daftartindakan_katakunci' => 'Daftartindakan Katakunci',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'no_masukpenunjang' => 'No. Masukpenunjang',
			'tarif_satuan' => 'Tarif Satuan',
			'qty_tindakan' => 'Jumlah Tindakan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tindakansudahbayar_id' => 'Tindakansudahbayar',
			'tgl_tindakan' => 'Tanggal Tindakan',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'rujukan_id' => 'Rujukan',
			'asalrujukan_id' => 'Asalrujukan',
			'asalrujukan_nama' => 'Asalrujukan Nama',
			'asalrujukan_institusi' => 'Asalrujukan Institusi',
			'no_rujukan' => 'No. Rujukan',
			'nama_perujuk' => 'Nama Perujuk',
			'tglmasukpenunjang' => 'Tglmasukpenunjang',
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

		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('tindakansudahbayar_id',$this->tindakansudahbayar_id);
		$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('rujukan_id',$this->rujukan_id);
		$criteria->compare('asalrujukan_id',$this->asalrujukan_id);
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		$criteria->compare('LOWER(asalrujukan_institusi)',strtolower($this->asalrujukan_institusi),true);
		$criteria->compare('LOWER(no_rujukan)',strtolower($this->no_rujukan),true);
		$criteria->compare('LOWER(nama_perujuk)',strtolower($this->nama_perujuk),true);
		$criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('tindakansudahbayar_id',$this->tindakansudahbayar_id);
		$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('rujukan_id',$this->rujukan_id);
		$criteria->compare('asalrujukan_id',$this->asalrujukan_id);
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		$criteria->compare('LOWER(asalrujukan_institusi)',strtolower($this->asalrujukan_institusi),true);
		$criteria->compare('LOWER(no_rujukan)',strtolower($this->no_rujukan),true);
		$criteria->compare('LOWER(nama_perujuk)',strtolower($this->nama_perujuk),true);
		$criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}