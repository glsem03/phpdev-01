<?php
class Node implements NodeInterface 
{
    //попробовал добавлять в массив дочерние элементы через метод addChild
    public string $name;
    public $childs = array();
    function __consruct(string $name)
    {
        $this->name = $name;
    }
    function __toString()
    {
        return $this->text;
    }
    function getName() 
    {
        return $name;
    }
    function addChild(Node $node) 
    {
        array_push($childs, $node);
    }
}
?>