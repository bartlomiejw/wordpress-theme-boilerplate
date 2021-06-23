@extends('layouts.app')

@section('content')
@include('partials.hero')
@include('partials.page-header')

<section class="text-gray-600 body-font overflow-hidden">
  <div class="container mx-auto">
    <div class="flex flex-wrap">
      @if (! have_posts())
      <x-alert type="warning">
        {!! __('Sorry, no results were found.', 'grupaww') !!}
      </x-alert>

      {!! get_search_form(false) !!}
      @endif

      @while(have_posts()) @php(the_post())
      @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
      @endwhile
    </div>
  </div>
</section>


{!! get_the_posts_navigation() !!}

@endsection


@section('sidebar')
@include('partials.sidebar')
@endsection