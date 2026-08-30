<?php

/**
 * This is the model class for table "modul_k".
 *
 * The followings are the available columns in table 'modul_k':
 * @property integer $modul_id
 * @property integer $kelompokmodul_id
 * @property string $modul_nama
 * @property string $modul_namalainnya
 * @property string $modul_fungsi
 * @property string $tglrevisimodul
 * @property string $tglupdatemodul
 * @property string $url_modul
 * @property string $icon_modul
 * @property string $modul_key
 * @property integer $modul_urutan
 * @property string $modul_kategori
 * @property boolean $modul_aktif
 */
class ModulK extends CActiveRecord
{
    public $kelompokmodul_nama;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModulK the static model class
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
		return 'modul_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokmodul_id, modul_nama, modul_key, modul_kategori', 'required'),
			array('kelompokmodul_id, modul_urutan', 'numerical', 'integerOnly'=>true),
			array('modul_nama, modul_namalainnya, url_modul, modul_key', 'length', 'max'=>50),
			array('icon_modul', 'length', 'max'=>100),
			array('modul_fungsi, tglrevisimodul, tglupdatemodul, modul_aktif', 'safe'),
                        //array('tglrevisimodul', 'type', 'type'=>'date', 'dateFormat'=>'yyyy-MM-dd'), 
                        //array('tglrevisimodul','date','format'=>Yii::app()->locale->getDateFormat('medium')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('modul_kategori, kelompokmodul_nama, modul_id, kelompokmodul_id, modul_nama, modul_namalainnya, modul_fungsi, tglrevisimodul, tglupdatemodul, url_modul, icon_modul, modul_key, modul_urutan, modul_aktif', 'safe', 'on'=>'search'),
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
			'kelompokmodul' => array(self::BELONGS_TO, 'KelompokmodulK', 'kelompokmodul_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'modul_id' => 'ID',
			'kelompokmodul_id' => 'Kelompok Moduls',
			'modul_nama' => 'Modul',
			'modul_namalainnya' => 'Nama Lainnya',
			'modul_fungsi' => 'Fungsi',
			'tglrevisimodul' => 'Tanggal Revisi',
			'tglupdatemodul' => 'Tanggal Update',
			'url_modul' => 'URL',
			'icon_modul' => 'Icon',
			'modul_key' => 'Modul Key',
			'modul_urutan' => 'Urutan',
                                                'modul_kategori' => 'Kategori',
			'modul_aktif' => 'Aktif',
                    
                                                'kelompokmodul_nama'=>'Kelompok Modul',
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

		$criteria->compare('modul_id',$this->modul_id);
		$criteria->compare('kelompokmodul_id',$this->kelompokmodul_id);
		$criteria->compare('LOWER(modul_nama)',strtolower($this->modul_nama),true);
		$criteria->compare('LOWER(modul_namalainnya)',strtolower($this->modul_namalainnya),true);
		$criteria->compare('LOWER(modul_fungsi)',strtolower($this->modul_fungsi),true);
		$criteria->compare('LOWER(tglrevisimodul)',strtolower($this->tglrevisimodul),true);
		$criteria->compare('LOWER(tglupdatemodul)',strtolower($this->tglupdatemodul),true);
		$criteria->compare('LOWER(url_modul)',strtolower($this->url_modul),true);
		$criteria->compare('LOWER(icon_modul)',strtolower($this->icon_modul),true);
		$criteria->compare('LOWER(modul_key)',strtolower($this->modul_key),true);
		$criteria->compare('modul_urutan',$this->modul_urutan);
		$criteria->compare('modul_aktif',$this->modul_aktif);
                $criteria->compare('LOWER(modul_kategori)',strtolower($this->modul_kategori),true);
//                $criteria->AddCondition('modul_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchModul()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		// $moduls = ModulK::model()->with('kelompokmodul')->findAllByAttributes(array('modul_aktif'=>true),array('order'=>'modul_kategori, t.kelompokmodul_id, modul_urutan'));
		$criteria=new CDbCriteria;
		// $criteria->with('kelompokmodul');
		$criteria->compare('modul_id',$this->modul_id);
		$criteria->compare('kelompokmodul_id',$this->kelompokmodul_id);
		$criteria->compare('LOWER(modul_nama)',strtolower($this->modul_nama),true);
		$criteria->compare('LOWER(modul_namalainnya)',strtolower($this->modul_namalainnya),true);
		$criteria->compare('LOWER(modul_fungsi)',strtolower($this->modul_fungsi),true);
		$criteria->compare('LOWER(tglrevisimodul)',strtolower($this->tglrevisimodul),true);
		$criteria->compare('LOWER(tglupdatemodul)',strtolower($this->tglupdatemodul),true);
		$criteria->compare('LOWER(url_modul)',strtolower($this->url_modul),true);
		$criteria->compare('LOWER(icon_modul)',strtolower($this->icon_modul),true);
		$criteria->compare('LOWER(modul_key)',strtolower($this->modul_key),true);
		$criteria->compare('modul_urutan',$this->modul_urutan);
		$criteria->compare('modul_aktif',$this->modul_aktif);
                $criteria->compare('LOWER(modul_kategori)',strtolower($this->modul_kategori),true);
                $criteria->AddCondition('modul_aktif is true');
                $criteria->order = 'modul_kategori DESC, modul_urutan ASC';


		return new CActiveDataProvider($this, array(
			'pagination' => array('pageSize' => 5,),
			'criteria'=>$criteria,
		));
	}
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->compare('modul_id',$this->modul_id);
                $criteria->compare('kelompokmodul_id',$this->kelompokmodul_id);
                $criteria->compare('LOWER(modul_nama)',strtolower($this->modul_nama),true);
                $criteria->compare('LOWER(modul_namalainnya)',strtolower($this->modul_namalainnya),true);
                $criteria->compare('LOWER(modul_fungsi)',strtolower($this->modul_fungsi),true);
                $criteria->compare('LOWER(tglrevisimodul)',strtolower($this->tglrevisimodul),true);
                $criteria->compare('LOWER(tglupdatemodul)',strtolower($this->tglupdatemodul),true);
                $criteria->compare('LOWER(url_modul)',strtolower($this->url_modul),true);
                $criteria->compare('LOWER(icon_modul)',strtolower($this->icon_modul),true);
                $criteria->compare('LOWER(modul_key)',strtolower($this->modul_key),true);
                $criteria->compare('modul_urutan',$this->modul_urutan);
                $criteria->compare('LOWER(modul_kategori)',strtolower($this->modul_kategori),true);
                $criteria->compare('modul_aktif',$this->modul_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date'){
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }elseif ($column->dbType == 'datetime'){
                            $this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                    }

            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {
            //$this->modul_nama = ucwords(strtolower($this->modul_nama));
            $this->modul_namalainnya = strtoupper($this->modul_namalainnya);
            if($this->tglrevisimodul===null || trim($this->tglrevisimodul)==''){
	        $this->setAttribute('tglrevisimodul', null);
            } 
            
            if($this->tglupdatemodul===null || trim($this->tglupdatemodul)==''){
	        $this->setAttribute('tglupdatemodul', null);
            } 
            
            return parent::beforeSave();
        }

        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'datetime'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
                
        public function getKelompokModulItems()
        {
            return SAKelompokModulK::model()->findAll();
        }
        
        public function getKelompokModul()
        {
            return SAKelompokModulK::model()->findByPk($this->kelompokmodul_id)->kelompokmodul_nama;
        }
}