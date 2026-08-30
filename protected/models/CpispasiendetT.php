<?php

/**
 * This is the model class for table "cpispasiendet_t".
 *
 * The followings are the available columns in table 'cpispasiendet_t':
 * @property integer $cpispasiendet_t
 * @property integer $cpispasien_id
 * @property string $hasipenilaian
 * @property string $skorpenilaian
 * @property integer $nourut
 * @property string $hasil_kultur
 * @property string $hasil_vap
 *
 * The followings are the available model relations:
 * @property CpispasienT $cpispasien
 */
class CpispasiendetT extends CActiveRecord
{
        public $label, $type, $input, $rule;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cpispasiendet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cpispasien_id', 'required'),
			array('cpispasien_id, nourut', 'numerical', 'integerOnly'=>true),
			array('skorpenilaian', 'length', 'max'=>100),
			array('hasipenilaian, hasil_kultur, hasil_vap', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cpispasiendet_id, cpispasien_id, hasipenilaian, skorpenilaian, nourut, hasil_kultur, hasil_vap', 'safe', 'on'=>'search'),
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
			'cpispasien' => array(self::BELONGS_TO, 'CpispasienT', 'cpispasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cpispasiendet_t' => 'Cpispasiendet T',
			'cpispasien_id' => 'Cpispasien',
			'hasipenilaian' => 'Hasipenilaian',
			'skorpenilaian' => 'Skorpenilaian',
			'nourut' => 'Nourut',
			'hasil_kultur' => 'Hasil Kultur',
			'hasil_vap' => 'Hasil Vap',
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

		$criteria->compare('cpispasiendet_t',$this->cpispasiendet_t);
		$criteria->compare('cpispasien_id',$this->cpispasien_id);
		$criteria->compare('hasipenilaian',$this->hasipenilaian,true);
		$criteria->compare('skorpenilaian',$this->skorpenilaian,true);
		$criteria->compare('nourut',$this->nourut);
		$criteria->compare('hasil_kultur',$this->hasil_kultur,true);
		$criteria->compare('hasil_vap',$this->hasil_vap,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CpispasiendetT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * 
         */
        public static function simpanData($modDet, $post, $multi = false){
            
            $format = new MyFormatter;
            $pesan = '';
            $sukses = true;
            
            if (!$multi){
                $modDet->attributes = $post;

                $sukses &= $model->save();

                if (!$sukses){
                    $pesan .= 'CPIS pasien det <br/>:'.MyExceptionMessage::getErrorMessage($model);
                }
            }else{
                $mod = get_called_class();
                $modDet = [];
                
                foreach($post as $key => $val){
                    $modDet[$key] = new $mod;
                    if (!empty($val['cpispasiendet_id'])){
                        $cek = $mod::model()->findByPk($val['cpispasiendet_id']);
                        if (!empty($cek)){
                            $modDet[$key] = $cek;
                        }
                    }
                    $modDet[$key]->attributes = $val;                    

                    $sukses &= $modDet[$key]->save();

                    if (!$sukses){
                        $pesan .= 'CPIS pasien det <br/>:'.MyExceptionMessage::getErrorMessage($modDet[$key]);
                    }
                }
            }
            
            return [
                'sukses' => $sukses,
                'pesan' => $pesan,
                'model' => $modDet
            ];
        }
        
        public function loadDetail(){
            $mod = get_called_class();
            $res = [];
            $arr = [
                [
                    'label' => 'Sekresi trakea',
                    'input' => 'dropdown',
                    'type' => 'Sekresi',
                ],
                [
                    'label' => 'Infiltrat',
                    'input' => 'dropdown',
                    'type' => 'Infiltrat',
                ],
                [
                    'label' => 'Suhu',
                    'input' => 'text',     
                    'rule' => 'angkacoma-only'
                ],
                [
                    'label' => 'Leukosit',
                    'input' => 'text',                         
                    'rule' => 'numbers-only'
                ],
                [
                    'label' => 'Pa02/Fi02',
                    'input' => 'text',                         
                ],              
            ];
                        
            if (!empty($this->cpispasien_id)){
                $cri = new CDbCriteria;
                if (!is_array($this->cpispasien_id)){
                    $cri->addCondition("cpispasien_id=".$this->cpispasien_id);
                }else{
                    $cri->addInCondition("cpispasien_id",$this->cpispasien_id);
                }
                $cri->order = " nourut ASC ";
                $load = $mod::model()->findAll($cri);
                                               
                foreach($load as $key => $val){
                    $init = $val->nourut-1;
                    if (isset($arr[$init])){                        
                        $arr[$init]['model'] = $val;                        
                    }
                }
            }
                        
            
            foreach($arr as $key => $val){
                $res[$key] = isset($val['model'])?$val['model']:new $mod;
                $res[$key]->label = $val['label'];
                $res[$key]->input = $val['input'];
                $res[$key]->type = isset($val['type'])?$val['type']:'';
                $res[$key]->rule = isset($val['rule'])?$val['rule']:'';
                $res[$key]->nourut = $key+1;
            }
    
            return $res;
        }
}
