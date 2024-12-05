<?php

class Controller {

    require_once 'components/connect.php';
require_once 'models/users.php';
    $user_model = new User($conn);

    $user_model->getByEmail($_POST['email']);
}

