<?php
namespace App\Exports;

use App\Models\Vente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VentesExport implements FromCollection, WithHeadings
{
    protected $poleId;

    public function __construct($poleId = null)
    {
        $this->poleId = $poleId;
    }

    public function collection()
    {
        $query = Vente::with('pole');

        if ($this->poleId) {
            $query->where('pole_id', $this->poleId);
        }

        return $query->orderBy('date', 'desc')->get()->map(function ($vente) {
            return [
                'Date' => $vente->date,
                'Pôle' => $vente->pole->nom,
                'Montant (€)' => $vente->montant,
                'Coût (€)' => $vente->cout,
                'Bénéfice (€)' => $vente->benefice,
            ];
        });
    }

    public function headings(): array
    {
        return ['Date', 'Pôle', 'Montant (€)', 'Coût (€)', 'Bénéfice (€)'];
    }
}