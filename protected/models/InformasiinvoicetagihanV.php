<?php

/**
 * This is the model class for table "informasiinvoicetagihan_v".
 *
 * The followings are the available columns in table 'informasiinvoicetagihan_v':
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $invoicetagihan_id
 * @property integer $invoicedisposisi_id
 * @property integer $invoicetagdetail_id
 * @property string $uraian_tagdetail
 * @property double $total_tagdetail
 * @property string $ket_tagdetail
 * @property string $uraian_disoposisi
 * @property double $total_disposisi
 * @property string $ket_disposisi
 * @property string $invoicetagihan_no
 * @property string $invoicetagihan_tgl
 * @property string $namapenagih
 * @property string $perihal_tagihan
 * @property string $rekanan_tagihan
 * @property string $ket_pembayaran
 * @property string $isisurat_tagihan
 * @property boolean $status_verifikasi
 * @property string $tgl_verfikasi_tagihan
 * @property double $total_tagihan
 * @property string $disetujui_nama
 * @property string $disetujui_posisi
 * @property string $verifikator_nama
 * @property string $verifikator_posisi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemekai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $nama_pegawai
 * @property string $ruangan_nama
 */
class InformasiinvoicetagihanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiinvoicetagihanV the static model class
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
		return 'informasiinvoicetagihan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, ruangan_id, invoicetagihan_id, invoicedisposisi_id, invoicetagdetail_id, create_loginpemekai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('total_tagdetail, total_disposisi, total_tagihan', 'numerical'),
			array('uraian_tagdetail, uraian_disoposisi, namapenagih', 'length', 'max'=>200),
			array('invoicetagihan_no, nama_pegawai, ruangan_nama', 'length', 'max'=>50),
			array('perihal_tagihan', 'length', 'max'=>500),
			array('rekanan_tagihan', 'length', 'max'=>100),
			array('disetujui_nama, disetujui_posisi, verifikator_nama, verifikator_posisi', 'length', 'max'=>10),
			array('ket_tagdetail, ket_disposisi, invoicetagihan_tgl, ket_pembayaran, isisurat_tagihan, status_verifikasi, tgl_verfikasi_tagihan, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, ruangan_id, invoicetagihan_id, invoicedisposisi_id, invoicetagdetail_id, uraian_tagdetail, total_tagdetail, ket_tagdetail, uraian_disoposisi, total_disposisi, ket_disposisi, invoicetagihan_no, invoicetagihan_tgl, namapenagih, perihal_tagihan, rekanan_tagihan, ket_pembayaran, isisurat_tagihan, status_verifikasi, tgl_verfikasi_tagihan, total_tagihan, disetujui_nama, disetujui_posisi, verifikator_nama, verifikator_posisi, create_time, update_time, create_loginpemekai_id, update_loginpemakai_id, create_ruangan, nama_pegawai, ruangan_nama', 'safe', 'on'=>'search'),
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
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'invoicetagihan_id' => 'Invoicetagihan',
			'invoicedisposisi_id' => 'Invoicedisposisi',
			'invoicetagdetail_id' => 'Invoicetagdetail',
			'uraian_tagdetail' => 'Uraian Tagihan Detail',
			'total_tagdetail' => 'Total Tagihan Detail',
			'ket_tagdetail' => 'Ket Tagihan Detail',
			'uraian_disoposisi' => 'Uraian Disoposisi',
			'total_disposisi' => 'Total Disposisi',
			'ket_disposisi' => 'Ket Disposisi',
			'invoicetagihan_no' => 'No. Invoice',
			'invoicetagihan_tgl' => 'Invoicetagihan Tgl',
			'namapenagih' => 'Nama Penagih',
			'perihal_tagihan' => 'Perihal Tagihan',
			'rekanan_tagihan' => 'Rekanan',
			'ket_pembayaran' => 'Ket Pembayaran',
			'isisurat_tagihan' => 'Isisurat Tagihan',
			'status_verifikasi' => 'Status Verifikasi',
			'tgl_verfikasi_tagihan' => 'Tanggal Verfikasi Tagihan',
			'total_tagihan' => 'Total Tagihan',
			'disetujui_nama' => 'Disetujui Oleh',
			'disetujui_posisi' => 'Disetujui Posisi',
			'verifikator_nama' => 'Nama Verifikator',
			'verifikator_posisi' => 'Verifikator Posisi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemekai_id' => 'Create Loginpemekai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'nama_pegawai' => 'Nama Pegawai',
			'ruangan_nama' => 'Ruangan Nama',
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

		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->invoicetagihan_id)){
			$criteria->addCondition('invoicetagihan_id = '.$this->invoicetagihan_id);
		}
		if(!empty($this->invoicedisposisi_id)){
			$criteria->addCondition('invoicedisposisi_id = '.$this->invoicedisposisi_id);
		}
		if(!empty($this->invoicetagdetail_id)){
			$criteria->addCondition('invoicetagdetail_id = '.$this->invoicetagdetail_id);
		}
		$criteria->compare('LOWER(uraian_tagdetail)',strtolower($this->uraian_tagdetail),true);
		$criteria->compare('total_tagdetail',$this->total_tagdetail);
		$criteria->compare('LOWER(ket_tagdetail)',strtolower($this->ket_tagdetail),true);
		$criteria->compare('LOWER(uraian_disoposisi)',strtolower($this->uraian_disoposisi),true);
		$criteria->compare('total_disposisi',$this->total_disposisi);
		$criteria->compare('LOWER(ket_disposisi)',strtolower($this->ket_disposisi),true);
		$criteria->compare('LOWER(invoicetagihan_no)',strtolower($this->invoicetagihan_no),true);
		$criteria->compare('LOWER(invoicetagihan_tgl)',strtolower($this->invoicetagihan_tgl),true);
		$criteria->compare('LOWER(namapenagih)',strtolower($this->namapenagih),true);
		$criteria->compare('LOWER(perihal_tagihan)',strtolower($this->perihal_tagihan),true);
		$criteria->compare('LOWER(rekanan_tagihan)',strtolower($this->rekanan_tagihan),true);
		$criteria->compare('LOWER(ket_pembayaran)',strtolower($this->ket_pembayaran),true);
		$criteria->compare('LOWER(isisurat_tagihan)',strtolower($this->isisurat_tagihan),true);
		$criteria->compare('status_verifikasi',$this->status_verifikasi);
		$criteria->compare('LOWER(tgl_verfikasi_tagihan)',strtolower($this->tgl_verfikasi_tagihan),true);
		$criteria->compare('total_tagihan',$this->total_tagihan);
		$criteria->compare('LOWER(disetujui_nama)',strtolower($this->disetujui_nama),true);
		$criteria->compare('LOWER(disetujui_posisi)',strtolower($this->disetujui_posisi),true);
		$criteria->compare('LOWER(verifikator_nama)',strtolower($this->verifikator_nama),true);
		$criteria->compare('LOWER(verifikator_posisi)',strtolower($this->verifikator_posisi),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemekai_id)){
			$criteria->addCondition('create_loginpemekai_id = '.$this->create_loginpemekai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);

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