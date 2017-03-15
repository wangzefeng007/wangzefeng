<?php
/**
 * @desc  搜索老赖
 */
class DeadBeat
{
    public function index(){
        $Nav='SearchDeadBeat';
        echo '搜索老赖';

        include template('SearchDeadBeat');
    }
}