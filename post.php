<?php

class post
{
    private $data;

    public function setData($data){
        $this->data = $data;
    }

    public function getData(){
        return $this->data;
    }

    public function getID(){
        return $this->data['id'];
    }

    public function getTitle(){
        return $this->data['title'];
    }

    public function getUserID(){
        return $this->data['userId'];
    }

    public function __construct(array $data){
        $this->data = $data;
    }

    public function renderPost(){

        $text = $this->data["content"];
        if (strlen($this->data["content"]) > 150){
            $text = substr($this->data["content"],0,150)."...";
        }

        return '<div class="post" onclick="window.location.href=\'viewpost.php?id='.$this->data["id"].'\'">
                <div class="post-title">
                    <h3> '.$this->data['title'].'</h3>
            
                </div>
                <div class="post-preview-content">
                    <div class="post-preview-text">
                        '. $text .'
                    </div>
                </div>
            </div>';
    }
}