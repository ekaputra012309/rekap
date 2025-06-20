@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h2>Dashboard</h2>
    <div class="row mt-4">
      <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-bg-primary p-3">
          <h5>150</h5>
          <p>New Orders</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-bg-success p-3">
          <h5>53%</h5>
          <p>Bounce Rate</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-bg-warning p-3">
          <h5>200</h5>
          <p>New Messages</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-bg-danger p-3">
          <h5>50</h5>
          <p>Errors</p>
        </div>
      </div>
    </div>    
@endsection
