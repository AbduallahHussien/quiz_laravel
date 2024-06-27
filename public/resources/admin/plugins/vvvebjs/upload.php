<?php
//This script is used by image upload input to save the imge on the server and return the image url to be set as image src attribute.

define('UPLOAD_FOLDER', explode('assets', __DIR__)[0] . 'uploads/certificates/');
define('UPLOAD_PATH', '../uploads/certificates/');
move_uploaded_file($_FILES['file']['tmp_name'], UPLOAD_FOLDER . $_FILES['file']['name']);

echo UPLOAD_PATH . $_FILES['file']['name'];
