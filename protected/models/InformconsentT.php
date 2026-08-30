<?php

/**
 * This is the model class for table "informconsent_t".
 *
 * The followings are the available columns in table 'informconsent_t':
 * @property integer $suratpersetujuantm_id
 * @property string $informasi_tindakan_medis
 * @property string $nama_menyetujui1
 * @property string $nama_menyetujui2
 * @property string $nama_menyetujui3
 * @property string $nama_menyetujui4
 *
 * The followings are the available model relations:
 * @property SuratpersetujuantmT $suratpersetujuantm
 */
class InformconsentT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformconsentT the static model class
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
		return 'informconsent_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('suratpersetujuantm_id', 'required'),
			array('suratpersetujuantm_id', 'numerical', 'integerOnly'=>true),
			array('informasi_tindakan_medis, nama_menyetujui1, nama_menyetujui2, nama_menyetujui3, nama_menyetujui4', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('suratpersetujuantm_id, informasi_tindakan_medis, nama_menyetujui1, nama_menyetujui2, nama_menyetujui3, nama_menyetujui4', 'safe', 'on'=>'search'),
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
			'suratpersetujuantm' => array(self::BELONGS_TO, 'SuratpersetujuantmT', 'suratpersetujuantm_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suratpersetujuantm_id' => 'Suratpersetujuantm',
			'informasi_tindakan_medis' => 'Informasi Tindakan Medis',
			'nama_menyetujui1' => 'Nama Menyetujui1',
			'nama_menyetujui2' => 'Nama Menyetujui2',
			'nama_menyetujui3' => 'Nama Menyetujui3',
			'nama_menyetujui4' => 'Nama Menyetujui4',
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

		$criteria->compare('suratpersetujuantm_id',$this->suratpersetujuantm_id);
		$criteria->compare('informasi_tindakan_medis',$this->informasi_tindakan_medis,true);
		$criteria->compare('nama_menyetujui1',$this->nama_menyetujui1,true);
		$criteria->compare('nama_menyetujui2',$this->nama_menyetujui2,true);
		$criteria->compare('nama_menyetujui3',$this->nama_menyetujui3,true);
		$criteria->compare('nama_menyetujui4',$this->nama_menyetujui4,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}