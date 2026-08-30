<?php

/**
 * This is the model class for table "laporanlembarresepluar_v".
 *
 * The followings are the available columns in table 'laporanlembarresepluar_v':
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
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property string $carabayar_nama
 * @property string $penjamin_nama
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property string $jenispenjualan
 * @property string $tglpenjualan
 * @property double $qty_oa
 */
class LaporanlembarresepluarV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanlembarresepluarV the static model class
	 */
        public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode, $tick, $data, $jumlah;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanlembarresepluar_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjualanresep_id, rke, ruangan_id, pendaftaran_id, pegawai_id, carabayar_id, penjamin_id', 'numerical', 'integerOnly'=>true),
			array('totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, qty_oa', 'numerical'),
			array('noresep, carabayar_nama, penjamin_nama', 'length', 'max'=>50),
			array('instalasiasal_nama, ruanganasal_nama, jenispenjualan', 'length', 'max'=>100),
			array('r', 'length', 'max'=>2),
			array('tglresep, tglpenjualan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penjualanresep_id, tglresep, noresep, totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, instalasiasal_nama, ruanganasal_nama, r, rke, ruangan_id, pendaftaran_id, pegawai_id, carabayar_nama, penjamin_nama, carabayar_id, penjamin_id, jenispenjualan, tglpenjualan, qty_oa', 'safe', 'on'=>'search'),
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
			'penjualanresep_id' => 'Penjualanresep',
			'tglresep' => 'Tglresep',
			'noresep' => 'Noresep',
			'totharganetto' => 'Totharganetto',
			'totalhargajual' => 'Totalhargajual',
			'totaltarifservice' => 'Totaltarifservice',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayakonseling' => 'Biayakonseling',
			'instalasiasal_nama' => 'Instalasiasal Nama',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'r' => 'R',
			'rke' => 'Rke',
			'ruangan_id' => 'Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Pegawai',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_nama' => 'Penjamin Nama',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'jenispenjualan' => 'Jenispenjualan',
			'tglpenjualan' => 'Tglpenjualan',
			'qty_oa' => 'Jumlah Oa',
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
		$criteria->compare('DATE(tglresep)',strtolower($this->tglresep),true);
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
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('DATE(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('qty_oa',$this->qty_oa);

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
		$criteria->compare('DATE(tglresep)',strtolower($this->tglresep),true);
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
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('DATE(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('qty_oa',$this->qty_oa);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}