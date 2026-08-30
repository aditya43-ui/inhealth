<?php

/**
 * This is the model class for table "pembatalanuangmuka_t".
 *
 * The followings are the available columns in table 'pembatalanuangmuka_t':
 * @property integer $pembatalanuangmuka_id
 * @property integer $bayaruangmuka_id
 * @property integer $tandabuktikeluar_id
 * @property integer $tandabuktibayar_id
 * @property integer $ruangan_id
 * @property string $tglpembatalan
 * @property string $keterangan_batal
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PembatalanuangmukaT extends CActiveRecord
{
    
    public $total_uangmuka;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembatalanuangmukaT the static model class
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
		return 'pembatalanuangmuka_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpembatalan, keterangan_batal', 'required'),
			array('bayaruangmuka_id, tandabuktikeluar_id, tandabuktibayar_id', 'numerical', 'integerOnly'=>true),
			array('ruangan_id, update_time, update_loginpemakai_id', 'safe'),
                    
                                                array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                                                array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                                                array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                                                array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                                                array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembatalanuangmuka_id, bayaruangmuka_id, tandabuktikeluar_id, tandabuktibayar_id, tglpembatalan, keterangan_batal, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'login'=>array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembatalanuangmuka_id' => 'Pembatalanuangmuka',
			'bayaruangmuka_id' => 'Bayaruangmuka',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'tglpembatalan' => 'Tanggal Pembatalan',
			'keterangan_batal' => 'Keterangan Batal',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
            'total_uangmuka' => 'Jumlah Uang Muka',
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

		$criteria->compare('pembatalanuangmuka_id',$this->pembatalanuangmuka_id);
		$criteria->compare('bayaruangmuka_id',$this->bayaruangmuka_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('LOWER(tglpembatalan)',strtolower($this->tglpembatalan),true);
		$criteria->compare('LOWER(keterangan_batal)',strtolower($this->keterangan_batal),true);
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
		$criteria->compare('pembatalanuangmuka_id',$this->pembatalanuangmuka_id);
		$criteria->compare('bayaruangmuka_id',$this->bayaruangmuka_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('LOWER(tglpembatalan)',strtolower($this->tglpembatalan),true);
		$criteria->compare('LOWER(keterangan_batal)',strtolower($this->keterangan_batal),true);
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