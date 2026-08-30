<?php

/**
 * This is the model class for table "rencanggaranpeng_t".
 *
 * The followings are the available columns in table 'rencanggaranpeng_t':
 * @property integer $rencanggaranpeng_id
 * @property integer $konfiganggaran_id
 * @property integer $unitkerja_id
 * @property string $rencanggaranpeng_no
 * @property string $rencanggaranpeng_tgl
 * @property integer $mengetahui_id
 * @property string $tglmengetahui
 * @property integer $menyetujui_id
 * @property string $tglmenyetujui
 * @property double $total_nilairencpeng
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class RencanggaranpengT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanggaranpengT the static model class
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
		return 'rencanggaranpeng_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('konfiganggaran_id, unitkerja_id, rencanggaranpeng_no, menyetujui_id, mengetahui_id, rencanggaranpeng_tgl, total_nilairencpeng, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('konfiganggaran_id, unitkerja_id, mengetahui_id, menyetujui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('total_nilairencpeng', 'numerical'),
			array('rencanggaranpeng_no', 'length', 'max'=>30),
			array('konfiganggaran_id,tglmengetahui, tglmenyetujui, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanggaranpeng_id, konfiganggaran_id, unitkerja_id, rencanggaranpeng_no, rencanggaranpeng_tgl, mengetahui_id, tglmengetahui, menyetujui_id, tglmenyetujui, total_nilairencpeng, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'konfiganggaran' => array(self::BELONGS_TO, 'KonfiganggaranK', 'konfiganggaran_id'),
			'unitkerja' => array(self::BELONGS_TO, 'UnitkerjaM', 'unitkerja_id'),
			'mengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_id'),
			'menyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'menyetujui_id'),
			'rencanggaranpengdetail' => array(self::BELONGS_TO, 'RencanggaranpengdetailT', 'rencanggaranpengdetail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanggaranpeng_id' => 'Rencanggaranpeng',
			'konfiganggaran_id' => 'Konfiganggaran',
			'unitkerja_id' => 'Unitkerja',
			'rencanggaranpeng_no' => 'Nomor Pengeluaran',
			'rencanggaranpeng_tgl' => 'Tanggal',
			'mengetahui_id' => 'Mengetahui',
			'tglmengetahui' => 'Tglmengetahui',
			'menyetujui_id' => 'Menyetujui',
			'tglmenyetujui' => 'Tglmenyetujui',
			'total_nilairencpeng' => 'Total Nilairencpeng',
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

		if(!empty($this->rencanggaranpeng_id)){
			$criteria->addCondition('rencanggaranpeng_id = '.$this->rencanggaranpeng_id);
		}
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		$criteria->compare('LOWER(rencanggaranpeng_no)',strtolower($this->rencanggaranpeng_no),true);
		$criteria->compare('LOWER(rencanggaranpeng_tgl)',strtolower($this->rencanggaranpeng_tgl),true);
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		$criteria->compare('LOWER(tglmengetahui)',strtolower($this->tglmengetahui),true);
		if(!empty($this->menyetujui_id)){
			$criteria->addCondition('menyetujui_id = '.$this->menyetujui_id);
		}
		$criteria->compare('LOWER(tglmenyetujui)',strtolower($this->tglmenyetujui),true);
		$criteria->compare('total_nilairencpeng',$this->total_nilairencpeng);
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