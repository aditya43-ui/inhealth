<?php

/**
 * This is the model class for table "closingkasir_t".
 *
 * The followings are the available columns in table 'closingkasir_t':
 * @property integer $closingkasir_id
 * @property integer $shift_id
 * @property integer $pegawai_id
 * @property integer $setorbank_id
 * @property string $tglclosingkasir
 * @property string $closingdari
 * @property string $sampaidengan
 * @property double $closingsaldoawal
 * @property double $terimauangmuka
 * @property double $terimauangpelayanan
 * @property double $totalpengeluaran
 * @property double $nilaiclosingtrans
 * @property double $totalsetoran
 * @property double $jmluanglogam
 * @property double $jmluangkertas
 * @property integer $jmltransaksi
 * @property double $piutang
 * @property string $keterangan_closing
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class ClosingkasirT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ClosingkasirT the static model class
	 */
        public $tgl_awal, $tgl_akhir, $bulan ,$nilaiuang,$banyakuang,$jumlahuang;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'closingkasir_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keterangan_closing, pegawai_id, tglclosingkasir, closingdari, sampaidengan, closingsaldoawal, terimauangmuka, terimauangpelayanan, nilaiclosingtrans, totalsetoran, jmluanglogam, jmluangkertas, jmltransaksi, piutang', 'required'),
			array('shift_id, pegawai_id, setorbank_id, jmltransaksi', 'numerical', 'integerOnly'=>true),
			array('closingsaldoawal, terimauangmuka, terimauangpelayanan, totalpengeluaran, nilaiclosingtrans, totalsetoran, pemakaianuangmuka, jmluanglogam, jmluangkertas, piutang, jumlahtunai, jumlahdebit, jumlahkredit', 'numerical'),
                        
			array('jumlah_returtagihan', 'safe'),
			
                        array('create_time, update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('update_loginpemakai_id', 'safe'),
                    
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update'),
                    
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('closingkasir_id, shift_id, tgl_awal, tgl_akhir, no_pendaftaran, nilaiuang, banyakuang, jumlahuang,  nama_pasien, bulan, pegawai_id, setorbank_id, tglclosingkasir, closingdari, sampaidengan, closingsaldoawal, terimauangmuka, terimauangpelayanan, totalpengeluaran, nilaiclosingtrans, totalsetoran, jmluanglogam, jmluangkertas, jmltransaksi, piutang, keterangan_closing, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jumlahtunai, jumlahdebit, jumlahkredit', 'safe', 'on'=>'search'),
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
                    'shift' => array(self::BELONGS_TO,'ShiftM','shift_id'),
                    'pegawai' => array(self::BELONGS_TO,'PegawaiM','pegawai_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'closingkasir_id' => 'Closing kasir',
			'shift_id' => 'Shift',
			'pegawai_id' => 'Pegawai',
			'setorbank_id' => 'Setor Bank',
			'tglclosingkasir' => 'Tanggal Tutup Kasir',
			'closingdari' => 'Closing Dari',
			'sampaidengan' => 'Sampai Dengan',
			'closingsaldoawal' => 'Jumlah Saldo Awal',
			'terimauangmuka' => 'Jumlah Terima Uang Muka',
			'terimauangpelayanan' => 'Jumlah Penerimaan Pelayanan',
			'totalpengeluaran' => 'Total Pengeluaran',
			'nilaiclosingtrans' => 'Total Tutup Kasir',
			'totalsetoran' => 'Total Setoran',
			'jmluanglogam' => 'Jumlah Uang Logam',
			'jmluangkertas' => 'Jumlah Uang Kertas',
			'jmltransaksi' => 'Total Transaksi',
			'piutang' => 'Jumlah Piutang',
			'keterangan_closing' => 'Keterangan Closing',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
            'closingkasir_no' => 'No. Closing Kasir'
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

		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('setorbank_id',$this->setorbank_id);
		$criteria->compare('LOWER(tglclosingkasir)',strtolower($this->tglclosingkasir),true);
		$criteria->compare('LOWER(closingdari)',strtolower($this->closingdari),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('closingsaldoawal',$this->closingsaldoawal);
		$criteria->compare('terimauangmuka',$this->terimauangmuka);
		$criteria->compare('terimauangpelayanan',$this->terimauangpelayanan);
		$criteria->compare('totalpengeluaran',$this->totalpengeluaran);
		$criteria->compare('nilaiclosingtrans',$this->nilaiclosingtrans);
		$criteria->compare('totalsetoran',$this->totalsetoran);
		$criteria->compare('jmluanglogam',$this->jmluanglogam);
		$criteria->compare('jmluangkertas',$this->jmluangkertas);
		$criteria->compare('jmltransaksi',$this->jmltransaksi);
		$criteria->compare('piutang',$this->piutang);
		$criteria->compare('LOWER(keterangan_closing)',strtolower($this->keterangan_closing),true);
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
		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('setorbank_id',$this->setorbank_id);
		$criteria->compare('LOWER(tglclosingkasir)',strtolower($this->tglclosingkasir),true);
		$criteria->compare('LOWER(closingdari)',strtolower($this->closingdari),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('closingsaldoawal',$this->closingsaldoawal);
		$criteria->compare('terimauangmuka',$this->terimauangmuka);
		$criteria->compare('terimauangpelayanan',$this->terimauangpelayanan);
		$criteria->compare('totalpengeluaran',$this->totalpengeluaran);
		$criteria->compare('nilaiclosingtrans',$this->nilaiclosingtrans);
		$criteria->compare('totalsetoran',$this->totalsetoran);
		$criteria->compare('jmluanglogam',$this->jmluanglogam);
		$criteria->compare('jmluangkertas',$this->jmluangkertas);
		$criteria->compare('jmltransaksi',$this->jmltransaksi);
		$criteria->compare('piutang',$this->piutang);
		$criteria->compare('LOWER(keterangan_closing)',strtolower($this->keterangan_closing),true);
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
        
        public function beforeSave() {
            
            if($this->tglclosingkasir===null || trim($this->tglclosingkasir)==''){
	        $this->setAttribute('tglclosingkasir', null);
            }
            
            if($this->closingdari===null || trim($this->closingdari)==''){
	        $this->setAttribute('closingdari', null);
            }
            
            if($this->sampaidengan===null || trim($this->sampaidengan)==''){
	        $this->setAttribute('sampaidengan', null);
            }            
            
            return parent::beforeSave();
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
}
