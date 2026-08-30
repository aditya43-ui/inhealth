<?php

/**
 * This is the model class for table "pegawaicuti_t".
 *
 * The followings are the available columns in table 'pegawaicuti_t':
 * @property integer $pegawaicuti_id
 * @property integer $jeniscuti_id
 * @property integer $pegawai_id
 * @property string $tglmulaicuti
 * @property string $tglakhircuti
 * @property string $lamacuti
 * @property string $noskcuti
 * @property string $tglditetapkanskcuti
 * @property string $keterangan
 * @property string $keperluancuti
 * @property string $pejabatmenyetujui
 * @property string $pejabatmengetahui
 */
class PegawaicutiT extends CActiveRecord
{
        public $nama_pegawai;
        public $status_cuti;
        public $pejabatmengetahui_nama, $lamacuti_pegawai; 
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaicutiT the static model class
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
		return 'pegawaicuti_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniscuti_id, pegawai_id, tglmulaicuti', 'required'),
			array('jeniscuti_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('lamacuti, noskcuti', 'length', 'max'=>10),
			array('pejabatmenyetujui, pejabatmengetahui', 'length', 'max'=>100),
			array('status_cuti, pegpengganti_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_menyetujui, tglakhircuti, keterangan, keperluancuti', 'safe'),
            array('lamacuti', 'validasiJatahCuti'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawaicuti_id, jeniscuti_id, pegawai_id, tglmulaicuti, tglakhircuti, lamacuti, noskcuti, tglditetapkanskcuti, keterangan, keperluancuti, pejabatmenyetujui, pejabatmengetahui', 'safe', 'on'=>'search'),
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
			'jeniscuti'=>array(self::BELONGS_TO,'JeniscutiM','jeniscuti_id'),
                        'pegMengetahui'=>array(self::BELONGS_TO,'PegawaiM','pejabatmengetahui'),
                        'pegMenyetujui'=>array(self::BELONGS_TO,'PegawaiM','pejabatmenyetujui'),
                        'pegpengganti'=>array(self::BELONGS_TO,'PegawaiM','pegpengganti_id'),
                        'pemohon'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return array(
                'pegawaicuti_id' => 'ID',
                'jeniscuti_id' => 'Jenis Cuti',
                'pegawai_id' => 'Pegawai',
                'tglmulaicuti' => 'Tanggal Mulai',
                'tglakhircuti' => 'Sampai Dengan',
                'lamacuti' => 'Lama Cuti',
                'noskcuti' => 'No. SK',
                'tglditetapkanskcuti' => 'Tanggal SK',
                'keterangan' => 'Keterangan',
                'keperluancuti' => 'Keperluan',
                'pejabatmenyetujui' => 'Kabag Umum',
                'pejabatmengetahui' => 'Atasan Langsung',
                'pegpengganti_id' => 'Pegawai Pengganti',
                'status_cuti' => 'Status'
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

		$criteria->compare('pegawaicuti_id',$this->pegawaicuti_id);
		$criteria->compare('jeniscuti_id',$this->jeniscuti_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglmulaicuti)',strtolower($this->tglmulaicuti),true);
		$criteria->compare('LOWER(tglakhircuti)',strtolower($this->tglakhircuti),true);
		$criteria->compare('LOWER(lamacuti)',strtolower($this->lamacuti),true);
		$criteria->compare('LOWER(noskcuti)',strtolower($this->noskcuti),true);
		$criteria->compare('LOWER(tglditetapkanskcuti)',strtolower($this->tglditetapkanskcuti),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(keperluancuti)',strtolower($this->keperluancuti),true);
		$criteria->compare('LOWER(pejabatmenyetujui)',strtolower($this->pejabatmenyetujui),true);
		$criteria->compare('LOWER(pejabatmengetahui)',strtolower($this->pejabatmengetahui),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pegawaicuti_id',$this->pegawaicuti_id);
		$criteria->compare('jeniscuti_id',$this->jeniscuti_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglmulaicuti)',strtolower($this->tglmulaicuti),true);
		$criteria->compare('LOWER(tglakhircuti)',strtolower($this->tglakhircuti),true);
		$criteria->compare('LOWER(lamacuti)',strtolower($this->lamacuti),true);
		$criteria->compare('LOWER(noskcuti)',strtolower($this->noskcuti),true);
		$criteria->compare('LOWER(tglditetapkanskcuti)',strtolower($this->tglditetapkanskcuti),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(keperluancuti)',strtolower($this->keperluancuti),true);
		$criteria->compare('LOWER(pejabatmenyetujui)',strtolower($this->pejabatmenyetujui),true);
		$criteria->compare('LOWER(pejabatmengetahui)',strtolower($this->pejabatmengetahui),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getJeniscutiItems() {
            return JeniscutiM::model()->findAll('jeniscuti_aktif=TRUE ORDER BY jeniscuti_nama');
        }
        
        public function getPegawaiItems() {
            return PegawaiM::model()->findAll('pegawai_aktif=TRUE ORDER BY nama_pegawai');
        }
//		RND-8362    
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//                if (!strlen($this->$columnName)) continue;
//                if ($column->dbType == 'date'){
//                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                }elseif ($column->dbType == 'timestamp without time zone'){
//                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                            CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
//                }
//            }
//            return true;
//        }       

        
        public function validasiJatahCuti($attr) {
            
            $tahun_cuti = date('Y', strtotime($this->tglmulaicuti));
            $konfig = KonfigsystemK::model()->find();
            
            
            $cr = new CDbCriteria();
            $cr->compare('status_cuti', Params::STATUS_CUTI_DISETUJUI);
            $cr->compare('pegawai_id',$this->pegawai_id);
            $cr->addCondition("date_part('year', tglmulaicuti) = ".date('Y'));
            $cr->addCondition("jeniscuti_id <> 2");
            if (!empty($this->pegawaicuti_id)) {
                $cr->addCondition('pegawaicuti_id <> '.$this->pegawaicuti_id);
            }
            
            $cutiBulanSekarang = 0;
            
            $modCutiPeg = PegawaicutiT::model()->findAll($cr);
            if(count((array)$modCutiPeg)>0){
                foreach ($modCutiPeg as $cutiPeg){
                    $tglawal = $cutiPeg->tglmulaicuti;
                    $tglakhir = $cutiPeg->tglakhircuti;
                      
                    if(date('Y', strtotime($cutiPeg->tglmulaicuti)) < date('Y')){
                        $tglawal = date('d-m-Y', strtotime('first day of january this year'));
                    }
                    if(date('Y', strtotime($cutiPeg->tglakhircuti)) > date('Y')){
                        $tglakhir = date('d-m-Y', strtotime('last day of december this year'));
                    }
                    $cutiBulanSekarang += CustomFunction::hitungHari($tglakhir, $tglawal) + 1;
                }
            }
            
            
            //  $konfig->lama_cuti = 8; // untuk debugging
            
            // var_dump($konfig->attributes);
            if (($cutiBulanSekarang + $this->$attr) > $konfig->lama_cuti && $this->status_cuti != Params::STATUS_CUTI_DITOLAK && $this->jeniscuti_id != 2) {
                $this->addError($attr, "Lama cuti yang diajukan sudah melampaui lama cuti yang ditentukan pertahun. (>".$konfig->lama_cuti." hari)");
            }
            
        }
        
        
}