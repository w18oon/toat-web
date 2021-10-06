<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use RuntimeException;


abstract class CRUDController extends Controller
{
    protected $dtoClassName = null;
    protected $modelClassName = null;
    protected static $methods = [];
    protected static $routePrefix = '/';

    /**
     * @param string|null $routePrefix
     * @param \Closure|null $callback
     */
    public static function route(string $routePrefix = null, \Closure $callback = null)
    {
        $prefix = $routePrefix ?? static::getStaticClassName();
        $methods = static::$methods;
        $routes = [];
//        Route::group([
//            'middleware' => 'api',
//        ], function () use ($prefix, $methods, &$routes) {
        if (in_array('readAll', $methods)) $routes['readAll'] = Route::get("$prefix", [static::class, 'readAll']);
        if (in_array('read', $methods)) $routes['read'] = Route::get("$prefix/{id}", [static::class, 'read']);
        if (in_array('create', $methods)) $routes['create'] = Route::post("$prefix", [static::class, 'create']);
        if (in_array('update', $methods)) $routes['update'] = Route::put("$prefix/{id}", [static::class, 'update']);
        if (in_array('delete', $methods)) $routes['delete'] = Route::delete("$prefix/{id}", [static::class, 'delete']);
//        });

        if (!is_null($callback)) {
            $callback($routes);
        }
    }

    private static function getStaticClassName()
    {
        $class = strval(static::class);
        $class = last(explode("\\", $class));
        if (!$class || strlen($class) < 1) return '/';
        $class[0] = strtolower($class[0]);
        $class = str_replace('Controller', '', $class);
        return $class;
    }

    private function checkMethodAllowed($method)
    {
        if (!in_array($method, static::$methods)) throw new RuntimeException("method '$method' is not allow!");
    }


    public function readAll(): JsonResponse
    {
        $this->checkMethodAllowed(__FUNCTION__);

        $Model = $this->modelClassName;
        return response()->json($Model::all());
    }

    public function read(int $id): JsonResponse
    {
        $this->checkMethodAllowed(__FUNCTION__);

        $Model = $this->modelClassName;
        $object = $Model::query()->find($id);

        if (!$object) return response()->json(null, 404);

        return response()->json($object);
    }

    public function create(Request $req)
    {
        $this->checkMethodAllowed(__FUNCTION__);

        $Model = $this->modelClassName;
        $Dto = $this->dtoClassName;

        if ($Dto) {
            [$dto, $err] = $this->parseDto($Dto, $req);
            if ($err) return response($err, $err['status']);
            $any = $dto->toArray();
        } else {
            $any = $req->all();
        }

        $object = new $Model($any);
        $object->save();

        return $object;
    }

    public function update(int $id, Request $req)
    {
        $this->checkMethodAllowed(__FUNCTION__);

        $Model = $this->modelClassName;
        $Dto = $this->dtoClassName;

        if ($Dto) {
            /**
             * @type CourseInstanceDto $dto
             */
            [$dto, $err] = $this->parseDto($Dto, $req);
            if ($err) return response($err, $err['status']);
            $any = $dto->toArray();
        } else {
            $any = $req->all();
        }

        $object = $Model::query()->find($id);
        if (!$object) return response()->json(null, 404);

        $object->fill($any);
        $object->save();

        return $object;
    }

    public function delete(int $id)
    {
        $this->checkMethodAllowed(__FUNCTION__);

        $Model = $this->modelClassName;

        $object = $Model::query()->find($id);
        if (!$object) return response()->json(null, 404);

        return $object->delete();
    }


    protected function parseDto($class, ?Request $request, array $overrideData = [])
    {
        try {
            $data = is_null($request) ? [] : $request->all();
            return [new $class($overrideData + $data), null];
        } catch (\Exception $e) {
            return [
                null, [
                    'message' => 'Invalid Arguments',
                    'errors' => $e->errors(),
                    'status' => $e->status,
                ],
            ];
        }
    }
}
