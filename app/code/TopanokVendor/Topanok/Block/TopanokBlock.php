<?php


namespace TopanokVendor\Topanok\Block;


class TopanokBlock extends \Magento\Framework\View\Element\Template
{

    public function getWelcomeText()
    {
        return 'Hello my friend!!!';
    }
    public function sayBye()
    {
    	return 'Bye, my friend!!!';
    }
    public function itsOkey(){
    	return 'its OKKEY MAN !!!';
    }
}