<?php

/**
 * This is the model class for table "rl4b_mobiditaspasienrj_v".
 *
 * The followings are the available columns in table 'rl4b_mobiditaspasienrj_v':
 * @property integer $profilrs_id
 * @property string $propinsi
 * @property string $kabupaten
 * @property string $koders
 * @property string $namars
 * @property string $tgl_laporan
 * @property string $dtd_kode
 * @property string $dtd_noterperinci
 * @property string $golongansebabpenyakit
 * @property string $var_0hr_6hr_l
 * @property string $var_0hr_6hr_p
 * @property string $var_6hr_28hr_l
 * @property string $var_6hr_28hr_p
 * @property string $var_28hr_1th_l
 * @property string $var_28hr_1th_p
 * @property string $var_1th_4th_l
 * @property string $var_1th_4th_p
 * @property string $var_4th_14th_l
 * @property string $var_4th_14th_p
 * @property string $var_14th_24th_l
 * @property string $var_14th_24th_p
 * @property string $var_24th_44th_l
 * @property string $var_24th_44th_p
 * @property string $var_44th_64th_l
 * @property string $var_44th_64th_p
 * @property string $var_64th_keatas_l
 * @property string $var_64th_keatas_p
 * @property string $kasusbaru_lakilaki
 * @property string $kasusbaru_perempuan
 * @property string $jumlahkasusbaru
 * @property string $jumlahkunjungan
 */
class Rl4bMobiditaspasienrjV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl4bMobiditaspasienrjV the static model class
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
		return 'rl4b_mobiditaspasienrj_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id', 'numerical', 'integerOnly'=>true),
			array('propinsi, kabupaten, koders, namars', 'length', 'max'=>50),
			array('dtd_kode', 'length', 'max'=>10),
			array('dtd_noterperinci', 'length', 'max'=>400),
			array('golongansebabpenyakit', 'length', 'max'=>255),
			array('tgl_laporan, var_0hr_6hr_l, var_0hr_6hr_p, var_6hr_28hr_l, var_6hr_28hr_p, var_28hr_1th_l, var_28hr_1th_p, var_1th_4th_l, var_1th_4th_p, var_4th_14th_l, var_4th_14th_p, var_14th_24th_l, var_14th_24th_p, var_24th_44th_l, var_24th_44th_p, var_44th_64th_l, var_44th_64th_p, var_64th_keatas_l, var_64th_keatas_p, kasusbaru_lakilaki, kasusbaru_perempuan, jumlahkasusbaru, jumlahkunjungan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('profilrs_id, propinsi, kabupaten, koders, namars, tgl_laporan, dtd_kode, dtd_noterperinci, golongansebabpenyakit, var_0hr_6hr_l, var_0hr_6hr_p, var_6hr_28hr_l, var_6hr_28hr_p, var_28hr_1th_l, var_28hr_1th_p, var_1th_4th_l, var_1th_4th_p, var_4th_14th_l, var_4th_14th_p, var_14th_24th_l, var_14th_24th_p, var_24th_44th_l, var_24th_44th_p, var_44th_64th_l, var_44th_64th_p, var_64th_keatas_l, var_64th_keatas_p, kasusbaru_lakilaki, kasusbaru_perempuan, jumlahkasusbaru, jumlahkunjungan', 'safe', 'on'=>'search'),
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
			'profilrs_id' => 'Profilrs',
			'propinsi' => 'Provinsi',
			'kabupaten' => 'Kabupaten',
			'koders' => 'Koders',
			'namars' => 'Namars',
			'tgl_laporan' => 'Tgl. Laporan',
			'dtd_kode' => 'Dtd Kode',
			'dtd_noterperinci' => 'Dtd Noterperinci',
			'golongansebabpenyakit' => 'Golongansebabpenyakit',
			'var_0hr_6hr_l' => 'Var 0hr 6hr L',
			'var_0hr_6hr_p' => 'Var 0hr 6hr P',
			'var_6hr_28hr_l' => 'Var 6hr 28hr L',
			'var_6hr_28hr_p' => 'Var 6hr 28hr P',
			'var_28hr_1th_l' => 'Var 28hr 1th L',
			'var_28hr_1th_p' => 'Var 28hr 1th P',
			'var_1th_4th_l' => 'Var 1th 4th L',
			'var_1th_4th_p' => 'Var 1th 4th P',
			'var_4th_14th_l' => 'Var 4th 14th L',
			'var_4th_14th_p' => 'Var 4th 14th P',
			'var_14th_24th_l' => 'Var 14th 24th L',
			'var_14th_24th_p' => 'Var 14th 24th P',
			'var_24th_44th_l' => 'Var 24th 44th L',
			'var_24th_44th_p' => 'Var 24th 44th P',
			'var_44th_64th_l' => 'Var 44th 64th L',
			'var_44th_64th_p' => 'Var 44th 64th P',
			'var_64th_keatas_l' => 'Var 64th Keatas L',
			'var_64th_keatas_p' => 'Var 64th Keatas P',
			'kasusbaru_lakilaki' => 'Kasusbaru Lakilaki',
			'kasusbaru_perempuan' => 'Kasusbaru Perempuan',
			'jumlahkasusbaru' => 'Jumlahkasusbaru',
			'jumlahkunjungan' => 'Jumlahkunjungan',
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

		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(propinsi)',strtolower($this->propinsi),true);
		$criteria->compare('LOWER(kabupaten)',strtolower($this->kabupaten),true);
		$criteria->compare('LOWER(koders)',strtolower($this->koders),true);
		$criteria->compare('LOWER(namars)',strtolower($this->namars),true);
		$criteria->compare('LOWER(tgl_laporan)',strtolower($this->tgl_laporan),true);
		$criteria->compare('LOWER(dtd_kode)',strtolower($this->dtd_kode),true);
		$criteria->compare('LOWER(dtd_noterperinci)',strtolower($this->dtd_noterperinci),true);
		$criteria->compare('LOWER(golongansebabpenyakit)',strtolower($this->golongansebabpenyakit),true);
		$criteria->compare('LOWER(var_0hr_6hr_l)',strtolower($this->var_0hr_6hr_l),true);
		$criteria->compare('LOWER(var_0hr_6hr_p)',strtolower($this->var_0hr_6hr_p),true);
		$criteria->compare('LOWER(var_6hr_28hr_l)',strtolower($this->var_6hr_28hr_l),true);
		$criteria->compare('LOWER(var_6hr_28hr_p)',strtolower($this->var_6hr_28hr_p),true);
		$criteria->compare('LOWER(var_28hr_1th_l)',strtolower($this->var_28hr_1th_l),true);
		$criteria->compare('LOWER(var_28hr_1th_p)',strtolower($this->var_28hr_1th_p),true);
		$criteria->compare('LOWER(var_1th_4th_l)',strtolower($this->var_1th_4th_l),true);
		$criteria->compare('LOWER(var_1th_4th_p)',strtolower($this->var_1th_4th_p),true);
		$criteria->compare('LOWER(var_4th_14th_l)',strtolower($this->var_4th_14th_l),true);
		$criteria->compare('LOWER(var_4th_14th_p)',strtolower($this->var_4th_14th_p),true);
		$criteria->compare('LOWER(var_14th_24th_l)',strtolower($this->var_14th_24th_l),true);
		$criteria->compare('LOWER(var_14th_24th_p)',strtolower($this->var_14th_24th_p),true);
		$criteria->compare('LOWER(var_24th_44th_l)',strtolower($this->var_24th_44th_l),true);
		$criteria->compare('LOWER(var_24th_44th_p)',strtolower($this->var_24th_44th_p),true);
		$criteria->compare('LOWER(var_44th_64th_l)',strtolower($this->var_44th_64th_l),true);
		$criteria->compare('LOWER(var_44th_64th_p)',strtolower($this->var_44th_64th_p),true);
		$criteria->compare('LOWER(var_64th_keatas_l)',strtolower($this->var_64th_keatas_l),true);
		$criteria->compare('LOWER(var_64th_keatas_p)',strtolower($this->var_64th_keatas_p),true);
		$criteria->compare('LOWER(kasusbaru_lakilaki)',strtolower($this->kasusbaru_lakilaki),true);
		$criteria->compare('LOWER(kasusbaru_perempuan)',strtolower($this->kasusbaru_perempuan),true);
		$criteria->compare('LOWER(jumlahkasusbaru)',strtolower($this->jumlahkasusbaru),true);
		$criteria->compare('LOWER(jumlahkunjungan)',strtolower($this->jumlahkunjungan),true);

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