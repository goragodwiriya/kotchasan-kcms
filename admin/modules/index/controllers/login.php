<?php
/**
 * @filesource login.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Index\Login;

use Kotchasan\Http\Request;
use Kotchasan\Login;
use Kotchasan\Template;

/**
 * Login Form.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Kotchasan\Controller
{
    /**
     * แสดง หน้า Login.
     *
     * @param Request $request
     *
     * @return object
     */
    public static function init(Request $request)
    {
        // template
        $template = Template::create('', '', 'login');
        $template->add(array(
            '/{TOKEN}/' => $request->createToken(),
            '/{EMAIL}/' => isset(Login::$login_params['username']) ? Login::$login_params['username'] : '',
            '/{PASSWORD}/' => isset(Login::$login_params['password']) ? Login::$login_params['password'] : '',
            '/{MESSAGE}/' => Login::$login_message,
            '/{CLASS}/' => empty(Login::$login_message) ? 'hidden' : (empty(Login::$login_input) ? 'message' : 'error'),
        ));
        // คืนค่าข้อมูลโมดูล

        return (object) array(
            'module' => 'login',
            'title' => self::$cfg->web_title,
            'detail' => $template->render(),
        );
    }
}
