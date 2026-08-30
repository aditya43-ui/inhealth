<?php

/**
 * This is the model class for table "intervensiaskep_t".
 *
 * The followings are the available columns in table 'intervensiaskep_t':
 * @property integer $intervensiaskep_id
 * @property integer $rencanakeperawatan_id
 * @property integer $asuhankeperawatan_id
 * @property string $tglmulaiintervensi
 * @property string $intervensi_kode
 * @property string $intervensi_nama
 * @property string $intervensi_rasionalisasi
 * @property integer $lama_waktu_jam
 * @property boolean $iskolaborasi
 */
class IntervensiaskepT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IntervensiaskepT the static model class
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
		return 'intervensiaskep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglmulaiintervensi, intervensi_kode, intervensi_nama', 'required'),
			array('rencanakeperawatan_id, asuhankeperawatan_id, lama_waktu_jam', 'numerical', 'integerOnly'=>true),
			array('intervensi_kode', 'length', 'max'=>20),
			array('intervensi_rasionalisasi, iskolaborasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('intervensiaskep_id, rencanakeperawatan_id, asuhankeperawatan_id, tglmulaiintervensi, intervensi_kode, intervensi_nama, intervensi_rasionalisasi, lama_waktu_jam, iskolaborasi', 'safe', 'on'=>'search'),
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
                    'rencanakeperawatan'=>array(self::BELONGS_TO, 'RencanakeperawatanM', 'rencanakeperawatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'intervensiaskep_id' => 'Intervensiaskep',
			'rencanakeperawatan_id' => 'Rencanakeperawatan',
			'asuhankeperawatan_id' => 'Asuhankeperawatan',
			'tglmulaiintervensi' => 'Tglmulaiintervensi',
			'intervensi_kode' => 'Intervensi Kode',
			'intervensi_nama' => 'Intervensi Nama',
			'intervensi_rasionalisasi' => 'Intervensi Rasionalisasi',
			'lama_waktu_jam' => 'Lama Waktu Jam',
			'iskolaborasi' => 'Iskolaborasi',
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

		$criteria->compare('intervensiaskep_id',$this->intervensiaskep_id);
		$criteria->compare('rencanakeperawatan_id',$this->rencanakeperawatan_id);
		$criteria->compare('asuhankeperawatan_id',$this->asuhankeperawatan_id);
		$criteria->compare('LOWER(tglmulaiintervensi)',strtolower($this->tglmulaiintervensi),true);
		$criteria->compare('LOWER(intervensi_kode)',strtolower($this->intervensi_kode),true);
		$criteria->compare('LOWER(intervensi_nama)',strtolower($this->intervensi_nama),true);
		$criteria->compare('LOWER(intervensi_rasionalisasi)',strtolower($this->intervensi_rasionalisasi),true);
		$criteria->compare('lama_waktu_jam',$this->lama_waktu_jam);
		$criteria->compare('iskolaborasi',$this->iskolaborasi);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('intervensiaskep_id',$this->intervensiaskep_id);
		$criteria->compare('rencanakeperawatan_id',$this->rencanakeperawatan_id);
		$criteria->compare('asuhankeperawatan_id',$this->asuhankeperawatan_id);
		$criteria->compare('LOWER(tglmulaiintervensi)',strtolower($this->tglmulaiintervensi),true);
		$criteria->compare('LOWER(intervensi_kode)',strtolower($this->intervensi_kode),true);
		$criteria->compare('LOWER(intervensi_nama)',strtolower($this->intervensi_nama),true);
		$criteria->compare('LOWER(intervensi_rasionalisasi)',strtolower($this->intervensi_rasionalisasi),true);
		$criteria->compare('lama_waktu_jam',$this->lama_waktu_jam);
		$criteria->compare('iskolaborasi',$this->iskolaborasi);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}