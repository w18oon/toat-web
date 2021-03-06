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

                    case '?????????????????????????????????????????????????????? (Domestic Business trip)':

                        $subCategoryName = '??????????????????????????????????????????????????????????????????????????? (Air fare)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '????????????????????????????????????????????? (Train fare)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '?????????????????????????????????????????????????????? (Bus fare)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '??????????????????????????????????????? (Personal car)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '???????????????????????? (Parking fee)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '???????????????????????????????????????????????? (Public Transportation)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '?????????????????????????????????????????????????????? (Express way)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '??????????????????????????????????????????????????? (Car rental)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '??????????????????????????????????????????????????????????????????????????????????????? (Gasoline fee for car rental)';
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
                                     'unit' => '??????????????????',
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

                    case '???????????????????????????????????????????????????????????????????????????????????????????????????????????? (Claim Domestic Business trip)':

                        $subCategoryName = '??????????????????????????????????????????????????????????????????????????? (Air fare)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '????????????????????????????????????????????? (Train fare)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '?????????????????????????????????????????????????????? (Bus fare)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '??????????????????????????????????????? (Personal car)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '???????????????????????? (Parking fee)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '???????????????????????????????????????????????? (Public Transportation)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '?????????????????????????????????????????????????????? (Express way)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '??????????????????????????????????????????????????? (Car rental)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '??????????????????????????????????????????????????????????????????????????????????????? (Gasoline fee for car rental)';
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
                                     'unit' => '??????????????????',
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

                    case '???????????????????????????????????????????????????????????? (Overseas Business trip)':

                        $subCategoryName = '????????????????????????????????????????????????????????????????????????????????? (Air fare)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '???????????????????????? (Parking fee)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '???????????????????????????????????????????????? (Public Transportation)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '??????????????????????????????????????????????????????????????? (Car rental)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '??????????????????????????????????????????????????????????????????????????????????????????????????? (Gasoline fee for car rental)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '??????????????????????????????????????????????????????????????????????????????????????? (Travel Insurance)';
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
                                     'unit' => '??????????????????',
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

                    case '??????????????????????????????????????????????????? (Domestic Accomodation)':

                        $subCategoryName = '????????????????????????????????????????????? (Daily Accomodation)';
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
                                     'unit' => '????????????',
                                     'second_unit' => '?????????',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '??????????????????????????????????????????????????? (Monthly accomodation)';
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
                                     'unit' => '????????????',
                                     'second_unit' => '???????????????',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case '????????????????????????????????????????????????????????????????????????????????????????????????????????? (Claim Domestic Accomodation)':

                        $subCategoryName = '????????????????????????????????????????????? (Daily Accomodation)';
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
                                     'unit' => '????????????',
                                     'second_unit' => '?????????',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '??????????????????????????????????????????????????? (Monthly accomodation)';
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
                                     'unit' => '????????????',
                                     'second_unit' => '???????????????',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);
                        break;

                    case '??????????????????????????????????????????????????????????????? (Oversea Accomodation)':

                        $subCategoryName = '??????????????????????????????????????????????????????????????? (Oversea hotel fee)';
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
                                     'unit' => '????????????',
                                     'second_unit' => '?????????',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case '???????????????????????????????????????????????????????????????????????? (Overseas daily allowance)':

                        $subCategoryName = '???????????????????????????????????????????????????????????????????????? (Overseas daily allowance)';
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
                                     'unit' => '??????????????????',
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

                    case '???????????????????????????????????????????????????????????????????????? (Entertain expense)':

                        $subCategoryName = '?????????????????????????????????????????????????????????????????? (Food & Beverage)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '????????????????????? ?????????????????? ?????????????????????????????? (Gift & Flower)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = "??????????????????????????????????????????????????????????????????????????? (Cash for support activity's busniess partner)";
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '???????????????????????????-???????????????/???????????? (Sport,Golf,Others)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '?????????????????????????????????????????????/?????????????????? (Hotel fee for client & business partner)';
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
                                     'unit' => '????????????',
                                     'second_unit' => '?????????',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case '???????????????????????????????????????????????????????????????????????????????????????????????? (Marketing activity support expense)':

                        $subCategoryName = '????????????????????????????????????????????????????????????????????????????????????????????????????????????????????? (Expense to support sale promotion activity)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '???????????????????????????????????????????????????????????????????????? (Claim compensation billboard)';
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
                                     'unit' => '??????????????????',
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

                    case '?????????????????????????????????????????????????????????????????????????????????????????????????????????????????? (Campaign expense)':

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
                                     'unit' => '??????????????????',
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

                    case '?????????????????????????????? (Donation expense)':

                        $subCategoryName = '?????????????????????????????? (Donation expense)';
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
                                     'unit' => '??????????????????',
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

                    case '??????????????????????????????/?????????????????? (Agent training expense)':

                        $subCategoryName = '??????????????????????????????????????????????????? (Hotel fee for training)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '?????????????????????????????? (Instructor fee)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '???????????????????????? ????????????????????????????????? (Material expense)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '???????????????????????? (Food & beverage for training)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '?????????????????????????????????????????????????????????????????????????????????????????? (Agent license examination fee)';
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
                                     'unit' => '??????????????????',
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

                    case '?????????????????????????????????????????????????????? ??? (Membership fee)':

                        $subCategoryName = '?????????????????????????????????????????????????????? ??? (Membership fee)';
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
                                     'unit' => '??????????????????',
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

                    case '?????????????????????????????? (Books and magazine expense)':

                        $subCategoryName = '?????????????????????????????? (Books and magazine expense)';
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
                                     'unit' => '??????????????????',
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

                    case '??????????????????????????????????????????????????????????????????????????????/?????????. (Government/Regulation fee)':

                        $subCategoryName = '?????????????????????????????????????????????????????????????????????????????? (Government fee)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '?????????????????????????????????????????????????????????????????????????????????????????????????????? (OIC product approval fee)';
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
                                     'unit' => '??????????????????',
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
                                     'unit' => '??????????????????',
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
                                     'unit' => '??????????????????',
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

                    case '???????????????????????????????????? (Postage & Courier expense)':

                        $subCategoryName = '????????????????????????????????? ??????????????? ????????????????????? (Courier expense)';
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
                                     'unit' => '??????????????????',
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

                    case '??????????????????????????? (Car wash expense)':

                        $subCategoryName = '??????????????????????????? (Car wash expense)';
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
                                     'unit' => '??????????????????',
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

                    case '????????????????????????????????????????????????????????? Cliam expense (Daily report copy fee)':

                        $subCategoryName = '????????????????????????????????????????????????????????? - Cliam expense (Daily report copy fee)';
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
                                     'unit' => '??????????????????',
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

                    case '??????????????????????????????????????? (Stamp duty expense)':

                        $subCategoryName = '??????????????????????????????????????? (Stamp duty expense)';
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
                                     'unit' => '??????????????????',
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

                    case '????????????????????????????????????????????????????????????????????????????????????????????????????????? (Staff welfare related expenses)':

                        $subCategoryName = "???????????????????????????????????? ????????????????????????????????????????????? (Funeral wreath,cash for staff's family)";
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
                                     'unit' => '??????????????????',
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

                    case '???????????????????????????????????? (Stationery)':

                        $subCategoryName = '???????????????????????????????????? (Stationery)';
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
                                     'unit' => '??????????????????',
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

                    case '?????????????????????????????????????????????????????????????????????????????? (Staff training expense)':

                        $subCategoryName = '??????????????????????????????????????????????????????????????????????????????????????? (Food & Gift for instructor)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '????????????????????? (Instructor fee)';
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
                                     'unit' => '??????????????????',
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

                        $subCategoryName = '???????????????????????? ????????????????????????????????? (Material expense)';
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
                                     'unit' => '??????????????????',
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

                    case '????????????????????????????????????????????? (Repair & maintenance expense)':

                        $subCategoryName = '????????????????????????????????????????????? (Repair & maintenance expense)';
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
                                     'unit' => '??????????????????',
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

                    case '??????????????????????????????????????????????????????????????????????????????????????????????????? (Staff activity expense)':

                        $subCategoryName = '??????????????????????????????????????????????????????????????????????????????????????????????????? (Staff activity expense)';
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
                                     'unit' => '??????????????????',
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

                    case '??????????????????????????????????????????????????????????????????????????? (Excursion expenses)':

                        $subCategoryName = 'Excursion - ??????????????????????????? (Accomodation fee for excursion)';
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
                                     'unit' => '????????????',
                                     'second_unit' => '?????????',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Excursion - ????????????????????????,?????????????????????????????????,????????????????????? (Food & beverage forexcursion)';
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
                                     'unit' => '????????????',
                                     'second_unit' => '?????????',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Excursion - ??????????????????????????????????????????????????? (Admission fare to the show)';
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
                                     'unit' => '????????????',
                                     'second_unit' => '?????????',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Excursion - ??????????????????????????? (Car rental for excursion)';
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
                                     'unit' => '????????????',
                                     'second_unit' => '?????????',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Excursion - ?????????????????????????????? (express way fee for excursion)';
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
                                     'unit' => '????????????',
                                     'second_unit' => '?????????',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'N',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Excursion - ????????????????????????????????????????????????????????????????????????????????? (Music expense for excursion)';
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
                                     'unit' => '????????????',
                                     'second_unit' => '?????????',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Excursion - ???????????????????????????????????????????????????????????????????????? ??? ???????????? ??????????????? (Recreation expense)';
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
                                     'unit' => '????????????',
                                     'second_unit' => '?????????',
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        break;

                    case '????????????????????????????????????????????????????????? (Staff party expense)':

                        $subCategoryName = 'Staff party expense - ?????????????????????????????????????????? (Place fee)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Staff party expense - ???????????????????????? (Food & beverage expense)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'Staff party expense - ????????????????????????????????????, Lucky draw, ???????????? ??? (Recreation expense,games,etc.)';
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
                                     'unit' => '??????????????????',
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

                    case '??????????????????????????????????????????????????? (TMFC expense)':

                        $subCategoryName = 'TMFC expense - ????????????????????????????????? (Field expense)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = 'TMFC expense - ?????????????????????????????????????????????????????????????????? (Food & Beverage expense)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '???????????????,???????????????????????????????????????????????????????????????????????????????????? (Medicine, sport ware and equipment expense)';
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
                                     'unit' => '??????????????????',
                                     'second_unit' => null,
                                     'required_attachment' => false,
                                     'interface_doc_flag' => 'Y',
                                     'allow_exceed_policy' => true,
                                     'active' => true,
                                     'last_updated_by' => -1,
                                     'created_by' => -1,
                                     'creation_date' => date('Y-m-d H:i:s'),
                                     'last_update_date' => date('Y-m-d H:i:s')]);

                        $subCategoryName = '???????????????????????????????????? (Coach fee)';
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
                                     'unit' => '??????????????????',
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

                    case '?????????????????????????????? (Medical)':

                        $subCategoryName = '?????????????????????????????? (Medical)';
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
                                     'unit' => '??????????????????',
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
                                     'unit' => '??????????????????',
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

                    case '????????????????????? 100% (Refund cash advance 100%)':

                        $subCategoryName = '????????????????????? 100% (Refund cash advance 100%)';
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
                                     'unit' => '??????????????????',
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
                                     'unit' => '??????????????????',
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