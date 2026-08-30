<?php

/**
 * This is the model class for table "jenisformdet_m".
 *
 * The followings are the available columns in table 'jenisformdet_m':
 * @property integer $formlab_id
 * @property integer $pemeriksaanlab_id,
 * @property integer $jenisform_id
 */
class JenisformdetM extends CActiveRecord
{
	public $jenispemeriksaanlab_id,$jenispemeriksaanlab_urutan,
	$jenispemeriksaanlab_namalainnya,
	$pemeriksaanlab_nama,$jenispemeriksaanlab_kode,$jenisform_nama,$jenispemeriksaanlab_kelompok,$pemeriksaanlab_kode,$jenispemeriksaanlab_nama;
 
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jenisformdet_m';
	}

	// public function primaryKey(){
	//  	return array('formlab_id');
	// }
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('formlab_id', 'required'),
			array('formlab_id, pemeriksaanlab_id, jenisform_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('formlab_id,jenispemeriksaanlab_id,pemeriksaanlab_nama,jenispemeriksaanlab_kode,jenisform_nama,jenispemeriksaanlab_kelompok,pemeriksaanlab_kelompok,jenispemeriksaanlab_nama, pemeriksaanlab_id, jenisform_id', 'safe', 'on'=>'search'),
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
			'jenisform' => array(self::BELONGS_TO, 'JenisformM', 'jenisform_id'),
			'periksalab'=> array(self::BELONGS_TO, 'PemeriksaanlabM', 'pemeriksaanlab_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'formlab_id' => 'Form lab',
			'pemeriksaanlab_id' => 'Pemeriksaan lab',
			'jenisform_id' => 'Jenis form',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('formlab_id',$this->formlab_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('jenisform_id',$this->jenisform_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	public function searchForm()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->join ='JOIN pemeriksaanlab_m p on p.pemeriksaanlab_id = t.pemeriksaanlab_id '
						.'JOIN jenisform_m j on j.jenisform_id = t.jenisform_id '
						.'JOIN jenispemeriksaanlab_m jp on jp.jenispemeriksaanlab_id = p.jenispemeriksaanlab_id ';

		$criteria->select = 't.formlab_id, j.jenisform_id,jp.*, j.jenisform_nama,jp.jenispemeriksaanlab_kelompok,p.pemeriksaanlab_kode,p.pemeriksaanlab_nama';

		//$criteria->compare('t.formlab_id',$this->formlab_id);
		//$criteria->compare('p.pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('j.jenisform_id',$this->jenisform_id);
		$criteria->compare('LOWER(j.jenisform_nama)',strtolower($this->jenisform_nama),true);
		$criteria->compare('LOWER(jp.jenispemeriksaanlab_kelompok)',strtolower($this->jenispemeriksaanlab_kelompok),true);
		$criteria->compare('LOWER(p.pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
		$criteria->compare('LOWER(p.pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
		$criteria->compare('LOWER(jp.jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
		$criteria->compare('LOWER(jp.jenispemeriksaanlab_kode)',strtolower($this->jenispemeriksaanlab_kode),true);
		
		
		//$criteria->addCondition('jenisform_id',$this->jenispemeriksaanlab_nama);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JenisformdetM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
