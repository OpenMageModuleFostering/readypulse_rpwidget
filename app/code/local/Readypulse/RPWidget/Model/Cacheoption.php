<?php

class Readypulse_RPWidget_Model_Cacheoption
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'true',
                'label' => 'Yes'
            ),
            array(
                'value' => 'false',
                'label' => 'No'
            )
        );
    }
}

?>
