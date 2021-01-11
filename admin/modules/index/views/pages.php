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

use Kotchasan\DataTable;
use Kotchasan\Http\Request;
use Kotchasan\Text;

/**
 * module=member
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Kotchasan\View
{
    /**
     * ตารางรายการหน้าเพจ.
     *
     * @param Request $request
     *
     * @return string
     */
    public function render(Request $request)
    {
        // action
        $actions = array('delete' => 'Remove');
        // ตารางรายการหน้าเพจ
        $table = new DataTable(array(
            /* โหลดข้อมูลมาแสดงผลด้วย Model */
            'model' => 'Index\Pages\Model',
            /* กำหนดการแสดงผลตัวแบ่งหน้า */
            'perPage' => $request->cookie('pages_perPage', 30)->toInt(),
            /* กำหนดวิธีการจัดรูปแบบข้อมูลแต่ละแถวในการแสดงผลด้วยตัวเอง */
            'onRow' => array($this, 'onRow'),
            /* คอลัมน์ที่สามารถค้นหาได้ */
            'searchColumns' => array('module', 'topic', 'detail'),
            /* ตั้งค่าการกระทำของของตัวเลือกต่างๆ ด้านล่างตาราง ซึ่งจะใช้ร่วมกับการขีดถูกเลือกแถว */
            'action' => 'index.php/index/model/pages/action',
            'actions' => array(
                array(
                    'id' => 'action',
                    'class' => 'ok',
                    'text' => 'ทำกับที่เลือก',
                    'options' => $actions,
                ),
            ),
            /* รายชื่อฟิลด์ที่ query (ถ้าแตกต่างจาก Model) */
            'fields' => array(
                'id',
                'module',
                'topic',
                'detail',
            ),
            /* ส่วนหัวของตาราง และการเรียงลำดับ (thead) */
            'headers' => array(
                'id' => array(
                    'text' => 'ID',
                    'class' => 'center',
                ),
                'module' => array(
                    'text' => 'โมดูล',
                ),
                'topic' => array(
                    'text' => 'หัวข้อ',
                ),
                'detail' => array(
                    'text' => 'รายละเอียด',
                ),
            ),
            /* รูปแบบการแสดงผลของคอลัมน์ (tbody) */
            'cols' => array(
                'id' => array(
                    'class' => 'center',
                ),
            ),
            /* ปุ่มแสดงในแต่ละแถว */
            'buttons' => array(
                array(
                    'class' => 'icon-edit button green',
                    'href' => 'index.php?module=pagewrite&amp;id=:id',
                    'text' => 'แก้ไข',
                ),
            ),
            /* ปุ่มเพิ่ม */
            'addNew' => array(
                'class' => 'float_button icon-new',
                'href' => 'index.php?module=pagewrite',
                'title' => 'เพิ่มหน้าเพจ',
            ),
        ));
        // save cookie
        setcookie('pages_perPage', $table->perPage, time() + 3600 * 24 * 365, '/');

        return $table->render();
    }

    /**
     * จัดรูปแบบการแสดงผลในแต่ละแถว.
     *
     * @param array $item
     *
     * @return array
     */
    public function onRow($item, $o, $prop)
    {
        $item['topic'] = '<a href="../index.php?module='.$item['module'].'" target=_blank>'.$item['topic'].'</a>';
        $item['detail'] = Text::cut(strip_tags($item['detail']), 100);
        // คืนค่าข้อมูลทั้งหมดหลังจากจัดรูปแบบแล้วกลับไปแสดงผล

        return $item;
    }
}
