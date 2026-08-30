<?php

/**
 * This is the model class for table "penerimaanumum_t".
 *
 * The followings are the available columns in table 'penerimaanumum_t':
 * @property integer $penerimaanumum_id
 * @property integer $tandabuktibayar_id
 * @property integer $ruangan_id
 * @property integer $jenispenerimaan_id
 * @property integer $penjamin_id
 * @property string $tglpenerimaan
 * @property string $nopenerimaan
 * @property string $kelompoktransaksi
 * @property double $volume
 * @property string $satuanvol
 * @property double $hargasatuan
 * @property double $totalharga
 * @property string $keterangan_penerimaan
 * @property string $namapenandatangan
 * @property string $nippenandatangan
 * @property string $jabatanpenandatangan
 * @property boolean $isuraintransaksi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PenerimaanumumT extends CActiveRecord
{
    public $jenisKodeNama;
    public $tgl_awal;
    public $tgl_akhir;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaanumumT the static model class
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
		return 'penerimaanumum_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, jenispenerimaan_id, penjamin_id, tglpenerimaan, nopenerimaan, kelompoktransaksi, volume, hargasatuan, totalharga', 'required'),
			array('tandabuktibayar_id, ruangan_id, jenispenerimaan_id, penjamin_id, shift_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('volume, hargasatuan, totalharga, jmlpph_21', 'numerical'),
			array('nopenerimaan', 'length', 'max'=>20),
			array('kelompoktransaksi, satuanvol', 'length', 'max'=>50),
			array('namapenandatangan, nippenandatangan, jabatanpenandatangan', 'length', 'max'=>100),
			array('jenisKodeNama, keterangan_penerimaan, isuraintransaksi, update_time, update_loginpemakai_id, jmlpph_22, jmlpph_23, ppn', 'safe'),
                    
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penerimaanumum_id, tandabuktibayar_id, ruangan_id, jenispenerimaan_id, penjamin_id, tglpenerimaan, nopenerimaan, kelompoktransaksi, volume, satuanvol, hargasatuan, totalharga, keterangan_penerimaan, namapenandatangan, nippenandatangan, jabatanpenandatangan, isuraintransaksi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jmlpph_22, jmlpph_23, jmlpph_21, shift_id, pegawai_id', 'safe', 'on'=>'search'),
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
                    'jenispenerimaan'=>array(self::BELONGS_TO, 'JenispenerimaanM', 'jenispenerimaan_id'),
                    'buktibayar'=>array(self::BELONGS_TO, 'TandabuktibayarT', 'tandabuktibayar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penerimaanumum_id' => 'Penerimaanumum',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'ruangan_id' => 'Ruangan',
			'jenispenerimaan_id' => 'Jenis Penerimaan',
			'penjamin_id' => 'Penjamin',
			'tglpenerimaan' => 'Tanggal Penerimaan',
			'nopenerimaan' => 'No. Penerimaan',
			'kelompoktransaksi' => 'Kelompok Transaksi',
			'volume' => 'Volume',
			'satuanvol' => 'Satuan Vol',
			'hargasatuan' => 'Harga Satuan',
			'totalharga' => 'Total Harga',
			'keterangan_penerimaan' => 'Keterangan Penerimaan',
			'namapenandatangan' => 'Nama Penanda Tangan',
			'nippenandatangan' => 'NIP Penanda Tangan',
			'jabatanpenandatangan' => 'Jabatan Penanda Tangan',
			'isuraintransaksi' => 'Uraian Transaksi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'tgl_awal'=>'Tanggal Awal',
                        'tgl_akhir'=>'Tanggal Akhir',
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

		$criteria->compare('penerimaanumum_id',$this->penerimaanumum_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jenispenerimaan_id',$this->jenispenerimaan_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(tglpenerimaan)',strtolower($this->tglpenerimaan),true);
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(kelompoktransaksi)',strtolower($this->kelompoktransaksi),true);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('LOWER(satuanvol)',strtolower($this->satuanvol),true);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('LOWER(keterangan_penerimaan)',strtolower($this->keterangan_penerimaan),true);
		$criteria->compare('LOWER(namapenandatangan)',strtolower($this->namapenandatangan),true);
		$criteria->compare('LOWER(nippenandatangan)',strtolower($this->nippenandatangan),true);
		$criteria->compare('LOWER(jabatanpenandatangan)',strtolower($this->jabatanpenandatangan),true);
		$criteria->compare('isuraintransaksi',$this->isuraintransaksi);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('penerimaanumum_id',$this->penerimaanumum_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jenispenerimaan_id',$this->jenispenerimaan_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(tglpenerimaan)',strtolower($this->tglpenerimaan),true);
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(kelompoktransaksi)',strtolower($this->kelompoktransaksi),true);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('LOWER(satuanvol)',strtolower($this->satuanvol),true);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('LOWER(keterangan_penerimaan)',strtolower($this->keterangan_penerimaan),true);
		$criteria->compare('LOWER(namapenandatangan)',strtolower($this->namapenandatangan),true);
		$criteria->compare('LOWER(nippenandatangan)',strtolower($this->nippenandatangan),true);
		$criteria->compare('LOWER(jabatanpenandatangan)',strtolower($this->jabatanpenandatangan),true);
		$criteria->compare('isuraintransaksi',$this->isuraintransaksi);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date'){
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }elseif ($column->dbType == 'timestamp without time zone'){
                            //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }
            }

            return parent::beforeValidate ();
        }
                
        protected function afterFind()
        {
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
        
        /**
         * Mengambil daftar semua penjamin
         * @return CActiveDataProvider 
         */
        public function getPenjaminItems($idCarabayar='')
        {
            if($idCarabayar!='')
                return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$idCarabayar,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
            else
                return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
        }
}