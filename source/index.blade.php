@extends('_layouts.master')

@section('body')
    @foreach ($recipes->where('featured', true) as $featuredRecipe)
        <div class="w-full mb-6">
            @if ($featuredRecipe->cover_image)
                <img src="{{ $featuredRecipe->cover_image }}" alt="{{ $featuredRecipe->title }} cover image" class="mb-6">
            @endif

            <p class="text-gray-700 font-medium my-2">
                {{ $featuredRecipe->getDate()->format('F j, Y') }}
            </p>

            <h2 class="text-3xl mt-0">
                <a href="{{ $featuredRecipe->getUrl() }}" title="Read {{ $featuredRecipe->title }}" class="text-gray-900 font-extrabold">
                    {{ $featuredRecipe->title }}
                </a>
            </h2>

            <p class="mt-0 mb-4">{!! $featuredRecipe->getExcerpt() !!}</p>

            <a href="{{ $featuredRecipe->getUrl() }}" title="Read - {{ $featuredRecipe->title }}" class="uppercase tracking-wide mb-4">
                Read
            </a>
        </div>

        @if (! $loop->last)
            <hr class="border-b my-6">
        @endif
    @endforeach

    @foreach ($recipes->where('featured', false)->take(6)->chunk(2) as $row)
        <div class="flex flex-col md:flex-row md:-mx-6">
            @foreach ($row as $recipe)
                <div class="w-full md:w-1/2 md:mx-6">
                    @include('_components.recipe-preview-inline')
                </div>

                @if (! $loop->last)
                    <hr class="block md:hidden w-full border-b mt-2 mb-6">
                @endif
            @endforeach
        </div>

        @if (! $loop->last)
            <hr class="w-full border-b mt-2 mb-6">
        @endif
    @endforeach
@stop
