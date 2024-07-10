<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class YearExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function collection()
    {
        return Invoice::where('status', 4)->selectRaw('MONTH(date) as month, SUM(total) as total')
            ->whereYear('date', $this->year)
            ->groupByRaw('MONTH(date)')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tháng',
            'Tổng doanh thu',
        ];
    }

    public function map($row): array
    {
        return [
            $row->month,
            $row->total,
        ];
    }
    public function columnFormats(): array
    {
        return [
            'B' => '#,##0',
        ];
    }
}
