<x-layouts::app :title="__('Articles | Show')">

    <div class="max-w-3xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow-md">
        <div class="flex justify-between items-start mb-6 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $article->title }}</h1>
                <p class="text-sm text-gray-500">By {{ $article->user->name }} &middot; {{ $article->created_at->format('M d, Y') }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('articles.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-md transition shadow-sm border border-gray-200">Back</a>
                @can('article-edit')
                    <a href="{{ route('articles.edit', $article) }}" class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md shadow-sm transition">Edit</a>
                @endcan
            </div>
        </div>
        <div class="prose max-w-none text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $article->content }}</div>
    </div>

</x-layouts::app>
