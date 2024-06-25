@extends('dashboard.layout') 

@section('title',__('Dashboard'))

@section('page_css')

@endsection
@section('middle_content')
 
@include('dashboard.dashboard') {{-- Include sidebar file --}} 

@section('page_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js" integrity="sha512-d6nObkPJgV791iTGuBoVC9Aa2iecqzJRE0Jiqvk85BhLHAPhWqkuBiQb1xz2jvuHNqHLYoN3ymPfpiB1o+Zgpw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
<script src="{{ URL::asset('resources/js/pages/dashboard/dashboard.js?v=3')}}"></script>               
@endsection
@endsection

