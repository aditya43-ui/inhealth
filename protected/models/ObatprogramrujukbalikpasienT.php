<?php

/**
 * This is the model class for table "obatprogramrujukbalikpasien_t".
 *
 * The followings are the available columns in table 'obatprogramrujukbalikpasien_t':
 * @property integer $obatprogramrujukbalikpasien_id
 * @property integer $programrujukbalikpasien_id
 * @property string $obatprb_bpjskode
 * @property string $obatprb_bpjsnama
 * @property integer $obatalkes_id
 * @property string $signa
 * @property string $carapenggunaanobat
 * @property double $qty_obat
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property ProgramrujukbalikpasienT $programrujukbalikpasien
 */
class ObatprogramrujukbalikpasienT extends CActiveRecord
{
        public $obatbpjsprb;
        public $obatalkes_nama;        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'obatprogramrujukbalikpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('programrujukbalikpasien_id, obatprb_bpjskode, obatprb_bpjsnama, qty_obat, create_time, create_loginpemakai_id', 'required'),
			array('programrujukbalikpasien_id, obatalkes_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('qty_obat', 'numerical'),
			array('obatprb_bpjskode', 'length', 'max'=>50),
			array('signa', 'length', 'max'=>100),
			array('carapenggunaanobat', 'length', 'max'=>200),
			array('signa_2, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('obatprogramrujukbalikpasien_id, programrujukbalikpasien_id, obatprb_bpjskode, obatprb_bpjsnama, obatalkes_id, signa, carapenggunaanobat, qty_obat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
                    'programrujukbalikpasien' => array(self::BELONGS_TO, 'ProgramrujukbalikpasienT', 'programrujukbalikpasien_id'),
                    'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatprogramrujukbalikpasien_id' => 'Obatprogramrujukbalikpasien',
			'programrujukbalikpasien_id' => 'Programrujukbalikpasien',
			'obatprb_bpjskode' => 'Obatprb Bpjskode',
			'obatprb_bpjsnama' => 'Obatprb Bpjsnama',
			'obatalkes_id' => 'Obatalkes',
			'signa' => 'Signa',
			'carapenggunaanobat' => 'Carapenggunaanobat',
			'qty_obat' => 'Qty Obat',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('obatprogramrujukbalikpasien_id',$this->obatprogramrujukbalikpasien_id);
		$criteria->compare('programrujukbalikpasien_id',$this->programrujukbalikpasien_id);
		$criteria->compare('obatprb_bpjskode',$this->obatprb_bpjskode,true);
		$criteria->compare('obatprb_bpjsnama',$this->obatprb_bpjsnama,true);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('signa',$this->signa,true);
		$criteria->compare('carapenggunaanobat',$this->carapenggunaanobat,true);
		$criteria->compare('qty_obat',$this->qty_obat);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ObatprogramrujukbalikpasienT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
        * 
        * @param type $model
        * @param type $post
        * @param type $is_multi
        * @return type
        */
       public static function simpanData($model, $post, $is_multi = false) {
           $ok = true;
           $format = new MyFormatter();
           $new = get_called_class();
           $pesan = '';

           if ($is_multi === false) {
               $modDet = new $new;
               if (!empty($post['obatprogramrujukbalikpasien_id'])) {
                   $cek = $new::model()->findByPk($post['obatprogramrujukbalikpasien_id']);
                   if (!empty($cek)) {
                       $modDet = $cek;
                   }
               }

               $modDet = self::set_audit($model, $modDet, $post);
               $ok &= $modDet->save();

               if (!$ok) {
                   $pesan .= '<br/>obat program rujuk balik : ' . MyExceptionMessage::getErrorMessage($modDet);
               }
           } else {
               foreach ($post as $ii => $det) {
                   $modDet[$ii] = new $new;
                   if (!empty($det['obatprogramrujukbalikpasien_id'])) {
                       $cek = $new::model()->findByPk($det['obatprogramrujukbalikpasien_id']);
                       if (!empty($cek)) {
                           $modDet[$ii] = $cek;
                       }
                   }
                   $modDet[$ii] = self::set_audit($model, $modDet[$ii], $det);
                   $ok &= $modDet[$ii]->save();

                   if (!$ok) {
                       $pesan .= '<br/>obat program rujuk balikc : ' . MyExceptionMessage::getErrorMessage($modDet[$ii]);
                   } 
               }
           }
           
           $data['sukses'] = $ok;
           $data['model'] = $modDet;
           $data['pesan'] = $pesan;

           return $data;
       }

       /**
        * 
        * @param type $model
        * @param type $modDet
        * @param type $post
        * @return type
        */
       public static function set_audit($model, $modDet, $post) {

           $modDet->attributes = $post;
           
           if (empty($model->obatprogramrujukbalikpasien_id)){               
                $modDet->create_time = date('Y-m-d H:i:s');
                $modDet->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $modDet->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
            }else{
                $modDet->update_time = date('Y-m-d H:i:s');
                $modDet->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                
            }
           
           return $modDet;
       }
}
