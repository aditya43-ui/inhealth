<?php

/**
 * This is the model class for table "ruanganpegawai_m".
 *
 * The followings are the available columns in table 'ruanganpegawai_m':
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 */
class RuanganpegawaiM extends CActiveRecord
{
                public $instalasi_id;
                public $nama_pegawai,$ruangan_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RuanganpegawaiM the static model class
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
		return 'ruanganpegawai_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pegawai_id', 'required'),
                                                array('ruangan_id, pegawai_id', 'cekdata'),
			array('ruangan_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruangan_id, pegawai_id, nama_pegawai, ruangan_nama', 'safe', 'on'=>'search'),
		);
	}
        
                public function cekdata($attribute, $params)
                {
                    $querydata = RuanganpegawaiM::model()->findAllByAttributes(array('ruangan_id'=>$this->ruangan_id,'pegawai_id'=>$this->pegawai_id));
                    if (!$this->hasErrors()){
                        if (count((array)$querydata) > 0)
                        {
                            $this->addError('ruangan_id, pegawai_id',' Nama pegawai '.$this->pegawai->gelardepan.' '.$this->pegawai->nama_pegawai.' untuk poli '.$this->ruangan->ruangan_nama.' telah terdaftar di database');
                            return false;
                        }
                    }
                }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM','ruangan_id'),
                                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','pegawai_id'),
                    //'loginpemakai'=>array(self::BELONGS_TO,'LoginpemakaiK','pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
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
                $criteria->with=array('ruangan','pegawai');
                                $criteria->order = 't.ruangan_id';
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
                $criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(pegawai.pegawai_nama)',strtolower($this->pegawai_nama),true);
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'ruangan_nama'=>array(
                                    'asc'=>'ruangan.ruangan_nama',
                                    'desc'=>'ruangan.ruangan_nama DESC',
                                ),
                                '*',
                            ),
                        ),
		));
	}
        
	public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                                $sessionruangan = Yii::app()->user->ruangan_id;
	
		$criteria=new CDbCriteria;
                                $criteria->with = array('ruangan','pegawai');
                                $criteria->order = 't.ruangan_id';
        
                if (Yii::app()->controller->module->id =='sistemAdministrator') {
                    $criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
                }else{
                        $criteria->compare('t.ruangan_id',$sessionruangan);
                }  
                $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
//		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'ruangan_nama'=>array(
                                    'asc'=>'ruangan.ruangan_nama',
                                    'desc'=>'ruangan.ruangan_nama DESC',
                                ),
                                'nama_pegawai'=>array(
                                    'asc'=>'pegawai.nama_pegawai ASC',
                                    'desc'=>'pegawai.nama_pegawai DESC',
                                ),
                                '*',
                            ),
                        ),
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

			 $sessionruangan = Yii::app()->user->ruangan_id;
	
		$criteria=new CDbCriteria;
                                $criteria->with = array('ruangan','pegawai');
                                $criteria->order = 't.ruangan_id';
        
                if (Yii::app()->controller->module->id =='sistemAdministrator') {
                    $criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
                }else{
                        $criteria->compare('t.ruangan_id',$sessionruangan);
                }  
                $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
//		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
        
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
        }
        
        public function getRuanganItems()
        {
          return RuanganM::model()->findAll(array('order'=>'ruangan_nama'));
        }
        
        public function getPegawaiItems()
        {
            return PegawaiM::model()->findAll(array('order'=>'nama_pegawai'));
        }
        
        public function getNamaLengkap()
        {
            if ($this->pegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK):
                return $this->pegawai->gelardepan." ".$this->pegawai->nama_pegawai.", ".$this->pegawai->gelarbelakang_nama;
            else:
                return $this->pegawai->nama_pegawai;
            endif;
        } 
        
        
}