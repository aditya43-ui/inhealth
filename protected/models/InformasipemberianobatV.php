<?php

/**
 * This is the model class for table "informasipemberianobat_v".
 *
 * The followings are the available columns in table 'informasipemberianobat_v':
 * @property integer $reseptur_id
 * @property integer $resepturdetail_id
 * @property string $tglreseptur
 * @property string $noresep
 * @property integer $ruangan_id
 * @property string $no_pendaftaran
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $obatalkes_id
 * @property string $obatalkes_nama
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property double $qty_reseptur
 * @property double $qty_penjualan
 * @property double $sisa
 * @property string $status
 */
class InformasipemberianobatV extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasipemberianobat_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reseptur_id, resepturdetail_id, ruangan_id, pendaftaran_id, pasien_id, obatalkes_id, satuankecil_id', 'numerical', 'integerOnly'=>true),
			array('qty_reseptur, qty_penjualan, sisa', 'numerical'),
			array('noresep, nama_pasien, satuankecil_nama', 'length', 'max'=>50),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('obatalkes_nama', 'length', 'max'=>200),
			array('tglreseptur, status', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('reseptur_id, resepturdetail_id, tglreseptur, noresep, ruangan_id, no_pendaftaran, pendaftaran_id, pasien_id, no_rekam_medik, nama_pasien, obatalkes_id, obatalkes_nama, satuankecil_id, satuankecil_nama, qty_reseptur, qty_penjualan, sisa, status', 'safe', 'on'=>'search'),
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
			'reseptur_id' => 'Reseptur',
			'resepturdetail_id' => 'Resepturdetail',
			'tglreseptur' => 'Tglreseptur',
			'noresep' => 'No resep',
			'ruangan_id' => 'Ruangan',
			'no_pendaftaran' => 'No Pendaftaran',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'obatalkes_id' => 'Obatalkes',
			'obatalkes_nama' => 'Nama Obat',
			'satuankecil_id' => 'Satuankecil',
			'satuankecil_nama' => 'Satuan',
			'qty_reseptur' => 'Qty Reseptur',
			'qty_penjualan' => 'Qty Penjualan',
			'sisa' => 'Sisa',
			'status' => 'Status',
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

		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('resepturdetail_id',$this->resepturdetail_id);
		$criteria->compare('tglreseptur',$this->tglreseptur,true);
		$criteria->compare('noresep',$this->noresep,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('obatalkes_nama',$this->obatalkes_nama,true);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('satuankecil_nama',$this->satuankecil_nama,true);
		$criteria->compare('qty_reseptur',$this->qty_reseptur);
		$criteria->compare('qty_penjualan',$this->qty_penjualan);
		$criteria->compare('sisa',$this->sisa);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchInformasi()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->addBetweenCondition('date(tglreseptur)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('resepturdetail_id',$this->resepturdetail_id);
                $criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
                $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
                $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
                $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
                $criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('qty_reseptur',$this->qty_reseptur);
		$criteria->compare('qty_penjualan',$this->qty_penjualan);
		$criteria->compare('sisa',$this->sisa);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->addBetweenCondition('date(tglreseptur)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('resepturdetail_id',$this->resepturdetail_id);
                $criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
                $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
                $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
                $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
                $criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('qty_reseptur',$this->qty_reseptur);
		$criteria->compare('qty_penjualan',$this->qty_penjualan);
		$criteria->compare('sisa',$this->sisa);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                    'pagination' => false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasipemberianobatV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
