<?php

namespace Database\Seeders\IE;

use Illuminate\Database\Seeder;
use DB;
// use App\HrOperatingUnit;

class CategoryTableSeeder extends Seeder
{
        /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('oracle_oaie')->table('ptw_categories')->truncate();
        DB::connection('oracle_oaie')->table('ptw_categories')->insert($this->categories());
    }

    public function categories()
    {
      $lists = [];
        array_push($lists, [
         'name' => 'ค่าเดินทางในประเทศ (Domestic Business trip)',
         'description' => 'ค่าเดินทางในประเทศ (Domestic Business trip)',
         'icon' => 'fa-car',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        // array_push($lists, [
        //  'name' => 'ค่าเดินทางในประเทศเพื่อไปทำงานสินไหม (Claim Domestic Business trip)',
        //  'description' => 'ค่าเดินทางในประเทศเพื่อไปทำงานสินไหม (Claim Domestic Business trip)',
        //  'icon' => 'fa-car',
        //  'active' => true,
        //  'last_updated_by' => date('Y-m-d H:i:s'),
        //  'last_update_date' => date('Y-m-d H:i:s'),
        //  'last_updated_by' => -1,
        //  'created_by' => -1
        // ]);
        array_push($lists, [
         'name' => 'ค่าเดินทางต่างประเทศ (Overseas Business trip)',
         'description' => 'ค่าเดินทางต่างประเทศ (Overseas Business trip)',
         'icon' => 'fa-plane',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าที่พักในประเทศ (Domestic Accomodation)',
         'description' => 'ค่าที่พักในประเทศ (Domestic Accomodation)',
         'icon' => 'fa-home',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        // array_push($lists, [
        //  'name' => 'ค่าที่พักในประเทศเพื่อไปทำงานสินไหม (Claim Domestic Accomodation)',
        //  'description' => 'ค่าที่พักในประเทศเพื่อไปทำงานสินไหม (Claim Domestic Accomodation)',
        //  'icon' => 'fa-home',
        //  'active' => true,
        //  'last_updated_by' => date('Y-m-d H:i:s'),
        //  'last_update_date' => date('Y-m-d H:i:s'),
        // 'last_updated_by' => -1,
         // 'created_by' => -1
        // ]);
        array_push($lists, [
         'name' => 'ค่าที่พักในต่างประเทศ (Oversea Accomodation)',
         'description' => 'ค่าที่พักในต่างประเทศ (Oversea Accomodation)',
         'icon' => 'fa-hotel',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าเบี้ยเลี้ยงต่างประเทศ (Overseas daily allowance)',
         'description' => 'ค่าเบี้ยเลี้ยงต่างประเทศ (Overseas daily allowance)',
         'icon' => 'fa-usd',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่ารับรองลูกค้าและคู่ค้า (Entertain expense)',
         'description' => 'ค่ารับรองลูกค้าและคู่ค้า (Entertain expense)',
         'icon' => 'fa-users',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าใช้จ่ายสนับสนุนกิจกรรมการตลาด (Marketing activity support expense)',
         'description' => 'ค่าใช้จ่ายสนับสนุนกิจกรรมการตลาด (Marketing activity support expense)',
         'icon' => 'fa-support',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าใข้จ่ายในการจัดกิจกรรมกระตุ้นยอดขาย (Campaign expense)',
         'description' => 'ค่าใข้จ่ายในการจัดกิจกรรมกระตุ้นยอดขาย (Campaign expense)',
         'icon' => 'fa-flag-o',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'เงินบริจาค (Donation expense)',
         'description' => 'เงินบริจาค (Donation expense)',
         'icon' => 'fa-smile-o',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'อบรมตัวแทน/คู่ค้า (Agent training expense)',
         'description' => 'อบรมตัวแทน/คู่ค้า (Agent training expense)',
         'icon' => 'fa-certificate',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าสมาชิกสมาคมต่าง ๆ (Membership fee)',
         'description' => 'ค่าสมาชิกสมาคมต่าง ๆ (Membership fee)',
         'icon' => 'fa-user',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าหนังสือ (Books and magazine expense)',
         'description' => 'ค่าหนังสือ (Books and magazine expense)',
         'icon' => 'fa-book',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าธรรมเนียมหน่วยงานราชการ/คปภ. (Government/Regulation fee)',
         'description' => 'ค่าธรรมเนียมหน่วยงานราชการ/คปภ. (Government/Regulation fee)',
         'icon' => 'fa-star',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'Visa for oversea businsess trip',
         'description' => 'Visa for oversea businsess trip',
         'icon' => 'fa-check-square-o',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'Visa & Work Permit expense',
         'description' => 'Visa & Work Permit expense',
         'icon' => 'fa-check-square-o',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าส่งเอกสาร (Postage & Courier expense)',
         'description' => 'ค่าส่งเอกสาร (Postage & Courier expense)',
         'icon' => 'fa-send-o',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าล้างรถ (Car wash expense)',
         'description' => 'ค่าล้างรถ (Car wash expense)',
         'icon' => 'fa-car',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าคัดสำเนาประจำวัน Cliam expense (Daily report copy fee)',
         'description' => 'ค่าคัดสำเนาประจำวัน Cliam expense (Daily report copy fee)',
         'icon' => 'fa-file-text',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าอากรแสตมป์ (Stamp duty expense)',
         'description' => 'ค่าอากรแสตมป์ (Stamp duty expense)',
         'icon' => 'fa-envelope',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าใช้จ่ายเกี่ยวกับสวัสดิการพนักงาน (Staff welfare related expenses)',
         'description' => 'ค่าใช้จ่ายเกี่ยวกับสวัสดิการพนักงาน (Staff welfare related expenses)',
         'icon' => 'fa-frown-o',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'เครื่องเขียน (Stationery)',
         'description' => 'เครื่องเขียน (Stationery)',
         'icon' => 'fa-pencil',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าใช้จ่ายในการอบรมพนักงาน (Staff training expense)',
         'description' => 'ค่าใช้จ่ายในการอบรมพนักงาน (Staff training expense)',
         'icon' => 'fa-user',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าซ่อมแซมบำรุง (Repair & maintenance expense)',
         'description' => 'ค่าซ่อมแซมบำรุง (Repair & maintenance expense)',
         'icon' => 'fa-wrench',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าใช้จ่ายเกี่ยวกับกิจกรรมพนักงาน (Staff activity expense)',
         'description' => 'ค่าใช้จ่ายเกี่ยวกับกิจกรรมพนักงาน (Staff activity expense)',
         'icon' => 'fa-comments-o',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าใช้จ่ายไปเที่ยวประจำปี (Excursion expenses)',
         'description' => 'ค่าใช้จ่ายไปเที่ยวประจำปี (Excursion expenses)',
         'icon' => 'fa-suitcase',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่าใช้จ่ายงานปีใหม่ (Staff party expense)',
         'description' => 'ค่าใช้จ่ายงานปีใหม่ (Staff party expense)',
         'icon' => 'fa-child',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'กิจกรรมชมรมฟุตบอล (TMFC expense)',
         'description' => 'กิจกรรมชมรมฟุตบอล (TMFC expense)',
         'icon' => 'fa-soccer-ball-o',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'ค่ายาสามัญ (Medical)',
         'description' => 'ค่ายาสามัญ (Medical)',
         'icon' => 'fa-medkit',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'WHT-Manual',
         'description' => 'WHT-Manual',
         'icon' => 'fa-file-text',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
        array_push($lists, [
         'name' => 'คืนเงิน 100% (Refund cash advance 100%)',
         'description' => 'คืนเงิน 100% (Refund cash advance 100%)',
         'icon' => 'fa-ban',
         'active' => true,
         'last_updated_by' => date('Y-m-d H:i:s'),
         'last_update_date' => date('Y-m-d H:i:s'),
         'last_updated_by' => -1,
         'created_by' => -1
     ]);
     //    array_push($lists, [
     //     'name' => config('services.category.advance_over_name'),
     //     'description' => config('services.category.advance_over_name'),
     //     'icon' => 'fa-bolt',
     //     'active' => true,
     //     'last_updated_by' => date('Y-m-d H:i:s'),
     //     'last_update_date' => date('Y-m-d H:i:s'),
     //     'last_updated_by' => -1,
     //     'created_by' => -1
     // ]);

        return $lists;
    }

}