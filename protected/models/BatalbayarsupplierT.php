<?php

/**
 * This is the model class for table "batalbayarsupplier_t".
 *
 * The followings are the available columns in table 'batalbayarsupplier_t':
 * @property integer $batalbayarsupplier_id
 * @property integer $ruangan_id
 * @property integer $tandabuktikeluar_id
 * @property integer $bayarkesupplier_id
 * @property string $tglbatalbayar
 * @property string $alasanbatalbayar
 * @property string $user_name_otoritasi
 * @property integer $user_id_otorisasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class BatalbayarsupplierT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BatalbayarsupplierT the static model class
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
		return 'batalbayarsupplier_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, tglbatalbayar, alasanbatalbayar', 'required'),
			array('ruangan_id, tandabuktikeluar_id, bayarkesupplier_id, user_id_otorisasi', 'numerical', 'integerOnly'=>true),
			array('user_name_otoritasi', 'length', 'max'=>50),
			array('update_time, update_loginpemakai_id', 'safe'),
                        
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('batalbayarsupplier_id, ruangan_id, tandabuktikeluar_id, bayarkesupplier_id, tglbatalbayar, alasanbatalbayar, user_name_otoritasi, user_id_otorisasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'batalbayarsupplier_id' => 'Batal Bayar Supplier',
			'ruangan_id' => 'Ruangan',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'bayarkesupplier_id' => 'Bayar ke Supplier',
			'tglbatalbayar' => 'Tanggal Batal Bayar',
			'alasanbatalbayar' => 'Alasan Batal Bayar',
			'user_name_otoritasi' => 'User Name Otoritasi',
			'user_id_otorisasi' => 'User Id Otorisasi',
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

		$criteria->compare('batalbayarsupplier_id',$this->batalbayarsupplier_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
		$criteria->compare('LOWER(tglbatalbayar)',strtolower($this->tglbatalbayar),true);
		$criteria->compare('LOWER(alasanbatalbayar)',strtolower($this->alasanbatalbayar),true);
		$criteria->compare('LOWER(user_name_otoritasi)',strtolower($this->user_name_otoritasi),true);
		$criteria->compare('user_id_otorisasi',$this->user_id_otorisasi);
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
		$criteria->compare('batalbayarsupplier_id',$this->batalbayarsupplier_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
		$criteria->compare('LOWER(tglbatalbayar)',strtolower($this->tglbatalbayar),true);
		$criteria->compare('LOWER(alasanbatalbayar)',strtolower($this->alasanbatalbayar),true);
		$criteria->compare('LOWER(user_name_otoritasi)',strtolower($this->user_name_otoritasi),true);
		$criteria->compare('user_id_otorisasi',$this->user_id_otorisasi);
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