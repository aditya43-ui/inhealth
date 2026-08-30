<?php

/**
 * This is the model class for table "terimabahanmakan_t".
 *
 * The followings are the available columns in table 'terimabahanmakan_t':
 * @property integer $terimabahanmakan_id
 * @property integer $pengajuanbahanmkn_id
 * @property integer $ruangan_id
 * @property integer $supplier_id
 * @property string $sumberdanabhn
 * @property string $nopenerimaanbahan
 * @property string $tglterimabahan
 * @property string $nosuratjalan
 * @property string $tglsurjalan
 * @property string $nofaktur
 * @property string $tglfaktur
 * @property double $totalharganetto
 * @property double $totaldiscount
 * @property string $keterangan_terima_bahan
 */
class TerimabahanmakanT extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        public $supplier_nama;
        public $mengetahui_nama, $persenpph_22, $umurhutang, $pegawai_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimabahanmakanT the static model class
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
		return 'terimabahanmakan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, supplier_id, nopenerimaanbahan, tglterimabahan, biayapajak, biayapengiriman', 'required'),
			array('pengajuanbahanmkn_id, ruangan_id, supplier_id, pegawaimenyetujuikeuangan_id, returpenbahanmakan_id, syaratbayar_id, pajak_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('totalharganetto, totaldiscount, biayapengiriman, biayapajak, biayatransportasi,biayaadministrasi, pajakpph, pajakppn, totalkeseluruhan, persendiscount, biayapajakpph, jmluangmukabeli, totalhutangusaha', 'numerical'),
			array('sumberdanabhn, nopenerimaanbahan, nosuratjalan, nofaktur', 'length', 'max'=>50),
			array('keterangan_terima_bahan', 'length', 'max'=>200),
			array('tglsurjalan, tglfaktur, mengetahui_id, biayaadministrasi, pajakpph, pajakppn, totalkeseluruhan, persendiscount, biayapajakpph, tgl_menyetujuikeuangan, tgljatuhtempo, keteranganfaktur', 'safe'),
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'update,insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, terimabahanmakan_id, pengajuanbahanmkn_id, ruangan_id, supplier_id, sumberdanabhn, nopenerimaanbahan, tglterimabahan, nosuratjalan, tglsurjalan, nofaktur, tglfaktur, totalharganetto, totaldiscount, keterangan_terima_bahan, biayaadministrasi, pajakpph, pajakppn, totalkeseluruhan, , persendiscount, biayapajakpph, pegawaimenyetujuikeuangan_id, tgl_menyetujuikeuangan, tgljatuhtempo, returpenbahanmakan_id, syaratbayar_id, keteranganfaktur, pajak_id, pegawai_id, jmluangmukabeli, totalhutangusaha', 'safe', 'on'=>'search'),
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
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                    'supplier'=>array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
                    'pengajuanbahanmkn'=>array(self::BELONGS_TO, 'PengajuanbahanmknT', 'pengajuanbahanmkn_id'),
                    'penerima' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
                    'mengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_id'),
                    'syaratbayar' => array(self::BELONGS_TO, 'SyaratbayarM', 'syaratbayar_id'),
                    'pegawaipenerima' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                    'pajak' => array(self::BELONGS_TO, 'PajakM', 'pajak_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'terimabahanmakan_id' => 'Terima Bahan Makan',
			'pengajuanbahanmkn_id' => 'Pengajuan Bahan Makan',
			'ruangan_id' => 'Ruangan',
			'supplier_id' => 'Supplier',
			'sumberdanabhn' => 'Sumber Dana Bahan',
			'nopenerimaanbahan' => 'No. Penerimaan',
			'tglterimabahan' => 'Tgl. Terima',
			'nosuratjalan' => 'No. Surat Jalan',
			'tglsurjalan' => 'Tgl. Surat Jalan',
			'nofaktur' => 'No. Faktur',
			'tglfaktur' => 'Tanggal Faktur',
			'totalharganetto' => 'Total Harga',
			'totaldiscount' => 'Total Keringanan',
			'keterangan_terima_bahan' => 'Keterangan Penerimaan',
                        'biayapajak'=>'Biaya Pajak',
                        'biayapengiriman'=>'Biaya Pengiriman',
                        'biayatransportasi'=>'Biaya Transportasi',
            'supplier_nama'=>'Supplier',
                    'keteranganfaktur'=>'Keterangan',
                    'pajak_id' => 'Jenis Pajak'
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

		$criteria->compare('terimabahanmakan_id',$this->terimabahanmakan_id);
		$criteria->compare('pengajuanbahanmkn_id',$this->pengajuanbahanmkn_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(sumberdanabhn)',strtolower($this->sumberdanabhn),true);
		$criteria->compare('LOWER(nopenerimaanbahan)',strtolower($this->nopenerimaanbahan),true);
		$criteria->compare('LOWER(tglterimabahan)',strtolower($this->tglterimabahan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('LOWER(tglsurjalan)',strtolower($this->tglsurjalan),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('totalharganetto',$this->totalharganetto);
		$criteria->compare('totaldiscount',$this->totaldiscount);
		$criteria->compare('LOWER(keterangan_terima_bahan)',strtolower($this->keterangan_terima_bahan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('terimabahanmakan_id',$this->terimabahanmakan_id);
		$criteria->compare('pengajuanbahanmkn_id',$this->pengajuanbahanmkn_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(sumberdanabhn)',strtolower($this->sumberdanabhn),true);
		$criteria->compare('LOWER(nopenerimaanbahan)',strtolower($this->nopenerimaanbahan),true);
		$criteria->compare('LOWER(tglterimabahan)',strtolower($this->tglterimabahan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('LOWER(tglsurjalan)',strtolower($this->tglsurjalan),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('totalharganetto',$this->totalharganetto);
		$criteria->compare('totaldiscount',$this->totaldiscount);
		$criteria->compare('LOWER(keterangan_terima_bahan)',strtolower($this->keterangan_terima_bahan),true);
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
            if($this->tglsurjalan===null || trim($this->tglsurjalan)==''){
	        $this->setAttribute('tglsurjalan', null);
            }
            if($this->tglterimabahan===null || trim($this->tglterimabahan)==''){
	        $this->setAttribute('tglterimabahan', null);
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