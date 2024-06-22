<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function exportInvoice($id)
    {
        $inVoice=Invoice::find($id);
        $listInvoiceDetail=InvoiceDetail::where('invoice_id',$id)->get();
        $pdf = app('dompdf.wrapper')->loadView('pdf.invoice', ['inVoice'=>$inVoice],['listInvoiceDetail'=>$listInvoiceDetail]);
        return $pdf->stream('hoa-don.pdf');
    }
}
