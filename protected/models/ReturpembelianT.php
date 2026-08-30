<?php

/**
 * This is the model class for table "returpembelian_t".
 *
 * The followings are the available columns in table 'returpembelian_t':
 * @property integer $returpembelian_id
 * @property integer $supplier_id
 * @property integer $fakturpembelian_id
 * @property integer $ruangan_id
 * @property string $tglretur
 * @property string $noretur
 * @property string $alasanretur
 * @property string $keteranganretur
 * @property double $totalretur
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class ReturpembelianT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturpembelianT the static model class
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
		return 'returpembelian_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_id, ruangan_id, tglretur, noretur, alasanretur, totalretur', 'required'),
			array('supplier_id, fakturpembelian_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('totalretur', 'numerical'),
			array('noretur', 'length', 'max'=>50),
			array('keteranganretur, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			// Please remove those attributes that should not be searched.
			array('returpembelian_id, supplier_id, fakturpembelian_id, ruangan_id, tglretur, noretur, alasanretur, keteranganretur, totalretur, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'returpembelian_id' => 'Retur Pembelian',
			'supplier_id' => 'Supplier',
			'fakturpembelian_id' => 'Faktur Pembelian',
			'ruangan_id' => 'Ruangan',
			'tglretur' => 'Tanggal Retur',
			'noretur' => 'No. Retur',
			'alasanretur' => 'Alasan Retur',
			'keteranganretur' => 'Keterangan Retur',
			'totalretur' => 'Total Retur',
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

		$criteria->compare('returpembelian_id',$this->returpembelian_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(tglretur)',strtolower($this->tglretur),true);
		$criteria->compare('LOWER(noretur)',strtolower($this->noretur),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('totalretur',$this->totalretur);
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
		$criteria->compare('returpembelian_id',$this->returpembelian_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(tglretur)',strtolower($this->tglretur),true);
		$criteria->compare('LOWER(noretur)',strtolower($this->noretur),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('totalretur',$this->totalretur);
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