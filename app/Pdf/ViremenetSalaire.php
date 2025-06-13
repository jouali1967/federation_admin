<?php

namespace App\Pdf;

use TCPDF;

class ViremenetSalaire extends TCPDF
{
  protected $mois;
  protected $annee;

    // Constructor to receive the data
  public function __construct($mois, $annee, $orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false)
  {
    parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache);
    $this->mois = $mois; // String 'dd/mm/YYYY'
    $this->annee = $annee;
  }

  // Header personnalisé
  public function Header()
  {
    if ($this->getPage() === 1) {
      $this->SetFont('helvetica', '', 10);
      $this->setX(6);
      $this->Cell(0, 8, 'Période : ' . str_pad($this->mois, 2, '0', STR_PAD_LEFT) . '/' . $this->annee, 0, 1, 'L');
      $this->SetLineWidth(1); // Définir l'épaisseur de la ligne
      $this->line(6, $this->GetY(), 180, $this->GetY());
      $this->SetLineWidth(0.2); // Réinitialiser l'épaisseur de la ligne pour les autres éléments
      $this->ln(2);
      $this->setX(6);

      // En-tête du tableau avec fond de couleur et centrage vertical
      $this->SetFont('helvetica', 'B', 8);
      $this->SetFillColor(220, 220, 220); // gris clair
      $this->MultiCell(60, 8, "Nom et Prénom", 1, 'C', 1, 0, null, null, true, 0, false, true, 8, 'M');
      $this->MultiCell(20, 8, "Salaire de\nBase", 1, 'C', 1, 0, null, null, true, 0, false, true, 8, 'M');
      $this->MultiCell(20, 8, "Montant\nPrimes", 1, 'C', 1, 0, null, null, true, 0, false, true, 8, 'M');
      $this->MultiCell(20, 8, "Montant\nSanctions", 1, 'C', 1, 0, null, null, true, 0, false, true, 8, 'M');
      $this->MultiCell(20, 8, "Salaire\nMensuel", 1, 'C', 1, 0, null, null, true, 0, false, true, 8, 'M');
      $this->MultiCell(40, 8, "N° Compte", 1, 'C', 1, 1, null, null, true, 0, false, true, 8, 'M');
      $this->ln();
    }
  }

  // Footer personnalisé
  public function Footer()
  {
    $this->setY(-19);
    $this->setFontSize(9);
    $this->cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
  }
}
