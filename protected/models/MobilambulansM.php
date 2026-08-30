<?php

/**
 * This is the model class for table "mobilambulans_m".
 *
 * The followings are the available columns in table 'mobilambulans_m':
 * @property integer $mobilambulans_id
 * @property integer $inventarisaset_id
 * @property string $mobilambulans_kode
 * @property string $nopolisi
 * @property string $jeniskendaraan
 * @property integer $isibbmliter
 * @property string $kmterakhirkend
 * @property string $photokendaraan
 * @property double $hargabbmliter
 * @property string $formulajasars
 * @property string $formulajasaba
 * @property string $formulajasapel
 * @property boolean $mobilambulans_aktif
 */
class MobilambulansM extends CActiveRecord
{
        public $barang_id;
        public $barang_nama;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MobilAmbulansM the static model class
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
		return 'mobilambulans_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mobilambulans_kode, nopolisi', 'required'),
			array('inventarisaset_id, isibbmliter', 'numerical', 'integerOnly'=>true),
			array('hargabbmliter', 'numerical'),
			array('mobilambulans_kode, nopolisi', 'length', 'max'=>20),
			array('jeniskendaraan', 'length', 'max'=>100),
			array('formulajasars, formulajasaba, formulajasapel', 'length', 'max'=>50),
			array('kmterakhirkend, photokendaraan, mobilambulans_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nopolisi, mobilambulans_id, inventarisaset_id, mobilambulans_kode, nopolisi, jeniskendaraan, isibbmliter, kmterakhirkend, photokendaraan, hargabbmliter, formulajasars, formulajasaba, formulajasapel, mobilambulans_aktif', 'safe', 'on'=>'search'),
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
                                    'barang' => array(self::BELONGS_TO,'BarangM','barang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mobilambulans_id' => 'ID',
			'inventarisaset_id' => 'Inventaris Aset',
			'mobilambulans_kode' => ' Kode',
			'nopolisi' => 'No. Polisi',
			'jeniskendaraan' => 'Jenis Kendaraan',
			'isibbmliter' => 'Isi BBM / Liter',
			'kmterakhirkend' => 'KM Terakhir Kendaraan',
			'photokendaraan' => 'Foto',
			'hargabbmliter' => 'Harga BBM / Liter',
			'formulajasars' => 'Formula Jasa RS',
			'formulajasaba' => 'Formula Jasa BA',
			'formulajasapel' => 'Formula Jasa Pel',
			'mobilambulans_aktif' => 'Aktif',
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
        $criteria->join = "left JOIN barang_m ON barang_m.barang_id = t.inventarisaset_id";
		$criteria->compare('t.mobilambulans_id',$this->mobilambulans_id);
		$criteria->compare('t.inventarisaset_id',$this->inventarisaset_id);
		$criteria->compare('LOWER(t.mobilambulans_kode)',strtolower($this->mobilambulans_kode),true);
		$criteria->compare('LOWER(t.nopolisi)',strtolower($this->nopolisi),true);
		$criteria->compare('LOWER(t.jeniskendaraan)',strtolower($this->jeniskendaraan),true);
		$criteria->compare('t.isibbmliter',$this->isibbmliter);
		$criteria->compare('LOWER(t.kmterakhirkend)',strtolower($this->kmterakhirkend),true);
                $criteria->compare('LOWER(barang_m.barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(t.photokendaraan)',strtolower($this->photokendaraan),true);
		$criteria->compare('t.hargabbmliter',$this->hargabbmliter);
		$criteria->compare('LOWER(t.formulajasars)',strtolower($this->formulajasars),true);
		$criteria->compare('LOWER(t.formulajasaba)',strtolower($this->formulajasaba),true);
		$criteria->compare('LOWER(t.formulajasapel)',strtolower($this->formulajasapel),true);
		//$criteria->compare('mobilambulans_aktif',$this->mobilambulans_aktif);
                $criteria->compare('t.mobilambulans_aktif',isset($this->mobilambulans_aktif)?$this->mobilambulans_aktif:true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.
                
		$criteria=new CDbCriteria;
                $criteria->join = "JOIN barang_m ON barang_m.barang_id = t.inventarisaset_id";
		$criteria->compare('t.mobilambulans_id',$this->mobilambulans_id);
		$criteria->compare('t.inventarisaset_id',$this->inventarisaset_id);
		$criteria->compare('LOWER(t.mobilambulans_kode)',strtolower($this->mobilambulans_kode),true);
		$criteria->compare('LOWER(t.nopolisi)',strtolower($this->nopolisi),true);
		$criteria->compare('LOWER(t.jeniskendaraan)',strtolower($this->jeniskendaraan),true);
		$criteria->compare('t.isibbmliter',$this->isibbmliter);
		$criteria->compare('LOWER(t.kmterakhirkend)',strtolower($this->kmterakhirkend),true);
                $criteria->compare('LOWER(barang_m.barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(t.photokendaraan)',strtolower($this->photokendaraan),true);
		$criteria->compare('t.hargabbmliter',$this->hargabbmliter);
		$criteria->compare('LOWER(t.formulajasars)',strtolower($this->formulajasars),true);
		$criteria->compare('LOWER(t.formulajasaba)',strtolower($this->formulajasaba),true);
		$criteria->compare('LOWER(t.formulajasapel)',strtolower($this->formulajasapel),true);
		//$criteria->compare('mobilambulans_aktif',$this->mobilambulans_aktif);
                $criteria->compare('t.mobilambulans_aktif',isset($this->mobilambulans_aktif)?$this->mobilambulans_aktif:true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getJenisKendaraanItems()
        {
            $criteria=new CDbCriteria;
            $criteria->compare('lookup_type','jeniskendaraan');
            $criteria->compare('lookup_aktif',true);
            $criteria->order = 'lookup_name';
            return LookupM::model()->findAll($criteria);
        }
        
        public function getNamaBarang($id)
        {           
            return BarangM::model()->findByAttributes(array('barang_id'=>$id))->barang_nama;
        }
}
