@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!<br>
                        <a href="{{url('user/addKey')}}">添加公钥</a>
                        <a href="{{url('user/decrypt')}}">解密数据</a>
                        <a href="{{url('user/sign')}}">在线验签</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
