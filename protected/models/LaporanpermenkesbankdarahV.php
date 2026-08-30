<?php

/**
 * This is the model class for table "laporanpermenkesbankdarah_v".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'laporanpermenkesbankdarah_v':
 * @property integer $pendonor_id
 * @property string $no_pendonor
 * @property string $no_identitas
 * @property string $nama_lengkap
 * @property string $tgllahir
 * @property string $jenis_kelamin
 * @property string $gol_darah
 * @property string $rhesus
 * @property integer $donor_itd_ke
 * @property integer $daftardonasi_id
 * @property string $no_formulir
 * @property string $waktu_pendaftaran
 * @property integer $donasi_ke
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $seleksidonor_id
 * @property string $tglseleksidonor
 * @property integer $seleksi_umur
 * @property string $kelompok_umur
 * @property string $gagal_seleksi
 * @property string $jenisdonor
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
 * @property integer $kantongdarah_id
 * @property string $nomorbarcode_utama
 */
class LaporanpermenkesbankdarahV extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir, $jns_periode, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $data, $jumlah;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpermenkesbankdarahV the static model class
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
		return 'laporanpermenkesbankdarah_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendonor_id, donor_itd_ke, daftardonasi_id, donasi_ke, ruangan_id, seleksidonor_id, seleksi_umur', 'numerical', 'integerOnly'=>true),
			array('no_pendonor, no_identitas, no_formulir, ruangan_nama', 'length', 'max'=>50),
			array('nama_lengkap', 'length', 'max'=>100),
			array('jenis_kelamin, rhesus', 'length', 'max'=>20),
			array('gol_darah', 'length', 'max'=>2),
			array('jenisdonor', 'length', 'max'=>255),
			array('nomorbarcode_utama', 'length', 'max'=>30),
			array('singkatan_komp', 'length', 'max'=>5),
			array('bataldonordarah, tgllahir, waktu_pendaftaran, tglseleksidonor, kelompok_umur, gagal_seleksi, is_gagalseleksi, hb_rendah, bb_rendah, medis_hb_17, medis_td_rendah, medis_tk_tinggi, medis_bb_lebih, medis_vaksin, perilakuberesiko, riwberpergian, lain_lain', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendonor_id, no_pendonor, no_identitas, nama_lengkap, tgllahir, jenis_kelamin, gol_darah, rhesus, donor_itd_ke, daftardonasi_id, no_formulir, waktu_pendaftaran, donasi_ke, ruangan_id, ruangan_nama, seleksidonor_id, tglseleksidonor, seleksi_umur, kelompok_umur, gagal_seleksi, jenisdonor, is_gagalseleksi, hb_rendah, bb_rendah, medis_hb_17, medis_td_rendah, medis_tk_tinggi, medis_bb_lebih, medis_vaksin, perilakuberesiko, riwberpergian, lain_lain, kantongdarah_id, nomorbarcode_utama', 'safe', 'on'=>'search'),
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
			'no_identitas' => 'No Identitas',
			'nama_lengkap' => 'Nama Lengkap',
			'tgllahir' => 'Tgllahir',
			'jenis_kelamin' => 'Jenis Kelamin',
			'gol_darah' => 'Gol Darah',
			'rhesus' => 'Rhesus',
			'donor_itd_ke' => 'Donor Itd Ke',
			'daftardonasi_id' => 'Daftardonasi',
			'no_formulir' => 'No Formulir',
			'waktu_pendaftaran' => 'Waktu Pendaftaran',
			'donasi_ke' => 'Donasi Ke',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'seleksidonor_id' => 'Seleksidonor',
			'tglseleksidonor' => 'Tglseleksidonor',
			'seleksi_umur' => 'Seleksi Umur',
			'kelompok_umur' => 'Kelompok Umur',
			'gagal_seleksi' => 'Gagal Seleksi',
			'jenisdonor' => 'Jenisdonor',
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
			'nomorbarcode_utama' => 'Nomorbarcode Utama',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pendonor_id',$this->pendonor_id);
		$criteria->compare('no_pendonor',$this->no_pendonor,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('nama_lengkap',$this->nama_lengkap,true);
		$criteria->compare('tgllahir',$this->tgllahir,true);
		$criteria->compare('jenis_kelamin',$this->jenis_kelamin,true);
		$criteria->compare('gol_darah',$this->gol_darah,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('donor_itd_ke',$this->donor_itd_ke);
		$criteria->compare('daftardonasi_id',$this->daftardonasi_id);
		$criteria->compare('no_formulir',$this->no_formulir,true);
		$criteria->compare('waktu_pendaftaran',$this->waktu_pendaftaran,true);
		$criteria->compare('donasi_ke',$this->donasi_ke);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('seleksidonor_id',$this->seleksidonor_id);
		$criteria->compare('tglseleksidonor',$this->tglseleksidonor,true);
		$criteria->compare('seleksi_umur',$this->seleksi_umur);
		$criteria->compare('kelompok_umur',$this->kelompok_umur,true);
		$criteria->compare('gagal_seleksi',$this->gagal_seleksi,true);
		$criteria->compare('jenisdonor',$this->jenisdonor,true);
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
		$criteria->compare('nomorbarcode_utama',$this->nomorbarcode_utama,true);

		return $criteria;
	}
        
         /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = $this->criteriaSearch();

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchTable() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = $this->criteriaSearch();

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchPrint() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = $this->criteriaSearch();

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }
}