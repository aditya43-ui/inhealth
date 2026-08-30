<?php

/**
 * This is the model class for table "hd_tpc_t".
 *
 * The followings are the available columns in table 'hd_tpc_t':
 * @property integer $hd_tpc_id
 * @property string $tgl_monitoring
 * @property string $ro1_jam
 * @property double $ro1_permeate
 * @property double $ro1_concentrate
 * @property double $ro1_rejection
 * @property string $ro2_jam
 * @property double $ro2_permeate
 * @property double $ro2_concentrate
 * @property double $ro2_rejection
 * @property string $ro3_jam
 * @property double $ro3_permeate
 * @property double $ro3_concentrate
 * @property double $ro3_rejection
 * @property string $create_time
 * @property integer $create_loginpemakai_id
 * @property integer $create_ruangan_id
 * @property string $update_time
 * @property integer $update_loginpemakai_id
 * @property integer $update_ruangan_id
 */
class HdTpcT extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HdTpcT the static model class
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
		return 'hd_tpc_t';
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
			array('create_loginpemakai_id, create_ruangan_id, update_loginpemakai_id, update_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('ro1_permeate, ro1_concentrate, ro1_rejection, ro2_permeate, ro2_concentrate, ro2_rejection, ro3_permeate, ro3_concentrate, ro3_rejection', 'numerical'),
			array('tgl_monitoring, ro1_jam, ro2_jam, ro3_jam, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hd_tpc_id, tgl_monitoring, ro1_jam, ro1_permeate, ro1_concentrate, ro1_rejection, ro2_jam, ro2_permeate, ro2_concentrate, ro2_rejection, ro3_jam, ro3_permeate, ro3_concentrate, ro3_rejection, create_time, create_loginpemakai_id, create_ruangan_id, update_time, update_loginpemakai_id, update_ruangan_id', 'safe', 'on'=>'search'),
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
			'hd_tpc_id' => 'Hd Tpc',
			'tgl_monitoring' => 'Tgl Monitoring',
			'ro1_jam' => 'Ro1 Jam',
			'ro1_permeate' => 'Permeate',
			'ro1_concentrate' => 'Concentrate',
			'ro1_rejection' => '% Rejection',
			'ro2_jam' => 'Ro2 Jam',
			'ro2_permeate' => 'Permeate',
			'ro2_concentrate' => 'Concentrate',
			'ro2_rejection' => '% Rejection',
			'ro3_jam' => 'Ro3 Jam',
			'ro3_permeate' => 'Permeate',
			'ro3_concentrate' => 'Concentrate',
			'ro3_rejection' => '% Rejection',
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
		
		$criteria->addBetweenCondition('DATE(tgl_monitoring)',$this->tgl_awal,$this->tgl_akhir);                		

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
                    }else{
                        $data[$init]['ro1_jam'] = '';
                        $data[$init]['ro1_permeate'] = '';
                        $data[$init]['ro1_concentrate'] = '';
                        $data[$init]['ro1_rejection'] = '';
                        
                        $data[$init]['ro2_jam'] = '';
                        $data[$init]['ro2_permeate'] = '';
                        $data[$init]['ro2_concentrate'] = '';
                        $data[$init]['ro2_rejection'] = '';
                        
                        $data[$init]['ro3_jam'] = '';
                        $data[$init]['ro3_permeate'] = '';
                        $data[$init]['ro3_concentrate'] = '';
                        $data[$init]['ro3_rejection'] = '';
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