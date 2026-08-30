<?php

/**
 * This is the model class for table "msurveypelayanan_t".
 *
 * The followings are the available columns in table 'msurveypelayanan_t':
 * @property integer $msurveypelayanan_id
 * @property integer $pasien_id
 * @property string $tglsurveypelayanan
 * @property string $status_kepuasan
 * @property string $jenissurvey
 */
class MsurveypelayananT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MsurveypelayananT the static model class
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
		return 'msurveypelayanan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglsurveypelayanan, status_kepuasan, jenissurvey', 'required'),
			array('pasien_id', 'numerical', 'integerOnly'=>true),
			array('status_kepuasan', 'length', 'max'=>50),
			array('jenissurvey', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('msurveypelayanan_id, pasien_id, tglsurveypelayanan, status_kepuasan, jenissurvey', 'safe', 'on'=>'search'),
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
			'msurveypelayanan_id' => 'Msurveypelayanan',
			'pasien_id' => 'Pasien',
			'tglsurveypelayanan' => 'Tglsurveypelayanan',
			'status_kepuasan' => 'Status Kepuasan',
			'jenissurvey' => 'Jenisrsurvey',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('msurveypelayanan_id',$this->msurveypelayanan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglsurveypelayanan)',strtolower($this->tglsurveypelayanan),true);
		$criteria->compare('LOWER(status_kepuasan)',strtolower($this->status_kepuasan),true);
		$criteria->compare('LOWER(jenissurvey)',strtolower($this->jenissurvey),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}