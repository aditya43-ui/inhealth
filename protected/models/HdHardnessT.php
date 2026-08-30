<?php

/**
 * This is the model class for table "hd_hardness_t".
 *
 * The followings are the available columns in table 'hd_hardness_t':
 * @property integer $hd_hardness_id
 * @property integer $pegawai_id
 * @property string $tgl_monitoring
 * @property integer $test_result
 * @property string $status
 * @property string $create_time
 * @property integer $create_loginpemakai_id
 * @property integer $create_ruangan_id
 * @property string $update_time
 * @property integer $update_loginpemakai_id
 * @property integer $update_ruangan_id
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 */
class HdHardnessT extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir;
        public $nama_pegawai;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HdHardnessT the static model class
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
		return 'hd_hardness_t';
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
			array('pegawai_id, test_result, create_loginpemakai_id, create_ruangan_id, update_loginpemakai_id, update_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>50),
			array('tgl_monitoring, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hd_hardness_id, pegawai_id, tgl_monitoring, test_result, status, create_time, create_loginpemakai_id, create_ruangan_id, update_time, update_loginpemakai_id, update_ruangan_id', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hd_hardness_id' => 'Hd Hardness',
			'pegawai_id' => 'Pegawai',
			'tgl_monitoring' => 'Tgl Monitoring',
			'test_result' => 'Test Result',
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
                $criteria->select = " t.*, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,', ',glr.gelarbelakang_nama) as nama_pegawai ";
                $criteria->join = "     LEFT JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id  
                                        LEFT JOIN gelarbelakang_m glr ON glr.gelarbelakang_id = peg.gelarbelakang_id ";                
		
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

		$criteria=new CDbCriteria;
                $criteria->select = " t.*, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,', ',glr.gelarbelakang_nama) as nama_pegawai ";
                $criteria->join = "     LEFT JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id  
                                        LEFT JOIN gelarbelakang_m glr ON glr.gelarbelakang_id = peg.gelarbelakang_id ";                
		
		$criteria->addBetweenCondition('DATE(t.tgl_monitoring)',$this->tgl_awal,$this->tgl_akhir);                		

                $load = self::model()->findAll($criteria);
                
                $set = [];
                foreach($load as $det){
                    $set[$det->tgl_monitoring] = $det;
                }
                
                $selisih = CustomFunction::hitungHari($this->tgl_akhir, $this->tgl_awal);
                
                $data = [];
                for($i=0;$i<=$selisih;$i++){
                    $init = $i;
                    $tgl = date('Y-m-d',strtotime($this->tgl_awal.' +'.$i.' days'));
                    if (isset($set[$tgl])){
                        $data[$init] = $set[$tgl]->attributes;
                        $data[$init]['nama_pegawai'] = $set[$tgl]->nama_pegawai;
                        $data[$init]['ada_data'] = 'ada';
                    }else{                        
                        $data[$init]['ada_data'] = 'tidak-ada';
                        $data[$init]['test_result'] = '';
                        $data[$init]['status'] = '';
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