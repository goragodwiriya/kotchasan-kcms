<?php
/**
 * @filesource pages.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Index\Pages;

use Kotchasan\Http\Request;
use Kotchasan\Login;

/**
 * ตารางหน้าเพจ.
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
    protected $table = 'site';

    /**
     * อ่านรายการโมดูลที่ ID สำหรับการแก้ไข
     * หรือคืนค่า id = 0 สำหรับการเพิ่มโมดูลใหม่.
     *
     * @param int $id ID ของรายการที่ต้องการ
     *
     * @return object|bool คืนค่ารายการที่พบ, ไม่พบคืนค่า false
     */
    public static function get($id)
    {
        if ($id === 0) {
            return (object) array(
                'id' => 0,
            );
        } else {
            // เรียกใช้งาน Model
            $model = new \Kotchasan\Model();
            // ตรวจสอบรายการที่แก้ไข
            // SELECT * FROM `u`.`site` WHERE `id` = $id LIMIT 1

            return $model->db()->createQuery()->from('site')->where($id)->first();
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
                $model->db()->delete($model->getTableName('site'), array('id', $ids), 0);
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
                'module' => $request->post('write_module')->username(),
                'topic' => $request->post('write_topic')->topic(),
                'detail' => $request->post('write_detail')->detail(),
            );
            // รายการที่แก้ไข 0 รายการใหม่
            $id = $request->post('write_id')->toInt();
            // ตรวจสอบค่าที่ส่งมา
            $ret = array();
            if ($id > 0) {
                // ตรวจสอบรายการที่แก้ไข
                $index = self::get($id);
            }
            if ($id > 0 && !$index) {
                $ret['alert'] = 'ไม่พบข้อมูลที่แก้ไข กรุณารีเฟรช';
            } elseif ($save['module'] == '') {
                $ret['alert'] = 'กรุณากรอก โมดูล';
                $ret['input'] = 'write_module';
            } elseif ($save['topic'] == '') {
                $ret['alert'] = 'กรุณากรอก หัวข้อ';
                $ret['input'] = 'write_topic';
            } else {
                // เรียกใช้งาน Model
                $model = new \Kotchasan\Model();
                // บันทึก
                if ($id == 0) {
                    // ใหม่
                    $model->db()->insert($model->getTableName('site'), $save);
                } else {
                    // แก้ไข
                    $model->db()->update($model->getTableName('site'), $id, $save);
                }
                // เคลียร์ Token
                $request->removeToken();
                // คืนค่า
                $ret['alert'] = 'บันทึกเรียบร้อย';
                $ret['location'] = 'index.php?module=pages';
            }
            // คืนค่าเป็น JSON
            echo json_encode($ret);
        }
    }
}
