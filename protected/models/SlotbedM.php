<?php

/**
 * This is the model class for table "slotbed_m".
 *
 * The followings are the available columns in table 'slotbed_m':
 * @property integer $slotbed_id
 * @property integer $instalasi_id
 * @property integer $kelaspelayanan_id
 * @property string $jadwal_hari
 * @property string $jadwal_buka
 * @property string $jadwal_mulai
 * @property string $jadwal_tutup
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $tutupslotbed_id
 * @property string $jadwalpengganti_id
 */
class SlotbedM extends CActiveRecord
{
	public $jadwal_awal;
	public $jadwal_akhir;
	public $nama_pegawai, $gelardepan, $gelarbelakang_nama;
        public $photopegawai, $ruangan_nama;
		public $ceklis;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SlotbedM the static model class
	 */
	public $bulan;
	public $instalasi_id, $kelaspelayanan_id;	 
		
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'slotbed_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelaspelayanan_id, instalasi_id, jadwal_hari, jadwal_buka, jadwal_mulai, jadwal_tutup', 'required'),
			array('kelaspelayanan_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('jadwal_hari', 'length', 'max'=>20),
			array('jadwal_buka', 'length', 'max'=>50),
                        array('jadwal_mulai, jadwal_tutup', 'date', 'format'=>'H:m:s'),
			array('bulan, jadwal_mulai, jadwal_tutup, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe'),
                        array('jadwal_mulai, jadwal_tutup','setValidation'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('estimasipelayanan', 'safe'),
			array('slotbed_id, kelaspelayanan_id, instalasi_id, jadwal_hari, jadwal_buka, jadwal_mulai, jadwal_tutup, , create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
                        array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
		);
	}
        
        public function setValidation(){
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
                        'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'slotbed_id' => 'ID',
			'instalasi_id' => 'Instalasi',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'slotbed_noslot' => 'Nama Bed',
			'jadwal_hari' => 'Hari',
			'jadwal_buka' => 'Jadwal Buka',
			'jadwal_mulai' => 'Jadwal Mulai',
			'jadwal_tutup' => 'Jadwal Tutup',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('lower(p.nama_pegawai)', strtolower($this->nama_pegawai), true);

		$criteria->compare('t.slotbed_id',$this->slotbed_id);
		$criteria->compare('t.instalasi_id',$this->instalasi_id);
		$criteria->compare('t.kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(t.jadwal_hari)',strtolower($this->jadwal_hari),true);
		$criteria->compare('LOWER(t.jadwal_buka)',strtolower($this->jadwal_buka),true);
//		$criteria->addBetweenCondition('jadwal_mulai', $this->jadwal_mulai, $this->jadwal_tutup);
		$criteria->compare('t.jadwal_tutup',strtolower($this->jadwal_tutup));
		$criteria->compare('t.jadwal_mulai',strtolower($this->jadwal_mulai));
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
           
		if (!empty($this->bulan)) {
                    
			$criteria->addBetweenCondition('t.jadwal_tgl::date'
					, date('Y-m-d', strtotime(date('Y')."-".$this->bulan."-01"))
					, date('Y-m-t', strtotime(date('Y')."-".$this->bulan."-01"))
			);
		}


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('slotbed_id',$this->slotbed_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(jadwal_hari)',strtolower($this->jadwal_hari),true);
		$criteria->compare('LOWER(jadwal_buka)',strtolower($this->jadwal_buka),true);
		$criteria->compare('LOWER(jadwal_mulai)',strtolower($this->jadwal_mulai),true);
		$criteria->compare('LOWER(jadwal_tutup)',strtolower($this->jadwal_tutup),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
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
            $format = new MyFormatter();
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
            return parent::beforeSave();
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
        
        public function getListHari()
        { 
           return $list = array('listHari'=>'Senin',
                                    'Selasa',
                                    'Rabu',
                                    'Kamis',
                                    'Jumat',
                                    'Sabtu',
                                    'Minggu',
                                );
        }
        
        public function getNamaLengkap(){
            return (!empty($this->gelardepan)?$this->gelardepan.' ':'').$this->nama_pegawai.(!empty($this->gelarbelakang_nama)?', '.$this->gelarbelakang_nama:'');
        }

        public function getKelasPelayananItems()
        {
            return SAKelasPelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'kelaspelayanan_nama'));
        }

	public static function getSlotBed($tanggal, $kelaspelayanan_id, $instalasi_id) {
		$cr = new CDbCriteria;
		$cr->compare('jadwal_tgl::date', date('Y-m-d', strtotime($tanggal)));
		// $cr->compare('kelaspelayanan_id', $kelaspelayanan_id);
		$cr->compare('instalasi_id', $instalasi_id);
		$cr->addCondition('slotbed_aktif = true');
		$cr->group = $cr->select = 'slotbed_noslot';
		$cr->order = 'slotbed_noslot';

		// var_dump($cr);
		
		$data = self::model()->findAll($cr);

		$list = array();

		foreach ($data as $item) {
			$list[$item->slotbed_noslot] = $item->slotbed_noslot;
		}

		// var_dump($list);

		return $list;
	}

	public static function getSlotBedJadwal($tanggal, $kelaspelayanan_id, $instalasi_id, $noslot) {
		$cr = new CDbCriteria;
		$cr->compare('jadwal_tgl::date', date('Y-m-d', strtotime($tanggal)));
		// $cr->compare('kelaspelayanan_id', $kelaspelayanan_id);
		$cr->compare('instalasi_id', $instalasi_id);
		$cr->compare('slotbed_noslot', $noslot);
		$cr->addCondition('slotbed_aktif = true');
		$cr->order = 'slotbed_noslot';

		$datas = self::model()->findAll($cr);

		$str = '<option value="">-- Pilih --</option>';
		$dipakai = 0;

		if (empty($noslot)) {
			return $str;
		}


		foreach ($datas as $data) {

			$data->jadwal_tgl = MyFormatter::formatDateTimeForDB($data->jadwal_tgl);

			$waktu_mulai = new DateTime($data->jadwal_tgl." ".$data->jadwal_mulai);
			$waktu_selesai = new DateTime($data->jadwal_tgl." ".$data->jadwal_tutup);

			$dataJadwalRM = array();
			$dataJadwal = array();
			$arr_waktu = array();

			$period = new DatePeriod(
				$waktu_mulai,
				new DateInterval('PT'.$data->estimasipelayanan.'M'),
				$waktu_selesai
			);

			foreach ($period as $item) {
				$value_awal = $item->format('H:i:s');

				$arr_waktu[] = $tanggal." ".$value_awal;
			}

			$jadwalRM = JadwalrehabmedisT::model()->findAllByAttributes(array(
				'slotbed_id'=>$data->slotbed_id,
			));

			foreach ($jadwalRM as $item) {
				$waktu = date('H:i', strtotime($item->jadwalrehabmedis_tgl_ke));
        		$dataJadwalRM[$waktu] = $item;
			}

			// var_dump($data->slotbed_id, $dataJadwalRM); die;

			$idx_slot = 1;
			foreach ($period as $idx => $item) {
				$terisi = 0;
				$terisi_jadwal = 0;
				$pasien_id = "";
				$value_awal = $item->format('H:i');

				$key = $data->slotbed_id."_".$value_awal;
				
				$value_akhir = date('H:i', strtotime($value_awal.":00") + ($data->estimasipelayanan * 60));

				$label = $value_awal." - ".$value_akhir;

				if (!empty($dataJadwalRM[$value_awal])) {
					$terisi = 1;
					$label .= " -- ".$dataJadwalRM[$value_awal]->pasienrl->nama_pasien;
					$pasien_id = $dataJadwalRM[$value_awal]->pasien_id;
					$dipakai++;
				}

				$str .= '<option value="'.$key.'" data-terisi="'.$terisi.'" data-pasien="'.$pasien_id.'">'.$label.'</option>';
				// $idx_slot++;
			}

		}

		return $str;
	}
}