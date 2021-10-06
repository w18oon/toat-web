<?php

namespace App\Http\Controllers\PD\Api;

use App\Http\Controllers\Controller;
use App\Models\PM\Lookup\PtpmMaterialGroup;
use Illuminate\Http\Request;

class LookupController extends Controller
{
    public function lookupView(Request $request, string $table)
    {
        $id = $request->get('id', null);
        $idField = $request->get('idField');
        $lookupField = $request->get('lookupField', 'meaning');
        $payload = json_decode($request->get('payload', '{}'), true);

        if ($id) {
            return $this->byId($table, $id, $idField, $lookupField);
        }

        $query = $request->get('q');
        return $this->searchQuery($table, $query, $idField, $lookupField, $payload);
    }

    private function byId($table, $id, $idField, $lookupField)
    {
        $class = "App\\Models\\PD\\Lookup\\$table";
        if (!class_exists($class)) {
            return response()->json([
                'class' => $class,
                'message' => 'lookup_table_not_exist',
            ], 400);
        }

        $row = $class::query()
            ->where($idField, $id)
            ->first();

        if (!$row) {
            return response()->json([
                'message' => "id $idField = '$id' not found in $class",
            ], 404);
        }

        return response([
            'key' => $row[$idField],
            'value' => $row[$lookupField],
            'row' => $row,
        ]);
    }

    private function searchQuery($table, $query, $idField, $lookupField, $payload = [])
    {
        $class = "App\\Models\\PD\\Lookup\\$table";
        if (!class_exists($class)) {
            return response()->json([
                'class' => $class,
                'message' => 'lookup_table_not_exist',
            ], 400);
        }

        $builder = $class::query();
        foreach ($payload as $field => $val) {
            $builder = $builder->where($field, $val);
        }

        if (trim($query) === '') {
            $rows = $builder
                ->take(20)
                ->get();
        } else {
            if (stripos($query, '%') === false) $query = "%$query%";
            $rows = $builder
                ->where($lookupField, 'like', $query)
                ->take(20)
                ->get();
        }

        $rows = $rows->map(function ($row) use ($idField, $lookupField, $query) {
            return [
                'key' => $row[$idField],
                'value' => $row[$lookupField],
                'row' => $row,
                //'query' => $query,
            ];
        });

        return response($rows);
    }
}
