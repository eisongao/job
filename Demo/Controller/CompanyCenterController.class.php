<?php
namespace Demo\Controller;
use Think\Controller;
class CompanyCenterController extends Controller {
    public function center(){
       $this->display();
    }
    public function job(){
       $this->display();
    }
    public function unprocessed(){
       $this->display();
    }
    //高级筛查：简历管理、职位管理-》操作-》简历
    public function screen(){
        $this->display();
    }
    public function all(){
       $this->display();
    }
    public function editjob(){
       $this->display();
    }
    public function comment(){
       $this->display();
    }
    public function editpass(){
       $this->display();
    }
    public function editemail(){
       $this->display();
    }
    public function basic(){
       $this->display();
    }
    public function financing(){
       $this->display();
    }
    public function production(){
        $this->display();
    }
    //查看个人简历
    public function apply(){
        $this->display();
    }
}