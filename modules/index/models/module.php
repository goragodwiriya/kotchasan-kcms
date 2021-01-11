<?php
/**
 * @filesource module.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Index\Module;

/**
 * Description.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * อ่านข้อมูลโมดูลที่เลือก
     *
     * @param string $module
     *
     * @return object|bool คืนค่าผลลัพท์ที่พบเพียงรายการเดียว ไม่พบข้อมูลคืนค่า false
     */
    public static function get($module)
    {
        // เรียกใช้งาน Model
        $model = new static();
        // query ข้อมูลโมดูล (หน้าเพจ) ที่ต้องการ
        $query = $model->db()->createQuery()
            ->from('site')
            ->where(array(
                array('module', $module),
            ))
            ->cacheOn();
        // คำสั่งสำหรับดู query
        // SELECT * FROM `u`.`site` WHERE `module` = 'home' LIMIT 1
        //echo $query->select()->limit(1)->text();
        // คืนค่าข้อมูลที่พบ รายการเดียว

        return $query->first();
    }
}
