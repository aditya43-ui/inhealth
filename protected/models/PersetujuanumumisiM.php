<?php

/**
 * This is the model class for table "persetujuanumumisi_m".
 *
 * The followings are the available columns in table 'persetujuanumumisi_m':
 * @property integer $persetujuanumumisi_id
 * @property integer $persetujuanumum_id
 * @property string $persetujuan_isi
 * @property integer $persetujuan_urutan
 * @property boolean $persetujuan_isiadagambar
 * @property string $persetujuan_gambar
 * @property boolean $persetujuan_isiadainputan
 * @property boolean $isaktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PersetujuanumumM $persetujuanumum
 * @property PersetujuanumuminputanM[] $persetujuanumuminputanMs
 */
class PersetujuanumumisiM extends CActiveRecord
{
        public $val64_gambar;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'persetujuanumumisi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('persetujuanumum_id, create_time, create_loginpemakai_id, update_loginpemakai_id', 'required'),
			array('persetujuanumum_id, persetujuan_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('persetujuan_isi, persetujuan_isiadagambar, persetujuan_gambar, persetujuan_isiadainputan, isaktif, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('persetujuanumumisi_id, persetujuanumum_id, persetujuan_isi, persetujuan_urutan, persetujuan_isiadagambar, persetujuan_gambar, persetujuan_isiadainputan, isaktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'persetujuanumum' => array(self::BELONGS_TO, 'PersetujuanumumM', 'persetujuanumum_id'),
			'persetujuanumuminputanMs' => array(self::HAS_MANY, 'PersetujuanumuminputanM', 'persetujuanumumisi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'persetujuanumumisi_id' => 'Persetujuanumumisi',
			'persetujuanumum_id' => 'Persetujuanumum',
			'persetujuan_isi' => 'Isi Persetujuan',
			'persetujuan_urutan' => 'Urutan',
			'persetujuan_isiadagambar' => 'Apakah Memiliki Gambar?',
			'persetujuan_gambar' => 'Persetujuan Gambar',
			'persetujuan_isiadainputan' => 'Apakah Memiliki Inputan?',
			'isaktif' => 'Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('persetujuanumumisi_id',$this->persetujuanumumisi_id);
		$criteria->compare('persetujuanumum_id',$this->persetujuanumum_id);
		$criteria->compare('persetujuan_isi',$this->persetujuan_isi,true);
		$criteria->compare('persetujuan_urutan',$this->persetujuan_urutan);
		$criteria->compare('persetujuan_isiadagambar',$this->persetujuan_isiadagambar);
		$criteria->compare('persetujuan_gambar',$this->persetujuan_gambar,true);
		$criteria->compare('persetujuan_isiadainputan',$this->persetujuan_isiadainputan);
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PersetujuanumumisiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
