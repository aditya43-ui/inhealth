<?php

/**
 * This is the model class for table "penawarandetail_t".
 *
 * The followings are the available columns in table 'penawarandetail_t':
 * @property integer $penawarandetail_id
 * @property integer $satuankecil_id
 * @property integer $satuanbesar_id
 * @property integer $sumberdana_id
 * @property integer $obatalkes_id
 * @property integer $permintaanpenawaran_id
 * @property double $qty
 * @property double $harganetto
 * @property double $kemasanbesar
 * @property double $hargabelibesar
 */
class PenawarandetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenawarandetailT the static model class
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
		return 'penawarandetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('permintaanpenawaran_id, qty, harganetto', 'required'),
			array('satuankecil_id, satuanbesar_id, sumberdana_id, obatalkes_id, permintaanpenawaran_id', 'numerical', 'integerOnly'=>true),
			array('hargabelibesar,kemasanbesar,qty, harganetto', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hargabelibesar,kemasanbesar,penawarandetail_id, satuankecil_id, satuanbesar_id, sumberdana_id, obatalkes_id, permintaanpenawaran_id, qty, harganetto', 'safe', 'on'=>'search'),
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
                    'satuanbesar'=>array(self::BELONGS_TO, 'SatuanbesarM','satuanbesar_id'),
                    'sumberdana'=>array(self::BELONGS_TO, 'SumberdanaM','sumberdana_id'),
                    'satuankecil'=>array(self::BELONGS_TO, 'SatuankecilM','satuankecil_id'),
                    'obatalkes'=>array(self::BELONGS_TO, 'ObatalkesM','obatalkes_id'),
                    'permintaanpenawaran'=>array(self::BELONGS_TO, 'PermintaanpenawaranT', 'permintaanpenawaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penawarandetail_id' => 'Penawarandetail',
			'satuankecil_id' => 'Satuankecil',
			'satuanbesar_id' => 'Satuanbesar',
			'sumberdana_id' => 'Sumberdana',
			'obatalkes_id' => 'Obatalkes',
			'permintaanpenawaran_id' => 'Permintaanpenawaran',
			'qty' => 'Jumlah',
			'harganetto' => 'Harganetto',
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

		$criteria->compare('penawarandetail_id',$this->penawarandetail_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('permintaanpenawaran_id',$this->permintaanpenawaran_id);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('harganetto',$this->harganetto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('penawarandetail_id',$this->penawarandetail_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('permintaanpenawaran_id',$this->permintaanpenawaran_id);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('harganetto',$this->harganetto);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}