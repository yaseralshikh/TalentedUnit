<?php

namespace App\Exports;

use App\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class StudentExport implements FromCollection , WithHeadings , ShouldAutoSize , WithEvents
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
        return Student::when($this->request->office_idt, function ($q) {

            return $q->where('office_id', $this->request->office_id);

        })->when($this->request->stage, function ($q) {

            return $q->where('stage', $this->request->stage);

        })->when($this->request->school_id, function ($q) {

            return $q->where('school_id', $this->request->school_id);

        })->when($this->request->class, function ($q) {

            return $q->where('class', $this->request->class);

        })->when($this->request->teacher_id, function ($q) {

            return $q->where('teacher_id', $this->request->teacher_id);

        })->when($this->request->search, function ($q) {

            return $q->where('name', 'like' , '%' . $this->request->search . '%')
                     ->orWhere('idcard',$this->request->search)
                     ->orWhere('mobile', $this->request->search)
                     ->orWhere('email', 'like', '%' . $this->request->search . '%');

        })->orderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'idcard',
            'mobile',
            'email',
            'stage',
            'class',
            'degree',
            'office_id',
            'school_id',
            'teacher_id',
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
