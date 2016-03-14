<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\CampusTransformer;

use App\Campus;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $campuses = Campus::all();

        return $this->response->array($campuses, new CampusTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param    int    $id
     * @return Response
     */
    public function show($id)
    {
        $campus = Campus::findOrFail($id);

        return $this->response->item($campus, new CampusTransformer);
    }
}
