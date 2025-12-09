@props(['title' => 'Table Title', 'link' => null, 'linkText' => 'Add New', 'pagination' => null])

<div
    class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
    <div class="mb-6 flex justify-between items-center">
        <h4 class="text-xl font-semibold text-black dark:text-white">
            {{ $title }}
        </h4>

        @if($link)
            <a href="{{ $link }}"
                class="inline-flex items-center justify-center gap-2.5 rounded-md bg-primary py-4 px-10 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10 btn-gold glow-hover">
                <span><x-bi-plus class="w-6 h-6" /></span>
                {{ $linkText }}
            </a>
        @endif
    </div>

    <div class="max-w-full overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-2 text-left dark:bg-meta-4">
                    {{ $header }}
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if($pagination)
        <div class="py-4">
            @if(is_object($pagination) && method_exists($pagination, 'links'))
                {!! $pagination->links() !!}
            @else
                {!! $pagination !!}
            @endif
        </div>
    @endif
</div>
