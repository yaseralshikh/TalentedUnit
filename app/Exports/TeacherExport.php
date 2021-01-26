<?php

namespace App\Exports;

use App\Teacher;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TeacherExport implements FromCollection , WithMapping , WithHeadings , ShouldAutoSize , WithEvents
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
        return Teacher::with('school','office')->when($this->request->office_id, function ($q) {

            return $q->where('office_id', $this->request->office_id);

        })->when($this->request->school_id, function ($q) {

            return $q->where('school_id', $this->request->school_id);

        })->when($this->request->search, function ($q) {

            return $q->where('name', 'like' , $this->request->search . '%')
                    ->orWhere('idcard', 'like', '%' . $this->request->search . '%')
                    ->orWhere('specialization', 'like', '%' . $this->request->search . '%')
                    ->orWhere('mobile', 'like', '%' . $this->request->search . '%')
                    ->orWhere('email', 'like', '%' . $this->request->search . '%');

        })->orderBy('name')->get();
    }

    public function map($teacher) : array {
        return [
            $teacher->id,
            $teacher->name,
            $teacher->idcard,
            $teacher->mobile,
            $teacher->email,
            $teacher->specialization,
            $teacher->office->name,
            $teacher->school->name,
            //Carbon::parse($student->created_at)->toFormattedDateString(),
            //Carbon::parse($student->updated_at)->toFormattedDateString()
        ] ;
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'idcard',
            'mobile',
            'email',
            'specialization',
            //'image',
            'office',
            'school',
            //'created_at',
            //'updated_at'
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
