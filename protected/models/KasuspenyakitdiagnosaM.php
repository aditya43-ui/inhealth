<?php

/**
 * This is the model class for table "kasuspenyakitdiagnosa_m".
 *
 * The followings are the available columns in table 'kasuspenyakitdiagnosa_m':
 * @property integer $jeniskasuspenyakit_id
 * @property integer $diagnosa_id
 */
class KasuspenyakitdiagnosaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KasuspenyakitdiagnosaM the static model class
	 */
        public $diagnosa_nama,$diagnosa_namalainnya,$jeniskasuspenyakit_nama, $diagnosa_kode;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kasuspenyakitdiagnosa_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskasuspenyakit_id, diagnosa_id', 'required'),
                        array('jeniskasuspenyakit_id, diagnosa_id', 'cekdata'),
			array('jeniskasuspenyakit_id, diagnosa_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('diagnosa_kode, jeniskasuspenyakit_id, diagnosa_id, diagnosa_nama, diagnosa_namalainnya, jeniskasuspenyakit_nama', 'safe', 'on'=>'search'),
		);
	}
        
                public function cekdata($attribute, $params)
                {
                    $querydata = KasuspenyakitdiagnosaM::model()->findAllByAttributes(array('jeniskasuspenyakit_id'=>$this->jeniskasuspenyakit_id, 'diagnosa_id'=>$this->diagnosa_id));
                    if (!$this->hasErrors()) {
                        if (count((array)$querydata) > 0)
                        {
                            $this->addError('jeniskasuspenyakit_id, diagnosa_id', 'Kasus '.$this->jeniskasuspenyakit->jeniskasuspenyakit_nama.' dengan diagnosa '.$this->diagnosa->diagnosa_nama. ' telah tersedia di database');
                            return false;
                        }
                    }
                }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'diagnosa'=>array(self::BELONGS_TO,'DiagnosaM', 'diagnosa_id'),
                    'jeniskasuspenyakit'=>array(self::BELONGS_TO,'JeniskasuspenyakitM', 'jeniskasuspenyakit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
			'diagnosa_id' => 'Diagnosa',
                        'diagnosa_nama' => 'Nama Diagnosa'
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

		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
                $criteria->compare('t.diagnosa_kode',$this->diagnosa_kode);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->compare('t.jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('t.diagnosa_id',$this->diagnosa_id);
                $criteria->compare('LOWER(diagnosa.diagnosa_kode)',  strtolower($this->diagnosa_kode), true);
                //$criteria->compare('LOWER(diagnosa.diagnosa_nama)',strtolower($this->diagnosa_nama),true);
                $criteria->compare('LOWER(diagnosa.diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
                $criteria->compare('LOWER(jeniskasuspenyakit.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);                
                $criteria->with=array('diagnosa','jeniskasuspenyakit');
                $criteria->addSearchCondition('LOWER(diagnosa.diagnosa_nama)', strtolower($this->diagnosa_nama));
                $criteria->addSearchCondition('LOWER(diagnosa.diagnosa_namalainnya)', strtolower($this->diagnosa_namalainnya));

               // $criteria->order = 'jeniskasuspenyakit.jeniskasuspenyakit_nama ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                            'attributes' => array(
                                'jeniskasuspenyakit.jeniskasuspenyakit_nama' => array(
                                    'asc' => 'jeniskasuspenyakit.jeniskasuspenyakit_nama ASC',
                                    'desc' => 'jeniskasuspenyakit.jeniskasuspenyakit_nama DESC',
                                ),
                                 'diagnosa.diagnosa_nama' => array(
                                    'asc' => 'diagnosa.diagnosa_nama ASC',
                                    'desc' => 'diagnosa.diagnosa_nama DESC',
                                ),
                                'diagnosa.diagnosa_namalainnya' => array(
                                    'asc' => 'diagnosa.diagnosa_namalainnya ASC',
                                    'desc' => 'diagnosa.diagnosa_namalainnya DESC',
                                ),
                                'diagnosa_kode' => array(
                                    'asc' => 'diagnosa.diagnosa_kode ASC',
                                    'desc' => 'diagnosa.diagnosa_kode DESC',
                                ),
                                '*',
                            )
                        )
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		 $criteria->with = array('diagnosa');
		$criteria->compare('LOWER(diagnosa.diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa.diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa.diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa.diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		$criteria->compare('diagnosa.diagnosa_nourut',$this->diagnosa_nourut);
		if (!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id ='.$this->jeniskasuspenyakit_id);
		}
		if (!empty($this->diagnosa_id)){
			$criteria->addCondition('diagnosa_id ='.$this->diagnosa_id);
		}
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getJeniskasuspenyakitItems()
        {
            return JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif = TRUE ORDER BY jeniskasuspenyakit_nama');
        }
        
        public function getDiagnosaItems()
        {
            return DiagnosaM::model()->findAll('diagnosa_aktif = TRUE ORDER BY diagnosa_nama');
        }
}