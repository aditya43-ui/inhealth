<?php

/**
 * This is the model class for table "penyimpananlinendetail_v".
 *
 * The followings are the available columns in table 'penyimpananlinendetail_v':
 * @property integer $linen_id
 * @property string $kodelinen
 * @property string $namalinen
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $no_linen
 * @property string $tgl_linen
 * @property integer $kode
 */
class PenyimpananlinendetailV extends CActiveRecord
{
	public $instalasi_id, $tgl_awal, $tgl_akhir, $pencucianlinen_id, $perawatanlinen_id, $checklist;
	public $instalasi_nama;
        
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyimpananlinendetailV the static model class
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
		return 'penyimpananlinendetail_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('linen_id, ruangan_id, kode', 'numerical', 'integerOnly'=>true),
			array('kodelinen, ruangan_nama', 'length', 'max'=>50),
			array('namalinen', 'length', 'max'=>200),
			array('no_linen', 'length', 'max'=>20),
			array('tgl_linen', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('linen_id, kodelinen, namalinen, ruangan_id, ruangan_nama, no_linen, tgl_linen, kode', 'safe', 'on'=>'search'),
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
			'linen_id' => 'Linen',
			'kodelinen' => 'Kodelinen',
			'namalinen' => 'Namalinen',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'no_linen' => 'No Linen',
			'tgl_linen' => 'Tgl. Linen',
			'kode' => 'Kode',
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

		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		$criteria->compare('LOWER(kodelinen)',strtolower($this->kodelinen),true);
		$criteria->compare('LOWER(namalinen)',strtolower($this->namalinen),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(no_linen)',strtolower($this->no_linen),true);
		$criteria->compare('LOWER(tgl_linen)',strtolower($this->tgl_linen),true);
		if(!empty($this->kode)){
			$criteria->addCondition('kode = '.$this->kode);
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
		
		public function searchPenyimpanan() {
			$criteria=new CDbCriteria;
			$format = new MyFormatter();
		
			$this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
			$this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);

			$criteria->limit=1000;
			if(!Yii::app()->request->isAjaxRequest){//data hanya muncul setelah melakukan pencarian
				$criteria->limit = 0;
			}
			$criteria->addBetweenCondition('DATE(tgl_linen)', $this->tgl_awal, $this->tgl_akhir,true);
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
			}
			$criteria->compare('LOWER(no_linen)',strtolower($this->no_linen),true);
//			$criteria->addCondition("t.kode NOT IN (SELECT pencucianlinen_id FROM penyimpananlinendet_t WHERE pencucianlinen_id IS NOT NULL)");
			$criteria->addCondition("(t.kode NOT IN (SELECT perawatanlinen_id FROM penyimpananlinendet_t WHERE perawatanlinen_id IS NOT NULL)) OR (t.kode NOT IN (SELECT pencucianlinen_id FROM penyimpananlinendet_t WHERE pencucianlinen_id IS NOT NULL))");
			
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
		
		}
		
		public function getNoPencucian($no_linen, $kode) {
			$pencucianlinen_id = null;
			$noLinen = substr($no_linen, 0 , 3);
			if($noLinen == 'PCL'){ //kode harus disamakan dengan class generator fungsi untuk no pencucian
				$pencucianlinen_id = $kode;
			}
			return $pencucianlinen_id;
		}
		
		public function getNoPerawatan($no_linen, $kode) {
			$perawatanlinen_id = null;
			$noLinen = substr($no_linen, 0 , 3);
			if($noLinen == 'PWL'){ //kode harus disamakan dengan class generator fungsi untuk no perawatan
				$perawatanlinen_id = $kode;
			}
			return $perawatanlinen_id;
		}
		
}