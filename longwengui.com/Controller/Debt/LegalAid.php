<?php
/**
 * @desc  法律援助
 */
class LegalAid
{
    public function Index(){
        $Nav='legalaid';
        $MemberLawfirmAidModule = new MemberLawfirmAidModule();
        include template('LegalAidIndex');
    }
}