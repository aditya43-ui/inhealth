<?php

/**
 * This is the model class for table "kelaspelayanan_m".
 *
 * The followings are the available columns in table 'kelaspelayanan_m':
 * @property integer $kelaspelayanan_id
 * @property integer $jeniskelas_id
 * @property string $kelaspelayanan_nama
 * @property string $kelaspelayanan_namalainnya
 * @property boolean $kelaspelayanan_aktif
 * @property double $persentasirujin
 * @property string $kelasbpjs_id
 * @property string $kelasnaikbpjs_id
 */

class KelaspelayananM extends CActiveRecord
{
    public $jeniskelas_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelaspelayananM the static model class
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
		return 'kelaspelayanan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskelas_id, kelaspelayanan_nama, kelaspelayanan_aktif', 'required'),
			array('jeniskelas_id', 'numerical', 'integerOnly'=>true),
                        array('persentasirujin', 'numerical'),
			array('kelaspelayanan_nama, kelaspelayanan_namalainnya', 'length', 'max'=>50),
			array('urutankelas, kelasbpjs_id, kelasnaikbpjs_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('persentasirujin, kelaspelayanan_id, jeniskelas_nama, kelaspelayanan_nama, kelaspelayanan_namalainnya, kelaspelayanan_aktif', 'safe', 'on'=>'search'),
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
			'jeniskelas' => array(self::BELONGS_TO, 'JeniskelasM', 'jeniskelas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kelaspelayanan_id' => 'ID',
			'jeniskelas_id' => 'Jenis kelas',
			'kelaspelayanan_nama' => 'Kelas Pelayanan',
			'kelaspelayanan_namalainnya' => 'Nama Lainnya',
			'kelaspelayanan_aktif' => 'Aktif',
                        'jeniskelas_nama' => 'Jenis Kelas',
                        'persentasirujin' => 'Persen Rujukan',
			'urutankelas' => 'Urutan Kelas',
			'kelasbpjs_id' => 'ID Kelas BPJS',
			'kelasnaikbpjs_id' => 'ID Naik Kelas BPJS',
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

		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('jeniskelas_id',$this->jeniskelas_id);
                $criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
                $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('kelaspelayanan_aktif',isset($this->kelaspelayanan_aktif)?$this->kelaspelayanan_aktif:true);
                $criteria->compare('persentasirujin',$this->persentasirujin);
//                $criteria->addCondition('kelaspelayanan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('t.jeniskelas_id',$this->jeniskelas_id);
                $criteria->compare('LOWER(jeniskelas.jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
                $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
//		$criteria->compare('kelaspelayanan_aktif',$this->kelaspelayanan_aktif);
                $criteria->limit=-1;
                $criteria->order='jeniskelas.jeniskelas_nama,kelaspelayanan_nama';
                $criteria->with = array('jeniskelas');

		return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                        ));
	}
        
        public function beforeSave() {
            $this->kelaspelayanan_nama = $this->kelaspelayanan_nama;
            $this->kelaspelayanan_namalainnya = strtoupper($this->kelaspelayanan_namalainnya);
            return parent::beforeSave();
        }
        
        public function getJenisKelasItems()
        {
            return JeniskelasM::model()->findAll("jeniskelas_aktif = TRUE ORDER BY jeniskelas_nama");
        }
        
        public function getItems(){
            $criteria = new CDbCriteria();
            $criteria->addCondition('kelaspelayanan_aktif = TRUE');
            $criteria->order = 'kelaspelayanan_nama ASC';
            $model = $this->model()->findAll($criteria);
            if(count((array)$model) > 0){
                return $model;
            }else{
                return array();
            }
        }
        
        /**
         * 
         * @return type
         */
        public static function getDropList(){
            $cri = new CDbCriteria();
            $cri->group = " kelaspelayanan_id, kelaspelayanan_nama ";     
            $cri->addCondition(" kelaspelayanan_aktif = true ");
            $cri->order = " kelaspelayanan_nama ASC ";
            $model = self::model()->findAll($cri);
            
            $arr = array();
            foreach($model as $d){
                $arr[$d->kelaspelayanan_id] = $d->kelaspelayanan_nama;
            }
            
            return $arr;
        }
}