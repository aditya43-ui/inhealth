<?php

/**
 * This is the model class for table "apprrencanggaran_t".
 *
 * The followings are the available columns in table 'apprrencanggaran_t':
 * @property integer $apprrencanggaran_id
 * @property integer $subkegiatanprogram_id
 * @property integer $konfiganggaran_id
 * @property integer $rencanggaranpengdet_id
 * @property integer $unitkerja_id
 * @property integer $revisirencanggpeng_id
 * @property string $tglapprrencanggaran
 * @property integer $menyetujui_id
 * @property integer $mengetahui_id
 * @property string $tglrencanggpeng
 * @property double $nilaiygdisetujui
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property double $nilaiygsudahalokasi
 * @property boolean $statusalokasi
 */
class ApprrencanggaranT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ApprrencanggaranT the static model class
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
		return 'apprrencanggaran_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subkegiatanprogram_id, konfiganggaran_id, unitkerja_id, tglapprrencanggaran, menyetujui_id, tglrencanggpeng, nilaiygdisetujui, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('subkegiatanprogram_id, konfiganggaran_id, rencanggaranpengdet_id, unitkerja_id, revisirencanggpeng_id, menyetujui_id, mengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nilaiygdisetujui, nilaiygsudahalokasi', 'numerical'),
			array('update_time, statusalokasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('apprrencanggaran_id, subkegiatanprogram_id, konfiganggaran_id, rencanggaranpengdet_id, unitkerja_id, revisirencanggpeng_id, tglapprrencanggaran, menyetujui_id, mengetahui_id, tglrencanggpeng, nilaiygdisetujui, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, nilaiygsudahalokasi, statusalokasi', 'safe', 'on'=>'search'),
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
			'mengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_id'),
			'menyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'menyetujui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'apprrencanggaran_id' => 'Apprrencanggaran',
			'subkegiatanprogram_id' => 'Subkegiatanprogram',
			'konfiganggaran_id' => 'Konfiganggaran',
			'rencanggaranpengdet_id' => 'Rencanggaranpengdet',
			'unitkerja_id' => 'Unitkerja',
			'revisirencanggpeng_id' => 'Revisirencanggpeng',
			'tglapprrencanggaran' => 'Tglapprrencanggaran',
			'menyetujui_id' => 'Menyetujui',
			'mengetahui_id' => 'Mengetahui',
			'tglrencanggpeng' => 'Tglrencanggpeng',
			'nilaiygdisetujui' => 'Nilaiygdisetujui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'nilaiygsudahalokasi' => 'Nilaiygsudahalokasi',
			'statusalokasi' => 'Statusalokasi',
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

		if(!empty($this->apprrencanggaran_id)){
			$criteria->addCondition('apprrencanggaran_id = '.$this->apprrencanggaran_id);
		}
		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		if(!empty($this->rencanggaranpengdet_id)){
			$criteria->addCondition('rencanggaranpengdet_id = '.$this->rencanggaranpengdet_id);
		}
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		if(!empty($this->revisirencanggpeng_id)){
			$criteria->addCondition('revisirencanggpeng_id = '.$this->revisirencanggpeng_id);
		}
		$criteria->compare('LOWER(tglapprrencanggaran)',strtolower($this->tglapprrencanggaran),true);
		if(!empty($this->menyetujui_id)){
			$criteria->addCondition('menyetujui_id = '.$this->menyetujui_id);
		}
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		$criteria->compare('LOWER(tglrencanggpeng)',strtolower($this->tglrencanggpeng),true);
		$criteria->compare('nilaiygdisetujui',$this->nilaiygdisetujui);
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
		$criteria->compare('nilaiygsudahalokasi',$this->nilaiygsudahalokasi);
		$criteria->compare('statusalokasi',$this->statusalokasi);

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