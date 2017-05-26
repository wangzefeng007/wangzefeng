<?php
/**
 * @desc  法律援助
 */
class LegalAid
{
    public function Index(){
        $MemberLawfirmAidModule = new MemberLawfirmAidModule();
        include template('LegalAidIndex');
    }
}