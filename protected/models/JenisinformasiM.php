<?php

/**
 * This is the model class for table "jenisinformasi_m".
 *
 * The followings are the available columns in table 'jenisinformasi_m':
 * @property integer $jenisinformasi_id
 * @property integer $jenissurat_id
 * @property string $jenisinformasi_nama
 * @property string $jenisinformasi_namalain
 * @property integer $jenisinformasi_urutan
 * @property string $tipeinput_isiinformasi
 * @property boolean $jenisinformasi_aktif
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property JenissuratM $jenissurat
 * @property IsiinformasiM[] $isiinformasiMs
 */
class JenisinformasiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisinformasiM the static model class
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
		return 'jenisinformasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan, jenissurat_id, jenisinformasi_nama', 'required'),
			array('jenissurat_id, jenisinformasi_urutan', 'numerical', 'integerOnly'=>true),
			array('jenissurat_id, jenisinformasi_id, jenisinformasi_nama, jenisinformasi_namalain, tipeinput_isiinformasi, jenisinformasi_aktif, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisinformasi_id, jenissurat_id, jenisinformasi_nama, jenisinformasi_namalain, jenisinformasi_urutan, tipeinput_isiinformasi, jenisinformasi_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'jenissurat' => array(self::BELONGS_TO, 'JenissuratM', 'jenissurat_id'),
			'isiinformasiMs' => array(self::HAS_MANY, 'IsiinformasiM', 'jenisinformasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenisinformasi_id' => 'ID',
			'jenissurat_id' => 'Jenis Surat',
			'jenisinformasi_nama' => 'Jenis Informasi',
			'jenisinformasi_namalain' => 'Nama Lain',
			'jenisinformasi_urutan' => 'Urutan',
			'tipeinput_isiinformasi' => 'Tipe Input Isi Informasi',
			'jenisinformasi_aktif' => 'Status',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('jenisinformasi_id',$this->jenisinformasi_id);
		$criteria->compare('jenissurat_id',$this->jenissurat_id);
		$criteria->compare('lower(jenisinformasi_nama)',strtolower($this->jenisinformasi_nama),true);
		$criteria->compare('lower(jenisinformasi_namalain)',strtolower($this->jenisinformasi_namalain),true);
		$criteria->compare('jenisinformasi_urutan',$this->jenisinformasi_urutan);
		$criteria->compare('tipeinput_isiinformasi',$this->tipeinput_isiinformasi,true);
		$criteria->compare('jenisinformasi_aktif',$this->jenisinformasi_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchPrint() {
        $prov = $this->search();
        $prov->pagination = false;
        
        return $prov;
    }
}