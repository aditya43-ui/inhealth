<?php

/**
 * This is the model class for table "dtd_m".
 *
 * The followings are the available columns in table 'dtd_m':
 * @property integer $dtd_id
 * @property integer $tabularlist_id
 * @property string $dtd_kode
 * @property string $dtd_noterperinci
 * @property string $dtd_nama
 * @property string $dtd_namalainnya
 * @property string $dtd_katakunci
 * @property integer $dtd_nourut
 * @property boolean $dtd_menular
 * @property boolean $dtd_aktif
 */
class DtdM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DtdM the static model class
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
		return 'dtd_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dtd_kode, dtd_noterperinci, dtd_nama', 'required'),
			array('tabularlist_id, dtd_nourut', 'numerical', 'integerOnly'=>true),
			array('dtd_kode', 'length', 'max'=>10),
			array('dtd_noterperinci, dtd_nama, dtd_namalainnya, dtd_katakunci', 'length', 'max'=>50),
			array('dtd_menular, dtd_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dtd_id, tabularlist_id, dtd_kode, dtd_noterperinci, dtd_nama, dtd_namalainnya, dtd_katakunci, dtd_nourut, dtd_menular, dtd_aktif', 'safe', 'on'=>'search'),
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
			'dtd_id' => 'ID',
			'tabularlist_id' => 'Tabular List',
			'dtd_kode' => 'Kode',
			'dtd_noterperinci' => 'No. Terperinci',
			'dtd_nama' => 'Nama',
			'dtd_namalainnya' => 'Nama Lainnya',
			'dtd_katakunci' => 'Kata Kunci',
			'dtd_nourut' => 'No. Urut',
			'dtd_menular' => 'Menular',
			'dtd_aktif' => 'Aktif',
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

		$criteria->compare('dtd_id',$this->dtd_id);
		$criteria->compare('tabularlist_id',$this->tabularlist_id);
		$criteria->compare('LOWER(dtd_kode)',strtolower($this->dtd_kode),true);
		$criteria->compare('LOWER(dtd_noterperinci)',strtolower($this->dtd_noterperinci),true);
		$criteria->compare('LOWER(dtd_nama)',strtolower($this->dtd_nama),true);
		$criteria->compare('LOWER(dtd_namalainnya)',strtolower($this->dtd_namalainnya),true);
		$criteria->compare('LOWER(dtd_katakunci)',strtolower($this->dtd_katakunci),true);
		$criteria->compare('dtd_nourut',$this->dtd_nourut);
		//$criteria->compare('dtd_menular',isset($this->dtd_menular)?$this->dtd_menular:true);
		$criteria->compare('dtd_aktif',isset($this->dtd_aktif)?$this->dtd_aktif:true);
                $criteria->order = "dtd_kode ASC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('dtd_id',$this->dtd_id);
		$criteria->compare('tabularlist_id',$this->tabularlist_id);
		$criteria->compare('LOWER(dtd_kode)',strtolower($this->dtd_kode),true);
		$criteria->compare('LOWER(dtd_noterperinci)',strtolower($this->dtd_noterperinci),true);
		$criteria->compare('LOWER(dtd_nama)',strtolower($this->dtd_nama),true);
		$criteria->compare('LOWER(dtd_namalainnya)',strtolower($this->dtd_namalainnya),true);
		$criteria->compare('LOWER(dtd_katakunci)',strtolower($this->dtd_katakunci),true);
		$criteria->compare('dtd_nourut',$this->dtd_nourut);
                $criteria->compare('dtd_aktif',isset($this->dtd_aktif)?$this->dtd_aktif:true);
//		$criteria->compare('dtd_menular',$this->dtd_menular);
//		$criteria->compare('dtd_aktif',$this->dtd_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
         public function beforeSave() {
            $this->dtd_nama = ucwords(strtolower($this->dtd_nama));
            $this->dtd_namalainnya = strtoupper($this->dtd_namalainnya);
            $this->dtd_katakunci = strtoupper($this->dtd_katakunci);

            return parent::beforeSave();
        }
        
        public function getDiagnosaItems()
        {
//            return DiagnosaM::model()->findAll(array('order'=>'diagnosa_nama'));
            return Yii::app()->db->createCommand('SELECT diagnosa_id, diagnosa_nama FROM diagnosa_m WHERE diagnosa_aktif=TRUE')->queryAll();
        }
        
        /**
         * Mengambil daftar semua propinsi
         * @return CActiveDataProvider 
         */
        public function getTabularItems()
        {
            return SATabularListM::model()->findAll(array('order'=>'tabularlist_block'),array('tabularlist_aktif'=>TRUE));
           // return Yii::app()->db->createCommand('SELECT tabularlist_id, tabularlist_block FROM tabularlist_m WHERE tabularlist_aktif=TRUE')->queryAll();
        }
        
        public function getDiagnosaformItems()
        {
//            return DiagnosaM::model()->findAll('diagnosa_aktif=TRUE ORDER BY diagnosa_nama');
            return Yii::app()->db->createCommand('SELECT diagnosa_id, diagnosa_nama FROM diagnosa_m WHERE diagnosa_aktif=TRUE')->queryAll();
        }
}