<?php

/**
 * This is the model class for table "usulanpenghapusanasetdet_t".
 *
 * The followings are the available columns in table 'usulanpenghapusanasetdet_t':
 * @property integer $usulanpenghapusanasetdet_id
 * @property integer $usulanpenghapusanaset_id
 * @property integer $invperalatan_id
 * @property integer $pengeluaranasetdet_id
 * @property string $kondisi
 * @property string $alasan
 * @property boolean $is_disetujui
 * @property string $catatan
 *
 * The followings are the available model relations:
 * @property InvperalatanT $invperalatan
 * @property PengeluaranasetdetT $pengeluaranasetdet
 * @property UsulanpenghapusanT $usulanpenghapusanaset
 */
class UsulanpenghapusanasetdetT extends CActiveRecord
{
        public $invperalatan_namabrg, $invperalatan_kode, $invperalatan_merk;
        public $invperalatan_keadaan, $tanggal_perolehan;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UsulanpenghapusanasetdetT the static model class
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
		return 'usulanpenghapusanasetdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usulanpenghapusanaset_id, invperalatan_id, kondisi', 'required'),
			array('usulanpenghapusanaset_id, invperalatan_id, pengeluaranasetdet_id', 'numerical', 'integerOnly'=>true),
			array('kondisi', 'length', 'max'=>50),
			array('alasan, is_disetujui, catatan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('usulanpenghapusanasetdet_id, usulanpenghapusanaset_id, invperalatan_id, pengeluaranasetdet_id, kondisi, alasan, is_disetujui, catatan', 'safe', 'on'=>'search'),
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
			'invperalatan' => array(self::BELONGS_TO, 'InvperalatanT', 'invperalatan_id'),
			'pengeluaranasetdet' => array(self::BELONGS_TO, 'PengeluaranasetdetT', 'pengeluaranasetdet_id'),
			'usulanpenghapusanaset' => array(self::BELONGS_TO, 'UsulanpenghapusanT', 'usulanpenghapusanaset_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'usulanpenghapusanasetdet_id' => 'Usulanpenghapusanasetdet',
			'usulanpenghapusanaset_id' => 'Usulanpenghapusanaset',
			'invperalatan_id' => 'Invperalatan',
			'pengeluaranasetdet_id' => 'Pengeluaranasetdet',
			'kondisi' => 'Kondisi',
			'alasan' => 'Alasan',
			'is_disetujui' => 'Is Disetujui',
			'catatan' => 'Catatan',
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

		$criteria->compare('usulanpenghapusanasetdet_id',$this->usulanpenghapusanasetdet_id);
		$criteria->compare('usulanpenghapusanaset_id',$this->usulanpenghapusanaset_id);
		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('pengeluaranasetdet_id',$this->pengeluaranasetdet_id);
		$criteria->compare('kondisi',$this->kondisi,true);
		$criteria->compare('alasan',$this->alasan,true);
		$criteria->compare('is_disetujui',$this->is_disetujui);
		$criteria->compare('catatan',$this->catatan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         /**
         * 
         * @param type $model variabel dari model UsulanpenghapusanT
         * @param type $post
         * @param type $is_multi
         * @return type
         */
        public static function simpan_data($model, $post, $is_multi = false){
            $ok = true;
            $format = new MyFormatter();
            $new = get_called_class();     
            $pesan = '';
            
            if ($is_multi === false){   
                $modDet = new $new;                
                if (!empty($post['usulanpenghapusanasetdet_id'])){
                    $cek = $new::model()->findByPk($post['usulanpenghapusanasetdet_id']);
                    if (!empty($cek)){
                        $modDet = $cek;
                    }
                }                
                
                $modDet = self::set_audit($model, $modDet, $post);
                
                $ok &= $modDet->save();                                
                
            }else{                           
                foreach($post as $ii => $det){
                    $modDet[$ii] = new $new;                
                    if (!empty($det['usulanpenghapusanasetdet_id'])){
                        $cek = $new::model()->findByPk($det['usulanpenghapusanasetdet_id']);
                        if (!empty($cek)){
                            $modDet[$ii] = $cek;
                        }
                    }
                    
                    $modDet[$ii] = self::set_audit($model, $modDet[$ii], $det);
                
                    $ok &= $modDet[$ii]->save();   
                    
                    if (!$ok){
                        $pesan .= '<br>Usulan Penghapusan Aset Det'.MyExceptionMessage::getErrorMessage($modDet[$ii]);
                    }else{
                        if ($modDet[$ii]->is_disetujui == true){
                            $proses = $modDet[$ii]->simpanPengeluaranAsetDet();
                            $ok &= $proses['sukses'];
                            $pesan .= $proses['pesan'];
                        }
                    }
                                        
                }                                                                             
            }
            
            $data['sukses'] = $ok;
            $data['model'] = $model;
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
    public static function set_audit($model, $modDet, $post){                
        
        $modDet->attributes = $post;              
        $modDet->usulanpenghapusanaset_id = $model->usulanpenghapusanaset_id;
        
        if ($model->jenis_transaksi){
            $modDet->is_disetujui = !empty($modDet->is_disetujui)?true:false;
        }
        
        return $modDet;
    }
    
    public function simpanPengeluaranAsetDet(){
        $ok = true;
        $pesan = '';
        $usulan = $this->usulanpenghapusanaset;
        
        $model = new PengeluaranasetdetT;
        $model->pengeluaranaset_id = $usulan->pengeluaranaset_id;
        $model->pengeluaranaset_keadaan = $this->kondisi;
        $model->ket_pengeluaranaset = $this->alasan;
        $model->invperalatan_id = $this->invperalatan_id;
        
        $ok &= $model->save();
            
        
        $inv = InvperalatanT::model()->findByPk($model->invperalatan_id);
        $inv->lokasi_id = $usulan->lokasisementara_id;
        $inv->ruangan_id = $usulan->lokasisementara->ruangan_id;
        $ok &= $inv->save();
        
        $this->pengeluaranasetdet_id = $model->pengeluaranasetdet_id;
        $this->update();
        
        if (!$ok){
            $pesan .= '<br/>Pengeluaran Aset Det :'.MyExceptionMessage::getErrorMessage($model);
        }

        $data['sukses'] = $ok;        
        $data['pesan'] = $pesan;

        return $data;
    }
}