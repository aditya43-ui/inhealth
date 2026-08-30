<?php

/**
 * This is the model class for table "hd_chlorine_t".
 *
 * The followings are the available columns in table 'hd_chlorine_t':
 * @property integer $hd_chlorine_id
 * @property integer $pegawai_shift1_id
 * @property integer $pegawai_shift2_id
 * @property integer $pegawai_lateshift_id
 * @property string $tgl_monitoring
 * @property boolean $is_shift1
 * @property boolean $is_shift2
 * @property boolean $is_lateshift
 * @property string $status
 * @property string $create_time
 * @property integer $create_loginpemakai_id
 * @property integer $create_ruangan_id
 * @property string $update_time
 * @property integer $update_loginpemakai_id
 * @property integer $update_ruangan_id
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawaiShift1
 * @property PegawaiM $pegawaiShift2
 * @property PegawaiM $pegawaiLateshift
 */
class HdChlorineT extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir;
        public $pegawai_shift1_nama, $pegawai_shift2_nama, $pegawai_lateshift_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HdChlorineT the static model class
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
		return 'hd_chlorine_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan_id', 'required'),
			array('pegawai_shift1_id, pegawai_shift2_id, pegawai_lateshift_id, create_loginpemakai_id, create_ruangan_id, update_loginpemakai_id, update_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>50),
			array('tgl_monitoring, is_shift1, is_shift2, is_lateshift, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hd_chlorine_id, pegawai_shift1_id, pegawai_shift2_id, pegawai_lateshift_id, tgl_monitoring, is_shift1, is_shift2, is_lateshift, status, create_time, create_loginpemakai_id, create_ruangan_id, update_time, update_loginpemakai_id, update_ruangan_id', 'safe', 'on'=>'search'),
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
			'pegawaiShift1' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_shift1_id'),
			'pegawaiShift2' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_shift2_id'),
			'pegawaiLateshift' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_lateshift_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hd_chlorine_id' => 'Hd Chlorine',
			'pegawai_shift1_id' => 'Pegawai Shift1',
			'pegawai_shift2_id' => 'Pegawai Shift2',
			'pegawai_lateshift_id' => 'Pegawai Lateshift',
			'tgl_monitoring' => 'Tgl Monitoring',
			'is_shift1' => 'Is Shift1',
			'is_shift2' => 'Is Shift2',
			'is_lateshift' => 'Is Lateshift',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
			'update_time' => 'Update Time',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'update_ruangan_id' => 'Update Ruangan',
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
                $criteria->select = [
                    " t.*", 
                    "CONCAT(peg1.gelardepan,' ',peg1.nama_pegawai,', ',glr1.gelarbelakang_nama) as pegawai_shift1_nama",
                    "CONCAT(peg2.gelardepan,' ',peg2.nama_pegawai,', ',glr2.gelarbelakang_nama) as pegawai_shift2_nama",
                    "CONCAT(peg3.gelardepan,' ',peg3.nama_pegawai,', ',glr3.gelarbelakang_nama) as pegawai_lateshift_nama",
                ];
                $criteria->join = "     LEFT JOIN pegawai_m peg1 ON peg1.pegawai_id = t.pegawai_shift1_id  
                                        LEFT JOIN gelarbelakang_m glr1 ON glr1.gelarbelakang_id = peg1.gelarbelakang_id 
                                        LEFT JOIN pegawai_m peg2 ON peg2.pegawai_id = t.pegawai_shift2_id  
                                        LEFT JOIN gelarbelakang_m glr2 ON glr2.gelarbelakang_id = peg2.gelarbelakang_id
                                        LEFT JOIN pegawai_m peg3 ON peg3.pegawai_id = t.pegawai_lateshift_id  
                                        LEFT JOIN gelarbelakang_m glr3 ON glr3.gelarbelakang_id = peg3.gelarbelakang_id
                                ";                
		
		$criteria->addBetweenCondition('DATE(t.tgl_monitoring)',$this->tgl_awal,$this->tgl_akhir);                		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
                
                $load = $this->search();
                
                $set = [];
                foreach($load->getData() as $det){
                    $set[$det->tgl_monitoring] = $det;
                }
                
                $selisih = CustomFunction::hitungHari($this->tgl_akhir, $this->tgl_awal);
                
                $data = [];
                for($i=0;$i<=$selisih;$i++){
                    $init = $i;
                    $tgl = date('Y-m-d',strtotime($this->tgl_awal.' +'.$i.' days'));
                    if (isset($set[$tgl])){
                        $data[$init] = $set[$tgl]->attributes;
                        $data[$init]['pegawai_shift1_nama'] = $set[$tgl]->pegawai_shift1_nama;
                        $data[$init]['pegawai_shift2_nama'] = $set[$tgl]->pegawai_shift2_nama;
                        $data[$init]['pegawai_lateshift_nama'] = $set[$tgl]->pegawai_lateshift_nama;
                        $data[$init]['ada_data'] = 'ada';
                    }else{
                        $data[$init]['is_shift1'] = '';
                        $data[$init]['is_shift2'] = '';
                        $data[$init]['is_lateshift'] = '';                        
                        $data[$init]['status'] = '';
                        $data[$init]['ada_data'] = 'tidak-ada';
                    }
                    $data[$init]['no_urut'] = $i;
                    $data[$init]['tanggal'] = date('d',strtotime($this->tgl_awal.' +'.$i.' days'));
                    $data[$init]['bulan'] = MyFormatter::getMonthId(date('m',strtotime($this->tgl_awal.' +'.$i.' days')));
                    $data[$init]['tahun'] = MyFormatter::getMonthId(date('Y',strtotime($this->tgl_awal.' +'.$i.' days')));
                    
                    
                }
                
		return new CArrayDataProvider($data, array(
                    'keyField'=>'no_urut',			
                    'id'=>'data_laporan',
                    'totalItemCount'=>count($data),
                    'pagination' => array(
                        'pageSize' => 10,
                        'pageVar' => 'page'
                    ),	                    
                ));
	}
}