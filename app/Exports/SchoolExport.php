<?php

namespace App\Exports;

use App\School;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SchoolExport implements FromCollection , WithMapping , WithHeadings , ShouldAutoSize , WithEvents
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
        return School::with('office')->when($this->request->office_id, function ($q) {

            return $q->where('office_id', $this->request->office_id);

        })->when($this->request->stage, function ($q) {

            return $q->where('stage', $this->request->stage);

        })->when($this->request->search, function ($q) {

            return $q->where('name', 'like' , '%' . $this->request->search . '%')
                     ->orWhere('moe_id', 'like', '%' . $this->request->search . '%')
                     ->orWhere('manager', 'like', '%' .$this->request->search . '%')
                     ->orWhere('mobile', 'like', '%' . $this->request->search . '%')
                     ->orWhere('email', 'like', '%' . $this->request->search . '%');

        })->orderBy('name')->get();
    }

    public function map($school) : array {
        return [
            $school->id,
            $school->name,
            $school->office->name,
            $school->moe_id,
            $school->stage,
            $school->manager,
            $school->mobile,
            $school->email
        ] ;
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'office',
            'moe_id',
            'stage',
            'manager',
            'mobile',
            'email'
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
