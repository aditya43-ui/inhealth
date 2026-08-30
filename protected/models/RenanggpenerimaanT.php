<?php

/**
 * This is the model class for table "renanggpenerimaan_t".
 *
 * The followings are the available columns in table 'renanggpenerimaan_t':
 * @property integer $renanggpenerimaan_id
 * @property integer $konfiganggaran_id
 * @property integer $sumberanggaran_id
 * @property integer $approverenanggpen_id
 * @property integer $ruangan_id
 * @property string $tglrenanggaranpen
 * @property string $noren_penerimaan
 * @property double $total_renanggaranpen
 * @property integer $renpen_mengetahui_id
 * @property string $renpen_tglmengetahui
 * @property integer $renpen_menyetujui_id
 * @property string $renpen_tglmenyetujui
 * @property double $nilaipenerimaananggaran
 * @property integer $berapaxpenerimaan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class RenanggpenerimaanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RenanggpenerimaanT the static model class
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
		return 'renanggpenerimaan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('konfiganggaran_id, sumberanggaran_id, ruangan_id, tglrenanggaranpen, noren_penerimaan, create_time, create_loginpemakai_id, create_ruangan, renpen_mengetahui_id, renpen_menyetujui_id', 'required'),
			array('konfiganggaran_id, sumberanggaran_id, approverenanggpen_id, ruangan_id, renpen_mengetahui_id, renpen_menyetujui_id, berapaxpenerimaan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('total_renanggaranpen, nilaipenerimaananggaran', 'numerical'),
			array('noren_penerimaan', 'length', 'max'=>50),
			array('renpen_tglmengetahui, renpen_tglmenyetujui, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('renanggpenerimaan_id, konfiganggaran_id, sumberanggaran_id, approverenanggpen_id, ruangan_id, tglrenanggaranpen, noren_penerimaan, total_renanggaranpen, renpen_mengetahui_id, renpen_tglmengetahui, renpen_menyetujui_id, renpen_tglmenyetujui, nilaipenerimaananggaran, berapaxpenerimaan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'sumberanggaran' => array(self::BELONGS_TO, 'SumberanggaranM', 'sumberanggaran_id'),
			'mengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'renpen_mengetahui_id'),
			'menyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'renpen_menyetujui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'renanggpenerimaan_id' => 'Renanggpenerimaan',
			'konfiganggaran_id' => 'Konfiganggaran',
			'sumberanggaran_id' => 'Sumberanggaran',
			'approverenanggpen_id' => 'Approverenanggpen',
			'ruangan_id' => 'Ruangan',
			'tglrenanggaranpen' => 'Tanggal',
			'noren_penerimaan' => 'Nomor Penerimaan',
			'total_renanggaranpen' => 'Total Renanggaranpen',
			'renpen_mengetahui_id' => 'Pegawai Mengetahui',
			'renpen_tglmengetahui' => 'Renpen Tglmengetahui',
			'renpen_menyetujui_id' => 'Pegawai Menyetujui',
			'renpen_tglmenyetujui' => 'Renpen Tglmenyetujui',
			'nilaipenerimaananggaran' => 'Nilai Penerimaan',
			'berapaxpenerimaan' => 'Jumlah Termin',
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

		if(!empty($this->renanggpenerimaan_id)){
			$criteria->addCondition('renanggpenerimaan_id = '.$this->renanggpenerimaan_id);
		}
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		if(!empty($this->sumberanggaran_id)){
			$criteria->addCondition('sumberanggaran_id = '.$this->sumberanggaran_id);
		}
		if(!empty($this->approverenanggpen_id)){
			$criteria->addCondition('approverenanggpen_id = '.$this->approverenanggpen_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(tglrenanggaranpen)',strtolower($this->tglrenanggaranpen),true);
		$criteria->compare('LOWER(noren_penerimaan)',strtolower($this->noren_penerimaan),true);
		$criteria->compare('total_renanggaranpen',$this->total_renanggaranpen);
		if(!empty($this->renpen_mengetahui_id)){
			$criteria->addCondition('renpen_mengetahui_id = '.$this->renpen_mengetahui_id);
		}
		$criteria->compare('LOWER(renpen_tglmengetahui)',strtolower($this->renpen_tglmengetahui),true);
		if(!empty($this->renpen_menyetujui_id)){
			$criteria->addCondition('renpen_menyetujui_id = '.$this->renpen_menyetujui_id);
		}
		$criteria->compare('LOWER(renpen_tglmenyetujui)',strtolower($this->renpen_tglmenyetujui),true);
		$criteria->compare('nilaipenerimaananggaran',$this->nilaipenerimaananggaran);
		if(!empty($this->berapaxpenerimaan)){
			$criteria->addCondition('berapaxpenerimaan = '.$this->berapaxpenerimaan);
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