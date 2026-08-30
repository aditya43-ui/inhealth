<?php

/**
 * Model untuk tabel "evaluasianestesi_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * The followings are the available columns in table 'evaluasianestesi_t':
 * @property integer $evaluasianestesi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienkirimkeunitlain_id
 * @property string $tglevaluasianestesi
 * @property boolean $jenisanestesi_anestsesi
 * @property boolean $jenisanestesi_sedasisedangberat
 * @property integer $diagnosa_praanestesi
 * @property integer $ruangan_id
 * @property integer $kamarruangan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property EvaluasianestesiPraT[] $evaluasianestesiPraTs
 */
class EvaluasianestesiT extends CActiveRecord
{       
        public $diagnosa_praanestesi_nama;
        public $pasienanastesi_id, $ruangan_nama;
        public $spesialis_nama, $ppds_nama, $perawat_nama;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EvaluasianestesiT the static model class
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
		return 'evaluasianestesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisanastesi_id, pasien_id, pendaftaran_id', 'required'),
			array('pasien_id, pendaftaran_id, pasienmasukpenunjang_id, pasienkirimkeunitlain_id, diagnosa_praanestesi, ruangan_id, kamarruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pasienanastesi_id, jenisanastesi_id, tglevaluasianestesi, jenisanestesi_anestsesi, jenisanestesi_sedasisedangberat, create_time, create_loginpemakai_id, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('evaluasianestesi_id, pasien_id, pendaftaran_id, pasienmasukpenunjang_id, pasienkirimkeunitlain_id, tglevaluasianestesi, jenisanestesi_anestsesi, jenisanestesi_sedasisedangberat, diagnosa_praanestesi, ruangan_id, ruanganasal_id, kamarruangan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'evaluasianestesiPraTs' => array(self::HAS_MANY, 'EvaluasianestesiPraT', 'evaluasianestesi_id'),
                        'diagnosa'=>array(self::BELONGS_TO,'DiagnosaM', 'diagnosa_praanestesi'),
                        'ruangan'=>array(self::BELONGS_TO,'RuanganM', 'ruangan_id'),
                        'pegawai'=>array(self::BELONGS_TO,'PegawaiM', 'pegawai_pemberiinformasi_id'),
                        'spesialis'=>array(self::BELONGS_TO,'PegawaiM', 'spesialis_id'),
                        'perawat'=>array(self::BELONGS_TO,'PegawaiM', 'perawat_id'),
                        'ppds'=>array(self::BELONGS_TO,'PpdsM', 'ppds_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'evaluasianestesi_id' => 'Evaluasianestesi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'tglevaluasianestesi' => 'Tglevaluasianestesi',
			'jenisanestesi_anestsesi' => 'Jenis Anestesi',
			'jenisanestesi_sedasisedangberat' => 'Jenisanestesi Sedasisedangberat',
			'diagnosa_praanestesi' => 'Diagnosa Praanestesi',
			'ruangan_id' => 'Ruangan',
			'kamarruangan_id' => 'Kamarruangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
                        'jenisanastesi_id' => 'Jenis Anestesi'
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

		$criteria->compare('evaluasianestesi_id',$this->evaluasianestesi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('tglevaluasianestesi',$this->tglevaluasianestesi,true);
		$criteria->compare('jenisanestesi_anestsesi',$this->jenisanestesi_anestsesi);
		$criteria->compare('jenisanestesi_sedasisedangberat',$this->jenisanestesi_sedasisedangberat);
		$criteria->compare('diagnosa_praanestesi',$this->diagnosa_praanestesi);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Load data Instalasi Anestesi
         * @param type $instalasi_id
         * @return type
         */        
        public function getRuanganInstalasiItems($instalasi_id = null)
	{
	    if(!empty($instalasi_id)){
			$criteria = new CDbCriteria;
			$criteria->addCondition('instalasi_id ='.$instalasi_id);
			$criteria->addCondition('ruangan_aktif is TRUE');

			return RuanganM::model()->findAll($criteria);
		}else{
			return array();
		}
	}
        
        /**
         * Load data pegawai untuk ruangan anestesi
         * @param type $ruangan_id
         * @return type
         */
        public function getPegawaiItems($ruangan_id='')
        {
        if(!empty($ruangan_id)):
            return PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=> Params::RUANGAN_ID_ANASTESI), array(
                'order'=>'nama_pegawai',
            ));
        else:
            return array();
        endif;
        }
}