<?php

/**
 * This is the model class for table "verifikasitagihankomponen_r".
 *
 * The followings are the available columns in table 'verifikasitagihankomponen_r':
 * @property integer $verifikasitagihankomponen_id
 * @property integer $verifikasitagihantindakan_id
 * @property integer $tindakankomponen_id
 * @property integer $komponentarif_id
 * @property double $tarifkompsatuan_sebelum
 * @property double $tarifkompsatuan_sesudah
 * @property double $tariftindakankomp_sebelum
 * @property double $tariftindakankomp_sesudah
 *
 * The followings are the available model relations:
 * @property VerifikasitagihantindakanR $verifikasitagihantindakan
 * @property KomponentarifM $komponentarif
 */
class VerifikasitagihankomponenR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VerifikasitagihankomponenR the static model class
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
		return 'verifikasitagihankomponen_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('verifikasitagihantindakan_id, tindakankomponen_id, komponentarif_id', 'required'),
			array('verifikasitagihantindakan_id, tindakankomponen_id, komponentarif_id', 'numerical', 'integerOnly'=>true),
			array('tarifkompsatuan_sebelum, tarifkompsatuan_sesudah, tariftindakankomp_sebelum, tariftindakankomp_sesudah', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verifikasitagihankomponen_id, verifikasitagihantindakan_id, tindakankomponen_id, komponentarif_id, tarifkompsatuan_sebelum, tarifkompsatuan_sesudah, tariftindakankomp_sebelum, tariftindakankomp_sesudah', 'safe', 'on'=>'search'),
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
			'verifikasitagihantindakan' => array(self::BELONGS_TO, 'VerifikasitagihantindakanR', 'verifikasitagihantindakan_id'),
			'komponentarif' => array(self::BELONGS_TO, 'KomponentarifM', 'komponentarif_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'verifikasitagihankomponen_id' => 'Verifikasitagihankomponen',
			'verifikasitagihantindakan_id' => 'Verifikasitagihantindakan',
			'tindakankomponen_id' => 'Tindakankomponen',
			'komponentarif_id' => 'Komponentarif',
			'tarifkompsatuan_sebelum' => 'Tarifkompsatuan Sebelum',
			'tarifkompsatuan_sesudah' => 'Tarifkompsatuan Sesudah',
			'tariftindakankomp_sebelum' => 'Tariftindakankomp Sebelum',
			'tariftindakankomp_sesudah' => 'Tariftindakankomp Sesudah',
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

		$criteria->compare('verifikasitagihankomponen_id',$this->verifikasitagihankomponen_id);
		$criteria->compare('verifikasitagihantindakan_id',$this->verifikasitagihantindakan_id);
		$criteria->compare('tindakankomponen_id',$this->tindakankomponen_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('tarifkompsatuan_sebelum',$this->tarifkompsatuan_sebelum);
		$criteria->compare('tarifkompsatuan_sesudah',$this->tarifkompsatuan_sesudah);
		$criteria->compare('tariftindakankomp_sebelum',$this->tariftindakankomp_sebelum);
		$criteria->compare('tariftindakankomp_sesudah',$this->tariftindakankomp_sesudah);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}