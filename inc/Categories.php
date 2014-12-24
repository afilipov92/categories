<?php

class Categories{

    /**
     * содержит преобразованный массив в виде дерева
     * @var array
     */
    private $arr = array();
    /**
     * список категорий
     * @var string
     */
    private $listTopics = "";

    /**
     * формирует дерево
     * @param array $data
     */
    function __Construct(array $data){
        if(!empty($data)){
            foreach($data as $a){
                if(empty($this->arr[$a['id_parent']])) {
                    $this->arr[$a['id_parent']] = array();
                }
               $this->arr[$a['id_parent']][] = $a;
            }
		}
	}

    /**
     * преобразует массив категорий в html
     * @param int $id_parent
     */
    public function toStringListTopics($id_parent = 0) {
        if(empty($this->arr[$id_parent])) {
            return;
        }
        $this->listTopics .= "<ul>";
        foreach($this->arr[$id_parent] as $a) {
            $this->listTopics .= "<li><form name=\"form2\" method=\"post\" class='form2'><a href=\"?id=".$a['id']."\"><input type='text' name='id' hidden value='".$a['id']."'>".$a['title']." {{EDIT}} {{DEL}}</a></form>";
            $this->listTopics .= $this->toStringListTopics($a['id']);
            $this->listTopics .= "</li>";
        }
        $this->listTopics .= "</ul>";
    }

    /**
     * Возвращает список категорий
     * @return string
     */
    public function getListTopics(){
        return $this->listTopics;
	}

    /**
     * Возвращает список option для select
     * @param array $arr
     * @param $select
     * @param $id
     * @return string
     */
    public static function getCtaegoriesForForm(array $arr, $select, $id){
        $str = "";
        foreach($arr as $mas){
            if($mas['id'] == $id){
                $str .= Template::processTemplace("<option value='{{id}}' selected>{{title}}</option>", $mas);
            } else{
                $str .= Template::processTemplace($select, $mas);
		    }
        }
        return $str;
    }
}