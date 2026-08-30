<?php

/**
 * This is the model class for table "teknisiperalatan_m".
 *
 * The followings are the available columns in table 'teknisiperalatan_m':
 * @property integer $teknisiperalatan_id
 * @property string $namateknisi
 * @property string $jeniskelamin
 * @property string $tempatlahir
 * @property string $tgllahir
 * @property integer $pendidikan_id
 * @property string $agama
 * @property string $statusperkawinan
 * @property integer $kabupaten_id
 * @property string $alamat_teknisi
 * @property string $no_kontak_teknisi
 * @property integer $supplier_id
 *
 * The followings are the available model relations:
 * @property WorkorderT[] $workorderTs
 * @property SertifikatteknisiM[] $sertifikatteknisiMs
 */
class TeknisiperalatanM extends CActiveRecord
{
    public $supplier_nama,$kabupaten_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TeknisiperalatanM the static model class
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
		return 'teknisiperalatan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('namateknisi, jeniskelamin, kabupaten_id, alamat_teknisi,kabupaten_id, no_kontak_teknisi, supplier_id', 'required'),
			array('pendidikan_id, kabupaten_id, supplier_id', 'numerical', 'integerOnly'=>true),
			array('namateknisi, tempatlahir', 'length', 'max'=>100),
			array('jeniskelamin, statusperkawinan', 'length', 'max'=>20),
			array('agama', 'length', 'max'=>10),
			array('alamat_teknisi', 'length', 'max'=>255),
			array('no_kontak_teknisi', 'length', 'max'=>50),
			array('tgllahir,teknisiperalatan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('teknisiperalatan_id, namateknisi, jeniskelamin, tempatlahir, tgllahir, pendidikan_id, agama, statusperkawinan, kabupaten_id, alamat_teknisi, no_kontak_teknisi, supplier_id', 'safe', 'on'=>'search'),
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
			'workorderTs' => array(self::HAS_MANY, 'WorkorderT', 'teknisiperalatan_id'),
			'sertifikatteknisiMs' => array(self::HAS_MANY, 'SertifikatteknisiM', 'teknisiperalatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'teknisiperalatan_id' => 'Teknisi Peralatan ID',
			'namateknisi' => 'Nama Teknisi',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempatlahir' => 'Tempat Lahir',
			'tgllahir' => 'Tanggal Lahir',
			'pendidikan_id' => 'Pendidikan',
			'agama' => 'Agama',
			'statusperkawinan' => 'Status Pernikahan',
			'kabupaten_id' => 'Domisili',
			'alamat_teknisi' => 'Alamat Teknisi',
			'no_kontak_teknisi' => 'No Kontak Teknisi',
			'supplier_id' => 'Supplier',
			'teknisiperalatan_aktif' => 'Status',
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

		$criteria->compare('teknisiperalatan_id',$this->teknisiperalatan_id);
		$criteria->compare('LOWER(namateknisi)',strtolower($this->namateknisi),true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempatlahir',$this->tempatlahir,true);
		$criteria->compare('tgllahir',$this->tgllahir,true);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		//$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('alamat_teknisi',$this->alamat_teknisi,true);
		$criteria->compare('no_kontak_teknisi',$this->no_kontak_teknisi,true);
                if (!empty($this->supplier_id)){
                    $criteria->addCondition('supplier_id ='.$this->supplier_id);
                }else{
                   // $criteria->addCondition('supplier_id is null ');
                }

                if (!empty($this->kabupaten_id)){
                    $criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
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

		$criteria->compare('teknisiperalatan_id',$this->teknisiperalatan_id);
		$criteria->compare('namateknisi',$this->namateknisi,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempatlahir',$this->tempatlahir,true);
		$criteria->compare('tgllahir',$this->tgllahir,true);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		//$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('alamat_teknisi',$this->alamat_teknisi,true);
		$criteria->compare('no_kontak_teknisi',$this->no_kontak_teknisi,true);
        if (!empty($this->supplier_id)){
            $criteria->addCondition('supplier_id ='.$this->supplier_id);
        }
        if (!empty($this->kabupaten_id)){
            $criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
        }
        $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>false,
		));
	}
}