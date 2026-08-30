<?php

/**
 * This is the model class for table "laporanpemeriksaanpenunjang_v".
 *
 * The followings are the available columns in table 'laporanpemeriksaanpenunjang_v':
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
 */
class LaporanpemeriksaanpenunjangV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpemeriksaanpenunjangV the static model class
	 */
        public $tgl_awal, $tgl_akhir, $bulan, $tahun, $hari;
        public $tick, $data, $jumlah;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanpemeriksaanpenunjang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carabayar_id, penjamnin_id, tindakanpelayanan_id, daftartindakan_id, pasienmasukpenunjang_id, qty_tindakan, tindakansudahbayar_id', 'numerical', 'integerOnly'=>true),
			array('tarif_satuan', 'numerical'),
			array('daftartindakan_kode, no_masukpenunjang', 'length', 'max'=>20),
			array('carabayar_nama, penjamin_nama, daftartindakan_nama', 'length', 'max'=>200),
			array('daftartindakan_katakunci', 'length', 'max'=>30),
			array('create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_tindakan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('carabayar_id, carabayar_nama, penjamnin_id, penjamin_nama, tindakanpelayanan_id, tgl_awal, tgl_akhir, bulan, tahun, haridaftartindakan_id, daftartindakan_kode, daftartindakan_nama, daftartindakan_katakunci, pasienmasukpenunjang_id, no_masukpenunjang, tarif_satuan, qty_tindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tindakansudahbayar_id, tgl_tindakan', 'safe', 'on'=>'search'),
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
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'daftartindakan_id' => 'Jenis Pemeriksaan',
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
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama);

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
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}