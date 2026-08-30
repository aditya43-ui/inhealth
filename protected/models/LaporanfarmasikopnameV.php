<?php

/**
 * This is the model class for table "laporanfarmasikopname_v".
 *
 * The followings are the available columns in table 'laporanfarmasikopname_v':
 * @property integer $stokopname_id
 * @property string $tglstokopname
 * @property string $nostokopname
 * @property boolean $isstokawal
 * @property string $jenisstokopname
 * @property string $keterangan_opname
 * @property double $totalharga
 * @property double $totalnetto
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $ruangan_id
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property integer $sumberdana_id
 * @property string $sumberdana_nama
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_kode
 * @property string $jenisobatalkes_nama
 * @property string $obatalkes_barcode
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_namalain
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $kemasanbesar
 * @property integer $kekuatan
 * @property string $satuankekuatan
 * @property double $volume_fisik
 * @property double $hargasatuan
 * @property double $jumlahharga
 * @property double $harganetto
 * @property double $jumlahnetto
 * @property string $tglkadaluarsa
 * @property string $kondisibarang
 */
class LaporanfarmasikopnameV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanfarmasikopnameV the static model class
	 */
        public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanfarmasikopname_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stokopname_id, ruangan_id, satuankecil_id, sumberdana_id, jenisobatalkes_id, kemasanbesar, kekuatan', 'numerical', 'integerOnly'=>true),
			array('totalharga, totalnetto, volume_fisik, hargasatuan, jumlahharga, harganetto, jumlahnetto', 'numerical'),
			array('nostokopname, jenisstokopname, satuankecil_nama, sumberdana_nama, jenisobatalkes_nama, obatalkes_namalain, obatalkes_golongan, obatalkes_kategori, kondisibarang', 'length', 'max'=>50),
			array('jenisobatalkes_kode', 'length', 'max'=>10),
			array('obatalkes_barcode, obatalkes_kode, obatalkes_nama', 'length', 'max'=>200),
			array('obatalkes_kadarobat, satuankekuatan', 'length', 'max'=>20),
			array('tglstokopname, isstokawal, keterangan_opname, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglkadaluarsa', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stokopname_id, tglstokopname, nostokopname, isstokawal, jenisstokopname, keterangan_opname, totalharga, totalnetto, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, ruangan_id, satuankecil_id, satuankecil_nama, sumberdana_id, sumberdana_nama, jenisobatalkes_id, jenisobatalkes_kode, jenisobatalkes_nama, obatalkes_barcode, obatalkes_kode, obatalkes_nama, obatalkes_namalain, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, kemasanbesar, kekuatan, satuankekuatan, volume_fisik, hargasatuan, jumlahharga, harganetto, jumlahnetto, tglkadaluarsa, kondisibarang, tgl_awal, tgl_akhir', 'safe', 'on'=>'search'),
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
			'stokopname_id' => 'Stock Opname',
			'tglstokopname' => 'Tanggal Stock Opname',
			'nostokopname' => 'No. Stock Opname',
			'isstokawal' => 'Status Stock Awal',
			'jenisstokopname' => 'Jenis Stock Opname',
			'keterangan_opname' => 'Keterangan Opname',
			'totalharga' => 'Total Harga',
			'totalnetto' => 'Total Netto',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'ruangan_id' => 'Ruangan',
			'satuankecil_id' => 'Satuan Kecil',
			'satuankecil_nama' => 'Satuan Kecil',
			'sumberdana_id' => 'Sumber Dana',
			'sumberdana_nama' => 'Sumber Dana',
			'jenisobatalkes_id' => 'Jenis Obat Alkes',
			'jenisobatalkes_kode' => 'Kode Jenis Obat Alkes',
			'jenisobatalkes_nama' => 'Jenis Obat Alkes',
			'obatalkes_barcode' => 'Barcode',
			'obatalkes_kode' => 'Kode Obat Alkes',
			'obatalkes_nama' => 'Nama Obat Alkes',
			'obatalkes_namalain' => 'Nama Lain Obat Alkes',
			'obatalkes_golongan' => 'Golongan Obat ',
			'obatalkes_kategori' => 'Kategori Obat',
			'obatalkes_kadarobat' => 'Kadar Obat Alkes',
			'kemasanbesar' => 'Kemasan Besar',
			'kekuatan' => 'Kekuatan',
			'satuankekuatan' => 'Satuan Kekuatan',
			'volume_fisik' => 'Volume Fisik',
			'hargasatuan' => 'Harga Satuan',
			'jumlahharga' => 'Jumlah Harga',
			'harganetto' => 'Harga Netto',
			'jumlahnetto' => 'Jumlah Netto',
			'tglkadaluarsa' => 'Tanggal Kedaluwarsa',
			'kondisibarang' => 'Kondisi Barang',
                        'tgl_awal'=>'Tanggal Stock Opname',
                        'tgl_akhir'=>'Sampai Dengan',
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

		$criteria->compare('stokopname_id',$this->stokopname_id);
		$criteria->compare('LOWER(tglstokopname)',strtolower($this->tglstokopname),true);
		$criteria->compare('LOWER(nostokopname)',strtolower($this->nostokopname),true);
		$criteria->compare('isstokawal',$this->isstokawal);
		$criteria->compare('LOWER(jenisstokopname)',strtolower($this->jenisstokopname),true);
		$criteria->compare('LOWER(keterangan_opname)',strtolower($this->keterangan_opname),true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('totalnetto',$this->totalnetto);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_kode)',strtolower($this->jenisobatalkes_kode),true);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('volume_fisik',$this->volume_fisik);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jumlahharga',$this->jumlahharga);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('jumlahnetto',$this->jumlahnetto);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('stokopname_id',$this->stokopname_id);
		$criteria->compare('LOWER(tglstokopname)',strtolower($this->tglstokopname),true);
		$criteria->compare('LOWER(nostokopname)',strtolower($this->nostokopname),true);
		$criteria->compare('isstokawal',$this->isstokawal);
		$criteria->compare('LOWER(jenisstokopname)',strtolower($this->jenisstokopname),true);
		$criteria->compare('LOWER(keterangan_opname)',strtolower($this->keterangan_opname),true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('totalnetto',$this->totalnetto);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_kode)',strtolower($this->jenisobatalkes_kode),true);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('volume_fisik',$this->volume_fisik);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jumlahharga',$this->jumlahharga);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('jumlahnetto',$this->jumlahnetto);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}