<?php

/**
 * This is the model class for table "returresep_t".
 *
 * The followings are the available columns in table 'returresep_t':
 * @property integer $returresep_id
 * @property integer $ruangan_id
 * @property integer $penjualanresep_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property string $tglretur
 * @property string $noreturresep
 * @property string $alasanretur
 * @property string $keteranganretur
 * @property integer $mengetahui_id
 * @property integer $pegretur_id
 * @property double $totalretur
 */
class ReturresepT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturresepT the static model class
	 */
	public $tgl_awal, $tgl_akhir;
	public $instalasiasal_nama;
	public $ruanganasal_nama;
	public $tglpenjualan;
	public $noresep;
	public $tgl_pendaftaran;
	public $no_pendaftaran;
	public $no_rekam_medik;
	public $nama_pasien;
	public $carabayar_nama;
	public $penjamin_nama;
	public $dokterresep_id;
	public $carabayar_id;
	public $penjamin_id;	
	public $instalasiasal_id;
	public $ruanganasal_id;

	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'returresep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pasien_id, tglretur, noreturresep, alasanretur, pegretur_id, totalretur', 'required'),
			array('ruangan_id, penjualanresep_id, pendaftaran_id, pasien_id, pasienadmisi_id, mengetahui_id, pegretur_id', 'numerical', 'integerOnly'=>true),
			array('totalretur', 'numerical'),
			array('noreturresep', 'length', 'max'=>50),
			array('alasanretur', 'length', 'max'=>200),
			array('keteranganretur', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('returresep_id, ruangan_id, penjualanresep_id, tgl_awal, tgl_akhir, pendaftaran_id, pasien_id, pasienadmisi_id, tglretur, noreturresep, alasanretur, keteranganretur, mengetahui_id, pegretur_id, totalretur', 'safe', 'on'=>'search'),
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
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','mengetahui_id'),
                    'pegawairetur'=>array(self::BELONGS_TO, 'PegawaiM','pegretur_id'),
                    'pasien'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
                    'penjualanresep'=>array(self::BELONGS_TO,'PenjualanresepT','penjualanresep_id'),
                    'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
                    'pasienadmisi'=>array(self::BELONGS_TO,'PasienadmisiT','pasienadmisi_id'),
					'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'returresep_id' => 'Retur Resep Id',
			'ruangan_id' => 'Ruangan',
			'penjualanresep_id' => 'No. Penjualan Resep',
			'pendaftaran_id' => 'No. Pendaftaran',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasien Admisi',
			'tglretur' => 'Tanggal Retur',
			'noreturresep' => 'No. Retur',
			'alasanretur' => 'Alasan Retur',
			'keteranganretur' => 'Keterangan Retur',
			'mengetahui_id' => 'Mengetahui',
			// 'pegretur_id' => 'Pegawai Retur',
			'totalretur' => 'Total Retur',
			'instalasiasal_nama' => 'Instalasi',
			'ruanganasal_nama' => 'Ruangan',
			'dokterresep_id' => 'Dokter Resep',
			'penjamin_id' => 'Penjamin',
			'carabayar_id' => 'Jenis Penjamin',
			'pegretur_id'=>'Petugas Farmasi',
			'instalasiasal_id'=>'Instalasi',
			'ruanganasal_id'=>'Ruangan',
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

		$criteria->compare('returresep_id',$this->returresep_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglretur)',strtolower($this->tglretur),true);
		$criteria->compare('LOWER(noreturresep)',strtolower($this->noreturresep),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('pegretur_id',$this->pegretur_id);
		$criteria->compare('totalretur',$this->totalretur);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchReturPenjualan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = " t.pasien_id, t.pegretur_id, pr.instalasiasal_nama, PR.ruanganasal_nama, t.returresep_id, t.tglretur, t.noreturresep, t.penjualanresep_id, pr.tglpenjualan, pr.noresep, p.tgl_pendaftaran, p.no_pendaftaran "
						.	" , pa.no_rekam_medik, pa.nama_pasien, c.carabayar_nama, pp.penjamin_nama, pr.pegawai_id as dokterresep_id, t.pegretur_id";		
		$criteria->join = " LEFT JOIN penjualanresep_t pr ON pr.penjualanresep_id = t.penjualanresep_id "
						. "	LEFT JOIN pendaftaran_t p ON p.pendaftaran_id = t.pendaftaran_id "
						. " JOIN pasien_m pa ON pa.pasien_id = t.pasien_id "
						. " LEFT JOIN carabayar_m c ON c.carabayar_id = pr.carabayar_id "
						. " LEFT JOIN penjaminpasien_m pp ON pp.penjamin_id = pr.penjamin_id "
						. "	LEFT JOIN pegawai_m peg ON peg.pegawai_id = pr.pegawai_id ";
		$criteria->addBetweenCondition('DATE(tglretur)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('returresep_id',$this->returresep_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglretur)',strtolower($this->tglretur),true);
		$criteria->compare('LOWER(noreturresep)',strtolower($this->noreturresep),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('pegretur_id',$this->pegretur_id);
		$criteria->compare('totalretur',$this->totalretur);
		
		if (!empty($this->dokterresep_id)){
			$criteria->addCondition(" pr.pegawai_id = '".$this->dokterresep_id."' ");
		}
		
		if (!empty($this->pegretur_id)){
			$criteria->addCondition(" t.pegretur_id = '".$this->pegretur_id."' ");
		}
		
		if (!empty($this->carabayar_id)){
			$criteria->addCondition(" c.carabayar_id = '".$this->carabayar_id."' ");
		}
		
		if (!empty($this->penjamin_id)){
			$criteria->addCondition(" pp.penjamin_id = '".$this->penjamin_id."' ");
		}
		
		if (!empty($this->ruanganasal_id)){
			$r = RuanganM::model()->findByPk($this->ruanganasal_id);
			$criteria->addCondition(" LOWER(pr.ruanganasal_nama ) = '". strtolower($r->ruangan_nama)."' ");
		}
		
		if (!empty($this->instalasiasal_id)){
			$i = InstalasiM::model()->findByPk($this->instalasiasal_id);
			$criteria->addCondition(" LOWER(pr.instalasiasal_nama ) = '". strtolower($i->instalasi_nama)."' ");
		}
		
		$criteria->order='tglretur DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('returresep_id',$this->returresep_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglretur)',strtolower($this->tglretur),true);
		$criteria->compare('LOWER(noreturresep)',strtolower($this->noreturresep),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('pegretur_id',$this->pegretur_id);
		$criteria->compare('totalretur',$this->totalretur);
		$criteria->order='tglretur DESC';
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