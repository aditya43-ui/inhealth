<?php

/**
 * This is the model class for table "pengajuangantikm_t".
 *
 * The followings are the available columns in table 'pengajuangantikm_t':
 * @property integer $pengajuangantikm_id
 * @property string $tglpengajuan_km
 * @property string $no_pengajuan
 * @property integer $supervisior_id
 * @property integer $mengetahui_id
 * @property string $tglprint_pengajuan
 * @property integer $jmlprint_pengajuan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PengajuangantikmT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuangantikmT the static model class
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
		return 'pengajuangantikm_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpengajuan_km, no_pengajuan, tglprint_pengajuan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('supervisior_id, mengetahui_id, jmlprint_pengajuan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('no_pengajuan', 'length', 'max'=>50),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuangantikm_id, tglpengajuan_km, no_pengajuan, supervisior_id, mengetahui_id, tglprint_pengajuan, jmlprint_pengajuan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pengajuangantikm_id' => 'Pengajuan Ganti Kacamata',
			'tglpengajuan_km' => 'Tgl. Pengajuan Kacamata',
			'no_pengajuan' => 'No Memo',
			'supervisior_id' => 'Supervisor',
			'mengetahui_id' => 'Mengetahui',
			'tglprint_pengajuan' => 'Tgl. Print Pengajuan',
			'jmlprint_pengajuan' => 'Jumlah Print Pengajuan',
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

		if(!empty($this->pengajuangantikm_id)){
			$criteria->addCondition('pengajuangantikm_id = '.$this->pengajuangantikm_id);
		}
		$criteria->compare('LOWER(tglpengajuan_km)',strtolower($this->tglpengajuan_km),true);
		$criteria->compare('LOWER(no_pengajuan)',strtolower($this->no_pengajuan),true);
		if(!empty($this->supervisior_id)){
			$criteria->addCondition('supervisior_id = '.$this->supervisior_id);
		}
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		$criteria->compare('LOWER(tglprint_pengajuan)',strtolower($this->tglprint_pengajuan),true);
		if(!empty($this->jmlprint_pengajuan)){
			$criteria->addCondition('jmlprint_pengajuan = '.$this->jmlprint_pengajuan);
		}
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