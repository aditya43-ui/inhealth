<?php

/**
 * This is the model class for table "anamesadiet_t".
 *
 * The followings are the available columns in table 'anamesadiet_t':
 * @property integer $anamesadiet_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property integer $ruangan_id
 * @property integer $jeniswaktu_id
 * @property integer $bahanmakanan_id
 * @property integer $pegawai_id
 * @property integer $pendaftaran_id
 * @property integer $pekerjaan_id
 * @property integer $menudiet_id
 * @property string $tglanamesadiet
 * @property string $keterangan
 * @property string $katpekerjaan
 * @property double $beratbahan
 * @property string $urt
 * @property double $energikalori
 * @property double $protein
 * @property double $lemak
 * @property double $hidratarang
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class AnamesadietT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamesadietT the static model class
	 */
    
        public $menudietNama,$bahanmakananNama,$bdd,$energikalori2;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'anamesadiet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, ruangan_id, pendaftaran_id, tglanamesadiet, beratbahan, energikalori, protein, lemak, hidratarang, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasien_id, pasienadmisi_id, ruangan_id, jeniswaktu_id, bahanmakanan_id, pegawai_id, pendaftaran_id, pekerjaan_id, menudiet_id, ahligizi', 'numerical', 'integerOnly'=>true),
			array('beratbahan, energikalori, protein, lemak, hidratarang', 'numerical'),
			array('katpekerjaan, urt', 'length', 'max'=>50),
                    
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			array('keterangan, update_time, update_loginpemakai_id, protein, lemak, beratbahan, hidratarang, energikalori', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('anamesadiet_id, pasien_id, pasienadmisi_id, ruangan_id, menudietNama, bahanmakananNama, bdd,  jeniswaktu_id, bahanmakanan_id, pegawai_id, pendaftaran_id, pekerjaan_id, menudiet_id, tglanamesadiet, keterangan, katpekerjaan, beratbahan, urt, energikalori, protein, lemak, hidratarang, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                        'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
                        'jeniswaktu'=>array(self::BELONGS_TO,'JeniswaktuM','jeniswaktu_id'),
                        'bahanmakanan'=>array(self::BELONGS_TO,'BahanmakananM','bahanmakanan_id'),
                        'menudiet'=>array(self::BELONGS_TO,'MenuDietM','menudiet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'anamesadiet_id' => 'Anamnesa Diet',
			'pasien_id' => 'Id Pasien',
			'pasienadmisi_id' => 'Id Pasien Admisi',
			'ruangan_id' => 'Id Ruangan',
			'jeniswaktu_id' => 'Id Jenis Waktu',
			'bahanmakanan_id' => 'Id Bahan Makanan',
			'pegawai_id' => 'Id Pegawai',
			'pendaftaran_id' => 'Id Pendaftaran',
			'pekerjaan_id' => 'Id Pekerjaan',
			'menudiet_id' => 'Id Menu Diet',
			'tglanamesadiet' => 'Tanggal Anamnesa Diet',
			'keterangan' => 'Keterangan',
			'katpekerjaan' => 'Kategori Pekerjaan',
			'beratbahan' => 'Berat Bahan',
			'urt' => 'Urt',
			'energikalori' => 'Energi Kalori',
			'protein' => 'Protein',
			'lemak' => 'Lemak',
			'hidratarang' => 'Hidrat Arang',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'ahligizi' => 'Ahli Gizi',
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

		$criteria->compare('anamesadiet_id',$this->anamesadiet_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('LOWER(tglanamesadiet)',strtolower($this->tglanamesadiet),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(katpekerjaan)',strtolower($this->katpekerjaan),true);
		$criteria->compare('beratbahan',$this->beratbahan);
		$criteria->compare('LOWER(urt)',strtolower($this->urt),true);
		$criteria->compare('energikalori',$this->energikalori);
		$criteria->compare('protein',$this->protein);
		$criteria->compare('lemak',$this->lemak);
		$criteria->compare('hidratarang',$this->hidratarang);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('ahligizi',$this->ahligizi);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('anamesadiet_id',$this->anamesadiet_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('LOWER(tglanamesadiet)',strtolower($this->tglanamesadiet),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(katpekerjaan)',strtolower($this->katpekerjaan),true);
		$criteria->compare('beratbahan',$this->beratbahan);
		$criteria->compare('LOWER(urt)',strtolower($this->urt),true);
		$criteria->compare('energikalori',$this->energikalori);
		$criteria->compare('protein',$this->protein);
		$criteria->compare('lemak',$this->lemak);
		$criteria->compare('hidratarang',$this->hidratarang);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('ahligizi',$this->ahligizi);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        public function getDokterItems($ruangan_id=null){
            if (Yii::app()->user->getState('dokterruangan')==true){
				if(empty($ruangan_id))
					$ruangan_id = Yii::app()->user->getState('ruangan_id');
                if(!empty($ruangan_id))
                    return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'nama_pegawai'));
                else
                    return array();
            }else{
				//criteria disamakan dengan dokter_v
				$criteria = new CDbCriteria();
				$criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
				$criteria->addCondition("pegawai_aktif = TRUE");
				$criteria->order = 'nama_pegawai';
                return PegawaiM::model()->findAll($criteria);
            }
        }
		
		public function getAhliGiziItems()
        {
            return PegawairuanganV::model()->findAllByAttributes(array('jabatan_id'=>  Params::JABATAN_ID_AHLI_GIZI, 'pegawai_aktif'=>true, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')),array('order'=>'nama_pegawai ASC'));
            //return DokterV::model()->findAll();
        }
}