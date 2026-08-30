<?php

/**
 * This is the model class for table "permintaandarahdet_t".
 * @author  Rusdiyanto <rusdiyanto@.com>
 * @package application.models
 * The followings are the available columns in table 'permintaandarahdet_t':
 * @property integer $permintaandarahdet_id
 * @property integer $permintaandarah_id
 * @property integer $komponendarah_id
 * @property string $indikasi_darah
 * @property integer $jml_kantong
 * @property integer $daftartindakan_id
 * @property double $tarif_satuan
 * @property string $golongandarah
 * @property string $rhesus
 * @property integer $penyiapandarah_id
 * @property integer $penyerahandarah_id
 */
class PermintaandarahdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermintaandarahdetT the static model class
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
		return 'permintaandarahdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('permintaandarah_id, indikasi_darah, jml_kantong, daftartindakan_id, tarif_satuan', 'required'),
			array('permintaandarah_id, komponendarah_id, jml_kantong, daftartindakan_id, penyiapandarah_id, penyerahandarah_id', 'numerical', 'integerOnly'=>true),
			array('tarif_satuan', 'numerical'),
			array('indikasi_darah', 'length', 'max'=>50),
			array('golongandarah', 'length', 'max'=>2),
			array('rhesus', 'length', 'max'=>20),
                        array('singkatan_komp, tglren_transfusi, sd_tglrentransfusi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglren_transfusi, sd_tglrentransfusi,permintaandarahdet_id, permintaandarah_id, komponendarah_id, indikasi_darah, jml_kantong, daftartindakan_id, tarif_satuan, golongandarah, rhesus, penyiapandarah_id, penyerahandarah_id', 'safe', 'on'=>'search'),
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
			'permintaandarahdet_id' => 'Permintaandarahdet',
			'permintaandarah_id' => 'Permintaandarah',
			'komponendarah_id' => 'Komponendarah',
			'indikasi_darah' => 'Indikasi Darah',
			'jml_kantong' => 'Jml Kantong',
			'daftartindakan_id' => 'Daftartindakan',
			'tarif_satuan' => 'Tarif Satuan',
			'golongandarah' => 'Golongandarah',
			'rhesus' => 'Rhesus',
			'penyiapandarah_id' => 'Penyiapandarah',
			'penyerahandarah_id' => 'Penyerahandarah',
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

		if(!empty($this->permintaandarahdet_id)){
			$criteria->addCondition('permintaandarahdet_id = '.$this->permintaandarahdet_id);
		}
		if(!empty($this->permintaandarah_id)){
			$criteria->addCondition('permintaandarah_id = '.$this->permintaandarah_id);
		}
		if(!empty($this->komponendarah_id)){
			$criteria->addCondition('komponendarah_id = '.$this->komponendarah_id);
		}
		$criteria->compare('LOWER(indikasi_darah)',strtolower($this->indikasi_darah),true);
		if(!empty($this->jml_kantong)){
			$criteria->addCondition('jml_kantong = '.$this->jml_kantong);
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
		}
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		if(!empty($this->penyiapandarah_id)){
			$criteria->addCondition('penyiapandarah_id = '.$this->penyiapandarah_id);
		}
		if(!empty($this->penyerahandarah_id)){
			$criteria->addCondition('penyerahandarah_id = '.$this->penyerahandarah_id);
		}

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

         /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
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