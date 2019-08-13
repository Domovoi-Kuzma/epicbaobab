<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 13.08.2019
 * Time: 15:43
 */

/**
 * Class ModelDelete
 * удаляет из БД записи.
 */
class ModelDelete extends CModel{
    /**
     * @var string $id
     * ключ записи, что удаляется.
     */
    private $id;

    /**
     * @var string $dbtable             имя таблицыБД, в которую вставляет модель
     */
    private $dbtable;
    /**
     * @var string имя поля в таблице отношений EID либо MID,
     * по которому выбираем, что удалять из неё
     */
    private $relationsFieldCaption;

    public function attributeNames(){
        return array();
    }

    /**
     * ModelDelete constructor.
     * * @param string $what принимает строковое значение employees или meets
     * в зависимости от выбора меняются ключевые слова в командах БД
     */
    function __construct($what)
    {
        if ($what == 'employees')
        {
            $this->dbtable              = 'people';
            $this->relationsFieldCaption= 'EID';
        }
        else if ($what == 'meets')
        {
            $this->dbtable              = 'meets';
            $this->relationsFieldCaption= 'MID';
        }
        else {
            echo "undefined what is what $what";
            die();
        }
    }

    /**
     * Execute метод удаления
     * составляет SQL запрос вида
     */
    public function Execute($id){
        $sql="DELETE FROM ".$this->dbtable." WHERE ID=".$id;
        Yii::app()->db->createCommand($sql)->execute();
        $sql="DELETE FROM relations WHERE ".$this->relationsFieldCaption."=".$id;
        Yii::app()->db->createCommand($sql)->execute();



    }
}