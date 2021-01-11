<?php
/**
 * @filesource main.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Index\Main;

use Kotchasan\Http\Request;
use Kotchasan\Template;

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
     * เริ่มต้นใช้งานโมดูล
     * อ่านข้อมูลโมดูลออกมา แล้วส่งให้ View
     * ข้อมูลจาก View ส่งกลับไปให้ Controller หลัก
     *
     * @param Request $request
     * @param string  $module
     *
     * @return object
     */
    public function init(Request $request, $module)
    {
        // ตรวจสอบหน้าที่เรียกจากฐานข้อมูล
        $page = \Index\Module\Model::get($module);
        if ($page === false) {
            $index = new \Index\Pagenotfound\View();
            $title = $index->title();
            $detail = $index->render();
        } else {
            $title = $page->topic;
            $detail = $page->detail;
        }
        // เริ่มต้นใช้งาน View ของโมดูล Main
        $view = new \Kotchasan\View();
        // ใส่เนื้อหาลงใน View ตามที่กำหนดใน Template
        $view->setContents(array(
            // หัวข้อ
            '/{TOPIC}/' => $title,
            // เนื้อหา
            '/{DETAIL}/' => $detail,
        ));
        // โหลด template หน้า main (main.html)
        $template = Template::load('', '', 'main');
        // คืนค่าข้อมูลโมดูล

        return (object) array(
            'module' => $module,
            'title' => $title,
            'detail' => $view->renderHTML($template),
        );
    }
}
