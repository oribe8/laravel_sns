<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- ↓編集ここから↓ -->
            新規投稿
            <!-- ↑編集ここまで↑ -->
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- ↓編集ここから↓ -->
                    @if(session('message'))
                        <p>{{ session('message') }}</p>
                    @endif
                    <!-- ↓テンプレート↓ -->
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-5 mx-auto">
                            <div class="flex flex-wrap -m-2">
                                <form method="post" action="{{ route('sns.store') }}" enctype="multipart/form-data">
                                @csrf
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="message" class="leading-7 text-sm text-gray-600">投稿文</label>
                                            <x-input-error :messages="$errors->get('post_text')" />
                                            <textarea id="message" name="post_text" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{old('post_text')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="postimageId" class="leading-7 text-sm text-gray-600">画像</label>
                                            <x-input-error :messages="$errors->get('post_blob')" />
                                            <input type="file" id="postimageId" name="post_blob" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" value="{{old('post_blob')}}">
                                        </div>
                                    </div>
                                    <div class="p-2 w-full">
                                        <input type="submit" value="送信" class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                    <!-- ↑テンプレート↑ -->
                    
                    <!-- ↑編集ここまで↑ -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>