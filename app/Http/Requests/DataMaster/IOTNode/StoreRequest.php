<?php

namespace App\Http\Requests\DataMaster\IOTNode;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'serial_number'           => 'required|unique:i_o_t_nodes',
            'edge_computing_id'       => 'required',
            'edge_computing_node'     => 'required|numeric|min:1',
            'region_id'               => 'required',
            'city_id'                 => 'required',
            'picture'                 => 'nullable|mimes:jpeg,jpg,png', //1MB
        ];
    }
}
