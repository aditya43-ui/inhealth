<?php

/**
 * This is the model class for table "kesimpulanmcu_lab_t".
 *
 * The followings are the available columns in table 'kesimpulanmcu_lab_t':
 * @property integer $kesimpulanmcu_lab_id
 * @property integer $kesimpulanmcu_id
 * @property integer $pemeriksaanlab_id
 * @property integer $detailhasilpemeriksaanlab_id
 * @property string $namapemeriksaanlab
 * @property string $keteranganhasil
 *
 * The followings are the available model relations:
 * @property DetailhasilpemeriksaanlabT $detailhasilpemeriksaanlab
 * @property KesimpulanmcuT $kesimpulanmcu
 * @property PemeriksaanlabM $pemeriksaanlab
 */
class KesimpulanmcuLabT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kesimpulanmcu_lab_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kesimpulanmcu_id, pemeriksaanlab_id, detailhasilpemeriksaanlab_id', 'numerical', 'integerOnly'=>true),
			array('namapemeriksaanlab', 'length', 'max'=>150),
			array('keteranganhasil', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kesimpulanmcu_lab_id, kesimpulanmcu_id, pemeriksaanlab_id, detailhasilpemeriksaanlab_id, namapemeriksaanlab, keteranganhasil', 'safe', 'on'=>'search'),
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
			'detailhasilpemeriksaanlab' => array(self::BELONGS_TO, 'DetailhasilpemeriksaanlabT', 'detailhasilpemeriksaanlab_id'),
			'kesimpulanmcu' => array(self::BELONGS_TO, 'KesimpulanmcuT', 'kesimpulanmcu_id'),
			'pemeriksaanlab' => array(self::BELONGS_TO, 'PemeriksaanlabM', 'pemeriksaanlab_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kesimpulanmcu_lab_id' => 'Kesimpulanmcu Lab',
			'kesimpulanmcu_id' => 'Kesimpulanmcu',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'detailhasilpemeriksaanlab_id' => 'Detailhasilpemeriksaanlab',
			'namapemeriksaanlab' => 'Namapemeriksaanlab',
			'keteranganhasil' => 'Keteranganhasil',
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

		$criteria->compare('kesimpulanmcu_lab_id',$this->kesimpulanmcu_lab_id);
		$criteria->compare('kesimpulanmcu_id',$this->kesimpulanmcu_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('detailhasilpemeriksaanlab_id',$this->detailhasilpemeriksaanlab_id);
		$criteria->compare('namapemeriksaanlab',$this->namapemeriksaanlab,true);
		$criteria->compare('keteranganhasil',$this->keteranganhasil,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KesimpulanmcuLabT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
