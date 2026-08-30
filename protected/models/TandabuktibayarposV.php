<?php

/**
 * This is the model class for table "tandabuktibayarpos_v".
 *
 * The followings are the available columns in table 'tandabuktibayarpos_v':
 * @property integer $tandabuktibayar_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $closingkasir_id
 * @property integer $shift_id
 * @property string $shift_nama
 * @property integer $nourutkasir
 * @property string $nobuktibayar
 * @property string $tglbuktibayar
 * @property string $carapembayaran
 * @property double $jmlpembayaran
 * @property double $uangditerima
 * @property double $uangkembalian
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class TandabuktibayarposV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TandabuktibayarposV the static model class
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
		return 'tandabuktibayarpos_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tandabuktibayar_id, ruangan_id, closingkasir_id, shift_id, nourutkasir', 'numerical', 'integerOnly'=>true),
			array('jmlpembayaran, uangditerima, uangkembalian', 'numerical'),
			array('ruangan_nama, shift_nama, nobuktibayar, carapembayaran', 'length', 'max'=>50),
			array('tglbuktibayar, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tandabuktibayar_id, ruangan_id, ruangan_nama, closingkasir_id, shift_id, shift_nama, nourutkasir, nobuktibayar, tglbuktibayar, carapembayaran, jmlpembayaran, uangditerima, uangkembalian, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'closingkasir_id' => 'Closingkasir',
			'shift_id' => 'Shift',
			'shift_nama' => 'Shift Nama',
			'nourutkasir' => 'Nourutkasir',
			'nobuktibayar' => 'Nobuktibayar',
			'tglbuktibayar' => 'Tglbuktibayar',
			'carapembayaran' => 'Carapembayaran',
			'jmlpembayaran' => 'Jmlpembayaran',
			'uangditerima' => 'Uang Diterima',
			'uangkembalian' => 'Uangkembalian',
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

		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);
		$criteria->compare('nourutkasir',$this->nourutkasir);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('LOWER(carapembayaran)',strtolower($this->carapembayaran),true);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('uangditerima',$this->uangditerima);
		$criteria->compare('uangkembalian',$this->uangkembalian);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);
		$criteria->compare('nourutkasir',$this->nourutkasir);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('LOWER(carapembayaran)',strtolower($this->carapembayaran),true);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('uangditerima',$this->uangditerima);
		$criteria->compare('uangkembalian',$this->uangkembalian);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}