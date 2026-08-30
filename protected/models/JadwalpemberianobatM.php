<?php

/**
 * This is the model class for table "jadwalpemberianobat_m".
 *
 * The followings are the available columns in table 'jadwalpemberianobat_m':
 * @property integer $jadwalpemberianobat_id
 * @property integer $subjenis_id
 * @property string $signa_oa
 * @property string $jadwal
 * @property integer $urutan
 * @property boolean $jadwalpemberianobat_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class JadwalpemberianobatM extends CActiveRecord
{
        public $subjenis_nama;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jadwalpemberianobat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jadwal, urutan', 'required'),
			array('subjenis_id, urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('signa_oa, jadwal', 'length', 'max'=>20),
			array('jadwal, jadwalpemberianobat_aktif, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('jadwalpemberianobat_id, subjenis_id, signa_oa, jadwal, urutan, jadwalpemberianobat_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'subjenis' => [self::BELONGS_TO, 'SubjenisM','subjenis_id']
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jadwalpemberianobat_id' => 'Jadwalpemberianobat',
			'subjenis_id' => 'Subjenis',
			'signa_oa' => 'Signa Oa',
			'jadwal' => 'Jadwal',
			'urutan' => 'Urutan',
			'jadwalpemberianobat_aktif' => 'Jadwalpemberianobat Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = [
                    "t.*",
                    "sj.subjenis_nama"
                ];
                $criteria->join = " LEFT JOIN subjenis_m sj ON sj.subjenis_id = t.subjenis_id ";
		$criteria->compare('subjenis_id',$this->subjenis_id);
		$criteria->compare('signa_oa',$this->signa_oa,true);
		$criteria->compare('jadwal',$this->jadwal);
		$criteria->compare('jadwalpemberianobat_aktif', isset($this->jadwalpemberianobat_aktif)?$this->jadwalpemberianobat_aktif:true);
                
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort' => [
                        'defaultOrder' => 'jadwal ASC'
                    ]
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JadwalpemberianobatM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function simpanData($model, $post, $multiple = false){
            
            $sukses = 1;
            $pesan = '';
            
            if (!$multiple){
                $modDet->attributes = $post;

                $modDet = self::set_audit($model, $modDet, $post);
                
                $sukses &= $model->save();

                if (!$sukses){
                    $pesan .= 'jadwal pemberian obat det <br/>:'.MyExceptionMessage::getErrorMessage($model);
                }
            }else{
                $mod = get_called_class();
                $modDet = [];
                
                foreach($post as $key => $val){
                    $modDet[$key] = new $mod;
                    if (!empty($val['jadwalpemberianobat_id'])){
                        $cek = $mod::model()->findByPk($val['jadwalpemberianobat_id']);
                        if (!empty($cek)){
                            $modDet[$key] = $cek;
                        }
                    }
                    $modDet[$key]->attributes = $val;      
                    
                    $modDet[$key] = self::set_audit($model, $modDet[$key], $val);

                    $sukses &= $modDet[$key]->save();

                    if (!$sukses){
                        $pesan .= 'jadwal pemberian obat det <br/>:'.MyExceptionMessage::getErrorMessage($modDet[$key]);
                    }                    
                }
            }
            
            return [
                'model' => $modDet,
                'sukses' => $sukses,
                'pesan' => $pesan
            ];
        }
        
        /**
        * 
        * @param type $model
        * @param type $modDet
        * @param type $post
        * @return type
        */
       public static function set_audit($model, $modDet, $post){                

           $modDet->attributes = $post;              

           if (empty($model->jadwalpemberianobat_id)){
               $modDet->create_time = date('Y-m-d H:i:s');
               $modDet->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
               $modDet->create_ruangan = Yii::app()->user->getState('ruangan_id');
           }else{
               $modDet->update_time = date('Y-m-d H:i:s');
               $modDet->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
           }

           return $modDet;
       }
}
