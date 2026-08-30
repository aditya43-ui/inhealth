<?php

/**
 * @author Tantowy <tantowijaya@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * This is the model class for table "seleksipendonor_t".
 *
 * The followings are the available columns in table 'seleksipendonor_t':
 * @property integer $seleksidonor_id
 * @property integer $pendonor_id
 * @property integer $daftardonasi_id
 * @property string $tglseleksidonor
 * @property integer $petugas_id
 * @property string $jenisdonor
 * @property string $tekanandarah
 * @property integer $td_systolic
 * @property integer $td_diastoliic
 * @property integer $kadar_hb
 * @property double $suhu_tubuh
 * @property integer $detaknadi
 * @property boolean $is_gagalseleksi
 * @property boolean $hb_rendah
 * @property boolean $hb_tinggi
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
 * @property integer $dokter_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SeleksikuesionerT[] $seleksikuesionerTs
 */
class SeleksipendonorT extends CActiveRecord
{
    public $medis_lain,$ruangan_id;
    public $dokter_nama;
    public $petugas_nama;    
    public $petugaskoreksi_nama;
    public $ppds_nama;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SeleksipendonorT the static model class
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
		return 'seleksipendonor_t';
	}
                        
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendonor_id, daftardonasi_id, tglseleksidonor, is_gagalseleksi, hb_rendah, bb_rendah, medis_hb_17, medis_td_rendah, medis_tk_tinggi, medis_bb_lebih, medis_vaksin, perilakuberesiko, riwberpergian, status_pendonor, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendonor_id, daftardonasi_id, petugas_id, td_systolic, td_diastoliic, detaknadi, dokter_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kadar_hb,suhu_tubuh', 'numerical'),
			array('jenisdonor', 'length', 'max'=>255),
			array('tekanandarah', 'length', 'max'=>20),
			array('status_pendonor', 'length', 'max'=>10),
			array('petugaskoreksi_id, gol_darah, rhesus, catatan_dokter,bb_rendah, update_time,ppds_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('medis_lain, usia_kurang, medis_pasca_op,perilakuberesiko_homo, perilakuberesiko_tatto, perilakuberesiko_freesx, perilakuberesiko_penasun, perilakuberesiko_napi,riwbepergian_endemik, riwbepergian_hiv, riwbepergian_sapigila, lain_lain_tdkkembali, lain_lain_donortua, petugaskuesioner_id,seleksidonor_id, pendonor_id, daftardonasi_id, tglseleksidonor, petugas_id, jenisdonor, tekanandarah, td_systolic, td_diastoliic, kadar_hb, suhu_tubuh, detaknadi, is_gagalseleksi, hb_rendah, bb_rendah, medis_hb_17, medis_td_rendah, medis_tk_tinggi, medis_bb_lebih, medis_vaksin, perilakuberesiko, riwberpergian, lain_lain, catatan_dokter, status_pendonor, dokter_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			array('seleksidonor_id, pendonor_id, daftardonasi_id, tglseleksidonor, petugas_id, jenisdonor, tekanandarah, td_systolic, td_diastoliic, kadar_hb, suhu_tubuh, detaknadi, is_gagalseleksi, hb_rendah, bb_rendah, medis_hb_17, medis_td_rendah, medis_tk_tinggi, medis_bb_lebih, medis_vaksin, perilakuberesiko, riwberpergian, lain_lain, catatan_dokter, status_pendonor, dokter_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'seleksikuesionerTs' => array(self::HAS_MANY, 'SeleksikuesionerT', 'seleksidonor_id'),
                    'petugas' => array(self::BELONGS_TO,'PegawaiM','petugas_id'),
                    'dokter' => array(self::BELONGS_TO,'PegawaiM','dokter_id'),
                    'petugaskoreksi' => array(self::BELONGS_TO,'PegawaiM','petugaskoreksi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'seleksidonor_id' => 'Seleksidonor',
			'pendonor_id' => 'Pendonor',
			'daftardonasi_id' => 'Daftardonasi',
			'tglseleksidonor' => 'Tglseleksidonor',
			'petugas_id' => 'Petugas',
			'jenisdonor' => 'Jenis Donor Darah',
			'tekanandarah' => 'Tekanan Darah',
			'td_systolic' => 'Td Systolic',
			'td_diastoliic' => 'Td Diastoliic',
			'kadar_hb' => 'Kadar Hemoglobin',
			'suhu_tubuh' => 'Suhu Tubuh',
			'detaknadi' => 'Detak Nadi',
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
			'dokter_id' => 'Dokter',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		if(!empty($this->seleksidonor_id)){
			$criteria->addCondition('seleksidonor_id = '.$this->seleksidonor_id);
		}
		if(!empty($this->pendonor_id)){
			$criteria->addCondition('pendonor_id = '.$this->pendonor_id);
		}
		if(!empty($this->daftardonasi_id)){
			$criteria->addCondition('daftardonasi_id = '.$this->daftardonasi_id);
		}
		$criteria->compare('LOWER(tglseleksidonor)',strtolower($this->tglseleksidonor),true);
		if(!empty($this->petugas_id)){
			$criteria->addCondition('petugas_id = '.$this->petugas_id);
		}
		$criteria->compare('LOWER(jenisdonor)',strtolower($this->jenisdonor),true);
		$criteria->compare('LOWER(tekanandarah)',strtolower($this->tekanandarah),true);
		if(!empty($this->td_systolic)){
			$criteria->addCondition('td_systolic = '.$this->td_systolic);
		}
		if(!empty($this->td_diastoliic)){
			$criteria->addCondition('td_diastoliic = '.$this->td_diastoliic);
		}
		if(!empty($this->kadar_hb)){
			$criteria->addCondition('kadar_hb = '.$this->kadar_hb);
		}
		$criteria->compare('suhu_tubuh',$this->suhu_tubuh);
		if(!empty($this->detaknadi)){
			$criteria->addCondition('detaknadi = '.$this->detaknadi);
		}
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
		$criteria->compare('LOWER(catatan_dokter)',strtolower($this->catatan_dokter),true);
		$criteria->compare('LOWER(status_pendonor)',strtolower($this->status_pendonor),true);
		if(!empty($this->dokter_id)){
			$criteria->addCondition('dokter_id = '.$this->dokter_id);
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