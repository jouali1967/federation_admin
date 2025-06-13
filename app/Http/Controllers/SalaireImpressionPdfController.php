<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salaire;
use App\Pdf\ViremenetSalaire;
use Elibyy\TCPDF\Facades\TCPDF;

class SalaireImpressionPdfController extends Controller
{
  public function export(Request $request)
  {
    $mois = $request->input('mois');
    $annee = $request->input('annee');
    $salaires = Salaire::with('personne')
      ->whereMonth('date_virement', $mois)
      ->whereYear('date_virement', $annee)
      ->get();

    $pdf = new ViremenetSalaire($mois,$annee,$orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false);
    $pdf->SetMargins(10, 6, 10);
    $pdf->SetAutoPageBreak(true, 15);

    $pdf->AddPage('P');
    $pdf->SetY($pdf->getY()+12);
    $compt = 1;
    $tot_sb=0;
    $tot_pr=0;
    $tot_sa=0;
    $tot_sm=0;


    // Lignes du tableau avec centrage vertical
    $count_pers=count($salaires);
    $pdf->SetFont('helvetica', '', 8);
    foreach ($salaires as $salaire) {
      $pdf->setX(6);
      $pdf->MultiCell(60, 5, $salaire->personne->nom . ' ' . $salaire->personne->prenom, 1, 'L', 0, 0, null, null, true, 0, false, true, 0, 'M');
      $pdf->MultiCell(20, 5, $salaire->salaire_base, 1, 'R', 0, 0, null, null, true, 0, false, true, 5, 'M');
      $pdf->MultiCell(20, 5, $salaire->montant_prime, 1, 'R', 0, 0, null, null, true, 0, false, true, 5, 'M');
      $pdf->MultiCell(20, 5, $salaire->montant_sanction, 1, 'R', 0, 0, null, null, true, 0, false, true, 5, 'M');
      $pdf->MultiCell(20, 5, $salaire->montant_vire, 1, 'R', 0, 0, null, null, true, 0, false, true, 5, 'M');
      $pdf->MultiCell(40, 5, $salaire->personne->num_compte, 1, 'R', 0, 1, null, null, true, 0, false, true, 5, 'M');
      $tot_sb += $salaire->salaire_base;
      $tot_pr += $salaire->montant_prime;
      $tot_sa += $salaire->montant_sanction;
      $tot_sm += $salaire->montant_vire;
        $compt++;
        $count_pers=$count_pers-1;
        if ($pdf->GetY() + 10 > ($pdf->getPageHeight() - $pdf->getFooterMargin()) and $count_pers<5) {
            $pdf->AddPage();
        }

    }
    $pdf->setX(6);
    $pdf->MultiCell(60, 5, 'Total', 1, 'R', 0, 0, null, null, true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, number_format($tot_sb,2,'.',' '), 1, 'R', 0, 0, null, null, true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, number_format($tot_pr,2,'.',' '), 1, 'R', 0, 0, null, null, true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, number_format($tot_sa,2,'.',' '), 1, 'R', 0, 0, null, null, true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, number_format($tot_sm,2,'.',' '), 1, 'R', 0, 0, null, null, true, 0, false, true, 5, 'M');


    $pdf->Output('etat_salaires.pdf');
  }
}
