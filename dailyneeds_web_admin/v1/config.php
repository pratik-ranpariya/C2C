<?php
date_default_timezone_set('Asia/Kolkata');
/**
 * MIT License
 * ===========
 *
 * Copyright (c) 2012 oengines oengines.studio@gmail.com
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @category   [ Category ]
 * @package    [ Package ]
 * @subpackage [ Subpackage ]
 * @author     oengines oengines.studio@gmail.com
 * @copyright  2012 oengines.oengines.studio@gmail.com
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    [ Version ]
 * @link       http://www.oengines.com
 */
define('ENCR', '5d05e40c518e6ee109b8afa79eba7db5');
define('IV', '567c996739edfa1cdbad4c55a80580df');

// define('URL', 'http://admin.dailyneeds.co.nz');
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', 'dailyneeds@2019');
// define('DB_DATABASE', 'dailyneeds');

define('URL', 'http://localhost/dailyneeds/dailyneeds/html/dailyneeds_web_admin/');
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'newmagic');

 $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

 // Check connection
if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
