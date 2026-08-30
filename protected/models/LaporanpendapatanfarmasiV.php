<?php

/**
 * This is the model class for table "laporanpendapatanfarmasi_v".
 *
 * The followings are the available columns in table 'laporanpendapatanfarmasi_v':
 * @property string $tglpenjualan
 * @property integer $penjualanresep_id
 * @property integer $obatalkes_id
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_nama
 * @property double $qty_oa
 * @property double $hargasatuan_oa
 * @property double $hargajual_oa
 * @property double $harganetto_oa
 * @property double $discount
 * @property double $ppn_persen
 * @property double $hpp
 * @property integer $returresep_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $noresep
 * @property string $jenispenjualan
 * @property integer $oasudahbayar_id
 */
class LaporanpendapatanfarmasiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpendapatanfarmasiV the static model class
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
		return 'laporanpendapatanfarmasi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjualanresep_id, obatalkes_id, jenisobatalkes_id, returresep_id, ruangan_id, oasudahbayar_id', 'numerical', 'integerOnly'=>true),
			array('qty_oa, hargasatuan_oa, hargajual_oa, harganetto_oa, discount, ppn_persen, hpp', 'numerical'),
			array('obatalkes_kode, obatalkes_nama', 'length', 'max'=>200),
			array('obatalkes_golongan, obatalkes_kategori, jenisobatalkes_nama, ruangan_nama, noresep', 'length', 'max'=>50),
			array('obatalkes_kadarobat', 'length', 'max'=>20),
			array('jenispenjualan', 'length', 'max'=>100),
			array('tglpenjualan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglpenjualan, penjualanresep_id, obatalkes_id, obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, jenisobatalkes_id, jenisobatalkes_nama, qty_oa, hargasatuan_oa, hargajual_oa, harganetto_oa, discount, ppn_persen, hpp, returresep_id, ruangan_id, ruangan_nama, noresep, jenispenjualan, oasudahbayar_id', 'safe', 'on'=>'search'),
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
			'tglpenjualan' => 'Tanggal Penjualan',
			'penjualanresep_id' => 'Penjualanresep',
			'obatalkes_id' => 'Obatalkes',
			'obatalkes_kode' => 'Obatalkes Kode',
			'obatalkes_nama' => 'Obatalkes Nama',
			'obatalkes_golongan' => 'Obatalkes Golongan',
			'obatalkes_kategori' => 'Obatalkes Kategori',
			'obatalkes_kadarobat' => 'Obatalkes Kadarobat',
			'jenisobatalkes_id' => 'Jenis Obatalkes',
			'jenisobatalkes_nama' => 'Jenis Obatalkes',
			'qty_oa' => 'Jumlah Oa',
			'hargasatuan_oa' => 'Hargasatuan Oa',
			'hargajual_oa' => 'Hargajual Oa',
			'harganetto_oa' => 'Harganetto Oa',
			'discount' => 'Keringanan',
			'ppn_persen' => 'Ppn Persen',
			'hpp' => 'Hpp',
			'returresep_id' => 'Returresep',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'noresep' => 'Noresep',
			'jenispenjualan' => 'Jenis Penjualan',
			'oasudahbayar_id' => 'Oasudahbayar',
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

		$criteria->compare('LOWER(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		$criteria->compare('harganetto_oa',$this->harganetto_oa);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('ppn_persen',$this->ppn_persen);
		$criteria->compare('hpp',$this->hpp);
		$criteria->compare('returresep_id',$this->returresep_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('oasudahbayar_id',$this->oasudahbayar_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('LOWER(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		$criteria->compare('harganetto_oa',$this->harganetto_oa);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('ppn_persen',$this->ppn_persen);
		$criteria->compare('hpp',$this->hpp);
		$criteria->compare('returresep_id',$this->returresep_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('oasudahbayar_id',$this->oasudahbayar_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}