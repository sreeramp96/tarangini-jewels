@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">Categories</h2>
    </div>
    <x-table
        title="All Categories"
        :link="route('admin.categories.create')"
        linkText="Add Category"
        :pagination="$categories->links()">
        <x-slot name="header">
            <th class="py-4 px-4 font-medium text-black dark:text-white xl:pl-11">Image</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white">Name</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white">Slug</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white text-right">Actions</th>
        </x-slot>
        @foreach($categories as $category)
            <tr class="border-b border-stroke dark:border-strokedark hover:bg-gray-50 dark:hover:bg-meta-4">
                <td class="py-4 px-4 pl-9 xl:pl-11">
                    @if($category->image)
                        <img src="{{ Storage::url($category->image) }}" class="h-12 w-12 rounded object-cover">
                    @else
                        <div class="h-12 w-12 rounded bg-gray-200 flex items-center justify-center text-gray-500 text-xs">No Img</div>
                    @endif
                </td>
                <td class="py-4 px-4 text-black dark:text-white font-medium">{{ $category->name }}</td>
                <td class="py-4 px-4 text-sm text-body">{{ $category->slug }}</td>
                <td class="py-4 px-4">
                    <div class="flex items-center justify-end space-x-3.5">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="hover:text-primary"><x-bi-pencil class="w-5 h-5"/></a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="hover:text-danger"><x-bi-trash class="w-5 h-5"/></button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-table>
@endsection
