<?php

/**
 * This is the model class for table "pengeluaranumum_t".
 *
 * The followings are the available columns in table 'pengeluaranumum_t':
 * @property integer $pengeluaranumum_id
 * @property integer $tandabuktikeluar_id
 * @property integer $jenispengeluaran_id
 * @property string $kelompoktransaksi
 * @property string $nopengeluaran
 * @property string $tglpengeluaran
 * @property double $volume
 * @property string $satuanvol
 * @property double $hargasatuan
 * @property double $totalharga
 * @property double $biayaadministrasi
 * @property string $keterangankeluar
 * @property boolean $isurainkeluarumum
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PengeluaranumumT extends CActiveRecord
{
    public $jenisKodeNama,$tgl_awal,$tgl_akhir, $totalpajak, $checklist, $jmlsetoran, $sisahutang, $keterangan, $jenispengeluaran_nama, $pajak_nama, $pajak_id;
	public $pegawaimengetahui_nama;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengeluaranumumT the static model class
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
		return 'pengeluaranumum_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispengeluaran_id, kelompoktransaksi, nopengeluaran, tglpengeluaran, hargasatuan, totalharga, biayaadministrasi', 'required'),
			array('tandabuktikeluar_id, jenispengeluaran_id, pph21_id, pph22_id, pph23_id, closingkasir_id, invoicetagihan_id, shift_id', 'numerical', 'integerOnly'=>true),
			array('volume, hargasatuan, totalharga, biayaadministrasi, jmlpph_21', 'numerical'),
			array('kelompoktransaksi, nopengeluaran, satuanvol', 'length', 'max'=>50),
			array('jenisKodeNama, keterangankeluar, isurainkeluarumum, update_time, update_loginpemakai_id, create_ruangan, jmlpph_21, jmlpph_22, jmlpph_23, ppn, ispenggajian', 'safe'),
            array('pegawaimengetahui_id', 'safe'),        

                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengeluaranumum_id, tandabuktikeluar_id, tgl_awal, tgl_akhir, jenispengeluaran_id, kelompoktransaksi, nopengeluaran, tglpengeluaran, volume, satuanvol, hargasatuan, totalharga, biayaadministrasi, keterangankeluar, isurainkeluarumum, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jmlpph_21, jmlpph_22, jmlpph_23, pph21_id, pph22_id, pph23_id, closingkasir_id, invoicetagihan_id, ispenggajian, shift_id', 'safe', 'on'=>'search'),
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
                    'uraian'=>array(self::HAS_MANY, 'UraiankeluarumumT', 'pengeluaranumum_id'),
                    'buktikeluar'=>array(self::BELONGS_TO, 'TandabuktikeluarT', 'tandabuktikeluar_id'),
                    'jenispengeluaran'=>array(self::BELONGS_TO, 'JenispengeluaranM', 'jenispengeluaran_id'),
					'pegawaimengetahui'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengeluaranumum_id' => 'Pengeluaranumum',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'jenispengeluaran_id' => 'Jenis Pengeluaran',
			'kelompoktransaksi' => 'Kelompok Transaksi',
			'nopengeluaran' => 'No. Pengeluaran',
			'tglpengeluaran' => 'Tanggal Pengeluaran',
			'volume' => 'Volume',
			'satuanvol' => 'Satuan Volume',
			'hargasatuan' => 'Harga',
			'totalharga' => 'Total Harga',
			'biayaadministrasi' => 'Biaya Administrasi',
			'keterangankeluar' => 'Keterangan Pengeluaran/Nomor Cek/Bilyet Giro',
			'isurainkeluarumum' => 'Uraian Transaksi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pegawaimengetahui_id' => "Pegawai Mengetahui",
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

		$criteria->compare('pengeluaranumum_id',$this->pengeluaranumum_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('LOWER(kelompoktransaksi)',strtolower($this->kelompoktransaksi),true);
		$criteria->compare('LOWER(nopengeluaran)',strtolower($this->nopengeluaran),true);
		$criteria->compare('LOWER(tglpengeluaran)',strtolower($this->tglpengeluaran),true);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('LOWER(satuanvol)',strtolower($this->satuanvol),true);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('LOWER(keterangankeluar)',strtolower($this->keterangankeluar),true);
		$criteria->compare('isurainkeluarumum',$this->isurainkeluarumum);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pengeluaranumum_id',$this->pengeluaranumum_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('LOWER(kelompoktransaksi)',strtolower($this->kelompoktransaksi),true);
		$criteria->compare('LOWER(nopengeluaran)',strtolower($this->nopengeluaran),true);
		$criteria->compare('LOWER(tglpengeluaran)',strtolower($this->tglpengeluaran),true);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('LOWER(satuanvol)',strtolower($this->satuanvol),true);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('LOWER(keterangankeluar)',strtolower($this->keterangankeluar),true);
		$criteria->compare('isurainkeluarumum',$this->isurainkeluarumum);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
                
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                        }
            }
            return true;
        }
}