<?php

/**
 * This is the model class for table "pembelianbarang_t".
 *
 * The followings are the available columns in table 'pembelianbarang_t':
 * @property integer $pembelianbarang_id
 * @property integer $terimapersediaan_id
 * @property integer $sumberdana_id
 * @property integer $supplier_id
 * @property string $tglpembelian
 * @property string $nopembelian
 * @property string $tgldikirim
 * @property integer $peg_pemesanan_id
 * @property integer $peg_mengetahui_id
 * @property integer $peg_menyetujui_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PembelianbarangT extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir, $peg_pemesan_nama, $peg_mengetahui_nama, $peg_menyetujui_nama, $peg_mengetahui_umum_nama;
        public $jumlah;
        public $data;
        public $tick;
        public $pilihanx;
        public $supplier_nama, $is_uangmukapembelian;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembelianbarangT the static model class
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
		return 'pembelianbarang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('sumberdana_id, supplier_id, tglpembelian, nopembelian, peg_pemesanan_id', 'required'),
                array('terimapersediaan_id, sumberdana_id, supplier_id, peg_pemesanan_id, peg_mengetahui_id, peg_menyetujui_id, peg_mengetahui_umum_id, batalpermintaanpembelian_id, pajak_id', 'numerical', 'integerOnly'=>true),
                array('jmlpermintaanuangmuka', 'numerical'),
                array('nopembelian, noreferensi', 'length', 'max'=>100),
                array('peg_pemesan_nama, peg_mengetahui_nama, peg_menyetujui_nama, tgldikirim, update_time, update_loginpemakai_id, keterangan, noreferensi, alamatpengirim, tglpermintaanuangmuka', 'safe'),
                array('create_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert'),
                array('update_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert, update'),
                array('create_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert'),
                array('update_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert, update'),
                array('create_ruangan', 'default','value'=>Yii::app()->user->getState('ruangan_id'), 'setOnEmpty'=>false, 'on'=>'insert'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('tgl_awal, tgl_akhir, pembelianbarang_id, terimapersediaan_id, totalbeli, jumlah, data, tick, pilihanx, sumberdana_id, supplier_id, tglpembelian, nopembelian, tgldikirim, peg_pemesanan_id, peg_mengetahui_id, peg_menyetujui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglmengetahui, tglmenyetujui, peg_mengetahui_umum_id, tglmengetahui_umum, noreferensi, alamatpengirim, batalpermintaanpembelian_id, tglpermintaanuangmuka, jmlpermintaanuangmuka, pajak_id', 'safe', 'on'=>'search'),
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
                    'sumberdana'=>array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
                    'supplier'=>array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
                    'pemesan'=>array(self::BELONGS_TO, 'PegawaiM', 'peg_pemesanan_id'),
                    'mengetahui'=>array(self::BELONGS_TO, 'PegawaiM', 'peg_mengetahui_id'),
                    'menyetujui'=>array(self::BELONGS_TO, 'PegawaiM', 'peg_menyetujui_id'),
                    'belibrgdetail'=>array(self::HAS_MANY, 'BelibrgdetailT','pembelianbarang_id'),
                    'terimabarang'=>array(self::BELONGS_TO, 'TerimapersediaanT','terimapersediaan_id'),
                    'mengetahuiumum'=>array(self::BELONGS_TO, 'PegawaiM', 'peg_mengetahui_umum_id'),
                    'pajak'=>array(self::BELONGS_TO, 'PajakM', 'pajak_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembelianbarang_id' => 'Pembelian Barang',
			'terimapersediaan_id' => 'Terima Persediaan',
			'sumberdana_id' => 'Sumber Dana',
			'supplier_id' => 'Supplier',
			'tglpembelian' => 'Tanggal Permintaan',
			'nopembelian' => 'No. Permintaan',
			'tgldikirim' => 'Tanggal Dikirim',
			'peg_pemesanan_id' => 'Pegawai Pemesanan',
			'peg_mengetahui_id' => 'Pegawai Mengetahui',
			'peg_menyetujui_id' => 'Pegawai Menyetujui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'noreferensi' => 'No Referensi',
                        'alamatpengirim' => 'Alamat Pengiriman',
                    'tglpermintaanuangmuka'=>'Tgl. Permintaan Uang Muka',
                    'jmlpermintaanuangmuka'=>'Jumlah Uang Muka'
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

		$criteria->compare('pembelianbarang_id',$this->pembelianbarang_id);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(tglpembelian)',strtolower($this->tglpembelian),true);
		$criteria->compare('LOWER(nopembelian)',strtolower($this->nopembelian),true);
		$criteria->compare('LOWER(tgldikirim)',strtolower($this->tgldikirim),true);
		$criteria->compare('peg_pemesanan_id',$this->peg_pemesanan_id);
		$criteria->compare('peg_mengetahui_id',$this->peg_mengetahui_id);
		$criteria->compare('peg_menyetujui_id',$this->peg_menyetujui_id);
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
		$criteria->compare('pembelianbarang_id',$this->pembelianbarang_id);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(tglpembelian)',strtolower($this->tglpembelian),true);
		$criteria->compare('LOWER(nopembelian)',strtolower($this->nopembelian),true);
		$criteria->compare('LOWER(tgldikirim)',strtolower($this->tgldikirim),true);
		$criteria->compare('peg_pemesanan_id',$this->peg_pemesanan_id);
		$criteria->compare('peg_mengetahui_id',$this->peg_mengetahui_id);
		$criteria->compare('peg_menyetujui_id',$this->peg_menyetujui_id);
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
            if($this->tglpembelian===null || trim($this->tglpembelian)==''){
	        $this->setAttribute('tglpembelian', null);
            }
            if($this->tgldikirim===null || trim($this->tgldikirim)==''){
	        $this->setAttribute('tgldikirim', null);
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
}