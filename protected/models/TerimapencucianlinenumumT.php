<?php

/**
 * This is the model class for table "terimapencucianlinenumum_t".
 *
 * The followings are the available columns in table 'terimapencucianlinenumum_t':
 * @property integer $terimapencucianlinenumum_id
 * @property string $tglpenerimaan
 * @property string $nopenerimaan
 * @property string $namapengirim
 * @property double $berat
 * @property double $harga
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_ruangan
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property boolean $status_bayar
 * @property integer $pembayarancucilinenumum_id
 * @property string $tglpenerimaanlinen
 */
class TerimapencucianlinenumumT extends CActiveRecord
{
    public $hargacuci;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'terimapencucianlinenumum_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_ruangan, create_loginpemakai_id, update_loginpemakai_id, pembayarancucilinenumum_id', 'numerical', 'integerOnly'=>true),
			array('berat, harga', 'numerical'),
			array('nopenerimaan', 'length', 'max'=>30),
			array('namapengirim', 'length', 'max'=>50),
			array('tglpenerimaan, keterangan, create_time, update_time, status_bayar, tglpenerimaanlinen', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('terimapencucianlinenumum_id, tglpenerimaan, nopenerimaan, namapengirim, berat, harga, keterangan, create_time, update_time, create_ruangan, create_loginpemakai_id, update_loginpemakai_id, status_bayar, pembayarancucilinenumum_id, tglpenerimaanlinen', 'safe', 'on'=>'search'),
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
			'terimapencucianlinenumum_id' => 'Terimapencucianlinenumum',
			'tglpenerimaan' => 'Tglpenerimaan',
			'nopenerimaan' => 'Nopenerimaan',
			'namapengirim' => 'Namapengirim',
			'berat' => 'Berat',
			'harga' => 'Harga',
			'keterangan' => 'Keterangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_ruangan' => 'Create Ruangan',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'status_bayar' => 'Status Bayar',
			'pembayarancucilinenumum_id' => 'Pembayarancucilinenumum',
			'tglpenerimaanlinen' => 'Tglpenerimaanlinen',
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

		$criteria->compare('terimapencucianlinenumum_id',$this->terimapencucianlinenumum_id);
		$criteria->compare('tglpenerimaan',$this->tglpenerimaan,true);
		$criteria->compare('nopenerimaan',$this->nopenerimaan,true);
		$criteria->compare('namapengirim',$this->namapengirim,true);
		$criteria->compare('berat',$this->berat);
		$criteria->compare('harga',$this->harga);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('status_bayar',$this->status_bayar);
		$criteria->compare('pembayarancucilinenumum_id',$this->pembayarancucilinenumum_id);
		$criteria->compare('tglpenerimaanlinen',$this->tglpenerimaanlinen,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TerimapencucianlinenumumT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
