<?php

namespace App\Http\Controllers;

use App\Models\VatModel;
use Illuminate\Http\Request;

class VatModelController extends Controller
{

    public function index()
    {
       return VatModel::all();
    }
}
