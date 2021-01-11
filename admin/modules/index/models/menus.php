<?php
/**
 * @filesource menus.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Index\Menus;

use Kotchasan\Http\Request;
use Kotchasan\Login;

/**
 * ตารางเมนู.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Orm\Field
{
    /**
     * ชื่อตาราง.
     *
     * @var string
     */
    protected $table = 'menu';

    /**
     * อ่านรายการเมนูที่ ID สำหรับการแก้ไข
     * หรือ อ่าน ID ถัดไป ของเมนู สำหรับการสร้างเมนูใหม่.
     *
     * @param int $id ID ของรายการที่ต้องการ
     *
     * @return object|bool คืนค่ารายการที่พบ, ไม่พบคืนค่า false
     */
    public static function get($id)
    {
        // เรียกใช้งาน Model
        $model = new \Kotchasan\Model();
        if ($id == 0) {
            // สร้างเมนูใหม่ query ID ถัดไป ของเมนูเพื่อใช้เป็นเลขลำดับของเมนูต่อจากเมนูสุดท้าย
            // (1 + IFNULL((SELECT MAX(`order`) FROM `u`.`menu`), 0)) AS `order`
            $q1 = $model->db()->createQuery()->buildNext('order', 'menu', null, 'order');
            // SELECT 0 AS `id`, (1 + IFNULL((SELECT MAX(`order`) FROM `u`.`menu`), 0)) AS `order` LIMIT 1

            return $model->db()->createQuery()->first('0 id', $q1);
        } else {
            // ตรวจสอบรายการที่แก้ไข
            // SELECT * FROM `u`.`menu` WHERE `id` = $id LIMIT 1
            return $model->db()->createQuery()->from('menu')->where($id)->first();
        }
    }

    /**
     * รับค่าจาก action ของตาราง.
     *
     * @param Request $request
     */
    public function action(Request $request)
    {
        // session, referer, member
        if ($request->initSession() && $request->isReferer() && Login::isMember()) {
            $action = $request->post('action')->toString();
            if ($action == 'delete') {
                // รับค่า id แยกออกเป็นแอเรย์และแปลงให้เป็นตัวเลข
                $ids = array();
                foreach (explode(',', $request->post('id')->filter('\d,')) as $item) {
                    $ids[] = (int) $item;
                }
                // ลบข้อมูลด้วย Model
                $model = new \Kotchasan\Model();
                $model->db()->delete($model->getTableName('menu'), array('id', $ids), 0);
            }
        }
    }

    /**
     * รับค่าจาก form.
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        // session, token, member
        if ($request->initSession() && $request->isSafe() && Login::isMember()) {
            // รับค่าจากการ POST
            $save = array(
                'order' => $request->post('write_order')->toInt(),
                'module' => $request->post('write_module')->username(),
                'text' => $request->post('write_text')->topic(),
                'url' => $request->post('write_url')->url(),
                'target' => $request->post('write_target')->topic(),
            );
            // รายการที่แก้ไข 0 รายการใหม่
            $id = $request->post('write_id')->toInt();
            // ตรวจสอบค่าที่ส่งมา
            $ret = array();
            // เรียกใช้งาน Model
            $model = new \Kotchasan\Model();
            $db = $model->db();
            // โหลดเมนูทั้งหมดออกมาก่อน
            // SELECT * FROM u.`menu` ORDER BY `order`, `id`
            $query = $db->createQuery()->select()->from('menu')->order('order', 'id');
            $menus = array();
            foreach ($query->execute() as $item) {
                $menus[$item->id] = $item;
                unset($menus[$item->id]->id);
            }
            if ($id > 0 && !isset($menus[$id])) {
                $ret['alert'] = 'ไม่พบข้อมูลที่แก้ไข กรุณารีเฟรช';
            } elseif ($save['module'] == '') {
                $ret['alert'] = 'กรุณากรอก โมดูล';
                $ret['input'] = 'write_module';
            } elseif ($save['text'] == '') {
                $ret['alert'] = 'กรุณากรอก ข้อความบนเมนู ';
                $ret['input'] = 'write_text';
            } else {
                // ชื่อตาราง menu
                $table_name = $model->getTableName('menu');
                // ลบข้อมูลทั้งหมดในตาราง
                $db->emptyTable($table_name);
                $order = 1;
                foreach ($menus as $key => $item) {
                    // ตรงกับ ID ที่ต้องการ เก็บรายการใหม่
                    if ($save['order'] == $order) {
                        $db->insert($table_name, $save);
                        ++$order;
                    }
                    // รายการใหม่ หรือ ไม่ใช่รายการที่แก้ไข เก็บรายการเดิม
                    if ($id == 0 || $key != $id) {
                        $item->order = $order;
                        $db->insert($table_name, $item);
                        ++$order;
                    }
                }
                // รายการใหม่ที่เป็นรายการสุดท้าย
                if ($save['order'] >= $order) {
                    $save['order'] = $order;
                    $db->insert($table_name, $save);
                }
                // เคลียร์ Token
                $request->removeToken();
                // คืนค่า
                $ret['alert'] = 'บันทึกเรียบร้อย';
                $ret['location'] = 'index.php?module=menus';
            }
            // คืนค่าเป็น JSON
            echo json_encode($ret);
        }
    }
}
