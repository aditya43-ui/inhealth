<?php

/**
 * This is the model class for table "preventifmainten_m".
 *
 * The followings are the available columns in table 'preventifmainten_m':
 * @property integer $preventifmainten_id
 * @property integer $invperalatan_id
 * @property string $frekuensi_inspeksi
 * @property integer $frekuensi_jml
 * @property string $frekuensi_satuan
 * @property integer $ipmchecklist_id
 * @property boolean $ipmchecklist_list
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property IpmchecklistM $ipmchecklist
 * @property InvperalatanT $invperalatan
 */
class PreventifmaintenM extends CActiveRecord
{
        public $fungsi, $risiko_klinis, $pemeliharaan, $riwayat_insiden, $nilaiem; 
        public $nilai_fungsi, $nilai_risiko_klinis, $nilai_pemeliharaan, $nilai_riwayat_insiden;
        public $barang_nama;


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PreventifmaintenM the static model class
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
		return 'preventifmainten_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('frekuensi_inspeksi, frekuensi_jml, frekuensi_satuan, ipmchecklist_id, create_time, create_loginpemakai_id, create_ruangan, barang_id', 'required'),
			array('frekuensi_jml, ipmchecklist_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, barang_id', 'numerical', 'integerOnly'=>true),
			array('frekuensi_inspeksi', 'length', 'max'=>20),
			array('frekuensi_satuan', 'length', 'max'=>10),
			array('barang_nama, update_time, ipmchecklist_list', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('barang_nama, preventifmainten_id, frekuensi_inspeksi, frekuensi_jml, frekuensi_satuan, ipmchecklist_id, ipmchecklist_list, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, barang_id', 'safe', 'on'=>'search'),
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
			'ipmchecklist' => array(self::BELONGS_TO, 'IpmchecklistM', 'ipmchecklist_id'),
			'invperalatan' => array(self::BELONGS_TO, 'InvperalatanT', 'invperalatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'preventifmainten_id' => 'Preventifmainten',
			'invperalatan_id' => 'Inventarisasi Peralatan',						
			'frekuensi_inspeksi' => 'Frekuensi Inspeksi',
			'frekuensi_jml' => 'Jumlah Frekuensi',
			'frekuensi_satuan' => 'Satuan Frekuensi',
			'ipmchecklist_id' => 'Checklist',
			'ipmchecklist_list' => 'Daftar Checklist',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'barang_id' => 'Barang',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('t.preventifmainten_id',$this->preventifmainten_id);
		$criteria->compare('t.frekuensi_inspeksi',$this->frekuensi_inspeksi,true);
		$criteria->compare('t.frekuensi_jml',$this->frekuensi_jml);
		$criteria->compare('t.frekuensi_satuan',$this->frekuensi_satuan,true);
		$criteria->compare('t.ipmchecklist_id',$this->ipmchecklist_id);
		$criteria->compare('t.ipmchecklist_list',$this->ipmchecklist_list);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('t.create_ruangan',$this->create_ruangan);
		$criteria->compare('t.barang_id',$this->barang_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    
    public function searchMaster() {
        $prov = $this->search();
        $prov->criteria->join = 'join barang_m b on b.barang_id = t.barang_id';
        $prov->criteria->compare('lower(b.barang_nama)', strtolower($this->barang_nama), true);
        $prov->criteria->group = $prov->criteria->select = 't.barang_id, t.frekuensi_inspeksi, '
            . 't.frekuensi_jml, t.frekuensi_satuan';
    
        return $prov;
        
    }
    
    public function searchPrintMaster() {
        $prov = $this->searchMaster();
        $prov->pagination = false;
        
        return $prov;   
    }

}