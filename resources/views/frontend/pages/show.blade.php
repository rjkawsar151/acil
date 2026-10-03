@extends('layouts.app')

@section('title', $page->meta_title ?: "{$page->title} | Adonis Chemical Limited")
@section('meta_description', $page->meta_description ?: $page->excerpt)

@section('content')

    <!-- Header Banner -->
    <section class="bg-navy-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-hexagon-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <span class="badge-scientific-dark">{{ $page->subtitle ?? 'Adonis Chemical Limited' }}</span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight">{{ $page->title }}</h1>
                @if($page->excerpt)
                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed">{{ $page->excerpt }}</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Page Body -->
    <section class="py-16 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed space-y-4">
                {!! $page->content !!}
            </div>
        </div>
    </section>

@endsection
