<?php

/**
 * This is the model class for table "infostokobatalkesruangan_v".
 *
 * The followings are the available columns in table 'infostokobatalkesruangan_v':
 * @property integer $stokobatalkes_id
 * @property integer $obatalkes_id
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_nama
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $kemasanbesar
 * @property integer $kekuatan
 * @property string $satuankekuatan
 * @property integer $minimalstok
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property integer $sumberdana_id
 * @property string $sumberdana_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $tglstok_in
 * @property string $tglstok_out
 * @property double $qtystok_in
 * @property double $qtystok_out
 * @property double $qtystok_current
 * @property double $harganetto_oa
 * @property double $hargajual_oa
 * @property double $discount
 * @property string $tglkadaluarsa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $penerimaandetail_id
 */
class InfostokobatalkesruanganV extends CActiveRecord
{
                public $tgl_awal;
                public $tgl_akhir;
                public $qty;
                public $qtystok;
                public $qty_in;
                public $qty_out;
                public $qty_current;
                public $filterTanggal = false;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfostokobatalkesruanganV the static model class
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
		return 'infostokobatalkesruangan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stokobatalkes_id, obatalkes_id, jenisobatalkes_id, kemasanbesar, kekuatan, minimalstok, satuankecil_id, sumberdana_id, ruangan_id, instalasi_id, penerimaandetail_id', 'numerical', 'integerOnly'=>true),
			array('qtystok_in, qtystok_out, qtystok_current, harganetto_oa, hargajual_oa, discount, qtystokoa_baik, qtystokoa_rusak, qtystokoa', 'numerical'),
			array('jenisobatalkes_nama, obatalkes_kode, obatalkes_golongan, obatalkes_kategori, satuankecil_nama, sumberdana_nama, ruangan_nama', 'length', 'max'=>50),
			array('obatalkes_nama', 'length', 'max'=>200),
			array('obatalkes_kadarobat, satuankekuatan', 'length', 'max'=>20),
			array('tglstok_in, tglstok_out, tglkadaluarsa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal,tgl_akhir,tgl_awal, tgl_akhir, stokobatalkes_id, obatalkes_id, jenisobatalkes_id, jenisobatalkes_nama, obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, kemasanbesar, kekuatan, satuankekuatan, minimalstok, satuankecil_id, satuankecil_nama, sumberdana_id, sumberdana_nama, ruangan_id, ruangan_nama, instalasi_id, tglstok_in, tglstok_out, qtystok_in, qtystok_out, qtystok_current, harganetto_oa, hargajual_oa, discount, tglkadaluarsa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, penerimaandetail_id, qtystokoa, , qtystokoa_baik, qtystokoa_rusak', 'safe', 'on'=>'search'),
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
                                    'jenisobatalkes'=>array(self::BELONGS_TO,'JenisobatalkesM','jenisobatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'stokobatalkes_id' => 'Stokobatalkes',
			'obatalkes_id' => 'Obatalkes',
			'jenisobatalkes_id' => 'Jenis Obat Alkes',
			'jenisobatalkes_nama' => 'Jenis',
			'obatalkes_kode' => 'Kode',
			'obatalkes_nama' => 'Nama',
			'obatalkes_golongan' => 'Golongan',
			'obatalkes_kategori' => 'Kategori',
			'obatalkes_kadarobat' => 'Kadar Obat',
			'kemasanbesar' => 'Kemasanbesar',
			'kekuatan' => 'Kekuatan',
			'satuankekuatan' => 'Satuan',
			'minimalstok' => 'Minimal stok',
			'satuankecil_id' => 'Satuan kecil',
			'satuankecil_nama' => 'Satuankecil',
			'sumberdana_id' => 'Asal Barang',
			'sumberdana_nama' => 'Sumberdana Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'tglstok_in' => 'Tglstok In',
			'tglstok_out' => 'Tglstok Out',
			'qtystok_in' => 'Qtystok In',
			'qtystok_out' => 'Qtystok Out',
			'qtystok_current' => 'Qtystok Current',
			'harganetto_oa' => 'Harganetto Oa',
			'hargajual_oa' => 'Hargajual Oa',
			'discount' => 'Keringanan',
			'tglkadaluarsa' => 'Tglkadaluarsa',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'penerimaandetail_id' => 'Penerimaandetail',
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
                $ruangansession = Yii::app()->user->ruangan_id;
//		$criteria->compare('stokobatalkes_id',$this->stokobatalkes_id);
//		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('minimalstok',$this->minimalstok);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('ruangan_id',$ruangansession);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(tglstok_in)',strtolower($this->tglstok_in),true);
		$criteria->compare('LOWER(tglstok_out)',strtolower($this->tglstok_out),true);
		$criteria->compare('qtystok_in',$this->qtystok_in);
		$criteria->compare('qtystok_out',$this->qtystok_out);
                if (isset($this->qtystok_current)){
                    $criteria->compare('qtystok_current',$this->qtystok_current);
                }
                if (isset($this->harganetto_oa)){
                    $criteria->compare('harganetto_oa',$this->harganetto_oa);
                }
                if (isset($this->hargajual_oa)){
                    $criteria->compare('hargajual_oa',$this->hargajual_oa);
                }
                if (isset($this->hargajual_oa)){
                    $criteria->compare('discount',$this->discount);
                }
		//$criteria->addBetweenCondition('tglkadaluarsa',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('penerimaandetail_id',$this->penerimaandetail_id);                
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchObat()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;                
                $criteria->select = "satuankecil_nama, obatalkes_nama, obatalkes_id, jenisobatalkes_id, jenisobatalkes_nama, obatalkes_golongan, obatalkes_kategori";
		$criteria->compare('ruangan_id',Yii::app()->user->ruangan_id);		
                $criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), TRUE);		
                $criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), TRUE);
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), TRUE);
                $criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);//obatalkes_nama
                $criteria->group = "satuankecil_nama, obatalkes_nama, obatalkes_id, jenisobatalkes_id, jenisobatalkes_nama, obatalkes_golongan, obatalkes_kategori";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('stokobatalkes_id',$this->stokobatalkes_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('minimalstok',$this->minimalstok);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(tglstok_in)',strtolower($this->tglstok_in),true);
		$criteria->compare('LOWER(tglstok_out)',strtolower($this->tglstok_out),true);
		$criteria->compare('qtystok_in',$this->qtystok_in);
		$criteria->compare('qtystok_out',$this->qtystok_out);
		$criteria->compare('qtystok_current',$this->qtystok_current);
		$criteria->compare('harganetto_oa',$this->harganetto_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('penerimaandetail_id',$this->penerimaandetail_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getJenisobatalkesItems()
        {
            return JenisobatalkesM::model()->findAll("jenisobatalkes_aktif = TRUE ORDER BY jenisobatalkes_nama ASC");
        }
        public function getRuanganItems()
        {
            return RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true), array('order'=>'ruangan_nama'));
        }
        
        public function getSumberdanaItems()
        {
            return SumberdanaM::model()->findAll();
        }
        
        public function getNamaJenisObat($jenisobatalkes_id) {
            $nama = "";
            $modJenis = JenisobatalkesM::model()->findByPk($jenisobatalkes_id);
            if(!empty($modJenis)){
                $nama = $modJenis->jenisobatalkes_nama;
            }
            return $nama;
        }
        
       
}