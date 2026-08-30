<?php

/**
 * This is the model class for table "isiinformasi_m".
 *
 * The followings are the available columns in table 'isiinformasi_m':
 * @property integer $isiinformasi_id
 * @property integer $jenisinformasi_id
 * @property string $isiinformasi_nama
 * @property string $infosebelumcheckbox
 * @property string $infosetelahcheckbox
 * @property integer $isiinformasi_urutan
 * @property boolean $isiinformasi_aktif
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property JenisinformasiM $jenisinformasi
 */
class IsiinformasiM extends CActiveRecord
{
    public $jenissurat_id;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IsiinformasiM the static model class
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
		return 'isiinformasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('jenisinformasi_id, isiinformasi_urutan', 'numerical', 'integerOnly'=>true),
			array('jenissurat_id, isiinformasi_nama, infosebelumcheckbox, infosetelahcheckbox, isiinformasi_aktif, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenissurat_id, isiinformasi_id, jenisinformasi_id, isiinformasi_nama, infosebelumcheckbox, infosetelahcheckbox, isiinformasi_urutan, isiinformasi_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'jenisinformasi' => array(self::BELONGS_TO, 'JenisinformasiM', 'jenisinformasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'isiinformasi_id' => 'ID',
			'jenisinformasi_id' => 'Jenis Informasi',
			'isiinformasi_nama' => 'NamaInformasi',
			'infosebelumcheckbox' => 'Info Sebelum Check Box',
			'infosetelahcheckbox' => 'Info Setelah Check Box',
			'isiinformasi_urutan' => 'Urutan',
			'isiinformasi_aktif' => 'Status',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
            'jenissurat_id' => 'Jenis Surat Persetujuan Tindakan',
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

        $criteria->join = 'join jenisinformasi_m j on j.jenisinformasi_id = t.jenisinformasi_id';
        
		$criteria->compare('t.isiinformasi_id',$this->isiinformasi_id);
		$criteria->compare('j.jenissurat_id',$this->jenissurat_id);
		$criteria->compare('t.jenisinformasi_id',$this->jenisinformasi_id);
		$criteria->compare('t.isiinformasi_nama',$this->isiinformasi_nama,true);
		$criteria->compare('t.infosebelumcheckbox',$this->infosebelumcheckbox,true);
		$criteria->compare('t.infosetelahcheckbox',$this->infosetelahcheckbox,true);
		$criteria->compare('t.isiinformasi_urutan',$this->isiinformasi_urutan);
		$criteria->compare('t.isiinformasi_aktif',$this->isiinformasi_aktif);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('t.create_ruangan',$this->create_ruangan,true);
        
        $criteria->order = "j.jenissurat_id, j.jenisinformasi_id, t.isiinformasi_urutan";

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