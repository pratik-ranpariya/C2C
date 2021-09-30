<?php

session_start();
session_destroy();
header('Location:http://localhost/dailyneeds/dailyneeds/html/dailyneeds_web_admin/index');
