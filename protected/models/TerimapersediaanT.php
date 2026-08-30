<?php

/**
 * This is the model class for table "terimapersediaan_t".
 *
 * The followings are the available columns in table 'terimapersediaan_t':
 * @property integer $terimapersediaan_id
 * @property integer $pembelianbarang_id
 * @property integer $sumberdana_id
 * @property integer $returpenerimaan_id
 * @property string $tglterima
 * @property string $nopenerimaan
 * @property string $tglsuratjalan
 * @property string $nosuratjalan
 * @property string $tglfaktur
 * @property string $nofaktur
 * @property string $keterangan_persediaan
 * @property double $totalharga
 * @property double $discount
 * @property double $biayaadministrasi
 * @property double $pajakpph
 * @property double $pajakppn
 * @property string $nofakturpajak
 * @property integer $peg_penerima_id
 * @property integer $peg_mengetahui_id
 * @property integer $ruanganpenerima_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class TerimapersediaanT extends CActiveRecord
{
    
        public $tgl_awal, $tgl_akhir, $peg_penerima_nama, $peg_mengetahui_nama, $instalasi_id;
        public $jumlah;
        public $data;
        public $tick;
        public $pilihanx;
        public $persenpph_22, $nopembelian, $pajak_nama, $is_langsungfaktur, $supplier_nama;


        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimapersediaanT the static model class
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
		return 'terimapersediaan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sumberdana_id, tglterima, nopenerimaan, totalharga, discount, biayaadministrasi, ruanganpenerima_id', 'required'),
			array('pembelianbarang_id, sumberdana_id, returpenerimaan_id, peg_penerima_id, peg_mengetahui_id, ruanganpenerima_id, pegawaimenyetujuikeuangan_id, pajak_id, jlmuangmukabeli', 'numerical', 'integerOnly'=>true),
			array('totalharga, discount, biayaadministrasi, pajakpph, pajakppn, persendiscount, persenppn, persenpph, totalhutangusaha', 'numerical'),
			array('nopenerimaan', 'length', 'max'=>50),
			array('nosuratjalan, nofaktur', 'length', 'max'=>50),
			array('nofakturpajak', 'length', 'max'=>100),
                        array('is_dokumenlengkap, nofaktur, bentuk_dokumen, no_dokumen, tgl_dokumen, totalkeseluruhan, syaratbayar_id, peg_penerima_nama, peg_mengetahui_nama, instalasi_id, tglsuratjalan, tglfaktur, keterangan_persediaan, update_time, update_loginpemakai_id, '
                            . 'tgl_pembayaran, tgl_sp_penerimaan, no_sp_penerimaan, tgl_ba_penerimaan, no_ba_penerimaan, tgl_ba_pemeriksaan, no_ba_pemeriksaan, '
                            . 'lokasigudang_id, spesifikasi, rekeningbelanja_id, diskon_persen, diskon_total, ppn_persen, ppn_total, tglkadaluarsa, keterangan,rekeningbelanja_id', 'safe'),
			array('tgljatuhtempo, totalkeseluruhan, syaratbayar_id, supplier_id, peg_penerima_nama, peg_mengetahui_nama, instalasi_id, tglsuratjalan, tglfaktur, keterangan_persediaan, update_time, update_loginpemakai_id, persendiscount, persenppn, persenpph, tgl_menyetujuikeuangan, keteranganfaktur,is_terimalangsung', 'safe'),
			array('create_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert'),
			array('update_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert, update'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert, update'),
			array('create_ruangan', 'default','value'=>Yii::app()->user->getState('ruangan_id'), 'setOnEmpty'=>false, 'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, terimapersediaan_id, pembelianbarang_id, jumlah, data, tick, pilihanx,  sumberdana_id, returpenerimaan_id, tglterima, nopenerimaan, tglsuratjalan, nosuratjalan, tglfaktur, nofaktur, keterangan_persediaan, totalharga, discount, biayaadministrasi, pajakpph, pajakppn, nofakturpajak, peg_penerima_id, peg_mengetahui_id, ruanganpenerima_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgljatuhtempo, persendiscount, persenppn, persenpph, pegawaimenyetujuikeuangan_id, tgl_menyetujuikeuangan, keteranganfaktur, pajak_id, totalhutangusaha, jlmuangmukabeli', 'safe', 'on'=>'search'),
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
                    'pembelianbarang'=>array(self::BELONGS_TO, 'PembelianbarangT', 'pembelianbarang_id'),
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'ruanganpenerima_id'),
                    'penerima'=>array(self::BELONGS_TO, 'PegawaiM', 'peg_penerima_id'),
                    'mengetahui'=>array(self::BELONGS_TO, 'PegawaiM', 'peg_mengetahui_id'),
                    'sumberdana'=>array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
                    'supplier'=>array(self::BELONGS_TO,'SupplierM', 'supplier_id'),
                    'syaratbayar'=>array(self::BELONGS_TO,'SyaratbayarM', 'syaratbayar_id'),
                    'pajak'=>array(self::BELONGS_TO,'PajakM', 'pajak_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'terimapersediaan_id' => 'Terima Persediaan',
			'pembelianbarang_id' => 'Pembelian Barang',
			'sumberdana_id' => 'Sumber Dana',
			'returpenerimaan_id' => 'Returpenerimaan',
			'tglterima' => 'Tanggal Terima',
			'nopenerimaan' => 'No. Penerimaan',
			'tglsuratjalan' => 'Tanggal Surat Jalan',
			'nosuratjalan' => 'No. Surat Jalan',
			'tglfaktur' => 'Tanggal Faktur',
			'nofaktur' => 'No. Faktur',
			'keterangan_persediaan' => 'Keterangan Penerimaan',
			'totalharga' => 'Total Harga',
			'discount' => 'Keringanan',
			'biayaadministrasi' => 'Biaya Administrasi',
			'pajakpph' => 'Pajak PPH',
			'pajakppn' => 'Pajak PPN',
			'nofakturpajak' => 'No. Faktur Pajak',
			'peg_penerima_id' => 'Pegawai Penerima',
			'peg_mengetahui_id' => 'Pegawai Mengetahui',
			'ruanganpenerima_id' => 'Ruangan Penerima',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tgljatuhtempo'=> 'Tanggal Jatuh Tempo',
			'supplier_id'=> 'Supplier',
                        'syaratbayar_id' => 'Syarat Bayar',
			'totalkeseluruhan' => 'Total Keseluruhan',
                        'keteranganfaktur' => 'Keterangan',
                        'pajak_id' => 'Jenis Pajak',
						'is_terimalangsung' => 'Penerimaan Langsung'
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

		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('pembelianbarang_id',$this->pembelianbarang_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('returpenerimaan_id',$this->returpenerimaan_id);
		$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('pajakpph',$this->pajakpph);
		$criteria->compare('pajakppn',$this->pajakppn);
		$criteria->compare('LOWER(nofakturpajak)',strtolower($this->nofakturpajak),true);
		$criteria->compare('peg_penerima_id',$this->peg_penerima_id);
		$criteria->compare('peg_mengetahui_id',$this->peg_mengetahui_id);
		$criteria->compare('ruanganpenerima_id',$this->ruanganpenerima_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(tglterima)',strtolower($this->tglterima),true);
                
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('pembelianbarang_id',$this->pembelianbarang_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('returpenerimaan_id',$this->returpenerimaan_id);
		$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('pajakpph',$this->pajakpph);
		$criteria->compare('pajakppn',$this->pajakppn);
		$criteria->compare('LOWER(nofakturpajak)',strtolower($this->nofakturpajak),true);
		$criteria->compare('peg_penerima_id',$this->peg_penerima_id);
		$criteria->compare('peg_mengetahui_id',$this->peg_mengetahui_id);
		$criteria->compare('ruanganpenerima_id',$this->ruanganpenerima_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(tglterima)',strtolower($this->tglterima),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
                    else if ( $column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {         
            if($this->tglfaktur===null || trim($this->tglfaktur)==''){
	        $this->setAttribute('tglfaktur', null);
            }
            if($this->tglsuratjalan===null || trim($this->tglsuratjalan)==''){
	        $this->setAttribute('tglsuratjalan', null);
            }
            if($this->tglterima===null || trim($this->tglterima)==''){
	        $this->setAttribute('tglterima', null);
            }
            return parent::beforeSave();
        }

        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
        
        /**
         * - digunakan untuk memanggil data supplier ke field dropdowon
         * @return type
         */
        public function getDropSuppAktif(){
            $cri = new CDbCriteria();
            $cri->addCondition(" supplier_aktif = TRUE ");
            $cri->order = " supplier_nama ASC ";
            
            return CHtml::listData(SupplierM::model()->findAll($cri),'supplier_id','supplier_nama');
        }
		
		
		public function getTotalSeluruh(){
			if ($this->totalkeseluruhan == 0 || empty($this->totalkeseluruhan)){
				$total = $this->totalharga - $this->discount + $this->pajakppn + $this->pajakpph + $this->biayaadministrasi;
			}else{
				$total = $this->totalkeseluruhan;
			}
			
			return $total;
		}
		
		public function getDiskonPersen(){
                    if($this->discount != 0){
                        return  number_format(($this->discount / $this->totalharga)*100,2,",",".");
                    }
                    else{
                        return 0;
                    }
		}
}