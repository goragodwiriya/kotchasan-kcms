<?php
/**
 * @filesource index.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Guestbook\Index;

use Kotchasan\Http\Request;

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
     * ลิสต์รายการ.
     *
     * @param Request $request
     *
     * @return object
     */
    public static function get(Request $request)
    {
        $model = new static();
        $query = $model->db()->createQuery()->from('guestbook');
        // เปิดใช้งาน cache ถ้าไม่มี $_GET[visited]
        if (!$request->get('visited')->exists()) {
            $query->cacheOn();
        }
        // จำนวน
        $index = (object) array(
            'list_per_page' => 10,
            'total' => $query->count(),
        );
        // ข้อมูลแบ่งหน้า
        $index->page = $request->get('page')->toInt();
        $index->totalpage = ceil($index->total / $index->list_per_page);
        $index->page = max(1, ($index->page > $index->totalpage ? $index->totalpage : $index->page));
        $index->start = $index->list_per_page * ($index->page - 1);
        // query
        $query->select()->order('create_date DESC')->limit($index->list_per_page, $index->start);
        // เปิดใช้งาน cache ถ้าไม่มี $_GET[visited]
        if (!$request->get('visited')->exists()) {
            $query->cacheOn();
        }
        $index->items = $query->execute();
        // คืนค่า

        return $index;
    }

    /**
     * รับค่าจากฟอร์ม
     *
     * @param Request $request
     */
    public function save(Request $request)
    {
        // session, referer, token
        if ($request->initSession() && $request->isReferer() && $request->isSafe()) {
            // รับค่าจากการ POST
            $save = array(
                'detail' => $request->post('write_detail')->textarea(),
                'name' => $request->post('write_name')->topic(),
            );
            // ตรวจสอบค่าที่ส่งมา
            $ret = array();
            if ($save['detail'] == '') {
                // ไม่ได้กรอกรายละเอียด
                $ret['alert'] = 'กรุณากรอกรายละเอียด';
                $ret['input'] = 'write_detail';
            } elseif ($save['name'] == '') {
                // ไม่ได้กรอกชื่อผู้เขียน
                $ret['alert'] = 'กรุณากรอกชื่อผู้เขียน';
                $ret['input'] = 'write_name';
            } else {
                $save['create_date'] = date('Y-m-d H:i:s');
                $save['ip'] = $request->getClientIp();
                // บันทึก
                $model = new static();
                $model->db()->insert($model->getTableName('guestbook'), $save);
                // คืนค่า
                $ret['alert'] = 'ขอบคุณสำหรับการเยี่ยมชม';
                $ret['location'] = WEB_URL.'index.php?module=guestbook&visited='.time();
                // clear
                $request->removeToken();
            }
            // คืนค่าเป็น JSON
            echo json_encode($ret);
        }
    }

    /**
     * ลบข้อมูล ต้องเข้าระบบมาจากแอดมินก่อน.
     *
     * @param Request $request
     */
    public function delete(Request $request)
    {
        // session, referer, login
        if ($request->initSession() && $request->isReferer() && \Kotchasan\Login::isMember()) {
            // รายการที่ต้องการลบ
            $id = $request->post('id')->toInt();
            // ลบข้อมูล
            $this->db()->delete($this->getTableName('guestbook'), $id);
            // คืนค่า
            $ret['alert'] = 'ลบเรียบร้อย';
            $ret['location'] = WEB_URL.'index.php?module=guestbook&visited='.time();
            // คืนค่าเป็น JSON
            echo json_encode($ret);
        }
    }
}
