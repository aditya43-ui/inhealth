<?php

/**
 * This is the model class for table "harikerjagol_m".
 *
 * The followings are the available columns in table 'harikerjagol_m':
 * @property integer $harikerjagol_id
 * @property integer $kelompokpegawai_id
 * @property string $periodeharikerjaawl
 * @property string $periodehariakhir
 * @property string $periodeharikerjaakhir
 * @property integer $jmlharibln
 * @property boolean $harikerjagol_aktif
 */
class HariKerjaGolM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HariKerjaGolM the static model class
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
		return 'harikerjagol_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokpegawai_id, periodeharikerjaawl, periodeharikerjaakhir', 'required'),
			array('kelompokpegawai_id, jmlharibln', 'numerical', 'integerOnly'=>true),
			array('periodeharikerjaakhir, harikerjagol_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('harikerjagol_id, kelompokpegawai_id, periodeharikerjaawl, periodehariakhir, periodeharikerjaakhir, jmlharibln, harikerjagol_aktif', 'safe', 'on'=>'search'),
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
                    'kelompokpegawai'=>array(self::BELONGS_TO,'KelompokpegawaiM','kelompokpegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'harikerjagol_id' => 'ID',
			'kelompokpegawai_id' => 'Kelompok Pegawai',
			'periodeharikerjaawl' => 'Hari',
			'periodehariakhir' => 'Periode Hari Akhir',
			'periodeharikerjaakhir' => 'Sampai Dengan',
			'jmlharibln' => 'Jumlah Hari Bulan',
			'harikerjagol_aktif' => 'Aktif',
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

		$criteria->compare('harikerjagol_id',$this->harikerjagol_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		//$criteria->compare('periodeharikerjaawl',  MyFormatter::formatDateTimeForDb($this->periodeharikerjaawl));
		//$criteria->compare('periodehariakhir',  MyFormatter::formatDateTimeForDb($this->periodehariakhir));
		//$criteria->compare('periodeharikerjaakhir',  MyFormatter::formatDateTimeForDb($this->periodeharikerjaakhir));
		$criteria->compare('periodeharikerjaawl',  $this->periodeharikerjaawl);		
		$criteria->compare('periodeharikerjaakhir',  $this->periodeharikerjaakhir);
		$criteria->compare('jmlharibln',$this->jmlharibln);
		$criteria->compare('harikerjagol_aktif', isset($this->harikerjagol_aktif)?$this->harikerjagol_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('harikerjagol_id',$this->harikerjagol_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('periodeharikerjaawl',  $this->periodeharikerjaawl);		
		$criteria->compare('periodeharikerjaakhir',  $this->periodeharikerjaakhir);
		
		$criteria->compare('jmlharibln',$this->jmlharibln);
		$criteria->compare('harikerjagol_aktif', isset($this->harikerjagol_aktif)?$this->harikerjagol_aktif:true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}