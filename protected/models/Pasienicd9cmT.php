<?php

/**
 * This is the model class for table "pasienicd9cm_t".
 *
 * The followings are the available columns in table 'pasienicd9cm_t':
 * @property integer $pasienicd9cm_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property integer $diagnosaicdix_id
 * @property integer $pasienmorbiditas_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 */
class Pasienicd9cmT extends CActiveRecord
{
	public $ruangan_id, $tglmorbiditas, $pegawai_id, $kelompokdiagnosa_id,$ppds_id, $diagnosaicdix_nama, $diagnosaicdix_kode, $diagnosaicdix_namalainnya;
	public $pegawai_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pasienicd9cmT the static model class
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
		return 'pasienicd9cm_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, diagnosaicdix_id, pasienmorbiditas_id, create_time, create_loginpemakai_id, create_ruangan_id', 'required'),
			array('pasienadmisi_id, pendaftaran_id, diagnosaicdix_id,ppds_id, pasienmorbiditas_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('update_time, kelompokdiagnosa_id, pegawai_id, keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienicd9cm_id, pasienadmisi_id, pendaftaran_id, diagnosaicdix_id, pasienmorbiditas_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'diagnosatindakan'=>array(self::BELONGS_TO, 'DiagnosaicdixM', 'diagnosaicdix_id'),
			'kelompokdiagnosa'=>array(self::BELONGS_TO,  'KelompokdiagnosaM', 'kelompokdiagnosa_id'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienicd9cm_id' => 'Pasienicd9cm',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pendaftaran_id' => 'Pendaftaran',
			'diagnosaicdix_id' => 'Diagnosaicdix',
			'pasienmorbiditas_id' => 'Pasienmorbiditas',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan_id' => 'Create Ruangan',
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

		if(!empty($this->pasienicd9cm_id)){
			$criteria->addCondition('pasienicd9cm_id = '.$this->pasienicd9cm_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->diagnosaicdix_id)){
			$criteria->addCondition('diagnosaicdix_id = '.$this->diagnosaicdix_id);
		}
		if(!empty($this->pasienmorbiditas_id)){
			$criteria->addCondition('pasienmorbiditas_id = '.$this->pasienmorbiditas_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan_id)){
			$criteria->addCondition('create_ruangan_id = '.$this->create_ruangan_id);
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

		public function loadPasienIcd9(){
            $mod = get_called_class();
            $load = [];
            if (!empty($this->pendaftaran_id)){
                $cri = new CDbCriteria;
                $cri->select = "t.*, diag.diagnosaicdix_nama, diag.diagnosaicdix_kode, diag.diagnosaicdix_namalainnya";
                $cri->join = " JOIN diagnosaicdix_m diag ON diag.diagnosaicdix_id = t.diagnosaicdix_id ";
                $cri->addCondition(" pendaftaran_id =  ".$this->pendaftaran_id);
                
                $load = $mod::model()->findAll($cri);
                
                foreach($load as $key => $val){
                    $load[$key]['diagnosaicdix_nama'] = $val->diagnosaicdix_nama;
                    $load[$key]['diagnosaicdix_kode'] = $val->diagnosaicdix_kode;
                    $load[$key]['diagnosaicdix_namalainnya'] = $val->diagnosaicdix_namalainnya;
                    $load[$key]['pegawai_nama'] = !empty($val->pegawai->namaLengkap)?$val->pegawai->namaLengkap:'';
                }
            }
            return $load;
        }
}