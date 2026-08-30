<?php

/**
 * This is the model class for table "hukdisiplin_r".
 *
 * The followings are the available columns in table 'hukdisiplin_r':
 * @property integer $hukdisiplin_id
 * @property integer $jnshukdisiplin_id
 * @property integer $pegawai_id
 * @property string $hukdisiplin_jabatan
 * @property string $hukdisiplin_tglhukuman
 * @property string $hukdisiplin_nosk
 * @property string $hukdisiplin_ruangan
 * @property string $hukdisiplin_unitkerja
 * @property string $hukdisiplin_tmt
 * @property string $hukdisiplin_pejygberwenang
 * @property integer $hukdisiplin_lama
 * @property string $hukdisiplin_keterangan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $hukdisiplin_satuanlama
 *
 * The followings are the available model relations:
 * @property JnshukdisiplinM $jnshukdisiplin
 * @property PegawaiM $pegawai
 * @property LoginpemakaiK $createLoginpemakai
 * @property LoginpemakaiK $updateLoginpemakai
 * @property RuanganM $createRuangan
 */
class HukdisiplinR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HukdisiplinR the static model class
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
		return 'hukdisiplin_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jnshukdisiplin_id, pegawai_id, hukdisiplin_jabatan, hukdisiplin_tglhukuman, hukdisiplin_nosk, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('jnshukdisiplin_id, pegawai_id, hukdisiplin_lama', 'numerical', 'integerOnly'=>true),
			array('hukdisiplin_jabatan', 'length', 'max'=>100),
			array('hukdisiplin_nosk, hukdisiplin_pejygberwenang', 'length', 'max'=>50),
			array('hukdisiplin_ruangan', 'length', 'max'=>30),
			array('hukdisiplin_unitkerja', 'length', 'max'=>35),
			array('hukdisiplin_satuanlama', 'length', 'max'=>10),
			array('hukdisiplin_tmt, hukdisiplin_keterangan, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hukdisiplin_id, jnshukdisiplin_id, pegawai_id, hukdisiplin_jabatan, hukdisiplin_tglhukuman, hukdisiplin_nosk, hukdisiplin_ruangan, hukdisiplin_unitkerja, hukdisiplin_tmt, hukdisiplin_pejygberwenang, hukdisiplin_lama, hukdisiplin_keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, hukdisiplin_satuanlama, hukdisiplin_mengetahui_id, hukdisiplin_mengetahui_tgl, hukdisiplin_menyetujui_id, hukdisiplin_menyetujui_tgl', 'safe', 'on'=>'search'),
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
			'jnshukdisiplin' => array(self::BELONGS_TO, 'JnshukdisiplinM', 'jnshukdisiplin_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
			'createRuangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
			'jabatan'=>array(self::BELONGS_TO,'JabatanM','hukdisiplin_jabatan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hukdisiplin_id' => 'ID',
			'jnshukdisiplin_id' => 'Jenis hukuman',
			'pegawai_id' => 'Pegawai',
			'hukdisiplin_jabatan' => 'Jabatan',
			'hukdisiplin_tglhukuman' => 'Tanggal hukuman',
			'hukdisiplin_nosk' => 'No. SK',
			'hukdisiplin_ruangan' => 'Ruangan pegawai',
			'hukdisiplin_unitkerja' => 'Unit kerja pegawai',
			'hukdisiplin_tmt' => 'Hukuman disiplin TMT',
			'hukdisiplin_pejygberwenang' => 'Pejabat yang berwenang',
			'hukdisiplin_lama' => 'Lama',
			'hukdisiplin_keterangan' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'hukdisiplin_satuanlama' => 'Hukdisiplin Satuanlama',
			'hukdisiplin_mengetahui_id' => 'Pegawai Mengetahui',
			'hukdisiplin_mengetahui_tgl' => 'Tanggal Mengetahui',
			'hukdisiplin_menyetujui_id' => 'Pegawai Menyetujui',
			'hukdisiplin_menyetujui_tgl' => 'Tanggal Menyetujui',
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

		if(!empty($this->hukdisiplin_id)){
			$criteria->addCondition('hukdisiplin_id = '.$this->hukdisiplin_id);
		}
		if(!empty($this->jnshukdisiplin_id)){
			$criteria->addCondition('jnshukdisiplin_id = '.$this->jnshukdisiplin_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->hukdisiplin_jabatan)){
			$criteria->addCondition('hukdisiplin_jabatan = '.$this->hukdisiplin_jabatan);
		}
		$criteria->compare('LOWER(hukdisiplin_tglhukuman)',strtolower($this->hukdisiplin_tglhukuman),true);
		$criteria->compare('LOWER(hukdisiplin_nosk)',strtolower($this->hukdisiplin_nosk),true);
		$criteria->compare('LOWER(hukdisiplin_ruangan)',strtolower($this->hukdisiplin_ruangan),true);
		$criteria->compare('LOWER(hukdisiplin_unitkerja)',strtolower($this->hukdisiplin_unitkerja),true);
		$criteria->compare('LOWER(hukdisiplin_tmt)',strtolower($this->hukdisiplin_tmt),true);
		$criteria->compare('LOWER(hukdisiplin_pejygberwenang)',strtolower($this->hukdisiplin_pejygberwenang),true);
		if(!empty($this->hukdisiplin_lama)){
			$criteria->addCondition('hukdisiplin_lama = '.$this->hukdisiplin_lama);
		}
		$criteria->compare('LOWER(hukdisiplin_keterangan)',strtolower($this->hukdisiplin_keterangan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(hukdisiplin_satuanlama)',strtolower($this->hukdisiplin_satuanlama),true);

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

        public function getJnshukdisiplinItems() {
            return JnshukdisiplinM::model()->findAll('jnshukdisiplin_aktif=TRUE ORDER BY jnshukdisiplin_nama');
        }
        
        public function getRuanganItems() {
            return RuanganM::model()->findAll('ruangan_aktif=TRUE ORDER BY ruangan_nama');
        }
        
        public function getJabatanItems() {
            return JabatanM::model()->findAll('jabatan_aktif=TRUE ORDER BY jabatan_nama');
        }
}