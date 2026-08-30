<?php

/**
 * This is the model class for table "diagnosakesehatanjiwa_m".
 *
 * The followings are the available columns in table 'diagnosakesehatanjiwa_m':
 * @property integer $diagnosakesehatanjiwa_id
 * @property string $jenisdiagnosa
 * @property string $kelompokdiagnosa
 * @property string $diagnosakesehatanjiwa_nama
 * @property integer $urutan
 * @property boolean $isaktif
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 */
class DiagnosakesehatanjiwaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosakesehatanjiwaM the static model class
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
		return 'diagnosakesehatanjiwa_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisdiagnosa, urutan, create_time, create_loginpemakai, update_loginpemakai', 'required'),
			array('urutan, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('jenisdiagnosa', 'length', 'max'=>225),
			array('kelompokdiagnosa', 'length', 'max'=>255),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('diagnosakesehatanjiwa_nama, isaktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('diagnosakesehatanjiwa_id, jenisdiagnosa, kelompokdiagnosa, diagnosakesehatanjiwa_nama, urutan, isaktif, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'diagnosakesehatanjiwa_id' => 'Diagnosakesehatanjiwa',
			'jenisdiagnosa' => 'Jenis Diagnosa',
			'kelompokdiagnosa' => 'Kelompok Diagnosa',
			'diagnosakesehatanjiwa_nama' => 'Nama Diagnosa',
			'urutan' => 'Urutan',
			'isaktif' => 'Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('diagnosakesehatanjiwa_id',$this->diagnosakesehatanjiwa_id);
		$criteria->compare('jenisdiagnosa',$this->jenisdiagnosa,true);
		$criteria->compare('kelompokdiagnosa',$this->kelompokdiagnosa,true);
		$criteria->compare('diagnosakesehatanjiwa_nama',$this->diagnosakesehatanjiwa_nama,true);
		$criteria->compare('urutan',$this->urutan);
		$criteria->compare('isaktif',$this->isaktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

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