<?php

namespace App\Http\Controllers\PD\Web;

use App\Http\Controllers\PD\Api\InvMaterialItemApiController;
use App\Http\Controllers\PD\Web\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Class InvMaterialItemController extends BaseController
{
  /**
   * @var InvMaterialItemApiController
   */
  private $api;

  /**
    * RequestMaterialController constructor.
    * @param InvMaterialItemApiController $api
    */
  public function __construct(InvMaterialItemApiController $api)
  {
    $this->api = $api;
  }

   /**
    * @param int $id
    * @return Application|Factory|View|string|void
    */

  // public function index($id)
  // {
  //   if($id == 'create') return $this->create();
  //   return $this->show(intval($id));
  // }

  public function create()
  {
    $user = auth()->user();

    return $this->vue('inv-material-item', [
      'header_id' => null,
      'inv_material_item' => (object)[],
      'user' => $user,
    ]);
  }

  public function show(int $id)
  {
    $data = $this->api->show($id)->getData();
    $user = auth()->user();

    return $this->vue('inv-material-item', [
      'header_id' => $id,
      'inv_material_item' => $data->invMaterialItem,
      'user' => $user,
    ]);
  }

   
  
}