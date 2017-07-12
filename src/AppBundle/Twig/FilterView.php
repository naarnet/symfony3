<?php

namespace AppBundle\Twig;

class FilterView extends \Twig_Extension
{

    public function getName()
    {
        return 'filter_view';
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter("addText", array($this, 'addText'))
        );
    }

    public function addText($string,$num)
    {
        return $string."TEXTO CONCATENADO".$num;
    }

}
