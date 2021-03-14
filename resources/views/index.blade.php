@extends('layouts.app')

@section('content')
@include('partials.page-header')

@if (! have_posts())
<x-alert type="warning">
  {!! __('Sorry, no results were found.', 'webness') !!}
</x-alert>

{!! get_search_form(false) !!}
@endif

@while(have_posts()) @php(the_post())
@includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
@endwhile

<div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
  <div class="md:flex">
    <div class="md:flex-shrink-0">
      <img class="h-48 w-full object-cover md:w-48" src="/img/store.jpg" alt="Man looking at item at a store">
    </div>
    <div class="p-8">
      <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Case study</div>
      <a href="#" class="block mt-1 text-lg leading-tight font-medium text-black hover:underline">Finding customers for
        your new business</a>
      <p class="mt-2 text-gray-500">Getting a new business off the ground is a lot of hard work. Here are five ideas you
        can use to find your first customers.</p>
    </div>
  </div>
</div>

{!! get_the_posts_navigation() !!}

@endsection


@section('sidebar')
@include('partials.sidebar')
@endsection