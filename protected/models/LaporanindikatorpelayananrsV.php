<?php

/**
 * This is the model class for table "laporanindikatorpelayananrs_v".
 *
 * The followings are the available columns in table 'laporanindikatorpelayananrs_v':
 * @property string $tgl_laporan
 * @property integer $profilrs_id
 * @property double $bor
 * @property double $los
 * @property double $bto
 * @property double $toi
 * @property double $ndr
 * @property double $gdr
 * @property integer $pendaftaran_id
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pasienpulang_id
 * @property integer $carakeluar_id
 * @property string $carakeluar_nama
 * @property integer $kondisikeluar_id
 * @property string $kondisikeluar_nama
 * @property integer $hariperawatan
 * @property integer $lamarawat
 * @property integer $pasienadmisi_id
 * @property integer $kamarruangan_id
 */
class LaporanindikatorpelayananrsV extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        public $bln_awal;
        public $bln_akhir;
        public $thn_awal;
        public $thn_akhir;        
        public $jns_periode;
        public $jumlah;
        public $data;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanindikatorpelayananrsV the static model class
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
		return 'laporanindikatorpelayananrs_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, pendaftaran_id, kelaspelayanan_id, instalasi_id, ruangan_id, pasienpulang_id, carakeluar_id, kondisikeluar_id, hariperawatan, lamarawat, pasienadmisi_id, kamarruangan_id', 'numerical', 'integerOnly'=>true),
			array('bor, los, bto, toi, ndr, gdr', 'numerical'),
			array('kelaspelayanan_nama, instalasi_nama, ruangan_nama', 'length', 'max'=>50),
			array('carakeluar_nama, kondisikeluar_nama', 'length', 'max'=>100),
			array('tgl_laporan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_laporan, profilrs_id, bor, los, bto, toi, ndr, gdr, pendaftaran_id, kelaspelayanan_id, kelaspelayanan_nama, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, pasienpulang_id, carakeluar_id, carakeluar_nama, kondisikeluar_id, kondisikeluar_nama, hariperawatan, lamarawat, pasienadmisi_id, kamarruangan_id', 'safe', 'on'=>'search'),
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
			'tgl_laporan' => 'Tgl. Laporan',
			'profilrs_id' => 'Profilrs',
			'bor' => 'Bor',
			'los' => 'Los',
			'bto' => 'Bto',
			'toi' => 'Toi',
			'ndr' => 'Ndr',
			'gdr' => 'Gdr',
			'pendaftaran_id' => 'Pendaftaran',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'pasienpulang_id' => 'Pasienpulang',
			'carakeluar_id' => 'Carakeluar',
			'carakeluar_nama' => 'Carakeluar Nama',
			'kondisikeluar_id' => 'Kondisikeluar',
			'kondisikeluar_nama' => 'Kondisikeluar Nama',
			'hariperawatan' => 'Hariperawatan',
			'lamarawat' => 'Lamarawat',
			'pasienadmisi_id' => 'Pasienadmisi',
			'kamarruangan_id' => 'Kamarruangan',
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

		$criteria->compare('tgl_laporan',$this->tgl_laporan,true);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('bor',$this->bor);
		$criteria->compare('los',$this->los);
		$criteria->compare('bto',$this->bto);
		$criteria->compare('toi',$this->toi);
		$criteria->compare('ndr',$this->ndr);
		$criteria->compare('gdr',$this->gdr);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('carakeluar_id',$this->carakeluar_id);
		$criteria->compare('carakeluar_nama',$this->carakeluar_nama,true);
		$criteria->compare('kondisikeluar_id',$this->kondisikeluar_id);
		$criteria->compare('kondisikeluar_nama',$this->kondisikeluar_nama,true);
		$criteria->compare('hariperawatan',$this->hariperawatan);
		$criteria->compare('lamarawat',$this->lamarawat);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getBorKelas($kelaspelayanan_id, $tgl_awal, $tgl_akhir){
            $cri = new CDbCriteria();
            $cri->select = " kelaspelayanan_nama, kelaspelayanan_id, profilrs_id, count(pasienadmisi_id) as jumlah";
            $cri->addCondition(" kelaspelayanan_id = '".$kelaspelayanan_id."' ");                        
            $cri->addBetweenCondition(" (tgl_laporan) ", $tgl_awal, $tgl_akhir);  
            $cri->addCondition(" pasienadmisi_id IS NOT NULL AND kamarruangan_id IS NOT NULL ");
            $cri->group = "  kelaspelayanan_id, kelaspelayanan_nama, profilrs_id ";
            $all = LaporanindikatorpelayananrsV::model()->find($cri);
            
            $kamar = KamarruanganM::model()->findAllByAttributes(array('kelaspelayanan_id'=>$kelaspelayanan_id,'kamarruangan_aktif'=>true));
                       
            $bor = 0;
            if (count((array)$all)>0){
                $hp = $all->jumlah;
                $totKamar = count((array)$kamar);
                
                $periode = CustomFunction::hitungHari($tgl_akhir, $tgl_awal);
                if ($periode==0){
                    $periode = 24;
                }                
                
                $bor = ($hp/ ($totKamar*$periode) )*100;
                return number_format($bor,2).' %';
            }else{
                return number_format($bor,2).' %';
            }
        }
}