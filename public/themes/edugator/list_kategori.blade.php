@extends('layouts.theme')

@section('content')

    <form action="" id="form-search">
        <!-- Search bar -->
        {{-- <section class="px-6 lg:px-36 bg-neutral-500">
            
        </section> --}}

        <!--  Program Bisnis  -->
        <section class="px-6 lg:px-36 pb-16 lg:pb-28 pt-10 lg:pt-16">
            <div class="container mx-auto">
                <div class="text-center mb-10">
                    <h3 class="text-xl lg:text-3xl font-semibold text-neutral-500 mb-1 lg:mb-2">
                        List Kategori
                    </h3>
                    {{-- <p class="text-sm lg:text-base font-normal text-neutral-400" id="totalData">
                    </p> --}}
                </div>
                <div class="block md:flex items-center justify-between mb-4 lg:mb-8">
                    
                    <button type="button"
                        class="flex items-center justify-center text-sm lg:text-base font-normal text-neutral-500 py-2.5 px-6 bg-white border border-neutral-300 rounded-lg w-full md:w-auto"
                        data-drawer-target="drawer-left-example" data-drawer-show="drawer-left-example"
                        data-drawer-placement="left" aria-controls="drawer-left-example">
                        <span class="material-icons-outlined mr-2">
                            filter_list
                        </span>
                        Filter
                    </button>

                    <select name="category" id="category"
                        class="cursor-pointer text-sm lg:text-base font-normal text-neutral-500 py-2.5 px-6 bg-white border border-neutral-300 rounded-lg w-full md:w-44 mb-3 md:mb-0">
                        <option value="">All</option>
                        <option value="Populer">Populer</option>
                        {{-- <option value="Terbaru">Terbaru</option> --}}
                    </select>

                </div>
                <div class="relative">
                    <div class="programs13list">
                    </div>
                    <div class="absolute -left-[10px] lg:-left-[22px] top-1/4 lg:top-2/4 -translate-y-2/4 pb-5">
                        <div
                            class="prev-program-bisnis cursor-pointer hidden w-6 h-16 rounded-[100px] bg-brand-500 text-white md:flex items-center justify-center">
                            <span class="material-icons-outlined text-18">
                                arrow_back
                            </span>
                        </div>
                    </div>
                    <div class="absolute -right-[10px] lg:-right-[22px] top-1/4 lg:top-2/4 -translate-y-2/4 pb-5">
                        <div
                            class="next-program-bisnis cursor-pointer hidden w-6 h-16 rounded-[100px] bg-brand-500 text-white md:flex items-center justify-center">
                            <span class="material-icons-outlined text-18">
                                arrow_forward
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Drawer Filter -->
        <div id="drawer-left-example" class="fixed z-40 h-screen p-4 overflow-y-auto bg-white w-80" tabindex="-1"
            aria-labelledby="drawer-left-label">
            <form action="">
                <div class="border-b-2 border-neutral-100 py-[3px] mb-6">
                    <h6 class="text-base font-semibold text-neutral-400">
                        Filter Kategori
                    </h6>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-500 mb-4">
                        Program Bisnis
                    </p>
                    @php
                        $category = \App\Category::where('slug', '!=', 'developer')->where('step', 2)->get()->toArray();
                    @endphp
                    @foreach ($category as $item)
                        <div class="flex items-center mb-4">
                            <input type="checkbox" id="{{ $item['slug'] }}" name="program" value="{{ $item['slug'] }}"
                                class="border border-neutral-200 rounded checked:text-brand-500 checked:border checked:border-brand-500 checked:ring-0 focus:ring-0 cursor-pointer w-4 h-4 m-0">
                            <label for="{{ $item['slug'] }}" class="text-sm font-normal text-neutral-500 cursor-pointer ml-2.5">
                                Program {{$item['category_name']}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    </form>

@endsection
