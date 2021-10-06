<?php

namespace App\Http\Controllers\PD\Api;  
use App\Models\PD\PtpdInvMaterialItemHeader;   
use App\Http\Controllers\Controller;
use App\Models\PD\InvMaterialItemController; 
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InvMaterialItemApiController extends Controller
{
  public function index(): JsonResponse
  {
    $InvMaterialItem = PtpdInvMaterialItemHeader::query()->get();
    // return response()->json([
    //   'invmaterialitem' => $InvMaterialItem
    // ]);
    return response()->json(
       $InvMaterialItem
    );
  }

  public function show(int $id): JsonResponse
  {
    $invMaterialItem = PtpdInvMaterialItemHeader::query()->find($id);
    if(!$invMaterialItem) return response()->json([
      'message' => 'data not found',
    ], 404);
    return response()->json([
      'invMaterialItem' => $invMaterialItem
    ]);
  }
 
  public function create(Request $request): JsonResponse
  {

    $invMaterialItem = $request->input('invMaterialItem');
    // $invMaterialItem->description = $request->input('idescription');
    // $invMaterialItem->raw_material_type = $request->input('raw_material_type');
    // $invMaterialItem->blend_num = $request->input('blend_num');
    // $invMaterialItem->raw_material_type_code = $request->input('raw_material_type_code');

    // return response()->json([
    //    $invMaterialItem
    // ]);
    $user = auth()->user();
    $invMaterialItemModel = PtpdInvMaterialItemHeader::query()
      ->create([
        'raw_material_type' => $invMaterialItem['raw_material_type'], 
        'blend_num' => $invMaterialItem['blend_num'],
        'description' => $invMaterialItem['description'],
        'raw_material_type_code' => $invMaterialItem['raw_material_type_code'],
        'creation_date' => date('Y-m-d'),
        'created_by' => $user->user_id,
        'last_updated_by' => $user->user_id,

      ]);

    return response()->json([
      'invMaterialItem' => $invMaterialItemModel
    ]);

  
      // $invMaterialItemModel = PtpdInvMaterialItemHeader::query()
      // ->where('raw_material_id', $id)
      // ->first();
         
  }

  public function update(Request $request, int $id)
  {
    $invMaterialItem = $request->input('invMaterialItem');
    $user = auth()->user();
    
    DB::beginTransaction();

    try {
      $invMaterialItemModel = PtpdInvMaterialItemHeader::query()
        ->where('raw_material_id', $id)
        ->first();

      if(!$invMaterialItemModel) return response()->jsonn([
        'message' => 'data not found',
      ], 404);

      $invMaterialItemModel->update([
        'raw_material_type' => $invMaterialItem['raw_material_type'], 
        'blend_num' => $invMaterialItem['blend_num'],
        'description' => $invMaterialItem['description'],
        'raw_material_type_code' => $invMaterialItem['raw_material_type_code'],
        'last_updated_by' => $user->user_id,
        'last_update_date' => date('Y-m-d'),

      ]);

      DB::commit();

      return response()->json([
        'invMaterialItem' => $invMaterialItemModel,
      ]);

    } catch (\Exception $e) {
      DB::rollback();
      return $e;
    }
  }

  // public function search(Request $request){
  //   $InvMaterialItem = PtpdInvMaterialItemHeader::query()->get();
    

  //   if ($request->has('raw_material_type')) {
  //       $InvMaterialItem->where('raw_material_type', $request->input('raw_material_type'));
  //   }
  //   if ($request->has('raw_material_type_code')) {
  //       $InvMaterialItem->where('raw_material_type_code', $request->input('raw_material_type_code'));
  //   }
  //   if ($request->has('description')) {
  //      $InvMaterialItem->where('description', $request->input('description'));
  //   }

  //   return response()->json([
  //   'invMaterialItem' => $invMaterialItems,
  //   ]);
    

  // }
  // public function delete(int $id)
  // {
  //   $invMaterialItems = PtpdInvMaterialItemHeader::query()->find($id);
  //   if(!$invMaterialItems)
  //   {
  //     return response()->json([
  //       'message' => 'Not Found!'
  //     ], 404);
  //   } 
  //   $exCigarette->delete();
  //   return response()->json([
  //     'message' => 'Deleted!'
  //   ], 200);
  // }
}