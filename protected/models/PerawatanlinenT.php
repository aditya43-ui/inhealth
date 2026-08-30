<?php

/**
 * This is the model class for table "perawatanlinen_t".
 *
 * The followings are the available columns in table 'perawatanlinen_t':
 * @property integer $perawatanlinen_id
 * @property string $noperawatan
 * @property string $tglperawatanlinen
 * @property string $keterangan_perawatan
 * @property integer $pegperawatan_id
 * @property integer $pegmengetahui
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $udpate_loginpemakai_id
 * @property integer $create_ruangan
 */
class PerawatanlinenT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerawatanlinenT the static model class
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
		return 'perawatanlinen_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('noperawatan, tglperawatanlinen, pegperawatan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegperawatan_id, pegmengetahui, create_loginpemakai_id, udpate_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('noperawatan', 'length', 'max'=>20),
			array('keterangan_perawatan, update_time, iskirimkeluar, tglkirimkeluar, alasankirimkeluar, ketkirimkeluar, tgl_kembali', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perawatanlinen_id, noperawatan, tglperawatanlinen, keterangan_perawatan, pegperawatan_id, pegmengetahui, create_time, update_time, create_loginpemakai_id, udpate_loginpemakai_id, create_ruangan, iskirimkeluar, tglkirimkeluar, alasankirimkeluar, ketkirimkeluar, tgl_kembali', 'safe', 'on'=>'search'),
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
			'pegperawatan'=>array(self::BELONGS_TO,'PegawaiM','pegperawatan_id'),
			'pegmengetahui'=>array(self::BELONGS_TO,'PegawaiM','pegmengetahui'),
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'perawatanlinen_id' => 'Perawatan Linen',
			'noperawatan' => 'No. Perawatan',
			'tglperawatanlinen' => 'Tanggal Perawatan',
			'keterangan_perawatan' => 'Keterangan Perawatan',
			'pegperawatan_id' => 'Pegawai Perawatan',
			'pegmengetahui' => 'Pegawai Mengetahui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'udpate_loginpemakai_id' => 'Udpate Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'iskirimkeluar' => 'Melakukan perawatan diluar rumah sakit',
                    'tglkirimkeluar' => 'Tanggal Kirim Keluar',
                    'alasankirimkeluar' => 'Alasan Kirim Keluar',
                    'ketkirimkeluar' => 'Keterangan Kirim Keluar',
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

		if(!empty($this->perawatanlinen_id)){
			$criteria->addCondition('perawatanlinen_id = '.$this->perawatanlinen_id);
		}
		$criteria->compare('LOWER(noperawatan)',strtolower($this->noperawatan),true);
		$criteria->compare('LOWER(tglperawatanlinen)',strtolower($this->tglperawatanlinen),true);
		$criteria->compare('LOWER(keterangan_perawatan)',strtolower($this->keterangan_perawatan),true);
		if(!empty($this->pegperawatan_id)){
			$criteria->addCondition('pegperawatan_id = '.$this->pegperawatan_id);
		}
		if(!empty($this->pegmengetahui)){
			$criteria->addCondition('pegmengetahui = '.$this->pegmengetahui);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->udpate_loginpemakai_id)){
			$criteria->addCondition('udpate_loginpemakai_id = '.$this->udpate_loginpemakai_id);
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