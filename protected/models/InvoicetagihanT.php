<?php

/**
 * This is the model class for table "invoicetagihan_t".
 *
 * The followings are the available columns in table 'invoicetagihan_t':
 * @property integer $invoicetagihan_id
 * @property integer $ruangan_id
 * @property string $invoicetagihan_no
 * @property string $invoicetagihan_tgl
 * @property string $namapenagih
 * @property string $perihal_tagihan
 * @property string $rekanan_tagihan
 * @property string $ket_pembayaran
 * @property string $isisurat_tagihan
 * @property boolean $status_verifikasi
 * @property integer $peg_verifikasi_tag_id
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
 */
class InvoicetagihanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvoicetagihanT the static model class
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
		return 'invoicetagihan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, invoicetagihan_no, invoicetagihan_tgl, namapenagih, perihal_tagihan, rekanan_tagihan, status_verifikasi, total_tagihan, disetujui_nama, disetujui_posisi, verifikator_nama, verifikator_posisi, create_time, create_loginpemekai_id, create_ruangan', 'required'),
			array('ruangan_id, peg_verifikasi_tag_id, create_loginpemekai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('total_tagihan', 'numerical'),
			array('invoicetagihan_no', 'length', 'max'=>50),
			array('namapenagih', 'length', 'max'=>200),
			array('perihal_tagihan', 'length', 'max'=>500),
			array('rekanan_tagihan', 'length', 'max'=>100),
			array('disetujui_nama, disetujui_posisi, verifikator_nama, verifikator_posisi', 'length', 'max'=>10),
			array('ket_pembayaran, isisurat_tagihan, tgl_verfikasi_tagihan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoicetagihan_id, ruangan_id, invoicetagihan_no, invoicetagihan_tgl, namapenagih, perihal_tagihan, rekanan_tagihan, ket_pembayaran, isisurat_tagihan, status_verifikasi, peg_verifikasi_tag_id, tgl_verfikasi_tagihan, total_tagihan, disetujui_nama, disetujui_posisi, verifikator_nama, verifikator_posisi, create_time, update_time, create_loginpemekai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'invoicetagihan_id' => 'Invoicetagihan',
			'ruangan_id' => 'Ruangan',
			'invoicetagihan_no' => 'No. Invoice',
			'invoicetagihan_tgl' => 'Tanggal Invoice',
			'namapenagih' => 'Namapenagih',
			'perihal_tagihan' => 'Perihal Tagihan',
			'rekanan_tagihan' => 'Rekanan Tagihan',
			'ket_pembayaran' => 'Keterangan Pembayaran',
			'isisurat_tagihan' => 'Isi Surat',
			'status_verifikasi' => 'Status Verifikasi',
			'peg_verifikasi_tag_id' => 'Nama Verifikator RS Luar',
			'tgl_verfikasi_tagihan' => 'Tanggal Verifikasi',
			'total_tagihan' => 'Total Tagihan',
			'disetujui_nama' => 'Disetujui Oleh',
			'disetujui_posisi' => 'Posisi',
			'verifikator_nama' => 'Nama Verifikator',
			'verifikator_posisi' => 'Posisi Verifikator',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemekai_id' => 'Create Loginpemekai',
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

		if(!empty($this->invoicetagihan_id)){
			$criteria->addCondition('invoicetagihan_id = '.$this->invoicetagihan_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(invoicetagihan_no)',strtolower($this->invoicetagihan_no),true);
		$criteria->compare('LOWER(invoicetagihan_tgl)',strtolower($this->invoicetagihan_tgl),true);
		$criteria->compare('LOWER(namapenagih)',strtolower($this->namapenagih),true);
		$criteria->compare('LOWER(perihal_tagihan)',strtolower($this->perihal_tagihan),true);
		$criteria->compare('LOWER(rekanan_tagihan)',strtolower($this->rekanan_tagihan),true);
		$criteria->compare('LOWER(ket_pembayaran)',strtolower($this->ket_pembayaran),true);
		$criteria->compare('LOWER(isisurat_tagihan)',strtolower($this->isisurat_tagihan),true);
		$criteria->compare('status_verifikasi',$this->status_verifikasi);
		if(!empty($this->peg_verifikasi_tag_id)){
			$criteria->addCondition('peg_verifikasi_tag_id = '.$this->peg_verifikasi_tag_id);
		}
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