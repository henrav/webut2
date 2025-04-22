<?php

abstract class Post{
    // abstract Post class

    // datan från databasen
    protected $data;

    // flagga för om man får redigera posten
    protected $editable = false;
    public function __construct($data, $editable = false){
        $this->data = $data;
        $this->editable = $editable;
    }

    abstract public function renderPost();
}

//index post är poster på index.php och profile.php
class indexPost extends Post
{
    // callar den för att printa posten varje grej
    public function renderPost(){


        if (! is_array($this->data)) {
            return '<div class="error" style="color: black">Oops: något fel hände här.</div>';
        }
        // visa inte all text
        $text = $this->data["content"];
        if (strlen($this->data["content"]) > 100){
            $text = substr($this->data["content"],0,100)."...";
        }
        $id = $this->data["id"];
        // hämta path, om tom, default till scout
        $imgPath = !empty($this->data['image'] || $this->data['image'] != '')
            ? 'uploads/'. $this->data['image']
            : 'images/scout_eating.jpg';

        // om editable, skapa två knappar och lägg till den till return satsen
        $editBtn = '';
        if ($this->editable) {
            $editBtn = "<div style='display: block; margin-left: auto; margin-right: auto; '>
                    <button class='redigera'  onclick=\"getEditPost({$id})\">Redigera</button> 
                    <button class='redigera tabort' onclick=\"getDelete({$id})\">Ta bort</button>       
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
        //basicly samma som indexpost, fast utan knappar
        if (!is_array($this->data)) {
            return '<div class="error" style="color: black">Oops: något fel hände här.</div>';
        }
        $imgPath = !empty($this->data['image'] || $this->data['image'] != '')
            ? 'uploads/'. $this->data['image']
            : 'images/scout_eating.jpg';

        $postIMG = !empty($this->data['filename'] || $this->data['filename'] != '')
            ? 'uploads/'. $this->data['filename']
            : 'images/scout_eating.jpg';

        return '<div class="container-för-att-kolla-på-posten-grejen-eller-någonting">
                 <div class="title-post">
                            <h1>'.$this->data['title'].'</h1>
                        </div>
                        <div class="post-content-image-container" style="color: black">
                        <div style="text-align: center; font-size: 18; font-weight: bold">'. $this->data['description'] .'</div>
                            <div class="post-image-container">
                             <img src='.$postIMG.' alt="">
                            </div>
                            <div class="content">   
                             '. $this->data["content"] .'
                            
                            </div>
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