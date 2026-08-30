<?php

/**
 * This is the model class for table "informasidokumenpengadaan_v".
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.models
 * The followings are the available columns in table 'informasidokumenpengadaan_v':
 * @property integer $periodeanggaran_id
 * @property string $anggaran_nama
 * @property string $tahunanggaran
 * @property integer $unitkerja_id
 * @property string $namaunitkerja
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property string $rencanaumumpengadaan_kategori
 * @property integer $metodepengadaan_id
 * @property string $metode_pengadaan
 * @property string $metodepengadaan_final
 * @property integer $rencanaumumpengadaan_id
 * @property string $rencanaumumpengadaan_nomor
 * @property string $rencanaumumpengadaan_tanggal
 * @property double $total_pagu
 * @property integer $persiapanpengadaan_id
 * @property string $persiapanpengadaan_nomor
 * @property string $persiapanpengadaan_tanggal
 * @property double $total_hargaseluruhnya
 * @property integer $suratperjanjiankerja_id
 * @property string $nosuratperjanjiankerja
 * @property string $tglsuratperjanjian
 * @property string $nomor_dokumen
 * @property double $nilaikontrak
 * @property integer $pegawaippk_id
 * @property string $nama_pegawai
 * @property string $koderup_awal
 * @property string $koderup_final
 * @property integer $supplier_id
 * @property string $supplier_nama
 * @property string $status
 * @property double $nilai_pengadaan
 */
class InformasidokumenpengadaanV extends CActiveRecord
{
    public $nama_pekerjaan, $nama_pegawai_kuasa, $total;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasidokumenpengadaanV the static model class
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
		return 'informasidokumenpengadaan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('periodeanggaran_id, unitkerja_id, instalasi_id, metodepengadaan_id, rencanaumumpengadaan_id, persiapanpengadaan_id, suratperjanjiankerja_id, pegawaippk_id, supplier_id', 'numerical', 'integerOnly'=>true),
			array('total_pagu, total_hargaseluruhnya, nilaikontrak, nilai_pengadaan', 'numerical'),
			array('anggaran_nama, metode_pengadaan, nosuratperjanjiankerja, nomor_dokumen, koderup_final, supplier_nama', 'length', 'max'=>100),
			array('tahunanggaran', 'length', 'max'=>4),
			array('namaunitkerja', 'length', 'max'=>200),
			array('instalasi_nama, nama_pegawai, nama_kpa, koderup_awal', 'length', 'max'=>50),
			array('rencanaumumpengadaan_kategori, rencanaumumpengadaan_nomor, persiapanpengadaan_nomor', 'length', 'max'=>20),
			array('notadinaspptk_nomor, nomor_notadinas, metodepengadaan_final, rencanaumumpengadaan_tanggal, persiapanpengadaan_tanggal, tglsuratperjanjian, status', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('periodeanggaran_id, anggaran_nama, tahunanggaran, unitkerja_id, namaunitkerja, instalasi_id, instalasi_nama, rencanaumumpengadaan_kategori, metodepengadaan_id, metode_pengadaan, metodepengadaan_final, rencanaumumpengadaan_id, rencanaumumpengadaan_nomor, rencanaumumpengadaan_tanggal, total_pagu, persiapanpengadaan_id, persiapanpengadaan_nomor, persiapanpengadaan_tanggal, total_hargaseluruhnya, suratperjanjiankerja_id, nosuratperjanjiankerja, tglsuratperjanjian, nomor_dokumen, nilaikontrak, pegawaippk_id, nama_pegawai, koderup_awal, koderup_final, supplier_id, supplier_nama, status, nilai_pengadaan, pegawaikpa_id, kode_kegiatan, nama_kpa', 'safe', 'on'=>'search'),
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
			'periodeanggaran_id' => 'Periodeanggaran',
			'anggaran_nama' => 'Anggaran Nama',
			'tahunanggaran' => 'Tahunanggaran',
			'unitkerja_id' => 'Unitkerja',
			'namaunitkerja' => 'Namaunitkerja',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'rencanaumumpengadaan_kategori' => 'Rencanaumumpengadaan Kategori',
			'metodepengadaan_id' => 'Metodepengadaan',
			'metode_pengadaan' => 'Metode Pengadaan',
			'metodepengadaan_final' => 'Metodepengadaan Final',
			'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
			'rencanaumumpengadaan_nomor' => 'Rencanaumumpengadaan Nomor',
			'rencanaumumpengadaan_tanggal' => 'Rencanaumumpengadaan Tanggal',
			'total_pagu' => 'Total Pagu',
			'persiapanpengadaan_id' => 'Persiapanpengadaan',
			'persiapanpengadaan_nomor' => 'Persiapanpengadaan Nomor',
			'persiapanpengadaan_tanggal' => 'Persiapanpengadaan Tanggal',
			'total_hargaseluruhnya' => 'Total Hargaseluruhnya',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'nosuratperjanjiankerja' => 'Nosuratperjanjiankerja',
			'tglsuratperjanjian' => 'Tglsuratperjanjian',
			'nomor_dokumen' => 'Nomor Dokumen',
			'nilaikontrak' => 'Nilaikontrak',
			'pegawaippk_id' => 'Pegawaippk',
			'nama_pegawai' => 'Nama Pegawai',
			'koderup_awal' => 'Koderup Awal',
			'koderup_final' => 'Koderup Final',
			'supplier_id' => 'Supplier',
			'supplier_nama' => 'Supplier Nama',
			'status' => 'Status',
			'nilai_pengadaan' => 'Nilai Pengadaan',
		);
	}
        
        /**
         * Set data dropdown periode anggaran
         * @return array $data option untuk dropdown
         */
        public function getPeriodeAnggaran(){
            $data = array();
            $criteria = new CDbCriteria();
            $criteria->order = "periodeanggaran_id ASC";
            $criteria->addCondition('isclosing_rencanaanggaran IS TRUE');
            $criteria->addCondition('isclosing_closinganggaran IS FALSE');
            $models = PeriodeanggaranK::model()->findAll($criteria);
            if(count($models) > 0){
                foreach($models as $model)
                    $data[$model->periodeanggaran_id]= ($model->tahunanggaran." - ".$model->anggaran_nama);
            }

            return $data;
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

		$criteria->compare('periodeanggaran_id',$this->periodeanggaran_id);
		$criteria->compare('anggaran_nama',$this->anggaran_nama,true);
		$criteria->compare('tahunanggaran',$this->tahunanggaran,true);
		$criteria->compare('unitkerja_id',$this->unitkerja_id);
		$criteria->compare('namaunitkerja',$this->namaunitkerja,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('rencanaumumpengadaan_kategori',$this->rencanaumumpengadaan_kategori,true);
		$criteria->compare('metodepengadaan_id',$this->metodepengadaan_id);
		$criteria->compare('metode_pengadaan',$this->metode_pengadaan,true);
		$criteria->compare('metodepengadaan_final',$this->metodepengadaan_final,true);
		$criteria->compare('rencanaumumpengadaan_id',$this->rencanaumumpengadaan_id);
		$criteria->compare('rencanaumumpengadaan_nomor',$this->rencanaumumpengadaan_nomor,true);
		$criteria->compare('rencanaumumpengadaan_tanggal',$this->rencanaumumpengadaan_tanggal,true);
		$criteria->compare('total_pagu',$this->total_pagu);
		$criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
		$criteria->compare('persiapanpengadaan_nomor',$this->persiapanpengadaan_nomor,true);
		$criteria->compare('persiapanpengadaan_tanggal',$this->persiapanpengadaan_tanggal,true);
		$criteria->compare('total_hargaseluruhnya',$this->total_hargaseluruhnya);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('nosuratperjanjiankerja',$this->nosuratperjanjiankerja,true);
		$criteria->compare('tglsuratperjanjian',$this->tglsuratperjanjian,true);
		$criteria->compare('nomor_dokumen',$this->nomor_dokumen,true);
		$criteria->compare('nilaikontrak',$this->nilaikontrak);
		$criteria->compare('pegawaippk_id',$this->pegawaippk_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('koderup_awal',$this->koderup_awal,true);
		$criteria->compare('koderup_final',$this->koderup_final,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('nilai_pengadaan',$this->nilai_pengadaan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDokumenPengadaan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = "t.*, informasirencanaumumpengadaan_v.nama_pekerjaan";
                $criteria->join = "LEFT JOIN informasirencanaumumpengadaan_v ON t.rencanaumumpengadaan_id = informasirencanaumumpengadaan_v.rencanaumumpengadaan_id ";
                if(!empty($this->periodeanggaran_id)){
                    $criteria->addCondition("t.periodeanggaran_id = ".$this->periodeanggaran_id." ");
                }
                $criteria->compare('LOWER(t.rencanaumumpengadaan_nomor)',strtolower($this->rencanaumumpengadaan_nomor),true);
                $criteria->compare('LOWER(informasirencanaumumpengadaan_v.nama_pekerjaan)',strtolower($this->nama_pekerjaan),true);
		$criteria->compare('t.anggaran_nama',$this->anggaran_nama,true);
		$criteria->compare('t.tahunanggaran',$this->tahunanggaran,true);
		$criteria->compare('t.unitkerja_id',$this->unitkerja_id);
                $criteria->compare('LOWER(t.namaunitkerja)',strtolower($this->namaunitkerja),true);
		$criteria->compare('t.instalasi_id',$this->instalasi_id);
		$criteria->compare('t.instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('t.rencanaumumpengadaan_kategori',$this->rencanaumumpengadaan_kategori,true);
		$criteria->compare('t.metodepengadaan_id',$this->metodepengadaan_id);
		$criteria->compare('t.metode_pengadaan',$this->metode_pengadaan,true);
		$criteria->compare('t.metodepengadaan_final',$this->metodepengadaan_final,true);
		$criteria->compare('t.rencanaumumpengadaan_id',$this->rencanaumumpengadaan_id);
		$criteria->compare('t.rencanaumumpengadaan_tanggal',$this->rencanaumumpengadaan_tanggal,true);
		$criteria->compare('t.total_pagu',$this->total_pagu);
		$criteria->compare('t.persiapanpengadaan_id',$this->persiapanpengadaan_id);
                $criteria->compare('LOWER(t.persiapanpengadaan_nomor)',strtolower($this->persiapanpengadaan_nomor),true);;
		$criteria->compare('t.persiapanpengadaan_tanggal',$this->persiapanpengadaan_tanggal,true);
		$criteria->compare('t.total_hargaseluruhnya',$this->total_hargaseluruhnya);
		$criteria->compare('t.suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
                $criteria->compare('LOWER(t.nosuratperjanjiankerja)',strtolower($this->nosuratperjanjiankerja),true);
		$criteria->compare('t.tglsuratperjanjian',$this->tglsuratperjanjian,true);
                $criteria->compare('LOWER(t.nomor_dokumen)',strtolower($this->nomor_dokumen),true);
		$criteria->compare('t.nilaikontrak',$this->nilaikontrak);
		$criteria->compare('t.pegawaippk_id',$this->pegawaippk_id);
                $criteria->compare('t.pegawaikpa_id',$this->pegawaikpa_id);
                $criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(t.nama_kpa)',strtolower($this->nama_kpa),true);
		$criteria->compare('t.koderup_awal',$this->koderup_awal,true);
		$criteria->compare('t.koderup_final',$this->koderup_final,true);
		$criteria->compare('t.supplier_id',$this->supplier_id);
                $criteria->compare('LOWER(t.kode_kegiatan)',strtolower($this->kode_kegiatan),true);
                $criteria->compare('LOWER(t.supplier_nama)',strtolower($this->supplier_nama),true);
                $criteria->compare('LOWER(t.notadinaspptk_nomor)',strtolower($this->notadinaspptk_nomor),true);
                $criteria->compare('LOWER(t.nomor_notadinas)',strtolower($this->nomor_notadinas),true);
                $criteria->compare('LOWER(status)',strtolower($this->status),true);
		$criteria->compare('nilai_pengadaan',$this->nilai_pengadaan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDokumenPengadaanPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = "t.*, informasirencanaumumpengadaan_v.nama_pekerjaan";
                $criteria->join = "LEFT JOIN informasirencanaumumpengadaan_v ON t.rencanaumumpengadaan_id = informasirencanaumumpengadaan_v.rencanaumumpengadaan_id ";
		if(!empty($this->periodeanggaran_id)){
                    $criteria->addCondition('t.periodeanggaran_id ='.$this->periodeanggaran_id);
                }
                $criteria->compare('LOWER(t.rencanaumumpengadaan_nomor)',strtolower($this->rencanaumumpengadaan_nomor),true);
                $criteria->compare('LOWER(informasirencanaumumpengadaan_v.nama_pekerjaan)',strtolower($this->nama_pekerjaan),true);
		$criteria->compare('t.anggaran_nama',$this->anggaran_nama,true);
		$criteria->compare('t.tahunanggaran',$this->tahunanggaran,true);
		$criteria->compare('t.unitkerja_id',$this->unitkerja_id);
                $criteria->compare('LOWER(t.namaunitkerja)',strtolower($this->namaunitkerja),true);
		$criteria->compare('t.instalasi_id',$this->instalasi_id);
		$criteria->compare('t.instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('t.rencanaumumpengadaan_kategori',$this->rencanaumumpengadaan_kategori,true);
		$criteria->compare('t.metodepengadaan_id',$this->metodepengadaan_id);
		$criteria->compare('t.metode_pengadaan',$this->metode_pengadaan,true);
		$criteria->compare('t.metodepengadaan_final',$this->metodepengadaan_final,true);
		$criteria->compare('t.rencanaumumpengadaan_id',$this->rencanaumumpengadaan_id);
		$criteria->compare('t.rencanaumumpengadaan_tanggal',$this->rencanaumumpengadaan_tanggal,true);
		$criteria->compare('t.total_pagu',$this->total_pagu);
		$criteria->compare('t.persiapanpengadaan_id',$this->persiapanpengadaan_id);
                $criteria->compare('LOWER(t.persiapanpengadaan_nomor)',strtolower($this->persiapanpengadaan_nomor),true);;
		$criteria->compare('t.persiapanpengadaan_tanggal',$this->persiapanpengadaan_tanggal,true);
		$criteria->compare('t.total_hargaseluruhnya',$this->total_hargaseluruhnya);
		$criteria->compare('t.suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
                $criteria->compare('LOWER(t.nosuratperjanjiankerja)',strtolower($this->nosuratperjanjiankerja),true);
		$criteria->compare('t.tglsuratperjanjian',$this->tglsuratperjanjian,true);
                $criteria->compare('LOWER(t.nomor_dokumen)',strtolower($this->nomor_dokumen),true);
		$criteria->compare('t.nilaikontrak',$this->nilaikontrak);
		$criteria->compare('t.pegawaippk_id',$this->pegawaippk_id);
                $criteria->compare('t.pegawaikpa_id',$this->pegawaikpa_id);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(t.kode_kegiatan)',strtolower($this->kode_kegiatan),true);
                $criteria->compare('LOWER(t.nama_kpa)',strtolower($this->nama_kpa),true);
		$criteria->compare('t.koderup_awal',$this->koderup_awal,true);
		$criteria->compare('t.koderup_final',$this->koderup_final,true);
		$criteria->compare('t.supplier_id',$this->supplier_id);
                $criteria->compare('LOWER(t.notadinaspptk_nomor)',strtolower($this->notadinaspptk_nomor),true);
                $criteria->compare('LOWER(t.nomor_notadinas)',strtolower($this->nomor_notadinas),true);
                $criteria->compare('LOWER(t.supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(status)',strtolower($this->status),true);
		$criteria->compare('nilai_pengadaan',$this->nilai_pengadaan);
                $criteria->limit=-1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
}