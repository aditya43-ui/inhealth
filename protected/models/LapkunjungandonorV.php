<?php

/**
 * This is the model class for table "lapkunjungandonor_v".
 *
 * @author Andyka Putra <andykaputra@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'lapkunjungandonor_v':
 * @property integer $pendonor_id
 * @property string $no_pendonor
 * @property string $jenisidentitas
 * @property string $no_identitas
 * @property string $nama_lengkap
 * @property string $tempat_lahir
 * @property string $tgllahir
 * @property string $jenis_kelamin
 * @property string $alamat_lengkap
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property string $notelp_pendonor
 * @property string $nomobile_pendonor
 * @property integer $pekerjaan_id
 * @property string $statusperkawinan
 * @property string $gol_darah
 * @property string $rhesus
 * @property integer $donor_itd_ke
 * @property boolean $is_pernah_donor
 * @property integer $daftardonasi_id
 * @property string $no_formulir
 * @property string $waktu_pendaftaran
 * @property integer $ruangan_rekruitmen_id
 * @property string $status
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $keterangan_donasi
 * @property integer $donasi_ke
 * @property integer $seleksidonor_id
 * @property string $tglseleksidonor
 * @property string $jenisdonor
 * @property string $tekanandarah
 * @property integer $td_systolic
 * @property integer $td_diastoliic
 * @property double $kadar_hb
 * @property integer $suhu_tubuh
 * @property integer $detaknadi
 * @property boolean $is_gagalseleksi
 * @property boolean $hb_rendah
 * @property boolean $bb_rendah
 * @property boolean $medis_hb_17
 * @property boolean $medis_td_rendah
 * @property boolean $medis_tk_tinggi
 * @property boolean $medis_bb_lebih
 * @property boolean $medis_vaksin
 * @property boolean $perilakuberesiko
 * @property boolean $riwberpergian
 * @property boolean $lain_lain
 * @property string $catatan_dokter
 * @property string $status_pendonor
 */
class LapkunjungandonorV extends CActiveRecord
{
        public $jns_periode, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir,$tgl_awal, $tgl_akhir, $tampilGrafik;
        //untuk grafik
        public $jumlah,$data,$type;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LapkunjungandonorV the static model class
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
		return 'lapkunjungandonor_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendonor_id, pekerjaan_id, donor_itd_ke, daftardonasi_id, ruangan_rekruitmen_id, instalasi_id, ruangan_id, donasi_ke, seleksidonor_id, td_systolic, td_diastoliic, suhu_tubuh, detaknadi', 'numerical', 'integerOnly'=>true),
			array('beratbadan_kg, tinggibadan_cm, kadar_hb', 'numerical'),
			array('no_pendonor, no_identitas, no_formulir, status, instalasi_nama, ruangan_nama', 'length', 'max'=>50),
			array('jenisidentitas', 'length', 'max'=>30),
			array('nama_lengkap, tempat_lahir, notelp_pendonor', 'length', 'max'=>100),
			array('jenis_kelamin, statusperkawinan, rhesus, tekanandarah', 'length', 'max'=>20),
			array('alamat_lengkap, nomobile_pendonor, jenisdonor', 'length', 'max'=>255),
			array('gol_darah', 'length', 'max'=>2),
			array('status_pendonor', 'length', 'max'=>10),
			array('tgllahir, is_pernah_donor, waktu_pendaftaran, keterangan_donasi, tglseleksidonor, is_gagalseleksi, hb_rendah, bb_rendah, medis_hb_17, medis_td_rendah, medis_tk_tinggi, medis_bb_lebih, medis_vaksin, perilakuberesiko, riwberpergian, lain_lain, catatan_dokter', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendonor_id, no_pendonor, jenisidentitas, no_identitas, nama_lengkap, tempat_lahir, tgllahir, jenis_kelamin, alamat_lengkap, beratbadan_kg, tinggibadan_cm, notelp_pendonor, nomobile_pendonor, pekerjaan_id, statusperkawinan, gol_darah, rhesus, donor_itd_ke, is_pernah_donor, daftardonasi_id, no_formulir, waktu_pendaftaran, ruangan_rekruitmen_id, status, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, keterangan_donasi, donasi_ke, seleksidonor_id, tglseleksidonor, jenisdonor, tekanandarah, td_systolic, td_diastoliic, kadar_hb, suhu_tubuh, detaknadi, is_gagalseleksi, hb_rendah, bb_rendah, medis_hb_17, medis_td_rendah, medis_tk_tinggi, medis_bb_lebih, medis_vaksin, perilakuberesiko, riwberpergian, lain_lain, catatan_dokter, status_pendonor', 'safe', 'on'=>'search'),
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
			'pendonor_id' => 'Pendonor',
			'no_pendonor' => 'No Pendonor',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas' => 'No Identitas',
			'nama_lengkap' => 'Nama Lengkap',
			'tempat_lahir' => 'Tempat Lahir',
			'tgllahir' => 'Tgllahir',
			'jenis_kelamin' => 'Jenis Kelamin',
			'alamat_lengkap' => 'Alamat Lengkap',
			'beratbadan_kg' => 'Beratbadan Kg',
			'tinggibadan_cm' => 'Tinggibadan Cm',
			'notelp_pendonor' => 'Notelp Pendonor',
			'nomobile_pendonor' => 'Nomobile Pendonor',
			'pekerjaan_id' => 'Pekerjaan',
			'statusperkawinan' => 'Statusperkawinan',
			'gol_darah' => 'Gol Darah',
			'rhesus' => 'Rhesus',
			'donor_itd_ke' => 'Donor Itd Ke',
			'is_pernah_donor' => 'Is Pernah Donor',
			'daftardonasi_id' => 'Daftardonasi',
			'no_formulir' => 'No Formulir',
			'waktu_pendaftaran' => 'Waktu Pendaftaran',
			'ruangan_rekruitmen_id' => 'Ruangan Rekruitmen',
			'status' => 'Status',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'keterangan_donasi' => 'Keterangan Donasi',
			'donasi_ke' => 'Donasi Ke',
			'seleksidonor_id' => 'Seleksidonor',
			'tglseleksidonor' => 'Tglseleksidonor',
			'jenisdonor' => 'Jenisdonor',
			'tekanandarah' => 'Tekanandarah',
			'td_systolic' => 'Td Systolic',
			'td_diastoliic' => 'Td Diastoliic',
			'kadar_hb' => 'Kadar Hb',
			'suhu_tubuh' => 'Suhu Tubuh',
			'detaknadi' => 'Detaknadi',
			'is_gagalseleksi' => 'Is Gagalseleksi',
			'hb_rendah' => 'Hb Rendah',
			'bb_rendah' => 'Bb Rendah',
			'medis_hb_17' => 'Medis Hb 17',
			'medis_td_rendah' => 'Medis Td Rendah',
			'medis_tk_tinggi' => 'Medis Tk Tinggi',
			'medis_bb_lebih' => 'Medis Bb Lebih',
			'medis_vaksin' => 'Medis Vaksin',
			'perilakuberesiko' => 'Perilakuberesiko',
			'riwberpergian' => 'Riwberpergian',
			'lain_lain' => 'Lain Lain',
			'catatan_dokter' => 'Catatan Dokter',
			'status_pendonor' => 'Status Pendonor',
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

		$criteria->compare('pendonor_id',$this->pendonor_id);
		$criteria->compare('no_pendonor',$this->no_pendonor,true);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('nama_lengkap',$this->nama_lengkap,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tgllahir',$this->tgllahir,true);
		$criteria->compare('jenis_kelamin',$this->jenis_kelamin,true);
		$criteria->compare('alamat_lengkap',$this->alamat_lengkap,true);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('notelp_pendonor',$this->notelp_pendonor,true);
		$criteria->compare('nomobile_pendonor',$this->nomobile_pendonor,true);
		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('gol_darah',$this->gol_darah,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('donor_itd_ke',$this->donor_itd_ke);
		$criteria->compare('is_pernah_donor',$this->is_pernah_donor);
		$criteria->compare('daftardonasi_id',$this->daftardonasi_id);
		$criteria->compare('no_formulir',$this->no_formulir,true);
		$criteria->compare('waktu_pendaftaran',$this->waktu_pendaftaran,true);
		$criteria->compare('ruangan_rekruitmen_id',$this->ruangan_rekruitmen_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('keterangan_donasi',$this->keterangan_donasi,true);
		$criteria->compare('donasi_ke',$this->donasi_ke);
		$criteria->compare('seleksidonor_id',$this->seleksidonor_id);
		$criteria->compare('tglseleksidonor',$this->tglseleksidonor,true);
		$criteria->compare('jenisdonor',$this->jenisdonor,true);
		$criteria->compare('tekanandarah',$this->tekanandarah,true);
		$criteria->compare('td_systolic',$this->td_systolic);
		$criteria->compare('td_diastoliic',$this->td_diastoliic);
		$criteria->compare('kadar_hb',$this->kadar_hb);
		$criteria->compare('suhu_tubuh',$this->suhu_tubuh);
		$criteria->compare('detaknadi',$this->detaknadi);
		$criteria->compare('is_gagalseleksi',$this->is_gagalseleksi);
		$criteria->compare('hb_rendah',$this->hb_rendah);
		$criteria->compare('bb_rendah',$this->bb_rendah);
		$criteria->compare('medis_hb_17',$this->medis_hb_17);
		$criteria->compare('medis_td_rendah',$this->medis_td_rendah);
		$criteria->compare('medis_tk_tinggi',$this->medis_tk_tinggi);
		$criteria->compare('medis_bb_lebih',$this->medis_bb_lebih);
		$criteria->compare('medis_vaksin',$this->medis_vaksin);
		$criteria->compare('perilakuberesiko',$this->perilakuberesiko);
		$criteria->compare('riwberpergian',$this->riwberpergian);
		$criteria->compare('lain_lain',$this->lain_lain);
		$criteria->compare('catatan_dokter',$this->catatan_dokter,true);
		$criteria->compare('status_pendonor',$this->status_pendonor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    /**
     * Filter Tabel Kunjungan
     * @return \CActiveDataProvider
     */
    public function searchTableKunjungan() {
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        if(!empty($this->ruangan_rekruitmen_id)){
            $criteria->addInCondition('ruangan_rekruitmen_id',$this->ruangan_rekruitmen_id);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /** 
     * Fungsi untuk generate filter / criteria pada frame grafik
     * $model adalah model yang akan digunakan untuk grafik
     * $type adalah filter akan digunakan sebagai x-axis('data') atau group('tick'), default type sebagai x-axis('data')
     * $addCols variable untuk column tmbahan, typenya mix, diantaranya untuk order dll,
     * 
     * @param type $model
     * @param type $type
     * @param type $addCols
     * @return \CDbCriteria
     */
    public static function criteriaGrafik($model, $type='data', $addCols = array()){
        $criteria = new CDbCriteria;
        
        if ($_GET['LapkunjungandonorV']['tampilGrafik'] == 'ruangan'){
            $criteria->join = 'JOIN ruangan_m ON ruangan_m.ruangan_id = t.ruangan_rekruitmen_id';
            $criteria->select = 'count(daftardonasi_id) as jumlah, ruangan_m.ruangan_nama as '.$type;
            $criteria->group .= 'ruangan_m.ruangan_nama';
        }else if ($_GET['LapkunjungandonorV']['tampilGrafik'] == 'donorke'){
            $criteria->select = "count(daftardonasi_id) as jumlah,"
                                . "(case when pendonorlama_v.count IS NOT null then '>1' else '1x' end) as data";
            $criteria->join = "LEFT JOIN pendonorlama_v ON t.pendonor_id = pendonorlama_v.pendonor_id 
                               LEFT JOIN pendonorbaru_v ON t.pendonor_id = pendonorbaru_v.pendonor_id";
            $criteria->group .= "pendonorlama_v.count";
        }else if ($_GET['LapkunjungandonorV']['tampilGrafik'] == 'jeniskelamin'){
            $criteria->select = 'count(daftardonasi_id) as jumlah, t.jenis_kelamin as '.$type;
            $criteria->group .= 't.jenis_kelamin';
        }else if ($_GET['LapkunjungandonorV']['tampilGrafik'] == 'jenisdonor'){
            $criteria->select = 'count(t.daftardonasi_id) as jumlah, t.jenisdonor as '.$type;
            $criteria->group .= 't.jenisdonor';
        }

        if (count($addCols) > 0){
            if (is_array($addCols)){
                foreach ($addCols as $i => $v){
                    $criteria->group .= ','.$v;
                    $criteria->select .= ','.$v.' as '.$i;
                }
            }            
        }

        return $criteria;
    }
    
    /**
     * Filtering frame grafik laporan kunjungan
     * @return \CActiveDataProvider
     */
    public function searchGrafikKunjungan() {

        $criteria = $this->criteriaGrafik($this);
        $format = new MyFormatter();
        
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        if(!empty($this->ruangan_rekruitmen_id)){
            $criteria->addInCondition('ruangan_rekruitmen_id',$this->ruangan_rekruitmen_id);
        }
        $criteria->order = "jumlah DESC";
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}