<?php

echo "Useredit";

$id        = filter_input(INPUT_POST, 'id');
$firstname = filter_input(INPUT_POST, 'firstname');
$lastname  = filter_input(INPUT_POST, 'lastname');
$username  = filter_input(INPUT_POST, 'username');
$email     = filter_input(INPUT_POST, 'email');
$public_as = filter_input(INPUT_POST, 'public_as');