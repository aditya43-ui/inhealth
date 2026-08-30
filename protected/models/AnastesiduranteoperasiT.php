<?php

/**
 * This is the model class for table "anastesiduranteoperasi_t".
 *
 * The followings are the available columns in table 'anastesiduranteoperasi_t':
 * @property integer $anastesiduranteoperasi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $rencanaoperasi_id
 * @property integer $pemeriksaanke
 * @property string $observasi_jam
 * @property integer $spo2_nilai
 * @property integer $endtidalco2_nilai
 * @property boolean $isisofluran
 * @property double $isofluran_nilai
 * @property boolean $issevofluran
 * @property double $sevofluran_nilai
 * @property boolean $isdesfluran
 * @property double $desfluran_nilai
 * @property integer $n2o_nilai
 * @property integer $air_nilai
 * @property integer $o2_nilai
 * @property integer $pernapasan_nilai
 * @property double $suhutubuh
 * @property integer $td_sistolik
 * @property integer $td_diastolik
 * @property integer $detaknadi
 * @property string $kesadaranpasien
 * @property double $urine_jumlah
 * @property string $catatan
 * @property string $keterangan_jamobservasi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property RencanaoperasiT $rencanaoperasi
 * @property MedikasiduranteoperasiT[] $medikasiduranteoperasiTs
 * @property CairanimduranteopT[] $cairanimduranteopTs
 */
class AnastesiduranteoperasiT extends CActiveRecord
{
    public $waktu2 = 0;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnastesiduranteoperasiT the static model class
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
		return 'anastesiduranteoperasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, pasienmasukpenunjang_id, pemeriksaanke, observasi_jam, pernapasan_nilai, suhutubuh, td_sistolik, td_diastolik, detaknadi', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, pemeriksaanke, spo2_nilai, endtidalco2_nilai, n2o_nilai, air_nilai, o2_nilai, pernapasan_nilai, td_sistolik, td_diastolik, detaknadi, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('isofluran_nilai, sevofluran_nilai, desfluran_nilai, suhutubuh, urine_jumlah', 'numerical'),
			array('kesadaranpasien', 'length', 'max'=>50),
			array('keterangan_jamobservasi, isisofluran, issevofluran, isdesfluran, catatan, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('anastesiduranteoperasi_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, pemeriksaanke, observasi_jam, spo2_nilai, endtidalco2_nilai, isisofluran, isofluran_nilai, issevofluran, sevofluran_nilai, isdesfluran, desfluran_nilai, n2o_nilai, air_nilai, o2_nilai, pernapasan_nilai, suhutubuh, td_sistolik, td_diastolik, detaknadi, kesadaranpasien, urine_jumlah, catatan, keterangan_jamobservasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'rencanaoperasi' => array(self::BELONGS_TO, 'RencanaoperasiT', 'rencanaoperasi_id'),
			'medikasiduranteoperasiTs' => array(self::HAS_MANY, 'MedikasiduranteoperasiT', 'anastesiduranteoperasi_id'),
			'cairanimduranteopTs' => array(self::HAS_MANY, 'CairanimduranteopT', 'anastesiduranteoperasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'anastesiduranteoperasi_id' => 'Anastesiduranteoperasi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'rencanaoperasi_id' => 'Rencanaoperasi',
			'pemeriksaanke' => 'Pemeriksaan Ke-',
			'observasi_jam' => 'Jam Observasi',
			'spo2_nilai' => 'SpO2',
			'endtidalco2_nilai' => 'End Tidal CO2',
			'isisofluran' => 'Isofluran',
			'isofluran_nilai' => 'Isofluran Nilai',
			'issevofluran' => 'Sevofluran',
			'sevofluran_nilai' => 'Sevofluran Nilai',
			'isdesfluran' => 'Desfluran',
			'desfluran_nilai' => 'Desfluran Nilai',
			'n2o_nilai' => 'N2O',
			'air_nilai' => 'Air',
			'o2_nilai' => 'O2',
			'pernapasan_nilai' => 'Pernapasan',
			'suhutubuh' => 'Suhu',
			'td_sistolik' => 'Td Sistolik',
			'td_diastolik' => 'Td Diastolik',
			'detaknadi' => 'Nadi',
			'kesadaranpasien' => 'Kesadaran',
			'urine_jumlah' => 'Urine',
			'catatan' => 'Catatan',
			'keterangan_jamobservasi' => 'Keterangan Jamobservasi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
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

		if(!empty($this->anastesiduranteoperasi_id)){
			$criteria->addCondition('anastesiduranteoperasi_id = '.$this->anastesiduranteoperasi_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		if(!empty($this->rencanaoperasi_id)){
			$criteria->addCondition('rencanaoperasi_id = '.$this->rencanaoperasi_id);
		}
		if(!empty($this->pemeriksaanke)){
			$criteria->addCondition('pemeriksaanke = '.$this->pemeriksaanke);
		}
		$criteria->compare('LOWER(observasi_jam)',strtolower($this->observasi_jam),true);
		if(!empty($this->spo2_nilai)){
			$criteria->addCondition('spo2_nilai = '.$this->spo2_nilai);
		}
		if(!empty($this->endtidalco2_nilai)){
			$criteria->addCondition('endtidalco2_nilai = '.$this->endtidalco2_nilai);
		}
		$criteria->compare('isisofluran',$this->isisofluran);
		$criteria->compare('isofluran_nilai',$this->isofluran_nilai);
		$criteria->compare('issevofluran',$this->issevofluran);
		$criteria->compare('sevofluran_nilai',$this->sevofluran_nilai);
		$criteria->compare('isdesfluran',$this->isdesfluran);
		$criteria->compare('desfluran_nilai',$this->desfluran_nilai);
		if(!empty($this->n2o_nilai)){
			$criteria->addCondition('n2o_nilai = '.$this->n2o_nilai);
		}
		if(!empty($this->air_nilai)){
			$criteria->addCondition('air_nilai = '.$this->air_nilai);
		}
		if(!empty($this->o2_nilai)){
			$criteria->addCondition('o2_nilai = '.$this->o2_nilai);
		}
		if(!empty($this->pernapasan_nilai)){
			$criteria->addCondition('pernapasan_nilai = '.$this->pernapasan_nilai);
		}
		$criteria->compare('suhutubuh',$this->suhutubuh);
		if(!empty($this->td_sistolik)){
			$criteria->addCondition('td_sistolik = '.$this->td_sistolik);
		}
		if(!empty($this->td_diastolik)){
			$criteria->addCondition('td_diastolik = '.$this->td_diastolik);
		}
		if(!empty($this->detaknadi)){
			$criteria->addCondition('detaknadi = '.$this->detaknadi);
		}
		$criteria->compare('LOWER(kesadaranpasien)',strtolower($this->kesadaranpasien),true);
		$criteria->compare('urine_jumlah',$this->urine_jumlah);
		$criteria->compare('LOWER(catatan)',strtolower($this->catatan),true);
		$criteria->compare('LOWER(keterangan_jamobservasi)',strtolower($this->keterangan_jamobservasi),true);
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
        
        
        public function genPemeriksaan() {
            $data = self::model()->findByAttributes(array(
                'pasienmasukpenunjang_id'=>$this->pasienmasukpenunjang_id,
            ), array(
                'order'=>'pemeriksaanke desc',
            ));
            
            $this->pemeriksaanke = empty($data) ? 1 : ($data->pemeriksaanke + 1);
        }
}