<?php

use codeseasy\projecthandler\Handler;

require "src/Handler.php";

echo Handler::init($_REQUEST['domain']);

