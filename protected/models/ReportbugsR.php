<?php

/**
 * This is the model class for table "reportbugs_r".
 *
 * The followings are the available columns in table 'reportbugs_r':
 * @property integer $reportbugs_id
 * @property string $kodebugs
 * @property string $judul_bugs
 * @property string $link_bugs
 * @property string $type_bugs
 * @property string $file_bugs
 * @property string $line_bugs
 * @property string $pesan_bugs
 * @property integer $prioritas_bugs
 * @property integer $create_login_id
 * @property integer $create_pegawai_id
 * @property integer $create_instalasi_id
 * @property integer $create_ruangan_id
 * @property integer $create_modul_id
 * @property string $create_datetime
 * @property string $create_hostname_pc
 * @property string $create_browser_pc
 * @property boolean $isajax_bugs
 * @property string $create_login_nama
 */
class ReportbugsR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReportbugsR the static model class
	 */
    
        public $tgl_awal, $tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reportbugs_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kodebugs, judul_bugs, link_bugs, type_bugs, prioritas_bugs, create_datetime, create_hostname_pc, create_browser_pc, create_login_nama', 'required'),
			array('prioritas_bugs, create_login_id, create_pegawai_id, create_instalasi_id, create_ruangan_id, create_modul_id', 'numerical', 'integerOnly'=>true),
//			JIKA MELAMPAUI SEBAGIAN DATA TERPOTONG
//			array('kodebugs', 'length', 'max'=>50),
//			array('judul_bugs', 'length', 'max'=>200),
//			array('link_bugs', 'length', 'max'=>500),
//			array('type_bugs, file_bugs, line_bugs, create_hostname_pc, create_browser_pc', 'length', 'max'=>100),
//			array('create_login_nama', 'length', 'max'=>150),
//			array('pesan_bugs, isajax_bugs', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, reportbugs_id, kodebugs, judul_bugs, link_bugs, type_bugs, file_bugs, line_bugs, pesan_bugs, prioritas_bugs, create_login_id, create_pegawai_id, create_instalasi_id, create_ruangan_id, create_modul_id, create_datetime, create_hostname_pc, create_browser_pc, isajax_bugs, create_login_nama', 'safe'),
			array('tgl_awal, tgl_akhir, reportbugs_id, kodebugs, judul_bugs, link_bugs, type_bugs, file_bugs, line_bugs, pesan_bugs, prioritas_bugs, create_login_id, create_pegawai_id, create_instalasi_id, create_ruangan_id, create_modul_id, create_datetime, create_hostname_pc, create_browser_pc, isajax_bugs, create_login_nama', 'safe', 'on'=>'search'),
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
			'reportbugs_id' => 'Report Bug',
			'kodebugs' => 'Kode Bug',
			'judul_bugs' => 'Judul Bug',
			'link_bugs' => 'Link Bug',
			'type_bugs' => 'Tipe Bug',
			'file_bugs' => 'File Bug',
			'line_bugs' => 'Line Bug',
			'pesan_bugs' => 'Pesan Bug',
			'prioritas_bugs' => 'Prioritas Bug',
			'create_login_id' => 'Login',
			'create_pegawai_id' => 'Pegawai',
			'create_instalasi_id' => 'Asal Instalasi',
			'create_ruangan_id' => 'Asal Ruangan',
			'create_modul_id' => 'Asal Modul',
			'create_datetime' => 'Tanggal Pelaporan Bug',
			'create_hostname_pc' => 'Hostname PC',
			'create_browser_pc' => 'Web Browser PC',
			'isajax_bugs' => 'Bug AJAX',
			'create_login_nama' => 'Nama Login',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                if ($this->tgl_awal != '' OR $this->tgl_akhir != ''){
                    $criteria->addBetweenCondition('date(create_datetime)', MyFormatter::formatDateTimeForDb($this->tgl_awal), MyFormatter::formatDateTimeForDb($this->tgl_akhir));
                }
             
		//$criteria->compare('reportbugs_id',$this->reportbugs_id);
		$criteria->compare('kodebugs',$this->kodebugs,true);
		$criteria->compare('LOWER(judul_bugs)',strtolower($this->judul_bugs),true);
		$criteria->compare('LOWER(link_bugs)',strtolower($this->link_bugs),true);
		$criteria->compare('LOWER(type_bugs)',strtolower($this->type_bugs),true);
		//$criteria->compare('LOWER(file_bugs)',strtolower($this->file_bugs),true);
		//$criteria->compare('LOWER(line_bugs)',strtolower($this->line_bugs),true);
		//$criteria->compare('LOWER(pesan_bugs)',strtolower($this->pesan_bugs),true);
		//$criteria->compare('prioritas_bugs',$this->prioritas_bugs);
		//$criteria->compare('create_login_id',$this->create_login_id);
		//$criteria->compare('create_pegawai_id',$this->create_pegawai_id);
		//$criteria->compare('create_instalasi_id',$this->create_instalasi_id);
		//$criteria->compare('create_ruangan_id',$this->create_ruangan_id);
		//$criteria->compare('create_modul_id',$this->create_modul_id);
		//$criteria->compare('LOWER(create_datetime)',strtolower($this->create_datetime),true);
		$criteria->compare('LOWER(create_hostname_pc)',strtolower($this->create_hostname_pc),true);
		//$criteria->compare('LOWER(create_browser_pc)',strtolower($this->create_browser_pc),true);
		$criteria->compare('isajax_bugs',$this->isajax_bugs);
		//$criteria->compare('LOWER(create_login_nama)',strtolower($this->create_login_nama),true);
                $criteria->order = "create_datetime DESC";
		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}