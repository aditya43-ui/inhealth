<?php

/**
 * This is the model class for table "catatanedukasib_m".
 *
 * The followings are the available columns in table 'catatanedukasib_m':
 * @property integer $catatanedukasib_id
 * @property string $nama_edukasi
 * @property string $isi_edukasi
 * @property integer $urutan
 * @property boolean $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 */
class CatatanedukasibM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatatanedukasibM the static model class
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
		return 'catatanedukasib_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_edukasi, isi_edukasi, urutan, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('urutan, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nama_edukasi, isi_edukasi', 'length', 'max'=>200),
			array('status, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('catatanedukasib_id, nama_edukasi, isi_edukasi, urutan, status, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'catatanedukasib_id' => 'Catatanedukasib',
			'nama_edukasi' => 'Nama Edukasi',
			'isi_edukasi' => 'Isi Edukasi',
			'urutan' => 'Urutan',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}



	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(nama_edukasi)',strtolower($this->nama_edukasi));
		$criteria->compare('LOWER(isi_edukasi)',strtolower($this->isi_edukasi),true);

		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(nama_edukasi)',strtolower($this->nama_edukasi));
		$criteria->compare('LOWER(isi_edukasi)',strtolower($this->isi_edukasi),true);

		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria
		));
	}

}
