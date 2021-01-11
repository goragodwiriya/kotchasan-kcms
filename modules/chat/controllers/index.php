<?php
/**
 * @filesource index.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Chat\Index;

use Kotchasan\Http\Request;

/**
 * Description.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Kotchasan\Controller
{
    /**
     * @param Request $request
     * @param $module
     */
    public function init(Request $request, $module)
    {
        // คืนค่าข้อมูลโมดูล
        return (object) array(
            'module' => $module,
            'title' => 'Chat',
            'detail' => \Chat\Index\View::render($request),
        );
    }
}
