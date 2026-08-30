<?php

/**
 * This is the model class for table "rinciansetorankasir_t".
 *
 * The followings are the available columns in table 'rinciansetorankasir_t':
 * @property integer $rinciansetorankasir_id
 * @property integer $setorankasir_id
 * @property integer $ruangan_id
 * @property integer $jml_pasien_l
 * @property integer $jml_pasien_p
 * @property integer $jml_pasien_lp
 * @property double $jml_retirbusi_pl
 * @property double $jml_retirbusi_pb
 * @property double $jml_jasamedis_pb
 * @property double $jml_jasamedis_pl
 * @property double $jml_paramedis_pb
 * @property double $jml_paramedis_pl
 * @property double $jml_administrasi_pb
 * @property double $jml_administrasi_pl
 * @property double $jml_setoran_pb
 * @property double $jml_setoran_pl
 * @property double $totsetkasirruangan
 */
class RinciansetorankasirT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RinciansetorankasirT the static model class
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
		return 'rinciansetorankasir_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setorankasir_id, jml_pasien_l', 'required'),
			array('setorankasir_id, ruangan_id, jml_pasien_l, jml_pasien_p, jml_pasien_lp', 'numerical', 'integerOnly'=>true),
			array('jml_retirbusi_pl, jml_retirbusi_pb, jml_jasamedis_pb, jml_jasamedis_pl, jml_paramedis_pb, jml_paramedis_pl, jml_administrasi_pb, jml_administrasi_pl, jml_setoran_pb, jml_setoran_pl, totsetkasirruangan', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rinciansetorankasir_id, setorankasir_id, ruangan_id, jml_pasien_l, jml_pasien_p, jml_pasien_lp, jml_retirbusi_pl, jml_retirbusi_pb, jml_jasamedis_pb, jml_jasamedis_pl, jml_paramedis_pb, jml_paramedis_pl, jml_administrasi_pb, jml_administrasi_pl, jml_setoran_pb, jml_setoran_pl, totsetkasirruangan', 'safe', 'on'=>'search'),
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
			'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rinciansetorankasir_id' => 'Rinciansetorankasir',
			'setorankasir_id' => 'Setorankasir',
			'ruangan_id' => 'Ruangan',
			'jml_pasien_l' => 'Jml Pasien L',
			'jml_pasien_p' => 'Jml Pasien P',
			'jml_pasien_lp' => 'Jml Pasien Lp',
			'jml_retirbusi_pl' => 'Jml Retirbusi Pl',
			'jml_retirbusi_pb' => 'Jml Retirbusi Pb',
			'jml_jasamedis_pb' => 'Jml Jasamedis Pb',
			'jml_jasamedis_pl' => 'Jml Jasamedis Pl',
			'jml_paramedis_pb' => 'Jml Paramedis Pb',
			'jml_paramedis_pl' => 'Jml Paramedis Pl',
			'jml_administrasi_pb' => 'Jml Administrasi Pb',
			'jml_administrasi_pl' => 'Jml Administrasi Pl',
			'jml_setoran_pb' => 'Jml Setoran Pb',
			'jml_setoran_pl' => 'Jml Setoran Pl',
			'totsetkasirruangan' => 'Totsetkasirruangan',
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

		$criteria->compare('rinciansetorankasir_id',$this->rinciansetorankasir_id);
		$criteria->compare('setorankasir_id',$this->setorankasir_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jml_pasien_l',$this->jml_pasien_l);
		$criteria->compare('jml_pasien_p',$this->jml_pasien_p);
		$criteria->compare('jml_pasien_lp',$this->jml_pasien_lp);
		$criteria->compare('jml_retirbusi_pl',$this->jml_retirbusi_pl);
		$criteria->compare('jml_retirbusi_pb',$this->jml_retirbusi_pb);
		$criteria->compare('jml_jasamedis_pb',$this->jml_jasamedis_pb);
		$criteria->compare('jml_jasamedis_pl',$this->jml_jasamedis_pl);
		$criteria->compare('jml_paramedis_pb',$this->jml_paramedis_pb);
		$criteria->compare('jml_paramedis_pl',$this->jml_paramedis_pl);
		$criteria->compare('jml_administrasi_pb',$this->jml_administrasi_pb);
		$criteria->compare('jml_administrasi_pl',$this->jml_administrasi_pl);
		$criteria->compare('jml_setoran_pb',$this->jml_setoran_pb);
		$criteria->compare('jml_setoran_pl',$this->jml_setoran_pl);
		$criteria->compare('totsetkasirruangan',$this->totsetkasirruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}