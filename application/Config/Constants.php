<?php

//--------------------------------------------------------------------
// App Namespace
//--------------------------------------------------------------------
// This defines the default Namespace that is used throughout
// CodeIgniter to refer to the Application directory. Change
// this constant to change the namespace that all application
// classes should use.
//
// NOTE: changing this will require manually modifying the
// existing namespaces of App\* namespaced-classes.
//
$roles = [
		'user' => [
				'user_view',
				'user_add',
				'user_update',
				'user_delete',
				'user_list'
		],
		'request' => [
				'request_view',
				'request_add',
				'request_update',
				'request_delete',
				'request_list'
		],
		'problems' => [
				'problems_view',
				'problems_add',
				'problems_update',
				'problems_delete',
				'problems_list'
		],
		'incident' => [
				'incident_view',
				'incident_add',
				'incident_update',
				'incident_delete',
				'incident_list'
		],
		'workaround' => [
				'workaround_view',
				'workaround_add',
				'workaround_update',
				'workaround_delete',
				'workaround_list'
		],
		'equipment' => [
				'equipment_view',
				'equipment_add',
				'equipment_update',
				'equipment_delete',
				'equipment_list'
		],
		'permission_f' => [
				'permission_add',
				'permission_change'
		],
		'report' => [
				'report_view',
				'report_change'
		],
		'contact' => [
				'contact_view',
				'contact_update'
		],
		'news' => [
				'news_view',
				'news_add',
				'news_update',
				'news_delete',
				'news_list'
		],
		'message_f' => [
				'message_view',
				'message_add',
				'message_update',
				'message_delete',
				'message_list'
		],
		'member_f' => [
				'member_request',
				'member_problems',
				'member_incident'
		],
];

$userRoles = [
		'user_view',
		'user_add',
		'user_update',
		'user_delete',
		'user_list'
];
$newsRoles = [
		'news_view',
		'news_add',
		'news_update',
		'news_delete',
		'news_list'
];
$messageRoles = [
		'message_view',
		'message_add',
		'message_update',
		'message_delete',
		'message_list'
];
$requestRoles = [
		'request_view',
		'request_add',
		'request_update',
		'request_delete',
		'request_list'
];
$problemsRoles = [
		'problems_view',
		'problems_add',
		'problems_update',
		'problems_delete',
		'problems_list'
];
$incidentRoles = [
		'incident_view',
		'incident_add',
		'incident_update',
		'incident_delete',
		'incident_list'
];
$equipmentRoles = [
		'equipment_view',
		'equipment_add',
		'equipment_update',
		'equipment_delete',
		'equipment_list'
];
$permissionRoles = [
		'permission_add',
		'permission_change'
];
$reportRoles = [
		'report_view',
		'report_change'
];
$petition = [
		'member_request',
		'member_problems',
		'member_incident'
];

define('APP_NAMESPACE', 'App');

define('APP_PERMISSION', $roles);

define('APP_PERMISSION_USER', $userRoles);
define('APP_PERMISSION_NEWS', $newsRoles);
define('APP_PERMISSION_MESSAGE', $messageRoles);
define('APP_PERMISSION_REQUEST', $requestRoles);
define('APP_PERMISSION_PROBLEMS', $problemsRoles);
define('APP_PERMISSION_INCIDENT', $incidentRoles);
define('APP_PERMISSION_EQUIPMENT', $equipmentRoles);
define('APP_PERMISSION_MANAGER', $permissionRoles);
define('APP_PERMISSION_REPORT', $reportRoles);
define('APP_PERMISSION_PETITION', $petition);
/*
|--------------------------------------------------------------------------
| Composer Path
|--------------------------------------------------------------------------
|
| The path that Composer's autoload file is expected to live. By default,
| the vendor folder is in the Root directory, but you can customize that here.
*/
define('COMPOSER_PATH', ROOTPATH.'vendor/autoload.php');

/*
|--------------------------------------------------------------------------
| Timing Constants
|--------------------------------------------------------------------------
|
| Provide simple ways to work with the myriad of PHP functions that
| require information to be in seconds.
*/
defined('SECOND')   || define('SECOND',                 1);
defined('MINUTE')   || define('MINUTE',                60);
defined('HOUR')     || define('HOUR',                3600);
defined('DAY')      || define('DAY',                86400);
defined('WEEK')     || define('WEEK',              604800);
defined('MONTH')    || define('MONTH',            2592000);
defined('YEAR')     || define('YEAR',            31536000);
defined('DECADE')   || define('DECADE',         315360000);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS',        0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR',          1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG',         3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE',   4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS',  5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT',     7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE',       8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN',      9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX',    125); // highest automatically-assigned error code
