<?php

/**
 * This is the model class for table "rl3_14_kegiatanrujukan_v".
 *
 * The followings are the available columns in table 'rl3_14_kegiatanrujukan_v':
 * @property string $tgl_laporan
 * @property string $propinsi
 * @property string $koders
 * @property integer $profilrs_id
 * @property string $kabupaten
 * @property string $namars
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property string $rujukan_puskesmas
 * @property string $rujukan_faskeslain
 * @property string $rujukan_rslain
 * @property string $rujukan_dikembalikan_ke_puskesmas
 * @property string $rujukan_dikembalikan_ke_faskeslain
 * @property string $rujukan_dikembalikan_ke_rs_asal
 * @property string $dirujuk_pasienrujukan
 * @property string $dirujuk_pasiennonrujukan
 * @property string $dirujuk_diterimakembali
 */
class Rl314KegiatanrujukanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl314KegiatanrujukanV the static model class
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
		return 'rl3_14_kegiatanrujukan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, jeniskasuspenyakit_id', 'numerical', 'integerOnly'=>true),
			array('propinsi, koders, kabupaten, namars', 'length', 'max'=>50),
			array('jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('tgl_laporan, rujukan_puskesmas, rujukan_faskeslain, rujukan_rslain, rujukan_dikembalikan_ke_puskesmas, rujukan_dikembalikan_ke_faskeslain, rujukan_dikembalikan_ke_rs_asal, dirujuk_pasienrujukan, dirujuk_pasiennonrujukan, dirujuk_diterimakembali', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_laporan, propinsi, koders, profilrs_id, kabupaten, namars, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, rujukan_puskesmas, rujukan_faskeslain, rujukan_rslain, rujukan_dikembalikan_ke_puskesmas, rujukan_dikembalikan_ke_faskeslain, rujukan_dikembalikan_ke_rs_asal, dirujuk_pasienrujukan, dirujuk_pasiennonrujukan, dirujuk_diterimakembali', 'safe', 'on'=>'search'),
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
			'tgl_laporan' => 'Tgl. Laporan',
			'propinsi' => 'Provinsi',
			'koders' => 'Koders',
			'profilrs_id' => 'Profilrs',
			'kabupaten' => 'Kabupaten',
			'namars' => 'Namars',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'rujukan_puskesmas' => 'Rujukan Puskesmas',
			'rujukan_faskeslain' => 'Rujukan Faskeslain',
			'rujukan_rslain' => 'Rujukan Rslain',
			'rujukan_dikembalikan_ke_puskesmas' => 'Rujukan Dikembalikan Ke Puskesmas',
			'rujukan_dikembalikan_ke_faskeslain' => 'Rujukan Dikembalikan Ke Faskeslain',
			'rujukan_dikembalikan_ke_rs_asal' => 'Rujukan Dikembalikan Ke Rs Asal',
			'dirujuk_pasienrujukan' => 'Dirujuk Pasienrujukan',
			'dirujuk_pasiennonrujukan' => 'Dirujuk Pasiennonrujukan',
			'dirujuk_diterimakembali' => 'Dirujuk Diterimakembali',
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

		$criteria->compare('LOWER(tgl_laporan)',strtolower($this->tgl_laporan),true);
		$criteria->compare('LOWER(propinsi)',strtolower($this->propinsi),true);
		$criteria->compare('LOWER(koders)',strtolower($this->koders),true);
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(kabupaten)',strtolower($this->kabupaten),true);
		$criteria->compare('LOWER(namars)',strtolower($this->namars),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('LOWER(rujukan_puskesmas)',strtolower($this->rujukan_puskesmas),true);
		$criteria->compare('LOWER(rujukan_faskeslain)',strtolower($this->rujukan_faskeslain),true);
		$criteria->compare('LOWER(rujukan_rslain)',strtolower($this->rujukan_rslain),true);
		$criteria->compare('LOWER(rujukan_dikembalikan_ke_puskesmas)',strtolower($this->rujukan_dikembalikan_ke_puskesmas),true);
		$criteria->compare('LOWER(rujukan_dikembalikan_ke_faskeslain)',strtolower($this->rujukan_dikembalikan_ke_faskeslain),true);
		$criteria->compare('LOWER(rujukan_dikembalikan_ke_rs_asal)',strtolower($this->rujukan_dikembalikan_ke_rs_asal),true);
		$criteria->compare('LOWER(dirujuk_pasienrujukan)',strtolower($this->dirujuk_pasienrujukan),true);
		$criteria->compare('LOWER(dirujuk_pasiennonrujukan)',strtolower($this->dirujuk_pasiennonrujukan),true);
		$criteria->compare('LOWER(dirujuk_diterimakembali)',strtolower($this->dirujuk_diterimakembali),true);

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