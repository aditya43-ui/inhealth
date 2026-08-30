<?php

/**
 * This is the model class for table "pinjampegdet_t".
 *
 * The followings are the available columns in table 'pinjampegdet_t':
 * @property integer $pinjampegdet_id
 * @property integer $pinjamanpeg_id
 * @property integer $tandabuktibayar_id
 * @property string $tglakanbayar
 * @property integer $angsuranke
 * @property integer $bulan
 * @property string $tahun
 * @property double $jmlcicilan
 */
class PinjampegdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PinjampegdetT the static model class
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
		return 'pinjampegdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pinjamanpeg_id, tglakanbayar, angsuranke, bulan, tahun, jmlcicilan', 'required'),
			array('pinjamanpeg_id, tandabuktibayar_id, angsuranke, bulan', 'numerical', 'integerOnly'=>true),
			array('jmlcicilan', 'numerical'),
			array('tahun', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pinjampegdet_id, pinjamanpeg_id, tandabuktibayar_id, tglakanbayar, angsuranke, bulan, tahun, jmlcicilan', 'safe', 'on'=>'search'),
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
			'pinjamanpeg'=>array(self::BELONGS_TO, 'PinjamanpegT', 'pinjamanpeg_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pinjampegdet_id' => 'Pinjampegdet',
			'pinjamanpeg_id' => 'Pinjamanpeg',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'tglakanbayar' => 'Tglakanbayar',
			'angsuranke' => 'Angsuranke',
			'bulan' => 'Bulan',
			'tahun' => 'Tahun',
			'jmlcicilan' => 'Jmlcicilan',
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

		$criteria->compare('pinjampegdet_id',$this->pinjampegdet_id);
		$criteria->compare('pinjamanpeg_id',$this->pinjamanpeg_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('tglakanbayar',$this->tglakanbayar);
		$criteria->compare('angsuranke',$this->angsuranke);
		$criteria->compare('bulan',$this->bulan);
		$criteria->compare('LOWER(tahun)',strtolower($this->tahun),true);
		$criteria->compare('jmlcicilan',$this->jmlcicilan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pinjampegdet_id',$this->pinjampegdet_id);
		$criteria->compare('pinjamanpeg_id',$this->pinjamanpeg_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('tglakanbayar',$this->tglakanbayar);
		$criteria->compare('angsuranke',$this->angsuranke);
		$criteria->compare('bulan',$this->bulan);
		$criteria->compare('LOWER(tahun)',strtolower($this->tahun),true);
		$criteria->compare('jmlcicilan',$this->jmlcicilan);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}