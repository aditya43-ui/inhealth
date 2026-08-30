<?php

/**
 * This is the model class for table "pesanmenudiet_t".
 *
 * The followings are the available columns in table 'pesanmenudiet_t':
 * @property integer $pesanmenudiet_id
 * @property integer $ruangan_id
 * @property integer $kirimmenudiet_id
 * @property integer $jenisdiet_id
 * @property integer $bahandiet_id
 * @property string $jenispesanmenu
 * @property string $nopesanmenu
 * @property string $tglpesanmenu
 * @property string $adaalergimakanan
 * @property string $keterangan_pesan
 * @property string $nama_pemesan
 * @property integer $totalpesan_org
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PesanmenudietT extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        public $instalasi_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesanmenudietT the static model class
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
		return 'pesanmenudiet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, jenispesanmenu, nopesanmenu, tglpesanmenu, nama_pemesan,', 'required'),
			array('ruangan_id, bahandiet_id,kirimmenudiet_id, jenisdiet_id, bahandiet_id, totalpesan_org, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('jenispesanmenu, nopesanmenu', 'length', 'max'=>50),
			array('adaalergimakanan, nama_pemesan', 'length', 'max'=>100),
			array('status_terima,keterangan_pesan, update_time, update_loginpemakai_id, pendaftaran_id, verifikasi_id, pasien_id', 'safe'),
			array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, pesanmenudiet_id, ruangan_id, kirimmenudiet_id, jenisdiet_id, bahandiet_id, jenispesanmenu, nopesanmenu, tglpesanmenu, adaalergimakanan, keterangan_pesan, nama_pemesan, totalpesan_org, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pendaftaran_id', 'safe', 'on'=>'search'),
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
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                    'jenisdiet'=>array(self::BELONGS_TO, 'JenisdietM', 'jenisdiet_id'),
                    'bahandiet'=>array(self::BELONGS_TO, 'BahandietM', 'bahandiet_id'),
                    'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
					'kelaspelayanan'=>array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
					'loginpemakai'=>array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
					'pegawaiverif'=>array(self::BELONGS_TO, 'PegawaiM', 'verifikasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesanmenudiet_id' => 'Pesan Menu Diet',
			'ruangan_id' => 'Ruangan',
			'kirimmenudiet_id' => 'Kirim Menu Diet',
			'jenisdiet_id' => 'Jenis Diet',
			'bahandiet_id' => 'Bahan Diet',
			'jenispesanmenu' => 'Jenis Pesan Menu',
			'nopesanmenu' => 'No. Pesan Menu',
			'tglpesanmenu' => 'Tanggal Pesan Menu',
			'adaalergimakanan' => 'Ada Alergi Makanan',
			'keterangan_pesan' => 'Keterangan Pesan',
			'nama_pemesan' => 'Nama Pemesan',
			'totalpesan_org' => 'Total Pesan Org',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'carabayar_id' => 'Cara Bayar',
			'penjamin_id' => 'Penjamin',
                        'status_terima' => 'Status Terima',
                        'instalasi_id' => 'Instalasi'
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

		$criteria->compare('pesanmenudiet_id',$this->pesanmenudiet_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('bahandiet_id',$this->bahandiet_id);
		$criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
		$criteria->compare('LOWER(nopesanmenu)',strtolower($this->nopesanmenu),true);
		$criteria->compare('LOWER(tglpesanmenu)',strtolower($this->tglpesanmenu),true);
		$criteria->compare('LOWER(adaalergimakanan)',strtolower($this->adaalergimakanan),true);
		$criteria->compare('LOWER(keterangan_pesan)',strtolower($this->keterangan_pesan),true);
		$criteria->compare('LOWER(nama_pemesan)',strtolower($this->nama_pemesan),true);
		$criteria->compare('totalpesan_org',$this->totalpesan_org);
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
		$criteria->compare('pesanmenudiet_id',$this->pesanmenudiet_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('bahandiet_id',$this->bahandiet_id);
		$criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
		$criteria->compare('LOWER(nopesanmenu)',strtolower($this->nopesanmenu),true);
		$criteria->compare('LOWER(tglpesanmenu)',strtolower($this->tglpesanmenu),true);
		$criteria->compare('LOWER(adaalergimakanan)',strtolower($this->adaalergimakanan),true);
		$criteria->compare('LOWER(keterangan_pesan)',strtolower($this->keterangan_pesan),true);
		$criteria->compare('LOWER(nama_pemesan)',strtolower($this->nama_pemesan),true);
		$criteria->compare('totalpesan_org',$this->totalpesan_org);
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
        
//        DIKOMENTAR UNTUK MENGHINDARI BUGS
//        UNTUK FORMATTING BAIKNYA DILAKUKAN DI CONTROLLER / VIEW
//        protected function beforeValidate ()
//        {
//            // convert to storage format
//            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
//            $format = new MyFormatter();
//            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//                    if ($column->dbType == 'date')
//                        {
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                        }
//                     else if ($column->dbType == 'timestamp without time zone')
//                        {
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                        }    
//            }
//
//            return parent::beforeValidate ();
//        }
//
//        public function beforeSave() {         
//            if($this->tglpesanmenu===null || trim($this->tglpesanmenu)==''){
//	        $this->setAttribute('tglkirimmenu', null);
//            }
//            
//            return parent::beforeSave();
//        }
//
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){                         
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                        }elseif ($column->dbType == 'timestamp without time zone'){
//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
//                        }
//            }
//            return true;
//        }
}