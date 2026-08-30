<?php

/**
 * This is the model class for table "returpenbahanmakan_t".
 *
 * The followings are the available columns in table 'returpenbahanmakan_t':
 * @property integer $returpenbahanmakan_id
 * @property integer $terimabahanmakan_id
 * @property string $noreturbahanmakan
 * @property string $tglreturbahanmakan
 * @property string $alasanreturbahanmakan
 * @property string $keterangan_returbahanmakan
 * @property double $totalretur
 * @property integer $peg_retur_id
 * @property integer $peg_mengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegMengetahui
 * @property PegawaiM $pegRetur
 * @property TerimabahanmakanT $terimabahanmakan
 * @property ReturpenbahanmakandetailT $returpenbahanmakandetailT
 */
class ReturpenbahanmakanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturpenbahanmakanT the static model class
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
		return 'returpenbahanmakan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('noreturbahanmakan, tglreturbahanmakan, alasanreturbahanmakan, peg_retur_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('terimabahanmakan_id, peg_retur_id, peg_mengetahui_id', 'numerical', 'integerOnly'=>true),
			array('totalretur', 'numerical'),
			array('noreturbahanmakan', 'length', 'max'=>50),
			array('alasanreturbahanmakan', 'length', 'max'=>100),
			array('keterangan_returbahanmakan, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('returpenbahanmakan_id, terimabahanmakan_id, noreturbahanmakan, tglreturbahanmakan, alasanreturbahanmakan, keterangan_returbahanmakan, totalretur, peg_retur_id, peg_mengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegMengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'peg_mengetahui_id'),
			'pegRetur' => array(self::BELONGS_TO, 'PegawaiM', 'peg_retur_id'),
			'terimabahanmakan' => array(self::BELONGS_TO, 'TerimabahanmakanT', 'terimabahanmakan_id'),
			'returpenbahanmakandetailT' => array(self::HAS_ONE, 'ReturpenbahanmakandetailT', 'returpenbahanmakandetail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'returpenbahanmakan_id' => 'Returpenbahanmakan',
			'terimabahanmakan_id' => 'Terima Bahan Makanan',
			'noreturbahanmakan' => 'No. Retur Terima',
			'tglreturbahanmakan' => 'Tanggal Retur Terima',
			'alasanreturbahanmakan' => 'Alasan Retur Terima',
			'keterangan_returbahanmakan' => 'Keterangan Retur',
			'totalretur' => 'Total Retur',
			'peg_retur_id' => 'Pegawai Retur',
			'peg_mengetahui_id' => 'Pegawai Mengetahui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('returpenbahanmakan_id',$this->returpenbahanmakan_id);
		$criteria->compare('terimabahanmakan_id',$this->terimabahanmakan_id);
		$criteria->compare('noreturbahanmakan',$this->noreturbahanmakan,true);
		$criteria->compare('tglreturbahanmakan',$this->tglreturbahanmakan,true);
		$criteria->compare('alasanreturbahanmakan',$this->alasanreturbahanmakan,true);
		$criteria->compare('keterangan_returbahanmakan',$this->keterangan_returbahanmakan,true);
		$criteria->compare('totalretur',$this->totalretur);
		$criteria->compare('peg_retur_id',$this->peg_retur_id);
		$criteria->compare('peg_mengetahui_id',$this->peg_mengetahui_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}