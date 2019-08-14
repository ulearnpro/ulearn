@extends('layouts.email')
@section('subject')
{{ env('APP_NAME') }} - Enquiry for Instructor
@endsection

@section('content')
        Dear Instructor,<br/>
        <p>We would like to inform you that a user has requested a enquiry.  The enquiry details are:</p>
        <p>
        Full Name: {{ $enquiry->full_name }}<br/>
        Email ID : {{ $enquiry->email_id }}<br/>
        Message :{{ $enquiry->message }}<br/>
        </p>
@endsection
