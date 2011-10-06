<?php
    sleep(1);
    echo '{success:TRUE, file:'.json_encode($_FILES['photo-path']['name']).'}';
