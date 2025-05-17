<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAtividadeComplementarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'descricao' => 'required|string',
            'nomeAtividadeComplementar' => 'required|string',
            'maximoSemestral' => 'required|integer',
            'idTipoAtividade' => 'required|exists:tipo_atividades,id',
        ];
    }
}

