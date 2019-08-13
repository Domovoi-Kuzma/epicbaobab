<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 12.08.2019
 * Time: 18:16
 */

/**
 * Class modelSave редактирует запись в БД
 */
class ModelSave extends CModel
{
    /**
     * @var string $dbtable             имя таблицыБД, в которую вставляет модель
     */
    private $dbtable;
    /**
     * @var    string $myNameFieldCaption  имя столбца в этой таблице, соотв. имени.
     */
    private $myNameFieldCaption;
    /**
     * @var $removed_id_caption имя поля в таблице relations соотв. удаляемому ID
     */
    private $removed_id_caption;
    /**
     * @var $separator_format разделитель в формируемой строке SQL запроса
     */
    private $separator_format;
    /**
     * @var $rel_infix_format начало  в формируемой строке SQL запроса
     */
    private $rel_infix_format;

    /**
     * @var $rel_sufix_format конец  в формируемой строке SQL запроса
     */
    private $rel_sufix_format;

    /**
     * ModelSave constructor.
     * @param string $what принимает строковое значение employees или meets
     * в зависимости от выбора меняются ключевые слова в командах БД
     */
    function __construct($what)
    {
        if ($what == 'employees')
        {
            $this->dbtable              = 'people';
            $this->myNameFieldCaption   = 'Name';
            $this->removed_id_caption   = 'EID';
            $this->rel_infix_format     = ' (%d,';
            $this->rel_sufix_format    = ');';
            $this->separator_format     = '),(%d,';
        }
        else//if ($what == 'meets')
        {
            $this->dbtable              = 'meets';
            $this->myNameFieldCaption   = 'Meeting';
            $this->removed_id_caption   = 'MID';
            $this->rel_infix_format     = ' (';
            $this->rel_sufix_format    = ', %d);';
            $this->separator_format     = ', %d),(';
        }

    }

    /**
     * ExecuteSaving строит и выполняет SQL действие на редактирование таблицы
     *  $_POST=[
     *              "ModelShortList" =>[
     *                                  "name" => textfield
     *                                  "options" => []
     *                                  "id"=>id
     *                                  ]
     * `            "yt0" => "Submit"
     */
    public function ExecuteSaving()
    {
        $id=$_POST["ModelShortList"]["id"];

        $sql='UPDATE '.$this->dbtable.' SET '.$this->myNameFieldCaption.'="'.$_POST["ModelShortList"]["name"].'" WHERE ID='.$id;
        Yii::app()->db->createCommand($sql)->execute();

        $sql="DELETE FROM relations WHERE $this->removed_id_caption=$id";
        Yii::app()->db->createCommand($sql)->execute();

        if (!empty($_POST["ModelShortList"]["checkedoptions"]))
        {
            $separator  = sprintf($this->separator_format, $id);
            $infix      = sprintf($this->rel_infix_format, $id);
            $sufix      = sprintf($this->rel_sufix_format, $id);
            $relations  = implode($separator, $_POST["ModelShortList"]["checkedoptions"]);
            $sql="INSERT INTO relations VALUES $infix$relations$sufix";
            Yii::app()->db->createCommand($sql)->execute();
        }
    }
    public function attributeNames(){
        return array();
    }
}