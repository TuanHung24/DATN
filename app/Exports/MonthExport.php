<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class MonthExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $year;
    protected $month;

    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function collection()
    {
        return Invoice::where('status', 4)
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->selectRaw('DATE(date) as day, SUM(total) as total')
            ->groupByRaw('DATE(date)')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Ngày',
            'Doanh thu',
        ];
    }

    public function map($invoice): array
    {


        return [
            \Carbon\Carbon::parse($invoice->day)->format('d/m/Y'),
            $invoice->total,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => '#,##0',
        ];
    }
}
