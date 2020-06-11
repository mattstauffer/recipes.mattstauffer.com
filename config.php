<?php

use App\Contentful\ContentfulCollection;
use Illuminate\Support\Str;

return [
    'baseUrl' => 'http://matt-cooking.test',
    'production' => false,
    'siteName' => "Matt's Recipes",
    'siteDescription' => 'Recipes from Matt Stauffer',
    'siteAuthor' => 'Matt Stauffer',

    // collections
    'collections' => [
        'recipes' => [
            'author' => 'Matt Stauffer', // Default author, if not provided in a recipe
            'sort' => '-date',
            'path' => 'recipes/{filename}',
            'section' => 'content',
            'extends' => '_layouts.recipe',
            'items' => function ($config) {
                return  (new ContentfulCollection)->getPosts();
            },
        ],
        'categories' => [
            'path' => '/recipes/categories/{filename}',
            'recipes' => function ($page, $allRecipes) {
                return $allRecipes->filter(function ($recipe) use ($page) {
                    return $recipe->categories ? in_array($page->getFilename(), $recipe->categories, true) : false;
                });
            },
        ],
    ],

    // helpers
    'getDate' => function ($page) {
        dd($page->date);
        return Datetime::createFromFormat('Y-m-d', $page->date);
    },
    'getExcerpt' => function ($page, $length = 255) {
        if ($page->excerpt) {
            return $page->excerpt;
        }

        $content = preg_split('/<!-- more -->/m', $page->getContent(), 2);
        $cleaned = trim(
            strip_tags(
                preg_replace(['/<pre>[\w\W]*?<\/pre>/', '/<h\d>[\w\W]*?<\/h\d>/'], '', $content[0]),
                '<code>'
            )
        );

        if (count($content) > 1) {
            return $content[0];
        }

        $truncated = substr($cleaned, 0, $length);

        if (substr_count($truncated, '<code>') > substr_count($truncated, '</code>')) {
            $truncated .= '</code>';
        }

        return strlen($cleaned) > $length
            ? preg_replace('/\s+?(\S+)?$/', '', $truncated) . '...'
            : $cleaned;
    },
    'isActive' => function ($page, $path) {
        return Str::endsWith(trimPath($page->getPath()), trimPath($path));
    },
];
