<?php

/**
 * This is the model class for table "verpengeluaran_t".
 *
 * The followings are the available columns in table 'verpengeluaran_t':
 * @property string $verpengeluaran_id
 * @property string $no_voucher
 * @property string $tglvoucher
 * @property integer $jenispengeluaran_id
 * @property integer $jenisverifikasi_id
 * @property double $jmlpengeluaran
 * @property double $jmlpajak_pph
 * @property double $jmlpajak_ppn
 * @property string $ket_pajak
 * @property string $peg_verifikasi
 * @property string $peg_bendahara
 * @property string $peg_akuntansi
 * @property integer $supplier_id
 *
 * The followings are the available model relations:
 * @property VerpengelurandetT[] $verpengelurandetTs
 */
class VerpengeluaranT extends CActiveRecord
{
    public $jenisdokumen_id, $dokumenberkas_id, $jenis_pph, $matananggaran_kode;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VerpengeluaranT the static model class
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
		return 'verpengeluaran_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_voucher, tglvoucher, jenispengeluaran_id, jenisverifikasi_id, jmlpengeluaran, peg_verifikasi', 'required'),
			array('jenispengeluaran_id, jenisverifikasi_id, supplier_id, rekeningmak_id, cpa_id, buktikaskeluar_id', 'numerical', 'integerOnly'=>true),
			array('jmlpengeluaran, jmlpajak_pph, jmlpajak_ppn, dendabrg_kosong, persenppn, persenpph, totalpengeluaran', 'numerical'),
			array('no_voucher', 'length', 'max'=>100),
			array('ket_pajak', 'length', 'max'=>50),
                        array('jenispajak', 'length', 'max'=>20),
                        array('dibyarkankepada', 'length', 'max'=>255),   
			array('peg_verifikasi, peg_bendahara, peg_akuntansi, fileberkas', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verpengeluaran_id, no_voucher, tglvoucher, jenispengeluaran_id, jenisverifikasi_id, jmlpengeluaran, jmlpajak_pph, jmlpajak_ppn, ket_pajak, peg_verifikasi, peg_bendahara, peg_akuntansi, supplier_id, dendabrg_kosong, rekeningmak_id, tgl_jatuhtempo, cpa_id, buktikaskeluar_id, dibyarkankepada, untukkeperluan, buktipendukung, jenispajak, persenppn, persenpph, fileberkas, totalpengeluaran', 'safe', 'on'=>'search'),
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
			'verpengelurandetTs' => array(self::HAS_MANY, 'VerpengelurandetT', 'verpengeluaran_id'),
                    'mataanggarans' => array(self::BELONGS_TO, 'MataanggaranM', 'rekeningmak_id'),
                    'cpaTs' => array(self::BELONGS_TO, 'CpaT', 'cpa_id'),
                    'buktikaskeluarTs' => array(self::BELONGS_TO, 'BuktikaskeluarT', 'buktikaskeluar_id'),
                    'jenisverifikasi' => array(self::BELONGS_TO, 'JenisverifikasiM', 'jenisverifikasi_id'),
                    'jenispengeluaran' => array(self::BELONGS_TO, 'JenispengeluaranM', 'jenispengeluaran_id'),
                );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'verpengeluaran_id' => 'Verpengeluaran',
			'no_voucher' => 'No Voucher',
			'tglvoucher' => 'Tanggal Voucher',
			'jenispengeluaran_id' => 'Jenis Pengeluaran',
			'jenisverifikasi_id' => 'Jenis Verifikasi',
			'jmlpengeluaran' => 'Jumlah Pengeluaran',
			'jmlpajak_pph' => 'PPH',
			'jmlpajak_ppn' => 'PPN',
			'ket_pajak' => 'Keterangan Pajak',
			'peg_verifikasi' => 'Pegawai Verifikasi',
			'peg_bendahara' => 'Pegawai Bendahara',
			'peg_akuntansi' => 'Pegawai Akuntansi',
			'supplier_id' => 'Supplier',
                        'jenisdokumen_id'=>'Jenis Berkas',
                        'dendabrg_kosong' => 'Denda Barang Kosong',
                        'fileberkas' => 'File Berkas'
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

		$criteria->compare('LOWER(verpengeluaran_id)',strtolower($this->verpengeluaran_id),true);
		$criteria->compare('LOWER(no_voucher)',strtolower($this->no_voucher),true);
		$criteria->compare('LOWER(tglvoucher)',strtolower($this->tglvoucher),true);
		if(!empty($this->jenispengeluaran_id)){
			$criteria->addCondition('jenispengeluaran_id = '.$this->jenispengeluaran_id);
		}
		if(!empty($this->jenisverifikasi_id)){
			$criteria->addCondition('jenisverifikasi_id = '.$this->jenisverifikasi_id);
		}
		$criteria->compare('jmlpengeluaran',$this->jmlpengeluaran);
		$criteria->compare('jmlpajak_pph',$this->jmlpajak_pph);
		$criteria->compare('jmlpajak_ppn',$this->jmlpajak_ppn);
		$criteria->compare('LOWER(ket_pajak)',strtolower($this->ket_pajak),true);
		$criteria->compare('LOWER(peg_verifikasi)',strtolower($this->peg_verifikasi),true);
		$criteria->compare('LOWER(peg_bendahara)',strtolower($this->peg_bendahara),true);
		$criteria->compare('LOWER(peg_akuntansi)',strtolower($this->peg_akuntansi),true);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_id = '.$this->supplier_id);
		}

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