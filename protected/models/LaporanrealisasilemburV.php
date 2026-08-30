<?php

/**
 * This is the model class for table "laporanrealisasilembur_v".
 *
 * The followings are the available columns in table 'laporanrealisasilembur_v':
 * @property integer $realisasilembur_id
 * @property string $tglrealisasi
 * @property string $norealisasi
 * @property integer $create_ruangan
 * @property string $create_ruangan_nama
 * @property string $nama_pegawai
 * @property integer $realisasilemburdet_id
 * @property string $nourut
 * @property string $alasanlembur
 * @property string $tglmulai
 * @property string $tglselesai
 * @property integer $total_jam
 * @property double $nilai_lembur
 * @property double $total_nilai_lembur
 * @property integer $pemberitugas_id
 * @property string $gelardepan_pegawaitugas
 * @property string $nama_pegawaitugas
 * @property string $gelarbelakang_pegawaitugas
 * @property integer $mengetahui_id
 * @property string $gelardepan_mengetahui
 * @property string $nama_mengetahui
 * @property string $gelarbelakang_mengetahui
 * @property integer $menyetujui_id
 * @property string $gelardepan_menyetujui
 * @property string $nama_menyetujui
 * @property string $gelarbelakang_menyetujui
 */
class LaporanrealisasilemburV extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir;
    public $instalasi_id;
    public $is_tertinggi = false;
    
    
    public function primaryKey() {
        return "realisasilemburdet_id";
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrealisasilemburV the static model class
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
		return 'laporanrealisasilembur_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('realisasilembur_id, create_ruangan, realisasilemburdet_id, total_jam, pemberitugas_id, mengetahui_id, menyetujui_id', 'numerical', 'integerOnly'=>true),
			array('nilai_lembur, total_nilai_lembur, upah_lembur_jam1, upah_lembur_jam2, upah_lembur_jam3, upahsejamlembur, upah_bulanan, total_jam_normal', 'numerical'),
			array('norealisasi', 'length', 'max'=>20),
			array('create_ruangan_nama, nama_pegawai, nama_pegawaitugas, nama_mengetahui, nama_menyetujui', 'length', 'max'=>50),
			array('nourut', 'length', 'max'=>3),
			array('alasanlembur', 'length', 'max'=>500),
			array('gelardepan_pegawaitugas, gelardepan_mengetahui, gelardepan_menyetujui', 'length', 'max'=>10),
			array('gelarbelakang_pegawaitugas, gelarbelakang_mengetahui, gelarbelakang_menyetujui', 'length', 'max'=>15),
			array('tgl_awal, tgl_akhir, tglrealisasi, tglmulai, tglselesai, instalasi_id, is_tertinggi, jenislembur', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, is_tertinggi, tgl_awal, tgl_akhir, realisasilembur_id, tglrealisasi, norealisasi, create_ruangan, create_ruangan_nama, nama_pegawai, realisasilemburdet_id, nourut, alasanlembur, tglmulai, tglselesai, total_jam, nilai_lembur, total_nilai_lembur, pemberitugas_id, gelardepan_pegawaitugas, nama_pegawaitugas, gelarbelakang_pegawaitugas, mengetahui_id, gelardepan_mengetahui, nama_mengetahui, gelarbelakang_mengetahui, menyetujui_id, gelardepan_menyetujui, nama_menyetujui, gelarbelakang_menyetujui, jenislembur, upah_lembur_jam1, upah_lembur_jam2, upah_lembur_jam3, upahsejamlembur, upah_bulanan, total_jam_normal', 'safe', 'on'=>'search'),
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
			'realisasilembur_id' => 'Realisasilembur',
			'tglrealisasi' => 'Tgl. Realisasi',
			'norealisasi' => 'No. Realisasi',
			'create_ruangan' => 'Ruangan',
			'create_ruangan_nama' => 'Ruangan',
			'nama_pegawai' => 'Pegawai Lembur',
			'realisasilemburdet_id' => 'Realisasilemburdet',
			'nourut' => 'Nourut',
			'alasanlembur' => 'Alasan Lembur',
			'tglmulai' => 'Jam Mulai',
			'tglselesai' => 'Jam Selesai',
			'total_jam' => 'Total Jam',
			'nilai_lembur' => 'Nilai Lembur',
			'total_nilai_lembur' => 'Total Nilai Lembur',
			'pemberitugas_id' => 'Pemberi Tugas',
			'gelardepan_pegawaitugas' => 'Gelardepan Pegawaitugas',
			'nama_pegawaitugas' => 'Pemberi Tugas',
			'gelarbelakang_pegawaitugas' => 'Gelarbelakang Pegawaitugas',
			'mengetahui_id' => 'Mengetahui',
			'gelardepan_mengetahui' => 'Gelardepan Mengetahui',
			'nama_mengetahui' => 'Mengetahui',
			'gelarbelakang_mengetahui' => 'Gelarbelakang Mengetahui',
			'menyetujui_id' => 'Menyetujui',
			'gelardepan_menyetujui' => 'Gelardepan Menyetujui',
			'nama_menyetujui' => 'Menyetujui',
			'gelarbelakang_menyetujui' => 'Gelarbelakang Menyetujui',
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

        $criteria->join = 'left join ruangan_m r on r.ruangan_id = t.create_ruangan';
        
		$criteria->compare('t.realisasilembur_id',$this->realisasilembur_id);
		$criteria->compare('t.tglrealisasi',$this->tglrealisasi,true);
		$criteria->compare('t.norealisasi',$this->norealisasi,true);
		$criteria->compare('t.create_ruangan',$this->create_ruangan);
		$criteria->compare('t.create_ruangan_nama',$this->create_ruangan_nama,true);
		$criteria->compare('t.nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('t.realisasilemburdet_id',$this->realisasilemburdet_id);
		$criteria->compare('t.nourut',$this->nourut,true);
		$criteria->compare('t.alasanlembur',$this->alasanlembur,true);
		$criteria->compare('t.tglmulai',$this->tglmulai,true);
		$criteria->compare('t.tglselesai',$this->tglselesai,true);
		$criteria->compare('t.total_jam',$this->total_jam);
		$criteria->compare('t.nilai_lembur',$this->nilai_lembur);
		$criteria->compare('t.total_nilai_lembur',$this->total_nilai_lembur);
		$criteria->compare('t.pemberitugas_id',$this->pemberitugas_id);
		$criteria->compare('t.gelardepan_pegawaitugas',$this->gelardepan_pegawaitugas,true);
		$criteria->compare('t.nama_pegawaitugas',$this->nama_pegawaitugas,true);
		$criteria->compare('t.gelarbelakang_pegawaitugas',$this->gelarbelakang_pegawaitugas,true);
		$criteria->compare('t.mengetahui_id',$this->mengetahui_id);
		$criteria->compare('t.gelardepan_mengetahui',$this->gelardepan_mengetahui,true);
		$criteria->compare('t.nama_mengetahui',$this->nama_mengetahui,true);
		$criteria->compare('t.gelarbelakang_mengetahui',$this->gelarbelakang_mengetahui,true);
		$criteria->compare('t.menyetujui_id',$this->menyetujui_id);
		$criteria->compare('t.gelardepan_menyetujui',$this->gelardepan_menyetujui,true);
		$criteria->compare('t.nama_menyetujui',$this->nama_menyetujui,true);
		$criteria->compare('t.gelarbelakang_menyetujui',$this->gelarbelakang_menyetujui,true);
		$criteria->compare('r.instalasi_id',$this->instalasi_id,true);

        $criteria->addCondition("t.tglrealisasi::date between '".$this->tgl_awal."'::date and '".$this->tgl_akhir."'::date");
        
        if ($this->is_tertinggi) {
            $criteria->order = 'total_jam desc, tglrealisasi desc';
        }
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'tglrealisasi desc',
            ),
		));
	}
	
	public function getNamaLengkapPemberi(){
		return $this->gelardepan_pegawaitugas.' '.$this->nama_pegawaitugas.' '.$this->gelarbelakang_pegawaitugas;
	}
	
	public function getNamaLengkapMengetahui(){
		return $this->gelardepan_mengetahui.' '.$this->nama_mengetahui.' '.$this->gelarbelakang_mengetahui;
	}
	
	public function getNamaLengkapMenyetujui(){
		return $this->gelardepan_menyetujui.' '.$this->nama_menyetujui.' '.$this->gelarbelakang_menyetujui;
	}
}