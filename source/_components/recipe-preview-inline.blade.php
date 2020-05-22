<div class="flex flex-col mb-4">
    <p class="text-gray-700 font-medium my-2">
        {{ $recipe->getDate()->format('F j, Y') }}
    </p>

    <h2 class="text-3xl mt-0">
        <a
            href="{{ $recipe->getUrl() }}"
            title="Read more - {{ $recipe->title }}"
            class="text-gray-900 font-extrabold"
        >{{ $recipe->title }}</a>
    </h2>

    <p class="mb-4 mt-0">{!! $recipe->getExcerpt(200) !!}</p>

    <a
        href="{{ $recipe->getUrl() }}"
        title="Read more - {{ $recipe->title }}"
        class="uppercase font-semibold tracking-wide mb-2"
    >Read</a>
</div>
