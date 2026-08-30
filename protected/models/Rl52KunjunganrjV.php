<?php

/**
 * This is the model class for table "rl5_2_kunjrwtjln_v".
 *
 * The followings are the available columns in table 'rl5_2_kunjrwtjln_v':
 * @property string $tgl_pendaftaran
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property string $jmlpasien
 * @property integer $instalasi_id
 */
class Rl52KunjunganrjV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl52KunjrwtjlnV the static model class
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
		return 'rl5_2_kunjunganrj_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskasuspenyakit_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('tgl_pendaftaran, jmlpasien', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_pendaftaran, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, jmlpasien, instalasi_id', 'safe', 'on'=>'search'),
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
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'jmlpasien' => 'Jmlpasien',
			'instalasi_id' => 'Instalasi',
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

		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('jeniskasuspenyakit_nama',$this->jeniskasuspenyakit_nama,true);
		$criteria->compare('jmlpasien',$this->jmlpasien,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}