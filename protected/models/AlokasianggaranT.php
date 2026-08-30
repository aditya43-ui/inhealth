<?php

/**
 * This is the model class for table "alokasianggaran_t".
 *
 * The followings are the available columns in table 'alokasianggaran_t':
 * @property integer $alokasianggaran_id
 * @property integer $sumberanggaran_id
 * @property integer $subkegiatanprogram_id
 * @property integer $realisasianggpenerimaan_id
 * @property integer $unitkerja_id
 * @property integer $apprrencanggaran_id
 * @property integer $konfiganggaran_id
 * @property string $tglalokasianggaran
 * @property string $no_alokasi
 * @property double $nilairencana
 * @property double $nilaiygdialokasikan
 * @property double $sisaanggaran
 * @property integer $mengetahui_id
 * @property string $tglmengetahui
 * @property integer $menyetujui_id
 * @property string $tglmenyetujui
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class AlokasianggaranT extends CActiveRecord
{
	public $sumberanggarannama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AlokasianggaranT the static model class
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
		return 'alokasianggaran_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sumberanggaran_id, subkegiatanprogram_id, realisasianggpenerimaan_id, unitkerja_id, apprrencanggaran_id, konfiganggaran_id, tglalokasianggaran, no_alokasi, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('sumberanggaran_id, subkegiatanprogram_id, realisasianggpenerimaan_id, unitkerja_id, apprrencanggaran_id, konfiganggaran_id, mengetahui_id, menyetujui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nilairencana, nilaiygdialokasikan, sisaanggaran', 'numerical'),
			array('tglalokasianggaran', 'length', 'max'=>50),
			array('no_alokasi', 'length', 'max'=>20),
			array('tglmengetahui, tglmenyetujui, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('alokasianggaran_id, sumberanggaran_id, subkegiatanprogram_id, realisasianggpenerimaan_id, unitkerja_id, apprrencanggaran_id, konfiganggaran_id, tglalokasianggaran, no_alokasi, nilairencana, nilaiygdialokasikan, sisaanggaran, mengetahui_id, tglmengetahui, menyetujui_id, tglmenyetujui, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'sumberanggaran'=>array(self::BELONGS_TO,'SumberanggaranM','sumberanggaran_id'),
			'subkegiatanprogram'=>array(self::BELONGS_TO,'SubkegiatanprogramM','subkegiatanprogram_id'),
			'mengetahui'=>array(self::BELONGS_TO,'PegawaiM','mengetahui_id'),
			'menyetujui'=>array(self::BELONGS_TO,'PegawaiM','menyetujui_id'),
			'konfiganggaran'=>array(self::BELONGS_TO,'KonfiganggaranK','konfiganggaran_id'),
			'unitkerja'=>array(self::BELONGS_TO,'UnitkerjaM','unitkerja_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'alokasianggaran_id' => 'Alokasianggaran',
			'sumberanggaran_id' => 'Sumberanggaran',
			'subkegiatanprogram_id' => 'Subkegiatanprogram',
			'realisasianggpenerimaan_id' => 'Realisasianggpenerimaan',
			'unitkerja_id' => 'Unitkerja',
			'apprrencanggaran_id' => 'Apprrencanggaran',
			'konfiganggaran_id' => 'Konfiganggaran',
			'tglalokasianggaran' => 'Tgl. Alokasi Anggaran',
			'no_alokasi' => 'No. Alokasi',
			'nilairencana' => 'Nilairencana',
			'nilaiygdialokasikan' => 'Nilaiygdialokasikan',
			'sisaanggaran' => 'Sisa Anggaran',
			'mengetahui_id' => 'Mengetahui',
			'tglmengetahui' => 'Tglmengetahui',
			'menyetujui_id' => 'Menyetujui',
			'tglmenyetujui' => 'Tglmenyetujui',
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

		if(!empty($this->alokasianggaran_id)){
			$criteria->addCondition('alokasianggaran_id = '.$this->alokasianggaran_id);
		}
		if(!empty($this->sumberanggaran_id)){
			$criteria->addCondition('sumberanggaran_id = '.$this->sumberanggaran_id);
		}
		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		if(!empty($this->realisasianggpenerimaan_id)){
			$criteria->addCondition('realisasianggpenerimaan_id = '.$this->realisasianggpenerimaan_id);
		}
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		if(!empty($this->apprrencanggaran_id)){
			$criteria->addCondition('apprrencanggaran_id = '.$this->apprrencanggaran_id);
		}
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		$criteria->compare('LOWER(tglalokasianggaran)',strtolower($this->tglalokasianggaran),true);
		$criteria->compare('LOWER(no_alokasi)',strtolower($this->no_alokasi),true);
		$criteria->compare('nilairencana',$this->nilairencana);
		$criteria->compare('nilaiygdialokasikan',$this->nilaiygdialokasikan);
		$criteria->compare('sisaanggaran',$this->sisaanggaran);
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		$criteria->compare('LOWER(tglmengetahui)',strtolower($this->tglmengetahui),true);
		if(!empty($this->menyetujui_id)){
			$criteria->addCondition('menyetujui_id = '.$this->menyetujui_id);
		}
		$criteria->compare('LOWER(tglmenyetujui)',strtolower($this->tglmenyetujui),true);
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