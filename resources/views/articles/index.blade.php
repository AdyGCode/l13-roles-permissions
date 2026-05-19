<x-layouts::app :title="__('Dashboard')">

<div class="max-w-7xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Articles</h1>
        <div class="flex items-center space-x-4">
            @can('create articles')
                <a href="{{ route('articles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200 shadow-sm">
                    Create Article
                </a>
            @endcan
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-gray-600 hover:text-gray-900 text-sm underline transition">Logout ({{ auth()->user()->name }})</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 shadow-sm rounded-lg overflow-hidden">
            <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @forelse($articles as $article)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $articles->firstItem() + $loop->index }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $article->title }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $article->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($article->status) }}
                            </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('articles.show', $article) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 rounded-md text-xs text-white uppercase hover:bg-blue-700 transition shadow-sm">View</a>
                        @can('edit articles')
                            <a href="{{ route('articles.edit', $article) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-500 rounded-md text-xs text-white uppercase hover:bg-amber-600 transition shadow-sm">Edit</a>
                        @endcan
                        @can('delete articles')
                            <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline-block m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="inline-flex items-center px-3 py-1.5 bg-red-600 rounded-md text-xs text-white uppercase hover:bg-red-700 transition shadow-sm">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No articles found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $articles->links() }}
    </div>
</div>
</x-layouts::app>
