@extends('admin.layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Categories</h1>
        <a href="{{ route('categories.create') }}" class="px-6 py-2 rounded text-gray font-medium btn-gold glow-hover">
            Add New Category
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Slug</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                {{-- Loop through the categories --}}
                @forelse($categories as $category)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $category->name }}</td>
                        <td class="px-6 py-4">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:underline">Edit</a>
                            {{-- Add a delete form --}}
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block ml-4"
                                onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
