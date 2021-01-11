<?php
/**
 * @filesource modules/index/models/menu.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Index\Menu;

/**
 * รายการเมนู.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * ข้อมูลรายการเมนู.
     *
     * @return array
     */
    public static function get()
    {
        // เรียกใช้งาน Model
        $model = new static();
        // query ข้อมูลเมนูจากฐานข้อมูล
        $query = $model->db()->createQuery()
            ->select()
            ->from('menu')
            ->order('order ASC')
            ->cacheOn();
        // คำสั่งสำหรับดู query
        // SELECT * FROM `u`.`menu` ORDER BY `order` ASC
        //echo $query->text();
        $result = array();
        // query ข้อมูลและจัดรูปแบบเพื่อใส่ลงใน Array ตามข้อกำหนดของโมดูล
        foreach ($query->execute() as $item) {
            // จัดรูปแบบข้อมูลเมนูให้เหมาะสม สำหรับการสร้างเมนู
            $result[$item->module] = array(
                'text' => $item->text,
                'target' => $item->target,
            );
            if (empty($item->url)) {
                $result[$item->module]['url'] = WEB_URL.'index.php?module='.$item->module;
            } else {
                $result[$item->module]['url'] = $item->url;
            }
        }
        // คืนค่ารายการเมนูที่จัดรูปแบบแล้ว

        return $result;
    }
}
