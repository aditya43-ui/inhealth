<?php

/**
 * This is the model class for table "laporanrekappendapatan_v".
 *
 * The followings are the available columns in table 'laporanrekappendapatan_v':
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $ruangankasir_m_id
 * @property string $ruangankasir_nama
 * @property integer $tandabuktibayar_id
 * @property string $nobuktibayar
 * @property string $tglbuktibayar
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $pasienadmisi_id
 * @property string $nopembayaran
 * @property string $tglpembayaran
 * @property string $noresep
 * @property string $nosjp
 * @property double $totalbiayaoa
 * @property double $totalbiayatindakan
 * @property double $totalbiayapelayanan
 * @property double $totalsubsidiasuransi
 * @property double $totalsubsidipemerintah
 * @property double $totalsubsidirs
 * @property double $totaliurbiaya
 * @property double $totalbayartindakan
 * @property double $totaldiscount
 * @property double $totalpembebasan
 * @property double $totalsisatagihan
 * @property string $statusbayar
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $carapembayaran
 * @property integer $loginpemakai_id
 * @property string $nama_pemakai
 * @property integer $ruanganpelakhir_id
 * @property string $ruanganakhir_nama
 * @property string $tglpulang
 */
class LaporanrekappendapatanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrekappendapatanV the static model class
	 */
     public $tgl_awal,$tgl_akhir,$bulan,$hari,$tahun;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanrekappendapatan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, carabayar_id, penjamin_id, ruangankasir_m_id, tandabuktibayar_id, pendaftaran_id, pasienadmisi_id, loginpemakai_id, ruanganpelakhir_id', 'numerical', 'integerOnly'=>true),
			array('totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totalbayartindakan, totaldiscount, totalpembebasan, totalsisatagihan', 'numerical'),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, no_pendaftaran, nama_pemakai', 'length', 'max'=>20),
			array('nama_pasien, carabayar_nama, penjamin_nama, ruangankasir_nama, nobuktibayar, nopembayaran, noresep, nosjp, carapembayaran, ruanganakhir_nama', 'length', 'max'=>50),
			array('nama_bin, statusbayar', 'length', 'max'=>30),
			array('tglbuktibayar, tgl_pendaftaran, tglpembayaran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, tglpulang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, no_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, ruangankasir_m_id, ruangankasir_nama, tandabuktibayar_id, nobuktibayar, tglbuktibayar, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, pasienadmisi_id, nopembayaran, tglpembayaran, noresep, nosjp, totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totalbayartindakan, totaldiscount, totalpembebasan, totalsisatagihan, statusbayar, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, carapembayaran, loginpemakai_id, nama_pemakai, ruanganpelakhir_id, ruanganakhir_nama, tglpulang', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'ruangankasir_m_id' => 'Ruangankasir M',
			'ruangankasir_nama' => 'Ruangankasir Nama',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'nobuktibayar' => 'Nobuktibayar',
			'tglbuktibayar' => 'Tglbuktibayar',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'nopembayaran' => 'No. Pembayaran',
			'tglpembayaran' => 'Tgl. Pembayaran',
			'noresep' => 'Noresep',
			'nosjp' => 'Nosjp',
			'totalbiayaoa' => 'Totalbiayaoa',
			'totalbiayatindakan' => 'Totalbiayatindakan',
			'totalbiayapelayanan' => 'Totalbiayapelayanan',
			'totalsubsidiasuransi' => 'Totalsubsidiasuransi',
			'totalsubsidipemerintah' => 'Totalsubsidipemerintah',
			'totalsubsidirs' => 'Totalsubsidirs',
			'totaliurbiaya' => 'Totaliurbiaya',
			'totalbayartindakan' => 'Totalbayartindakan',
			'totaldiscount' => 'Total Keringanan',
			'totalpembebasan' => 'Totalpembebasan',
			'totalsisatagihan' => 'Totalsisatagihan',
			'statusbayar' => 'Statusbayar',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'carapembayaran' => 'Carapembayaran',
			'loginpemakai_id' => 'Loginpemakai',
			'nama_pemakai' => 'Nama Pemakai',
			'ruanganpelakhir_id' => 'Ruanganpelakhir',
			'ruanganakhir_nama' => 'Ruanganakhir Nama',
			'tglpulang' => 'Tglpulang',
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
		$criteria->select = " no_rekam_medik ";
		$criteria->group = $criteria->select;
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('ruangankasir_m_id',$this->ruangankasir_m_id);
		$criteria->compare('LOWER(ruangankasir_nama)',strtolower($this->ruangankasir_nama),true);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(nopembayaran)',strtolower($this->nopembayaran),true);
		$criteria->compare('LOWER(tglpembayaran)',strtolower($this->tglpembayaran),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('LOWER(nosjp)',strtolower($this->nosjp),true);
		$criteria->compare('totalbiayaoa',$this->totalbiayaoa);
		$criteria->compare('totalbiayatindakan',$this->totalbiayatindakan);
		$criteria->compare('totalbiayapelayanan',$this->totalbiayapelayanan);
		$criteria->compare('totalsubsidiasuransi',$this->totalsubsidiasuransi);
		$criteria->compare('totalsubsidipemerintah',$this->totalsubsidipemerintah);
		$criteria->compare('totalsubsidirs',$this->totalsubsidirs);
		$criteria->compare('totaliurbiaya',$this->totaliurbiaya);
		$criteria->compare('totalbayartindakan',$this->totalbayartindakan);
		$criteria->compare('totaldiscount',$this->totaldiscount);
		$criteria->compare('totalpembebasan',$this->totalpembebasan);
		$criteria->compare('totalsisatagihan',$this->totalsisatagihan);
		$criteria->compare('LOWER(statusbayar)',strtolower($this->statusbayar),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(carapembayaran)',strtolower($this->carapembayaran),true);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('LOWER(nama_pemakai)',strtolower($this->nama_pemakai),true);
		$criteria->compare('ruanganpelakhir_id',$this->ruanganpelakhir_id);
		$criteria->compare('LOWER(ruanganakhir_nama)',strtolower($this->ruanganakhir_nama),true);
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('ruangankasir_m_id',$this->ruangankasir_m_id);
		$criteria->compare('LOWER(ruangankasir_nama)',strtolower($this->ruangankasir_nama),true);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(nopembayaran)',strtolower($this->nopembayaran),true);
		$criteria->compare('LOWER(tglpembayaran)',strtolower($this->tglpembayaran),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('LOWER(nosjp)',strtolower($this->nosjp),true);
		$criteria->compare('totalbiayaoa',$this->totalbiayaoa);
		$criteria->compare('totalbiayatindakan',$this->totalbiayatindakan);
		$criteria->compare('totalbiayapelayanan',$this->totalbiayapelayanan);
		$criteria->compare('totalsubsidiasuransi',$this->totalsubsidiasuransi);
		$criteria->compare('totalsubsidipemerintah',$this->totalsubsidipemerintah);
		$criteria->compare('totalsubsidirs',$this->totalsubsidirs);
		$criteria->compare('totaliurbiaya',$this->totaliurbiaya);
		$criteria->compare('totalbayartindakan',$this->totalbayartindakan);
		$criteria->compare('totaldiscount',$this->totaldiscount);
		$criteria->compare('totalpembebasan',$this->totalpembebasan);
		$criteria->compare('totalsisatagihan',$this->totalsisatagihan);
		$criteria->compare('LOWER(statusbayar)',strtolower($this->statusbayar),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(carapembayaran)',strtolower($this->carapembayaran),true);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('LOWER(nama_pemakai)',strtolower($this->nama_pemakai),true);
		$criteria->compare('ruanganpelakhir_id',$this->ruanganpelakhir_id);
		$criteria->compare('LOWER(ruanganakhir_nama)',strtolower($this->ruanganakhir_nama),true);
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}