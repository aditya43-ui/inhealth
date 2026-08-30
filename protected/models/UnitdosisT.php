<?php

/**
 * This is the model class for table "unitdosis_t".
 *
 * The followings are the available columns in table 'unitdosis_t':
 * @property integer $unitdosis_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pegawai_id
 * @property integer $diagnosa_id
 * @property integer $ruangan_id
 * @property integer $jenisdiet_id
 * @property integer $kelaspelayanan_id
 * @property integer $kamarruangan_id
 * @property string $nounitdosis
 * @property string $tgluntidosis
 * @property integer $ruanganunitdosis_id
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property string $alergiobat
 */
class UnitdosisT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UnitdosisT the static model class
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
		return 'unitdosis_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, ruangan_id, kelaspelayanan_id, nounitdosis, tgluntidosis, ruanganunitdosis_id', 'required'),
			array('pendaftaran_id, pasien_id, pegawai_id, diagnosa_id, ruangan_id, jenisdiet_id, kelaspelayanan_id, kamarruangan_id, ruanganunitdosis_id', 'numerical', 'integerOnly'=>true),
			array('beratbadan_kg, tinggibadan_cm', 'numerical'),
			array('nounitdosis', 'length', 'max'=>20),
			array('alergiobat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('unitdosis_id, pendaftaran_id, pasien_id, pegawai_id, diagnosa_id, ruangan_id, jenisdiet_id, kelaspelayanan_id, kamarruangan_id, nounitdosis, tgluntidosis, ruanganunitdosis_id, beratbadan_kg, tinggibadan_cm, alergiobat', 'safe', 'on'=>'search'),
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
			'unitdosis_id' => 'Unit Dosis',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pegawai_id' => 'Pegawai',
			'diagnosa_id' => 'Diagnosa',
			'ruangan_id' => 'Ruangan',
			'jenisdiet_id' => 'Jenis Diet',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kamarruangan_id' => 'Kamar Ruangan',
			'nounitdosis' => 'No. Unit Dosis',
			'tgluntidosis' => 'Tanggal Unit Dosis',
			'ruanganunitdosis_id' => 'Ruangan Unit Dosis',
			'beratbadan_kg' => 'TB / BB',
			'tinggibadan_cm' => 'TB/',
			'alergiobat' => 'Alergi Obat',
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

		$criteria->compare('unitdosis_id',$this->unitdosis_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('LOWER(nounitdosis)',strtolower($this->nounitdosis),true);
		$criteria->compare('LOWER(tgluntidosis)',strtolower($this->tgluntidosis),true);
		$criteria->compare('ruanganunitdosis_id',$this->ruanganunitdosis_id);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('LOWER(alergiobat)',strtolower($this->alergiobat),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('unitdosis_id',$this->unitdosis_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('LOWER(nounitdosis)',strtolower($this->nounitdosis),true);
		$criteria->compare('LOWER(tgluntidosis)',strtolower($this->tgluntidosis),true);
		$criteria->compare('ruanganunitdosis_id',$this->ruanganunitdosis_id);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('LOWER(alergiobat)',strtolower($this->alergiobat),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}