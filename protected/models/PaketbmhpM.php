<?php

/**
 * This is the model class for table "paketbmhp_m".
 *
 * The followings are the available columns in table 'paketbmhp_m':
 * @property integer $paketbmhp_id
 * @property integer $daftartindakan_id
 * @property integer $tipepaket_id
 * @property integer $satuankecil_id
 * @property integer $obatalkes_id
 * @property integer $kelompokumur_id
 * @property double $qtypemakaian
 * @property double $qtystokout
 * @property double $hargapemakaian
 */
class PaketbmhpM extends CActiveRecord
{
    public $obatalkesNama;
    public $kelompokumurNama;
    public $daftartindakanNama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PaketbmhpM the static model class
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
		return 'paketbmhp_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipepaket_id, qtypemakaian, qtystokout, paketbmhp_nama, paketbmhp_nomorpaket', 'required'),
			array('daftartindakan_id, tipepaket_id, satuankecil_id, obatalkes_id, kelompokumur_id', 'numerical', 'integerOnly'=>true),
			array('qtypemakaian, qtystokout, hargapemakaian', 'numerical'),
			array('paketbmhp_namalain', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelompokumurNama, daftartindakanNama, obatalkesNama, daftartindakan_nama, kelompokumur_id, paketbmhp_id, daftartindakan_id, tipepaket_id, satuankecil_id, obatalkes_id, kelompokumur, qtypemakaian, qtystokout, hargapemakaian', 'safe', 'on'=>'search'),
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
                    'daftartindakan'=>array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
                    'obatalkes'=>array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
                    'tipepaket'=>array(self::BELONGS_TO, 'TipepaketM', 'tipepaket_id'),
                    'satuankecil'=>array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
                    'kelompokumur'=>array(self::BELONGS_TO, 'KelompokumurM', 'kelompokumur_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'paketbmhp_id' => 'Paketbmhp',
			'daftartindakan_id' => 'Daftar Tindakan',
			'tipepaket_id' => 'Tipe Paket',
			'satuankecil_id' => 'Satuan Kecil',
			'obatalkes_id' => 'Obat Alkes',
			'kelompokumur_id' => 'Kelompok Umur',
			'qtypemakaian' => 'Jumlah Pemakaian',
			'qtystokout' => 'Jumlah Stok Out',
			'hargapemakaian' => 'Harga Pemakaian',
                        'obatalkesNama' => 'Nama BHP',
                        'daftartindakanNama' => 'Uraian Tindakan',
                        'kelompokumurNama' => 'Kelompok Umur',
			'paketbmhp_nama' => 'Nama Paket BMHP',
			'paketbmhp_namalain' => 'Nama Lain Paket BMHP',
			'paketbmhp_nomorpaket' => 'Nomor Paket',
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
                
                $criteria->with = array('obatalkes','daftartindakan','kelompokumur');
		$criteria->compare('paketbmhp_id',$this->paketbmhp_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('qtypemakaian',$this->qtypemakaian);
		$criteria->compare('qtystokout',$this->qtystokout);
		$criteria->compare('hargapemakaian',$this->hargapemakaian);
		$criteria->compare('LOWER(obatalkes.obatalkes_nama)',strtolower($this->obatalkesNama),true);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakanNama),true);
		$criteria->compare('LOWER(kelompokumur.kelompokumur_nama)',strtolower($this->kelompokumurNama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('paketbmhp_id',$this->paketbmhp_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('qtypemakaian',$this->qtypemakaian);
		$criteria->compare('qtystokout',$this->qtystokout);
		$criteria->compare('hargapemakaian',$this->hargapemakaian);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}