<?php

/**
 * This is the model class for table "jeniskasuspenyakit_m".
 *
 * The followings are the available columns in table 'jeniskasuspenyakit_m':
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property string $jeniskasuspenyakit_namalainnya
 * @property boolean $jeniskasuspenyakit_aktif
 */
class JeniskasuspenyakitM extends CActiveRecord
{
    public $statusrawat_kemenkes_nama,$jmlpasien;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JeniskasuspenyakitM the static model class
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
		return 'jeniskasuspenyakit_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskasuspenyakit_nama', 'required'),
			array('jeniskasuspenyakit_nama, jeniskasuspenyakit_namalainnya', 'length', 'max'=>100),
            array('statusrawat_kemenkes', 'length', 'max'=>50),
			array('jeniskasuspenyakit_aktif,jeniskasuspenyakit_urutan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jeniskasuspenyakit_id, jeniskasuspenyakit_nama,jeniskasuspenyakit_urutan, jeniskasuspenyakit_namalainnya, jeniskasuspenyakit_aktif, statusrawat_kemenkes', 'safe', 'on'=>'search'),
                        array('jeniskasuspenyakit_urutan','numerical')
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
                            'pendaftaran' => array(self::HAS_MANY, 'PendaftaranT', 'jeniskasuspenyakit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jeniskasuspenyakit_id' => 'Kasus Penyakit',
			'jeniskasuspenyakit_nama' => 'Nama Kasus Penyakit',
			'jeniskasuspenyakit_namalainnya' => 'Nama Lainnya',
			'jeniskasuspenyakit_aktif' => 'Aktif',
			'ruangan_id' => 'Ruangan',
			'jeniskasuspenyakit_urutan'=>'Urutan',
            'statusrawat_kemenkes'=>'Status Rawat Kemenkes'
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

		$criteria->compare('t.jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('LOWER(t.jeniskasuspenyakit_namalainnya)',strtolower($this->jeniskasuspenyakit_namalainnya),true);
		$criteria->compare('t.jeniskasuspenyakit_urutan',$this->jeniskasuspenyakit_urutan);
		$criteria->compare('t.jeniskasuspenyakit_aktif',isset($this->jeniskasuspenyakit_aktif)?$this->jeniskasuspenyakit_aktif:true);
//                $criteria->addCondition('jeniskasuspenyakit_aktif is true');
		if (!empty($this->ruangan_id)) {
			# code...
			$criteria->join = 'JOIN kasuspenyakitruangan_m ON t.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id 
			JOIN ruangan_m ON kasuspenyakitruangan_m.ruangan_id = ruangan_m.ruangan_id';
			$criteria->addCondition('ruangan_m.ruangan_id ='.$this->ruangan_id);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('LOWER(jeniskasuspenyakit_namalainnya)',strtolower($this->jeniskasuspenyakit_namalainnya),true);
//		$criteria->compare('jeniskasuspenyakit_aktif',$this->jeniskasuspenyakit_aktif);
                $criteria->limit=-1;
                $criteria->order='jeniskasuspenyakit_nama';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        public function beforeSave() {
            $this->jeniskasuspenyakit_nama = ucwords(strtolower($this->jeniskasuspenyakit_nama));
            $this->jeniskasuspenyakit_namalainnya = strtoupper($this->jeniskasuspenyakit_namalainnya);
            return parent::beforeSave();
        }
        
          public function getJenisKasusPenyakitItems()
                {
                    return JeniskasuspenyakitM::model()->findAll("jeniskasuspenyakit_aktif = TRUE ORDER BY jeniskasuspenyakit_nama");
                }
                
        /**
         * 
         * @return type
         */
        public static function getDropList(){
            $cri = new CDbCriteria();
            $cri->group = " jeniskasuspenyakit_id, jeniskasuspenyakit_nama ";     
            $cri->addCondition(" jeniskasuspenyakit_aktif = true ");
            $cri->order = " jeniskasuspenyakit_nama ASC ";
            $model = self::model()->findAll($cri);
            
            $arr = array();
            foreach($model as $d){
                $arr[$d->jeniskasuspenyakit_id] = $d->jeniskasuspenyakit_nama;
            }
            
            return $arr;
        }
}