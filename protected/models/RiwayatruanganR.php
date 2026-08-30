<?php

/**
 * This is the model class for table "riwayatruangan_r".
 *
 * The followings are the available columns in table 'riwayatruangan_r':
 * @property integer $riwayatruangan_id
 * @property string $tglpenetapanruangan
 * @property string $nopenetapanruangan
 * @property string $tentangpenetapan
 */
class RiwayatruanganR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatruanganR the static model class
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
		return 'riwayatruangan_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpenetapanruangan, nopenetapanruangan', 'required'),
			array('nopenetapanruangan', 'length', 'max'=>50),
			array('tentangpenetapan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riwayatruangan_id, tglpenetapanruangan, nopenetapanruangan, tentangpenetapan', 'safe', 'on'=>'search'),
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
			'riwayatruangan_id' => 'ID',
			'tglpenetapanruangan' => 'Tanggal Penetapan',
			'nopenetapanruangan' => 'No. Penetapan',
			'tentangpenetapan' => 'Tentang Penetapan',
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

		$criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('LOWER(tglpenetapanruangan)',strtolower($this->tglpenetapanruangan),true);
		$criteria->compare('LOWER(nopenetapanruangan)',strtolower($this->nopenetapanruangan),true);
		$criteria->compare('LOWER(tentangpenetapan)',strtolower($this->tentangpenetapan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('LOWER(tglpenetapanruangan)',strtolower($this->tglpenetapanruangan),true);
		$criteria->compare('LOWER(nopenetapanruangan)',strtolower($this->nopenetapanruangan),true);
		$criteria->compare('LOWER(tentangpenetapan)',strtolower($this->tentangpenetapan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}