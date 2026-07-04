@extends('layouts.app')

@section('title', 'Unsubscribed')

@section('content')
    <section class="container-site py-16 md:py-20">
        <div class="mx-auto max-w-lg rounded-2xl border border-gray-200 bg-white p-8 text-center shadow-sm">
            <h1 class="text-2xl font-semibold text-gray-900">You have been unsubscribed</h1>
            <p class="mt-3 text-sm leading-relaxed text-gray-600">
                You will no longer receive newsletter emails from {{ config('app.name') }}.
            </p>
            <a href="{{ route('home') }}" class="btn-solid mt-6 inline-flex">Back to homepage</a>
        </div>
    </section>
@endsection
