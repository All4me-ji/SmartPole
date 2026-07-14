<?php
namespace App\Http\Controllers;

use App\Models\Pole;
use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VentesExport;

class RapportController extends Controller
{
    public function index()
    {
        $poles = Pole::all();
        return view('rapports.index', compact('poles'));
    }

    public function genererPdf(string $poleId = null)
    {
        $query = Vente::with('pole');

        if ($poleId) {
            $query->where('pole_id', $poleId);
        }

        $ventes = $query->orderBy('date', 'desc')->get();
        $totalVentes = $ventes->sum('montant');
        $totalBenefices = $ventes->sum('benefice');

        $pdf = Pdf::loadView('rapports.pdf', compact('ventes', 'totalVentes', 'totalBenefices'));

        return $pdf->download('rapport_ventes.pdf');
    }

    public function genererExcel(string $poleId = null)
    {
        return Excel::download(new VentesExport($poleId), 'rapport_ventes.xlsx');
    }
}
