<?php

/**
 * This is the model class for table "kommentar_t".
 * digunakan untuk modul portal rs post berita
 * RSST-2443
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package application.models
 * The followings are the available columns in table 'kommentar_t':
 * @property integer $kommentar_id
 * @property string $kommentar_nama
 * @property string $kommentar_email
 * @property string $kommentar_desc
 * @property boolean $kommentar_tampil
 * @property integer $komentar_parentid
 * @property integer $post_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class KommentarT extends CActiveRecord
{
        public $post_judul;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KommentarT the static model class
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
		return 'kommentar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kommentar_nama, kommentar_email, kommentar_desc, create_time', 'required'),
			array('komentar_parentid, post_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kommentar_nama, kommentar_email', 'length', 'max'=>100),
			array('kommentar_tampil, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kommentar_id, kommentar_nama, kommentar_email, kommentar_desc, kommentar_tampil, komentar_parentid, post_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'kommentar_id' => 'Kommentar',
			'kommentar_nama' => 'Kommentar Nama',
			'kommentar_email' => 'Kommentar Email',
			'kommentar_desc' => 'Kommentar Desc',
			'kommentar_tampil' => 'Kommentar Tampil',
			'komentar_parentid' => 'Komentar Parentid',
			'post_id' => 'Post',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('kommentar_id',$this->kommentar_id);
		$criteria->compare('kommentar_nama',$this->kommentar_nama,true);
		$criteria->compare('kommentar_email',$this->kommentar_email,true);
		$criteria->compare('kommentar_desc',$this->kommentar_desc,true);
		$criteria->compare('kommentar_tampil',$this->kommentar_tampil);
		$criteria->compare('komentar_parentid',$this->komentar_parentid);
		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}