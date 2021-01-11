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
use Kotchasan\Http\Response;

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
     * API สำหรับอ่านข้อมูล chat.
     *
     * @param Request $request
     *
     * @return object ส่งกลับข้อมูล JSON
     */
    public function get(Request $request)
    {
        if ($request->initSession() && $request->isReferer()) {
            // ค่าที่ส่งมา
            $id = $request->post('id')->toInt();
            $name = $request->post('name')->topic();
            // เวลาปัจจุบันสำหรับส่งกลับ
            $result = array('time' => time());
            if ($id == 0) {
                // เรียกครั้งแรก
                $result['items'][] = array(
                    'create_date' => $result['time'],
                    'message' => 'เข้าร่วมสนทนา',
                    'name' => $name,
                );
            } else {
                // query ข้อมูล ถัดจากรายการที่ $id
                $query = $this->db->createQuery()
                    ->select()
                    ->from('chat')
                    ->where(array('create_date', '>', $id))
                    ->order('create_date')
                    ->toArray();

                foreach ($query->execute() as $item) {
                    $result['items'][$item['create_date']] = $item;
                }
            }
            // คืนค่า output เป็น JSON
            $responsre = new Response();
            $responsre->withHeader('Content-type', 'application/json')
                ->withContent(json_encode($result))
                ->send();
        }
    }

    /**
     * API สำหรับการ submit chat.
     *
     * @param Request $request
     */
    public function send(Request $request)
    {
        if ($request->initSession() && $request->isReferer()) {
            $save = array(
                'create_date' => time(),
                'name' => $request->post('name')->topic(),
                'message' => $request->post('message')->topic(),
                'ip' => $request->getClientIp(),
            );
            $this->db()->insert($this->getTableName('chat'), $save);
        }
    }

    /**
     * API สำหรับการสุ่มชื่อสมาชิก
     *
     * @param Request $request
     *
     * @return object ส่งกลับข้อมูล JSON
     */
    public function getUser(Request $request)
    {
        // ตาราง chat
        $table = $this->getTableName('chat');
        // ตรวจสอบวันใหม่ และ ลบข้อมูลการทนทนาออกหากเริ่มวันใหม่
        if (is_file(ROOT_PATH.DATA_FOLDER.'chat.log')) {
            $d = (int) file_get_contents(ROOT_PATH.DATA_FOLDER.'chat.log');
            if ($d != (int) date('d')) {
                // ลบข้อมูล
                $this->db()->emptyTable($table);
            }
        }
        // บันทึกวันนี้เป็นไฟล์
        $f = fopen(ROOT_PATH.DATA_FOLDER.'chat.log', 'w');
        fwrite($f, (int) date('d'));
        fclose($f);
        // ตรวจสอบชื่อสมาชิกซ้ำในฐานข้อมูล
        while (true) {
            $name = 'Guest_'.\Kotchasan\Text::rndname(4, '123456789');
            $find = $this->db()->find($table, array('name', $name));
            if (!$find) {
                break;
            }
        }
        // บันทึกการเข้าห้อง Chat
        $this->db()->insert($table, array(
            'create_date' => time(),
            'name' => $name,
            'ip' => $request->getClientIp(),
            'message' => 'เข้าร่วมสนทนา',
        ));
        // เตรียมตัวแปรสำหรับส่งค่ากลับ
        $result = array('name' => $name);
        // คืนค่า output เป็น JSON
        $responsre = new Response();
        $responsre->withHeader('Content-type', 'application/json')
            ->withContent(json_encode($result))
            ->send();
    }
}
