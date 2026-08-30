<?php

/**
 * This is the model class for table "laporanlembarresep_v".
 *
 * The followings are the available columns in table 'laporanlembarresep_v':
 * @property integer $penjualanresep_id
 * @property string $tglresep
 * @property string $noresep
 * @property double $totharganetto
 * @property double $totalhargajual
 * @property double $totaltarifservice
 * @property double $biayaadministrasi
 * @property double $biayakonseling
 * @property string $instalasiasal_nama
 * @property string $ruanganasal_nama
 * @property string $r
 * @property integer $rke
 * @property integer $ruangan_id
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property integer $pendaftaran_id
 */
class LaporanlembarresepV extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode, $jumlah, $data, $tick, $pegawai_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanlembarresepV the static model class
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
		return 'laporanlembarresep_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjualanresep_id, rke, pegawai_id, ruangan_id, penjamin_id, carabayar_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling', 'numerical'),
			array('noresep', 'length', 'max'=>50),
			array('carabayar_nama, penjamin_nama, instalasiasal_nama, ruanganasal_nama', 'length', 'max'=>100),
			array('r', 'length', 'max'=>2),
			array('tglresep', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, penjualanresep_id, tglresep, noresep, totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, instalasiasal_nama, ruanganasal_nama, r, rke, ruangan_id, penjamin_id, carabayar_id, pendaftaran_id', 'safe', 'on'=>'search'),
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
                    'penjamin'=>array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
                    'carabayar'=>array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penjualanresep_id' => 'Penjualan Resep',
			'tglresep' => 'Tanggal Resep',
			'noresep' => 'No. Resep',
			'totharganetto' => 'Total Harga Netto',
			'totalhargajual' => 'Total Harga Jual',
			'totaltarifservice' => 'Total Tarif Sservice',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayakonseling' => 'Biaya Konseling',
			'instalasiasal_nama' => 'Instalasi Asal Nama',
			'ruanganasal_nama' => 'Ruangan Asal Nama',
			'r' => 'R',
			'rke' => 'Rke',
			'ruangan_id' => 'Ruangan',
			'penjamin_id' => 'Penjamin',
			'carabayar_id' => 'Jenis Penjamin',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Dokter',
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

		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('totharganetto',$this->totharganetto);
		$criteria->compare('totalhargajual',$this->totalhargajual);
		$criteria->compare('totaltarifservice',$this->totaltarifservice);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('biayakonseling',$this->biayakonseling);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('totharganetto',$this->totharganetto);
		$criteria->compare('totalhargajual',$this->totalhargajual);
		$criteria->compare('totaltarifservice',$this->totaltarifservice);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('biayakonseling',$this->biayakonseling);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}