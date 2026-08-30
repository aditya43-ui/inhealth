<?php

/**
 * This is the model class for table "permintaankepenunjang_t".
 *
 * The followings are the available columns in table 'permintaankepenunjang_t':
 * @property integer $permintaankepenunjang_id
 * @property integer $daftartindakan_id
 * @property integer $pemeriksaanrad_id
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $pemeriksaanlab_id
 * @property string $noperminatanpenujang
 * @property string $tglpermintaankepenunjang
 * @property integer $qtypermintaan
 */
class PermintaankepenunjangT extends CActiveRecord
{
        public $tipepaket_id, $jenistarif_id, $tarif_satuan, $tarif_tindakan, $satuantindakan, $pemeriksaanlab_nama, $pemeriksaanlab_kode;
	public $tindakansudahbayar_id, $qty_tindakan, $is_cito, $jenispemeriksaanrad_nama, $pemeriksaanrad_nama, $jenispemeriksaanlab_nama;
	public $lokasianatomi_lainnya, $pemeriksaanrad_kode;

	public $jenispemeriksaanlab_id, $samplelab_nama;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermintaankepenunjangT the static model class
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
		return 'permintaankepenunjang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienkirimkeunitlain_id, noperminatanpenujang, tglpermintaankepenunjang', 'required'),
			array('daftartindakan_id, pemeriksaanrad_id, pasienkirimkeunitlain_id, pemeriksaanlab_id, qtypermintaan, tarif_pelayananan, tindakanpelayanan_id', 'numerical', 'integerOnly'=>true),
			array('noperminatanpenujang', 'length', 'max'=>50),
			array('diambil, dititip, jumlah_kantong', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('permintaankepenunjang_id, daftartindakan_id, pemeriksaanrad_id, pasienkirimkeunitlain_id, pemeriksaanlab_id, noperminatanpenujang, tglpermintaankepenunjang, qtypermintaan, tindakanpelayanan_id, diambil, dititip, jumlah_kantong', 'safe', 'on'=>'search'),
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
                    'daftartindakan'=>array(self::BELONGS_TO,'DaftartindakanM','daftartindakan_id'),
                    'pemeriksaanlab'=>array(self::BELONGS_TO,'PemeriksaanlabM','pemeriksaanlab_id'),
                    'pemeriksaanrad'=>array(self::BELONGS_TO,'PemeriksaanradM','pemeriksaanrad_id'),
                    'operasi'=>array(self::BELONGS_TO,'OperasiM','operasi_id'),
                    'tindakanrm'=>array(self::BELONGS_TO,'TindakanrmM','tindakanrm_id'),
                    'tindakanpelayanan'=>array(self::BELONGS_TO,'TindakanpelayananT','tindakanpelayanan_id'),
                    'samplelab'=>array(self::BELONGS_TO,'SamplelabM','samplelab_id'),
                    'pasienkirimkeunitlain'=>array(self::BELONGS_TO,'PasienkirimkeunitlainT','pasienkirimkeunitlain_id'),
					'jeniskomponendarah' => array(self::BELONGS_TO, 'JeniskomponendarahM', 'jeniskomponendarah_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'permintaankepenunjang_id' => 'Permintaan Ke Penunjang',
			'daftartindakan_id' => 'Daftar Tindakan',
			'pemeriksaanrad_id' => 'Pemeriksaan Rad',
			'pasienkirimkeunitlain_id' => 'Pasien Kirim Ke Unit Lain',
			'pemeriksaanlab_id' => 'Pemeriksaan Lab',
			'noperminatanpenujang' => 'No. Permintaan Penunjang',
			'tglpermintaankepenunjang' => 'Tgl. Permintaan',
			'qtypermintaan' => 'Jml. Permintaan',
			'tarif_pelayananan' => 'Tarif Pelayanan',
			'tindakanpelayanan_id' => 'Tindakan Pelayanan',
			'jenis_pasientbc' => 'Jenis Terduga/Pasien TBC',
			'rekasi_transfusi' => 'Reaksi Transfusi'
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

		$criteria->compare('permintaankepenunjang_id',$this->permintaankepenunjang_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('LOWER(noperminatanpenujang)',strtolower($this->noperminatanpenujang),true);
		$criteria->compare('LOWER(tglpermintaankepenunjang)',strtolower($this->tglpermintaankepenunjang),true);
		$criteria->compare('LOWER(tarif_pelayananan)',strtolower($this->tarif_pelayananan),true);
		$criteria->compare('qtypermintaan',$this->qtypermintaan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('permintaankepenunjang_id',$this->permintaankepenunjang_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('LOWER(noperminatanpenujang)',strtolower($this->noperminatanpenujang),true);
		$criteria->compare('LOWER(tglpermintaankepenunjang)',strtolower($this->tglpermintaankepenunjang),true);
		$criteria->compare('LOWER(tarif_pelayananan)',strtolower($this->tarif_pelayananan),true);
		$criteria->compare('qtypermintaan',$this->qtypermintaan);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                        }
            }
            return true;
        }
}