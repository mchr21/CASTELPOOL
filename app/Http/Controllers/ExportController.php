<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;


class ExportController extends Controller
{
    public function reportPDF($userId, $reportType, $dateFrom = null, $dateTo = null)
    {
        $data = [];
        if ($reportType == 0) // ventas del dia
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00'; //desde esa hora del día
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59'; //hasta esa hora del mismo día

        } else {
            $from = Carbon::parse($dateFrom)->format('Y-m-d') . ' 00:00:00'; //el usuario selecciona desde esta fecha 
            $to = Carbon::parse($dateTo)->format('Y-m-d')     . ' 23:59:59'; //hasta esta fecha
        }

        if($userId == 0) // entonces es de todos los usuarios
        {
            $data = Sale::join('users as u','u.id','sales.user_id')
            ->select('sales.*','u.name as user')
            ->whereBetween('sales.created_at', [$from, $to])
            ->get();
        } else {
            $data = Sale::join('users as u','u.id','sales.user_id')
            ->select('sales.*','u.name as user')
            ->whereBetween('sales.created_at', [$from, $to])
            ->where('user_id', $userId)
            ->get();
        }

        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;
    $pdf = FacadePdf::loadView('pdf.reporte', compact('data','reportType','user','dateFrom','dateTo'));// 'pdf.reporte'en el directorio pdf se tendra un archivo llamado reporte-- estamos pasando la vista // y los parametros
   //$pdf una vez cargada de informacion el paquete FacadePdf nos da posibilidades una que podemos visualizar dentro del tab del navegador
   //o bien podemos generar una descarga de ese reporte
   //vamos a visualizar en el navegador 




/*
    $pdf = new DOMPDF();
    $pdf->setBasePath(realpath(APPLICATION_PATH . '/css/'));
    $pdf->loadHtml($html);
    $pdf->render();
    */
    /*
    $pdf->set_protocol(WWW_ROOT);
    $pdf->set_base_path('/');
*/

        return $pdf->stream('salesReport.pdf'); // visualizar
        //$customReportName = 'salesReport_'.Carbon::now()->format('Y-m-d').'.pdf';
        //return $pdf->download($customReportName); //descargar

    }


    // public function reporteExcel($userId, $reportType, $dateFrom =null, $dateTo =null)
    // {
    //     $reportName = 'Reporte de Ventas_' . uniqid() . '.xlsx';
        
    //     return Excel::download(new SalesExport($userId, $reportType, $dateFrom, $dateTo),$reportName );
    // }

}
