<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 08.08.2019
 * Time: 13:45
 */

/**
 * Class ModelInsert
 * Модель, оперирующая данными от отправленной формы добавления Сотрудника
 * Впрочем, и добавления встречи тоже.
 * добавляет новые записи в БД
 */
class ModelInsert extends  CModel
{

    /**
     * @var string $dbtable             имя таблицыБД, в которую вставляет модель
     * @var string $myNameFieldCaption  имя столбца в этой таблице, соотв. имени.
     */
    private $dbtable;               //
    private $myNameFieldCaption;    //
    //private $buttonAction;
    /**
     * @var string $rel_infix_format $separator_format $rel_sufix_format
     * текстовые суффиксы, вставляемые в запрос, в зависимости от того, что добавляем
     * напр. в команде
     * INSERT INTO relations VALUES (options[0],ID),  (options[1], ID) и.т.д.
     * приставка ' (';
     * сепаратор ',ID),(';
     * суффикс ',ID )'
     * напр. в команде
     * INSERT INTO relations VALUES (ID, options[0]),  (ID, options[1]) и.т.д.
     * приставка ' (ID, ';
     * сепаратор '),(ID,';
     * суффикс ')'
     */
    private $rel_infix_format, $rel_sufix_format, $separator_format;

    /**
     * ModelInsert constructor.
     * @param string $what принимает строковое значение employees или meets
     * в зависимости от выбора меняются ключевые слова в командах БД
     */
    function __construct($what)
    {
        if ($what == 'employees')
        {
            $this->dbtable              = 'people';
            $this->buttonAction         = 'people';
            $this->myNameFieldCaption   = 'Name';
            $this->rel_infix_format     = ' (%d,';
            $this->rel_sufix_format    = ');';
            $this->separator_format     = '),(%d,';
        }
        else//if ($what == 'meets')
        {
            $this->dbtable              = 'meets';
            $this->buttonAction         = 'people';
            $this->myNameFieldCaption   = 'Meeting';
            $this->rel_infix_format     = ' (';
            $this->rel_sufix_format    = ', %d);';
            $this->separator_format     = ', %d),(';
        }

    }

    public function attributeNames(){
        return array();
    }

    /**     Содержание формы вписывается в запрос SQL
     *      $_POST=[
     *              "ModelInsertForm" =>[
     *                                  "name"      =>  "textfield"  Введённое имя таблицы
     *                                  "options"   =>  [0 2]        Отмеченные галочки, начиная с 0
     *                                  ]
     *              "yt0"=>"Submit"
     *              ]
     *      Вставка в таблицу с данными
     *          INSERT INTO <имя таблицы> VALUES (поле name на форме)
     *      Вставка в таблицу отношений
     *          вариант 1 INSERT INTO relations VALUES (ID, options[0]),  (ID, options[1]) и.т.д.
     *          вариант 2 INSERT INTO relations VALUES (options[0],ID),  (options[1], ID) и.т.д.
     */
    public function ExecuteInsertion(){
        $sql="INSERT INTO $this->dbtable($this->myNameFieldCaption) VALUES ('".$_POST["ModelInsertForm"]["name"]."');";
        print("<br>mysql> $sql");

        Yii::app()->db->createCommand($sql)->execute();
        $relateToID=Yii::app()->db->getLastInsertId();
        if (!empty($_POST["ModelInsertForm"]["options"]))
        {
            //checkboxlist is indexed from 0;
            $separator  = sprintf($this->separator_format, $relateToID);
            $infix      = sprintf($this->rel_infix_format, $relateToID);
            $sufix      = sprintf($this->rel_sufix_format, $relateToID);
            $relations = implode($separator, $_POST["ModelInsertForm"]["options"]);//решить вопрос повторов реляций вида(5,1) (1,5)
            $sql="INSERT INTO relations VALUES $infix$relations$sufix";//ещё раз пишем newkey в начало массива, иначе он не проставлен implodeом ,1),(5,2),(5,3)

            Yii::app()->db->createCommand($sql)->execute();
        }
    }
}