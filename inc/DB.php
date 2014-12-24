<?php
require_once('inc.php');

class DB{

    /**
     * экзмепляр соединения с базой данных
     * @var PDO
     */
    private $db;

    /**
     * соединение с базой данных
     */
    function __Construct(){
        try{
            $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8;', DB_USER, DB_PASSWORD);
        } catch(PDOException $e){
            echo 'Подключение не удалось'.$e->getMessage();
        }
    }

    /**
     * добавляет новую категорию или обновляет
     * @param FormData $Data
     * @param $query
     * @return bool
     */
    public function saveCat(FormData $Data, $query){
        $ins = $this->db->prepare($query);
		if($Data->id_parent == ""){
			$a = array('id_parent' => NULL, 'title' => $Data->title);
		}
		else{
			$a = array('id_parent' => $Data->id_parent, 'title' => $Data->title);
		}
        if($ins->execute($a)){
            return true;
        } else{
            return false;
        }
    }

    /**
     * удаление категории из базы
     * @param $id
     * @return bool
     */
    public function requestDel($id){
        $query = $this->db->prepare("DELETE FROM categories WHERE id=:id");
        if($query->execute(array('id' => $id))){
            return true;
        } else{
            return false;
        }
    }

    /**
     * выбирает категорию по id
     * @param $id
     * @return bool|mixed
     */
    public function requestSelect($id){
        $mas = $this->db->query("SELECT * FROM categories WHERE id='$id'", PDO::FETCH_ASSOC)->fetch();
        if(!empty($mas)){
            return $mas;
        } else{
            return false;
        }
    }

    /**
     * выбирает все категории
     * @return array|bool
     */
    public function getCategories(){
        $mas = $this->db->query("SELECT id, title, IFNULL(id_parent, 0) AS id_parent FROM categories", PDO::FETCH_ASSOC)->fetchAll();
        if(!empty($mas)){
            return $mas;
        }else{
            return false;
        }
    }
}