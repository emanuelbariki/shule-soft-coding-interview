@extends('app')

@section('title', 'Dashboard')

@section('content')
    <h4>Welcome to the Dashboard</h4>
    <p>Select an option from the menu to proceed.</p>
@endsection

@push('scripts')
    <script>
        console.log('Dashboard loaded.');
    </script>
@endpush
