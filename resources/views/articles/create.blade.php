<x-layouts::app :title="__('Articles | Create')">

    <div class="max-w-2xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Create Article</h1>
            <a href="{{ route('articles.index') }}" class="text-gray-600 hover:text-gray-900 underline text-sm transition">Back</a>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('articles.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea name="content" rows="8" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-y">{{ old('content') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none bg-white transition">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div class="pt-2 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200 shadow-sm">
                    Submit Article
                </button>
            </div>
        </form>
    </div>

</x-layouts::app>
