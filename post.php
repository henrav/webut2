<?php

abstract class Post{
    protected $data;
    protected $editable = false;
    public function __construct($data, $editable = false){
        $this->data = $data;
        $this->editable = $editable;
    }

    abstract public function renderPost();
}

class indexPost extends Post
{
    public function renderPost(){
        if (! is_array($this->data)) {
            return '<div class="error" style="color: black">Oops: något fel hände här.</div>';
        }
        $text = $this->data["content"];
        if (strlen($this->data["content"]) > 100){
            $text = substr($this->data["content"],0,100)."...";
        }
        $imgPath = ! empty($post['image'])
            ? $post['image']
            : 'images/Heavy_from_tf2 copy.png';
        $editBtn = '';
        $id = $this->data["id"];
        if ($this->editable) {
            $editUrl = "editpost.php?ID={$this->data['id']}";
            $editBtn = "<div style='display: block; margin-left: auto; margin-right: auto; '>
                    <button class='redigera'  onclick=\"getEditPost({$id})\">Redigera</button> 
                    <button class='redigera' onclick=\"getDelete({$id})\">Ta bort</button>       
                </div>";
        }

        return '<div class="post">
                    <div class="post-title-container">
                        <div class="post-title" style="grid-column: 2">
                            <h3> '.$this->data['title'].'</h3>
                         
                        </div>
                        '.$editBtn.'
                    </div>
              
                <div class="post-preview-content" onclick="window.location.href=\'viewpost.php?ID='.$this->data["id"].'\'">
                    <div class="post-preview-text">
                        '. $text .'
                    </div>
                </div>
                <div class="post-footer" onclick="window.location.href=\'viewpost.php?ID='.$this->data["id"].'\'">
               
                    <div class="post-footer-username" >
                       '.  $this->data['username'] .'
                    </div>
                    <div class="user-image">
                     <img src="'. $imgPath. '" alt="">
                    </div>
                    <div class="post-date">
                       ' . $this->data['created'] . ": " .' 
                    </div>
                </div>
            </div>';
    }
}

class viewPost extends Post
{
    public function renderPost(){
        if (! is_array($this->data)) {
            return '<div class="error" style="color: black">Oops: något fel hände här.</div>';
        }
        $imgPath = ! empty($post['image'])
            ? $post['image']
            : '/images/Heavy_from_tf2 copy.png';

        return '<div class="container-för-att-kolla-på-posten-grejen-eller-någonting">
                 <div class="title-post">
                            <h1>'.$this->data['title'].'</h1>
                        </div>
                        <div class="content">   
                             '. $this->data["content"] .'
                        </div>
                        <div class="post-footer">
                            <div style="display: flex; flex-direction: row; justify-content: center; align-items: center; border-right: 1px solid black">
                                <div class="post-footer-username">
                                   '.  $this->data['username'] .'
                                </div>
                                <div class="user-image">
                                     <img src="'. $imgPath. '" alt="">
                                </div>
                                <div class="post-date">
                                   '.  $this->data['created'] .'
                                </div>
                            </div>
                            <button class="footer-mer-från" onclick="window.location.href=\'profile.php?ID='.$this->data["userId"].'\'">
                                    Mer från '. $this->data["username"] .'
                            </button>
                        
                             
                        </div>
                </div>
           ';
    }
}