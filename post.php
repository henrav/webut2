<?php

abstract class Post{
    protected $data;

    public function __construct($data){
        $this->data = $data;
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

        return '<div class="post" onclick="window.location.href=\'viewpost.php?ID='.$this->data["id"].'\'">
                <div class="post-title">
                    <h3> '.$this->data['title'].'</h3>
            
                </div>
                <div class="post-preview-content">
                    <div class="post-preview-text">
                        '. $text .'
                    </div>
                </div>
                <div class="post-footer">
               
                    <div class="post-footer-username">
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

        return '<div class="title-post">
            <h1>'.$this->data['title'].'</h1>
        </div>
        <div class="content">   
             '. $this->data["content"] .'
        </div>
        <div class="post-footer">
             <div class="post-footer-username">
               '.  $this->data['username'] .'
            </div>
           <div class="user-image">
                 <img src="'. $imgPath. '" alt="">
            </div>
            <div class="post-date">
               '.  $this->data['created'] .'
            </div>
        </div>';
    }
}