<?php

/**
 * This is the model class for table "kelengkapandokumen_rm_m".
 *
 * The followings are the available columns in table 'kelengkapandokumen_rm_m':
 * @property integer $kelengkapandokumen_rm_id
 * @property string $jenisdokumen
 * @property string $nama_dokumen
 * @property string $urutan_dokumen
 * @property boolean $kelengkapandokumen_aktif
 * @property integer $level_dokumen
 * @property string $kelompok_dokumen
 * @property string $tipe
 */
class KelengkapandokumenRmM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kelengkapandokumen_rm_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('level_dokumen', 'numerical', 'integerOnly'=>true),
			array('jenisdokumen, nama_dokumen, urutan_dokumen, kelompok_dokumen', 'length', 'max'=>255),
			array('kelengkapandokumen_aktif, tipe', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kelengkapandokumen_rm_id, jenisdokumen, nama_dokumen, urutan_dokumen, kelengkapandokumen_aktif, level_dokumen, kelompok_dokumen, tipe', 'safe', 'on'=>'search'),
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
			'kelengkapandokumen_rm_id' => 'Kelengkapandokumen Rm',
			'jenisdokumen' => 'Jenis Dokumen',
			'nama_dokumen' => 'Nama Dokumen',
			'urutan_dokumen' => 'Urutan',
			'kelengkapandokumen_aktif' => 'Status',
			'level_dokumen' => 'Level',
			'kelompok_dokumen' => 'Kelompok Dokumen',
			'tipe' => 'Tipe',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kelengkapandokumen_rm_id',$this->kelengkapandokumen_rm_id);
		$criteria->compare('LOWER(jenisdokumen)',strtolower($this->jenisdokumen),true);
		$criteria->compare('LOWER(nama_dokumen)',strtolower($this->nama_dokumen),true);
		$criteria->compare('urutan_dokumen',$this->urutan_dokumen,true);
		$criteria->compare('kelengkapandokumen_aktif',$this->kelengkapandokumen_aktif);
		$criteria->compare('level_dokumen',$this->level_dokumen);
		$criteria->compare('kelompok_dokumen',$this->kelompok_dokumen,true);
		if(!empty($this->tipe)) {
			$criteria->addCondition("LOWER(tipe) = '" . strtolower($this->tipe) . "'");
		}
		// echo '<pre>';var_dump($criteria);die;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kelengkapandokumen_rm_id',$this->kelengkapandokumen_rm_id);
		$criteria->compare('LOWER(jenisdokumen)',strtolower($this->jenisdokumen),true);
		$criteria->compare('LOWER(nama_dokumen)',strtolower($this->nama_dokumen),true);
		$criteria->compare('urutan_dokumen',$this->urutan_dokumen,true);
		$criteria->compare('kelengkapandokumen_aktif',$this->kelengkapandokumen_aktif);
		$criteria->compare('level_dokumen',$this->level_dokumen);
		$criteria->compare('kelompok_dokumen',$this->kelompok_dokumen,true);
		if(!empty($this->tipe)) {
			$criteria->addCondition("LOWER(tipe) = '" . strtolower($this->tipe) . "'");
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => false
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KelengkapandokumenRmM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
