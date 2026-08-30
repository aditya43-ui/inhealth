<?php

/**
 * This is the model class for table "laporanjmlpasienhariangizi_v".
 *
 * The followings are the available columns in table 'laporanjmlpasienhariangizi_v':
 * @property string $tglkirimmenu
 * @property integer $jenisdiet_id
 * @property string $jenisdiet_nama
 * @property integer $kirimmenudiet_id
 * @property integer $jeniswaktu_id
 * @property string $jeniswaktu_nama
 * @property string $jml_kirim
 */
class LaporanjmlpasienhariangiziV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanjmlpasienhariangiziV the static model class
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
		return 'laporanjmlpasienhariangizi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisdiet_id, kirimmenudiet_id, jeniswaktu_id', 'numerical', 'integerOnly'=>true),
			array('jenisdiet_nama, jeniswaktu_nama', 'length', 'max'=>50),
			array('tglkirimmenu, jml_kirim', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglkirimmenu, jenisdiet_id, jenisdiet_nama, kirimmenudiet_id, jeniswaktu_id, jeniswaktu_nama, jml_kirim', 'safe', 'on'=>'search'),
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
			'tglkirimmenu' => 'Tanggal Kirim Menu',
			'jenisdiet_id' => 'Jenis Diet',
			'jenisdiet_nama' => 'Jenis Diet',
			'kirimmenudiet_id' => 'Kirim Menu Diet',
			'jeniswaktu_id' => 'Jenis Waktu',
			'jeniswaktu_nama' => 'Jenis Waktu',
			'jml_kirim' => 'Jml',
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

		$criteria->compare('LOWER(tglkirimmenu)',strtolower($this->tglkirimmenu),true);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('LOWER(jeniswaktu_nama)',strtolower($this->jeniswaktu_nama),true);
		$criteria->compare('LOWER(jml_kirim)',strtolower($this->jml_kirim),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('LOWER(tglkirimmenu)',strtolower($this->tglkirimmenu),true);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('LOWER(jeniswaktu_nama)',strtolower($this->jeniswaktu_nama),true);
		$criteria->compare('LOWER(jml_kirim)',strtolower($this->jml_kirim),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}