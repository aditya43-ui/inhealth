<?php

/**
 * This is the model class for table "pesangonpeg_t".
 *
 * The followings are the available columns in table 'pesangonpeg_t':
 * @property integer $pesangonpeg_id
 * @property integer $pengeluaranumum_id
 * @property integer $pegawai_id
 * @property string $tglpesangon
 * @property string $nopesangon
 * @property string $keterangan
 * @property string $mengetahui
 * @property string $menyetujui
 * @property double $totalterima
 * @property double $totalpajak
 * @property double $totalpotongan
 * @property double $penerimaanbersih
 * @property string $periodegaji
 * @property double $gajipertahun
 * @property double $biayajabatan
 * @property double $potonganpensiun
 * @property string $kodeptkp
 * @property double $ptkppertahun
 * @property double $penerimaanbersihpertahun
 * @property double $pkp
 * @property integer $persentasepph21
 * @property double $pph21pertahun
 * @property double $pph21perbulan
 * @property double $potongan_lainlain
 * @property integer $harikerja
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $tgl_mengetahui
 * @property string $tgl_menyetujui
 * @property integer $mengetahui_id
 * @property integer $menyetujui_id
 * @property double $jaminanpensiun
 * @property double $bpjskesehatan
 * @property double $gajipokok
 * @property double $tunjanganjabatan
 * @property double $premiasuransi
 * @property integer $pemotong_id
 * @property double $pengurangan
 * @property integer $mengetahuipt_id
 * @property string $mengetahuipt
 * @property string $tgl_mengetahuipt
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property PengeluaranumumT $pengeluaranumum
 * @property PegawaiM $mengetahuipt0
 */
class PesangonpegT extends CActiveRecord
{
    public $nomorindukpegawai, $nama_pegawai, $kelompokpegawai_id, $jabatan_id, $status;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesangonpegT the static model class
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
		return 'pesangonpeg_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, tglpesangon, nopesangon, totalterima, totalpajak, totalpotongan, penerimaanbersih, mengetahui, menyetujui, mengetahuipt', 'required'),
			array('pengeluaranumum_id, pegawai_id, persentasepph21, harikerja, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, mengetahui_id, menyetujui_id, pemotong_id, mengetahuipt_id', 'numerical', 'integerOnly'=>true),
			array('totalterima, totalpajak, totalpotongan, penerimaanbersih, gajipertahun, biayajabatan, potonganpensiun, ptkppertahun, penerimaanbersihpertahun, pkp, pph21pertahun, pph21perbulan, potongan_lainlain, jaminanpensiun, bpjskesehatan, gajipokok, tunjanganjabatan, premiasuransi, pengurangan', 'numerical'),
			array('nopesangon', 'length', 'max'=>50),
			array('mengetahui, menyetujui', 'length', 'max'=>100),
			array('kodeptkp', 'length', 'max'=>5),
			array('keterangan, periodegaji, create_time, update_time, tgl_mengetahui, tgl_menyetujui, mengetahuipt, tgl_mengetahuipt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesangonpeg_id, pengeluaranumum_id, pegawai_id, tglpesangon, nopesangon, keterangan, mengetahui, menyetujui, totalterima, totalpajak, totalpotongan, penerimaanbersih, periodegaji, gajipertahun, biayajabatan, potonganpensiun, kodeptkp, ptkppertahun, penerimaanbersihpertahun, pkp, persentasepph21, pph21pertahun, pph21perbulan, potongan_lainlain, harikerja, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_mengetahui, tgl_menyetujui, mengetahui_id, menyetujui_id, jaminanpensiun, bpjskesehatan, gajipokok, tunjanganjabatan, premiasuransi, pemotong_id, pengurangan, mengetahuipt_id, mengetahuipt, tgl_mengetahuipt, kode_objekpajakpes', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pengeluaranumum' => array(self::BELONGS_TO, 'PengeluaranumumT', 'pengeluaranumum_id'),
			'mengetahuipt0' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahuipt_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesangonpeg_id' => 'Pesangonpeg',
			'pengeluaranumum_id' => 'Pengeluaranumum',
			'pegawai_id' => 'Pegawai',
			'tglpesangon' => 'Tanggal Pesangon',
			'nopesangon' => 'No Pesangon',
			'keterangan' => 'Keterangan',
			'mengetahui' => 'Mengetahui',
			'menyetujui' => 'Menyetujui',
			'totalterima' => 'Totalterima',
			'totalpajak' => 'Total Pajak',
			'totalpotongan' => 'Total Potongan',
			'penerimaanbersih' => 'Penerimaan Bersih',
			'periodegaji' => 'Periodegaji',
			'gajipertahun' => 'Gajipertahun',
			'biayajabatan' => 'Biayajabatan',
			'potonganpensiun' => 'Potonganpensiun',
			'kodeptkp' => 'Kodeptkp',
			'ptkppertahun' => 'Ptkppertahun',
			'penerimaanbersihpertahun' => 'Penerimaanbersihpertahun',
			'pkp' => 'Pkp',
			'persentasepph21' => 'Persentasepph21',
			'pph21pertahun' => 'Pph21pertahun',
			'pph21perbulan' => 'Pph21perbulan',
			'potongan_lainlain' => 'Potongan Lain Lain',
			'harikerja' => 'Harikerja',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tgl_mengetahui' => 'Tgl. Mengetahui',
			'tgl_menyetujui' => 'Tgl. Menyetujui',
			'mengetahui_id' => 'Mengetahui',
			'menyetujui_id' => 'Menyetujui',
			'jaminanpensiun' => 'Jaminanpensiun',
			'bpjskesehatan' => 'Bpjskesehatan',
			'gajipokok' => 'Gajipokok',
			'tunjanganjabatan' => 'Tunjanganjabatan',
			'premiasuransi' => 'Premiasuransi',
			'pemotong_id' => 'Pemotong',
			'pengurangan' => 'Pengurangan',
			'mengetahuipt_id' => 'Mengetahuipt',
			'mengetahuipt' => 'Mengetahuipt',
			'tgl_mengetahuipt' => 'Tgl. Mengetahuipt',
            'jabatan_id'=>'Jabatan',
			'nomorindukpegawai' => 'Nomor Induk Pegawai',
			'kode_objekpajakpes' => 'Kode Objek Pajak',
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

		if(!empty($this->pesangonpeg_id)){
			$criteria->addCondition('pesangonpeg_id = '.$this->pesangonpeg_id);
		}
		if(!empty($this->pengeluaranumum_id)){
			$criteria->addCondition('pengeluaranumum_id = '.$this->pengeluaranumum_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(tglpesangon)',strtolower($this->tglpesangon),true);
		$criteria->compare('LOWER(nopesangon)',strtolower($this->nopesangon),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(mengetahui)',strtolower($this->mengetahui),true);
		$criteria->compare('LOWER(menyetujui)',strtolower($this->menyetujui),true);
		$criteria->compare('totalterima',$this->totalterima);
		$criteria->compare('totalpajak',$this->totalpajak);
		$criteria->compare('totalpotongan',$this->totalpotongan);
		$criteria->compare('penerimaanbersih',$this->penerimaanbersih);
//		$criteria->compare('LOWER(periodegaji)',strtolower($this->periodegaji),true);
		$criteria->compare('gajipertahun',$this->gajipertahun);
		$criteria->compare('biayajabatan',$this->biayajabatan);
		$criteria->compare('potonganpensiun',$this->potonganpensiun);
		$criteria->compare('LOWER(kodeptkp)',strtolower($this->kodeptkp),true);
		$criteria->compare('ptkppertahun',$this->ptkppertahun);
		$criteria->compare('penerimaanbersihpertahun',$this->penerimaanbersihpertahun);
		$criteria->compare('pkp',$this->pkp);
		if(!empty($this->persentasepph21)){
			$criteria->addCondition('persentasepph21 = '.$this->persentasepph21);
		}
		$criteria->compare('pph21pertahun',$this->pph21pertahun);
		$criteria->compare('pph21perbulan',$this->pph21perbulan);
		$criteria->compare('potongan_lainlain',$this->potongan_lainlain);
		if(!empty($this->harikerja)){
			$criteria->addCondition('harikerja = '.$this->harikerja);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		$criteria->compare('LOWER(tgl_mengetahui)',strtolower($this->tgl_mengetahui),true);
		$criteria->compare('LOWER(tgl_menyetujui)',strtolower($this->tgl_menyetujui),true);
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		if(!empty($this->menyetujui_id)){
			$criteria->addCondition('menyetujui_id = '.$this->menyetujui_id);
		}
		$criteria->compare('jaminanpensiun',$this->jaminanpensiun);
		$criteria->compare('bpjskesehatan',$this->bpjskesehatan);
		$criteria->compare('gajipokok',$this->gajipokok);
		$criteria->compare('tunjanganjabatan',$this->tunjanganjabatan);
		$criteria->compare('premiasuransi',$this->premiasuransi);
		if(!empty($this->pemotong_id)){
			$criteria->addCondition('pemotong_id = '.$this->pemotong_id);
		}
		$criteria->compare('pengurangan',$this->pengurangan);
		if(!empty($this->mengetahuipt_id)){
			$criteria->addCondition('mengetahuipt_id = '.$this->mengetahuipt_id);
		}
		$criteria->compare('LOWER(mengetahuipt)',strtolower($this->mengetahuipt),true);
		$criteria->compare('LOWER(tgl_mengetahuipt)',strtolower($this->tgl_mengetahuipt),true);
		$criteria->compare('LOWER(kode_objekpajakpes)',strtolower($this->tglpesangon),true);

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