<?php

namespace App\Http\Controllers;

use App\Http\Model\Menus;
use Illuminate\Http\Request;

class MenusController extends Controller {

    private $request;

    public function __construct(Request $request) {
        $this->middleware('authentication');
        $this->request = $request;
    }

    public function create(Request $request) {
        $this->validate($request, Menus::rules());

        $identity = $this->getIdentity($request);

        $attributes = $request->all();
        $attributes['created_by'] = $identity->user_id;
        $model = Menus::create($attributes);

        $response = [
            'status' => 'success',
            'data' => $model,
            'token' => $this->getToken($request)
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function view($id) {
        $model = $this->findModel($id);
        $response = [
            'status' => 'success',
            'data' => $model,
            'token' => $this->getToken($this->request)
        ];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function update(Request $request, $id) {
        $model = $this->findModel($id);

        $this->validate($request, Menus::rules($id));

        $identity = $this->getIdentity($request);

        $attributes = $request->all();
        $attributes['updated_by'] = $identity['user_id'];
        $model->update($attributes);

        $response = [
            'status' => 'success',
            'data' => $model,
            'token' => $this->getToken($request)
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function delete($id) {
        $model = $this->findModel($id);
        $model->delete();

        $response = [
            'status' => 'success',
            'data' => $model,
            'message' => 'Removed successfully.',
            'token' => $this->getToken($this->request)
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function index() {
        $parent = Menus::where('parent', 0)->get();
        $models = Menus::search();

        foreach ($models['data'] as $key => $value) {
            if ($value['parent'] == 0) {
                $models['data'][$key]['parent_name'] = '-';
            }
            foreach ($parent as $keyParent => $valueParent) {
                if ($value['parent'] == $valueParent['id']) {
                    $models['data'][$key]['parent_name'] = $valueParent['name'];
                }
            }
        }
        $response = $models;
        $response['token'] = $this->getToken($this->request);
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function getParent() {
        $models = Menus::where('parent', 0)->get();

        $response = [
            'status' => 'success',
            'data' => $models
        ];
        $response['token'] = $this->getToken($this->request);

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function getMenu() {
        $identity = $this->getIdentity($this->request);

        $parent = Menus::getParentByRole($identity->user_id);
        $child = Menus::getChildByRole($identity->user_id);

        $menu = array();

        foreach ($parent as $value) {
            array_push($menu, array(
                "id" => $value->id,
                "name" => $value->name,
                "description" => $value->description,
                "link" => $value->link,
                "icon" => $value->icon,
                "order" => $value->order,
                "child" => array()
            ));
        }
        foreach ($menu as $key => $value) {
            foreach ($child as $valuechild) {
                if ($value['id'] == $valuechild->parent) {
                    array_push($menu[$key]['child'], array(
                        "id" => $valuechild->id,
                        "name" => $valuechild->name,
                        "description" => $valuechild->description,
                        "link" => $valuechild->link,
                        "icon" => $valuechild->icon,
                        "order" => $valuechild->order,
                    ));
                }
            }
        }

        $response = [
            'status' => 'success',
            'data' => $menu
        ];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function findModel($id) {

        $model = Menus::find($id);
        if (!$model) {
            $response = [
                'status' => 'errors',
                'message' => "Invalid Record"
            ];

            response()->json($response, 400, [], JSON_PRETTY_PRINT)->send();
            die;
        }
        return $model;
    }

}
