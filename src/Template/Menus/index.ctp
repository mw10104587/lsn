<?php
    if($identity == 'admin') {
        echo $this->element('admin_sidebar');
    } else {
        echo $this->element('general_sidebar');
    }
?>