<?php
namespace Database\Seeders\IE;

use Illuminate\Database\Seeder;

// use App\HrOperatingUnit;
use App\Models\IE\Category;
use App\Models\IE\SubCategory;
use App\Models\IE\Preference;

class PolicyTableSeeder extends Seeder
{
        /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {

            $policies = $this->policies();
            DB::table('xxweb_policies')->truncate();
            DB::table('xxweb_policies')->insert($policies);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    public function policies()
    {
        $lists = [];

        // $mileageUnit = MileageUnit::where('code','KM')->first();
        // $hrOperatingUnits = HrOperatingUnit::all();

        // foreach ($hrOperatingUnits as $key => $hou) {

            $baseMileageUnit = Preference::getBaseMileageUnit();

            $categories = Category::all();
            foreach ($categories as $key => $category) {

                $subCategories = SubCategory::where('category_id',$category->id)
                                    ->get();

                foreach ($subCategories as $key => $subCategory) {

                    switch ($category->name) {

                        case 'ค่าเดินทางในประเทศ (Domestic Business trip)':

                            if($subCategory->name == 'ค่าตั๋วเครื่องบินในประเทศ (Air fare)'){

                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'EXPENSE',
                                         'mileage_unit' => null,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);

                            }

                            if($subCategory->name == 'ค่ารถไฟในประเทศ (Train fare)'){

                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'EXPENSE',
                                         'mileage_unit' => null,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);

                            }

                            if($subCategory->name == 'ค่ารถทัวร์ในประเทศ (Bus fare)'){

                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'EXPENSE',
                                         'mileage_unit' => null,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);

                            }

                            if($subCategory->name == 'รถยนต์ส่วนตัว (Personal car)'){

                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'MILEAGE',
                                         'mileage_unit' => $baseMileageUnit,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);

                            }

                            if($subCategory->name == 'ค่าจอดรถ (Parking fee)'){



                            }

                            if($subCategory->name == 'ค่าเดินทางประเภทอื่น (Other travelling)'){




                            }

                            if($subCategory->name == 'ค่าทางด่วนในประเทศ (Express way)'){




                            }

                            if($subCategory->name == 'ค่าเช่ารถในประเทศ (Car rental)'){




                            }

                            if($subCategory->name == 'ค่าน้ำมันสำหรับรถเช่าในประเทศ (Gasoline fee for car rental)'){




                            }

                            break;

                        case 'ค่าเดินทางในประเทศเพื่อไปทำงานสินไหม (Claim Domestic Business trip)':


                            if($subCategory->name == 'ค่าตั๋วเครื่องบินในประเทศ (Air fare)'){

                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'EXPENSE',
                                         'mileage_unit' => null,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);

                            }

                            if($subCategory->name == 'ค่ารถไฟในประเทศ (Train fare)'){

                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'EXPENSE',
                                         'mileage_unit' => null,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);

                            }

                            if($subCategory->name == 'ค่ารถทัวร์ในประเทศ (Bus fare)'){

                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'EXPENSE',
                                         'mileage_unit' => null,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);

                            }

                            if($subCategory->name == 'รถยนต์ส่วนตัว (Personal car)'){

                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'MILEAGE',
                                         'mileage_unit' => $baseMileageUnit,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);

                            }

                            if($subCategory->name == 'ค่าจอดรถ (Parking fee)'){



                            }

                            if($subCategory->name == 'ค่าเดินทางประเภทอื่น (Other travelling)'){



                            }

                            if($subCategory->name == 'ค่าทางด่วนในประเทศ (Express way)'){



                            }

                            if($subCategory->name == 'ค่าเช่ารถในประเทศ (Car rental)'){



                            }

                            if($subCategory->name == 'ค่าน้ำมันสำหรับรถเช่าในประเทศ (Gasoline fee for car rental)'){



                            }

                            break;

                        case 'ค่าเดินทางต่างประเทศ (Overseas Business trip)':

                            if($subCategory->name == 'ค่าตั๋วเครื่องบินต่างประเทศ (Air fare)'){



                            }

                            if($subCategory->name == 'ค่าจอดรถ (Parking fee)'){


                            }

                            if($subCategory->name == 'ค่าเดินทางประเภทอื่นๆ (Other travelling)'){



                            }

                            if($subCategory->name == 'ค่าเช่ารถในต่างประเทศ (Car rental)'){



                            }

                            if($subCategory->name == 'ค่าน้ำมันสำหรับรถเช่าในต่างประเทศ (Gasoline fee for car rental)'){



                            }

                            if($subCategory->name == 'ค่าประกันการเดินทางต่างประเทศ (Travel Insurance)'){



                            }

                            break;

                        case 'ค่าที่พักในประเทศ (Domestic Accomodation)':

                            if($subCategory->name == 'ค่าที่พักรายวัน (Daily Accomodation)'){
                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'EXPENSE',
                                         'mileage_unit' => null,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);
                            }

                            if($subCategory->name == 'ค่าที่พักรายเดือน (Monthly accomodation)'){
                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'EXPENSE',
                                         'mileage_unit' => null,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);
                            }

                            break;

                        case 'ค่าที่พักในประเทศเพื่อไปทำงานสินไหม (Claim Domestic Accomodation)':

                            if($subCategory->name == 'ค่าที่พักรายวัน (Daily Accomodation)'){
                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'EXPENSE',
                                         'mileage_unit' => null,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);
                            }

                            if($subCategory->name == 'ค่าที่พักรายเดือน (Monthly accomodation)'){
                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'EXPENSE',
                                         'mileage_unit' => null,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);
                            }

                            break;

                        case 'ค่าที่พักในต่างประเทศ (Oversea Accomodation)':

                            if($subCategory->name == 'ค่าโรงแรมในต่างประเทศ (Oversea hotel fee)'){
                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'EXPENSE',
                                         'mileage_unit' => null,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);
                            }

                            break;

                        case 'ค่าเบี้ยเลี้ยงต่างประเทศ (Overseas daily allowance)':

                            if($subCategory->name == 'ค่าเบี้ยเลี้ยงต่างประเทศ (Overseas daily allowance)'){
                                array_push($lists, [
                                         'category_id' => $category->id,
                                         'sub_category_id' => $subCategory->id,
                                         'type' => 'EXPENSE',
                                         'mileage_unit' => null,
                                         'active' => true,
                                         'created_at' => date('Y-m-d H:i:s'),
                                         'updated_at' => date('Y-m-d H:i:s')]);
                            }

                            break;

                        case 'ค่ารับรองลูกค้าและคู่ค้า (Entertain expense)':

                            if($subCategory->name == 'ค่าอาหารและเครื่องดื่ม (Food & Beverage)'){


                            }

                            if($subCategory->name == 'ของขวัญ ดอกไม้ และกระเช้า (Gift & Flower)'){


                            }

                            if($subCategory->name == "เงินสนับสนุนกิจกรรมคู่ค้า (Cash for support activity's busniess partner)"){

                            }

                            if($subCategory->name == 'สันทนาการ-กอล์ฟ/กีฬา (Sport,Golf,Others)'){


                            }

                            if($subCategory->name == 'ค่าที่พักลูกค้า/คู่ค้า (Hotel fee for client & business partner)'){


                            }

                            break;

                        case 'ค่าใช้จ่ายสนับสนุนกิจกรรมการตลาด (Marketing activity support expense)':

                            if($subCategory->name == 'ค่าใช้จ่ายในการจัดกิจกรรมส่งเสริมการขาย (Expense to support sale promotion activity)'){


                            }

                            if($subCategory->name == 'ค่าจัดทำป้ายมอบค่าสินไหม (Claim compensation billboard)'){


                            }

                            break;

                        case 'ค่าใข้จ่ายในการจัดกิจกรรมกระตุ้นยอดขาย (Campaign expense)':

                            if($subCategory->name == 'Gift voucher,Cash,Electrical equipment'){



                            }

                            break;

                        case 'เงินบริจาค (Donation expense)':

                            if($subCategory->name == 'เงินบริจาค (Donation expense)'){

                            }

                            break;

                        case 'อบรมตัวแทน/คู่ค้า (Agent training expense)':

                            if($subCategory->name == 'ค่าสถานที่จัดอบรม (Hotel fee for training)'){



                            }

                            if($subCategory->name == 'ค่าวิทยากร (Instructor fee)'){




                            }

                            if($subCategory->name == 'ค่าวัสดุ อุปรกณ์อบรม (Material expense)'){



                            }

                            if($subCategory->name == 'ค่าอาหาร (Food & beverage for training)'){



                            }

                            if($subCategory->name == 'ค่าธรรมเนียมสอบใบอนุญาติตัวแทน (Agent license examination fee)'){




                            }

                            break;

                        case 'ค่าสมาชิกสมาคมต่าง ๆ (Membership fee)':

                            if($subCategory->name == 'ค่าสมาชิกสมาคมต่าง ๆ (Membership fee)'){



                            }

                            break;

                        case 'ค่าหนังสือ (Books and magazine expense)':

                            if($subCategory->name == 'ค่าหนังสือ (Books and magazine expense)'){


                            }

                            break;

                        case 'ค่าธรรมเนียมหน่วยงานราชการ/คปภ. (Government/Regulation fee)':

                            if($subCategory->name == 'ค่าธรรมเนียมหน่วยงานราชการ (Government fee)'){


                            }

                            if($subCategory->name == 'ค่าธรรมเนียมขออนุมัติผลิตภัณฑ์ใหม่ (OIC product approval fee)'){


                            }

                            break;

                        case 'Visa for oversea businsess trip':

                            if($subCategory->name == 'Visa fee for business trip'){

                            }

                            break;

                        case 'Visa & Work Permit expense':

                            if($subCategory->name == 'Visa & Work Permit expense'){

                            }

                            break;

                        case 'ค่าส่งเอกสาร (Postage & Courier expense)':

                            if($subCategory->name == 'ค่าไปรษณีย์ รถตู้ รถทัวร์ (Courier expense)'){



                            }

                            break;

                        case 'ค่าล้างรถ (Car wash expense)':

                            if($subCategory->name == 'ค่าล้างรถ (Car wash expense)'){


                            }

                            break;

                        case 'ค่าคัดสำเนาประจำวัน Cliam expense (Daily report copy fee)':

                            if($subCategory->name == 'ค่าคัดสำเนาประจำวัน - Cliam expense (Daily report copy fee)'){

                            }

                            break;

                        case 'ค่าอากรแสตมป์ (Stamp duty expense)':

                            if($subCategory->name == 'ค่าอากรแสตมป์ (Stamp duty expense)'){

                            }

                            break;

                        case 'ค่าใช้จ่ายเกี่ยวกับสวัสดิการพนักงาน (Staff welfare related expenses)':

                            if($subCategory->name == "พวงหรีดงานศพ ครอบครัวพนักงาน (Funeral wreath,cash for staff's family)"){

                            }

                            break;

                        case 'เครื่องเขียน (Stationery)':

                            if($subCategory->name == 'เครื่องเขียน (Stationery)'){

                            }

                            break;

                        case 'ค่าใช้จ่ายในการอบรมพนักงาน (Staff training expense)':

                            if($subCategory->name == 'ค่าอาหารและของที่ระลึกวิทยากร (Food & Gift for instructor)'){

                            }

                            if($subCategory->name == 'ค่าอบรม (Instructor fee)'){

                            }

                            if($subCategory->name == 'ค่าวัสดุ อุปรกณ์อบรม (Material expense)'){

                            }

                            break;

                        case 'ค่าซ่อมแซมบำรุง (Repair & maintenance expense)':

                            if($subCategory->name == 'ค่าซ่อมแซมบำรุง (Repair & maintenance expense)'){

                            }

                            break;


                        case 'ค่าใช้จ่ายเกี่ยวกับกิจกรรมพนักงาน (Staff activity expense)':

                            if($subCategory->name == 'ค่าใช้จ่ายเกี่ยวกับกิจกรรมพนักงาน (Staff activity expense)'){


                            }

                            break;


                        case 'ค่าใช้จ่ายไปเที่ยวประจำปี (Excursion expenses)':

                            if($subCategory->name == 'Excursion - ค่าที่พัก (Accomodation fee for excursion)'){

                                //

                            }

                            if($subCategory->name == 'Excursion - ค่าอาหาร,เครื่องดื่ม,ของว่าง (Food & beverage forexcursion)'){

                                //

                            }

                            if($subCategory->name == 'Excursion - ค่าใช้จ่ายการแสดง (Admission fare to the show)'){

                                //

                            }

                            if($subCategory->name == 'Excursion - ค่าเช่ารถ (Car rental for excursion)'){

                                //

                            }

                            if($subCategory->name == 'Excursion - ค่าทางด่วน (express way fee for excursion)'){

                                //

                            }

                            if($subCategory->name == 'Excursion - ค่าเช่าเครื่องเสียงและดนตรี (Music expense for excursion)'){

                                //

                            }

                            if($subCategory->name == 'Excursion - ค่าใช้จ่ายจัดกิจกรรมต่าง ๆ เช่น เกมส์ (Recreation expense)'){

                                //

                            }

                            break;

                        case 'ค่าใช้จ่ายงานปีใหม่ (Staff party expense)':

                            if($subCategory->name == 'Staff party expense - ค่าเช่าสถานที่ (Place fee)'){



                            }

                            if($subCategory->name == 'Staff party expense - ค่าอาหาร (Food & beverage expense)'){



                            }

                            if($subCategory->name == 'Staff party expense - ค่าซุ้มเกมส์, Lucky draw, อื่น ๆ (Recreation expense,games,etc.)'){



                            }

                            break;

                        case 'กิจกรรมชมรมฟุตบอล (TMFC expense)':

                            if($subCategory->name == 'TMFC expense - ค่าเช่าสนาม (Field expense)'){



                            }

                            if($subCategory->name == 'TMFC expense - ค่าอาหารและเครื่องดื่ม (Food & Beverage expense)'){

                            }

                            if($subCategory->name == 'ค่ายา,ค่าชุดและอุปกรณ์ในการฝึกซ้อม (Medicine, sport ware and equipment expense)'){

                            }

                            if($subCategory->name == 'ค่าผู้ฝึกสอน (Coach fee)'){
                            }

                            break;

                        case 'ค่ายาสามัญ (Medical)':

                            if($subCategory->name == 'ค่ายาสามัญ (Medical)'){

                                //

                            }

                            break;

                        case 'WHT-Manual':

                            if($subCategory->name == 'WHT-Manual'){




                            }

                            break;

                        case 'คืนเงิน 100% (Refund cash advance 100%)':

                            if($subCategory->name == 'คืนเงิน 100% (Refund cash advance 100%)'){


                            }

                            break;

                        default:
                            # code...
                            break;
                    }

                }

            }
        // }

        return $lists;
    }
}