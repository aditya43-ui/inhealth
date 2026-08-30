<?php

/**
 * This is the model class for table "komponentarif_m".
 *
 * The followings are the available columns in table 'komponentarif_m':
 * @property integer $komponentarif_id
 * @property string $komponentarif_nama
 * @property string $komponentarif_namalainnya
 * @property integer $komponentarif_urutan
 * @property boolean $komponentarif_aktif
 */
class KomponentarifM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KomponentarifM the static model class
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
		return 'komponentarif_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('komponentarif_nama', 'required'),
			array('komponentarif_urutan', 'numerical', 'integerOnly'=>true),
			array('komponentarif_nama, komponentarif_namalainnya', 'length', 'max'=>25),
			array('komponentarif_aktif, isjasars, isjasamedis, isjasalayananlain, isbhp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('komponentarif_id, komponentarif_nama, komponentarif_namalainnya, komponentarif_urutan, komponentarif_aktif, isjasars, isjasamedis, isjasalayananlain, isbhp', 'safe', 'on'=>'search'),
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
			'komponentarif_id' => 'ID',
			'komponentarif_nama' => 'Nama Komponen Tarif',
			'komponentarif_namalainnya' => 'Nama Lain',
			'komponentarif_urutan' => 'Urutan',
			'komponentarif_aktif' => 'Aktif',
			'ispembayaranjasa' => 'Komponen Pembayaran Jasa'
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

		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('LOWER(komponentarif_namalainnya)',strtolower($this->komponentarif_namalainnya),true);
		$criteria->compare('komponentarif_urutan',$this->komponentarif_urutan);
		$criteria->compare('komponentarif_aktif',isset($this->komponentarif_aktif)?$this->komponentarif_aktif:true);
//                $criteria->addCondition('komponentarif_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('LOWER(komponentarif_namalainnya)',strtolower($this->komponentarif_namalainnya),true);
		$criteria->compare('komponentarif_urutan',$this->komponentarif_urutan);
//		$criteria->compare('komponentarif_aktif',$this->komponentarif_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit
                $criteria->limit=-1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

        public function beforeSave(){
            $this->komponentarif_nama = ucwords(strtolower($this->komponentarif_nama));
            $this->komponentarif_namalainnya = strtoupper($this->komponentarif_namalainnya);
            return parent::beforeSave();
        }

        public function getItems(){
            $criteria = new CDbCriteria();
            $criteria->addCondition('komponentarif_aktif = TRUE');
            $criteria->addCondition('komponentarif_id <> '.Params::KOMPONENTARIF_ID_TOTAL);
            $criteria->order = 'komponentarif_nama ASC';
            $model = $this->model()->findAll($criteria);
            if(count((array)$model) > 0){
                return $model;
            }else{
                return array();
            }
        }

        public function getItemKelompokMedisParamedis(){
            $criteria = new CDbCriteria();
            $criteria->join = 'join persenkelkomponentarif_m p on p.komponentarif_id = t.komponentarif_id';
            $criteria->addCondition('t.komponentarif_aktif = TRUE');
            $criteria->addCondition('t.komponentarif_id <> '.Params::KOMPONENTARIF_ID_TOTAL);
            $criteria->addCondition('p.kelompokkomponentarif_id in (1,2)');
            $criteria->order = 't.komponentarif_nama ASC';



            $model = $this->model()->findAll($criteria);
            if(count((array)$model) > 0){
                return $model;
            }else{
                return array();
            }
        }

        public function getItemPembayaranJasa(){
            $criteria = new CDbCriteria();
            $criteria->addCondition('t.komponentarif_aktif = TRUE');
            $criteria->addCondition('t.ispembayaranjasa = TRUE');
            $criteria->addCondition('t.komponentarif_id <> '.Params::KOMPONENTARIF_ID_TOTAL);
            $criteria->order = 't.komponentarif_nama ASC';

            $model = $this->model()->findAll($criteria);
            if(count((array)$model) > 0){
                return $model;
            }else{
                return array();
            }
        }
}
