<?php

/**
 * This is the model class for table "laporangizipmtradiologi_v".
 *
 * The followings are the available columns in table 'laporangizipmtradiologi_v':
 * @property double $jml_pesan_porsi
 * @property string $tglpesanmenu
 * @property string $nopesanmenu
 * @property integer $jenisdiet_id
 * @property string $jenisdiet_nama
 * @property integer $menudiet_id
 * @property string $menudiet_nama
 * @property integer $jeniswaktu_id
 * @property string $jeniswaktu_nama
 * @property string $jeniswaktu_jam
 */
class LaporangizipmtradiologiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporangizipmtradiologiV the static model class
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
		return 'laporangizipmtradiologi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisdiet_id, menudiet_id, jeniswaktu_id', 'numerical', 'integerOnly'=>true),
			array('jml_pesan_porsi', 'numerical'),
			array('nopesanmenu, jenisdiet_nama, jeniswaktu_nama', 'length', 'max'=>50),
			array('menudiet_nama', 'length', 'max'=>200),
			array('jeniswaktu_jam', 'length', 'max'=>20),
			array('tglpesanmenu', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jml_pesan_porsi, tglpesanmenu, nopesanmenu, jenisdiet_id, jenisdiet_nama, menudiet_id, menudiet_nama, jeniswaktu_id, jeniswaktu_nama, jeniswaktu_jam', 'safe', 'on'=>'search'),
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
			'jml_pesan_porsi' => 'Jml Pesan Porsi',
			'tglpesanmenu' => 'Tglpesanmenu',
			'nopesanmenu' => 'Nopesanmenu',
			'jenisdiet_id' => 'Jenisdiet',
			'jenisdiet_nama' => 'Jenisdiet Nama',
			'menudiet_id' => 'Menudiet',
			'menudiet_nama' => 'Menudiet Nama',
			'jeniswaktu_id' => 'Jeniswaktu',
			'jeniswaktu_nama' => 'Jeniswaktu Nama',
			'jeniswaktu_jam' => 'Jeniswaktu Jam',
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

		$criteria->compare('jml_pesan_porsi',$this->jml_pesan_porsi);
		$criteria->compare('tglpesanmenu',$this->tglpesanmenu,true);
		$criteria->compare('nopesanmenu',$this->nopesanmenu,true);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('jenisdiet_nama',$this->jenisdiet_nama,true);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('menudiet_nama',$this->menudiet_nama,true);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('jeniswaktu_nama',$this->jeniswaktu_nama,true);
		$criteria->compare('jeniswaktu_jam',$this->jeniswaktu_jam,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}