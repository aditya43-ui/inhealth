<?php

/**
 * This is the model class for table "karcis_v".
 *
 * The followings are the available columns in table 'karcis_v':
 * @property integer $karcis_id
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property string $karcis_nama
 * @property string $karcis_namalainnya
 * @property integer $ruangan_id
 * @property double $harga_tariftindakan
 * @property integer $kelaspelayanan_id
 * @property integer $komponentarif_id
 * @property integer $jenistarif_id
 * @property integer $penjamin_id
 */
class KarcisV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KarcisV the static model class
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
		return 'karcis_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('karcis_id, daftartindakan_id, ruangan_id, kelaspelayanan_id, komponentarif_id, jenistarif_id, penjamin_id', 'numerical', 'integerOnly'=>true),
			array('harga_tariftindakan', 'numerical'),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('karcis_nama, karcis_namalainnya', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('karcis_id, daftartindakan_id, daftartindakan_nama, karcis_nama, karcis_namalainnya, ruangan_id, harga_tariftindakan, kelaspelayanan_id, komponentarif_id', 'safe', 'on'=>'search'),
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
			'karcis_id' => 'Karcis',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'karcis_nama' => 'Karcis Nama',
			'karcis_namalainnya' => 'Karcis Namalainnya',
			'ruangan_id' => 'Ruangan',
			'harga_tariftindakan' => 'Harga Tariftindakan',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'komponentarif_id' => 'Komponentarif',
			'jenistarif_id' => 'Jenis Tarif',
			'penjamin_id' => 'Penjamin',
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

		$criteria->compare('karcis_id',$this->karcis_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(karcis_nama)',strtolower($this->karcis_nama),true);
		$criteria->compare('LOWER(karcis_namalainnya)',strtolower($this->karcis_namalainnya),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('karcis_id',$this->karcis_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(karcis_nama)',strtolower($this->karcis_nama),true);
		$criteria->compare('LOWER(karcis_namalainnya)',strtolower($this->karcis_namalainnya),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
                $criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}