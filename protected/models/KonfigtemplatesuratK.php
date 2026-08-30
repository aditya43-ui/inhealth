<?php

/**
 * This is the model class for table "konfigtemplatesurat_k".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'konfigtemplatesurat_k':
 * @property integer $konfigtemplatesurat_id
 * @property integer $jenissurat_id
 * @property string $jenissurat_nama
 * @property string $konfigtemplatesurat_isi
 * @property boolean $konfigtemplatesurat_aktif
 */
class KonfigtemplatesuratK extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KonfigtemplatesuratK the static model class
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
		return 'konfigtemplatesurat_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('konfigtemplatesurat_nama,jenissurat_id, konfigtemplatesurat_aktif', 'required'),
			array('jenissurat_id', 'numerical', 'integerOnly'=>true),
			array('jenissurat_nama', 'length', 'max'=>50),
			array('modul_id, keterangan,konfigtemplatesurat_isi,urutan,file,nama_lain,konfigtemplatesurat_nama', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('keterangan,urutan,file,nama_lain,konfigtemplatesurat_nama,konfigtemplatesurat_id, jenissurat_id, jenissurat_nama, konfigtemplatesurat_isi, konfigtemplatesurat_aktif', 'safe', 'on'=>'search'),
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
                    'jenissurat' => array(self::BELONGS_TO, 'JenisSuratM', 'jenissurat_id'), 
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'konfigtemplatesurat_id' => 'Konfigtemplatesurat',
			'jenissurat_id' => 'Jenis Surat',
			'jenissurat_nama' => 'Jenis Surat',
			'konfigtemplatesurat_isi' => 'Isi',
			'konfigtemplatesurat_aktif' => 'Aktif',
                        'urutan'=>'Urutan',
                        'keterangan'=>'Keterangan',
                        'file'=>'File',
                        'nama_lain'=>'Nama Lain',
                        'konfigtemplatesurat_nama'=>'Nama Template Dokumen',
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

		$criteria->compare('konfigtemplatesurat_id',$this->konfigtemplatesurat_id);
		$criteria->compare('jenissurat_id',$this->jenissurat_id);
		$criteria->compare('jenissurat_nama',$this->jenissurat_nama,true);
		$criteria->compare('konfigtemplatesurat_isi',$this->konfigtemplatesurat_isi,true);
		$criteria->compare('konfigtemplatesurat_aktif',$this->konfigtemplatesurat_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Load data cetak template surat
         * @return \CActiveDataProvider
         */
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->compare("LOWER(t.konfigtemplatesurat_isi)", strtolower($this->konfigtemplatesurat_isi), true);
		$criteria->compare('konfigtemplatesurat_aktif',$this->konfigtemplatesurat_aktif);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}