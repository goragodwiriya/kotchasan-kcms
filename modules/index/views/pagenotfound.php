<?php
/**
 * @filesource pagenotfound.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Index\Pagenotfound;

/**
 * เนื้อหาหน้า Page Not Found.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Kotchasan\View
{
    /**
     * เนื้อหาหน้า 404.
     *
     * @return string
     */
    public function render()
    {
        return '<div class=error>ขออภัย : ไม่พบหน้าที่เรียก</div>';
    }

    /**
     * คืนค่าข้อความบนไตเติลบาร์เมื่อแสดงหน้านี้ ไปยัง Controller.
     *
     * @return string
     */
    public function title()
    {
        return '404 Page Not Found!';
    }
}
