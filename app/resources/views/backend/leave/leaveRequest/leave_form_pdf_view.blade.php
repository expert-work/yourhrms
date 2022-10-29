<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leave Form</title>
    <style>
        .logo {
            width: 100px;
            height: auto;
        }

        .leaveFormBodyTitle {
            width: 100%;
            background: #ddd;
            padding: 10px;
            text-align: center;
        }

        .label-name {
            float: left;
            width: 30%;
        }

        .lavel-value {
            float: left;
            width: 70%;
        }

        .lavel-title {
            padding: 5px;
        }

        .right-under-line {
            border-bottom: 1px solid black;
            padding: 5px;
        }

        .flex {
            display: inline;
        }

        .margin-top-40 {
            margin-top: 40px;
        }

        .margin-top-20 {
            margin-top: 20px;
        }

        .float-right {
            float: right;
        }

        .sig {
            float: left;
            width: 45%;
            border-top: 1px solid #222;
            margin-top: 30px;
            padding: 10px
        }

        .date {
            float: right;
            width: 45%;
            border-top: 1px solid #222;
            padding: 10px
        }

        .margin-top {
            margin-top: 40px;
        }
        .text-center{
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="leaveForm">
        <div class="leaveFormHeader">
            {{-- <img src="https://sookhbucket.s3.ap-southeast-1.amazonaws.com/special/2021/Nov/17/2021-11-17-ofwtrngi71oh-Sookh_dark_mode-%281%29.webp"
                alt="" class="logo">  --}}
                <img src="{{ uploaded_asset(config('settings.app.company_logo_frontend')) }}"
                alt="" class="logo">
            <p>Leave Application Form </p>
        </div>
        <div class="leaveFormBody">
            <div class="leaveFormBodyTitle">
                Leave Information
            </div>
            <table style="width:100%">
                <tr>
                    <td class="label-name">Employee Name</td>
                    <td class="lavel-value right-under-line"> {{@$data->user->name}}</td>
                </tr>
                <tr>
                    <td class="label-name">Employee ID No.</td>
                    <td class="lavel-value right-under-line">{{@$data->user->employee_id}}</td>
                </tr>
                <tr>
                    <td class="label-name">Department</td>
                    <td class="lavel-value right-under-line"> {{@$data->user->department->title}}</td>
                </tr>
                <tr>
                    <td class="label-name">Manager/Team Lead</td>
                    <td class="lavel-value right-under-line"> {{@$data->user->manager->name}}</td>
                </tr>
            </table>

            <h4>Type of Absence Request</h4>
            <input type="radio" checked>
            <label for="age1">{{@$data->assignLeave->type->name}}</label><br>
            <div>
                <h4>Date of Absence</h4>
                <table style="width:100%">
                    <tr>
                        <td class="label-name">From</td>
                        <td class="lavel-value right-under-line">{{showDate(@$data->leave_from)}}</td>
                
                        <td class="label-name text-center">To</td>
                        <td class="lavel-value right-under-line"> {{showDate(@$data->leave_to)}}</td>
                    </tr>
                </table>
       
            </div>

            <h4>Reason for Absence</h4>
            <div>
                <p style="padding: 10px; border :1px solid #ddd; color:#222; text-align:justify">{{@$data->reason}}</p>
               
            </div>

           
            <div class=" " style="margin-bottom:15px">
                <div class="sig">
                    Employee Signature
                </div>
                <div class="date">
                    Date
                </div>
            </div>
           <br>
           <br>
           <br>

            <div class="leaveFormBodyTitle" style="margin-top: 10px">
                Manager Approval
            </div>

            <div class="margin-top-20">
                <input type="checkbox" checked>
                <label for="vehicle1" class="margin-top">{{@$data->status->name}}</label><br>
            </div>

            <h4>Comments</h4>
            <p style="padding: 10px; border :1px solid rgb(243, 242, 242); color:#222; text-align:justify">
                {{@$data->reason}}
            </p>

            <div class="row">
                <div class="sig">
                    Manager Signature
                </div>
                <div class="date">
                    Date
                </div>
            </div>

        </div>
    </div>
    </div>

</body>

</html>
