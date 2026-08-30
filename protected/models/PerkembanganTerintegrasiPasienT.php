<?php

/**
 * This is the model class for table "perkembangan_terintegrasi_pasien_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'perkembangan_terintegrasi_pasien_t':
 * @property integer $perkembangan_terintegrasi_pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tgltransaksi
 * @property string $profesi
 * @property integer $pegawai_id
 * @property string $subyektif
 * @property string $obyektif
 * @property string $asesmen
 * @property string $perencanaan
 * @property string $instruksi
 * @property integer $dpjp_id
 * @property boolean $menyetujui
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 * @property integer $update_ruangan_id
 * @property string $create_time
 * @property string $update_time
 */
class PerkembanganTerintegrasiPasienT extends CActiveRecord
{
        public $nama_pegawai,$nama_dpjp, $kelompok_pegawai, $default, $ppds_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerkembanganTerintegrasiPasienT the static model class
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
		return 'perkembangan_terintegrasi_pasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, create_loginpemakai_id, create_time', 'required'),
			array('ppds_id, pendaftaran_id, pasien_id, pegawai_id, dpjp_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id, update_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('profesi', 'length', 'max'=>30),
			array('ppds_id, tgltransaksi, subyektif, obyektif, asesmen, perencanaan, instruksi, menyetujui, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perkembangan_terintegrasi_pasien_id, pendaftaran_id, pasien_id, tgltransaksi, profesi, pegawai_id, subyektif, obyektif, asesmen, perencanaan, instruksi, dpjp_id, menyetujui, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id, update_ruangan_id, create_time, update_time', 'safe', 'on'=>'search'),
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
                    'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
                    'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                    'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
                    'ppds' => array(self::BELONGS_TO, 'PpdsM', 'ppds_id'),
                    'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'perkembangan_terintegrasi_pasien_id' => 'Perkembangan Terintegrasi Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'tgltransaksi' => 'Tanggal Pemeriksaan',
			'profesi' => 'Profesi',
			'pegawai_id' => 'Pegawai',
			'subyektif' => 'Subyektif',
			'obyektif' => 'Obyektif',
			'asesmen' => 'Asesmen',
			'perencanaan' => 'Perencanaan',
			'instruksi' => 'Instruksi',
			'dpjp_id' => 'Dpjp',
			'menyetujui' => 'Menyetujui',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
			'update_ruangan_id' => 'Update Ruangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		if(!empty($this->perkembangan_terintegrasi_pasien_id)){
			$criteria->addCondition('perkembangan_terintegrasi_pasien_id = '.$this->perkembangan_terintegrasi_pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
//		$criteria->compare('LOWER(tgltransaksi)',strtolower($this->tgltransaksi),true);
		$criteria->compare('LOWER(profesi)',strtolower($this->profesi),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(subyektif)',strtolower($this->subyektif),true);
		$criteria->compare('LOWER(obyektif)',strtolower($this->obyektif),true);
		$criteria->compare('LOWER(asesmen)',strtolower($this->asesmen),true);
		$criteria->compare('LOWER(perencanaan)',strtolower($this->perencanaan),true);
		$criteria->compare('LOWER(instruksi)',strtolower($this->instruksi),true);
		if(!empty($this->dpjp_id)){
			$criteria->addCondition('dpjp_id = '.$this->dpjp_id);
		}
		$criteria->compare('menyetujui',$this->menyetujui);
		if(!empty($this->tgltransaksi)){
			$criteria->addCondition('tgltransaksi = \''.$this->tgltransaksi. '\'');
		}
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan_id)){
			$criteria->addCondition('create_ruangan_id = '.$this->create_ruangan_id);
		}
		if(!empty($this->update_ruangan_id)){
			$criteria->addCondition('update_ruangan_id = '.$this->update_ruangan_id);
		}
                
                if(!empty($this->create_time)){
			$criteria->addCondition('create_time = \''.$this->create_time. '\'');
		}
                if(!empty($this->update_time)){
			$criteria->addCondition('update_time = \''.$this->update_time. '\'');
		}
//		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
//		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);

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
        
        /**
         * Load data cetak
         * @return \CActiveDataProvider
         */
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
              
        public function searchRiwayat(){
            
            $criteria = new CDbCriteria;
            $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
            $criteria->addCondition("profesi != 'KEPERAWATAN'");
            $criteria->order = ('create_time DESC');

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination' => false,
            ));
        }
        
        public function searchRiwayatPerawat(){
            
            $criteria = new CDbCriteria;
            $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
            $criteria->addCondition("profesi = 'KEPERAWATAN'");
            $criteria->order = ('create_time DESC');

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination' => false,
            ));
        }
        
        public function searchRI()
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