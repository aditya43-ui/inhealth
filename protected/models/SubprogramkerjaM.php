<?php

/**
 * This is the model class for table "subprogramkerja_m".
 *
 * The followings are the available columns in table 'subprogramkerja_m':
 * @property integer $subprogramkerja_id
 * @property integer $programkerja_id
 * @property string $subprogramkerja_kode
 * @property string $subprogramkerja_nama
 * @property string $subprogramkerja_namalain
 * @property string $subprogramkerja_ket
 * @property integer $subprogramkerja_nourut
 * @property boolean $subprogramkerja_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class SubprogramkerjaM extends CActiveRecord
{
        public $programkerja_kode, $programkerja_nama;
        public $default;
        public $periodeanggaran_id, $unitkerja_id;    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubprogramkerjaM the static model class
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
		return 'subprogramkerja_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('programkerja_id, subprogramkerja_kode, subprogramkerja_nama, subprogramkerja_namalain, subprogramkerja_nourut, create_time, create_loginpemakai_id, create_ruangan', 'required'),
                array('programkerja_id, subprogramkerja_nourut, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
                array('subprogramkerja_kode', 'length', 'max' => 5),
                array('subprogramkerja_nama, subprogramkerja_namalain', 'length', 'max' => 500),
                array('subsubkegiatan_id, subprogramkerja_ket, subprogramkerja_aktif, update_time', 'safe'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('subprogramkerja_id, programkerja_id, subprogramkerja_kode, subprogramkerja_nama, subprogramkerja_namalain, subprogramkerja_ket, subprogramkerja_nourut, subprogramkerja_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
                    'programkerja' => array(self::BELONGS_TO, 'ProgramkerjaM', 'programkerja_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subprogramkerja_id' => 'Subprogramkerja',
			'programkerja_id' => 'ID Programkerja',
			'subprogramkerja_kode' => 'Kode',
			'subprogramkerja_nama' => 'Nama Sub Program',
			'subprogramkerja_namalain' => 'Nama Lain',
			'subprogramkerja_ket' => 'Keterangan',
			'subprogramkerja_nourut' => 'Subprogramkerja Nourut',
			'subprogramkerja_aktif' => 'Aktif',
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
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->subprogramkerja_id)) {
            $criteria->addCondition('subprogramkerja_id = ' . $this->subprogramkerja_id);
        }
        if (!empty($this->programkerja_id)) {
            $criteria->addCondition('programkerja_id = ' . $this->programkerja_id);
        }
        $criteria->compare('LOWER(subprogramkerja_kode)', strtolower($this->subprogramkerja_kode), true);
        $criteria->compare('LOWER(subprogramkerja_nama)', strtolower($this->subprogramkerja_nama), true);
        $criteria->compare('LOWER(subprogramkerja_namalain)', strtolower($this->subprogramkerja_namalain), true);
        $criteria->compare('LOWER(subprogramkerja_ket)', strtolower($this->subprogramkerja_ket), true);
        if (!empty($this->subprogramkerja_nourut)) {
            $criteria->addCondition('subprogramkerja_nourut = ' . $this->subprogramkerja_nourut);
        }
        $criteria->compare('subprogramkerja_aktif', $this->subprogramkerja_aktif);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        if (!empty($this->create_loginpemakai_id)) {
            $criteria->addCondition('create_loginpemakai_id = ' . $this->create_loginpemakai_id);
        }
        if (!empty($this->update_loginpemakai_id)) {
            $criteria->addCondition('update_loginpemakai_id = ' . $this->update_loginpemakai_id);
        }
        if (!empty($this->create_ruangan)) {
            $criteria->addCondition('create_ruangan = ' . $this->create_ruangan);
        }

        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
    
    /**
     * Load data dialog DPA
     * @return \CActiveDataProvider
     */
    public function searchDialogDPA(){
        $criteria = $this->criteriaSearch();
        $criteria->select = "t.*, programkerja_m.* "; 
        $criteria->join = 'LEFT JOIN programkerja_m ON t.programkerja_id = programkerja_m.programkerja_id';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * 
     * @return \CActiveDataProvider
     */
    public function searchDialog(){
        $cri = new CDbCriteria();
        $cri->select = " t.*, pk.programkerja_id, pk.programkerja_nama ";
        $cri->join =  " JOIN programkerja_m pk ON pk.programkerja_id = t.programkerja_id "
                    . " ";
        $cri->addCondition(" subprogramkerja_aktif = TRUE ");
        $cri->compare("LOWER(programkerja_nama)", strtolower($this->programkerja_nama), true);
        $cri->compare("LOWER(subprogramkerja_nama)", strtolower($this->subprogramkerja_nama), true);
        $cri->compare("LOWER(subprogramkerja_kode)", strtolower($this->subprogramkerja_kode), true);
        if (!empty($this->default)){
            $cri->addCondition(" subprogramkerja_id IS NULL ");
        }
        if (!empty($this->programkerja_id)){
            $cri->addCondition(" t.programkerja_id = ".$this->programkerja_id);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $cri,            
            'sort' => array(
                'defaultOrder' => 'subprogramkerja_nama ASC'
            )
        ));
    }

    /**
     * Load data dialog DPA
     * @return \CActiveDataProvider
     */
    public function searchDialogDPA2(){
        
        $subprogramkerja_id = array();
        $crit = new CDbCriteria();
        $crit->select = 'subprogramkerja_id';
        if(!empty($this->periodeanggaran_id)){
            $crit->addCondition('t.periodeanggaran_id = '.$this->periodeanggaran_id);
        }
        if(!empty($this->unitkerja_id)){
            $crit->addCondition('t.unitkerja_id = '.$this->unitkerja_id);
        }
        $crit->group = 'subprogramkerja_id';
        $cekDPA = DokumenpelaksanaananggaranT::model()->findAll($crit);
        foreach ($cekDPA as $val){
            $subprogramkerja_id[] = $val->subprogramkerja_id;
        }
        
        $criteria = new CDbCriteria;

        $criteria->addInCondition('subprogramkerja_id ', $subprogramkerja_id);
        $criteria->compare('LOWER(subprogramkerja_kode)', strtolower($this->subprogramkerja_kode), true);
        $criteria->compare('LOWER(subprogramkerja_nama)', strtolower($this->subprogramkerja_nama), true);
        $criteria->compare('LOWER(subprogramkerja_namalain)', strtolower($this->subprogramkerja_namalain), true);
        $criteria->compare('LOWER(subprogramkerja_ket)', strtolower($this->subprogramkerja_ket), true);
        $criteria->compare('subprogramkerja_aktif', $this->subprogramkerja_aktif);
        
        $criteria->select = "t.*, programkerja_m.* "; 
        $criteria->join = 'LEFT JOIN programkerja_m ON t.programkerja_id = programkerja_m.programkerja_id';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data dialog Usulan cadangan
     * @return \CActiveDataProvider
     */
    public function searchDialogUsulanCadangan(){
        
        $programkerja_id = array();
        $crit = new CDbCriteria();
        $crit->select = 'programkerja_id';
        if(!empty($this->periodeanggaran_id)){
            $crit->addCondition('t.periodeanggaran_id = '.$this->periodeanggaran_id);
        }
        if(!empty($this->unitkerja_id)){
            $crit->addCondition('t.unitkerja_id = '.$this->unitkerja_id);
        }
        $crit->group = 'programkerja_id';
        $cekUsulan = UsulancadanganT::model()->findAll($crit);
        foreach ($cekUsulan as $val){
            $programkerja_id[] = $val->programkerja_id;
        }
        
        $criteria = new CDbCriteria;
        $criteria->select = "t.*, programkerja_m.* "; 
        $criteria->join = 'LEFT JOIN programkerja_m ON t.programkerja_id = programkerja_m.programkerja_id';
        
        $criteria->addInCondition('t.programkerja_id ', $programkerja_id);
        $criteria->compare('LOWER(t.subprogramkerja_kode)', strtolower($this->subprogramkerja_kode), true);
        $criteria->compare('LOWER(t.subprogramkerja_nama)', strtolower($this->subprogramkerja_nama), true);
        $criteria->compare('LOWER(t.subprogramkerja_namalain)', strtolower($this->subprogramkerja_namalain), true);
        $criteria->compare('LOWER(t.subprogramkerja_ket)', strtolower($this->subprogramkerja_ket), true);
        $criteria->compare('t.subprogramkerja_aktif', $this->subprogramkerja_aktif);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
}