<?php

namespace Database\Seeders\IE;

use Illuminate\Database\Seeder;
use DB;

use App\Models\IE\Category;
class SubCategoryTableSeeder extends Seeder
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

            $subCategories = $this->subCategories();
            DB::connection('oracle_oaie')->table('ptw_sub_categories')->truncate();
            DB::connection('oracle_oaie')->table('ptw_sub_categories')->insert($subCategories);

            $dbSubCategories = DB::connection('oracle_oaie')->table('ptw_sub_categories')->get();
            foreach ($dbSubCategories as $key => $dbSubCategory) {
                # code...
                DB::connection('oracle_oaie')->table('ptw_accessible_orgs')->insert(
                    [
                        'accessible_orgable_id' => $dbSubCategory->sub_category_id,
                        'accessible_orgable_type' => 'App\Models\IE\SubCategory',
                        'creation_date' => date('Y-m-d H:i:s'),
                        'last_update_date' => date('Y-m-d H:i:s'),
                        'last_updated_by' => -1,
                        'created_by' => -1,
                        'org_id' => '81'
                    ]
                );
            }

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    public function subCategories()
    {
        $lists = [];
        // $hrOperatingUnits = HrOperatingUnit::all();
        $defaultSubAccountCode = '000';
        $defaultRechargeAccountCode = '19341';
        $defaultRechargeSubAccountCode = '000';
        $defaultBranchCode = null;
        $defaultDepartmentCode = null;
        $categoryAdvanceOverName = config('services.category.advance_over_name');
        // foreach ($hrOperatingUnits as $key => $hou) {
            $categories = Category::all();
            foreach ($categories as $key => $category) {

                switch ($category->name) {

                    case 'ค่าเดินทางในประเทศ (Domestic Business trip)':

                        $subCategoryName = 'ค่าตั๋วเครื่องบินในประเทศ (Air fare)';
                        $accountCode = '76105';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'เที่ยว',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่ารถไฟในประเทศ (Train fare)';
                        $accountCode = '76105';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'เที่ยว',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่ารถทัวร์ในประเทศ (Bus fare)';
                        $accountCode = '76105';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'เที่ยว',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'รถยนต์ส่วนตัว (Personal car)';
                        $accountCode = '76105';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'เที่ยว',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าจอดรถ (Parking fee)';
                        $accountCode = '76105';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าโดยสารสาธารณะ (Public Transportation)';
                        $accountCode = '76105';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าทางด่วนในประเทศ (Express way)';
                        $accountCode = '76105';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าเช่ารถในประเทศ (Car rental)';
                        $accountCode = '72107';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT-ND',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าน้ำมันสำหรับรถเช่าในประเทศ (Gasoline fee for car rental)';
                        $accountCode = '72109';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT-ND',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าเดินทางในประเทศเพื่อไปทำงานสินไหม (Claim Domestic Business trip)':

                        $subCategoryName = 'ค่าตั๋วเครื่องบินในประเทศ (Air fare)';
                        $accountCode = '52102';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'เที่ยว',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่ารถไฟในประเทศ (Train fare)';
                        $accountCode = '52102';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'เที่ยว',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่ารถทัวร์ในประเทศ (Bus fare)';
                        $accountCode = '52102';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'เที่ยว',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'รถยนต์ส่วนตัว (Personal car)';
                        $accountCode = '52102';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'เที่ยว',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าจอดรถ (Parking fee)';
                        $accountCode = '52102';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าโดยสารสาธารณะ (Public Transportation)';
                        $accountCode = '52102';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าทางด่วนในประเทศ (Express way)';
                        $accountCode = '52102';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าเช่ารถในประเทศ (Car rental)';
                        $accountCode = '72107';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT-ND',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าน้ำมันสำหรับรถเช่าในประเทศ (Gasoline fee for car rental)';
                        $accountCode = '72109';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT-ND',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าเดินทางต่างประเทศ (Overseas Business trip)':

                        $subCategoryName = 'ค่าตั๋วเครื่องบินต่างประเทศ (Air fare)';
                        $accountCode = '76106';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'เที่ยว',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าจอดรถ (Parking fee)';
                        $accountCode = '76106';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าโดยสารสาธารณะ (Public Transportation)';
                        $accountCode = '76106';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าเช่ารถในต่างประเทศ (Car rental)';
                        $accountCode = '76106';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าน้ำมันสำหรับรถเช่าในต่างประเทศ (Gasoline fee for car rental)';
                        $accountCode = '76106';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าประกันการเดินทางต่างประเทศ (Travel Insurance)';
                        $accountCode = '76106';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าที่พักในประเทศ (Domestic Accomodation)':

                        $subCategoryName = 'ค่าที่พักรายวัน (Daily Accomodation)';
                        $accountCode = '76105';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => true,
                                     'unit' => 'ห้อง',
                                     'second_unit' => 'คืน',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าที่พักรายเดือน (Monthly accomodation)';
                        $accountCode = '76105';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => true,
                                     'unit' => 'ห้อง',
                                     'second_unit' => 'เดือน',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าที่พักในประเทศเพื่อไปทำงานสินไหม (Claim Domestic Accomodation)':

                        $subCategoryName = 'ค่าที่พักรายวัน (Daily Accomodation)';
                        $accountCode = '52102';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => true,
                                     'unit' => 'ห้อง',
                                     'second_unit' => 'คืน',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าที่พักรายเดือน (Monthly accomodation)';
                        $accountCode = '52102';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => true,
                                     'unit' => 'ห้อง',
                                     'second_unit' => 'เดือน',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);
                        break;

                    case 'ค่าที่พักในต่างประเทศ (Oversea Accomodation)':

                        $subCategoryName = 'ค่าโรงแรมในต่างประเทศ (Oversea hotel fee)';
                        $accountCode = '76106';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => true,
                                     'unit' => 'ห้อง',
                                     'second_unit' => 'คืน',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าเบี้ยเลี้ยงต่างประเทศ (Overseas daily allowance)':

                        $subCategoryName = 'ค่าเบี้ยเลี้ยงต่างประเทศ (Overseas daily allowance)';
                        $accountCode = '76106';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => false,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่ารับรองลูกค้าและคู่ค้า (Entertain expense)':

                        $subCategoryName = 'ค่าอาหารและเครื่องดื่ม (Food & Beverage)';
                        $accountCode = '76107';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT-ND',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ของขวัญ ดอกไม้ และกระเช้า (Gift & Flower)';
                        $accountCode = '76107';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT-ND',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = "เงินสนับสนุนกิจกรรมคู่ค้า (Cash for support activity's busniess partner)";
                        $accountCode = '76107';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT-ND',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'สันทนาการ-กอล์ฟ/กีฬา (Sport,Golf,Others)';
                        $accountCode = '76107';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT-ND',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าที่พักลูกค้า/คู่ค้า (Hotel fee for client & business partner)';
                        $accountCode = '76107';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT-ND',
                                     'use_second_unit' => true,
                                     'unit' => 'ห้อง',
                                     'second_unit' => 'คืน',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าใช้จ่ายสนับสนุนกิจกรรมการตลาด (Marketing activity support expense)':

                        $subCategoryName = 'ค่าใช้จ่ายในการจัดกิจกรรมส่งเสริมการขาย (Expense to support sale promotion activity)';
                        $accountCode = '76108';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าจัดทำป้ายมอบค่าสินไหม (Claim compensation billboard)';
                        $accountCode = '76108';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าใข้จ่ายในการจัดกิจกรรมกระตุ้นยอดขาย (Campaign expense)':

                        $subCategoryName = 'Gift voucher,Cash,Electrical equipment';
                        $accountCode = '76109';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'เงินบริจาค (Donation expense)':

                        $subCategoryName = 'เงินบริจาค (Donation expense)';
                        $accountCode = '76104';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'อบรมตัวแทน/คู่ค้า (Agent training expense)':

                        $subCategoryName = 'ค่าสถานที่จัดอบรม (Hotel fee for training)';
                        $accountCode = '76110';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าวิทยากร (Instructor fee)';
                        $accountCode = '76110';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าวัสดุ อุปรกณ์อบรม (Material expense)';
                        $accountCode = '76110';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าอาหาร (Food & beverage for training)';
                        $accountCode = '76110';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าธรรมเนียมสอบใบอนุญาติตัวแทน (Agent license examination fee)';
                        $accountCode = '76110';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าสมาชิกสมาคมต่าง ๆ (Membership fee)':

                        $subCategoryName = 'ค่าสมาชิกสมาคมต่าง ๆ (Membership fee)';
                        $accountCode = '76119';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าหนังสือ (Books and magazine expense)':

                        $subCategoryName = 'ค่าหนังสือ (Books and magazine expense)';
                        $accountCode = '76118';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าธรรมเนียมหน่วยงานราชการ/คปภ. (Government/Regulation fee)':

                        $subCategoryName = 'ค่าธรรมเนียมหน่วยงานราชการ (Government fee)';
                        $accountCode = '76123';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าธรรมเนียมขออนุมัติผลิตภัณฑ์ใหม่ (OIC product approval fee)';
                        $accountCode = '76123';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'Visa for oversea businsess trip':

                        $subCategoryName = 'Visa fee for business trip';
                        $accountCode = '76106';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'Visa & Work Permit expense':

                        $subCategoryName = 'Visa & Work Permit expense';
                        $accountCode = '71118';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => 'SM',
                                     'department_code' => '053',
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าส่งเอกสาร (Postage & Courier expense)':

                        $subCategoryName = 'ค่าไปรษณีย์ รถตู้ รถทัวร์ (Courier expense)';
                        $accountCode = '76116';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าล้างรถ (Car wash expense)':

                        $subCategoryName = 'ค่าล้างรถ (Car wash expense)';
                        $accountCode = '72111';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าคัดสำเนาประจำวัน Cliam expense (Daily report copy fee)':

                        $subCategoryName = 'ค่าคัดสำเนาประจำวัน - Cliam expense (Daily report copy fee)';
                        $accountCode = '52102';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าอากรแสตมป์ (Stamp duty expense)':

                        $subCategoryName = 'ค่าอากรแสตมป์ (Stamp duty expense)';
                        $accountCode = '73102';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าใช้จ่ายเกี่ยวกับสวัสดิการพนักงาน (Staff welfare related expenses)':

                        $subCategoryName = "พวงหรีดงานศพ ครอบครัวพนักงาน (Funeral wreath,cash for staff's family)";
                        $accountCode = '71112';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => 'SM',
                                     'department_code' => '053',
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'เครื่องเขียน (Stationery)':

                        $subCategoryName = 'เครื่องเขียน (Stationery)';
                        $accountCode = '72125';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าใช้จ่ายในการอบรมพนักงาน (Staff training expense)':

                        $subCategoryName = 'ค่าอาหารและของที่ระลึกวิทยากร (Food & Gift for instructor)';
                        $accountCode = '71115';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าอบรม (Instructor fee)';
                        $accountCode = '71115';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                        $subCategoryName = 'ค่าวัสดุ อุปรกณ์อบรม (Material expense)';
                        $accountCode = '71115';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าซ่อมแซมบำรุง (Repair & maintenance expense)':

                        $subCategoryName = 'ค่าซ่อมแซมบำรุง (Repair & maintenance expense)';
                        $accountCode = '72120';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าใช้จ่ายเกี่ยวกับกิจกรรมพนักงาน (Staff activity expense)':

                        $subCategoryName = 'ค่าใช้จ่ายเกี่ยวกับกิจกรรมพนักงาน (Staff activity expense)';
                        $accountCode = '71118';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าใช้จ่ายไปเที่ยวประจำปี (Excursion expenses)':

                        $subCategoryName = 'Excursion - ค่าที่พัก (Accomodation fee for excursion)';
                        $accountCode = '71112';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => true,
                                     'unit' => 'ห้อง',
                                     'second_unit' => 'คืน',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Excursion - ค่าอาหาร,เครื่องดื่ม,ของว่าง (Food & beverage forexcursion)';
                        $accountCode = '71112';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => true,
                                     'unit' => 'ห้อง',
                                     'second_unit' => 'คืน',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Excursion - ค่าใช้จ่ายการแสดง (Admission fare to the show)';
                        $accountCode = '71112';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => true,
                                     'unit' => 'ห้อง',
                                     'second_unit' => 'คืน',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Excursion - ค่าเช่ารถ (Car rental for excursion)';
                        $accountCode = '71112';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => true,
                                     'unit' => 'ห้อง',
                                     'second_unit' => 'คืน',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Excursion - ค่าทางด่วน (express way fee for excursion)';
                        $accountCode = '71112';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => true,
                                     'unit' => 'ห้อง',
                                     'second_unit' => 'คืน',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Excursion - ค่าเช่าเครื่องเสียงและดนตรี (Music expense for excursion)';
                        $accountCode = '71112';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => true,
                                     'unit' => 'ห้อง',
                                     'second_unit' => 'คืน',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Excursion - ค่าใช้จ่ายจัดกิจกรรมต่าง ๆ เช่น เกมส์ (Recreation expense)';
                        $accountCode = '71112';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => true,
                                     'unit' => 'ห้อง',
                                     'second_unit' => 'คืน',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่าใช้จ่ายงานปีใหม่ (Staff party expense)':

                        $subCategoryName = 'Staff party expense - ค่าเช่าสถานที่ (Place fee)';
                        $accountCode = '71112';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Staff party expense - ค่าอาหาร (Food & beverage expense)';
                        $accountCode = '71112';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Staff party expense - ค่าซุ้มเกมส์, Lucky draw, อื่น ๆ (Recreation expense,games,etc.)';
                        $accountCode = '71112';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'กิจกรรมชมรมฟุตบอล (TMFC expense)':

                        $subCategoryName = 'TMFC expense - ค่าเช่าสนาม (Field expense)';
                        $accountCode = '71118';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => 'SM',
                                     'department_code' => '053',
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'TMFC expense - ค่าอาหารและเครื่องดื่ม (Food & Beverage expense)';
                        $accountCode = '71118';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => 'SM',
                                     'department_code' => '053',
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่ายา,ค่าชุดและอุปกรณ์ในการฝึกซ้อม (Medicine, sport ware and equipment expense)';
                        $accountCode = '71118';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => 'SM',
                                     'department_code' => '053',
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'ค่าผู้ฝึกสอน (Coach fee)';
                        $accountCode = '71118';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => 'SM',
                                     'department_code' => '053',
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'ค่ายาสามัญ (Medical)':

                        $subCategoryName = 'ค่ายาสามัญ (Medical)';
                        $accountCode = '71114';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => 'INPUT',
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'WHT-Manual':

                        $subCategoryName = 'WHT-Manual';
                        $accountCode = '19341';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     // 'branch_code' => $defaultBranchCode,
                                     'branch_code' => 'SM',
                                     'department_code' => '000',
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case 'คืนเงิน 100% (Refund cash advance 100%)':

                        $subCategoryName = 'คืนเงิน 100% (Refund cash advance 100%)';
                        $accountCode = '19341';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => 'SM',
                                     'department_code' => '000',
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case $categoryAdvanceOverName:

                        $subCategoryName = config('services.sub_category.advance_over_name');
                        $accountCode = '19341';
                        // self::validateAccountCode(81,$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'category_id' => $category->category_id,
                                     'name' => $subCategoryName,
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'recharge_account_code' => $defaultRechargeAccountCode,
                                     'recharge_sub_account_code' => $defaultRechargeSubAccountCode,
                                     'branch_code' => 'SM',
                                     'department_code' => '000',
                                     'vat_id' => null,
                                     'use_second_unit' => false,
                                     'unit' => 'รายการ',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                    default:
                        # code...
                        break;
                }

            }
        // }

        return $lists;
    }

    // private static function validateAccountCode($orgId,$accountCode,$subAccountCode,$categoryName,$subCategoryName)
    // {
    //  $valid = true; $errMsg = '';

    //  $fndAccountCode = FNDListOfValues::account($orgId)
    //                          ->whereFlexValue($accountCode)
    //                          ->first();
    //  $fndSubAccountCode = FNDListOfValues::subAccount($orgId)
    //                          ->byParentValue('TMITH_GL_ACCOUNT',$accountCode)
    //                          ->whereFlexValue($subAccountCode)
    //                          ->first();

    //  if(!$fndAccountCode){
    //      $valid = false; 
    //      $errMsg = 'Not found TMITH_GL_ACCOUNT = '.$accountCode;
    //  }else{
    //      if(!$fndSubAccountCode){
       //       $valid = false; 
       //       $errMsg = 'Not found TMITH_GL_SUB_ACCOUNT = '.$subAccountCode.' (TMITH_GL_ACCOUNT='.$accountCode.') ';
       //   }
    //  }

    //  if(!$valid){
    //      throw new \Exception('INTERFACE ERROR : Category = '.$categoryName.' | Sub-Category = '.$subCategoryName.' | '.$errMsg, 1);
    //  }
    // }
}