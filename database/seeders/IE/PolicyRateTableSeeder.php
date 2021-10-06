<?php
namespace Database\Seeders\IE;

use Illuminate\Database\Seeder;

// use App\HrOperatingUnit;
use App\Models\IE\Category;
use App\Models\IE\SubCategory;
use App\Models\IE\Policy;
use App\Models\IE\Preference;
use App\Models\IE\MileageUnit;
use App\Models\IE\Location;
use App\Models\IE\FNDListOfValues;

class PolicyRateTableSeeder extends Seeder
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
            DB::table('xxweb_policy_rates')->truncate();
            DB::table('xxweb_policy_rates')->insert($policies);

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
        // $hrOperatingUnits = HrOperatingUnit::all();
        $positionLevels = FNDListOfValues::poLevel()->get();

        // foreach ($hrOperatingUnits as $key => $hou) {

            $locations = Location::all();
            $baseCurrency = Preference::getBaseCurrency(81);

            $categories = Category::all();
            foreach ($categories as $key => $category) {

                $subCategories = SubCategory::where('category_id',$category->id)
                                    ->get();

                foreach ($subCategories as $key => $subCategory) {

                    $policies = Policy::where('category_id',$category->id)
                                    ->where('sub_category_id',$subCategory->id)
                                    ->get();

                    foreach ($policies as $key => $policy) {

                        switch ($category->name) {

                            case 'ค่าเดินทางในประเทศ (Domestic Business trip)':

                                if($subCategory->name == 'ค่าตั๋วเครื่องบินในประเทศ (Air fare)'){

                                    if($policy->type = 'EXPENSE'){
                                        // CHECK ANY CASE
                                        $resultRate = self::getSeederRateDomesticBusinessTripAirFare(null,null);
                                        if($resultRate){
                                            array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => $resultRate['unlimit'],
                                            'rate' => $resultRate['rate'],
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s')]);
                                        }

                                        foreach ($positionLevels as $poLevel) {
                                            // CHECK POSITION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticBusinessTripAirFare($poLevel->flex_value,null);
                                            if($resultRate){
                                                array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => null,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                            }
                                        }

                                        foreach ($locations as $location) {
                                            // CHECK LOCATION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticBusinessTripAirFare(null,$location->name);
                                            if($resultRate){
                                                array_push($lists,
                                                [
                                                'category_id' => $category->id,
                                                'sub_category_id' => $subCategory->id,
                                                'policy_id' => $policy->id,
                                                'location_id' => $location->id,
                                                'position_po_level' => null,
                                                'unlimit' => $resultRate['unlimit'],
                                                'rate' => $resultRate['rate'],
                                                'currency_id' => $baseCurrency,
                                                'active' => true,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')]);
                                            }

                                            foreach ($positionLevels as $poLevel) {
                                                // CHECK POSITION & LOCATION CASE
                                                $resultRate = self::getSeederRateDomesticBusinessTripAirFare($poLevel->flex_value,$location->name);
                                                if($resultRate){
                                                    array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => $location->id,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                                }
                                            }

                                        }

                                    }

                                }

                                if($subCategory->name == 'ค่ารถไฟในประเทศ (Train fare)'){

                                    if($policy->type = 'EXPENSE'){
                                        // CHECK ANY CASE
                                        $resultRate = self::getSeederRateDomesticBusinessTripTrainFair(null,null);
                                        if($resultRate){
                                            array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => $resultRate['unlimit'],
                                            'rate' => $resultRate['rate'],
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s')]);
                                        }

                                        foreach ($positionLevels as $poLevel) {
                                            // CHECK POSITION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticBusinessTripTrainFair($poLevel->flex_value,null);
                                            if($resultRate){
                                                array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => null,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                            }
                                        }

                                        foreach ($locations as $location) {
                                            // CHECK LOCATION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticBusinessTripTrainFair(null,$location->name);
                                            if($resultRate){
                                                array_push($lists,
                                                [
                                                'category_id' => $category->id,
                                                'sub_category_id' => $subCategory->id,
                                                'policy_id' => $policy->id,
                                                'location_id' => $location->id,
                                                'position_po_level' => null,
                                                'unlimit' => $resultRate['unlimit'],
                                                'rate' => $resultRate['rate'],
                                                'currency_id' => $baseCurrency,
                                                'active' => true,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')]);
                                            }

                                            foreach ($positionLevels as $poLevel) {
                                                // CHECK POSITION & LOCATION CASE
                                                $resultRate = self::getSeederRateDomesticBusinessTripTrainFair($poLevel->flex_value,$location->name);
                                                if($resultRate){
                                                    array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => $location->id,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                                }
                                            }

                                        }

                                    }

                                }

                                if($subCategory->name == 'ค่ารถทัวร์ในประเทศ (Bus fare)'){

                                    if($policy->type = 'EXPENSE'){
                                        // CHECK ANY CASE
                                        $resultRate = self::getSeederRateDomesticBusinessTripBusFair(null,null);
                                        if($resultRate){
                                            array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => $resultRate['unlimit'],
                                            'rate' => $resultRate['rate'],
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s')]);
                                        }

                                        foreach ($positionLevels as $poLevel) {
                                            // CHECK POSITION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticBusinessTripBusFair($poLevel->flex_value,null);
                                            if($resultRate){
                                                array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => null,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                            }
                                        }

                                        foreach ($locations as $location) {
                                            // CHECK LOCATION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticBusinessTripBusFair(null,$location->name);
                                            if($resultRate){
                                                array_push($lists,
                                                [
                                                'category_id' => $category->id,
                                                'sub_category_id' => $subCategory->id,
                                                'policy_id' => $policy->id,
                                                'location_id' => $location->id,
                                                'position_po_level' => null,
                                                'unlimit' => $resultRate['unlimit'],
                                                'rate' => $resultRate['rate'],
                                                'currency_id' => $baseCurrency,
                                                'active' => true,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')]);
                                            }

                                            foreach ($positionLevels as $poLevel) {
                                                // CHECK POSITION & LOCATION CASE
                                                $resultRate = self::getSeederRateDomesticBusinessTripBusFair($poLevel->flex_value,$location->name);
                                                if($resultRate){
                                                    array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => $location->id,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                                }
                                            }

                                        }

                                    }

                                }

                                if($subCategory->name == 'รถยนต์ส่วนตัว (Personal car)'){

                                    if($policy->type = 'MILEAGE'){

                                        array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => false,
                                            'rate' => 6,
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                             'created_at' => date('Y-m-d H:i:s'),
                                             'updated_at' => date('Y-m-d H:i:s')]);

                                    }

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

                                    if($policy->type = 'EXPENSE'){
                                        // CHECK ANY CASE
                                        $resultRate = self::getSeederRateDomesticBusinessTripAirFare(null,null);
                                        if($resultRate){
                                            array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => $resultRate['unlimit'],
                                            'rate' => $resultRate['rate'],
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s')]);
                                        }

                                        foreach ($positionLevels as $poLevel) {
                                            // CHECK POSITION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticBusinessTripAirFare($poLevel->flex_value,null);
                                            if($resultRate){
                                                array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => null,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                            }
                                        }

                                        foreach ($locations as $location) {
                                            // CHECK LOCATION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticBusinessTripAirFare(null,$location->name);
                                            if($resultRate){
                                                array_push($lists,
                                                [
                                                'category_id' => $category->id,
                                                'sub_category_id' => $subCategory->id,
                                                'policy_id' => $policy->id,
                                                'location_id' => $location->id,
                                                'position_po_level' => null,
                                                'unlimit' => $resultRate['unlimit'],
                                                'rate' => $resultRate['rate'],
                                                'currency_id' => $baseCurrency,
                                                'active' => true,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')]);
                                            }

                                            foreach ($positionLevels as $poLevel) {
                                                // CHECK POSITION & LOCATION CASE
                                                $resultRate = self::getSeederRateDomesticBusinessTripAirFare($poLevel->flex_value,$location->name);
                                                if($resultRate){
                                                    array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => $location->id,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                                }
                                            }

                                        }

                                    }

                                }

                                if($subCategory->name == 'ค่ารถไฟในประเทศ (Train fare)'){

                                    if($policy->type = 'EXPENSE'){
                                        // CHECK ANY CASE
                                        $resultRate = self::getSeederRateDomesticBusinessTripTrainFair(null,null);
                                        if($resultRate){
                                            array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => $resultRate['unlimit'],
                                            'rate' => $resultRate['rate'],
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s')]);
                                        }

                                        foreach ($positionLevels as $poLevel) {
                                            // CHECK POSITION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticBusinessTripTrainFair($poLevel->flex_value,null);
                                            if($resultRate){
                                                array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => null,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                            }
                                        }

                                        foreach ($locations as $location) {
                                            // CHECK LOCATION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticBusinessTripTrainFair(null,$location->name);
                                            if($resultRate){
                                                array_push($lists,
                                                [
                                                'category_id' => $category->id,
                                                'sub_category_id' => $subCategory->id,
                                                'policy_id' => $policy->id,
                                                'location_id' => $location->id,
                                                'position_po_level' => null,
                                                'unlimit' => $resultRate['unlimit'],
                                                'rate' => $resultRate['rate'],
                                                'currency_id' => $baseCurrency,
                                                'active' => true,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')]);
                                            }

                                            foreach ($positionLevels as $poLevel) {
                                                // CHECK POSITION & LOCATION CASE
                                                $resultRate = self::getSeederRateDomesticBusinessTripTrainFair($poLevel->flex_value,$location->name);
                                                if($resultRate){
                                                    array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => $location->id,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                                }
                                            }

                                        }

                                    }

                                }

                                if($subCategory->name == 'ค่ารถทัวร์ในประเทศ (Bus fare)'){

                                    if($policy->type = 'EXPENSE'){
                                        // CHECK ANY CASE
                                        $resultRate = self::getSeederRateDomesticBusinessTripBusFair(null,null);
                                        if($resultRate){
                                            array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => $resultRate['unlimit'],
                                            'rate' => $resultRate['rate'],
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s')]);
                                        }

                                        foreach ($positionLevels as $poLevel) {
                                            // CHECK POSITION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticBusinessTripBusFair($poLevel->flex_value,null);
                                            if($resultRate){
                                                array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => null,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                            }
                                        }

                                        foreach ($locations as $location) {
                                            // CHECK LOCATION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticBusinessTripBusFair(null,$location->name);
                                            if($resultRate){
                                                array_push($lists,
                                                [
                                                'category_id' => $category->id,
                                                'sub_category_id' => $subCategory->id,
                                                'policy_id' => $policy->id,
                                                'location_id' => $location->id,
                                                'position_po_level' => null,
                                                'unlimit' => $resultRate['unlimit'],
                                                'rate' => $resultRate['rate'],
                                                'currency_id' => $baseCurrency,
                                                'active' => true,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')]);
                                            }

                                            foreach ($positionLevels as $poLevel) {
                                                // CHECK POSITION & LOCATION CASE
                                                $resultRate = self::getSeederRateDomesticBusinessTripBusFair($poLevel->flex_value,$location->name);
                                                if($resultRate){
                                                    array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => $location->id,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                                }
                                            }

                                        }

                                    }

                                }

                                if($subCategory->name == 'รถยนต์ส่วนตัว (Personal car)'){

                                    if($policy->type = 'MILEAGE'){

                                        array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => false,
                                            'rate' => 6,
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                             'created_at' => date('Y-m-d H:i:s'),
                                             'updated_at' => date('Y-m-d H:i:s')]);

                                    }

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


                                    // if($policy->type = 'EXPENSE'){
                                    //     // CHECK ANY CASE
                                    //     $resultRate = self::getSeederRateOverSeaBusinessTripAirFair(null,null);
                                    //     if($resultRate){
                                    //         array_push($lists,
                                    //         [
                                    //         'category_id' => $category->id,
                                    //         'sub_category_id' => $subCategory->id,
                                    //         'policy_id' => $policy->id,
                                    //         'location_id' => null,
                                    //         'position_po_level' => null,
                                    //         'unlimit' => $resultRate['unlimit'],
                                    //         'rate' => $resultRate['rate'],
                                    //         'currency_id' => $baseCurrency,
                                    //         'active' => true,
                                    //         'created_at' => date('Y-m-d H:i:s'),
                                    //         'updated_at' => date('Y-m-d H:i:s')]);
                                    //     }

                                    //     foreach ($positionLevels as $poLevel) {
                                    //         // CHECK POSITION ONLY CASE
                                    //         $resultRate = self::getSeederRateOverSeaBusinessTripAirFair($poLevel->flex_value,null);
                                    //         if($resultRate){
                                    //             array_push($lists,
                                    //                 [
                                    //                 'category_id' => $category->id,
                                    //                 'sub_category_id' => $subCategory->id,
                                    //                 'policy_id' => $policy->id,
                                    //                 'location_id' => null,
                                    //                 'position_po_level' => $poLevel->flex_value,
                                    //                 'unlimit' => $resultRate['unlimit'],
                                    //                 'rate' => $resultRate['rate'],
                                    //                 'currency_id' => $baseCurrency,
                                    //                 'active' => true,
                                    //                 'created_at' => date('Y-m-d H:i:s'),
                                    //                 'updated_at' => date('Y-m-d H:i:s')]);
                                    //         }
                                    //     }

                                    //     foreach ($locations as $location) {
                                    //         // CHECK LOCATION ONLY CASE
                                    //         $resultRate = self::getSeederRateOverSeaBusinessTripAirFair(null,$location->name);
                                    //         if($resultRate){
                                    //             array_push($lists,
                                    //             [
                                    //             'category_id' => $category->id,
                                    //             'sub_category_id' => $subCategory->id,
                                    //             'policy_id' => $policy->id,
                                    //             'location_id' => $location->id,
                                    //             'position_po_level' => null,
                                    //             'unlimit' => $resultRate['unlimit'],
                                    //             'rate' => $resultRate['rate'],
                                    //             'currency_id' => $baseCurrency,
                                    //             'active' => true,
                                    //             'created_at' => date('Y-m-d H:i:s'),
                                    //             'updated_at' => date('Y-m-d H:i:s')]);
                                    //         }

                                    //         foreach ($positionLevels as $poLevel) {
                                    //             // CHECK POSITION & LOCATION CASE
                                    //             $resultRate = self::getSeederRateOverSeaBusinessTripAirFair($poLevel->flex_value,$location->name);
                                    //             if($resultRate){
                                    //                 array_push($lists,
                                    //                 [
                                    //                 'category_id' => $category->id,
                                    //                 'sub_category_id' => $subCategory->id,
                                    //                 'policy_id' => $policy->id,
                                    //                 'location_id' => $location->id,
                                    //                 'position_po_level' => $poLevel->flex_value,
                                    //                 'unlimit' => $resultRate['unlimit'],
                                    //                 'rate' => $resultRate['rate'],
                                    //                 'currency_id' => $baseCurrency,
                                    //                 'active' => true,
                                    //                 'created_at' => date('Y-m-d H:i:s'),
                                    //                 'updated_at' => date('Y-m-d H:i:s')]);
                                    //             }
                                    //         }

                                    //     }

                                    // }


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

                                    if($policy->type = 'EXPENSE'){
                                        // CHECK ANY CASE
                                        $resultRate = self::getSeederRateDomesticAccommadationDaily(null,null);
                                        if($resultRate){
                                            array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => $resultRate['unlimit'],
                                            'rate' => $resultRate['rate'],
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s')]);
                                        }

                                        foreach ($positionLevels as $poLevel) {
                                            // CHECK POSITION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticAccommadationDaily($poLevel->flex_value,null);
                                            if($resultRate){
                                                array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => null,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                            }
                                        }

                                        foreach ($locations as $location) {
                                            // CHECK LOCATION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticAccommadationDaily(null,$location->name);
                                            if($resultRate){
                                                array_push($lists,
                                                [
                                                'category_id' => $category->id,
                                                'sub_category_id' => $subCategory->id,
                                                'policy_id' => $policy->id,
                                                'location_id' => $location->id,
                                                'position_po_level' => null,
                                                'unlimit' => $resultRate['unlimit'],
                                                'rate' => $resultRate['rate'],
                                                'currency_id' => $baseCurrency,
                                                'active' => true,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')]);
                                            }

                                            foreach ($positionLevels as $poLevel) {
                                                // CHECK POSITION & LOCATION CASE
                                                $resultRate = self::getSeederRateDomesticAccommadationDaily($poLevel->flex_value,$location->name);
                                                if($resultRate){
                                                    array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => $location->id,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                                }
                                            }

                                        }

                                    }

                                }

                                if($subCategory->name == 'ค่าที่พักรายเดือน (Monthly accomodation)'){

                                    if($policy->type = 'EXPENSE'){
                                        // CHECK ANY CASE
                                        $resultRate = self::getSeederRateDomesticAccommadationMonthly(null,null);
                                        if($resultRate){
                                            array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => $resultRate['unlimit'],
                                            'rate' => $resultRate['rate'],
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s')]);
                                        }

                                        foreach ($positionLevels as $poLevel) {
                                            // CHECK POSITION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticAccommadationMonthly($poLevel->flex_value,null);
                                            if($resultRate){
                                                array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => null,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                            }
                                        }

                                        foreach ($locations as $location) {
                                            // CHECK LOCATION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticAccommadationMonthly(null,$location->name);
                                            if($resultRate){
                                                array_push($lists,
                                                [
                                                'category_id' => $category->id,
                                                'sub_category_id' => $subCategory->id,
                                                'policy_id' => $policy->id,
                                                'location_id' => $location->id,
                                                'position_po_level' => null,
                                                'unlimit' => $resultRate['unlimit'],
                                                'rate' => $resultRate['rate'],
                                                'currency_id' => $baseCurrency,
                                                'active' => true,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')]);
                                            }

                                            foreach ($positionLevels as $poLevel) {
                                                // CHECK POSITION & LOCATION CASE
                                                $resultRate = self::getSeederRateDomesticAccommadationMonthly($poLevel->flex_value,$location->name);
                                                if($resultRate){
                                                    array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => $location->id,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                                }
                                            }

                                        }

                                    }

                                }

                                break;

                            case 'ค่าที่พักในประเทศเพื่อไปทำงานสินไหม (Claim Domestic Accomodation)':

                                if($subCategory->name == 'ค่าที่พักรายวัน (Daily Accomodation)'){

                                    if($policy->type = 'EXPENSE'){
                                        // CHECK ANY CASE
                                        $resultRate = self::getSeederRateDomesticAccommadationDaily(null,null);
                                        if($resultRate){
                                            array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => $resultRate['unlimit'],
                                            'rate' => $resultRate['rate'],
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s')]);
                                        }

                                        foreach ($positionLevels as $poLevel) {
                                            // CHECK POSITION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticAccommadationDaily($poLevel->flex_value,null);
                                            if($resultRate){
                                                array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => null,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                            }
                                        }

                                        foreach ($locations as $location) {
                                            // CHECK LOCATION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticAccommadationDaily(null,$location->name);
                                            if($resultRate){
                                                array_push($lists,
                                                [
                                                'category_id' => $category->id,
                                                'sub_category_id' => $subCategory->id,
                                                'policy_id' => $policy->id,
                                                'location_id' => $location->id,
                                                'position_po_level' => null,
                                                'unlimit' => $resultRate['unlimit'],
                                                'rate' => $resultRate['rate'],
                                                'currency_id' => $baseCurrency,
                                                'active' => true,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')]);
                                            }

                                            foreach ($positionLevels as $poLevel) {
                                                // CHECK POSITION & LOCATION CASE
                                                $resultRate = self::getSeederRateDomesticAccommadationDaily($poLevel->flex_value,$location->name);
                                                if($resultRate){
                                                    array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => $location->id,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                                }
                                            }

                                        }

                                    }

                                }

                                if($subCategory->name == 'ค่าที่พักรายเดือน (Monthly accomodation)'){

                                    if($policy->type = 'EXPENSE'){
                                        // CHECK ANY CASE
                                        $resultRate = self::getSeederRateDomesticAccommadationMonthly(null,null);
                                        if($resultRate){
                                            array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => $resultRate['unlimit'],
                                            'rate' => $resultRate['rate'],
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s')]);
                                        }

                                        foreach ($positionLevels as $poLevel) {
                                            // CHECK POSITION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticAccommadationMonthly($poLevel->flex_value,null);
                                            if($resultRate){
                                                array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => null,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                            }
                                        }

                                        foreach ($locations as $location) {
                                            // CHECK LOCATION ONLY CASE
                                            $resultRate = self::getSeederRateDomesticAccommadationMonthly(null,$location->name);
                                            if($resultRate){
                                                array_push($lists,
                                                [
                                                'category_id' => $category->id,
                                                'sub_category_id' => $subCategory->id,
                                                'policy_id' => $policy->id,
                                                'location_id' => $location->id,
                                                'position_po_level' => null,
                                                'unlimit' => $resultRate['unlimit'],
                                                'rate' => $resultRate['rate'],
                                                'currency_id' => $baseCurrency,
                                                'active' => true,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')]);
                                            }

                                            foreach ($positionLevels as $poLevel) {
                                                // CHECK POSITION & LOCATION CASE
                                                $resultRate = self::getSeederRateDomesticAccommadationMonthly($poLevel->flex_value,$location->name);
                                                if($resultRate){
                                                    array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => $location->id,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                                }
                                            }

                                        }

                                    }
                                }

                                break;

                            case 'ค่าที่พักในต่างประเทศ (Oversea Accomodation)':

                                if($subCategory->name == 'ค่าโรงแรมในต่างประเทศ (Oversea hotel fee)'){

                                    if($policy->type = 'EXPENSE'){
                                        // CHECK ANY CASE
                                        $resultRate = self::getSeederRateOverSeaAccommadationRate(null,null);

                                        if($resultRate){
                                            array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => $resultRate['unlimit'],
                                            'rate' => $resultRate['rate'],
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s')]);
                                        }

                                        foreach ($positionLevels as $poLevel) {
                                            // CHECK POSITION ONLY CASE
                                            $resultRate = self::getSeederRateOverSeaAccommadationRate($poLevel->flex_value,null);

                                            if($resultRate){
                                                array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => null,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                            }
                                        }

                                        foreach ($locations as $location) {
                                            // CHECK LOCATION ONLY CASE
                                            $resultRate = self::getSeederRateOverSeaAccommadationRate(null,$location->name);

                                            if($resultRate){
                                                array_push($lists,
                                                [
                                                'category_id' => $category->id,
                                                'sub_category_id' => $subCategory->id,
                                                'policy_id' => $policy->id,
                                                'location_id' => $location->id,
                                                'position_po_level' => null,
                                                'unlimit' => $resultRate['unlimit'],
                                                'rate' => $resultRate['rate'],
                                                'currency_id' => $baseCurrency,
                                                'active' => true,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')]);
                                            }

                                            foreach ($positionLevels as $poLevel) {
                                                // CHECK POSITION & LOCATION CASE
                                                $resultRate = self::getSeederRateOverSeaAccommadationRate($poLevel->flex_value,$location->name);
                                                if($resultRate){
                                                    array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => $location->id,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                                }
                                            }

                                        }

                                    }

                                }

                                break;

                            case 'ค่าเบี้ยเลี้ยงต่างประเทศ (Overseas daily allowance)':

                                if($subCategory->name == 'ค่าเบี้ยเลี้ยงต่างประเทศ (Overseas daily allowance)'){

                                   if($policy->type = 'EXPENSE'){
                                    // CHECK ANY CASE
                                        $resultRate = self::getSeederRateOverSeaAllowanceRate(null,null);
                                        if($resultRate){
                                            array_push($lists,
                                            [
                                            'category_id' => $category->id,
                                            'sub_category_id' => $subCategory->id,
                                            'policy_id' => $policy->id,
                                            'location_id' => null,
                                            'position_po_level' => null,
                                            'unlimit' => $resultRate['unlimit'],
                                            'rate' => $resultRate['rate'],
                                            'currency_id' => $baseCurrency,
                                            'active' => true,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s')]);
                                        }

                                        foreach ($positionLevels as $poLevel) {
                                            // CHECK POSITION ONLY CASE
                                            $resultRate = self::getSeederRateOverSeaAllowanceRate($poLevel->flex_value,null);
                                            if($resultRate){
                                                array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => null,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                            }
                                        }

                                        foreach ($locations as $location) {
                                            // CHECK LOCATION ONLY CASE
                                            $resultRate = self::getSeederRateOverSeaAllowanceRate(null,$location->name);
                                            if($resultRate){
                                                array_push($lists,
                                                [
                                                'category_id' => $category->id,
                                                'sub_category_id' => $subCategory->id,
                                                'policy_id' => $policy->id,
                                                'location_id' => $location->id,
                                                'position_po_level' => null,
                                                'unlimit' => $resultRate['unlimit'],
                                                'rate' => $resultRate['rate'],
                                                'currency_id' => $baseCurrency,
                                                'active' => true,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')]);
                                            }

                                            foreach ($positionLevels as $poLevel) {
                                                // CHECK POSITION & LOCATION CASE
                                                $resultRate = self::getSeederRateOverSeaAllowanceRate($poLevel->flex_value,$location->name);
                                                if($resultRate){
                                                    array_push($lists,
                                                    [
                                                    'category_id' => $category->id,
                                                    'sub_category_id' => $subCategory->id,
                                                    'policy_id' => $policy->id,
                                                    'location_id' => $location->id,
                                                    'position_po_level' => $poLevel->flex_value,
                                                    'unlimit' => $resultRate['unlimit'],
                                                    'rate' => $resultRate['rate'],
                                                    'currency_id' => $baseCurrency,
                                                    'active' => true,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'updated_at' => date('Y-m-d H:i:s')]);
                                                }
                                            }

                                        }

                                    }
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

            }
        // }

        return $lists;
    }

    private static function getSeederRateDomesticBusinessTripAirFare($positionPoLevel,$locationName)
    {
        $result = null;

        if(!$positionPoLevel && !$locationName){
            // ANY POSITION AND ANY LOCATION
            $result['rate'] = 0;
            $result['unlimit'] = false;

        }elseif(strpos($positionPoLevel,'G1') === 0 || strpos($positionPoLevel,'G2') === 0) {

            if($locationName == 'Domestic'){
                $result['rate'] = 0;
                $result['unlimit'] = false;
            }

        }elseif(strpos($positionPoLevel,'L1B') !== false || strpos($positionPoLevel,'L2B') !== false || strpos($positionPoLevel,'L3B') !== false || strpos($positionPoLevel,'L4B') !== false || strpos($positionPoLevel,'L5B') !== false || strpos($positionPoLevel,'L6B') !== false) {

            if($locationName == 'Domestic'){
                $result['rate'] = 3000;
                $result['unlimit'] = false;
            }

        }elseif(strpos($positionPoLevel,'L7B') !== false || strpos($positionPoLevel,'L8B') !== false || strpos($positionPoLevel,'L9B') !== false || strpos($positionPoLevel,'L10B') !== false || strpos($positionPoLevel,'L11B') !== false) {

            if($locationName == 'Domestic'){
                $result['rate'] = 3500;
                $result['unlimit'] = false;
            }
        }
        return $result;
    }

    private static function getSeederRateDomesticBusinessTripTrainFair($positionPoLevel,$locationName)
    {
        $result = null;

        if(!$positionPoLevel && !$locationName){
            // ANY POSITION AND ANY LOCATION
            $result['rate'] = 0;
            $result['unlimit'] = false;

        }elseif(strpos($positionPoLevel,'G1') === 0 || strpos($positionPoLevel,'G2') === 0 || strpos($positionPoLevel,'L1B') !== false || strpos($positionPoLevel,'L2B') !== false || strpos($positionPoLevel,'L3B') !== false || strpos($positionPoLevel,'L4B') !== false || strpos($positionPoLevel,'L5B') !== false || strpos($positionPoLevel,'L6B') !== false) {

            if($locationName == 'Domestic'){
                $result['rate'] = 1500;
                $result['unlimit'] = false;
            }

        }elseif(strpos($positionPoLevel,'L7B') !== false || strpos($positionPoLevel,'L8B') !== false || strpos($positionPoLevel,'L9B') !== false || strpos($positionPoLevel,'L10B') !== false || strpos($positionPoLevel,'L11B') !== false) {

            if($locationName == 'Domestic'){
                $result['rate'] = 1800;
                $result['unlimit'] = false;
            }

        }
        return $result;
    }

    private static function getSeederRateDomesticBusinessTripBusFair($positionPoLevel,$locationName)
    {
        $result = null;

        if(!$positionPoLevel && !$locationName){
            // ANY POSITION AND ANY LOCATION
            $result['rate'] = 0;
            $result['unlimit'] = false;

        }elseif(strpos($positionPoLevel,'G1') === 0 || strpos($positionPoLevel,'G2') === 0 || strpos($positionPoLevel,'L1B') !== false || strpos($positionPoLevel,'L2B') !== false || strpos($positionPoLevel,'L3B') !== false || strpos($positionPoLevel,'L4B') !== false || strpos($positionPoLevel,'L5B') !== false || strpos($positionPoLevel,'L6B') !== false) {

            if($locationName == 'Domestic'){
                $result['rate'] = 1700;
                $result['unlimit'] = false;
            }

        }elseif(strpos($positionPoLevel,'L7B') !== false || strpos($positionPoLevel,'L8B') !== false || strpos($positionPoLevel,'L9B') !== false || strpos($positionPoLevel,'L10B') !== false || strpos($positionPoLevel,'L11B') !== false) {

            if($locationName == 'Domestic'){
                $result['rate'] = 2000;
                $result['unlimit'] = false;
            }

        }
        return $result;
    }

    private static function getSeederRateOverSeaBusinessTripAirFair($positionPoLevel,$locationName)
    {
        $result = null;

        return $result;
    }

    private static function getSeederRateDomesticAccommadationDaily($positionPoLevel,$locationName)
    {
        $result = null;

        if(!$positionPoLevel && !$locationName){
            // ANY POSITION AND ANY LOCATION
            $result['rate'] = 0;
            $result['unlimit'] = false;

        }elseif(strpos($positionPoLevel,'G1') === 0 || strpos($positionPoLevel,'G2') === 0 || strpos($positionPoLevel,'L1B') !== false || strpos($positionPoLevel,'L2B') !== false || strpos($positionPoLevel,'L3B') !== false || strpos($positionPoLevel,'L4B') !== false) {

            if($locationName == 'Domestic'){
                $result['rate'] = 800;
                $result['unlimit'] = false;
            }

        }elseif(strpos($positionPoLevel,'L5B') !== false || strpos($positionPoLevel,'L6B') !== false) {

            if($locationName == 'Domestic'){
                $result['rate'] = 1200;
                $result['unlimit'] = false;
            }

        }elseif(strpos($positionPoLevel,'L7B') !== false || strpos($positionPoLevel,'L8B') !== false || strpos($positionPoLevel,'L9B') !== false || strpos($positionPoLevel,'L10B') !== false || strpos($positionPoLevel,'L11B') !== false) {

            if($locationName == 'Domestic'){
                $result['rate'] = null;
                $result['unlimit'] = true;
            }

        }
        return $result;
    }

    private static function getSeederRateDomesticAccommadationMonthly($positionPoLevel,$locationName)
    {
        $result = null;

        if(!$positionPoLevel && !$locationName){
            // ANY POSITION AND ANY LOCATION
            $result['rate'] = 0;
            $result['unlimit'] = false;

        }elseif(strpos($positionPoLevel,'G1') === 0 || strpos($positionPoLevel,'G2') === 0 || strpos($positionPoLevel,'L1B') !== false || strpos($positionPoLevel,'L2B') !== false || strpos($positionPoLevel,'L3B') !== false || strpos($positionPoLevel,'L4B') !== false) {
            // LOW LEVEL POSITION AND LOCATION 'Domestic'
            if($locationName == 'Domestic'){
                $result['rate'] = 2500;
                $result['unlimit'] = false;
            }

        }elseif(strpos($positionPoLevel,'L5B') !== false || strpos($positionPoLevel,'L6B') !== false || strpos($positionPoLevel,'L7B') !== false || strpos($positionPoLevel,'L8B') !== false || strpos($positionPoLevel,'L9B') !== false || strpos($positionPoLevel,'L10B') !== false || strpos($positionPoLevel,'L11B') !== false) {
            // HIGH LEVEL POSITION AND LOCATION 'Domestic'
            if($locationName == 'Domestic'){
                $result['rate'] = null;
                $result['unlimit'] = true;
            }

        }
        return $result;
    }

    private static function getSeederRateOverSeaAccommadationRate($positionPoLevel,$locationName)
    {
        $result = null;

        if(!$positionPoLevel && !$locationName){
            // ANY POSITION AND ANY LOCATION
            $result['rate'] = 0;
            $result['unlimit'] = false;
        }elseif(!$positionPoLevel && $locationName == 'Zone A'){
            // ANY POSITION AND LOCATION 'Zone A'
            $result['rate'] = 5200;
            $result['unlimit'] = false;
        }elseif(!$positionPoLevel && ($locationName == 'Zone B' || $locationName == 'Japan')){
            // ANY POSITION AND LOCATION 'Zone B','Japan'
            $result['rate'] = 6400;
            $result['unlimit'] = false;
        }elseif(!$positionPoLevel && $locationName == 'Zone C'){
            // ANY POSITION AND LOCATION 'Zone C'
            $result['rate'] = 7600;
            $result['unlimit'] = false;
        }elseif(!$positionPoLevel && $locationName == 'Domestic'){
            // ANY POSITION AND LOCATION 'Domestic'
            $result['rate'] = 0;
            $result['unlimit'] = false;
        }

        return $result;
    }

    private static function getSeederRateOverSeaAllowanceRate($positionPoLevel,$locationName)
    {
        $result = null;

        if(!$positionPoLevel && !$locationName){
            // ANY POSITION AND ANY LOCATION
            $result['rate'] = 0;
            $result['unlimit'] = false;
        }elseif(!$positionPoLevel && $locationName == 'Domestic'){
            // ANY POSITION AND ANY LOCATION
            $result['rate'] = 0;
            $result['unlimit'] = false;
        }elseif(strpos($positionPoLevel,'G1') === 0 || strpos($positionPoLevel,'G2') === 0 || strpos($positionPoLevel,'L1B') !== false || strpos($positionPoLevel,'L2B') !== false || strpos($positionPoLevel,'L3B') !== false || strpos($positionPoLevel,'L4B') !== false) {

            if(!$locationName){
                $result = null;
            }elseif($locationName == 'Domestic'){
                $result = null;
            }elseif($locationName == 'Japan'){
                $result['rate'] = 1600;
                $result['unlimit'] = false;
            }else{ // Zone A,B,C ...
                $result['rate'] = 1300;
                $result['unlimit'] = false;
            }

        }elseif(strpos($positionPoLevel,'L5B') !== false || strpos($positionPoLevel,'L6B') !== false || strpos($positionPoLevel,'L7B') !== false || strpos($positionPoLevel,'L8B') !== false || strpos($positionPoLevel,'L9B') !== false || strpos($positionPoLevel,'L10B') !== false || strpos($positionPoLevel,'L11B') !== false) {

            if(!$locationName){
                $result = null;
            }elseif($locationName == 'Domestic'){
                $result = null;
            }elseif($locationName == 'Japan'){
                $result['rate'] = 2000;
                $result['unlimit'] = false;
            }else{ // Zone A,B,C ...
                $result['rate'] = 1700;
                $result['unlimit'] = false;
            }

        }

        return $result;
    }
}