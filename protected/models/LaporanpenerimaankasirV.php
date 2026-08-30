<?php

/**
 * This is the model class for table "laporanpenerimaankasir_v".
 *
 * The followings are the available columns in table 'laporanpenerimaankasir_v':
 * @property integer $tandabuktibayar_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $shift_id
 * @property string $shift_nama
 * @property integer $nourutkasir
 * @property string $nobuktibayar
 * @property string $tglbuktibayar
 * @property string $carapembayaran
 * @property string $dengankartu
 * @property string $bankkartu
 * @property string $nokartu
 * @property string $nostrukkartu
 * @property string $darinama_bkm
 * @property string $alamat_bkm
 * @property string $sebagaipembayaran_bkm
 * @property double $jmlpembulatan
 * @property double $jmlpembayaran
 * @property double $biayaadministrasi
 * @property double $biayamaterai
 * @property double $uangditerima
 * @property double $uangkembalian
 * @property double $keterangan_pembayaran
 * @property string $create_time
 * @property string $update_time
 */
class LaporanpenerimaankasirV extends CActiveRecord
{   
        public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode, $jumlah, $tick, $data;
        public $pegawai_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpenerimaankasirV the static model class
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
		return 'laporanpenerimaankasir_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tandabuktibayar_id, ruangan_id, shift_id, nourutkasir', 'numerical', 'integerOnly'=>true),
			array('jmlpembulatan, jmlpembayaran, biayaadministrasi, biayamaterai, uangditerima, uangkembalian, keterangan_pembayaran', 'numerical'),
			array('ruangan_nama, shift_nama, nobuktibayar, carapembayaran, dengankartu', 'length', 'max'=>50),
			array('bankkartu, nokartu, nostrukkartu, darinama_bkm, sebagaipembayaran_bkm', 'length', 'max'=>100),
			array('pegawai_id, tglbuktibayar, alamat_bkm, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, tandabuktibayar_id, ruangan_id, ruangan_nama, shift_id, shift_nama, nourutkasir, nobuktibayar, tglbuktibayar, carapembayaran, dengankartu, bankkartu, nokartu, nostrukkartu, darinama_bkm, alamat_bkm, sebagaipembayaran_bkm, jmlpembulatan, jmlpembayaran, biayaadministrasi, biayamaterai, uangditerima, uangkembalian, keterangan_pembayaran, create_time, update_time', 'safe', 'on'=>'search'),
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
			'tandabuktibayar_id' => 'Tanda Bukti Bayar',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'shift_id' => 'Shift',
			'shift_nama' => 'Shift Nama',
			'nourutkasir' => 'No. Urut Kasir',
			'nobuktibayar' => 'No. Bukti Bayar',
			'tglbuktibayar' => 'Tanggal Bukti Bayar',
			'carapembayaran' => 'Cara Pembayaran',
			'dengankartu' => 'Dengan Kartu',
			'bankkartu' => 'Bank Kartu',
			'nokartu' => 'No. Kartu',
			'nostrukkartu' => 'No. Struk Kartu',
			'darinama_bkm' => 'Dari Nama Bkm',
			'alamat_bkm' => 'Alamat Bkm',
			'sebagaipembayaran_bkm' => 'Sebagai Pembayaran Bkm',
			'jmlpembulatan' => 'Jumlah Pembulatan',
			'jmlpembayaran' => 'Jumlah Pembayaran',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayamaterai' => 'Biaya Materai',
			'uangditerima' => 'Uang Diterima',
			'uangkembalian' => 'Uang Kembalian',
			'keterangan_pembayaran' => 'Keterangan Pembayaran',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
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

		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);
		$criteria->compare('nourutkasir',$this->nourutkasir);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('LOWER(carapembayaran)',strtolower($this->carapembayaran),true);
		$criteria->compare('LOWER(dengankartu)',strtolower($this->dengankartu),true);
		$criteria->compare('LOWER(bankkartu)',strtolower($this->bankkartu),true);
		$criteria->compare('LOWER(nokartu)',strtolower($this->nokartu),true);
		$criteria->compare('LOWER(nostrukkartu)',strtolower($this->nostrukkartu),true);
		$criteria->compare('LOWER(darinama_bkm)',strtolower($this->darinama_bkm),true);
		$criteria->compare('LOWER(alamat_bkm)',strtolower($this->alamat_bkm),true);
		$criteria->compare('LOWER(sebagaipembayaran_bkm)',strtolower($this->sebagaipembayaran_bkm),true);
		$criteria->compare('jmlpembulatan',$this->jmlpembulatan);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('biayamaterai',$this->biayamaterai);
		$criteria->compare('uangditerima',$this->uangditerima);
		$criteria->compare('uangkembalian',$this->uangkembalian);
		$criteria->compare('keterangan_pembayaran',$this->keterangan_pembayaran);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);
		$criteria->compare('nourutkasir',$this->nourutkasir);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('LOWER(carapembayaran)',strtolower($this->carapembayaran),true);
		$criteria->compare('LOWER(dengankartu)',strtolower($this->dengankartu),true);
		$criteria->compare('LOWER(bankkartu)',strtolower($this->bankkartu),true);
		$criteria->compare('LOWER(nokartu)',strtolower($this->nokartu),true);
		$criteria->compare('LOWER(nostrukkartu)',strtolower($this->nostrukkartu),true);
		$criteria->compare('LOWER(darinama_bkm)',strtolower($this->darinama_bkm),true);
		$criteria->compare('LOWER(alamat_bkm)',strtolower($this->alamat_bkm),true);
		$criteria->compare('LOWER(sebagaipembayaran_bkm)',strtolower($this->sebagaipembayaran_bkm),true);
		$criteria->compare('jmlpembulatan',$this->jmlpembulatan);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('biayamaterai',$this->biayamaterai);
		$criteria->compare('uangditerima',$this->uangditerima);
		$criteria->compare('uangkembalian',$this->uangkembalian);
		$criteria->compare('keterangan_pembayaran',$this->keterangan_pembayaran);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
//        RND-6992 Format date langsung diedit di view nya.   
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){                         
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                        }elseif ($column->dbType == 'timestamp without time zone'){
//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
//                        }
//            }
//            return true;
//        }
}