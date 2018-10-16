
@extends('layouts.admin_template')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <center><h2><strong>Wellcome</strong></h2></center>      
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Start managing your contents</strong>
            </div>
            <div class="card-body" align="center">
                <table>
                    <tr>
                        <td width="55%">
                            <h2>User :</h2>   
                        </td>
                        <td>
                            <h2><strong>{{ Auth::user()->_full_name }}</strong></h2>    
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h2>Last Login :</h2>    
                        </td>
                        <td>
                            <h2><strong>{{ \Carbon\Carbon::parse(Auth::user()->_last_login_at)->format('d M Y h:m:s')}}</strong></h2>    
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h2>Password Expired :</h2>    
                        </td>
                        <td>
                            <h2><strong>15 Sept 2018 21:01;03</strong></h2>    
                        </td>
                    </tr>                                        
                </table>
            </div>
        </div>
    </div>
</div>
@endsection