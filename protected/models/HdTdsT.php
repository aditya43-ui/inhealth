<?php

/**
 * This is the model class for table "hd_tds_t".
 *
 * The followings are the available columns in table 'hd_tds_t':
 * @property integer $hd_tds_id
 * @property string $tgl_monitoring
 * @property string $shift1_jam
 * @property integer $shift1_feed
 * @property integer $shift1_product
 * @property double $shift1_rejection
 * @property string $shift2_jam
 * @property integer $shift2_feed
 * @property integer $shift2_product
 * @property double $shift2_rejection
 * @property string $create_time
 * @property integer $create_loginpemakai_id
 * @property integer $create_ruangan_id
 * @property string $update_time
 * @property integer $update_loginpemakai_id
 * @property integer $update_ruangan_id
 */
class HdTdsT extends CActiveRecord
{   
        public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HdTdsT the static model class
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
		return 'hd_tds_t';
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
			array('shift1_feed, shift1_product, shift2_feed, shift2_product, create_loginpemakai_id, create_ruangan_id, update_loginpemakai_id, update_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('shift1_rejection, shift2_rejection', 'numerical'),
			array('tgl_monitoring, shift1_jam, shift2_jam, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hd_tds_id, tgl_monitoring, shift1_jam, shift1_feed, shift1_product, shift1_rejection, shift2_jam, shift2_feed, shift2_product, shift2_rejection, create_time, create_loginpemakai_id, create_ruangan_id, update_time, update_loginpemakai_id, update_ruangan_id', 'safe', 'on'=>'search'),
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
			'hd_tds_id' => 'Hd Tds',
			'tgl_monitoring' => 'Tgl Monitoring',
			'shift1_jam' => 'Jam',
			'shift1_feed' => 'Feed',
			'shift1_product' => 'Product',
			'shift1_rejection' => '% Rejection',
			'shift2_jam' => 'Jam',
			'shift2_feed' => 'Feed',
			'shift2_product' => 'Product',
			'shift2_rejection' => '% Rejection',
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
                        $data[$init]['shift1_jam'] = '';
                        $data[$init]['shift1_feed'] = '';
                        $data[$init]['shift1_product'] = '';
                        $data[$init]['shift1_rejection'] = '';
                        $data[$init]['shift2_jam'] = '';
                        $data[$init]['shift2_feed'] = '';
                        $data[$init]['shift2_product'] = '';
                        $data[$init]['shift2_rejection'] = '';
                        
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