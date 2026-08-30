<?php

/**
 * This is the model class for table "minimentalexam_m".
 *
 * The followings are the available columns in table 'minimentalexam_m':
 * @property integer $minimentalexam_id
 * @property string $variabel
 * @property integer $parent_id
 * @property integer $nilai_maksimum
 * @property boolean $isupload_gambar
 * @property string $gambar
 * @property integer $urutan
 * @property boolean $isaktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property MinimentalexampasienT[] $minimentalexampasienTs
 */
class MinimentalexamM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MinimentalexamM the static model class
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
		return 'minimentalexam_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('variabel, isaktif, create_time, create_loginpemakai_id', 'required'),
			array('parent_id, nilai_maksimum, urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('isupload_gambar, gambar, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('minimentalexam_id, variabel, parent_id, nilai_maksimum, isupload_gambar, gambar, urutan, isaktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'minimentalexampasienTs' => array(self::HAS_MANY, 'MinimentalexampasienT', 'minimentalexam_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'minimentalexam_id' => 'Minimentalexam',
			'variabel' => 'Variabel',
			'parent_id' => 'Parent',
			'nilai_maksimum' => 'Nilai Maksimum',
			'isupload_gambar' => 'Isupload Gambar',
			'gambar' => 'Gambar',
			'urutan' => 'Urutan',
			'isaktif' => 'Isaktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('minimentalexam_id',$this->minimentalexam_id);
		$criteria->compare('variabel',$this->variabel,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('nilai_maksimum',$this->nilai_maksimum);
		$criteria->compare('isupload_gambar',$this->isupload_gambar);
		$criteria->compare('gambar',$this->gambar,true);
		$criteria->compare('urutan',$this->urutan);
		$criteria->compare('isaktif',$this->isaktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}