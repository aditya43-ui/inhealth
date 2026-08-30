<?php

/**
 * This is the model class for table "bayarangsuranpelayanan_t".
 *
 * The followings are the available columns in table 'bayarangsuranpelayanan_t':
 * @property integer $bayarangsuranpelayanan_id
 * @property integer $tandabuktibayar_id
 * @property integer $pembayaranpelayanan_id
 * @property string $tglbayarangsuran
 * @property integer $bayarke
 * @property double $jmlbayarangsuran
 * @property double $sisaangsuran
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class BayarangsuranpelayananT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BayarangsuranpelayananT the static model class
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
		return 'bayarangsuranpelayanan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tandabuktibayar_id, pembayaranpelayanan_id, tglbayarangsuran, jmlbayarangsuran, sisaangsuran', 'required'),
			array('tandabuktibayar_id, pembayaranpelayanan_id, bayarke', 'numerical', 'integerOnly'=>true),
			array('jmlbayarangsuran, sisaangsuran, jmltelahbayar', 'numerical'),
			array('update_time, update_loginpemakai_id', 'safe'),
                    
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bayarangsuranpelayanan_id, tandabuktibayar_id, pembayaranpelayanan_id, tglbayarangsuran, bayarke, jmlbayarangsuran, sisaangsuran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jmltelahbayar', 'safe', 'on'=>'search'),
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
			'bayarangsuranpelayanan_id' => 'Bayarangsuranpelayanan',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'tglbayarangsuran' => 'Tanggal Bayar Angsuran',
			'bayarke' => 'Angsuran Ke',
			'jmlbayarangsuran' => 'Jumlah Bayar Angsuran',
			'sisaangsuran' => 'Sisa Angsuran',
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

		$criteria->compare('bayarangsuranpelayanan_id',$this->bayarangsuranpelayanan_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('LOWER(tglbayarangsuran)',strtolower($this->tglbayarangsuran),true);
		$criteria->compare('bayarke',$this->bayarke);
		$criteria->compare('jmlbayarangsuran',$this->jmlbayarangsuran);
		$criteria->compare('sisaangsuran',$this->sisaangsuran);
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
		$criteria->compare('bayarangsuranpelayanan_id',$this->bayarangsuranpelayanan_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('LOWER(tglbayarangsuran)',strtolower($this->tglbayarangsuran),true);
		$criteria->compare('bayarke',$this->bayarke);
		$criteria->compare('jmlbayarangsuran',$this->jmlbayarangsuran);
		$criteria->compare('sisaangsuran',$this->sisaangsuran);
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