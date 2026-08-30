<?php

/**
 * This is the model class for table "invbarang_t".
 *
 * The followings are the available columns in table 'invbarang_t':
 * @property integer $invbarang_id
 * @property integer $ruangan_id
 * @property string $invbarang_no
 * @property string $invbarang_tgl
 * @property string $invbarang_ket
 * @property double $invbarang_totalharga
 * @property double $invbarang_totalnetto
 * @property integer $mengetahui_id
 * @property integer $petugas1_id
 * @property integer $petugas2_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $formulirinvbarang_id
 * @property string $invbarang_jenis
 *
 * The followings are the available model relations:
 * @property InvbarangdetT[] $invbarangdetTs
 */
class InvbarangT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvbarangT the static model class
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
		return 'invbarang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, invbarang_no, invbarang_tgl, invbarang_totalnetto, create_time, create_loginpemakai_id, create_ruangan, invbarang_jenis', 'required'),
			array('ruangan_id, mengetahui_id, petugas1_id, petugas2_id, formulirinvbarang_id', 'numerical', 'integerOnly'=>true),
			array('invbarang_totalharga, invbarang_totalnetto, totalnilaipersediaan', 'numerical'),
			array('invbarang_no, invbarang_jenis', 'length', 'max'=>50),
			array('invbarang_ket, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invbarang_id, ruangan_id, invbarang_no, invbarang_tgl, invbarang_ket, invbarang_totalharga, invbarang_totalnetto, mengetahui_id, petugas1_id, petugas2_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, formulirinvbarang_id, invbarang_jenis, totalnilaipersediaan', 'safe', 'on'=>'search'),
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
			'invbarangdetTs' => array(self::HAS_MANY, 'InvbarangdetT', 'invbarang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invbarang_id' => 'Invbarang',
			'ruangan_id' => 'Ruangan',
			'invbarang_no' => 'Invbarang No',
			'invbarang_tgl' => 'Invbarang Tgl',
			'invbarang_ket' => 'Invbarang Ket',
			'invbarang_totalharga' => 'Invbarang Totalharga',
			'invbarang_totalnetto' => 'Invbarang Totalnetto',
			'mengetahui_id' => 'Mengetahui',
			'petugas1_id' => 'Petugas1',
			'petugas2_id' => 'Petugas2',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'formulirinvbarang_id' => 'Formulirinvbarang',
			'invbarang_jenis' => 'Invbarang Jenis',
			'totalnilaipersediaan'=>'Total Nilai Persediaan'
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

		$criteria->compare('invbarang_id',$this->invbarang_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('invbarang_no',$this->invbarang_no,true);
		$criteria->compare('invbarang_tgl',$this->invbarang_tgl,true);
		$criteria->compare('invbarang_ket',$this->invbarang_ket,true);
		$criteria->compare('invbarang_totalharga',$this->invbarang_totalharga);
		$criteria->compare('invbarang_totalnetto',$this->invbarang_totalnetto);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('petugas1_id',$this->petugas1_id);
		$criteria->compare('petugas2_id',$this->petugas2_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('formulirinvbarang_id',$this->formulirinvbarang_id);
		$criteria->compare('invbarang_jenis',$this->invbarang_jenis,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
