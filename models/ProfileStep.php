 <?php

/**
 * This is the model class for table "profile_step".
 *
 * The followings are the available columns in table 'profile_step':
 * @property integer $id
 * @property integer $users__id
 * @property integer $step
 * @property integer $periode__id
 */
class ProfileStep extends UTIActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProfileStep the static model class
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
        return 'profile_step';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('users__id, periode__id', 'required'),
            array('users__id, step, periode__id', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, users__id, step, periode__id', 'safe', 'on'=>'search'),
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
            'id' => 'ID',
            'users__id' => 'Users',
            'step' => 'Step',
            'periode__id' => 'Periode',
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

        $criteria->compare('id',$this->id);
        $criteria->compare('users__id',$this->users__id);
        $criteria->compare('step',$this->step);
        $criteria->compare('periode__id',$this->periode__id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
} 