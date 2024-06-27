
@extends('frontend.default.layouts.layout') 
    @if ($page_name == 'course_page'):
        @php $title = get_course_by_id($course_id)->row_array() @endphp
        @section('title', $title['subject_name'] . ' | ' . setting()->company_name)

    @else
        @section('title',ucwords($page_title) . ' | ' . setting()->company_name)
    @endif

@section('page_css')

@endsection
@section('middle_content')
 

@section('page_js')
          
@endsection
@endsection
