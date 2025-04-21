<?php
//gav upp på denna, börja klockan 02 sen orka ja inte



abstract class Nyheter
{
    protected $data;

    public function __construct($data){
        $this->data = $data;
    }

    abstract public function renderPost();
}

class nyUser extends Nyheter{

    public function renderPost(){

    }


}

class nyPost extends Nyheter{
    public function renderPost(){

    }
}