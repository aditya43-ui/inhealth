<?php

/**
 * This is the model class for table "korektifmainten_t".
 *
 * The followings are the available columns in table 'korektifmainten_t':
 * @property integer $korektifmainten_id
 * @property integer $invperalatan_id
 * @property string $korektifmainten_jenis
 * @property string $korektifmainten_no
 * @property string $korektifmainten_tgl
 * @property integer $pegpemohon_id
 * @property integer $ruanganpemohon_id
 * @property string $korektifmainten_status
 * @property string $korekfitmainten_progress
 * @property string $korektifmainten_finish
 * @property string $korektifmainten_ket
 * @property boolean $iskorektifinternal
 * @property integer $pegteknisiint_id
 * @property integer $teknisiperalatan_id
 * @property string $invperalatan_keadaan
 * @property integer $penghapussaninv_id
 * @property string $korektifmainten_tingkat
 *
 * The followings are the available model relations:
 * @property InvperalatanT $invperalatan
 */
class KorektifmaintenT extends CActiveRecord
{   
    public $invperalatan_namabrg,$invperalatan_kode, $lokasi_id;
    public $lokasiaset_namalokasi, $ada_pj_aset;
    public $ruangan_nama, $area_nama, $gedung_nama, $ruangan_lokasi, $lokasiaset_kode, $kode_internal;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KorektifmaintenT the static model class
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
		return 'korektifmainten_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invperalatan_id, korektifmainten_no, korektifmainten_tgl, pegpemohon_id, ruanganpemohon_id, korektifmainten_status, invperalatan_keadaan', 'required'),
			array('invperalatan_id, pegpemohon_id, ruanganpemohon_id, pegteknisiint_id, teknisiperalatan_id, penghapussaninv_id', 'numerical', 'integerOnly'=>true),
			array('korektifmainten_jenis, korektifmainten_status', 'length', 'max'=>20),
			array('korektifmainten_no, invperalatan_keadaan, korektifmainten_tingkat', 'length', 'max'=>50),
			array('korektifmainten_finish', 'length', 'max'=>255),
			array('korektifmainten_catatan, lokasi_id, korektifmainten_pending, korektifmainten_close, pegprogress_id, korekfitmainten_progress, korektifmainten_ket, iskorektifinternal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('korektifmainten_id, invperalatan_id, korektifmainten_jenis, korektifmainten_no, korektifmainten_tgl, pegpemohon_id, ruanganpemohon_id, korektifmainten_status, korekfitmainten_progress, korektifmainten_finish, korektifmainten_ket, iskorektifinternal, pegteknisiint_id, teknisiperalatan_id, invperalatan_keadaan, penghapussaninv_id, korektifmainten_tingkat', 'safe', 'on'=>'search'),
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
                    'invperalatan' => array(self::BELONGS_TO, 'InvperalatanT', 'invperalatan_id'),
                    'lokasi' => array(self::BELONGS_TO, 'LokasiasetM', 'lokasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'korektifmainten_id' => 'Korektifmainten',
			'invperalatan_id' => 'Invperalatan',
			'korektifmainten_jenis' => 'Korektifmainten Jenis',
			'korektifmainten_no' => 'Korektifmainten No',
			'korektifmainten_tgl' => 'Korektifmainten Tgl',
			'pegpemohon_id' => 'Pegpemohon',
			'ruanganpemohon_id' => 'Ruanganpemohon',
			'korektifmainten_status' => 'Korektifmainten Status',
			'korekfitmainten_progress' => 'Korekfitmainten Progress',
			'korektifmainten_finish' => 'Korektifmainten Finish',
			'korektifmainten_ket' => 'Korektifmainten Ket',
			'iskorektifinternal' => 'Iskorektifinternal',
			'pegteknisiint_id' => 'Pegteknisiint',
			'teknisiperalatan_id' => 'Teknisiperalatan',
			'invperalatan_keadaan' => 'Invperalatan Keadaan',
			'penghapussaninv_id' => 'Penghapussaninv',
			'korektifmainten_tingkat' => 'Korektifmainten Tingkat',
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

		if(!empty($this->korektifmainten_id)){
			$criteria->addCondition('korektifmainten_id = '.$this->korektifmainten_id);
		}
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		$criteria->compare('LOWER(korektifmainten_jenis)',strtolower($this->korektifmainten_jenis),true);
		$criteria->compare('LOWER(korektifmainten_no)',strtolower($this->korektifmainten_no),true);
		$criteria->compare('LOWER(korektifmainten_tgl)',strtolower($this->korektifmainten_tgl),true);
		if(!empty($this->pegpemohon_id)){
			$criteria->addCondition('pegpemohon_id = '.$this->pegpemohon_id);
		}
		if(!empty($this->ruanganpemohon_id)){
			$criteria->addCondition('ruanganpemohon_id = '.$this->ruanganpemohon_id);
		}
		$criteria->compare('LOWER(korektifmainten_status)',strtolower($this->korektifmainten_status),true);
		$criteria->compare('LOWER(korekfitmainten_progress)',strtolower($this->korekfitmainten_progress),true);
		$criteria->compare('LOWER(korektifmainten_finish)',strtolower($this->korektifmainten_finish),true);
		$criteria->compare('LOWER(korektifmainten_ket)',strtolower($this->korektifmainten_ket),true);
		$criteria->compare('iskorektifinternal',$this->iskorektifinternal);
		if(!empty($this->pegteknisiint_id)){
			$criteria->addCondition('pegteknisiint_id = '.$this->pegteknisiint_id);
		}
		if(!empty($this->teknisiperalatan_id)){
			$criteria->addCondition('teknisiperalatan_id = '.$this->teknisiperalatan_id);
		}
		$criteria->compare('LOWER(invperalatan_keadaan)',strtolower($this->invperalatan_keadaan),true);
		if(!empty($this->penghapussaninv_id)){
			$criteria->addCondition('penghapussaninv_id = '.$this->penghapussaninv_id);
		}
		$criteria->compare('LOWER(korektifmainten_tingkat)',strtolower($this->korektifmainten_tingkat),true);

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