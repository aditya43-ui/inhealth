<?php

/**
 * This is the model class for table "simulasianggaran_t".
 *
 * The followings are the available columns in table 'simulasianggaran_t':
 * @property integer $simulasianggaran_id
 * @property integer $konfiganggaran_id
 * @property integer $unitkerja_id
 * @property integer $subkegiatanprogram_id
 * @property string $nosimulasianggaran
 * @property string $tglsimulasianggaran
 * @property double $nilai_anggaran
 * @property string $kenaikan_persen
 * @property double $kenaikan_rupiah
 * @property double $total_nilaianggaran
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class SimulasianggaranT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SimulasianggaranT the static model class
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
		return 'simulasianggaran_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('konfiganggaran_id, unitkerja_id, subkegiatanprogram_id, nosimulasianggaran, tglsimulasianggaran, nilai_anggaran, kenaikan_persen, kenaikan_rupiah, total_nilaianggaran, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('konfiganggaran_id, unitkerja_id, subkegiatanprogram_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nilai_anggaran, kenaikan_rupiah, total_nilaianggaran', 'numerical'),
			array('nosimulasianggaran', 'length', 'max'=>50),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('simulasianggaran_id, konfiganggaran_id, unitkerja_id, subkegiatanprogram_id, nosimulasianggaran, tglsimulasianggaran, nilai_anggaran, kenaikan_persen, kenaikan_rupiah, total_nilaianggaran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'subkegiatanprogram' => array(self::BELONGS_TO, 'SubkegiatanprogramM', 'subkegiatanprogram_id'),
			'konfiganggaran' => array(self::BELONGS_TO, 'KonfiganggaranK', 'konfiganggaran_id'),
			'unitkerja' => array(self::BELONGS_TO, 'UnitkerjaM', 'unitkerja_id'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'simulasianggaran_id' => 'Simulasianggaran',
			'konfiganggaran_id' => 'Konfiganggaran',
			'unitkerja_id' => 'Unitkerja',
			'subkegiatanprogram_id' => 'Subkegiatanprogram',
			'nosimulasianggaran' => 'Nosimulasianggaran',
			'tglsimulasianggaran' => 'Tglsimulasianggaran',
			'nilai_anggaran' => 'Nilai Anggaran',
			'kenaikan_persen' => 'Kenaikan Persen',
			'kenaikan_rupiah' => 'Kenaikan Rupiah',
			'total_nilaianggaran' => 'Total Nilaianggaran',
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

		if(!empty($this->simulasianggaran_id)){
			$criteria->addCondition('simulasianggaran_id = '.$this->simulasianggaran_id);
		}
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		$criteria->compare('LOWER(nosimulasianggaran)',strtolower($this->nosimulasianggaran),true);
		$criteria->compare('LOWER(tglsimulasianggaran)',strtolower($this->tglsimulasianggaran),true);
		$criteria->compare('nilai_anggaran',$this->nilai_anggaran);
		$criteria->compare('LOWER(kenaikan_persen)',strtolower($this->kenaikan_persen),true);
		$criteria->compare('kenaikan_rupiah',$this->kenaikan_rupiah);
		$criteria->compare('total_nilaianggaran',$this->total_nilaianggaran);
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