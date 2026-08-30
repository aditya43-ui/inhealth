<?php

/**
 * This is the model class for table "produksiobatdet_t".
 *
 * The followings are the available columns in table 'produksiobatdet_t':
 * @property integer $produksiobatdet_id
 * @property integer $satuankecil_id
 * @property integer $obatalkes_id
 * @property integer $obatalkesproduksi_id
 * @property integer $produksiobat_id
 * @property double $hpp
 * @property double $harganetto
 * @property double $hargasatuan
 * @property double $qtyproduksi
 * @property string $keterangan
 */
class ProduksiobatdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProduksiobatdetT the static model class
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
		return 'produksiobatdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hpp, harganetto, hargasatuan', 'required'),
			array('satuankecil_id, obatalkes_id, obatalkesproduksi_id, produksiobat_id', 'numerical', 'integerOnly'=>true),
			array('hpp, harganetto, hargasatuan, qtyproduksi', 'numerical'),
			array('keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('produksiobatdet_id, satuankecil_id, obatalkes_id, obatalkesproduksi_id, produksiobat_id, hpp, harganetto, hargasatuan, qtyproduksi, keterangan', 'safe', 'on'=>'search'),
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
			'obatalkes'=>array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'produksiobatdet_id' => 'Produksiobatdet',
			'satuankecil_id' => 'Satuankecil',
			'obatalkes_id' => 'Obatalkes',
			'obatalkesproduksi_id' => 'Obatalkesproduksi',
			'produksiobat_id' => 'Produksiobat',
			'hpp' => 'Hpp',
			'harganetto' => 'Harganetto',
			'hargasatuan' => 'Hargasatuan',
			'qtyproduksi' => 'Qtyproduksi',
			'keterangan' => 'Keterangan',
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

		$criteria->compare('produksiobatdet_id',$this->produksiobatdet_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('obatalkesproduksi_id',$this->obatalkesproduksi_id);
		$criteria->compare('produksiobat_id',$this->produksiobat_id);
		$criteria->compare('hpp',$this->hpp);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('qtyproduksi',$this->qtyproduksi);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('produksiobatdet_id',$this->produksiobatdet_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('obatalkesproduksi_id',$this->obatalkesproduksi_id);
		$criteria->compare('produksiobat_id',$this->produksiobat_id);
		$criteria->compare('hpp',$this->hpp);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('qtyproduksi',$this->qtyproduksi);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}