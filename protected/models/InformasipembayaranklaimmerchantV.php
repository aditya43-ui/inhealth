<?php

/**
 * This is the model class for table "informasipembayaranklaimmerchant_v".
 *
 * The followings are the available columns in table 'informasipembayaranklaimmerchant_v':
 * @property integer $pembayarklaim_id
 * @property string $tglpembayaranklaim
 * @property string $nopembayaranklaim
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $pengajuanklaimpiutang_id
 * @property string $tglpengajuanklaimanklaim
 * @property string $nopengajuanklaimanklaim
 * @property double $totalpiutang
 * @property double $totalbayar
 * @property double $telahbayar
 * @property double $totalsisapiutang
 * @property integer $bayarke
 * @property string $pembayaranmelalui
 * @property string $nobuktisetor
 * @property string $alamatpenyetor
 * @property string $namabank
 * @property string $norekbank
 * @property integer $pembklaimdetal_id
 * @property integer $tandabuktibayar_id
 * @property string $tglbuktibayar
 * @property string $nobuktibayar
 * @property string $carapembayaran
 * @property string $dengankartu
 * @property string $bankkartu
 * @property string $nokartu
 * @property string $nostrukkartu
 * @property string $darinama_bkm
 * @property string $alamat_bkm
 * @property string $sebagaipembayaran_bkm
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class InformasipembayaranklaimmerchantV extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasipembayaranklaimmerchant_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembayarklaim_id, carabayar_id, penjamin_id, pengajuanklaimpiutang_id, bayarke, pembklaimdetal_id, tandabuktibayar_id', 'numerical', 'integerOnly'=>true),
			array('totalpiutang, totalbayar, telahbayar, totalsisapiutang', 'numerical'),
			array('nopembayaranklaim, carabayar_nama, penjamin_nama, nopengajuanklaimanklaim, nobuktibayar, carapembayaran, dengankartu', 'length', 'max'=>50),
			array('pembayaranmelalui, nobuktisetor, namabank, norekbank, bankkartu, nokartu, nostrukkartu, darinama_bkm, sebagaipembayaran_bkm', 'length', 'max'=>100),
			array('tglpembayaranklaim, tglpengajuanklaimanklaim, alamatpenyetor, tglbuktibayar, alamat_bkm, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembayarklaim_id, tglpembayaranklaim, nopembayaranklaim, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, pengajuanklaimpiutang_id, tglpengajuanklaimanklaim, nopengajuanklaimanklaim, totalpiutang, totalbayar, telahbayar, totalsisapiutang, bayarke, pembayaranmelalui, nobuktisetor, alamatpenyetor, namabank, norekbank, pembklaimdetal_id, tandabuktibayar_id, tglbuktibayar, nobuktibayar, carapembayaran, dengankartu, bankkartu, nokartu, nostrukkartu, darinama_bkm, alamat_bkm, sebagaipembayaran_bkm, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pembayarklaim_id' => 'Pembayarklaim',
			'tglpembayaranklaim' => 'Tgl. Pembayaran Klaim',
			'nopembayaranklaim' => 'No. Pembayaran Klaim',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'pengajuanklaimpiutang_id' => 'Pengajuanklaimpiutang',
			'tglpengajuanklaimanklaim' => 'Tgl. Pengajuan Klaim',
			'nopengajuanklaimanklaim' => 'No. Pengajuan Klaim',
			'totalpiutang' => 'Total Piutang',
			'totalbayar' => 'Total Bayar',
			'telahbayar' => 'Telah Bayar',
			'totalsisapiutang' => 'Total Sisa Piutang',
			'bayarke' => 'Bayar ke',
			'pembayaranmelalui' => 'Pembayaran Melalui',
			'nobuktisetor' => 'No. Bukti Setor',
			'alamatpenyetor' => 'Alamat Penyetor',
			'namabank' => 'Nama Bank',
			'norekbank' => 'No. Rekening Bank',
			'pembklaimdetal_id' => 'Pembklaimdetal',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'tglbuktibayar' => 'Tgl. Bukti Bayar',
			'nobuktibayar' => 'Nobuktibayar',
			'carapembayaran' => 'Carapembayaran',
			'dengankartu' => 'Dengankartu',
			'bankkartu' => 'Bankkartu',
			'nokartu' => 'Nokartu',
			'nostrukkartu' => 'Nostrukkartu',
			'darinama_bkm' => 'Darinama Bkm',
			'alamat_bkm' => 'Alamat Bkm',
			'sebagaipembayaran_bkm' => 'Sebagaipembayaran Bkm',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pembayarklaim_id)){
			$criteria->addCondition('pembayarklaim_id = '.$this->pembayarklaim_id);
		}
		$criteria->compare('LOWER(tglpembayaranklaim)',strtolower($this->tglpembayaranklaim),true);
		$criteria->compare('LOWER(nopembayaranklaim)',strtolower($this->nopembayaranklaim),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->pengajuanklaimpiutang_id)){
			$criteria->addCondition('pengajuanklaimpiutang_id = '.$this->pengajuanklaimpiutang_id);
		}
		$criteria->compare('LOWER(tglpengajuanklaimanklaim)',strtolower($this->tglpengajuanklaimanklaim),true);
		$criteria->compare('LOWER(nopengajuanklaimanklaim)',strtolower($this->nopengajuanklaimanklaim),true);
		$criteria->compare('totalpiutang',$this->totalpiutang);
		$criteria->compare('totalbayar',$this->totalbayar);
		$criteria->compare('telahbayar',$this->telahbayar);
		$criteria->compare('totalsisapiutang',$this->totalsisapiutang);
		if(!empty($this->bayarke)){
			$criteria->addCondition('bayarke = '.$this->bayarke);
		}
		$criteria->compare('LOWER(pembayaranmelalui)',strtolower($this->pembayaranmelalui),true);
		$criteria->compare('LOWER(nobuktisetor)',strtolower($this->nobuktisetor),true);
		$criteria->compare('LOWER(alamatpenyetor)',strtolower($this->alamatpenyetor),true);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(norekbank)',strtolower($this->norekbank),true);
		if(!empty($this->pembklaimdetal_id)){
			$criteria->addCondition('pembklaimdetal_id = '.$this->pembklaimdetal_id);
		}
		if(!empty($this->tandabuktibayar_id)){
			$criteria->addCondition('tandabuktibayar_id = '.$this->tandabuktibayar_id);
		}
		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(carapembayaran)',strtolower($this->carapembayaran),true);
		$criteria->compare('LOWER(dengankartu)',strtolower($this->dengankartu),true);
		$criteria->compare('LOWER(bankkartu)',strtolower($this->bankkartu),true);
		$criteria->compare('LOWER(nokartu)',strtolower($this->nokartu),true);
		$criteria->compare('LOWER(nostrukkartu)',strtolower($this->nostrukkartu),true);
		$criteria->compare('LOWER(darinama_bkm)',strtolower($this->darinama_bkm),true);
		$criteria->compare('LOWER(alamat_bkm)',strtolower($this->alamat_bkm),true);
		$criteria->compare('LOWER(sebagaipembayaran_bkm)',strtolower($this->sebagaipembayaran_bkm),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}