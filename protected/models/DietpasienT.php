<?php

/**
 * This is the model class for table "dietpasien_t".
 *
 * The followings are the available columns in table 'dietpasien_t':
 * @property integer $dietpasien_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property integer $tipediet_id
 * @property integer $jenisdiet_id
 * @property string $tgljenisdiet
 * @property double $energikalori
 * @property double $protein
 * @property double $lemak
 * @property double $hidratarang
 * @property double $diet_kandungan
 * @property string $alergidengan
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class DietpasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DietpasienT the static model class
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
		return 'dietpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pendaftaran_id, pasien_id, tgljenisdiet, energikalori, protein, lemak, hidratarang, diet_kandungan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, ruangan_id, pendaftaran_id, pasien_id, pasienadmisi_id, tipediet_id, jenisdiet_id, ahligizi', 'numerical', 'integerOnly'=>true),
			array('energikalori, protein, lemak, hidratarang, diet_kandungan', 'numerical'),
			array('alergidengan', 'length', 'max'=>200),
			array('keterangan, update_time, update_loginpemakai_id', 'safe'),
                    
                        array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dietpasien_id, pegawai_id, ruangan_id, pendaftaran_id, pasien_id, pasienadmisi_id, tipediet_id, jenisdiet_id, tgljenisdiet, energikalori, protein, lemak, hidratarang, diet_kandungan, alergidengan, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'dietpasien_id' => 'Diet Pasien',
			'pegawai_id' => 'Dokter / Konselor',
			'ruangan_id' => 'Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasien Admisi',
			'tipediet_id' => 'Tipe Diet',
			'jenisdiet_id' => 'Jenis Diet',
			'tgljenisdiet' => 'Tanggal Jenis Diet',
			'energikalori' => 'Energi Kalori',
			'protein' => 'Protein',
			'lemak' => 'Lemak',
			'hidratarang' => 'Hidrat Arang',
			'diet_kandungan' => 'Diet Kandungan',
			'alergidengan' => 'Alergi Dengan',
			'keterangan' => 'Keterangan',
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

		$criteria->compare('dietpasien_id',$this->dietpasien_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tipediet_id',$this->tipediet_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(tgljenisdiet)',strtolower($this->tgljenisdiet),true);
		$criteria->compare('energikalori',$this->energikalori);
		$criteria->compare('protein',$this->protein);
		$criteria->compare('lemak',$this->lemak);
		$criteria->compare('hidratarang',$this->hidratarang);
		$criteria->compare('diet_kandungan',$this->diet_kandungan);
		$criteria->compare('LOWER(alergidengan)',strtolower($this->alergidengan),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
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
		$criteria->compare('dietpasien_id',$this->dietpasien_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tipediet_id',$this->tipediet_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(tgljenisdiet)',strtolower($this->tgljenisdiet),true);
		$criteria->compare('energikalori',$this->energikalori);
		$criteria->compare('protein',$this->protein);
		$criteria->compare('lemak',$this->lemak);
		$criteria->compare('hidratarang',$this->hidratarang);
		$criteria->compare('diet_kandungan',$this->diet_kandungan);
		$criteria->compare('LOWER(alergidengan)',strtolower($this->alergidengan),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
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
//            tampilkan semua dokter
//            if (Yii::app()->user->getState('dokterruangan')==true){
//				if(empty($ruangan_id))
//					$ruangan_id = Yii::app()->user->getState('ruangan_id');
//                if(!empty($ruangan_id))
//                    return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'nama_pegawai'));
//                else
//                    return array();
//            }else{
//               DATA YANG DILOAD TERLALU BANYAK (BERAT) >> return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true),array('order'=>'nama_pegawai'));
                //criteria disamakan dengan dokter_v
				$criteria = new CDbCriteria();
				$criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
				$criteria->addCondition("pegawai_aktif = TRUE");
				$criteria->order = 'nama_pegawai';
                return PegawaiM::model()->findAll($criteria);
//            }
        }
        
        public function getAhliGiziItems()
        {
            return PegawairuanganV::model()->findAllByAttributes(array('jabatan_id'=>  Params::JABATAN_ID_AHLI_GIZI, 'pegawai_aktif'=>true, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')),array('order'=>'nama_pegawai ASC'));
            //return DokterV::model()->findAll();
        }
}