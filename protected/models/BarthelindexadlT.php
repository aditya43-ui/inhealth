<?php

/**
 * This is the model class for table "barthelindexadl_t".
 *
 * The followings are the available columns in table 'barthelindexadl_t':
 * @property integer $barthelindexadl_id
 * @property integer $asesmenawalkeperawatan_id
 * @property integer $perawat_id
 * @property integer $skor_bab
 * @property integer $skor_bak
 * @property integer $skor_kebersihanmandiri
 * @property integer $skor_pengunaanjamban
 * @property integer $skor_makan
 * @property integer $skor_sikap
 * @property integer $skor_berpindah
 * @property integer $skor_baju
 * @property integer $skor_naikturuntangga
 * @property integer $skor_mandi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $perawat
 * @property AsesmenawalkeperawatanT $asesmenawalkeperawatan
 */
class BarthelindexadlT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BarthelindexadlT the static model class
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
		return 'barthelindexadl_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmenawalkeperawatan_id, perawat_id, create_time, create_loginpemakai', 'required'),
			array('asesmenawalkeperawatan_id, perawat_id, skor_bab, skor_bak, skor_kebersihanmandiri, skor_pengunaanjamban, skor_makan, skor_sikap, skor_berpindah, skor_baju, skor_naikturuntangga, skor_mandi, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('barthelindexadl_id, asesmenawalkeperawatan_id, perawat_id, skor_bab, skor_bak, skor_kebersihanmandiri, skor_pengunaanjamban, skor_makan, skor_sikap, skor_berpindah, skor_baju, skor_naikturuntangga, skor_mandi, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'perawat' => array(self::BELONGS_TO, 'PegawaiM', 'perawat_id'),
			'asesmenawalkeperawatan' => array(self::BELONGS_TO, 'AsesmenawalkeperawatanT', 'asesmenawalkeperawatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'barthelindexadl_id' => 'Barthelindexadl',
			'asesmenawalkeperawatan_id' => 'Asesmenawalkeperawatan',
			'perawat_id' => 'Perawat',
			'skor_bab' => 'Skor Bab',
			'skor_bak' => 'Skor Bak',
			'skor_kebersihanmandiri' => 'Skor Kebersihanmandiri',
			'skor_pengunaanjamban' => 'Skor Pengunaanjamban',
			'skor_makan' => 'Skor Makan',
			'skor_sikap' => 'Skor Sikap',
			'skor_berpindah' => 'Skor Berpindah',
			'skor_baju' => 'Skor Baju',
			'skor_naikturuntangga' => 'Skor Naikturuntangga',
			'skor_mandi' => 'Skor Mandi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('barthelindexadl_id',$this->barthelindexadl_id);
		$criteria->compare('asesmenawalkeperawatan_id',$this->asesmenawalkeperawatan_id);
		$criteria->compare('perawat_id',$this->perawat_id);
		$criteria->compare('skor_bab',$this->skor_bab);
		$criteria->compare('skor_bak',$this->skor_bak);
		$criteria->compare('skor_kebersihanmandiri',$this->skor_kebersihanmandiri);
		$criteria->compare('skor_pengunaanjamban',$this->skor_pengunaanjamban);
		$criteria->compare('skor_makan',$this->skor_makan);
		$criteria->compare('skor_sikap',$this->skor_sikap);
		$criteria->compare('skor_berpindah',$this->skor_berpindah);
		$criteria->compare('skor_baju',$this->skor_baju);
		$criteria->compare('skor_naikturuntangga',$this->skor_naikturuntangga);
		$criteria->compare('skor_mandi',$this->skor_mandi);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
