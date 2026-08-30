<?php

/**
 * This is the model class for table "laporan10besarpenyakit_v".
 *
 * The followings are the available columns in table 'laporan10besarpenyakit_v':
 * @property integer $diagnosa_id
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property string $tglmorbiditas
 * @property integer $pasienmorbiditas_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 */
class Laporan10besarpenyakitV extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        public $jumlahTampil;
        public $jumlah;
        public $tick;
        public $data;
        public $jeniskasuspenyakit_id;
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Laporan10besarpenyakitV the static model class
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
		return 'laporan10besarpenyakit_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosa_id, pasienmorbiditas_id, ruangan_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('diagnosa_kode', 'length', 'max'=>10),
			array('diagnosa_nama', 'length', 'max'=>100),
			array('ruangan_nama, instalasi_nama', 'length', 'max'=>50),
			array('tglmorbiditas', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jumlahTampil, tgl_awal, tgl_akhir, diagnosa_id, diagnosa_kode, diagnosa_nama, tglmorbiditas, pasienmorbiditas_id, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama', 'safe', 'on'=>'search'),
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
			'diagnosa_id' => 'Diagnosa',
			'diagnosa_kode' => 'Kode Diagnosa',
			'diagnosa_nama' => 'Nama Diagnosa',
			'tglmorbiditas' => 'Tanggal Morbiditas',
			'pasienmorbiditas_id' => 'Pasienmorbiditas',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Nama Ruangan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Nama Instalasi',
                        'jumlah'=>'Jumlah Kasus',
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

		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(tglmorbiditas)',strtolower($this->tglmorbiditas),true);
		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(tglmorbiditas)',strtolower($this->tglmorbiditas),true);
		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
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
                    if ($column->dbType == 'date')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
                     else if ($column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }    
            }

            return parent::beforeValidate ();
        }

        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
        
        public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAll('carabayar_aktif=TRUE') ;
        }
        
        public function getPenjaminItems()
        {
            return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE');
        }
        
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
        }
        
        public function getNamaNamaBIN()
        {
            return $this->nama_pasien.' bin '.$this->nama_bin;
        }
        
        public function getCaraBayarPenjamin()
        {
                return $this->carabayar_nama.'/'.$this->penjamin_nama;
        }
        
        public function getRTRW()
        {
            return $this->rt.' / '.$this->rw;
        }
        
        public function primaryKey() {
            return 'diagnosa_id';
        }
}