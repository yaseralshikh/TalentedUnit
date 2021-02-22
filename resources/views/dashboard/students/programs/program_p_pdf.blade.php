<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>

        <style type='text/css'>
            body,html {
                margin: 0;
                padding: 0;
                font-family:'cairo', sans-serif;
                font-style: Bold;
                font-weight: 400;
                /* background-image: url("../dashboard_files/images/bg.jpg");
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover; */
            }

            @font-face {
                font-family: 'cairo';
                src: url("../fonts/Cairo-Bold.ttf");
            }

            .background{
                position: fixed;
                left: 0px; 
                top: 0px; 
                z-index: -1;
                padding-right: 45px;
                padding-top: 10px;
            }

            .stretch {
                margin: auto;
                display: block;
                padding-top: 20px;
                padding-left: 50px;
                height:297mm;
                width: 210mm;
            }

            .container {
                border: 5px solid rgb(33, 90, 99);
                width: 100%;
                height: 100%;
                display: table-cell;
                vertical-align: middle;
                /* overflow: auto; */
            }

            .student {
                padding-right: 195px; 
                padding-top: 253px; 
                font-size: 20px;
                color: rgb(33, 90, 99);
            }

            .idcard {
                padding-right: 518px; 
                padding-top: -33px; 
                font-size: 20px;
                color: rgb(33, 90, 99);
            }
            .program {
                padding-right: 290px; 
                padding-top: 0px; 
                font-size: 25px;
                color: rgb(33, 90, 99);
            }
            .program_date {
                padding-right: 238px; 
                padding-top: 5px; 
                font-size: 16px;
                color: rgb(33, 90, 99);
            }
        </style>
    </head>
    <body>
        <div class="background">
            <img src="{{ asset('dashboard_files/images/PR_BG_A4_P.png') }}" class="stretch" alt="" />
        </div>
        <div class="container">
            <div class="student">
                {{ $student->name }}
            </div>
            <div class="idcard">
                {{ $student->idcard }}
            </div>
            <div class="program">
                {{ $program->name }}
            </div>
            <div class="program_date">
                {{ \Carbon\Carbon::parse($student_program->program_date)->format('Y') }}هـ
            </div>
        </div>
    </body>
</html>