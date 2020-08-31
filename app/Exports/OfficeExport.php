<?php

namespace App\Exports;

use App\Office;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class OfficeExport implements FromCollection , WithHeadings, ShouldAutoSize , WithEvents
{
    protected $request;

    public function __construct(Request $request)
    {
       $this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Office::when($this->request->search , function ($q) {
            return $q->where('name', 'like', '%' . $this->request->search . '%');
        })->orderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'created_at',
            'updated_at'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray(
                    array(
                       'font'  => array(
                           'bold'  =>  true,
                       )
                    )
                  );
            },
        ];
    }
}
