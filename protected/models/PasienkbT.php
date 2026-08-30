<?php

/**
 * This is the model class for table "pasienkb_t".
 *
 * The followings are the available columns in table 'pasienkb_t':
 * @property integer $pasienkb_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $tglpelayanankb
 * @property string $metodekb
 * @property string $jeniskb
 * @property string $lama_waktu
 * @property string $efeksamping
 * @property string $catatan_kb
 * @property string $tindakanpelayanan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PasienkbT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienkbT the static model class
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
		return 'pasienkb_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pasien_id, tglpelayanankb,', 'required'),
			array('pegawai_id, ruangan_id, pasien_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('metodekb, tindakanpelayanan', 'length', 'max'=>100),
			array('jeniskb', 'length', 'max'=>500),
			array('lama_waktu', 'length', 'max'=>20),
			array('efeksamping, catatan_kb, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('pasienkb_id, pegawai_id, ruangan_id, pasien_id, pendaftaran_id, tglpelayanankb, metodekb, jeniskb, lama_waktu, efeksamping, catatan_kb, tindakanpelayanan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienkb_id' => 'Pasienkb',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'tglpelayanankb' => 'Tanggal Pelayanan',
			'metodekb' => 'Metode KB',
			'jeniskb' => 'Jenis KB',
			'lama_waktu' => 'Lama Waktu',
			'efeksamping' => 'Efek Samping',
			'catatan_kb' => 'Catatan',
			'tindakanpelayanan' => 'Tindakanpelayanan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('pasienkb_id',$this->pasienkb_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglpelayanankb)',strtolower($this->tglpelayanankb),true);
		$criteria->compare('LOWER(metodekb)',strtolower($this->metodekb),true);
		$criteria->compare('LOWER(jeniskb)',strtolower($this->jeniskb),true);
		$criteria->compare('LOWER(lama_waktu)',strtolower($this->lama_waktu),true);
		$criteria->compare('LOWER(efeksamping)',strtolower($this->efeksamping),true);
		$criteria->compare('LOWER(catatan_kb)',strtolower($this->catatan_kb),true);
		$criteria->compare('LOWER(tindakanpelayanan)',strtolower($this->tindakanpelayanan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasienkb_id',$this->pasienkb_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglpelayanankb)',strtolower($this->tglpelayanankb),true);
		$criteria->compare('LOWER(metodekb)',strtolower($this->metodekb),true);
		$criteria->compare('LOWER(jeniskb)',strtolower($this->jeniskb),true);
		$criteria->compare('LOWER(lama_waktu)',strtolower($this->lama_waktu),true);
		$criteria->compare('LOWER(efeksamping)',strtolower($this->efeksamping),true);
		$criteria->compare('LOWER(catatan_kb)',strtolower($this->catatan_kb),true);
		$criteria->compare('LOWER(tindakanpelayanan)',strtolower($this->tindakanpelayanan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
         public function beforeSave() {         
            if($this->tglpelayanankb===null || trim($this->tglpelayanankb)==''){
	        $this->setAttribute('tglpelayanankb', null);
            }
            return parent::beforeSave();
        }

        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
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
        
          public function getTglPelayananNoPendaftaran() {                         
            return $this->tglpelayanankb.PHP_EOL.'<br/>'.$this->pendaftaran->no_pendaftaran;
        }
        
        
}