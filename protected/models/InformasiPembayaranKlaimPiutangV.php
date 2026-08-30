<?php

/**
 * This is the model class for table "informasipembayaranklaimpiutang_v".
 *
 * The followings are the available columns in table 'informasipembayaranklaimpiutang_v':
 * @property integer $pembayarklaim_id
 * @property string $tglpembayaranklaim
 * @property string $nopembayaranklaim
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
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
 * @property integer $pengajuanklaimpiutang_id
 * @property string $tglpengajuanklaimanklaim
 * @property string $nopengajuanklaimanklaim
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class InformasiPembayaranKlaimPiutangV extends CActiveRecord
{

	public $tgl_awal;
    public $tgl_akhir, $statusbayar;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiPembayaranKlaimPiutangV the static model class
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
		return 'informasipembayaranklaimpiutang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembayarklaim_id, carabayar_id, penjamin_id, bayarke, pengajuanklaimpiutang_id, pegawaipenghapusan_id', 'numerical', 'integerOnly'=>true),
			array('totalpiutang, totalbayar, telahbayar, totalsisapiutang, biaya_administrasi, totalpenerimaan', 'numerical'),
			array('nopembayaranklaim, carabayar_nama, penjamin_nama, nopengajuanklaimanklaim', 'length', 'max'=>50),
			array('pembayaranmelalui, nobuktisetor, namabank, norekbank', 'length', 'max'=>100),
			array('tglpembayaranklaim, alamatpenyetor, tglpengajuanklaimanklaim, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglpenghapusanpiutang, pegawaipenghapusan_nama', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembayarklaim_id, tglpembayaranklaim, nopembayaranklaim, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, totalpiutang, totalbayar, telahbayar, totalsisapiutang, bayarke, pembayaranmelalui, nobuktisetor, alamatpenyetor, namabank, norekbank, pengajuanklaimpiutang_id, tglpengajuanklaimanklaim, nopengajuanklaimanklaim, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, biaya_administrasi, totalpenerimaan, tglpenghapusanpiutang, pegawaipenghapusan_nama, pegawaipenghapusan_id', 'safe', 'on'=>'search'),
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
			'tglpembayaranklaim' => 'Tanggal Pembayaran Klaim',
			'nopembayaranklaim' => 'No. Pembayaran Klaim',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
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
			'pengajuanklaimpiutang_id' => 'Pengajuan Klaim Piutang',
			'tglpengajuanklaimanklaim' => 'Tgl. Pengajuan Klaim',
			'nopengajuanklaimanklaim' => 'No. Pengajuan Klaim',
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
		if(!empty($this->pengajuanklaimpiutang_id)){
			$criteria->addCondition('pengajuanklaimpiutang_id = '.$this->pengajuanklaimpiutang_id);
		}
		$criteria->compare('LOWER(tglpengajuanklaimanklaim)',strtolower($this->tglpengajuanklaimanklaim),true);
		$criteria->compare('LOWER(nopengajuanklaimanklaim)',strtolower($this->nopengajuanklaimanklaim),true);
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
