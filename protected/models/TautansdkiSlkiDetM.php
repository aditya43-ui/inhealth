<?php

/**
 * This is the model class for table "tautansdki_slki_det_m".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'tautansdki_slki_det_m':
 * @property integer $tautansdki_slki_det_id
 * @property integer $tautansdki_slki_id
 * @property integer $luarankeperawatan_id
 * @property string $luarankeperawatan_nama
 * @property boolean $tautansdki_slki_aktif
 *
 * The followings are the available model relations:
 * @property LuarankeperawatanM $luarankeperawatan
 * @property TautansdkiSlkiM $tautansdkiSlki
 */
class TautansdkiSlkiDetM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TautansdkiSlkiDetM the static model class
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
		return 'tautansdki_slki_det_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tautansdki_slki_id, luarankeperawatan_id', 'required'),
			array('tautansdki_slki_id, luarankeperawatan_id', 'numerical', 'integerOnly'=>true),
			array('luarankeperawatan_nama', 'length', 'max'=>200),
			array('tautansdki_slki_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tautansdki_slki_det_id, tautansdki_slki_id, luarankeperawatan_id, luarankeperawatan_nama, tautansdki_slki_aktif', 'safe', 'on'=>'search'),
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
			'luarankeperawatan' => array(self::BELONGS_TO, 'LuarankeperawatanM', 'luarankeperawatan_id'),
			'tautansdkiSlki' => array(self::BELONGS_TO, 'TautansdkiSlkiM', 'tautansdki_slki_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tautansdki_slki_det_id' => 'Tautansdki Slki Det',
			'tautansdki_slki_id' => 'Tautansdki Slki',
			'luarankeperawatan_id' => 'Luarankeperawatan',
			'luarankeperawatan_nama' => 'Luarankeperawatan Nama',
			'tautansdki_slki_aktif' => 'Tautansdki Slki Aktif',
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

		$criteria->compare('tautansdki_slki_det_id',$this->tautansdki_slki_det_id);
		$criteria->compare('tautansdki_slki_id',$this->tautansdki_slki_id);
		$criteria->compare('luarankeperawatan_id',$this->luarankeperawatan_id);
		$criteria->compare('luarankeperawatan_nama',$this->luarankeperawatan_nama,true);
                $criteria->compare('tautansdki_slki_aktif',isset($this->tautansdki_slki_aktif)?$this->tautansdki_slki_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}