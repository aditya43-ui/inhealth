<?php

/**
 * This is the model class for table "informasijadwalpegawai_v".
 *
 * The followings are the available columns in table 'informasijadwalpegawai_v':
 * @property string $no_pembuatanjadwal
 * @property string $tglbuatjadwal
 * @property integer $shift_id
 * @property string $shift_jamawal
 * @property string $shift_jamakhir
 * @property string $shift_nama
 * @property string $shift_kode
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $nama_pegawai
 * @property integer $kelompokpegawai_id
 * @property string $kelompokpegawai_nama
 * @property string $periodebuatjadwal
 * @property string $sampaidengan
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $mengetahui_id
 * @property integer $menyetujiu_id
 * @property string $keterangan_penjadwalan
 */
class InformasijadwalpegawaiV extends CActiveRecord
{
	public $gelarbelakang_nama;
	public $gelardepan;
	public $create_ruangan;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasijadwalpegawaiV the static model class
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
		return 'informasijadwalpegawai_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shift_id, ruangan_id, kelompokpegawai_id, instalasi_id, mengetahui_id, menyetujiu_id', 'numerical', 'integerOnly'=>true),
			array('no_pembuatanjadwal', 'length', 'max'=>100),
			array('shift_nama, ruangan_nama, nama_pegawai, instalasi_nama', 'length', 'max'=>50),
			array('shift_kode', 'length', 'max'=>1),
			array('kelompokpegawai_nama', 'length', 'max'=>30),
			array('pegawai_id, tglbuatjadwal, shift_jamawal, shift_jamakhir, periodebuatjadwal, sampaidengan, keterangan_penjadwalan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('no_pembuatanjadwal, tglbuatjadwal, shift_id, shift_jamawal, shift_jamakhir, shift_nama, shift_kode, ruangan_id, ruangan_nama, nama_pegawai, kelompokpegawai_id, kelompokpegawai_nama, periodebuatjadwal, sampaidengan, instalasi_id, instalasi_nama, mengetahui_id, menyetujiu_id, keterangan_penjadwalan', 'safe', 'on'=>'search'),
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
			'no_pembuatanjadwal' => 'No Pembuatan Jadwal',
			'tglbuatjadwal' => 'Tgl. Buat Jadwal',
			'shift_id' => 'Shift',
			'shift_jamawal' => 'Shift Jam Awal',
			'shift_jamakhir' => 'Shift Jam Akhir',
			'shift_nama' => 'Nama Shift',
			'shift_kode' => 'Kode Shift',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'nama_pegawai' => 'Nama Pegawai',
			'kelompokpegawai_id' => 'Kelompok Pegawai',
			'kelompokpegawai_nama' => 'Nama Kelompok Pegawai',
			'periodebuatjadwal' => 'Periode Buat Jadwal',
			'sampaidengan' => 'Sampaidengan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Nama Instalasi',
			'mengetahui_id' => 'Mengetahui',
			'menyetujiu_id' => 'Menyetujui',
			'keterangan_penjadwalan' => 'Keterangan Penjadwalan',
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

		$criteria->compare('LOWER(no_pembuatanjadwal)',strtolower($this->no_pembuatanjadwal),true);
		$criteria->compare('LOWER(tglbuatjadwal)',strtolower($this->tglbuatjadwal),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		$criteria->compare('LOWER(shift_jamawal)',strtolower($this->shift_jamawal),true);
		$criteria->compare('LOWER(shift_jamakhir)',strtolower($this->shift_jamakhir),true);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);
		$criteria->compare('LOWER(shift_kode)',strtolower($this->shift_kode),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->kelompokpegawai_id)){
			$criteria->addCondition('kelompokpegawai_id = '.$this->kelompokpegawai_id);
		}
		$criteria->compare('LOWER(kelompokpegawai_nama)',strtolower($this->kelompokpegawai_nama),true);
		$criteria->compare('LOWER(periodebuatjadwal)',strtolower($this->periodebuatjadwal),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		if(!empty($this->menyetujiu_id)){
			$criteria->addCondition('menyetujiu_id = '.$this->menyetujiu_id);
		}
		$criteria->compare('LOWER(keterangan_penjadwalan)',strtolower($this->keterangan_penjadwalan),true);

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
		
		public function generateJadwal(){
			$cri = new CDbCriteria();	
			$cri->select = " t.*, gb.gelarbelakang_nama, p.gelardepan, jadwal.create_ruangan";
			$cri->join =	"	JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id "
						.	"	LEFT JOIN gelarbelakang_m gb ON gb.gelarbelakang_id = p.gelarbelakang_id "
						.	"	JOIN penjadwalan_t jadwal ON jadwal.no_pembuatanjadwal = t.no_pembuatanjadwal "
						.	"	JOIN ruangan_m cr ON cr.ruangan_id = jadwal.create_ruangan";
			
			if (!empty($this->kelompokpegawai_id)){
				$cri->addCondition(" t.kelompokpegawai_id = ". $this->kelompokpegawai_id);
			}
			
			if (!empty($this->shift_id)){
				$cri->addCondition(" t.shift_id = ". $this->shift_id);
			}
			
			if (!empty($this->ruangan_id)){
				$cri->addCondition(" t.ruangan_id = ". $this->ruangan_id." OR  jadwal.create_ruangan = ".$this->ruangan_id." ");
			}
			
			if (!empty($this->instalasi_id)){
				$cri->addCondition(" t.instalasi_id = ". $this->instalasi_id." OR  cr.instalasi_id = ".$this->instalasi_id." ");
			}
			
			//if (!empty($this->kelompokpegawai_id)){
			$cri->compare(" LOWER(t.nama_pegawai) ", strtolower($this->nama_pegawai),true);
			//}
			$cri->order = " tglbuatjadwal ASC, kelompokpegawai_nama ASC, t.nama_pegawai ASC ";
			$get = self::model()->findAll($cri);
			$data = array();
			
			foreach ($get as $g){
				$tglbuatjawal = (date('dmY', strtotime($g->tgljadwalpegawai))).$g->pegawai_id;
				$tglshift = (date('dmY', strtotime($g->tgljadwalpegawai))).$g->shift_id;
				$tgl = 	date('dmY', strtotime($g->tgljadwalpegawai));
				
				$data["$tgl"]['det']["$tglshift"]['shift_nama'] = $g->shift_nama;
				$data["$tgl"]['det']["$tglshift"]['shift_jamawal'] = $g->shift_jamawal;
				$data["$tgl"]['det']["$tglshift"]['shift_jamakhir'] = $g->shift_jamakhir;
				$data["$tgl"]['det']["$tglshift"]['det']["$tglbuatjawal"]['nama_pegawai'] = $g->gelardepan.' '.$g->nama_pegawai.', '.$g->gelarbelakang_nama;
				$data["$tgl"]['det']["$tglshift"]['det']["$tglbuatjawal"]['kelompokpegawai_id'] = $g->kelompokpegawai_id;
				$data["$tgl"]['det']["$tglshift"]['det']["$tglbuatjawal"]['penjadwalandetail_id'] = $g->penjadwalandetail_id;
				$data["$tgl"]['det']["$tglshift"]['det']["$tglbuatjawal"]['create_ruangan'] = $g->create_ruangan;
			}
		
			return $data;
		}
}