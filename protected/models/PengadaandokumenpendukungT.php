<?php

/**
 * This is the model class for table "pengadaandokumenpendukung_t".
 *
 * The followings are the available columns in table 'pengadaandokumenpendukung_t':
 * @property integer $dokumenpendukungpengadaan_id
 * @property integer $dokumenpengadaan_id
 * @property integer $rencanaumumpengadaan_id
 * @property integer $persiapanpengadaan_id
 * @property string $dokumenpendukungpengadaan_nama
 * @property string $dokumenpendukungpengadaan_file
 *
 * The followings are the available model relations:
 * @property PersiapanpengadaanT $persiapanpengadaan
 * @property DokumenpengadaanM $dokumenpengadaan
 * @property RencanaumumpengadaanT $rencanaumumpengadaan
 * @package      application.models 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 * 
 */
class PengadaandokumenpendukungT extends CActiveRecord
{        
        public $temp_file;
        public $jenispengadaan_id;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengadaandokumenpendukungT the static model class
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
		return 'pengadaandokumenpendukung_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dokumenpendukungpengadaan_nama', 'required'),
			array('dokumenpengadaan_id, rencanaumumpengadaan_id, persiapanpengadaan_id', 'numerical', 'integerOnly'=>true),
			array('dokumenpendukungpengadaan_nama', 'length', 'max'=>100),
			array('dokumenpendukungpengadaan_file', 'length', 'max'=>255),
                        array('temp_file','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dokumenpendukungpengadaan_id, dokumenpengadaan_id, rencanaumumpengadaan_id, persiapanpengadaan_id, dokumenpendukungpengadaan_nama, dokumenpendukungpengadaan_file', 'safe', 'on'=>'search'),
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
			'persiapanpengadaan' => array(self::BELONGS_TO, 'PersiapanpengadaanT', 'persiapanpengadaan_id'),
			'dokumenpengadaan' => array(self::BELONGS_TO, 'DokumenpengadaanM', 'dokumenpengadaan_id'),
			'rencanaumumpengadaan' => array(self::BELONGS_TO, 'RencanaumumpengadaanT', 'rencanaumumpengadaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dokumenpendukungpengadaan_id' => 'Dokumenpendukungpengadaan',
			'dokumenpengadaan_id' => 'Dokumenpengadaan',
			'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
			'persiapanpengadaan_id' => 'Persiapanpengadaan',
			'dokumenpendukungpengadaan_nama' => 'Dokumenpendukungpengadaan Nama',
			'dokumenpendukungpengadaan_file' => 'Dokumenpendukungpengadaan File',
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

		$criteria->compare('dokumenpendukungpengadaan_id',$this->dokumenpendukungpengadaan_id);
		$criteria->compare('dokumenpengadaan_id',$this->dokumenpengadaan_id);
		$criteria->compare('rencanaumumpengadaan_id',$this->rencanaumumpengadaan_id);
		$criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
		$criteria->compare('dokumenpendukungpengadaan_nama',$this->dokumenpendukungpengadaan_nama,true);
		$criteria->compare('dokumenpendukungpengadaan_file',$this->dokumenpendukungpengadaan_file,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}