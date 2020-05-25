<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medida;

class MedidaController extends Controller
{
  public function atualizarMedida(Request $req)
  {
    $medida_id = $req->get('id');
    $medida = Medida::findOrFail($medida_id);
    $medida->medida = $req->get('medida');
    $medida->save();
    return redirect()->route('admin.cadastros')->with('status', 'Medida atualizada com sucesso!');
  }

  public function deletarMedida()
  {
      $medida_id = $_GET['id'];
      $medida = Medida::find($medida_id);
      $medida->delete();
      return redirect()->back()->with('status', 'Medida deletada com sucesso!');
  }
}
