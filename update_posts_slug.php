<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Post;
use Illuminate\Support\Str;

$posts = Post::all();

foreach ($posts as $post) {
    if (empty($post->slug)) {
        $post->slug = Str::slug($post->title);
        $post->save();
        echo "Updated post #{$post->id}: {$post->title} -> {$post->slug}\n";
    }
}

echo "\nTotal posts updated: " . $posts->count() . "\n";
